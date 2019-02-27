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
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Show post numbers when viewing topics',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Show post numbers in topic review when composing a reply',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Show post numbers in MCP topic review',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Skip non-approved posts',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Do not assign post numbers to unapproved and soft-deleted posts',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Display post IDs instead of post numbers',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'If enabled, the above setting <span style="font-style: italic;">Skip non-approved posts</span> is ignored',
	'POSTNUMBERS_LOCATION'					=> 'Location of post numbers',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Before post image and post author name',
	'POSTNUMBERS_LOCATION_BEFORE_SUBJECT'	=> 'Add before post subject',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'Replace post subject',
	'POSTNUMBERS_CLIPBOARD'					=> 'Copy post link to clipboard when clicking on post number',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Only relevant if post numbers are displayed before post image and post author name. Only works in modern browsers, at least: Chrome 43, Firefox 41, IE 9, Opera 29, Safari 10. Unsupported browsers display a prompt containing the post link instead.',
	'POSTNUMBERS_BOLD'						=> 'Make post numbers/IDs bold',
	'POSTNUMBERS_BOLD_EXP'					=> 'Only relevant if post numbers are displayed before post image and post author name.',
]);
