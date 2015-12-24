<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2015 kasimi
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\postnumbers\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/* @var \phpbb\user */
	protected $user;

	/* @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var boolean */
	protected $is_active = false;

	/** @var int */
	protected $first_post_num = -1;

	/** @var int */
	protected $offset = -1;

	/**
 	 * Constructor
	 *
	 * @param \phpbb\user							$user
	 * @param \phpbb\config\config					$config
	 * @param \phpbb\request\request_interface		$request
	 * @param \phpbb\template\template				$template
	 * @param \phpbb\db\driver\driver_interface		$db
	 */
	public function __construct(
		\phpbb\user $user,
		\phpbb\config\config $config,
		\phpbb\request\request_interface $request,
		\phpbb\template\template $template,
		\phpbb\db\driver\driver_interface $db
	)
	{
		$this->user		= $user;
		$this->config 	= $config;
		$this->request	= $request;
		$this->template = $template;
		$this->db		= $db;
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
	 * Prepare language & template
	 */
	protected function init()
	{
		$this->user->add_lang_ext('kasimi/postnumbers', 'common');
		$this->template->assign_vars(array(
			'S_POSTNUMBERS_CLIPBOARD' => $this->cfg('clipboard'),
		));
	}

	/**
	 * Event: core.viewtopic_assign_template_vars_before
	 */
	public function init_viewtopic($event)
	{
		$this->is_active = $this->cfg('enabled.viewtopic') && !$this->user->data['is_bot'];
		if ($this->is_active)
		{
			$this->init();
		}
	}

	/**
	 * Event: core.viewtopic_modify_post_row
	 */
	public function postnum_in_viewtopic($event)
	{
		if ($this->is_active)
		{
			if ($post_num = $this->get_post_number($this->user->data['user_post_sortby_type'], $this->user->data['user_post_sortby_dir'], $this->user->data['user_post_show_days'], $event['row'], $event['topic_data']['topic_posts_approved'], $event['total_posts'], $event['start'], false))
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.posting_modify_template_vars
	 */
	public function init_topic_review($event)
	{
		$this->is_active = $this->cfg('enabled.review_reply');
		if ($this->is_active)
		{
			$this->init();
		}
	}

	/**
	 * Event: core.topic_review_modify_row
	 */
	public function postnum_in_topic_review($event)
	{
		if ($this->is_active && $event['mode'] == 'topic_review')
		{
			if ($post_num = $this->get_post_number('t', 'd', 0, $event['row'], $event['total_posts'], $event['total_posts'], $event['start'], true))
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.mcp_global_f_read_auth_after
	 */
	public function init_mcp_review($event)
	{
		$this->is_active = $this->cfg('enabled.review_mcp') && $event['mode'] == 'topic_view';
		if ($this->is_active)
		{
			$this->init();
		}
	}

	/**
	 * Event: core.mcp_topic_review_modify_row
	 */
	public function postnum_in_mcp_review($event)
	{
		if ($this->is_active)
		{
			if ($post_num = $this->get_post_number('t', 'a', 0, $event['row'], $event['topic_info']['topic_posts_approved'], $event['total'], $event['start'], false))
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Returns the post number/ID of the $row
	 */
	protected function get_post_number($default_sort_by, $default_sort_dir, $default_days, $row, $approved_posts, $total_posts, $start, $is_reply_review)
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
			return false;
		}

		$is_ascending = $this->request->variable('sd', $default_sort_dir) == 'a';

		// Initialize $first_post_num and $offset on first post
		if ($this->first_post_num === -1)
		{
			// We only need to query the number of previous/non-approved posts in certain situations
			$need_new_start = false;
			if ($is_reply_review || $this->request->variable('st', $default_days) != 0)
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
					$total_posts += $start == 0 ? $post_count + 1 - $total_posts : $post_count - $start;
				}
			}

			$this->first_post_num = $is_ascending ? $start : $total_posts - $start;
			$this->offset = $is_ascending ? 1 : 0;
		}

		return $this->first_post_num + ($is_ascending ? +$this->offset++ : -$this->offset++);
	}

	/**
	 * Injects a post's number into the row's POST_NUMBER and MINI_POST_IMG fields
	 */
	protected function inject_post_num($post_row, $post_num)
	{
		$bold_open = $bold_close = '';
		if ($this->cfg('bold'))
		{
			$bold_open = '<strong>';
			$bold_close = '</strong>';
		}

		$lang_copy_title = utf8_htmlspecialchars($this->user->lang('POSTNUMBERS_COPY_TITLE'));
		$lang_copied = utf8_htmlspecialchars($this->user->lang('POSTNUMBERS_COPIED'));
		$lang_copy_manually = utf8_htmlspecialchars($this->user->lang('POSTNUMBERS_COPY_MANUALLY'));

		$post_row['POST_NUMBER'] = sprintf('<span class="post-number" title="%s" data-tooltip="%s" data-copy-manually="%s">%s#%d%s</span>', $lang_copy_title, $lang_copied, $lang_copy_manually, $bold_open, $post_num, $bold_close);

		$href = isset($post_row['U_MINI_POST']) ? $post_row['U_MINI_POST'] : ('#pr' . $post_row['POST_ID']);
		$post_row['MINI_POST_IMG'] = sprintf('%s</a><a href="%s"> %s ', $post_row['MINI_POST_IMG'], $href, $post_row['POST_NUMBER']);

		return $post_row;
	}

	/**
	 * Gets the number of approved/all posts in a topic that have been posted before a certain time
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

		$sql = 'SELECT COUNT(*) as count
			FROM ' . POSTS_TABLE . ' p
			WHERE ' . implode(' AND ', $sql_where);
		$result = $this->db->sql_query($sql);
		$count = (int) $this->db->sql_fetchfield('count');
		$this->db->sql_freeresult($result);

		return $count;
	}

	/**
	 * Quick access to this extension's config values
	 */
	protected function cfg($key)
	{
		return $this->config['kasimi.postnumbers.' . $key];
	}
}
