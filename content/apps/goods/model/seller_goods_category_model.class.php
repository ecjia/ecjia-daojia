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

class seller_goods_category_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'seller_goods_category';
		parent::__construct();
	}
	
	/**
	 * 检查分类是否已经存在
	 *
	 * @param   string      $cat_name       分类名称
	 * @param   integer     $parent_cat     上级分类
	 * @param   integer     $exclude        排除的分类ID
	 *
	 * @return  boolean
	 */
	public function cat_exists($cat_name, $parent_cat, $exclude = 0, $seller_id) {
		return ($this->where(array('parent_id' => $parent_cat, 'cat_name' => $cat_name, 'seller_id' => $seller_id,'cat_id' => array('neq' => $exclude)))->count() > 0) ? true : false;
	}
	
	/**
	 * 获得商品类型的列表
	 *
	 * @access  public
	 * @param   integer     $selected   选定的类型编号
	 * @return  string
	 */
	public function goods_type_list($selected) {
		$db = RC_Model::model('goods/goods_type_model');
		$data = $db->field('cat_id, cat_name')->where(array('enabled' => 1))->select();
	
		$lst = '';
		if (!empty($data)) {
			foreach ($data as $row){
				$lst .= "<option value='$row[cat_id]'";
				$lst .= ($selected == $row['cat_id']) ? ' selected="true"' : '';
				$lst .= '>' . htmlspecialchars($row['cat_name']). '</option>';
			}
		}
		return $lst;
	}
	
	/**
	 * 获取属性列表
	 *
	 * @access  public
	 * @param
	 *
	 * @return void
	 */
	public function get_category_attr_list() {
		$db = RC_Model::model('goods/attribute_goods_viewmodel');
		$arr = $db->join('goods_type')->where("gt.enabled = 1")->order(array('a.cat_id' => 'asc','a.sort_order' => 'asc'))->select();
	
		$list = array();
	
		foreach ($arr as $val) {
			if (!empty($val['cat_id'])) {
				$list[$val['cat_id']][] = array($val['attr_id']=>$val['attr_name']);
			}
		}
	
		return $list;
	}
	
	/**
	 * 插入首页推荐扩展分类
	 *
	 * @access  public
	 * @param   array   $recommend_type 推荐类型
	 * @param   integer $cat_id     分类ID
	 *
	 * @return void
	 */
	public function insert_cat_recommend($recommend_type, $cat_id) {
		$db = RC_Model::model('goods/cat_recommend_model');
		/* 检查分类是否为首页推荐 */
		if (!empty($recommend_type)) {
			/* 取得之前的分类 */
			$recommend_res = $db->field('recommend_type')->where(array('cat_id' => $cat_id))->select();
			if (empty($recommend_res)) {
				foreach($recommend_type as $data) {
					$data = intval($data);
					$query = array(
							'cat_id' 			=> $cat_id,
							'recommend_type' 	=> $data
					);
					$db->insert($query);
				}
			} else {
				$old_data = array();
				foreach($recommend_res as $data) {
					$old_data[] = $data['recommend_type'];
				}
				$delete_array = array_diff($old_data, $recommend_type);
				if (!empty($delete_array)) {
					$db->where(array('cat_id' => $cat_id))->in(array('recommend_type' => $delete_array))->delete();
				}
				$insert_array = array_diff($recommend_type, $old_data);
				if (!empty($insert_array)) {
					foreach($insert_array as $data) {
						$data = intval($data);
						$query = array(
								'cat_id'          => $cat_id,
								'recommend_type'  => $data
						);
						$db->insert($query);
					}
				}
			}
		} else {
			$db->where(array('cat_id' => $cat_id))->delete();
		}
	}
	

	/**
	 * 添加类目证件标题
	 * @param unknown $dt_list
	 * @param int $cat_id
	 * @param array $dt_id
	 */
	public function get_documentTitle_insert_update($dt_list, $cat_id, $dt_id = array()){
		$db_merchants_documenttitle = RC_Model::model('goods/merchants_documenttitle_model');
	
		for($i=0; $i<count($dt_list); $i++){
	
			$dt_list[$i] = trim($dt_list[$i]);
	
			$catId = $db_merchants_documenttitle->where(array('dt_id'=>$dt_id[$i]))->get_field('cat_id');
	
			if(!empty($dt_list[$i])){
				$parent = array(
						'cat_id' 		=> $cat_id,
						'dt_title' 		=> $dt_list[$i]
				);
	
				if($catId > 0){
					$db_merchants_documenttitle->where(array('dt_id'=>$dt_id[$i]))->update($parent);
				}else{
					$db_merchants_documenttitle->insert($parent);
				}
			}else{
				if($catId > 0){
					//删除二级类目表数据
					$db_merchants_documenttitle->where(array('dt_id'=>$dt_id[$i],'user_id'=>$_SESSION['ru_id']))->delete();
				}
			}
		}
	}
	
	/**
	 * 获取属性列表
	 *
	 * @return  array
	 */
	function get_attr_list() {
		$dbview  = RC_Model::model('goods/attribute_goods_viewmodel');
		/* 查询条件 */
		$filter = array();
		$filter['cat_id'] = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
		$filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'sort_order' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'asc' : trim($_REQUEST['sort_order']);
		
		$where = (!empty($filter['cat_id'])) ? " a.cat_id = '$filter[cat_id]' " : '';
		$count = $dbview->join(null)->where($where)->count();
	
		/* 加载分页类 */
		RC_Loader::load_sys_class('ecjia_page', false);
		$page = new ecjia_page($count, 15, 5);
	
		/* 查询 */
		$dbview->view =array(
			'goods_type' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 't',
				'field' => 'a.*, t.cat_name',
				'on'    => 'a.cat_id = t.cat_id'
				)
			);
		$row = $dbview->join('goods_type')->where($where)->order(array($filter['sort_by']=>$filter['sort_order']))->limit($page->limit())->select();
	
		if(!empty($row)) {
			foreach ($row AS $key => $val) {
				// $row[$key]['attr_input_type_desc'] = RC_Lang::get("goods::goods.value_attr_input_type.".$val[attr_input_type]);//暂时注释2016-07-08
				$row[$key]['attr_values'] = str_replace("\n", ", ", $val['attr_values']);
			}
		}
	
		return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
	
	/**
	 * 获得商品分类的所有信息
	 *
	 * @param   integer     $cat_id     指定的分类ID
	 *
	 * @return  mix
	 */
	public function get_cat_info($cat_id) {
		return $this->find(array('cat_id' => $cat_id));
	}
	
	
	/**
	 * 添加商品分类
	 *
	 * @param   integer $cat_id
	 * @param   array   $args
	 *
	 * @return  mix
	 */
	public function cat_update($cat_id, $args, $seller_id) {
		if (empty($args) || empty($cat_id)) {
			return false;
		}
	
		 $this->where(array('cat_id' => $cat_id, 'seller_id' => $seller_id))->update($args);
	}
	
	/**
	 * 保存某商品的扩展分类
	 *
	 * @param int $goods_id
	 *            商品编号
	 * @param array $cat_list
	 *            分类编号数组
	 * @return void
	 */
	function handle_other_cat($goods_id, $add_list)
	{
		/* 查询现有的扩展分类 */
		$db = RC_Model::model('goods/goods_cat_model');
	
		$db->where(array('goods_id' => $goods_id))->delete();
	
		if (!empty ($add_list)) {
			$data = array();
			foreach ($add_list as $cat_id) {
				// 插入记录
				$data[] = array(
						'goods_id'  => $goods_id,
						'cat_id'    => $cat_id
				);
			}
			$db->batch_insert($data);
		}

	}	
	
	/**
	 * 获取商家一级商品分类
	 * @param   string      $options   where条件
	 * @return  array()
	 */
	public function get_seller_goods_cat_ids($options) {
		$cat_ids = $this->where($options['where'])->field('cat_id')->select();
		return $cat_ids;
	}
	
	/**
	 * 获取商家一级商品分类名称
	 * @param   string      $options   where条件
	 * @return  array()
	 */
	public function get_seller_goods_cat_name($options) {
		$cat_ids = $this->where(array('cat_id' => $options['cat_id']))->get_field('cat_name');
		return $cat_ids;
	}
}

// end