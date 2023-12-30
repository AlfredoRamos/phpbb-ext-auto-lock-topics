<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@skiff.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\autolocktopics\tests\functional;

/**
 * @group functional
 */
class autolocktopics_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return ['alfredoramos/autolocktopics'];
	}

	protected function acp_form_test($uri = '')
	{
		if (empty($uri)) {
			$this->markTestIncomplete('The URI cannot be empty');
			return;
		}

		$this->login();
		$this->admin_login();

		// Append SID
		$uri = vsprintf('%1$s&sid=%2$s', [$uri, $this->sid]);

		$crawler = self::request('GET', $uri);
		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();

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

	public function test_acp_edit_forum_form()
	{
		$this->acp_form_test(
			'adm/index.php?i=acp_forums&f=2&mode=manage&action=edit'
		);
	}

	public function test_acp_add_forum_form()
	{
		$this->acp_form_test(
			'adm/index.php?i=acp_forums&mode=manage&action=add'
		);
	}
}
