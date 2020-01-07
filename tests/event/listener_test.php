<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\autolocktopics\tests\event;

use phpbb_test_case;
use alfredoramos\autolocktopics\event\listener;
use alfredoramos\autolocktopics\includes\helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @group event
 */
class listener_test extends phpbb_test_case
{
	/** @var \alfredoramos\autolocktopics\includes\helper */
	protected $helper;

	public function setUp(): void
	{
		parent::setUp();

		$this->helper = $this->getMockBuilder(helper::class)
			->disableOriginalConstructor()->getMock();
	}

	public function test_instance()
	{
		$this->assertInstanceOf(
			EventSubscriberInterface::class,
			new listener($this->helper)
		);
	}

	public function test_subscribed_events()
	{
		$this->assertSame(
			[
				'core.acp_manage_forums_request_data',
				'core.acp_manage_forums_initialise_data',
				'core.acp_manage_forums_display_form'
			],
			array_keys(listener::getSubscribedEvents())
		);
	}
}
