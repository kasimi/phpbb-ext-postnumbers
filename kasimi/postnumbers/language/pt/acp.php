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
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Mostra a numeração das mensagens aquando se visualiza tópicos',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Mostra a numeração das mensagens na revisão do tópico aquando se responde',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Mostra a numeração de mensagens aquando na revisão do tópico no MCP',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Ignora mensagens não aprovadas',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Não conta mensagens não aprovadas ou apagadas.',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Mostra os IDs das mensagens ao invés da numeração',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Se ativado, a configuração <span style="font-style: italic;">Ignora mensagens não aprovadas</span> é ignorada.',
	'POSTNUMBERS_LOCATION'					=> 'Localização da numeração na mensagem',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'Entre a imagem e o nome do autor',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'No assunto da mensagem',
	'POSTNUMBERS_CLIPBOARD'					=> 'Copia o link da mensagem quando se clica na numeração da mesma',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'Apenas é válido se a numeração é exibida entre a imagem e o nome do autor. Só funciona em navegadores modernos: Chrome 42, Firefox 41, IE 9, Opera 29. Não funciona no Safari. Navegadores não suportados mostram um prompt contendo um link.',
	'POSTNUMBERS_BOLD'						=> 'Exibe a numeração/IDs em negrito',
	'POSTNUMBERS_BOLD_EXP'					=> 'Apenas é válido se a numeração é exibida entre a imagem e o nome do autor.',
));
