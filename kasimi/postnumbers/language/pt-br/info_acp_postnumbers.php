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
	'POSTNUMBERS_TITLE'						=> 'Numeração de Mensagens',
	'POSTNUMBERS_CONFIG'					=> 'Configuração',
	'POSTNUMBERS_CONFIG_UPDATED'			=> 'Extensão <strong>Numeração de Mensagens </strong><br />» Configuração salva',
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'Mostra a numeração de mensagens quando visualizando tópicos',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'Mostra a numeração de mensagens na revisão do tópico quando respondendo',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'Mostra a numeração de mensagens quando na revisão do tópico MCP',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'Pula mensagens não aprovadas',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'Não conta mensagens não aprovadas ou deletadas.',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'Mostra IDs das mensagens ao invés da numeração',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'Se habilitado, a configuração <span style="font-style: italic;">Pula mensagens não aprovadas</span> é ignorada.',
	'POSTNUMBERS_BOLD'						=> 'Exibe a numeração ou ID em negrito',
));
