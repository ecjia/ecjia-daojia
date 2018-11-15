<?php
/**
 * 用户模型
 */
defined('IN_ROYALCMS') or exit('No permission resources.');

class adviser_model extends Component_Model_Model {

    public $table_name = '';

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'adviser';
        parent::__construct();
    }

}

// end