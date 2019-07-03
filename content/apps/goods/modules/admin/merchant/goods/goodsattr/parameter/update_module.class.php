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
class admin_merchant_goods_goodsattr_parameter_update_module extends api_admin implements api_interface {
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
    	$parameter_id		= $this->requestData('parameter_id', 0);
    	$goods_attr_list	= $this->requestData('goods_attr_list', 0);
    	
    	//$goods_attr_list = '[{"attr_id":981,"value_list":[]}]';
    	
    	$goods_attr_list_array = json_decode($goods_attr_list, true);
    	
    	if (empty($goods_id) || empty($parameter_id) || empty($goods_attr_list) || !is_array($goods_attr_list_array)) {
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
    	
    	$goods = Ecjia\App\Goods\Models\GoodsModel::where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
    	if (empty($goods)) {
    		return new ecjia_error('not_exists_info', __('商品信息不存在！', 'goods'));
    	}
    	//商品已设置的属性ids
    	$goods_attr_ids = Ecjia\App\Goods\Models\GoodsAttrModel::where('cat_type', 'parameter')->where('goods_id', $goods_id)->lists('attr_id');
    	 
    	if ($goods_attr_ids) {
    		$goods_attr_ids = $goods_attr_ids->toArray();
    	}
    	
    	
    	//参数指定id属性列表
    	if (!empty($attr_ids)) {
    		$attribute_list = Ecjia\App\Goods\Models\AttributeModel::whereIn('attr_id', $attr_ids)->get();
    		$attribute_list = $attribute_list->toArray();
    		
    		foreach ($attribute_list as $row) {
    			$value_list = $goods_attr_list_format[$row['attr_id']];
    			
    			if ($row['attr_type'] == '2') {
    				if (in_array($row['attr_id'], $goods_attr_ids)) { //修改的属性id商品已设置，则删除已有的
    					Ecjia\App\Goods\Models\GoodsAttrModel::where('cat_type', 'parameter')->where('goods_id', $goods_id)->where('attr_id', $row['attr_id'])->delete();
    				}
    				//重新录入
    				if (!empty($value_list)) {
    					foreach ($value_list as $v) {
    						Ecjia\App\Goods\Models\GoodsAttrModel::insert([
	    						'cat_type' 		=> 'parameter',
	    						'goods_id' 		=> $goods_id,
	    						'attr_id' 		=> $row['attr_id'],
	    						'attr_value' 	=> empty($v) ? '' : $v,
    						]);
    					}
    				}
    			} else {
    				if (in_array($row['attr_id'], $goods_attr_ids)) { //修改的属性id商品已设置，则更新
    					//更新
    					if (!empty($value_list)) {
    						//参数值录入方式是多行文本，值处理
    						if ($row['attr_input_type'] == '2') {
    							$value_list = implode("\n", $value_list);
    						} else {
    							$value_list = empty($value_list) ? '' : $value_list['0'];
    						}
    					} else {
    						$value_list = empty($value_list) ? '' : $value_list['0'];
    					}
    					Ecjia\App\Goods\Models\GoodsAttrModel::where('cat_type', 'parameter')->where('goods_id', $goods_id)->where('attr_id', $row['attr_id'])->update(array('attr_value' => $value_list));
    				} else {
    					//修改的属性id商品未设置，则录入新数据
    					if ($row['attr_input_type'] == '2') {
    						$value_list = implode("\n", $value_list);
    					} else {
    						$value_list = empty($value_list) ? '' : $value_list['0'];
    					}
    					Ecjia\App\Goods\Models\GoodsAttrModel::insert([
	    					'cat_type' 		=> 'parameter',
	    					'goods_id' 		=> $goods_id,
	    					'attr_id' 		=> $row['attr_id'],
	    					'attr_value' 	=> $value_list,
    					]);
    				}
    			}
    		}
    	}
    	
    	//更新商品绑定的参数模板
    	Ecjia\App\Goods\Models\GoodsModel::where('goods_id', $goods_id)->update(array('parameter_id' => $parameter_id));
    	
    	//返回数据
    	$result = $this->get_goods_binded_template($parameter_id, $goods_id);
    	
    	return $result;
    	
    }
    
    /**
     * 商品绑定的参数模板信息
     */
    private function get_goods_binded_template($template_id, $goods_id)
    {
    	$pra_template_info = Ecjia\App\Goods\Models\GoodsTypeModel::where('cat_id', $template_id)->first();
    	$pra_attr_list = [];
    	
    	if ($pra_template_info->attribute_collection) {
    		$attribute_collection = $pra_template_info->attribute_collection;
    		$pra_attr_list = $attribute_collection->map(function ($item) use ($goods_id) {
    			//属性form表单展现形式
    			if ($item->attr_type == '2') {//参数可选值是复选参数时
    				$attr_form_type = 'checkbox';
    				$attr_values = !empty($item->attr_values) ? explode(',', str_replace("\n", ",", $item->attr_values)) : [];
    			} else {//参数可选值是唯一参数时
    				if ($item->attr_input_type == '0') {//该参数值的录入方式是手工录入时
    					$attr_form_type = 'input';
    					$attr_values = [];
    				} elseif ($item->attr_input_type == '1') {//该参数值的录入方式是从列表选择时
    					$attr_form_type = 'select';
    					$attr_values = !empty($item->attr_values) ? explode(',', str_replace("\n", ",", $item->attr_values)) : [];
    				} else {//该参数值的录入方式是多行文本框时
    					$attr_form_type = 'textarea';
    					$attr_values = [];
    				}
    			}
    			$goods_attr_values = [];
    			if ($item->goods_attr_collection) {
    				$goods_attr_value = $item->goods_attr_collection->where('goods_id', $goods_id)->where('attr_value', '!=', '');
    				$goods_attr_value = $goods_attr_value->toArray();
    				if ($goods_attr_value) {
    					if ($goods_attr_value) {
    						foreach ($goods_attr_value as $v) {
    							if ($item->attr_input_type == '2') {//参数值录入是多行文本时，商品属性值处理
    								$arr = explode(',', str_replace("\n", ",", $v['attr_value']));
    							} else {
    								$arr[] = $v['attr_value'];
    							}
    						}
    					}
    				}
    			}
    				
    			$attr_list = [
	    			'attr_id' 			=> intval($item->attr_id),
	    			'attr_name'			=> trim($item->attr_name),
	    			'attr_form_type'	=> $attr_form_type,
	    			'attr_values'		=> $attr_values,
	    			'goods_attr_value'	=> empty($arr) ? [] : $arr
    			];
    			return $attr_list;
    		});
    	
    			$pra_attr_list = $pra_attr_list->toArray();
    	}
    		
    	$result = [
    	'goods_isbind_parameter' 	=> 'yes',
    	'parameter_template_info'	=> ['parameter_id' => intval($pra_template_info->cat_id), 'parameter_name' => $pra_template_info->cat_name],
    	'parameter_attributes'		=> $pra_attr_list
    	];
    		
    	return $result;
    }
    
}