<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 某商品的所有评论
 * @author royalwang
 *
 */
class comments_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
    	$this->authSession();
		$goods_id = $this->requestData('goods_id');
		$comment_type = $this->requestData('comment_type', 'all');
		
		if (!$goods_id || !$comment_type) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$page_size	= $this->requestData('pagination.count', 15);
		$page		= $this->requestData('pagination.page', 1);
		
		//0评论的是商品,1评论的是文章
		$comment_list = EM_assign_comment($goods_id, $comment_type, $page, $page_size);
		return array('data' => $comment_list['data'], 'pager' => $comment_list['pager']);
	}
}



/**
 * 查询评论内容
 *
 * @access  public
 * @params  integer     $id
 * @params  integer     $type
 * @params  integer     $page
 * @return  array
 */
function EM_assign_comment($id, $type, $page = 1, $page_size = 15) {
    
	$comment_number = RC_DB::table('goods_data')->where('goods_id', $id)->first();
	if (empty($comment_number)) {
	    $list['comment_number']['all'] = 0;
	    $list['comment_number']['good'] = 0;
	    $list['comment_number']['general'] = 0;
	    $list['comment_number']['low'] = 0;
	    $list['comment_number']['picture'] = 0;
	    $list['comment_percent'] = '100%';
	} else {
	    $list['comment_number']['all'] = $comment_number['comment_good'] + $comment_number['comment_general'] + $comment_number['comment_low'];
	    $list['comment_number']['good'] = $comment_number['comment_good'];
	    $list['comment_number']['general'] = $comment_number['comment_general'];
	    $list['comment_number']['low'] = $comment_number['comment_low'];
	    $list['comment_number']['picture'] = $comment_number['comment_picture'];
	    $list['comment_percent'] = round($comment_number['goods_rank']/100).'%';
	}

	$db_comment = RC_DB::table('comment as c')
	    ->leftJoin('users as u', RC_DB::raw('u.user_id'), '=', RC_DB::raw('c.user_id'))
		->selectRaw('c.*, u.avatar_img')
		->where('id_value', $id)
		->where('status', 1)
		->where(RC_DB::raw('c.parent_id'), 0)
		->where('comment_type', 0);
	
	if ($type == 'all') {
		$db_comment->where('comment_rank', '>', 0);
	} elseif ($type == 'good') {
		$db_comment->where('comment_rank', '>', 3);
	} elseif ($type == 'general') {
		$db_comment->where('comment_rank', '>', 1)->where('comment_rank', '<', 4);
	} elseif ($type == 'low') {
		$db_comment->where('comment_rank', '=', 1);
	} elseif ($type == 'picture') {
		$db_comment->where('has_image', '=', 1);
	}
	
	/* 取得评论列表 */
	$count = $db_comment->count();
	
	/* 查询总数为0时直接返回  */
	if ($count == 0) {
		$pager = array(
			'total' => 0,
			'count' => 0,
			'more'	=> 0,
		);
		return array('data' => $list, 'pager' => $pager);
	}
		
	$page_row = new ecjia_page($count, $page_size, 6, '', $page);
	$data = $db_comment->orderBy('comment_id', 'desc')->take($page_size)->skip($page_row->start_id-1)->get();
	
	
	$arr = $ids = array();
	if (!empty($data)) {
		foreach ($data as $row) {
			$arr['id'] = $row['comment_id'];
			if ($row['is_anonymous'] == 1) {
				$len = mb_strlen($row['user_name']);
				if ($len > 2) {
					$user_name = mb_substr($row['user_name'], 0, 1) . '***' . mb_substr($row['user_name'], $len-1, $len);
				} else  {
					$user_name = mb_substr($row['user_name'], 0, 1) . '*';
				}
				$arr['author'] = $user_name;
			} else {
				$arr['author'] = $row['user_name'];
			}
			
			if(empty($row['avatar_img'])) {
			    $arr['avatar_img'] = '';
			} else {
			    $arr['avatar_img'] = RC_Upload::upload_url($row['avatar_img']);
			}
	
			$arr['content']  	= str_replace('\r\n', '<br />', htmlspecialchars($row['content']));
			$arr['content']  	= nl2br(str_replace('\n', '<br />', $arr['content']));
			$arr['rank']     	= $row['comment_rank'];
			$arr['goods_attr']	= str_replace('\n', '', $row['goods_attr']);
			$arr['goods_attr']	= str_replace('\r\n', '', $arr['goods_attr']);
			$arr['goods_attr']	= preg_replace("/\s/", "", $arr['goods_attr']);
			$arr['add_time'] 	= RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
			$arr['picture']     = array();
			
			if ($row['has_image'] == 1) {
				$picture_list = RC_DB::table('term_attachment')
					->where('object_group', 'comment')
					->where('object_id', $row['comment_id'])
					->where('object_app', 'ecjia.comment')
					->where('object_group', 'comment')
					->lists('file_path');
				$disk = RC_Filesystem::disk();
				if (!empty($picture_list)) {
					foreach ($picture_list as $k => $v) {
						if (!empty($v) && $disk->exists(RC_Upload::upload_path($v))) {
							$arr['picture'][] = RC_Upload::upload_url($v);
						}
					}
				}
			}
			$reply = RC_DB::table('comment_reply')->where('comment_id', $row['comment_id'])->whereIn('user_type', array('admin', 'merchant'))->first();
			if ($reply['user_type'] == 'admin' && $reply['user_id']) {
			    $reply_username = '平台回复';
			}
			if ($reply['user_type'] == 'merchant' && $reply['user_id']) {
			    $reply_username = '卖家回复';
			}
			$arr['reply_content']  = nl2br(str_replace('\n', '<br />', htmlspecialchars($reply['content'])));
			$arr['reply_username'] = $reply_username;
			$arr['reply_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $reply['add_time']);
			$list['list'][] = $arr;
		}
	}

	$pager = array(
		"total"  => $page_row->total_records,
		"count"  => $page_row->total_records,
		"more"   => $page_row->total_pages <= $page ? 0 : 1,
	);

   	return array('data' => $list, 'pager' => $pager);
}

// end