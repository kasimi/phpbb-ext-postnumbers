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
	$lang = array();
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

$lang = array_merge($lang, array(
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Afficher les numéros des messages lors de la consultation d’un sujet',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Afficher les numéros des messages lors de la publication d’une réponse (message) dans la « Revue du sujet »',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Afficher les numéros des messages dans la « Revue du sujet » depuis le « Panneau de modération »',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Ignorer les messages non approuvés',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Permet de ne pas assigner de numéro de messages aux messages non approuvés ou supprimés (ceux restaurables).',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Afficher les ID des messages en lieu et place des numéros des messages',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Permet d’afficher l’ID du message au lieu de son numéro. Si activée, l’option <span style="font-style: italic;">« Ignorer les messages non approuvés »</span> sera ignorée.',
	'POSTNUMBERS_LOCATION'					=> 'Emplacement des numéros des messages',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Avant l’image du message et du nom de l’auteur',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'Dans le sujet du message',
	'POSTNUMBERS_CLIPBOARD'					=> 'Copier le lien du message dans le presse-papier en cliquant sur le numéro du message',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Permet de copier le lien du message lors de clic sur son numéro. Utile uniquement, si l’option « Emplacement des numéros des messages » est sélectionnée sur : « Avant l’image du message et du nom de l’auteur ». Fonctionnalité disponible uniquement depuis les navigateurs récents, tels que : Chrome 43, Firefox 41, IE 9, Opera 29 et Safari 10. Sous les navigateurs non pris en charge, une fenêtre contenant le lien du message sera affichée en lieu et place.',
	'POSTNUMBERS_BOLD'						=> 'Afficher les numéros/ID des messages en gras',
	'POSTNUMBERS_BOLD_EXP'					=> 'Permet d’afficher les numéros et ID des messages avec une police de caractères en gras. Utile uniquement, si l’option « Emplacement des numéros des messages » est sélectionnée sur : « Avant l’image du message et du nom de l’auteur ».',
));
