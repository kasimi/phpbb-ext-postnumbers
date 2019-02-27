<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\acp;

class postnumbers_info
{
	function module()
	{
		return [
			'filename'	=> '\kasimi\postnumbers\acp\postnumbers_module',
			'title'		=> 'POSTNUMBERS_TITLE',
			'modes'		=> [
				'settings' => [
					'title'	=> 'POSTNUMBERS_CONFIG',
					'auth'	=> 'ext_kasimi/postnumbers && acl_a_board',
					'cat'	=> ['POSTNUMBERS_TITLE']
				],
			],
		];
	}
}
