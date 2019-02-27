<?php
/**
 *
 * Post Numbers. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 kasimi <https://kasimi.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'POSTNUMBERS_COPY_TITLE'		=> 'Copier le lien du message dans le presse-papier',
	'POSTNUMBERS_COPY_MANUALLY'		=> 'Copier manuellement le lien vers le presse-papier : Combinaison des touches Ctrl (Cmd sous Mac) + C, puis coller l’adresse dans la barre d’adresse du navigateur (combinaison des touches Ctrl / Cmd sous Mac + V) puis de la touche Enter',
	'POSTNUMBERS_COPIED'			=> 'Lien copié !',
]);
