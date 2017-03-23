<?php
defined('IN_ECJIA') or exit('No permission resources.');

class comment_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
// 		$this->db_config = RC_Config::load_config('database');
// 		$this->db_setting = 'default';
		$this->table_name = 'comment';
		$this->table_alias_name = 'c';
		
		//添加视图选项，方便调用
		$this->view = array(
			'comment' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN, 
				'alias'	=> 'r',
// 				'field' => 'c.*, g.goods_name AS cmt_name, r.content AS reply_content, r.add_time AS reply_time',
				'on' 	=> 'r.parent_id = c.comment_id AND r.parent_id > 0', 
			),
			'goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'g',
				'on'	=> 'c.comment_type=0 AND c.id_value = g.goods_id',
			),
		    'article' => array(
		        'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias'	=> 'a',
// 		        'field' => 'c.*,a.title as comment_name',
		        'on'	=> 'c.id_value = a.article_id',
		    )
		);
		parent::__construct();
	}
	
	public function comment_count($option) {
		return $this->join($option['table'])->where($option['where'])->count();
	}

	/* 评论查询 */
	public function comment_select($option) {
		return $this->join($option['table'])->field($option['field'])->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
}

// end