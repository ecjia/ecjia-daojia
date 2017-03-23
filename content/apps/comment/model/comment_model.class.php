<?php
defined('IN_ECJIA') or exit('No permission resources.');

class comment_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
// 		$this->db_config = RC_Config::load_config('database');
// 		$this->db_setting = 'default';
		$this->table_name = 'comment';
		parent::__construct();
	}
	
	public function comment_remove($where) {
	    return $this->delete($where);
	}
	
	public function comment_manage($parameter) {
	    if (!isset($parameter['comment_id'])) {
	        $id = $this->insert($parameter);
	    } else {
	        $where = array('comment_id' => $parameter['comment_id']);
	           
	        $this->where($where)->update($parameter);
	        $id = $parameter['comment_id'];
	    }
	    return $id;
	}
	
	public function comment_info($where, $field='*') {
	    if (is_array($where)) {
    	    foreach ($where as $key => $val) {
    	        $this->where($key, $val);
    	    }
        }
	    return $this->find();
	}
	
	public function comment_delete($where, $in=false) {
	    if ($in) {
	        return $this->in($where)->delete();
	    }
	    return $this->where($where)->delete();
	}
	
	public function comment_batch_update($where, $data) {
	    return $this->in($where)->update($data);
	}
}

// end