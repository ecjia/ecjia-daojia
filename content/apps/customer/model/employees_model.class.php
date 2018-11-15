<?php
defined('IN_ECJIA') or exit('No permission resources.');
class employees_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
// 		$this->db_config = RC_Config::load_config('database');
// 		$this->db_setting = 'ecmoban-crm';
		$this->table_name = 'employees';
		parent::__construct();
	}
}

// end