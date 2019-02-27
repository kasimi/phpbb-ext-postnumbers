<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\controller;

use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class acp
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var config */
	protected $config;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var array */
	private $config_keys = [
		'enabled.viewtopic',
		'enabled.review_reply',
		'enabled.review_mcp',
		'skip_nonapproved',
		'display_ids',
		'location',
		'clipboard',
		'bold',
	];

	/**
	 * @param user				$user
	 * @param language			$lang
	 * @param config			$config
	 * @param request_interface	$request
	 * @param template			$template
	 * @param log_interface		$log
	 */
	public function __construct(
		user $user,
		language $lang,
		config $config,
		request_interface $request,
		template $template,
		log_interface $log
	)
	{
		$this->user		= $user;
		$this->lang		= $lang;
		$this->config	= $config;
		$this->request	= $request;
		$this->template	= $template;
		$this->log		= $log;
	}

	/**
	 * @param string $u_action
	 */
	function settings($u_action)
	{
		$this->lang->add_lang('acp', 'kasimi/postnumbers');

		add_form_key('acp_postnumbers');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_postnumbers'))
			{
				trigger_error($this->lang->lang('FORM_INVALID') . adm_back_link($u_action));
			}

			foreach ($this->config_keys as $config_key)
			{
				$request_key = 'postnumbers_' . str_replace('.', '_', $config_key);
				$this->config->set('kasimi.postnumbers.' . $config_key, $this->request->variable($request_key, 0));
			}

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'POSTNUMBERS_CONFIG_UPDATED');

			trigger_error($this->lang->lang('CONFIG_UPDATED') . adm_back_link($u_action));
		}

		$template_data = [
			'U_ACTION' => $u_action,
		];

		foreach ($this->config_keys as $config_key)
		{
			$template_key = 'POSTNUMBERS_' . strtoupper(str_replace('.', '_', $config_key));
			$template_data[$template_key] = $this->config['kasimi.postnumbers.' . $config_key];
		}

		$this->template->assign_vars($template_data);
	}
}
