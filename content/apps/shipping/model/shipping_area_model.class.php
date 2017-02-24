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

class shipping_area_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'shipping_area';
		parent::__construct();
	}
	
	/**
	 *  获取配送区域列表
	 */
	public function get_shipareas_list($args = array()){
		$db_shipping_area = RC_DB::table('shipping_area');
		/* 过滤条件  为查询*/
		$filter['keywords'] = empty($args['keywords']) ? '' : trim($args['keywords']);
		
		if ($args['shipping_id']) {
		    $db_shipping_area->where('shipping_id', $args['shipping_id']);
		}
		if ($filter['keywords']) {
			$db_shipping_area->where('shipping_area_name', 'like', '%'. mysql_like_quote($filter['keywords']). '%');
		}
		
		isset($_SESSION['store_id']) ? $db_shipping_area->where(RC_DB::raw('store_id'), $_SESSION['store_id']) : '';
		
		$count = $db_shipping_area->count();
		$page = new ecjia_page($count, 10, 6);

		/* 查询所有配送方式信息  */
		$shipping_areas_list = array();
		$list = $db_shipping_area->take(10)->skip($page->start_id-1)->get();
		
		if (!empty($list)) {
			foreach ($list as $row) {
				$db_region = RC_Model::model('shipping/shipping_area_region_viewmodel');
				$region_names = RC_DB::table('area_region')->leftJoin('region', 'region.region_id', '=', 'area_region.region_id')
						->where('area_region.shipping_area_id', $row['shipping_area_id'])
						->select('region.region_name')->get();
				if (is_array($region_names) && count($region_names)>0 ) {
					$region_array = array();
					foreach ($region_names as $name) {
						//如果所对应的区域已在区域列表设置中被删除
						if( empty($name['region_name']) ) {
							$region_array[] = '<lable  style="color:red">' .RC_Lang::get('shipping::shipping_area.removed_region'). '</lable>';
						} else{
							$region_array[] = $name['region_name'];
						}
					}
					$regions = implode(',', $region_array);
				}
					
				$row['shipping_area_regions'] = empty($regions) ? '<lable  style="color:red">' .RC_Lang::get('shipping::shipping_area.empty_regions'). '</lable>': $regions;
				$shipping_areas_list[] = $row;
			}
		}
			
		$filter['keywords'] = stripslashes($filter['keywords']);
		return array('areas_list' => $shipping_areas_list, 'filter' => $filter, 'page' => $page->show(10), 'desc' => $page->page_desc());
	}
	
	public function is_only($where) {
		$db_shipping_area = RC_DB::table('shipping_area');
		if(!empty($where)){
			foreach($where as $key => $val){
				if (is_array($val)){
					foreach($val as $k => $v){
						if ($k == 'neq'){
							$db_shipping_area->where($key, '!=', $v);
						}
					}
				}else{
					$db_shipping_area->where($key, $val);
				}
			}
		}
		return $db_shipping_area->count();
	}
	
	public function shipping_area_find($where, $field='*') {
		$db_shipping_area = RC_DB::table('shipping_area');
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				$db_shipping_area->where($key, $val);
			}
		}
		return $db_shipping_area->select($field)->first();
	}
	
	public function shipping_area_manage($parameter) {
		if (!isset($parameter['shipping_area_id'])){
			$id = RC_DB::table('shipping_area')->insertGetId($parameter);
		}else{
			RC_DB::table('shipping_area')->where('shipping_area_id', $parameter['shipping_area_id'])->update($parameter);
			$id = $parameter['shipping_area_id'];
		}
		return $id;
	}
	
	public function shipping_area_field($where, $field) {
		$db_shipping_area = RC_DB::table('shipping_area');
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				$db_shipping_area->where($key, $val);
			}
		}
		return $db_shipping_area->pluck($field);
	}
	
	public function shipping_area_remove($where) {
		$db_shipping_area = RC_DB::table('shipping_area');
		if (!empty($where)) {
			foreach ($where as $key => $val){
				$db_shipping_area->where($key, $val);
			}
		}
		return $db_shipping_area->delete();
	}
	
	public function shipping_area_batch($where, $type) {
		$db_shipping_area = RC_DB::table('shipping_area');
		if ($type == 'select') {
			foreach($where as $key => $val){
				$db_shipping_area->whereIn($key, $val);
			}
			return $db_shipping_area->get();
		} elseif ($type == 'delete') {
			foreach ($where as $key => $val) {
				$db_shipping_area->whereIn($key, $val);
			}
			return $db_shipping_area->delete();
		}
	}
}

// end