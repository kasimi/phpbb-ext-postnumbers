<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2015 kasimi
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
	'POSTNUMBERS_COPY_TITLE'		=> 'Copy post link to clipboard',
	'POSTNUMBERS_COPY_MANUALLY'		=> 'Copy to clipboard: Ctrl/Cmd+C, Enter',
	'POSTNUMBERS_COPIED'			=> 'Copied!',
));
