<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_linkman_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer_linkman';
        $this->table_alias_name = 'cl';

        $this->view = array(
            'customer' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'c',
                'on' => 'cl.customer_id = c.customer_id'
            ),
        	'admin_user' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'au',
        		'on' => 'cl.adder = au.user_id'
        	),
        );
        parent::__construct();
    }

}

// end