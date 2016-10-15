<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\migrations;

class v1_0_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314rc1');
	}

	public function update_data()
	{
		return array(
			// Add config entries
			array('config.add', array('kasimi.postnumbers.version', '1.0.0')),
			array('config.add', array('kasimi.postnumbers.enabled.viewtopic', 0)),
			array('config.add', array('kasimi.postnumbers.enabled.review_reply', 0)),
			array('config.add', array('kasimi.postnumbers.enabled.review_mcp', 0)),
			array('config.add', array('kasimi.postnumbers.skip_nonapproved', 0)),
			array('config.add', array('kasimi.postnumbers.display_ids', 0)),

			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'POSTNUMBERS_TITLE'
			)),

			array('module.add', array(
				'acp',
				'POSTNUMBERS_TITLE',
				array(
					'module_basename'	=> '\kasimi\postnumbers\acp\postnumbers_module',
					'auth'				=> 'ext_kasimi/postnumbers && acl_a_board',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
