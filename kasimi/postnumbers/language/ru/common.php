<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * Russian translation by SouthKlad (http://southklad.ru/)
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
	'POSTNUMBERS_COPY_TITLE'		=> 'Копировать ссылку  на сообщение в буфер обмена',
	'POSTNUMBERS_COPY_MANUALLY'		=> 'Копировать в буфер обмена: Ctrl/Cmd+C, Enter',
	'POSTNUMBERS_COPIED'			=> 'Скопировано!',
]);
