<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @ignore
 */
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Automaatne lukustamine - Seaded',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Aktiveeri automaatne lukustamine',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Lukusta automaatselt teadaanded',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Lukusta automaatselt kleebised',
	'ACP_AUTO_LOCK_POLLS'			=> 'Lukusta automaatselt hääletused',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Lukusta automaatselt hääletused viimase postituse ajast.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Lukusta automaatselt postituse aja järgi',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Lukustatakse viimase postituse aja järgi.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Sagedus automaatseks lukustamiseks',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Päevade arv automaatse lukustamise sündmuseks.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Automaatselt lukustatud teemad</strong><br />» %s'
]);
