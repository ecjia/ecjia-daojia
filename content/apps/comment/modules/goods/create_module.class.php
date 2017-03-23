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
 * 发表评价
 * @author royalwang
 *
 */
class create_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	//如果用户登录获取其session
    	$this->authSession();
		$user_id = $_SESSION['user_id'];//1036
		if ($user_id < 1) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$user_name 		= $_SESSION['user_name'];
		$rec_id			= $this->requestData('rec_id', 0);//4826
		$content 		= $this->requestData('content');
		$rank 			= $this->requestData('rank', 5);
		$is_anonymous 	= $this->requestData('is_anonymous', 1);
		
		if ( empty($rec_id)) {
			return new ecjia_error('invalid_parameter', '参数错误！');
		}
		
		$comment_info = RC_DB::table('comment')->where('rec_id', $rec_id)->where('parent_id', 0)->first();
		if (!empty($comment_info) && $comment_info['has_image'] == 1) {
		    return new ecjia_error('comment_exist', '评价已完成，请勿重复评价');
		}
		$comment_second_info = RC_DB::table('comment')->where('rec_id', $rec_id)->where('parent_id', '<>', 0)->first();
		if (!empty($comment_second_info) && $comment_second_info['has_image'] == 1) {
		    return new ecjia_error('comment_exist', '评价已完成，请勿重复评价');//追加
		}
		
		$order_info = RC_DB::table('order_info as oi')
    		->selectRaw('oi.store_id, oi.shipping_time, og.goods_attr, og.order_id, og.goods_id')
    		->leftJoin('order_goods as og', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
    		->where(RC_DB::raw('oi.user_id'), $user_id)
    		->where(RC_DB::raw('og.rec_id'), $rec_id)
    		->first();
		if (empty($order_info)) {
		    return new ecjia_error('order_error', '订单信息不存在！');
		}
		
		//评价传图
		//评价无图
		//补充图片
		/* 评论是否需要审核 */
		if (!empty($content) && !empty($rank) && empty($comment_info)) {
		    $status = 1 - ecjia::config('comment_check');
		    
		    if ($rank > 5 || $rank < 1) {
	            return new ecjia_error('invalid_parameter', 'rank参数错误！');
		    }
		    
		    $data = array(
		        'comment_type'	=> 0,
		        'id_value'		=> $order_info['goods_id'],
		        'user_name'		=> $user_name,
		        'is_anonymous'  => $is_anonymous,
		        'content'		=> $content,
		        'comment_rank'	=> $rank,
		        'add_time'		=> RC_Time::gmtime(),
		        'order_time'    => empty($order_info['shipping_time']) ? RC_Time::gmtime() : $order_info['shipping_time'],
		        'ip_address'	=> RC_Ip::client_ip(),
		        'status'		=> $status,
		        'parent_id'		=> 0,
		        'user_id'		=> $user_id,
		        'store_id'		=> $order_info['store_id'],
		        'order_id'   	=> $order_info['order_id'],
		        'rec_id'        => $rec_id,
		        'goods_attr'	=> $order_info['goods_attr']
		    );
// 		    if (!empty($image_info)) {
// 		        $data['has_image'] = 1;
// 		    }
		    $comment_id = RC_Model::model('comment/comment_model')->insert($data);
		    
		    //评价送积分
		    $message = '';
		    $comment_award = 0;
		    
		    if (ecjia::config('comment_award_open') && ecjia::config('comment_check') == 0) {
		        $comment_award_rules = ecjia::config('comment_award_rules');
		        $comment_award_rules = unserialize($comment_award_rules);
		        $comment_award = isset($comment_award_rules[$_SESSION['user_rank']]) ? $comment_award_rules[$_SESSION['user_rank']] : ecjia::config('comment_award');
		        	
		        RC_Api::api('user', 'account_change_log', array('user_id' => $_SESSION['user_id'], 'pay_points' => $comment_award, 'change_desc' => '评论送积分'));
		        $message = '评论成功！并获得'.$comment_award.ecjia::config('integral_name').'！';
		    }
		    
		    //更新商品评分,商品审核开启时
		    if (ecjia::config('comment_check') == 1) {
		        RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $order_info['goods_id']));
		    }
		    
		}

		//补充图片 或 第一次评价
		if ((!empty($comment_info) && $comment_info['has_image'] == 0) || empty($comment_info)) {
		    
		    $save_path = 'data/comment/'.RC_Time::local_date('Ym');
		    $upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
		    
		    $image_info = null;
		    if (!empty($_FILES)) {
		        $count = count($_FILES['picture']['name']);
		        for ($i = 0; $i < $count; $i++) {
		            $picture = array(
		                'name' 		=> 	$_FILES['picture']['name'][$i],
		                'type' 		=> 	$_FILES['picture']['type'][$i],
		                'tmp_name' 	=> 	$_FILES['picture']['tmp_name'][$i],
		                'error'		=> 	$_FILES['picture']['error'][$i],
		                'size'		=> 	$_FILES['picture']['size'][$i],
		            );
		            if (!empty($picture['name'])) {
		                if (!$upload->check_upload_file($picture)) {
		                    return new ecjia_error('picture_error', $upload->error());
		                }
		            }
		        }
		        
		        $image_info	= $upload->batch_upload($_FILES);
		    }
		    
		    if (!empty($image_info)) {
		        if (!empty($comment_info) && $comment_info['has_image'] == 0) {
		            $comment_id = $comment_info['comment_id'];
		        }
		        if (empty($comment_id)) {
		            return new ecjia_error('comment_error', '评价主体信息丢失');
		        }
		        foreach ($image_info as $image) {
		            if (!empty($image)) {
		                $image_url	= $upload->get_position($image);
		                $data = array(
		                    'object_app'	=> 'ecjia.comment',
		                    'object_group'	=> 'comment',
		                    'object_id'		=> $comment_id,
		                    'attach_label'  => $image['name'],
		                    'file_name'     => $image['name'],
		                    'file_path'		=> $image_url,
		                    'file_size'     => $image['size'] / 1000,
		                    'file_ext'      => $image['ext'],
		                    'file_hash'     => $image['sha1'],
		                    'file_mime'     => $image['type'],
		                    'is_image'		=> 1,
		                    'user_id'		=> $user_id,
		                    'user_type'     => 'user',
		                    'add_time'		=> RC_Time::gmtime(),
		                    'add_ip'		=> RC_Ip::client_ip(),
		                    'in_status'     => 0
		                );
		                $attach = RC_DB::table('term_attachment')->insert($data);
		                if ($attach) {
		                    RC_DB::table('comment')->where('comment_id', $comment_id)->update(array('has_image' => 1));
		                }
		            }
		        }
		    }
		}
		if (!empty($content) && !empty($rank) && empty($comment_info) && ecjia::config('comment_award_open')) {
		    return array('data' => array('comment_award' => $comment_award, 'label_comment_award' => $message, 'label_award' => ecjia::config('integral_name')));
		}
		
		return array();
	}
}

// end