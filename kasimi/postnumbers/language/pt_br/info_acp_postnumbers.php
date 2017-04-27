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
	$lang = array();
}

$lang = array_merge($lang, array(
	'POSTNUMBERS_TITLE'						=> 'Numeração de Mensagens',
	'POSTNUMBERS_CONFIG'					=> 'Configuração',
	'POSTNUMBERS_CONFIG_UPDATED'			=> 'Extensão <strong>Numeração de Mensagens </strong><br />» Configuração salva',
));
