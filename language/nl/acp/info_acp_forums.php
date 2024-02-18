<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@proton.me>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB')) {
	exit;
}

/**
 * @ignore
 */
if (empty($lang) || !is_array($lang)) {
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Auto sluiten instellingen',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Auto sluiten inschakelen',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Auto sluit mededelingen',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Auto sluit peilingen',
	'ACP_AUTO_LOCK_POLLS'			=> 'Auto sluit polls',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Sluit onderwerpen met peilingen die niet zijn goedgekeurd voor na de leeftijd.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Auto sluit post leeftijd',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Aantal dagen sinds het laatste bericht.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Auto sluit frequentie',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Tijd in dagen tussen automatische sluit gebeurtenissen.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Onderwerpen automatisch gesloten</strong><br>» %s'
]);
