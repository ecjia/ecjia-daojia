<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class users_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'users';
        $this->table_alias_name = 'u';

        $this->view = array(
            'order_info' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'oi',
                'on' => 'u.user_id = oi.user_id'
            ),
            'adviser' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'ad',
                'on' => 'u.adviser_id = ad.id'
            ),
        );
        parent::__construct();
    }

}

// end