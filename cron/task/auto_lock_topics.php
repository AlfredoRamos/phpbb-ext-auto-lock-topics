<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@skiff.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\autolocktopics\cron\task;

use alfredoramos\autolocktopics\includes\helper;
use phpbb\cron\task\base as task_base;

class auto_lock_topics extends task_base
{
	/** @var helper */
	protected $helper;

	/**
	 * Cron task constructor.
	 *
	 * @param helper $helper
	 *
	 * @return void
	 */
	public function __construct(helper $helper)
	{
		$this->helper = $helper;
	}

	/**
	 * Execute the cron task.
	 *
	 * @return void
	 */
	public function run()
	{
		// Check if it should run
		$forums = $this->helper->forum_data(['limit' => 150]);

		// Stop execution if there's no forums to lock
		if (empty($forums))
		{
			return;
		}

		// Iterate over each forum to lock its topics
		foreach ($forums as $forum)
		{
			$this->helper->auto_lock($forum, 300);
		}
	}
}
