<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\autolocktopics\includes;

use phpbb\db\driver\factory as database;
use phpbb\log\log;
use phpbb\user;
use phpbb\event\dispatcher_interface as dispatcher;

class helper
{

	/** @var \phpbb\db\driver\factory */
	protected $db;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/**
	 * Constructor of the helper class.
	 *
	 * @param \phpbb\db\driver\factory			$db
	 * @param \phpbb\log\log					$log
	 * @param \phpbb\user						$user
	 * @param \phpbb\event\dispatcher_interface	$dispatcher
	 *
	 * @return void
	 */
	public function __construct(database $db, log $log, user $user, dispatcher $dispatcher)
	{
		$this->db = $db;
		$this->log = $log;
		$this->user = $user;
		$this->dispatcher = $dispatcher;
	}


	/**
	 * Forum data used in the cron task.
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function forum_data($options = [])
	{
		// Merge default options with given options
		$options = array_merge([
			'forum_id'			=> 0,
			'auto_lock_next'	=> time(),
			'limit'				=> 0
		], $options);

		// Cast option values
		$options['forum_id'] = (int) $options['forum_id'];
		$options['auto_lock_next'] = (int) $options['auto_lock_next'];
		$options['limit'] = (int) $options['limit'];

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

		$result = $this->db->sql_query_limit($sql, $options['limit']);
		$forum = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $forum;
	}

	/**
	 * Auto-lock topics given forum data.
	 *
	 * @param array		$forum
	 * @param integer	$limit
	 *
	 * @return void
	 */
	public function auto_lock($forum = [], $limit = 0)
	{
		if (empty($forum))
		{
			return;
		}

		// Cast values
		$forum['forum_id'] = (int) $forum['forum_id'];
		$forum['auto_lock_flags'] = (int) $forum['auto_lock_flags'];
		$forum['auto_lock_days'] = (int) $forum['auto_lock_days'];
		$forum['auto_lock_freq'] = (int) $forum['auto_lock_freq'];
		$limit = (int) $limit;

		// Seconds in a day
		$day = 24 * 60 * 60;

		// Lock the topics
		$locked = $this->lock_topics(
			$forum['forum_id'],
			$forum['auto_lock_flags'],
			(time() - ($forum['auto_lock_days'] * $day)),
			$limit
		);

		// Update the next lock date
		$this->update_next_lock_date(
			$forum['forum_id'],
			(time() + ($forum['auto_lock_freq'] * $day))
		);

		if ($locked)
		{
			// Add an entry in the admin log
			$this->log->add(
				'admin',
				$this->user->data['user_id'],
				$this->user->ip,
				'LOG_AUTO_LOCK_TOPIC',
				false,
				[$forum['forum_name']]
			);
		}
	}

	/**
	 * Lock all topics by forum ID.
	 *
	 * @param integer $forum_id
	 * @param integer $flags
	 * @param integer $lock_date
	 * @param integer $limit
	 *
	 * @return bool
	 */
	protected function lock_topics($forum_id = 0, $flags = 0, $lock_date = 0, $limit = 0)
	{
		// Cast parameters
		$forum_id = (int) $forum_id;
		$flags = (int) $flags;
		$lock_date = (int) $lock_date;
		$limit = (int) $limit;

		// Invalid forum ID
		if ($forum_id <= 0)
		{
			return false;
		}

		// Topic types to ignore in the SQL query
		$ignore = [];

		// Check if announcements auto-lock is disabled
		if (!($flags & FORUM_FLAG_PRUNE_ANNOUNCE))
		{
			$ignore[] = POST_ANNOUNCE;
			$ignore[] = POST_GLOBAL;
		}

		// Check if stickies auto-lock is disabled
		if (!($flags & FORUM_FLAG_PRUNE_STICKY))
		{
			$ignore[] = POST_STICKY;
		}

		// SQL condition
		$sql_where = 'forum_id = ' . $forum_id . '
			AND topic_status = ' . ITEM_UNLOCKED;

		// Check if is announcements or stickies auto-lock is disabled
		if (!empty($ignore))
		{
			$sql_where .= ' AND ' . $this->db->sql_in_set('topic_type', $ignore, true);
		}

		// Wrap:start
		// Check if is a normal topic
		$sql_where .= ' AND ((poll_start = 0
			AND topic_last_post_time < ' . $lock_date . ')';

		// Check if is a poll and polls auto-lock is enabled
		if ($flags & FORUM_FLAG_PRUNE_POLL)
		{
			$sql_where .= ' OR (poll_start > 0
				AND poll_last_vote < ' . $lock_date . ')';
		}

		// Wrap:end
		$sql_where .= ')';

		// Cache SELECT query for 12 hours
		$cache_time = 12 * 60 * 60;

		// Get topic list
		$sql_select = 'SELECT topic_id
			FROM ' . TOPICS_TABLE . '
			WHERE ' . $sql_where;
		$result = $this->db->sql_query_limit($sql_select, $limit, 0, $cache_time);
		$topics = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		$topic_ids = [];

		// Get topic ID list
		foreach ($topics as $topic)
		{
			$topic_ids[] = (int) $topic['topic_id'];
		}

		// There was no topic to lock
		if (empty($topic_ids))
		{
			return false;
		}

		// Lock topics
		$sql_update = 'UPDATE ' . TOPICS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', ['topic_status' => ITEM_LOCKED]) . '
			WHERE ' . $sql_where . '
			AND ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$this->db->sql_query($sql_update);

		/**
		 * Manipulate topics after they have been locked.
		 *
		 * @event alfredoramos.autolocktopics.topics_locked_after
		 *
		 * @var integer	forum_id	The forum ID where the topics belong to.
		 * @var array	topic_ids	List of topic IDs that were auto-locked.
		 *
		 * @since 1.1.0
		 */
		$vars = ['forum_id', 'topic_ids'];
		extract($this->dispatcher->trigger_event('alfredoramos.autolocktopics.topics_locked_after', compact($vars)));

		return ((int) $this->db->sql_affectedrows() > 0);
	}

	/**
	 * Update the next lock date in the forum table.
	 *
	 * @param integer $forum_id
	 * @param integer $next_lock
	 *
	 * @return void
	 */
	protected function update_next_lock_date($forum_id = 0, $next_lock = 0)
	{
		// Cast parameters
		$forum_id = (int) $forum_id;
		$next_lock = (int) $next_lock;

		// Forum ID must exist and next lock date
		// must be in the future
		if ($forum_id <= 0 || $next_lock <= time())
		{
			return;
		}

		$sql = 'UPDATE ' . FORUMS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', ['auto_lock_next' => $next_lock]) . '
			WHERE forum_id = ' . $forum_id;

		$this->db->sql_query($sql);
	}

}
