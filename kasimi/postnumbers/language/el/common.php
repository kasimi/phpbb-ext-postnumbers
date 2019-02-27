<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * Ελληνική μετάφραση [el]
 *
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
	'POSTNUMBERS_COPY_TITLE'		=> 'Αντιγραφή συνδέσμου δημοσίευσης στο πρόχειρο',
	'POSTNUMBERS_COPY_MANUALLY'		=> 'Αντιγραφή στο πρόχειρο: Ctrl/Cmd+C, Enter',
	'POSTNUMBERS_COPIED'			=> 'Αντιγράφηκε!',
]);
