<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GNU GPL-3.0+
 */

namespace alfredoramos\autolocktopics\includes;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class helper {
	protected $container;
	protected $db;
	
	public function __construct(Container $container) {
		$this->container = $container;
		$this->db = $this->container->get('dbal.conn');
	}
	
	public function forum_data($options = []) {
		$options = array_merge([
			'forum_id'			=> -1,
			'auto_lock_next'	=> 0
		], $options);
		
		$options['forum_id'] = (int) $options['forum_id'];
		$options['auto_lock_next'] = (int) $options['auto_lock_next'];
		
		$sql = 'SELECT forum_id, forum_name, enable_auto_lock, auto_lock_flags, auto_lock_next, auto_lock_days, auto_lock_frequency
				FROM ' . FORUMS_TABLE . '
				WHERE enable_auto_lock = 1';

		if ($options['forum_id'] > 0) {
			$sql .= ' AND forum_id = ' . $options['forum_id'];
		}
		
		if ($options['auto_lock_next'] > 0) {
			$sql .= ' AND auto_lock_next < ' . $options['auto_lock_next'];
		}
		
		$result = $this->db->sql_query($sql);
		$forum_data = [];
		
		if ($options['forum_id'] > 0) {
			$forum_data = $this->db->sql_fetchrow($result);
		} else {
			$forum_data = $this->db->sql_fetchrowset($result);
		}
		
		$this->db->sql_freeresult($result);
		
		return $forum_data;
	}
	
	public function lock_topics($forum_id = -1, $flags = 0, $lock_date = 0) {
		$forum_id = (int) $forum_id;
		
		if ($forum_id < 1) {
			return;
		}
		
		$data = ['topic_status'	=> ITEM_LOCKED];
		$type = [];
		
		if (!(bool) ($flags & FORUM_FLAG_PRUNE_ANNOUNCE)) {
			$type[] = POST_ANNOUNCE;
			$type[] = POST_GLOBAL;
		}
		
		if (!(bool) ($flags & FORUM_FLAG_PRUNE_STICKY)) {
			$type[] = POST_STICKY;
		}
		
		$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . '
				WHERE ' . $this->db->sql_in_set('forum_id', [$forum_id]) . '
				AND topic_status = ' . ITEM_UNLOCKED;
		
		if (!empty($type)) {
			$sql .= ' AND ' . $this->db->sql_in_set('topic_type', $type, true);
		}
		
		// Start
		// Enclosure the condition to check
		// whether is a poll or a normal post
		$sql .= ' AND (';
		$sql .= '(
					poll_start = 0
					AND topic_last_post_time < ' . $lock_date . '
				)';
		
		if ((bool) ($flags & FORUM_FLAG_PRUNE_POLL)) {
			$sql .= 'OR (
				poll_start > 0
				AND poll_last_vote < ' . $lock_date . '
			)';
		}
		
		// End
		$sql .= ')';
		
		$this->db->sql_query($sql);
				
	}
	
	public function update_next_lock_date($forum_id = -1, $next_lock = 0) {
		$forum_id = (int) $forum_id;
		$data = ['auto_lock_next' => (int) $next_lock];
		
		$sql = 'UPDATE ' . FORUMS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . '
				WHERE forum_id = ' . $forum_id;
		
		$this->db->sql_query($sql);
	}
}
