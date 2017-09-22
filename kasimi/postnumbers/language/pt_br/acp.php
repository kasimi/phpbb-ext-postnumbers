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
	$lang = array();
}

$lang = array_merge($lang, array(
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Mostra a numeração de mensagens quando visualizando tópicos',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Mostra a numeração de mensagens na revisão do tópico quando respondendo',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Mostra a numeração de mensagens quando na revisão do tópico MCP',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Pula mensagens não aprovadas',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Não conta mensagens não aprovadas ou deletadas.',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Mostra IDs das mensagens ao invés da numeração',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Se habilitado, a configuração <span style="font-style: italic;">Pula mensagens não aprovadas</span> é ignorada.',
	'POSTNUMBERS_LOCATION'					=> 'Localização da numeração na mensagem',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Entre a imagem e o nome do autor',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'No assunto da mensagem',
	'POSTNUMBERS_CLIPBOARD'					=> 'Copia o link da mensagem quando se clica na numeração da mensagem',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Somente é válido se a numeração é mostrada entre a imagem e o nome do autor. Só funciona em navegadores modernos: Chrome 43, Firefox 41, IE 9, Opera 29, Safari 10. Navegadores não suportados mostram um prompt contendo um link.',
	'POSTNUMBERS_BOLD'						=> 'Exibe a numeração/IDs em negrito',
	'POSTNUMBERS_BOLD_EXP'					=> 'Somente é válido se a numeração é mostrada entre a imagem e o nome do autor.',
));
