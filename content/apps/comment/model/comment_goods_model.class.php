<?php
defined('IN_ECJIA') or exit('No permission resources.');

class comment_goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
// 		$this->db_config = RC_Config::load_config('database');
// 		$this->db_setting = 'default';
		$this->table_name = 'goods';
		parent::__construct();
	}
	
	/* 查询字段信息 */
	public function goods_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
}