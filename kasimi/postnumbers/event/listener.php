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

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var boolean */
	protected $first_post_num = false;

	/** @var boolean */
	protected $offset = false;

	/** @var boolean */
	protected $mcp_sorted_by_post_time = false;

	/**
 	 * Constructor
	 *
	 * @param \phpbb\user							$user
	 * @param \phpbb\config\config					$config
	 * @param \phpbb\request\request_interface		$request
	 * @param \phpbb\db\driver\driver_interface		$db
	 */
	public function __construct(
		\phpbb\user $user,
		\phpbb\config\config $config,
		\phpbb\request\request_interface $request,
		\phpbb\db\driver\driver_interface $db
	)
	{
		$this->user		= $user;
		$this->config 	= $config;
		$this->request	= $request;
		$this->db		= $db;
	}

	/**
	 * Register hooks
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_row'	=> 'postnum_in_viewtopic',
			'core.topic_review_modify_row'		=> 'postnum_in_topic_review',
			'core.mcp_topic_review_modify_row'	=> 'postnum_in_mcp_review',
		);
	}

	/**
	 * Event: core.viewtopic_modify_post_row
	 */
	public function postnum_in_viewtopic($event)
	{
		// Show post numbers in viewtopic if
		//	1) viewtopic is enabled in the extension preferences
		//	2) the user is not a bot
		//	3) the user sorts the posts by 't'ime
		if ($this->cfg('enabled.viewtopic') && !$this->user->data['is_bot'])
		{
			$post_num = false;

			if ($this->cfg('display_ids'))
			{
				$post_num = $event['row']['post_id'];
			}
			else if ($this->request->variable('sk', $this->user->data['user_post_sortby_type']) == 't')
			{
				$post_num = $this->get_post_number($event['row'], $this->user->data['user_post_sortby_dir'], $event['topic_data']['topic_posts_approved'], $event['total_posts'], $event['start'], true, false);
			}

			if ($post_num)
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.topic_review_modify_row
	 */
	public function postnum_in_topic_review($event)
	{
		// Show post numbers when reviewing a topic if
		//	1) review_reply is enabled in the extension preferences
		//  2) the user is on the topic review page
		if ($this->cfg('enabled.review_reply') && $event['mode'] == 'topic_review')
		{
			if ($this->cfg('display_ids'))
			{
				$post_num = $event['row']['post_id'];
			}
			else
			{
				$is_approved = $this->cfg('skip_nonapproved') ? true : null;
				$post_num = $this->get_post_number($event['row'], 'd', $event['total'], $event['total'], $event['start'], false, $is_approved, true);
			}

			if ($post_num)
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.mcp_topic_review_modify_row
	 */
	public function postnum_in_mcp_review($event)
	{
		// The MCP default post sorting is not the user's UCP setting,
		// it is hard-coded in phpbb_mcp_sorting() to 't'. This means
		// the posts in the MCP topic review are NOT sorted by post_time
		// only if the request contains 'sk' and its value is not 't';
		if ($this->cfg('enabled.review_mcp') && $event['mode'] == 'topic_view')
		{
			$post_num = false;

			if ($this->cfg('display_ids'))
			{
				$post_num = $event['row']['post_id'];
			}
			else if ($this->request->variable('sk', 't') == 't')
			{
				$post_num = $this->get_post_number($event['row'], 'a', $event['topic_info']['topic_posts_approved'], $event['total'], $event['start'], true, false);
			}

			if ($post_num)
			{
				$event['post_row'] = $this->inject_post_num($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Returns the post number of the $row
	 */
	protected function get_post_number($row, $default_sort_dir, $approved_posts, $total_posts, $start, $is_strict_before, $is_approved, $need_post_count = false)
	{
		$is_ascending = $this->request->variable('sd', $default_sort_dir) == 'a';

		// Initialize start and offset on first call if we don't display IDs
		if ($this->first_post_num === false)
		{
			// We only need to query the number of non-approved posts if
			//	1) we display post numbers for all posts including non-approved ones, or
			//	2) there is at least one non-approved post in the topic and
			//	3a) posts are sorted ascending and we are not on the first page, or
			//	3b) posts are sorted descending and we are not on the last page
			$need_post_count = $need_post_count || ($this->cfg('skip_nonapproved') && $approved_posts != $total_posts && $is_ascending ? $start > 0 : $total_posts - $start > $this->config['posts_per_page']);

			// Count non-approved posts on previous pages
			$non_approved_posts_num = $need_post_count ? $this->get_post_count($row['topic_id'], $row['post_time'], $is_strict_before, $is_approved) : 0;

			// Ugly fix for calculating correct $first_post_num in topic review
			if (!$is_strict_before)
			{
				$start = 0;
				$total_posts = 2 * $non_approved_posts_num;
			}

			$this->first_post_num = $is_ascending ? ($start - $non_approved_posts_num) : ($total_posts - $start - $non_approved_posts_num);
			$this->offset = $is_ascending ? 1 : 0;
		}

		// Only add post number if
		//	1) we display post numbers for all posts including non-approved ones, or
		//	2) post is approved
		if (!$this->cfg('skip_nonapproved') || $row['post_visibility'] == ITEM_APPROVED)
		{
			return $is_ascending ? ($this->first_post_num + $this->offset++) : ($this->first_post_num - $this->offset++);
		}

		return false;
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

		$post_row['POST_NUMBER'] = sprintf('<span class="post-number">%s#%d%s</span>', $bold_open, $post_num, $bold_close);

		$href = isset($post_row['U_MINI_POST']) ? $post_row['U_MINI_POST'] : ('#pr' . $post_row['POST_ID']);
		$post_row['MINI_POST_IMG'] = sprintf('%s</a><a href="%s"> %s ', $post_row['MINI_POST_IMG'], $href, $post_row['POST_NUMBER']);

		return $post_row;
	}

	/**
	 * Gets the number of approved/non-approved/all posts in a topic that have been posted before a certain time
	 */
	protected function get_post_count($topic_id, $post_time, $is_strict_before, $is_approved)
	{
		$sql_where = array(
			sprintf('p.topic_id = %d', (int) $topic_id),
			sprintf('p.post_time %s %d', $is_strict_before ? '<' : '<=', (int) $post_time),
		);

		if (!is_null($is_approved))
		{
			$sql_where[] = sprintf('p.post_visibility %s %d', $is_approved ? '=' : '!=', ITEM_APPROVED);
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
	 *	Quick access to this extension's config values
	 */
	protected function cfg($key)
	{
		return $this->config['kasimi.postnumbers.' . $key];
	}
}
