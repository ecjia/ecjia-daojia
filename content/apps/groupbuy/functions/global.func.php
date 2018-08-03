<?php
defined('IN_ROYALCMS') or exit('No permission resources.');

/* 取得团购活动总数 */
function group_buy_count()
{
	$db = RC_Loader::load_app_model('goods_activity_model','goods');
    $now = RC_Time::gmtime();
//     $sql = "SELECT COUNT(*) " .
//             "FROM " . $GLOBALS['ecs']->table('goods_activity') .
//             "WHERE act_type = '" . GAT_GROUP_BUY . "' " .
//             "AND start_time <= '$now' AND is_finished < 3";

//     return $GLOBALS['db']->getOne($sql);

    return $db->where('act_type = "' . GAT_GROUP_BUY . '" AND start_time <= '.$now.' AND is_finished < 3')->count();
}

/**
 * 取得某页的所有团购活动
 * @param   int     $size   每页记录数
 * @param   int     $page   当前页
 * @return  array
 */
function group_buy_list($size, $page)
{
	$db = RC_Loader::load_app_model('goods_activity_viewmodel','goods');
    /* 取得团购活动 */
    $gb_list = array();
    $now = RC_Time::gmtime();
//     $sql = "SELECT ga.*, IFNULL(g.goods_thumb, '') AS goods_thumb, ga.act_id AS group_buy_id, ".
//                 "ga.start_time AS start_date, ga.end_time AS end_date " .
//             "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS ga " .
//                 "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id " .
//             "WHERE ga.act_type = '" . GAT_GROUP_BUY . "' " .
//             "AND ga.start_time <= '$now' AND ga.is_finished < 3 ORDER BY ga.act_id DESC";
//     $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    $db->view =array(
    		'goods' => array(
    				'type' =>Component_Model_View::TYPE_LEFT_JOIN,
    				'alias' => 'g',
    				'field' => "ga.*, IFNULL(g.goods_thumb, '') AS goods_thumb, ga.act_id AS group_buy_id,ga.start_time AS start_date, ga.end_time AS end_date",
    				'on' => 'ga.goods_id = g.goods_id'
    		)
    );
   
    $data = $db->where('ga.act_type = "' . GAT_GROUP_BUY . '" AND ga.start_time <= '.$now.' AND ga.is_finished < 3')->order(array('ga.act_id'=>'DESC'))->limit(($page - 1) * $size ,$size)->select();
    
//     while ($group_buy = $GLOBALS['db']->fetchRow($res))
    if(!empty($data))
    {
    foreach ($data as $group_buy)
    {
        $ext_info = unserialize($group_buy['ext_info']);
        $group_buy = array_merge($group_buy, $ext_info);

        /* 格式化时间 */
        $group_buy['formated_start_date']   = RC_Time::local_date($GLOBALS['_CFG']['time_format'], $group_buy['start_date']);
        $group_buy['formated_end_date']     = RC_Time::local_date($GLOBALS['_CFG']['time_format'], $group_buy['end_date']);

        /* 格式化保证金 */
        $group_buy['formated_deposit'] = price_format($group_buy['deposit'], false);

        /* 处理价格阶梯 */
        $price_ladder = $group_buy['price_ladder'];
        if (!is_array($price_ladder) || empty($price_ladder))
        {
            $price_ladder = array(array('amount' => 0, 'price' => 0));
        }
        else
        {
            foreach ($price_ladder as $key => $amount_price)
            {
                $price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
            }
        }
        $group_buy['price_ladder'] = $price_ladder;

        /* 处理图片 */
        if (empty($group_buy['goods_thumb']))
        {
            $group_buy['goods_thumb'] = get_image_path($group_buy['goods_id'], $group_buy['goods_thumb'], true);
        }
        //TODO: 去除路径修改
        //添加图片路径处理
        $group_buy['goods_thumb'] = 'content/uploads/goods'.substr($group_buy['goods_thumb'],strpos($group_buy['goods_thumb'], '/'));
        /* 处理链接 */
        $group_buy['url'] = build_uri('group_buy', array('gbid'=>$group_buy['group_buy_id']));
        /* 加入数组 */
        $gb_list[] = $group_buy;
    }
    }
// echo '<pre>';print_r($gb_list);die;
    return $gb_list;
}
// end