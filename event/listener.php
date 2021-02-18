<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\autolocktopics\event;

use alfredoramos\autolocktopics\includes\helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var helper */
	protected $helper;

	/**
	 * Event listener constructor.
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
	 * Assign functions defined in this class to event listeners in the core.
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_request_data'		=> 'manage_forums_request_data',
			'core.acp_manage_forums_initialise_data'	=> 'manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'		=> 'manage_forums_display_form'
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
		// Update forum data
		$event['forum_data'] = array_merge(
			$this->helper->form_forum_data(),
			$event['forum_data']
		);
	}

	/**
	 * Add initial forum data.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function manage_forums_initialise_data($event)
	{
		if (!in_array($event['action'], ['add', 'edit']))
		{
			return;
		}

		// Update forum data
		$event['forum_data'] = array_merge(
			$this->helper->form_forum_data(),
			$event['forum_data']
		);
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
