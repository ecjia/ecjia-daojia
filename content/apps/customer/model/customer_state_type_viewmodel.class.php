<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_state_type_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer_state';
        $this->table_alias_name = 'cs';

        $this->view = array(
            'customer' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'c',
                'on' => 'cs.state_id = c.state_id'
            ),
        );
        parent::__construct();
    }

}

// end