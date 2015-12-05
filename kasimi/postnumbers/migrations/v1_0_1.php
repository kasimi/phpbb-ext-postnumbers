<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2015 kasimi
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\migrations;

class v1_0_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\kasimi\postnumbers\migrations\v1_0_0');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('kasimi.postnumbers.version', '1.0.1')),
			array('config.add', array('kasimi.postnumbers.bold', 0)),
		);
	}
}
