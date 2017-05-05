<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GNU GPL-3.0+
 */

namespace alfredoramos\autolocktopics\tests\event;

use phpbb_test_case;
use alfredoramos\autolocktopics\event\listener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener_test extends phpbb_test_case {

	protected $request;

	public function setUp() {
		parent::setUp();

		$this->request = $this->getMock('\phpbb\request\request');
	}

	public function test_instance() {
		$this->assertInstanceOf(
			EventSubscriberInterface::class,
			new listener($this->request)
		);
	}

	public function test_suscribed_events() {
		$this->assertSame(
			[
				'core.user_setup',
				'core.acp_manage_forums_request_data',
				'core.acp_manage_forums_display_form'
			],
			array_keys(listener::getSubscribedEvents())
		);
	}
}
