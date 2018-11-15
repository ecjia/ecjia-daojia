<?php
/**
 * 客户model(省市级联动)
 */
defined('IN_ECJIA') or exit('No permission resources.');

class customer_province_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer';
        $this->table_alias_name = 'c';

        $this->view = array(
            'region' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'p',
                'field' => "",
                'on' => 'c.province=p.region_id',
            ),
        );
        parent::__construct();
    }

}

// end