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
 * 添加参数模板的参数属性
 * @author zrl
 *
 */
class admin_merchant_goods_parameter_attribute_add_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$parameter_id		= intval($this->requestData('parameter_id', 0));
		$attr_name			= trim($this->requestData('attr_name', ''));
		$group_name			= trim($this->requestData('group_name', '')); 			//参数属性分组名称
		$attr_type			= intval($this->requestData('attr_type', 0));			//参数属性值类型（0唯一参数，2复选参数）
		$attr_input_type	= intval($this->requestData('attr_input_type', 0));		//参数属性值录入方式（0手工录入，1从列表中选择，2多行文本框） //类型为复选2时，值的录入方式默认是选择输入1
		$attr_values		= $this->requestData('attr_values', []);				//参数属性可选值列表
		
		$store_id 			= $_SESSION['store_id'];

		if (empty($parameter_id)) {
			return new ecjia_error('parameter_error', __('请选择所属参数模板！', 'goods'));
		}
		if (empty($attr_name)) {
			return new ecjia_error('attr_name_error', __('请填写参数属性名称！', 'goods'));
		}
		//参数属性值类型是唯一参数且参数值录入方式是从下拉表中选择，则必须填写可选值列表；参数属性值类型是复选参数时，可选值列表需必填
		if (($attr_type === 0 && $attr_input_type === 1) || ($attr_type === 2)) {
			if (!is_array($attr_values) || empty($attr_values)) {
				return new ecjia_error('attr_values_error', __('请填写参数属性可选值列表！', 'goods'));
			}
		}
		//参数属性分组名称处理
		$parameter_info = Ecjia\App\Goods\Models\GoodsTypeModel::where('cat_id', $parameter_id)->where('cat_type', 'parameter')->where('store_id', $_SESSION['store_id'])->first();
		$parameter_group_arr = [];
		if (!empty($parameter_info->attr_group)) {
			$parameter_group_arr = explode("\n", $parameter_info->attr_group);
		}
		
		if (!empty($group_name)) {
			if (!in_array($group_name, $parameter_group_arr)) {
				$group_name = '';
			}
		}
		
		$format_attr_values = [];
		if (!empty($attr_values) && is_array($attr_values)) {
			$format_attr_values = implode("\n", $attr_values);
		}
		
		$data = [
			'cat_id' 			=> $parameter_id,
			'attr_name'			=> $attr_name,
			'attr_cat_type' 	=> 0, //属性类型，参数属性类型默认0
			'attr_input_type'	=> $attr_input_type, //下拉选择（参数可选值录入方式）
			'attr_type'			=> $attr_type, //参数可选值类型
		];
		if (!empty($format_attr_values)) {
			$data['attr_values'] = $format_attr_values;
		}
		if (!empty($group_name)) {
			$data['attr_group'] = $group_name;
		}
		
		$attr_id = Ecjia\App\Goods\Models\AttributeModel::insertGetId($data);
		
		if ($attr_id) {
			if ($attr_input_type === 0) {
				$label_attr_input_type = '手工录入';
			} elseif ($attr_input_type === 1) {
				$label_attr_input_type = '从列表中选择';
			} else {
				$label_attr_input_type = '多行文本框';
			}
			if ($attr_type === 0) {
				$label_attr_type = '唯一参数';
			} elseif ($attr_type === 2) {
				$label_attr_type = '复选参数';
			}
			 
			$detail = [
				'parameter_id' 	   		=> $parameter_id,
				'parameter_name'   		=> $parameter_info->cat_name,
				'parameter_group'  		=> $parameter_group_arr,
				'attr_id'		   		=> $attr_id,
				'attr_name'		   		=> $attr_name,
				'group_name'	   		=> $group_name,
				'attr_type'		   		=> $attr_type,
				'label_attr_type'  		=> $label_attr_type,
				'attr_input_type'  		=> $attr_input_type,
				'label_attr_input_type'	=> $label_attr_input_type,
				'attr_values'	   		=> $format_attr_values
			];
			return $detail;
		} else {
			return new ecjia_error('add_attr_fail', __('添加参数属性失败！', 'goods'));
		}
    }
}