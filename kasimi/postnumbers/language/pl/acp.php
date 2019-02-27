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
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Pokaż numerację postów podczas wyświetlania tematów',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Pokaż numerację postów (w przeglądzie tematu) podczas pisania odpowiedzi',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Pokaż numerację postów w Panelu Moderacji',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Opuść niezaakceptowane posty',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Nie przypisuj numeracji postów do niezaakceptowanych i ukrytych postów',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Wyświetlaj globalne ID postów zamiast numeracji w ramach tematu',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Jeśli opcja jest włączona, powyższa opcja <span style="font-style: italic;">Opuść niezaakceptowane posty</span> będzie ignorowana',
	'POSTNUMBERS_LOCATION'					=> 'Lokalizacja numeracji postów',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Przed ikoną postu i nazwą użytkownika autora postu',
	'POSTNUMBERS_LOCATION_BEFORE_SUBJECT'	=> 'W temacie postu',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'Replace post subject',
	'POSTNUMBERS_CLIPBOARD'					=> 'Kopiuj link do posta po kliknięciu w numerację',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Opcja ma znaczenie tylko wtedy, gdy numeracja postu znajduje się przed ikoną postu i nazwą użytkownika autora postu. Działa wyłącznie z nowoczesnymi przeglądarkami, w wersjach co najmniej: Chrome 43, Firefox 41, Internet Explorer 9, Opera 29, Safari 10. W niewspieranych przeglądarkach będzie wyświetlany komunikat z linkiem do postu, zamiast akcji kopiowania.',
	'POSTNUMBERS_BOLD'						=> 'Wyświetlaj numerację postów/globalne ID pogrubioną czcionką',
	'POSTNUMBERS_BOLD_EXP'					=> 'Opcja ma znaczenie tylko wtedy, gdy gdy numeracja postu znajduje się przed ikoną postu i nazwą użytkownika autora postu.',
]);
