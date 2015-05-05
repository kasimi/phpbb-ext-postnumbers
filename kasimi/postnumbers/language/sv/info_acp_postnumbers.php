<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2015 kasimi
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * Swedish translation by Holger (http://www.maskinisten.net)
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
	'POSTNUMBERS_TITLE'						=> 'Inläggsnummer',
	'POSTNUMBERS_CONFIG'					=> 'Inställningar',
	'POSTNUMBERS_CONFIG_UPDATED'			=> '<strong>Inläggsnummer </strong>tillägg<br />» Inställningarna har sparats',
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Visa inläggsnummer i trådarna',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Visa inläggsnummer i trådhistoriken när svar skrivs',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Visa inläggsnummer i trådgranskningen i MCP',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Skippa inlägg som ej har godkänts',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Skippa inläggsnummer för icke godkända inlägg och inlägg som har soft-raderats',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Visa inläggs-ID istället för inläggsnummer',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Aktiveras detta så kommer inställningen <span style="font-style: italic;">Skippa inlägg som ej har godkänts</span> ovan att ignoreras',
));
