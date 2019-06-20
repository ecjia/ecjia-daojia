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
 * 编辑商品的参数属性
 * @author zrl
 *
 */
class admin_merchant_goods_goodsattr_specification_update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
    	$result = $this->admin_priv('goods_manage');
        if (is_ecjia_error($result)) {
			return $result;
		}
    	
    	//请求参数：
    	$goods_id			= $this->requestData('goods_id', 0);
    	$specification_id		= $this->requestData('specification_id', 0);
    	$goods_attr_list	= $this->requestData('goods_attr_list', '');
    	
    	//$goods_attr_list = '[{"attr_id":885,"value_list":["150g"]},{"attr_id":952,"value_list":["珍珠"]},{"attr_id":953,"value_list":["简装"]},{"attr_id":954,"value_list":["国产"]}]';
    	
    	$goods_attr_list_array = json_decode($goods_attr_list, true);
    	
    	if (empty($goods_id) || empty($specification_id) || empty($goods_attr_list) || !is_array($goods_attr_list_array)) {
    	    return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'goods'), __CLASS__));
    	}
    	
    	if (!empty($goods_attr_list_array) && is_array($goods_attr_list_array)) {
    		foreach ($goods_attr_list_array as $val) {
    			if (empty($val['attr_id']) || !is_array($val['value_list'])) {
    				return new ecjia_error('attr_id_error', __('属性id参数错误或属性值参数错误', 'goods'));
    			}
    			$attr_ids[] = $val['attr_id'];
    			
    			$goods_attr_list_format[$val['attr_id']] = $val['value_list'];
    		}
    	}
    	
    	$GoodsBasicInfo = new Ecjia\App\Goods\Goods\GoodsBasicInfo($goods_id, $_SESSION['store_id']);
		$goods = $GoodsBasicInfo->goodsInfo();
    	if (empty($goods)) {
    		return new ecjia_error('not_exists_info', __('商品信息不存在！', 'goods'));
    	}
    	//商品已设置的属性信息
    	$goods_attr_list = Ecjia\App\Goods\Models\GoodsAttrModel::where('cat_type', 'specification')->where('goods_id', $goods_id)->get();
    	 
    	if ($goods_attr_list) {
    		foreach ($goods_attr_list as $val) {
    			$goods_attr_ids[] = $val['attr_id'];
    			$attr_values[] = $val['attr_value'];
    		}
    		$goods_attr_ids = array_merge($goods_attr_ids);
    	}
    	
    	//规格指定id属性列表
    	if (!empty($attr_ids)) {
    		$attribute_list = Ecjia\App\Goods\Models\AttributeModel::whereIn('attr_id', $attr_ids)->get();
    		$attribute_list = $attribute_list->toArray();
    		
    		foreach ($attribute_list as $row) {
    			$value_list = $goods_attr_list_format[$row['attr_id']];
    			
    			//修改的属性id商品已设置，则更新
    			if (in_array($row['attr_id'], $goods_attr_ids)) {
    				if (empty($value_list)) {
    					//当前属性值传的为空，移除商品已设置使用的
    					Ecjia\App\Goods\Models\GoodsAttrModel::where('cat_type', 'specification')->where('goods_id', $goods_id)->where('attr_id', $row['attr_id'])->delete();
    				} else {
    					foreach ($value_list as $v) {
    						//当前属性值未使用，录入新数据
    						if (!in_array($v, $attr_values)) {
    							if (!empty($v)) {
    								Ecjia\App\Goods\Models\GoodsAttrModel::insert([
	    								'cat_type'   => 'specification',
	    								'goods_id'   => $goods_id,
	    								'attr_id'    => $row['attr_id'],
	    								'attr_value' => $v,
    								]);
    							}
    						} else {
    							//当前属性值已使用，删除除去本身，其他未选用的
    							if (!empty($v)) {
    								Ecjia\App\Goods\Models\GoodsAttrModel::where('cat_type', 'specification')
    								->where('goods_id', $goods_id)
    								->where('attr_value', '!=', $v)
    								->where('attr_id', $row['attr_id'])->delete();
    							}
    						}
    					}
    				}
    			} else {
    				//修改的属性id商品未设置，则录入新数据
    				if (!empty($value_list)) {
    					foreach ($value_list as $v) {
    						if (!empty($v)) {
    							Ecjia\App\Goods\Models\GoodsAttrModel::insert([
	    							'cat_type'   => 'specification',
	    							'goods_id'   => $goods_id,
	    							'attr_id'    => $row['attr_id'],
	    							'attr_value' => $v,
    							]);
    						}
    					}
    				}
    			}
    		}
    	}
    	
    	//更新商品绑定的参数模板
    	Ecjia\App\Goods\Models\GoodsModel::where('goods_id', $goods_id)->update(array('specification_id'  => $specification_id));
    	
    	//返回数据
    	$result = $this->get_goods_binded_spe_template($specification_id, $goods_id);
    	
    	return $result;
    	
    }
    
    /**
     * 商品绑定的规格模板信息
     */
    private function get_goods_binded_spe_template($template_id, $goods_id)
    {
    	$GoodsBasicInfo = new Ecjia\App\Goods\Goods\GoodsBasicInfo($goods_id, $_SESSION['store_id']);
    	$goods = $GoodsBasicInfo->goodsInfo();
    	
    	//商品是否有设置规格属性
    	if ($goods->goods_attr_collection) {
    		$has_specification_attr = 'yes';
    	} else {
    		$has_specification_attr = 'no';
    	}
    	
    	//绑定的规格模板信息
    	$spe_template_info = Ecjia\App\Goods\Models\GoodsTypeModel::where('cat_id', $template_id)->first();
    	//获取规格属性
    	$specification_attributes = $this->get_specification_attributes($spe_template_info, $goods_id);
    	//货品列表
    	$product_list = $GoodsBasicInfo->goodsProducts();
    		
    	if (!empty($product_list)) {
    		$product_list = $this->format_product_list($product_list);
    	} else {
    		$product_list = [];
    	}
    		
    	$result = [
	    	'goods_isbind_specification' 	=> 'yes',
	    	'has_specification_attr'		=> $has_specification_attr,
	    	'specification_template_info'	=> ['specification_id' => intval($spe_template_info->cat_id), 'specification_name' => $spe_template_info->cat_name],
	    	'specification_attributes'		=> $specification_attributes,
	    	'product_list'					=> $product_list,
    	];
    	
    	return $result;
    }
    
    /**
     *
     * @param object $spe_template_info
     * @param int $goods_id
     * @return array
     */
    private function get_specification_attributes($spe_template_info, $goods_id)
    {
    	$spe_attr_list = [];
    	if ($spe_template_info->attribute_collection) {
    		$attribute_collection = $spe_template_info->attribute_collection->where('attr_values', '!=', '');
    		$spe_attr_list = $attribute_collection->map(function ($item) use ($goods_id) {
    			//属性form表单展现形式
    			$attr_form_type = 'checkbox';
    			$attr_values = !empty($item->attr_values) ? explode(',', str_replace("\n", ",", $item->attr_values)) : [];
    			 
    			$goods_attr_values = [];
    			if ($item->goods_attr_collection) {
    				$goods_attr_value = $item->goods_attr_collection->where('goods_id', $goods_id)->where('attr_value', '!=', '');
    
    				if ($goods_attr_value) {
    					$goods_attr_values = $goods_attr_value->map(function($g_attr_val) use ($item) {
    						$arr = $g_attr_val->attr_value;
    						return $arr;
    					});
    					$goods_attr_values = $goods_attr_values->toArray();
    				}
    			}
    
    			$attr_list = [
    			'attr_id' 			=> intval($item->attr_id),
    			'attr_name'			=> trim($item->attr_name),
    			'attr_form_type'	=> $attr_form_type,
    			'attr_values'		=> $attr_values,
    			'goods_attr_value'	=> array_merge($goods_attr_values)
    			];
    			return $attr_list;
    		});
    		$spe_attr_list = $spe_attr_list->toArray();
    	}
    	 
    	return $spe_attr_list;
    }
    
    
    private function format_product_list($product_list)
    {
    	$products = [];
    	if (!empty($product_list)) {
    		foreach ($product_list as $row) {
    			$products[] = [
    			'product_id' 					=> intval($row['product_id']),
    			'goods_id'	 					=> intval($row['goods_id']),
    			'goods_attr'					=> trim($row['goods_attr']),
    			'product_sn'					=> trim($row['product_sn']),
    			'product_number'				=> intval($row['product_number']),
    			'product_attr_value'			=> trim($row['product_attr_value']),
    			'product_bar_code'				=> empty($row['product_bar_code']) ? '' : $row['product_bar_code'],
    			'product_shop_price'			=> $row['product_shop_price'],
    			'formatted_product_shop_price'	=> $row['formatted_product_shop_price']
    			];
    		}
    	}
    	return $products;
    }
    
}