<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'POSTNUMBERS_TITLE'						=> 'Numeração das Mensagens',
	'POSTNUMBERS_CONFIG'					=> 'Configuração',
	'POSTNUMBERS_CONFIG_UPDATED'			=> 'Extensão <strong>Numeração das Mensagens</strong> <br />» Configuração guardada',
]);
