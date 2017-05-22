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
 * 编辑单个商品基本信息
 * @author huangyuyuan@ecmoban.com
 *
 */
class update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
    	$result = $this->admin_priv('goods_manage');
        if (is_ecjia_error($result)) {
			return $result;
		}
    	
    	//请求参数：
    	$goods_id		= $this->requestData('goods_id', 0);
    	if (empty($goods_id)) {
    	    return new ecjia_error('invalid_parameter', '参数错误');
    	}
    	$goods_name		= $this->requestData('goods_name');
    	if (empty($goods_name)) {
    	    return new ecjia_error('goods_name_empty', '请输入商品名称');
    	}
    	$category_id	= $this->requestData('category_id', 0);
    	$merchant_category_id = $this->requestData('merchant_category', 0);
    	$goods_price	= $this->requestData('goods_price', 0.00);
    	$stock			= $this->requestData('stock', 0);
    	
    	if (empty($category_id)) {
    	    return new ecjia_error('category_id_empty', '请选择商品分类');
    	}
    	if (empty($merchant_category_id)) {
    	    return new ecjia_error('merchant_category_id_empty', '请选择店铺分类');
    	}
    	
    	RC_Loader::load_app_func('global', 'goods');
    	
    	/*新增商品信息入库*/
    	$rs = RC_Model::model('goods/goods_model')->where(array('goods_id' => $goods_id))->update(array(
					    	'goods_name'         => $goods_name,
					    	'store_id'            => isset($_SESSION['store_id']) ? $_SESSION['store_id'] : 0,
					    	'cat_id'             => $category_id,
    						'merchant_cat_id'	 => $merchant_category_id,
					    	'shop_price'         => $goods_price,
					    	'market_price'       => $goods_price * 1.1,
					    	'goods_number'       => $stock,
    	                    'review_status'      => get_review_status($_SESSION['store_id']),
					    	'last_update'        => RC_Time::gmtime(),
    	));
    	
    	RC_Loader::load_app_class('goods_image_data', 'goods', false);
    	
    	/* 处理商品图片 */
    	$goods_img		= ''; // 初始化商品图片
    	$goods_thumb	= ''; // 初始化商品缩略图
    	$img_original	= ''; // 初始化原始图片
    	
    	$upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
    	$upload->add_saving_callback(function ($file, $filename) {
    	    return true;
    	});
    	
    	/* 是否处理商品图 */
    	$proc_goods_img = true;
    	if (isset($_FILES['goods_image']) && !$upload->check_upload_file($_FILES['goods_image'])) {
    		$proc_goods_img = false;
    	}
    	
    	if ($proc_goods_img) {
    		if (isset($_FILES['goods_image'])) {
    			$image_info = $upload->upload($_FILES['goods_image']);	
    		}	 
    	}
    	
    	/* 更新上传后的商品图片 */
    	if ($proc_goods_img) {
    		if (isset($image_info)) {
    			$goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
    			$goods_image->set_auto_thumb(true);
    			$result = $goods_image->update_goods();
    			if (is_ecjia_error($result)) {
    			    return $result;
    			}
    			$thumb_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
    			$result = $thumb_image->update_thumb();
    		}
    	}
    	
    	
    	/* 记录日志 */
    	if ($_SESSION['store_id'] > 0) {
    	    RC_Api::api('merchant', 'admin_log', array('text' => $goods_name.'【来源掌柜】', 'action' => 'edit', 'object' => 'goods'));
    	} else {
    	    ecjia_admin::admin_log(addslashes($goods_name).'【来源掌柜】', 'edit', 'goods'); // 记录日志
    	}
		
    	$today = RC_Time::gmtime();
    	$field = '*, (promote_price > 0 AND promote_start_date <= ' . $today . ' AND promote_end_date >= ' . $today . ')|is_promote';
    	$row = RC_Model::model('goods/goods_model')->field($field)->find(array('goods_id' => $goods_id));
    	
    	$brand_db = RC_Loader::load_app_model('brand_model', 'goods');
    	$category_db = RC_Loader::load_app_model('category_model', 'goods');
    		
    	$brand_name = $row['brand_id'] > 0 ? $brand_db->where(array('brand_id' => $row['brand_id']))->get_field('brand_name') : '';
    	$category_name = $category_db->where(array('cat_id' => $row['cat_id']))->get_field('cat_name');
    		
    	if (ecjia::config('shop_touch_url', ecjia::CONFIG_EXISTS)) {
    		$goods_desc_url = ecjia::config('shop_touch_url').'index.php?m=goods&c=index&a=init&id='.$id.'&hidenav=1&hidetab=1';
    	} else {
    		$goods_desc_url = null;
    	}
    	
    	$goods_detail = array(
    			'goods_id'	=> $row['goods_id'],
    			'name'		=> $row['goods_name'],
    			'goods_sn'	=> $row['goods_sn'],
    			'brand_name' 	=> $brand_name,
    			'category_name' => $category_name,
    			'market_price'	=> price_format($row['market_price'] , false),
    			'shop_price'	=> price_format($row['shop_price'] , false),
    			'is_promote'	=> $row['is_promote'],
    			'promote_price'	=> price_format($row['promote_price'], false),
    			'promote_start_date'	=> !empty($row['promote_start_date']) ? RC_Time::local_date('Y-m-d H:i:s', $row['promote_start_date']) : '',
    			'promote_end_date'		=> !empty($row['promote_end_date']) ? RC_Time::local_date('Y-m-d H:i:s', $row['promote_end_date']) : '',
    			'clicks'		=> intval($row['click_count']),
    			'stock'			=> (ecjia::config('use_storage') == 1) ? $row['goods_number'] : '',
    			'goods_weight'	=> $row['goods_weight']  = (intval($row['goods_weight']) > 0) ?
    			$row['goods_weight'] . __('千克') :
    			($row['goods_weight'] * 1000) . __('克'),
    			'is_promote'	=> $row['is_promote'],
    			'is_best'		=> $row['is_best'],
    			'is_new'		=> $row['is_new'],
    			'is_hot'		=> $row['is_hot'],
    			'is_shipping'	=> $row['is_shipping'],
    			'is_on_sale'	=> $row['is_on_sale'],
    			'is_alone_sale' => $row['is_alone_sale'],
    			'last_updatetime' => RC_Time::local_date(ecjia::config('time_format'), $row['last_update']),
    			'goods_desc' 	=> '',
    				
    			'img' => array(
    					'thumb'	=> !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : '',
    					'url'	=> !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : '',
    					'small'	=> !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : '',
    			),
    			'unformatted_shop_price'	=> $row['shop_price'],
    			'unformatted_market_price'	=> $row['market_price'],
    			'unformatted_promote_price'	=> $row['promote_price'],
    			'give_integral'				=> $row['give_integral'],
    			'rank_integral'				=> $row['rank_integral'],
    			'integral'					=> $row['integral'],
    			'sales_volume'				=> $row['sales_volume'],
    	);
    	
    	RC_Loader::load_app_func('admin_user', 'user');
    		
    	$goods_detail['user_rank'] = array();
    		
    	$discount_price = get_member_price_list($goods_id);
    	$user_rank = get_user_rank_list();
    	if(!empty($user_rank)){
    		foreach ($user_rank as $key => $value){
    			$goods_detail['user_rank'][] = array(
    					'rank_id'	 => $value['rank_id'],
    					'rank_name'	 => $value['rank_name'],
    					'discount'	 => $value['discount'],
    					'price'		 => !empty($discount_price[$value['rank_id']]) ? $discount_price[$value['rank_id']] : '-1',
    			);
    		}
    	}
    	$goods_detail['volume_number'] = array();
    	$volume_number = '';
    	$volume_number = get_volume_price_list($goods_id);
    	
    	if(!empty($volume_number)) {
    		foreach ($volume_number as $key=>$value) {
    			$goods_detail['volume_number'][] =array(
    					'number'	=> $value['number'],
    					'price'		=> $value['price']
    			);
    		}
    	}
    	
    	$goods_detail['pictures'] = array();
    	
    	return $goods_detail;
    }
    	 
}