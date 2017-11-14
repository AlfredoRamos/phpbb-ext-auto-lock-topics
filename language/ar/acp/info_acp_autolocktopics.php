<?php

/**
 * Auto-lock Topics Extension for phpBB.
 * @author Bassel Taha Alhitary <http://www.alhitary.net>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0
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
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'إعدادات الإغلاق التلقائي للمواضيع',
	'ACP_ENABLE_AUTO_LOCK'			=> 'تفعيل ',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'الإعلانات ',
	'ACP_AUTO_LOCK_STICKIES'		=> 'المواضيع المُثبتة ',
	'ACP_AUTO_LOCK_POLLS'			=> 'التصويتات ',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'سيتم إغلاق الموضوع مُنذ آخر تصويت وليس مُنذ آخر مُشاركة.',
	'ACP_AUTO_LOCK_DAYS'			=> 'الزمن ',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'سيتم إغلاق الموضوع بعد عدد الأيام التي تحددها هُنا بحيث تبدأ عملية العد مُنذ آخر مُشاركة.',
	'ACP_AUTO_LOCK_FREQ'		=> 'فترات الإغلاق التلقائي ',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'عدد الأيام لتشغيل الإغلاق التلقائي بين كل عملية وأخرى.',

	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>إغلاق الموضوع تلقائياً</strong><br />» %s'
]);
