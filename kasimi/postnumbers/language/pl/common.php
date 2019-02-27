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
	'POSTNUMBERS_COPY_TITLE'		=> 'Kopiuj link posta do schowka',
	'POSTNUMBERS_COPY_MANUALLY'		=> 'Kopiuj do schowka: Ctrl/Cmd+C, Enter',
	'POSTNUMBERS_COPIED'			=> 'Skopiowano link!',
]);
