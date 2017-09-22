<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\acp;

class postnumbers_module
{
	public $u_action;

	private $config_keys = array(
		'enabled.viewtopic',
		'enabled.review_reply',
		'enabled.review_mcp',
		'skip_nonapproved',
		'display_ids',
		'location',
		'clipboard',
		'bold',
	);

	function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_log;

		$user->add_lang_ext('kasimi/postnumbers', 'acp');

		$this->tpl_name = 'acp_postnumbers';
		$this->page_title = $user->lang('POSTNUMBERS_TITLE');

		add_form_key('acp_postnumbers');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_postnumbers'))
			{
				trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action));
			}

			foreach ($this->config_keys as $config_key)
			{
				$request_key = 'postnumbers_' . str_replace('.', '_', $config_key);
				$config->set('kasimi.postnumbers.' . $config_key, $request->variable($request_key, 0));
			}

			$user_id = (empty($user->data)) ? ANONYMOUS : $user->data['user_id'];
			$user_ip = (empty($user->ip)) ? '' : $user->ip;
			$phpbb_log->add('admin', $user_id, $user_ip, 'POSTNUMBERS_CONFIG_UPDATED');

			trigger_error($user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$template_data = array(
			'U_ACTION' => $this->u_action,
		);

		foreach ($this->config_keys as $config_key)
		{
			$template_key = 'POSTNUMBERS_' . strtoupper(str_replace('.', '_', $config_key));
			$template_data[$template_key] = $config['kasimi.postnumbers.' . $config_key];
		}

		$template->assign_vars($template_data);
	}
}
