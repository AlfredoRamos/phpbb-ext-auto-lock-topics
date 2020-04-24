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
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Preferencias del cierre automático',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Habilitar cierre automático',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Cierre automático de anuncios',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Cierre automático de notas',
	'ACP_AUTO_LOCK_POLLS'			=> 'Cierre automático de encuestas',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Cierra encuestas no votadas después de la vigencia especificada.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Vigencia de temas',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Número de días que se mantendrá el tema sin mensajes nuevos antes del cierre automático.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Frecuencia del cierre automático',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Tiempo en días transcurrido entre los cierres automáticos de temas.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Topics auto-locked</strong><br>» %s'
]);
