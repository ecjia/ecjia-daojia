<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_feedback_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer_feedback';
        $this->table_alias_name = 'cf';

        $this->view = array(
            'customer' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'c',
                'on' => 'cf.customer_id = c.customer_id'
            ),
        	'admin_user' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'au',
      			'on' => 'au.user_id = cf.adder'
        	),
        	'customer_contact_type' => array(
      			'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'ct',
       			'on' => 'cf.link_type = ct.type_id'
        	),
        	'customer_contact_way' => array(
       			'type' => Component_Model_View::TYPE_LEFT_JOIN,
      			'alias' => 'cw',
        		'on' => 'cf.type = cw.way_id'
        	),
        	'customer_linkman' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'cl',
      			'on' => 'cl.link_id = cf.link_man'
        	),
        	'customer_state' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'cs',
      			'field' => "",
        		'on' => 'cs.state_id=c.state_id',
        	),
        	'customer_source' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'co',
     			'field' => "",
        		'on' => 'co.source_id=c.source_id',
        	),
        );
        parent::__construct();
    }

}

// end