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

	public function test_instance() {
		$this->assertInstanceOf(
			EventSubscriberInterface::class,
			new listener
		);
	}

	public function test_suscribed_events() {
		$this->assertSame(
			['core.user_setup'],
			array_keys(listener::getSubscribedEvents())
		);
	}
}
