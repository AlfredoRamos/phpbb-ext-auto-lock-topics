<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@skiff.com>
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
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Nastavení automatického zamykání',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Povolit automatické zamykání',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Zamykat oznámení',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Zamykat témata označená jako důležitá',
	'ACP_AUTO_LOCK_POLLS'			=> 'Zamykat ankety',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Zamykat témata s anketami, ve kterých nikdo nehlasoval déle než nastavený počet dní.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Zamykat příspěvky starší než',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Počet dní od posledního příspěvku v tématu.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Frekvence automatického zamykání',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Interval kontroly a zamykání starých příspěvků.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Automatické zamknutí témat</strong><br>» %s'
]);
