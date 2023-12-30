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
	'LOG_AUTO_LOCK_TOPIC'	=> '<strong>Verrouillage automatique des sujets</strong><br>» %s'
]);
