<?php

/**
 * ECSHOP 地区切换程序
 */
defined('IN_ROYALCMS') or exit('No permission resources.');
RC_Loader::load_sys_class('ecjia_admin', null, false);

class region extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();
        
    }
    public function init()
    {
    	RC_Loader::load_app_func('area_select');        
        $type = ! empty($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
        $parent = ! empty($_REQUEST['parent']) ? intval($_REQUEST['parent']) : 0;
        
        $regions = get_regions($type, $parent);
        $regions = !empty($regions)? $regions: array();
        
        $arr['regions'] = json_decode(json_encode($regions));
        $arr['type'] = $type;
        $arr['target'] = ! empty($_REQUEST['target']) ? stripslashes(trim($_REQUEST['target'])) : '';
        $arr['target'] = htmlspecialchars($arr['target']);
        
        echo json_encode($arr);
    }
}

// end