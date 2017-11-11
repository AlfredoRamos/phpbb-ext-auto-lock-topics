<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0
 */

namespace alfredoramos\autolocktopics\tests\functional;

use phpbb_functional_test_case;

/**
 * @group functional
 */
class auto_lock_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return ['alfredoramos/autolocktopics'];
	}

	public function test_acp_form()
	{
		$this->login();
		$this->admin_login();

		$crawler = self::request('GET', sprintf(
			'adm/index.php?i=acp_forums&f=2&mode=manage&action=edit&sid=%s',
			$this->sid
		));
		$form = $crawler->selectButton('Submit')->form();

		$this->assertSame(1, $crawler->filter(
			'#forumedit #forum_auto_lock_options'
		)->count());

		$this->assertTrue($form->has('enable_auto_lock'));
		$this->assertSame(0, (int) $form->get('enable_auto_lock')->getValue());

		$this->assertTrue($form->has('auto_lock_announcements'));
		$this->assertSame(0, (int) $form->get('auto_lock_announcements')->getValue());

		$this->assertTrue($form->has('auto_lock_stickies'));
		$this->assertSame(0, (int) $form->get('auto_lock_stickies')->getValue());

		$this->assertTrue($form->has('auto_lock_polls'));
		$this->assertSame(0, (int) $form->get('auto_lock_polls')->getValue());

		$this->assertTrue($form->has('auto_lock_days'));
		$this->assertSame(90, (int) $form->get('auto_lock_days')->getValue());

		$this->assertTrue($form->has('auto_lock_freq'));
		$this->assertSame(7, (int) $form->get('auto_lock_freq')->getValue());
	}
}
