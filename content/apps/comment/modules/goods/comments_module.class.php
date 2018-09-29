<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 某商品的所有评论
 * @author royalwang
 *
 */
class goods_comments_module extends api_front implements api_interface
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
		$comment_list = $this->EM_assign_comment($goods_id, $comment_type, $page, $page_size);
		return array('data' => $comment_list['data'], 'pager' => $comment_list['pager']);
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
	private function EM_assign_comment($id, $type, $page = 1, $page_size = 15) {
    
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
			->select(RC_DB::raw('c.*, u.avatar_img'))
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
}

// end