<?php

/**
 * Auto-lock Topics extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@protonmail.com>
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
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Oto-kilit ayarları',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Oto-kiliti aç',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Duyuruları Oto-kilitle',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Sabit konuları Oto-kilitle',
	'ACP_AUTO_LOCK_POLLS'			=> 'Anketleri Oto-kilitle',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Oy kullanılmamış anketli konuları belirtilen gönderi yaşına göre kilitler.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Oto-kilit gönderi yaşı',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Son gönderiden sonraki geçen gün sayısı.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Oto-kilit sıklığı',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Oto-kilit olayları arasındaki gün sayısı.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Konu oto-kilitlendi</strong><br>» %s'
]);
