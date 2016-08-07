<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi
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
	'POSTNUMBERS_TITLE'						=> 'Números de Mensajes',
	'POSTNUMBERS_CONFIG'					=> 'Configuración',
	'POSTNUMBERS_CONFIG_UPDATED'			=> 'Extensión <strong>Números de Mensajes</strong><br />» Configuración actualizada',
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Mostrar números de mensajes cuando estemos viendo un tema',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Mostrar números de mensajes en la vista previa del tema cuando se esta escribiendo una respuesta',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Mostrar números de mensajes en la vista previa del PCM',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Omitir mensajes no aprobados',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'No asignar números de mensajes a mensajes no aprobados y [Soft] Borrados',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Mostrar los IDs de mensaje en lugar de números de mensajes',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Si está habilitado, el ajuste anterior <span style="font-style: italic;">Omitir mensajes no aprobados</span> será ignorado',
	'POSTNUMBERS_LOCATION'					=> 'Localización de la numeración en el mensaje',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Ingrese una imagen y el nombre del autor',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'Asunto del mensaje',
	'POSTNUMBERS_CLIPBOARD'					=> 'Copiar el enlace del mensaje cuando se haga clic en la numeración del mensaje',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Solamente es válido si la numeración es mostrada entre la imagen y el nombre del autor. Solo funciona en navegadores modernos: Chrome 42, Firefox 41, IE 9, Opera 29. No funciona con Safari. Navegadores no soportados muestran un prompt conteniendo un enlace.',
	'POSTNUMBERS_BOLD'						=> 'Muestra la numeración/IDs en negritas',
	'POSTNUMBERS_BOLD_EXP'					=> 'Solamente es válido si la numeración es mostrada entre la imagen y el nombre del autor.',
));
