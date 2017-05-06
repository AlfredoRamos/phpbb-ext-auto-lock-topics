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
use phpbb\log\log;

class auto_lock_topics extends task_base
{

	/** @var \alfredoramos\autolocktopics\includes\helper $auto_lock_helper */
	protected $auto_lock_helper;

	/** @var \phpbb\user $user */
	protected $user;

	/** @var \phpbb\log\log $log */
	protected $log;

	/**
	 * Cron task constructor.
	 *
	 * @param \alfredoramos\autolocktopics\includes\helper	$helper
	 * @param \phpbb\user									$user
	 * @param \phpbb\log\log								$log
	 *
	 * @return void
	 */
	public function __construct(auto_lock_helper $auto_lock_helper, user $user, log $log)
	{
		$this->auto_lock_helper = $auto_lock_helper;
		$this->user = $user;
		$this->log = $log;
	}

	/**
	 * Execute the cron task.
	 *
	 * @return void
	 */
	public function run()
	{
		// Check if it should run
		$forums = $this->auto_lock_helper->forum_data([
			'auto_lock_next' => time()
		]);

		// It there's no forums that need to
		// lock its topics, stop execution
		if (empty($forums))
		{
			return;
		}

		// Iterate over each forum to lock its topics
		foreach ($forums as $forum)
		{
			// Cast values
			$forum['forum_id'] = (int) $forum['forum_id'];
			$forum['auto_lock_flags'] = (int) $forum['auto_lock_flags'];
			$forum['auto_lock_days'] = (int) $forum['auto_lock_days'];
			$forum['auto_lock_frequency'] = (int) $forum['auto_lock_frequency'];

			// Lock the topics
			$this->auto_lock_helper->lock_topics(
				$forum['forum_id'],
				$forum['auto_lock_flags'],
				(time() - ($forum['auto_lock_days'] * (24 * 60 * 60)))
			);

			// Update the next lock date
			$this->auto_lock_helper->update_next_lock_date(
				$forum['forum_id'],
				(time() + ($forum['auto_lock_frequency'] * (24 * 60 * 60)))
			);

			// Add an entry in the admin log
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

	/**
	 * Check if the cron task can be executed
	 */
	public function is_runnable()
	{
		return true;
	}

}
