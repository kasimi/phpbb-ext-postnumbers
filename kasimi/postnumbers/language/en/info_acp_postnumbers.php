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
	'POSTNUMBERS_TITLE'						=> 'Post Numbers',
	'POSTNUMBERS_CONFIG'					=> 'Configuration',
	'POSTNUMBERS_CONFIG_UPDATED'			=> '<strong>Post Numbers </strong>Extension<br />» Configuration updated',
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Show post numbers when viewing topics',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Show post numbers in topic review when composing a reply',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Show post numbers in MCP topic review',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Skip non-approved posts',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Do not assign post numbers to unapproved and soft-deleted posts',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Display post IDs instead of post numbers',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'If enabled, the above setting <span style="font-style: italic;">Skip non-approved posts</span> is ignored',
	'POSTNUMBERS_BOLD'						=> 'Make post numbers/IDs bold',
));
