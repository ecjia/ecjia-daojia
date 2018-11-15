<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_contact_way_model extends Component_Model_Model {

    public $table_name = '';

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer_contact_way';
        parent::__construct();
    }

}
