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

		$this->assertEquals(1, $crawler->filter(
			'#forumedit #forum_auto_lock_options'
		)->count());
		$this->assertEquals(0, $form->get('enable_auto_lock')->getValue());
		$this->assertEquals(0, $form->get('auto_lock_announcements')->getValue());
		$this->assertEquals(0, $form->get('auto_lock_stickies')->getValue());
		$this->assertEquals(0, $form->get('auto_lock_polls')->getValue());
		$this->assertEquals(90, $form->get('auto_lock_days')->getValue());
		$this->assertEquals(7, $form->get('auto_lock_freq')->getValue());
	}
}
