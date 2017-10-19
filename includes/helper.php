<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0
 */

namespace alfredoramos\autolocktopics\includes;

use phpbb\db\driver\factory as database;

class helper
{

	/** @var \phpbb\db\driver\factory $db */
	protected $db;

	/**
	 * Constructor of the helper class.
	 *
	 * @param \phpbb\db\driver\factory	$db
	 *
	 * @return void
	 */
	public function __construct(database $db)
	{
		$this->db = $db;
	}


	/**
	 * Forum data used in the cron task.
	 *
	 * @param array	$options
	 *
	 * @return array
	 */
	public function forum_data($options = [])
	{
		// Merge default options with given options
		$options = array_merge([
			'forum_id'			=> 0,
			'auto_lock_next'	=> 0
		], $options);

		// Cast option values
		$options['forum_id'] = (int) $options['forum_id'];
		$options['auto_lock_next'] = (int) $options['auto_lock_next'];

		// At least one of the two options must be given
		if ($options['forum_id'] <= 0 && $options['auto_lock_next'] <= 0)
		{
			return [];
		}

		$sql = 'SELECT forum_id, forum_name, enable_auto_lock, auto_lock_flags, auto_lock_next, auto_lock_days, auto_lock_freq
			FROM ' . FORUMS_TABLE . '
			WHERE enable_auto_lock = 1';

		// Get a specific row
		if ($options['forum_id'] > 0)
		{
			$sql .= ' AND forum_id = ' . $options['forum_id'];
		}

		// Get rows older than the given date
		if ($options['auto_lock_next'] > 0)
		{
			$sql .= ' AND auto_lock_next < ' . $options['auto_lock_next'];
		}

		$result = $this->db->sql_query($sql);

		// Check if the just one row was requested,
		// otherwise return an array of forums
		if ($options['forum_id'] > 0)
		{
			$forum_data = $this->db->sql_fetchrow($result);
		}
		else
		{
			$forum_data = $this->db->sql_fetchrowset($result);
		}

		$this->db->sql_freeresult($result);

		return $forum_data;
	}


	/**
	 * Lock all topics by forum ID.
	 *
	 * @param integer	$forum_id
	 * @param integer	$flags
	 * @param integer	$lock_date
	 *
	 * @return bool
	 */
	public function lock_topics($forum_id = 0, $flags = 0, $lock_date = 0)
	{
		// Cast parameters
		$forum_id = (int) $forum_id;
		$flags = (int) $flags;
		$lock_date = (int) $lock_date;

		// Invalid forum ID
		if ($forum_id <= 0)
		{
			return false;
		}

		// New topic data
		$data = ['topic_status'	=> ITEM_LOCKED];

		// It will contain the topic types (announcement or sticky)
		// unless those options have been enabled
		$type = [];

		// Check if announcements auto-lock is enabled
		if (!(bool) ($flags & FORUM_FLAG_PRUNE_ANNOUNCE))
		{
			$type[] = POST_ANNOUNCE;
			$type[] = POST_GLOBAL;
		}

		// Check if stickies auto-lock is enabled
		if (!(bool) ($flags & FORUM_FLAG_PRUNE_STICKY))
		{
			$type[] = POST_STICKY;
		}

		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $data) . '
			WHERE ' . $this->db->sql_in_set('forum_id', [$forum_id]) . '
			AND topic_status = ' . ITEM_UNLOCKED;

		// If announcements or stickies auto-lock were disabled
		// ignore them in the SQL query
		if (!empty($type))
		{
			$sql .= ' AND ' . $this->db->sql_in_set('topic_type', $type, true);
		}

		// Start
		// Wrap the condition to check
		// whether is a poll or a normal post
		$sql .= ' AND ((poll_start = 0
			AND topic_last_post_time < ' . $lock_date . ')';

		// Check if polls auto-lock is enabled
		if ((bool) ($flags & FORUM_FLAG_PRUNE_POLL))
		{
			$sql .= ' OR (poll_start > 0
				AND poll_last_vote < ' . $lock_date . ')';
		}
		// End
		// Wrap ends here
		$sql .= ')';

		$this->db->sql_query($sql);

		return ((int) $this->db->sql_affectedrows() > 0);
	}

	/**
	 * Update the next lock date in the forum table.
	 *
	 * @param integer	$forum_id
	 * @param integer	$next_lock
	 *
	 * @return void
	 */
	public function update_next_lock_date($forum_id = 0, $next_lock = 0)
	{
		// Cast parameters
		$forum_id = (int) $forum_id;
		$next_lock = (int) $next_lock;

		// Forum ID must exist and next lock
		// date must be in the future
		if ($forum_id <= 0 || $next_lock <= time())
		{
			return;
		}

		// New forum data
		$data = ['auto_lock_next' => $next_lock];

		$sql = 'UPDATE ' . FORUMS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $data) . '
			WHERE forum_id = ' . $forum_id;

		$this->db->sql_query($sql);
	}

}
