<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 * Translated By : Bassel Taha Alhitary - www.alhitary.net
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
	'POSTNUMBERS_TITLE'						=> 'أرقام المُشاركات',
	'POSTNUMBERS_CONFIG'					=> 'الإعدادات',
	'POSTNUMBERS_CONFIG_UPDATED'			=> 'الإضافة : <strong>أرقام المُشاركات </strong><br />» تم تحديث الإعدادات',
]);
