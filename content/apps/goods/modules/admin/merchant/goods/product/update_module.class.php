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
 * 编辑商品货品
 * @author zrl
 *
 */
class admin_merchant_goods_product_update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		$result = $this->admin_priv('goods_manage');
		if (is_ecjia_error($result)) {
		    return $result;
		}
    	
    	$goods_id			= intval($this->requestData('goods_id'));
    	$product_id			= intval($this->requestData('product_id', 0)); 	//货品id
    	$product_name		= trim($this->requestData('product_name', 0)); 	//货品名称
    	$product_shop_price	= $this->requestData('product_shop_price', 0);	//货品价格
    	$product_bar_code	= $this->requestData('product_bar_code', 0);	//货品条形码
    	$stock				= intval($this->requestData('stock', 0));
    	
    	if (empty($goods_id) || empty($product_id)) {
    	    return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'goods'), __CLASS__));
    	}
    	
    	//商品信息
    	$GoodsBasicInfo = new Ecjia\App\Goods\Goods\GoodsBasicInfo($goods_id, $_SESSION['store_id']);
    	$goods = $GoodsBasicInfo->goodsInfo();
    	if (empty($goods)) {
    		return new ecjia_error('not_exist_info', __('商品信息不存在', 'goods'));
    	}
    	
    	$ProductBasicInfo = new Ecjia\App\Goods\Goods\ProductBasicInfo($product_id, $goods_id);
    	$product = $ProductBasicInfo->productInfo();
    	 
    	if (empty($product)) {
    		return new ecjia_error('product_not_exist_info', __('未检测到此货品', 'goods'));
    	}
    	
    	$use_storage = ecjia::config('use_storage');
    	$product_number = empty($stock)  ? (empty($use_storage) ? 0 : ecjia::config('default_storage')) : $stock; //库存
    	   
    	
    	$update_data = [
    		'product_shop_price' 	=>	$product_shop_price,
    		'product_number'		=>  $product_number,
    	];
    	if (!empty($product_name)) {
    		$update_data['product_name'] = $product_name;
    	}
    	
    	//兼容货品添加时未添加store_id情况
    	RC_DB::table('products')->where('product_id', $product_id)->update(['store_id' => $_SESSION['store_id']]);
    	
    	if (!empty($product_bar_code)) {
    		$update_data['product_bar_code'] = $product_bar_code;
    		$bar_code_count = RC_DB::table('products')->where('store_id', $_SESSION['store_id'])->where('product_id', '!=', $product_id)->where('product_bar_code', $product_bar_code)->count();
    		if (!empty($bar_code_count)) {
    			return new ecjia_error('product_bar_code_error', __('货品条形码已存在，请更换一个', 'goods'));
    		}
    		//货品条形码不可与主商品条形码一致
    		$g_bar_code_count = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_barcode', $product_bar_code)->count();
    		if ($g_bar_code_count > 0) {
    			return $this->showmessage(__('当前货品条形码已存在商品条形码中，请修改', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    	}
    	
    	//货品图片上传
    	if (isset($_FILES['product_image'])) {
    		$upload_result = $this->processProductImage($_FILES['product_image'], $goods_id, $product_id);
    		if (is_ecjia_error($upload_result)) {
    			return $upload_result;
    		}
    	}
    	
    	if (!empty($update_data)) {
    		Ecjia\App\Goods\Models\ProductsModel::where('goods_id', $goods_id)->where('product_id', $product_id)->update($update_data);
    	}
    	
    	return [];
    }
    
    
    /**
     * 普通商品主图上传
     * @param file $file_goods_image
     * @param int $goods_id
     * @return boolean|ecjia_error
     */
    private function processProductImage($file_product_image, $goods_id, $product_id)
    {
    	RC_Loader::load_app_class('product_image_data', 'goods', false);
    
    	$upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
    	$upload->add_saving_callback(function ($file, $filename) {
    		return true;
    	});
    		 
    	/* 是否处理商品图 */
    	$proc_goods_img = true;
    	if (isset($file_product_image) && !$upload->check_upload_file($file_product_image)) {
    		$proc_goods_img = false;
    	}
    		 
    	if ($proc_goods_img) {
    		if (isset($file_product_image)) {
    			$image_info = $upload->upload($file_product_image);
    			if (empty($image_info)) {
    				return new ecjia_error('upload_error', $upload->error());
    			}
    		}
    	}

    	/* 更新上传后的商品图片 */
    	if ($proc_goods_img) {
    		if (isset($image_info)) {
    			$goods_image = new product_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id, $product_id);
    			$goods_image->set_auto_thumb(true);
    			$result = $goods_image->update_goods();
    			if (is_ecjia_error($result)) {
    				return $result;
    			}
    			$thumb_image = new product_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id, $product_id);
    			$result = $thumb_image->update_thumb();
    		}
    	}
    		 
    	return true;
    }
}
