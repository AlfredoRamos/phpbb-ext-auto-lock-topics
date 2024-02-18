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
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Configurações do Auto-trancar',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Ativar auto-trancar',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Auto-trancar anúncio',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Auto-trancar fixos',
	'ACP_AUTO_LOCK_POLLS'			=> 'Auto-trancar enquetes',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Trancar tópicos com enquetes não votadas baseadas na idade do post em dias.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Auto-trancar post por idade',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Número de dias desde o último post.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Frequência do Auto-trancar',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Tempo em dias entre os eventos do Auto-trancar.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Tópicos trancados automaticamente</strong><br>» %s'
]);
