<?php

defined('IN_ROYALCMS') or exit('No permission resources.');

class customer_viewmodel extends Component_Model_View {

    public $table_name = '';
    public $view = array();

    public function __construct() {
//         $this->db_config = RC_Config::load_config('database');
//         $this->db_setting = 'default';
        $this->table_name = 'customer';
        $this->table_alias_name = 'c';

        $this->view = array(
            'order_info' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'i',
                'on' => 'c.user_id = i.user_id'
            ),
            'order_goods' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'g',
                'on' => 'i.order_id=g.order_id'
            ),
            'service' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 's',
                'on' => 'c.user_id=s.user_id'
            ),
            'ticket' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 't',
                'on' => 'c.user_id=t.user_id'
            ),
            //得到ticket_sn
            'ticket_complain' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'tc',
                'on' => 'tc.ticket_id=t.ticket_id'
            ),
            'users' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'u',
                'on' => 'c.user_id=u.user_id'
            ),  
           'adviser' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,	
        		'alias' => 'ad',
        		'on' => 'ad.id=u.adviser_id'
        	),
            'region' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'p',
                'field' => "",
                'on' => 'c.province=p.region_id',
            ),
        	'admin_user' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'au',
        		'field' => "",
        		'on' => 'c.adder=au.user_id',
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
        	'customer_pool' => array(
       			'type' => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'cp',
        		'field' => "",
        		'on' => 'c.charge_man=cp.operateor and c.customer_id=cp.customer_id',
        	),
            'customer_share' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'cshare',
                'field' => "",
                'on' => 'c.customer_id = cshare.customer_id',
            ),
        	'customer_contract_doc' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'cd',
        		'field' => "",
     			'on' => 'c.customer_id = cd.customer_id',
        	),
        );
        parent::__construct();
    }

}

// end