<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_exists_fields_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer_exists_fields';
        $this->table_alias_name = 'cef';

        $this->view = array(
            'customer_fields' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'cf',
                'on' => 'cef.exists_fields_id = cf.field_id'
            )
        );
        parent::__construct();
    }

}

// end