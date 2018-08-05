<?php
/**
 *
 * Auto-lock Topics. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2018 Alfredo Ramos <alfredo.ramos@yandex.com>
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_FORUM_AUTO_LOCK_SETTINGS'	=> 'Paramètres du verrouillage automatique',
	'ACP_ENABLE_AUTO_LOCK'			=> 'Activer le verrouillage automatique',
	'ACP_AUTO_LOCK_ANNOUNCEMENTS'	=> 'Activer le verrouillage automatique des annonces',
	'ACP_AUTO_LOCK_STICKIES'		=> 'Activer le verrouillage automatique des sujets épinglés',
	'ACP_AUTO_LOCK_POLLS'			=> 'Activer le verrouillage automatique des sondages',
	'ACP_AUTO_LOCK_POLLS_EXPLAIN'	=> 'Permet de verrouiller les sujets contenant un sondage dont aucun vote n’a été effectué depuis le nombre de jours défini ci-dessous.',
	'ACP_AUTO_LOCK_DAYS'			=> 'Activer le verrouillage automatique après un nombre de jours',
	'ACP_AUTO_LOCK_DAYS_EXPLAIN'	=> 'Permet de saisir le nombre de jours suivant le dernier message et après lequel le verrouillage s’effectuera.',
	'ACP_AUTO_LOCK_FREQ'		=> 'Fréquence du verrouillage automatique',
	'ACP_AUTO_LOCK_FREQ_EXPLAIN' => 'Permet de saisir l’intervalle de temps en nombre en jours entre lesquels un verrouillage automatique s’efectuera.',

	// %s => Forum name
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Verrouillage automatique des sujets</strong><br />» %s'
]);
