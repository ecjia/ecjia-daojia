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
 * 用户查询
 * @author will.chen
 */
class search_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 ) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$result = $this->admin_priv('users_manage');
		
		if (is_ecjia_error($result)) {
			return $result;
		}
		
		$keywords = $this->requestData('keywords');
		if (empty($keywords)) {
			return new ecjia_error(101, '参数错误');
		}
		
		$db_user = RC_Model::model('user/user_viewmodel');
		$region = RC_Model::model('shipping/region_model');
		$db_user->view = array(
				'user_rank' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'r',
						'field'		=> '',
						'on'		=> 'u.user_rank = r.rank_id'
				),
				'user_address' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'ua',
						'field'		=> '',
						'on'		=> 'u.address_id=ua.address_id'
				)
		);
		
		$where = array(
				'user_name' => array('like' => '%'. $keywords . '%'), 
				'OR', 
				'mobile_phone' => array('like' => '%'. $keywords . '%')
		);

		$arr = $db_user->join(array('user_rank','user_address'))
						->field('u.user_id, user_name, u.address_id, user_rank, u.email, mobile_phone, r.rank_name, u.user_money, pay_points, country, province, city, district, address')
						->where($where)
						->select();
		$user_search = array();
		if (!empty($arr)) {
			foreach ($arr as $k => $v){
				$uid = sprintf("%09d", $v['user_id']);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
				
				$dir1 = substr($uid, 0, 3);//把uid分段
				$dir2 = substr($uid, 3, 2);
				$dir3 = substr($uid, 5, 2);
				
				$filename    = md5($v['user_name']);
				$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				$disk = RC_Filesystem::disk();
				if(!$disk->exists($avatar_path)) {
					$avatar_img = '';
				} else {
					$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				}
				
				$address = $v['address_id'] > 0 ? $region->where(array('region_id' => $v['city']))->get_field('region_name')
				.$region->where(array('region_id' => $v['district']))->get_field('region_name').$v['address'] : '';
				$user_search[] = array(
						'id'			=>	$v['user_id'],
						'name'			=>	$v['user_name'],
						'rank_name'		=>	$v['rank_name'],
						'email'			=>	$v['email'],
						'mobile_phone'	=>	$v['mobile_phone'],
						'formatted_user_money' =>	price_format($v['user_money'],false),
						'user_points'	=>	$v['pay_points'],
						'user_money'	=>	$v['user_money'],
						'address'		=>	$address,
						'avatar_img'	=>	$avatar_img,
				);
			}
		}
		
		return $user_search;
	}
}

// end