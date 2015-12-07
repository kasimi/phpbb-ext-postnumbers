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
	protected $start = false;

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
			'core.mcp_global_f_read_auth_after'	=> 'postnum_in_mcp_review_before',
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
		//	3) the user's board preference is to sort topics by 't'ime
		if ($this->cfg('enabled.viewtopic') && !$this->user->data['is_bot'] && $this->user->data['user_post_sortby_type'] == 't')
		{
			$is_ascending = $this->user->data['user_post_sortby_dir'] == 'a';

			// Initialize start and offset on first call if we don't display IDs
			if (!$this->cfg('display_ids') && $this->start === false)
			{
				// We only need to query the number of non-approved posts if
				//	1) we display post numbers for all posts including non-approved ones, or
				//	2) there is at least one non-approved post in the topic and
				//	3a) posts are sorted ascending and we are not on the first page, or
				//	3b) posts are sorted descending and we are not on the last page
				$need_non_approved_posts_num = false;
				if ($this->cfg('skip_nonapproved') && $event['topic_data']['topic_posts_approved'] != $event['total_posts'])
				{
					$need_non_approved_posts_num = $is_ascending ? $event['start'] > 0 : ($event['total_posts'] - $event['start'] > $this->config['posts_per_page']);
				}

				// Count non-approved posts on previous pages
				$non_approved_posts_num = $need_non_approved_posts_num ? $this->get_post_count($event['row']['topic_id'], $event['row']['post_time'], true, false) : 0;
				$this->start = $is_ascending ? ($event['start'] - $non_approved_posts_num) : ($event['total_posts'] - $event['start'] - $non_approved_posts_num);
				$this->offset = $is_ascending ? 1 : 0;
			}

			// Only add post number if
			//	1) we display IDs (skipping IDs for non-approved posts doesn't make sense), or
			//	2) we display post numbers for all posts including non-approved ones, or
			//	3) post is approved
			if ($this->cfg('display_ids') || !$this->cfg('skip_nonapproved') || $event['row']['post_visibility'] == ITEM_APPROVED)
			{
				$post_num = $this->cfg('display_ids') ? $event['row']['post_id'] : ($is_ascending ? ($this->start + $this->offset++) : ($this->start - $this->offset++));
				$event['post_row'] = $this->inject_post_number($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.topic_review_modify_row
	 */
	public function postnum_in_topic_review($event)
	{
		if ($this->cfg('enabled.review_reply') && $event['mode'] == 'topic_review')
		{
			if (!$this->cfg('display_ids') && $this->start === false)
			{
				$is_approved = $this->cfg('skip_nonapproved') ? true : null;
				$this->start = $this->get_post_count($event['topic_id'], $event['row']['post_time'], false, $is_approved);
				$this->offset = 0;
			}

			if ($this->cfg('display_ids') || !$this->cfg('skip_nonapproved') || $event['row']['post_visibility'] == ITEM_APPROVED)
			{
				$post_num = $this->cfg('display_ids') ? $event['row']['post_id'] : $this->start - $this->offset++;
				$event['post_row'] = $this->inject_post_number($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Event: core.mcp_global_f_read_auth_after
	 */
	public function postnum_in_mcp_review_before($event)
	{
		// The MCP default post sorting is not the user's UCP setting,
		// it is hard-coded in phpbb_mcp_sorting() to 't'. This means
		// the posts in the MCP topic review are not sorted by post_time
		// only if the request contains 'sk' and its value is not 't';
		$this->mcp_sorted_by_post_time = $this->request->variable('sk', 't') == 't';
	}

	/**
	 * Event: core.mcp_topic_review_modify_row
	 */
	public function postnum_in_mcp_review($event)
	{
		if ($this->cfg('enabled.review_mcp') && $event['mode'] == 'topic_view' && $this->mcp_sorted_by_post_time)
		{
			if (!$this->cfg('display_ids') && $this->start === false)
			{
				$need_non_approved_posts_num = false;
				if ($this->cfg('skip_nonapproved') && $event['topic_info']['topic_posts_approved'] != $event['total'])
				{
					$need_non_approved_posts_num = $event['start'] > 0;
				}

				$non_approved_posts_num = $need_non_approved_posts_num ? $this->get_post_count($event['topic_id'], $event['row']['post_time'], true, false) : 0;
				$this->start = $event['start'] - $non_approved_posts_num;
				$this->offset = 1;
			}

			if ($this->cfg('display_ids') || !$this->cfg('skip_nonapproved') || $event['row']['post_visibility'] == ITEM_APPROVED)
			{
				$post_num = $this->cfg('display_ids') ? $event['row']['post_id'] : $this->start + $this->offset++;
				$event['post_row'] = $this->inject_post_number($event['post_row'], $post_num);
			}
		}
	}

	/**
	 * Injects a post's number into the row's MINI_POST_IMG field
	 */
	protected function inject_post_number($post_row, $post_num)
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
	protected function get_post_count($topic_id, $post_time, $is_strict_before, $is_approved = null)
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
