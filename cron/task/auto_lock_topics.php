<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GNU GPL-2.0
 */

namespace alfredoramos\autolocktopics\cron\task;

use alfredoramos\autolocktopics\includes\helper as auto_lock_helper;
use phpbb\cron\task\base as task_base;
use phpbb\user;
use phpbb\language\language;
use phpbb\log\log;

class auto_lock_topics extends task_base {
	
	protected $auto_lock_helper;
	protected $lang;
	protected $log;
	
	public function __construct(auto_lock_helper $auto_lock_helper, user $user, language $lang, log $log) {
		$this->auto_lock_helper = $auto_lock_helper;
		$this->user = $user;
		$this->lang = $lang;
		$this->log = $log;
	}
	
	public function run() {
		$forums = $this->auto_lock_helper->forum_data([
			'auto_lock_next' => time()
		]);
		
		if (empty($forums)) {
			return;
		}
		
		foreach ($forums as $forum) {
			// Cast values
			$forum['forum_id'] = (int) $forum['forum_id'];
			$forum['auto_lock_flags'] = (int) $forum['auto_lock_flags'];
			$forum['auto_lock_days'] = (int) $forum['auto_lock_days'];
			$forum['auto_lock_frequency'] = (int) $forum['auto_lock_frequency'];
			
			$this->auto_lock_helper->lock_topics(
				$forum['forum_id'],
				$forum['auto_lock_flags'],
				(time() - ($forum['auto_lock_days'] * (24 * 60 * 60)))
			);
			
			$this->auto_lock_helper->update_next_lock_date(
				$forum['forum_id'],
				(time() + ($forum['auto_lock_frequency'] * (24 * 60 * 60)))
			);
			
			$this->log->add(
				'admin',
				$this->user->data['user_id'],
				$this->user->ip,
				'LOG_AUTO_LOCK_TOPIC',
				time(),
				[$forum['forum_id'], $forum['forum_name']]
			);
		}
	}
	
	public function is_runnable() {
		return true;
	}
	
}
