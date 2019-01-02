<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\event;

use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\data;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use rxu\FirstPostOnEveryPage\event\listener as FirstPostOnEveryPage;
use Aurelienazerty\DisplayLastPost\event\listener as DisplayLastPost;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	const PAGE_VIEWTOPIC	= 'viewtopic';
	const PAGE_REVIEW_REPLY	= 'review_reply';
	const PAGE_REVIEW_MCP	= 'review_mcp';

	/* @var user */
	protected $user;

	/* @var config */
	protected $config;

	/** @var request_interface */
	protected $request;

	/* @var template */
	protected $template;

	/* @var db_interface */
	protected $db;

	/** @var FirstPostOnEveryPage */
	protected $firstPostOnEveryPage;
	
	/** @var DisplayLastPost */
	protected $displayLastPost;

	/** @var boolean */
	protected $is_active = false;

	/** @var string */
	protected $page;

	/** @var string */
	protected $location;

	/** @var int */
	protected $first_post_num = -1;

	/** @var int */
	protected $offset = -1;

	/**
 	 * Constructor
	 *
	 * @param user					$user
	 * @param config				$config
	 * @param request_interface		$request
	 * @param template				$template
	 * @param db_interface			$db
	 * @param FirstPostOnEveryPage	$firstPostOnEveryPage
	 * @param DisplayLastPost $displayLastPost
	 */
	public function __construct(
		user $user,
		config $config,
		request_interface $request,
		template $template,
		db_interface $db,
		FirstPostOnEveryPage $firstPostOnEveryPage = null,
		DisplayLastPost $displayLastPost = null
	)
	{
		$this->user					= $user;
		$this->config 				= $config;
		$this->request				= $request;
		$this->template				= $template;
		$this->db					= $db;
		$this->firstPostOnEveryPage	= $firstPostOnEveryPage;
		$this->displayLastPost		= $displayLastPost;
	}

	/**
	 * Register hooks
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_assign_template_vars_before'	=> 'init_viewtopic',
			'core.viewtopic_modify_post_row'				=> 'postnum_in_viewtopic',
			'core.posting_modify_template_vars'				=> 'init_topic_review',
			'core.topic_review_modify_row'					=> 'postnum_in_topic_review',
			'core.mcp_global_f_read_auth_after'				=> 'init_mcp_review',
			'core.mcp_topic_review_modify_row'				=> 'postnum_in_mcp_review',
		);
	}

	/**
	 * Prepare template data
	 *
	 * @param string $page
	 */
	protected function init($page)
	{
		$this->page = $page;

		$this->is_active = $this->cfg('enabled.' . $page) && !$this->user->data['is_bot'];

		if (!$this->is_active)
		{
			return;
		}

		switch ($this->cfg('location'))
		{
			case 1:
				$this->location = 'subject';
			break;

			default:
				$this->location = 'post_img';
			break;
		}

		$template_data = array(
			'S_POSTNUMBERS_LOCATION'	=> $this->location,
		);

		if ($this->location === 'post_img')
		{
			$this->user->add_lang_ext('kasimi/postnumbers', 'common');

			$template_data = array_merge($template_data, array(
				'S_POSTNUMBERS_CLIPBOARD'		=> $this->cfg('clipboard'),
				'S_POSTNUMBERS_BOLD'			=> $this->cfg('bold'),
				'POSTNUMBERS_PHPBB_VERSION'		=> phpbb_version_compare(PHPBB_VERSION, '3.1.0@dev', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.2.0@dev', '<') ? '31x' : (phpbb_version_compare(PHPBB_VERSION, '3.2.0@dev', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.3.0@dev', '<') ? '32x' : ''),
			));
		}

		$this->template->assign_vars($template_data);
	}

	/**
	 * Event: core.viewtopic_assign_template_vars_before
	 */
	public function init_viewtopic()
	{
		$this->init(self::PAGE_VIEWTOPIC);
	}

	/**
	 * Event: core.viewtopic_modify_post_row
	 *
	 * @param data $event
	 */
	public function postnum_in_viewtopic($event)
	{
		if ($this->is_active)
		{
			// Compatibility with the First Post On Every Page extension by rxu
			// Remove reference to the listener if the topic we are viewing
			// doesn't display the topic's first post on every page
			if ($this->firstPostOnEveryPage !== null && !$event['topic_data']['topic_first_post_show'] && !$event['topic_data']['first_post_always_show'])
			{
				$this->firstPostOnEveryPage = null;
			}

			if ($post_num = $this->get_post_number($this->user->data['user_post_sortby_type'], $this->user->data['user_post_sortby_dir'], $this->user->data['user_post_show_days'], $event['row'], $event['topic_data']['topic_posts_approved'], $event['total_posts'], $event['start']))
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.posting_modify_template_vars
	 */
	public function init_topic_review()
	{
		$this->init(self::PAGE_REVIEW_REPLY);
	}

	/**
	 * Event: core.topic_review_modify_row
	 *
	 * @param data $event
	 */
	public function postnum_in_topic_review($event)
	{
		if ($this->is_active && $event['mode'] == 'topic_review')
		{
			if ($post_num = $this->get_post_number('t', 'd', 0, $event['row'], $event['total_posts'], $event['total_posts'], $event['start']))
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.mcp_global_f_read_auth_after
	 *
	 * @param data $event
	 */
	public function init_mcp_review($event)
	{
		if ($event['mode'] == 'topic_view')
		{
			$this->init(self::PAGE_REVIEW_MCP);
		}
	}

	/**
	 * Event: core.mcp_topic_review_modify_row
	 *
	 * @param data $event
	 */
	public function postnum_in_mcp_review($event)
	{
		if ($this->is_active)
		{
			if ($post_num = $this->get_post_number('t', 'a', 0, $event['row'], $event['topic_info']['topic_posts_approved'], $event['total'], $event['start']))
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Returns the post number/ID of the $row
	 *
	 * @param string $default_sort_by
	 * @param string $default_sort_dir
	 * @param int $default_days
	 * @param array $row
	 * @param int $approved_posts
	 * @param int $total_posts
	 * @param int $start
	 * @return bool|int
	 */
	protected function get_post_number($default_sort_by, $default_sort_dir, $default_days, $row, $approved_posts, $total_posts, $start)
	{
		// If we display IDs, skip all checks and calculations and return immediately
		if ($this->cfg('display_ids'))
		{
			return $row['post_id'];
		}

		// Don't calculate post number if
		//  - posts are not sorted by post time, or
		//  - we display them only for approved posts and this post is not approved
		if ($this->request->variable('sk', $default_sort_by) != 't' || $this->cfg('skip_nonapproved') && $row['post_visibility'] != ITEM_APPROVED)
		{
			// Compatibility with the First Post On Every Page extension by rxu
			// If the first post of the current page meets the above criteria, we need to
			// make sure that the following post isn't labeled as post #1 in the next iteration.
			$this->firstPostOnEveryPage = null;

			return false;
		}

		$is_ascending = $this->request->variable('sd', $default_sort_dir) == 'a';

		// Compatibility with the First Post On Every Page extension by rxu
		if ($this->firstPostOnEveryPage !== null)
		{
			$this->firstPostOnEveryPage = null;

			// First Post On Every Page extension is only active on viewtopic
			if ($this->page === self::PAGE_VIEWTOPIC)
			{
				// If posts are sorted ascending, we display #1 on all except the first page.
				// If posts are sorted descending, we always display #1.
				if (!$is_ascending || $start != 0)
				{
					return 1;
				}
			}
		}

		// Initialize $first_post_num and $offset on first post
		if ($this->first_post_num === -1)
		{
			$need_new_start = false;

			// We only need to query the number of previous/non-approved posts in certain situations
			if ($this->page === self::PAGE_REVIEW_REPLY || $this->request->variable('st', $default_days) != 0)
			{
				$need_new_start = true;
			}
			else if ($this->cfg('skip_nonapproved') && $approved_posts != $total_posts)
			{
				// We skip non-approved posts and the topic we are viewing contains
				// at least one non-approved post. We only need to count posts if
				//  - posts are sorted ascending and we are not on the first page, or
				//  - posts are sorted descending and we are not on the last page
				$need_new_start = $is_ascending ? $start > 0 : $total_posts - $start > $this->config['posts_per_page'];
			}

			if ($need_new_start)
			{
				$post_count = $this->get_post_count($row['topic_id'], $row['post_time']);

				if ($is_ascending)
				{
					$start = $post_count;
				}
				else
				{
					$total_posts += $start == 0 ? $post_count - $total_posts + 1 : $post_count - $start;
				}
			}

			$this->first_post_num = $is_ascending ? $start : $total_posts - $start;
			$this->offset = $is_ascending ? 1 : 0;
		}

		$return = $this->first_post_num + ($is_ascending ? +$this->offset++ : -$this->offset++);
		
		if ($this->displayLastPost !== null && $this->config['display_last_post_show'] && $start) 
		{
			$return = $is_ascending ? $return - 1 : $return + 1;
		}

		return $return;
	}

	/**
	 * Injects a post's number into the row's POST_NUMBER and MINI_POST_IMG fields
	 *
	 * @param array $post_row
	 * @param int $post_num
	 * @return array
	 */
	protected function inject_post_num($post_row, $post_num)
	{
		$post_row['POSTNUMBER'] = $post_num;

		if ($this->location === 'subject')
		{
			$post_row['POST_SUBJECT'] = '#' . $post_num . ' ' . $post_row['POST_SUBJECT'];
		}

		return $post_row;
	}

	/**
	 * Gets the number of approved/all posts in a topic that have been posted before a certain time
	 *
	 * @param int $topic_id
	 * @param int $post_time
	 * @return int
	 */
	protected function get_post_count($topic_id, $post_time)
	{
		$sql_where = array(
			'p.topic_id = ' . (int) $topic_id,
			'p.post_time < ' . (int) $post_time,
		);

		if ($this->cfg('skip_nonapproved'))
		{
			$sql_where[] = 'p.post_visibility = ' . (int) ITEM_APPROVED;
		}

		$sql = 'SELECT COUNT(*) AS count
			FROM ' . POSTS_TABLE . ' p
			WHERE ' . implode(' AND ', $sql_where);
		$result = $this->db->sql_query($sql);
		$count = (int) $this->db->sql_fetchfield('count');
		$this->db->sql_freeresult($result);

		return $count;
	}

	/**
	 * Quick access to this extension's config values
	 *
	 * @param string $key
	 * @return string
	 */
	protected function cfg($key)
	{
		return $this->config['kasimi.postnumbers.' . $key];
	}
}
