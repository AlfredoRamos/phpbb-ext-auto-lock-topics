<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\autolocktopics\event;

use phpbb\request\request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	/** @var \phpbb\request\request */
	protected $request;

	/**
	 * Event listener constructor.
	 *
	 * @param \phpbb\request\request $request
	 *
	 * @return void
	 */
	public function __construct(request $request)
	{
		$this->request = $request;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core.
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_request_data' => 'manage_forums_request_data',
			'core.acp_manage_forums_display_form' => 'manage_forums_display_form'
		];
	}

	/**
	 * Request and update forum data.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function manage_forums_request_data($event)
	{
		// Set auto-lock flags
		$auto_lock_flags = 0;

		// Announcements auto-lock is enabled
		if ($this->request->variable('auto_lock_announcements', 0))
		{
			$auto_lock_flags += FORUM_FLAG_PRUNE_ANNOUNCE;
		}

		// Stickies auto-lock is enabled
		if ($this->request->variable('auto_lock_stickies', 0))
		{
			$auto_lock_flags += FORUM_FLAG_PRUNE_STICKY;
		}

		// Polls auto-lock is enabled
		if ($this->request->variable('auto_lock_polls', 0))
		{
			$auto_lock_flags += FORUM_FLAG_PRUNE_POLL;
		}

		// Update forum data
		$event['forum_data'] = array_merge([
			'enable_auto_lock' => $this->request->variable('enable_auto_lock', 0),
			'auto_lock_flags' => $auto_lock_flags,
			'auto_lock_days' => $this->request->variable('auto_lock_days', 90),
			'auto_lock_freq' => $this->request->variable('auto_lock_freq', 7)
		], $event['forum_data']);
	}

	/**
	 * Assign and update template variables.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function manage_forums_display_form($event)
	{
		// Assign template variables
		$event['template_data'] = array_merge([
			'AUTO_LOCK_TOPICS_ENABLED' => (int) $event['forum_data']['enable_auto_lock'],
			'AUTO_LOCK_ANNOUNCEMENTS' => (
				(int) $event['forum_data']['auto_lock_flags'] & FORUM_FLAG_PRUNE_ANNOUNCE
			),
			'AUTO_LOCK_STICKIES' => (
				(int) $event['forum_data']['auto_lock_flags'] & FORUM_FLAG_PRUNE_STICKY
			),
			'AUTO_LOCK_POLLS' => (
				(int) $event['forum_data']['auto_lock_flags'] & FORUM_FLAG_PRUNE_POLL
			),
			'AUTO_LOCK_DAYS' => (int) $event['forum_data']['auto_lock_days'],
			'AUTO_LOCK_FREQ' => (int) $event['forum_data']['auto_lock_freq']
		], $event['template_data']);
	}

}
