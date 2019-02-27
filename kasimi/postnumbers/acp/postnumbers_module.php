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
	/** @var string */
	public $page_title;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $u_action;

	/**
	 * @param string $id
	 * @param string $mode
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name = 'acp_postnumbers';
		$this->page_title = 'POSTNUMBERS_TITLE';

		$controller = $phpbb_container->get('kasimi.postnumbers.controller.acp');
		$controller->$mode($this->u_action);
	}
}
