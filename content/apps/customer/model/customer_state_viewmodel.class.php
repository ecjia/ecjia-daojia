<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_state_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer_state';
        $this->table_alias_name = 'cs';

        $this->view = array(
            'admin_user' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'au',
                'on' => 'au.user_id = cs.adder'
            ),
        );
        parent::__construct();
    }

}

// end