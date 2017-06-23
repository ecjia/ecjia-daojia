<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECMOBAN 公用函数库
 * ============================================================================
 * * 版权所有 上海商创网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecmoban.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: zhuo $
 * $Id: lib_ecmobanFunc.php 17217 2014-05-01 09:00:00Z zhuo $
*/

//IP地区名称 start
function get_ip_area_name($ip = '') {
	
    if ($ip == '') {
        $ip = '180.153.194.116'; //获取当前用户的ip real_ip()
    }

    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;  

    $Http = new Http();
    $data = $Http->doGet($url);//调用淘宝接口获取信息
    $str  = json_decode($data,true);

    if ($str['data']['county'] != '') { //市级
        $region = $str['data']['county'];
        $arr['county_level'] = 2;
    } else { //省级或特别行政区
        $region = $str['data']['region'];
        $arr['county_level'] = 1;
    }

    $area_name = str_replace(array('省', '市'), '', $region);

    if (strstr($area_name, '香港')) {
        $area_name = "香港";
    } elseif (strstr($area_name, '澳门')) {
        $area_name = "澳门";
    } elseif (strstr($area_name, '内蒙古')) {
        $area_name = "内蒙古";
    } elseif (strstr($area_name, '宁夏')) {
        $area_name = "宁夏";
    } elseif (strstr($area_name, '新疆')) {
        $area_name = "新疆";
    } elseif (strstr($area_name, '西藏')) {
        $area_name = "西藏";
    } elseif (strstr($area_name, '广西')) {
        $area_name = "广西";
    } elseif (strstr($area_name, '台湾')) {
    	$area_name = "台湾";
    }
    

    $arr['area_name'] = $area_name;

    return $arr; 
}
//IP地区名称 end

/**
 * 处理序列化的支付、配送的配置参数
 * 返回一个以name为索引的数组
 *
 * @access  public
 * @param   string       $cfg
 * @return  void
 */
function sc_unserialize_config($cfg) {
    if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {
        $config = array();

        foreach ($arr AS $key => $val) {
            $config[$val['name']] = $val['value'];
        }
        return $config;
    } else {
        return false;
    }
}

/**
 * 取得可用的配送方式列表
 * @param   array   $region_id_list     收货人地区id数组（包括国家、省、市、区）
 * @return  array   配送方式数组
 */
function sc_available_shipping_list($region_id_list) {
    $sql = 'SELECT s.shipping_id, s.shipping_code, s.shipping_name, ' .
                's.shipping_desc, s.insure, s.support_cod, a.configure ' .
            'FROM ' . $GLOBALS['ecs']->table('shipping') . ' AS s, ' .
                $GLOBALS['ecs']->table('shipping_area') . ' AS a, ' .
                $GLOBALS['ecs']->table('area_region') . ' AS r ' .
            'WHERE r.region_id ' . db_create_in($region_id_list) .
            ' AND r.shipping_area_id = a.shipping_area_id AND a.shipping_id = s.shipping_id AND s.enabled = 1 ORDER BY s.shipping_order';

    return $GLOBALS['db']->getAll($sql);
}

/**
 * 生成查询订单的sql
 * @param   string  $type   类型
 * @param   string  $alias  order表的别名（包括.例如 o.）
 * @return  string
 */
function get_order_query_sql($type = 'finished', $alias = '') {
    /* 已完成订单 */
    if ($type == 'finished') {
        return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
               " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
               " AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
    }
    /* 待发货订单 */
    elseif ($type == 'await_ship') {
        return " AND   {$alias}order_status " .
                 db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) .
               " AND   {$alias}shipping_status " .
                 db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) .
               " AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in(get_payment_id_list(true)) . ") ";
    }
    /* 待付款订单 */
    elseif ($type == 'await_pay') {
        return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
               " AND   {$alias}pay_status = '" . PS_UNPAYED . "'" .
               " AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in(get_payment_id_list(false)) . ") ";
    }
    /* 未确认订单 */
    elseif ($type == 'unconfirmed') {
        return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";
    }
    /* 未处理订单：用户可操作 */
    elseif ($type == 'unprocessed') {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
               " AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" .
               " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    }
    /* 未付款未发货订单：管理员可操作 */
    elseif ($type == 'unpay_unship') {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
               " AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) .
               " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    }
    /* 已发货订单：不论是否付款 */
    elseif ($type == 'shipped') {
        return " AND {$alias}order_status = '" . OS_CONFIRMED . "'" .
               " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " ";
    } else {
        die('函数 order_query_sql 参数错误');
    }
}

/*
 * 删除一条字符串里面的多个字符
 * $strCnt 字符串内容
 * $re_str 删除字符串内容
 */
function get_del_in_val($strCnt, $re_str) {
    
    $strCnt = explode(',', $strCnt); 
    $re_str = explode(',', $re_str);
    
    for ($i=0; $i<count($re_str); $i++) {
        for ($j=0; $j<count($strCnt); $j++) {
            if ($re_str[$i] == $strCnt[$j]) {
                unset($strCnt[$j]);
            }
        }
    }
    
    $strCnt = implode(',', $strCnt);
    return $strCnt;
}

/**
 * 取得支付方式id列表
 * @param   bool    $is_cod 是否货到付款
 * @return  array
 */
function get_payment_id_list($is_cod)
{
    $sql = "SELECT pay_id FROM " . $GLOBALS['ecs']->table('payment');
    if ($is_cod)
    {
        $sql .= " WHERE is_cod = 1";
    }
    else
    {
        $sql .= " WHERE is_cod = 0";
    }

    return $GLOBALS['db']->getCol($sql);
}

/**
 * 生成查询订单总金额的字段
 * @param   string  $alias  order表的别名（包括.例如 o.）
 * @return  string
 */
function get_order_amount_field($alias = '')
{
    return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .
           " + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .
           " + {$alias}card_fee ";
}

/*简化sql获取数据
 *$table 表名称
 *$where 查询条件 例子：$where = "goods_id = '$goods_id' and user_id = '$user_id'"
 *$date 传值数组方式
 *$sqlType 获取数据方式 0:取一维数组数据, 1:取二维数组数据 2:取单字段数据集
 */
function get_table_date($table = '', $where = array(), $date = array(), $sqlType = 0) {
	$data = implode(',', $date);
	if (!empty($data)) {
		if ($table == 'admin_user') {
			$db = RC_Model::model('admin_user_model');
		} else {
			//$db = RC_Loader::load_app_model($table.'_model','seller');
			$db = RC_DB::table($table);
		}
		
		
		if ($sqlType == 1) {
			//return $db->field($data)->where($where)->select();
			return $db->select(RC_DB::raw($data))->where($where)->get();
		} elseif ($sqlType == 2) {
			//return $db->where($where)->get_field($data);
			return $db->where($where)->pluck(RC_DB::raw($data));
		} else {
			//return $db->field($data)->where($where)->find();
			return $db->where($where)->select(RC_DB::raw($data))->first();
		}
	}	
}

/**
 * 获得分类的信息
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_store_cat_info($cat_id)
{
    return $GLOBALS['db']->getRow('SELECT cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id FROM ' . $GLOBALS['ecs']->table('category') .
        " WHERE cat_id = '$cat_id'");
}

/**
 * 取得最近的上级分类的grade值
 *
 * @access  public
 * @param   int     $cat_id    //当前的cat_id
 *
 * @return int
 */
function get_store_parent_grade($cat_id)
{
    static $res = NULL;

    if ($res === NULL)
    {
        $data = read_static_cache('cat_parent_grade');
        if ($data === false)
        {
            $sql = "SELECT parent_id, cat_id, grade ".
                   " FROM " . $GLOBALS['ecs']->table('category');
            $res = $GLOBALS['db']->getAll($sql);
            write_static_cache('cat_parent_grade', $res);
        }
        else
        {
            $res = $data;
        }
    }

    if (!$res)
    {
        return 0;
    }

    $parent_arr = array();
    $grade_arr = array();

    foreach ($res as $val)
    {
        $parent_arr[$val['cat_id']] = $val['parent_id'];
        $grade_arr[$val['cat_id']] = $val['grade'];
    }

    while ($parent_arr[$cat_id] >0 && $grade_arr[$cat_id] == 0)
    {
        $cat_id = $parent_arr[$cat_id];
    }

    return $grade_arr[$cat_id];

}

//数据打印
function get_print_r($arr) { 
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
} 

/**
 * 计算运费
 * @param   string  $shipping_code      配送方式代码
 * @param   mix     $shipping_config    配送方式配置信息
 * @param   float   $goods_weight       商品重量
 * @param   float   $goods_amount       商品金额
 * @param   float   $goods_number       商品数量
 * @return  float   运费
 */
function goods_shipping_fee($shipping_code, $shipping_config, $goods_weight, $goods_amount, $goods_number='')
{
    if (!is_array($shipping_config))
    {
        $shipping_config = unserialize($shipping_config);
    }
	
    $filename = ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php';
    if (file_exists($filename))
    {
        include_once($filename);

        $obj = new $shipping_code($shipping_config);

        return $obj->calculate($goods_weight, $goods_amount, $goods_number);
    }
    else
    {
        return 0;
    }
}
 
/**
 * 获得指定国家的所有省份
 *
 * @access      public
 * @param       int     country    国家的编号
 * @return      array
 */
// function get_regions_steps($type = 0, $parent = 0)
// {
//     $sql = 'SELECT region_id, region_name FROM ' . $GLOBALS['ecs']->table('region') .
//             " WHERE region_type = '$type' AND parent_id = '$parent'";
	
//     return $GLOBALS['db']->GetAll($sql);
// }

//数组排序--根据键的值的数值排序
function get_array_sort($arr,$keys,$type='asc') { 
	
	$new_array = array();
	if (is_array($arr) && !empty($arr)) {
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v) {
			$keysvalue[$k] = $v[$keys];
		}
		if ($type == 'asc') {
			asort($keysvalue);
		} else {
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v) {
			$new_array[$k] = $arr[$k];
		}
	}
	
	return $new_array; 
} 

//后台程序代码-------------------------------------

//添加或删除字段函数
function get_Add_Drop_fields($date, $newDate = '', $table = '', $type = 'insert', $dateType = 'VARCHAR', $length = '', $IntType = 'NOT NULL', $comment = '') {
	
	$date = trim($date);
	$comment = trim($comment);
	
	if (empty($newDate)) { //修改字段名称
		$newDate = $date;
	}
	
	//修改字段类型
	if ($dateType == 'VARCHAR') { //长字符串
		$length = empty($length) ? 255:$length;
		
		$dateType = "VARCHAR( " .$length. " )";
	} elseif ($dateType == 'CHAR') { //短字符串
		$length = empty($length) ? 60:$length;
		
		$dateType = "CHAR( " .$length. " )";
	} elseif ($dateType == 'INT') { //数据类型
		$length = empty($length) ? 11:$length;
		$codingType = '';
		$coding = '';
		
		$dateType = "INT( " .$length. " ) UNSIGNED";
	} elseif ($dateType == 'MEDIUMINT') { //数据类型
		$length = empty($length) ? 11:$length;
		$codingType = '';
		$coding = '';
		
		$dateType = "MEDIUMINT( " .$length. " ) UNSIGNED";
	} elseif ($dateType == 'SMALLINT') { //数据类型  
		$length = empty($length) ? 11:$length;
		$codingType = '';
		$coding = '';
		
		$dateType = "SMALLINT( " .$length. " ) UNSIGNED";
	} elseif ($dateType == 'TINYINT') { //数据类型
		$length = empty($length) ? 1:$length;
		$codingType = '';
		$coding = '';
		
		$dateType = "TINYINT( " .$length. " ) UNSIGNED";
	} elseif ($dateType == 'TEXT') { //文本类型
		$length = '';
		$dateType = "TEXT";
	} elseif ($dateType == 'DECIMAL') { //保留几位数类型
		$length = empty($length) ? '10,2':$length;
		$codingType = '';
		$coding = '';
		
		$dateType = "DECIMAL( " .$length. " )";
	}
	
	//修改字段是否为空
	if ($IntType != 'NOT NULL') {
		$IntType = 'NULL';
	}
	
	if (!empty($comment)) {
		$comment = " COMMENT '" .$comment. "'";
	}
	
	if (!empty($table)) {
		
		//字段操作 start
		if ($type == 'insert') {
			$sql = "ALTER TABLE " .$GLOBALS['ecs']->table($table). " ADD `" .$date. "` " .$dateType. " " .$IntType . $comment;
		} elseif ($type == 'update') {
			$sql = "ALTER TABLE " .$GLOBALS['ecs']->table($table). " CHANGE `" .$date. "` `" .$newDate. "` " .$dateType. " " .$codingType. " " . $IntType. " " . $comment;
		} elseif ($type == 'delete') {
			$sql = "ALTER TABLE " .$GLOBALS['ecs']->table($table). " DROP `" .$date. "`";
		}
		//字段操作 end
		
		$res = mysql_query($sql);
		
		if ($res == 1) {
			return 1;
		} else {
			return 3;
		}
	} else {
		return 2;
	}
}

function get_array_fields($date, $newDate, $table, $type, $dateType, $length) {
	
	for ($i=0; $i<count($date); $i++) {
		get_Add_Drop_fields($date[$i], $newDate[$i], $table, $type, $dateType[$i], $length[$i]);
	}
}

/******************文章函数 start************************/

//查找商家入驻文章列表
function get_merchants_article_menu($cat_id) {
	$sql = "select article_id, title, file_url, article_type, article_type from " .$GLOBALS['ecs']->table('article'). " where cat_id = '$cat_id' order by article_id desc";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['article_id'] = $row['article_id'];
		$arr[$key]['article_type'] = $row['article_type'];
		$arr[$key]['title'] = $row['title'];
		if ($row['open_type'] == 'article') {
			$arr[$key]['url'] = build_uri('merchants', array('mid'=>$row['article_id']), $row['title']);
		} else {
			$arr[$key]['url'] = $row['file_url'];
		}
	}
	
	return $arr;
}

//查找商家入驻文章内容
function get_merchants_article_info($article_id) {
	$sql = "select content from " .$GLOBALS['ecs']->table('article'). " where article_id = '$article_id'";
	return $GLOBALS['db']->getRow($sql);
}

/******************文章函数 end************************/

/******************入驻流程函数 start************************/

function get_merchants_steps_fields_admin($table, $date, $dateType, $length, $notnull, $coding, $formName, $fields_sort, $tid) {
	$arr = array();
	for ($i=0;$i<count($date); $i++) {
		if (!empty($date[$i])) {
			$arr[$i]['date']         = $date[$i];
			$arr[$i]['dateType']     = $dateType[$i];
			$arr[$i]['length']       = $length[$i];
			$arr[$i]['notnull']      = $notnull[$i];
			$arr[$i]['formName']     = $formName[$i];
			$arr[$i]['coding']       = $coding[$i];
			$arr[$i]['fields_sort']  = $fields_sort[$i];
			
			$arr['textFields']       .= $date[$i] . ',';
			$arr['fieldsDateType']   .= $dateType[$i] . ',';
			$arr['fieldsLength']     .= $length[$i] . ',';
			$arr['fieldsNotnull']    .= $notnull[$i] . ',';
			$arr['fieldsFormName']   .= $formName[$i] . ',';
			$arr['fieldsCoding']     .= $coding[$i] . ',';
			$arr['fields_sort']      .= $fields_sort[$i] . ',';
			$arr['will_choose']      .= $_POST['will_choose_' . $i] . ',';
			
			if ($dateType[$i] == 'INT' || $dateType[$i] == 'TINYINT' || $dateType[$i] == 'DECIMAL' || $dateType[$i] == 'MEDIUMINT' || $dateType[$i] == 'SMALLINT') {
				$arr[$i]['coding'] = '';
			}
			
			$type = 'insert';
			
			//判断数据库表的字段是否存在
			$test = mysql_query('Describe ' .$GLOBALS['ecs']->table($table). $date[$i]);
			$test = mysql_fetch_array($test);
			
			if (is_array($test)) { //表字段存在
				$type = 'update';
				$newDate = ''; //修改表名称
			} else { //表字段不存在
				$type = 'insert';
			}
			
			$failure = get_Add_Drop_fields($arr[$i]['date'], $newDate, $table, $type, $arr[$i]['dateType'], $arr[$i]['length'], $arr[$i]['notnull'], $arr[$i]['formName'], $arr[$i]['coding']);
			
			if ($failure == 2) {
				$sql = "select fields_steps from " .$GLOBALS['ecs']->table('merchants_steps_title'). " where tid = '$tid'";
				$pid = $GLOBALS['db']->getOne($sql);
				
				$link[] = array('text' => '返回一页', 'href'=>'merchants_steps.php?act=title_list&id=' . $pid);
				sys_msg('表名称为空', 0, $link);
				break;
			}
		}
	}
	
	$arr['textFields']         = substr($arr['textFields'], 0, -1);
	$arr['fieldsDateType']     = substr($arr['fieldsDateType'], 0, -1);
	$arr['fieldsLength']       = substr($arr['fieldsLength'], 0, -1);
	$arr['fieldsNotnull']      = substr($arr['fieldsNotnull'], 0, -1);
	$arr['fieldsFormName']     = substr($arr['fieldsFormName'], 0, -1);
	$arr['fieldsCoding']       = substr($arr['fieldsCoding'], 0, -1);
	$arr['fields_sort']        = substr($arr['fields_sort'], 0, -1);
	$arr['will_choose']        = substr($arr['will_choose'], 0, -1);
	
	return $arr;
}

//选择表单类型
function get_steps_form_choose($form_array = array()) {
	
	$form = $form_array['form'];
	
	$arr = array();
	$arr['chooseForm'] = '';
	for ($i=0;$i<count($form); $i++) {
		
		if (!empty($form_array['formName_special'][$i])) {
			$formName_special = '+' . $form_array['formName_special'][$i];
		} else {
			$formName_special = '+' . ' ';
		}
		
		if ($form[$i] == 'input') {
			$arr[$i]['form'] = $form[$i] . ':' . $form_array['formSize'][$i] . $formName_special;
		} elseif ($form[$i] == 'textarea') {
			$arr[$i]['form'] = $form[$i] . ':' . $form_array['rows'][$i] . ',' . $form_array['cols'][$i] . $formName_special;
		} elseif ($form[$i] == 'radio') {
			$arr[$i]['form'] = $form[$i] . ':' . implode(',', get_formType_arr($_POST['radio_checkbox_' . $i], $_POST['rc_sort_' . $i])) . $formName_special;
		} elseif ($form[$i] == 'checkbox') {
			$arr[$i]['form'] = $form[$i] . ':' . implode(',', get_formType_arr($_POST['radio_checkbox_' . $i], $_POST['rc_sort_' . $i])) . $formName_special;
		} elseif ($form[$i] == 'select') {
			$arr[$i]['form'] = $form[$i] . ':' . implode(',', get_formType_arr($_POST['select_' . $i], '', 1))  . $formName_special;
		} elseif ($form[$i] == 'other') {
			if ($form_array['formOther'][$i] == 'dateTime') {
				$dateTimeText = ',' . $form_array['formOtherSize'][$i];
			}
			$arr[$i]['form'] = $form[$i] . ':' . $form_array['formOther'][$i] . $dateTimeText . $formName_special;
		}
		
		if (!empty($form_array['date'][$i])) {
			$arr['chooseForm'] .= $arr[$i]['form'] . '|';
		}
	}
	
	$arr['chooseForm'] = substr($arr['chooseForm'], 0, -1);
	return $arr;
}

function get_formType_arr($formType, $rc_sort, $type = 0) {
	
	$arr =array();
	for ($i=0; $i<count($formType); $i++) {
		if (!empty($formType[$i])) {
			if ($type == 0) {
				$arr[$i] = trim($formType[$i]) .'*'. trim($rc_sort[$i]); 
			} else {
				$arr[$i] = trim($formType[$i]); 
			}
		}
	}
	
	return $arr;
}

function get_merchants_steps_fields_centent_insert_update($textFields, $fieldsDateType, $fieldsLength, $fieldsNotnull, $fieldsFormName, $fieldsCoding, $fields_sort, $will_choose, $chooseForm, $tid) {
	
	$parent = array(
				'tid'               => $tid,
				'textFields'        => $textFields,
				'fieldsDateType'    => $fieldsDateType,
				'fieldsLength'      => $fieldsLength,
				'fieldsNotnull'     => $fieldsNotnull,
				'fieldsFormName'    => $fieldsFormName,
				'fieldsCoding'      => $fieldsCoding,
				'fields_sort'       => $fields_sort,
				'will_choose'       => $will_choose,
				'fieldsForm'        => $chooseForm
			);	
	
	$sql = "select id from " .$GLOBALS['ecs']->table('merchants_steps_fields_centent'). " where tid = '$tid'";
	$res = $GLOBALS['db']->getOne($sql);		
	
	if ($res > 0) {
		$handler_type = 'update';
	} else {
		$handler_type = 'insert';
	}
				
	if ($handler_type == 'update') {
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_steps_fields_centent'), $parent, 'UPDATE', "tid = '$tid'");
	} else {
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_steps_fields_centent'), $parent, 'INSERT');
	}
	
	return true;
}

//添加或更新流程信息
function get_merchants_steps_title_insert_update($fields_steps, $fields_titles, $titles_annotation, $steps_style, $fields_special, $special_type, $handler_type = 'insert',$tid = 0) {
	
	if ($handler_type == 'update') {
		$typeTid = ' and tid <> ' . $tid;
	}
	
	$sql = "select tid from " .$GLOBALS['ecs']->table('merchants_steps_title'). " where fields_titles = '$fields_titles'" . $typeTid;
	$res = $GLOBALS['db']->getOne($sql);
	
	if ($res > 0) {
		return false;
	} else {	
		$parent = array(
					'fields_steps'         => $fields_steps,
					'fields_titles'        => $fields_titles,
					'titles_annotation'    => $titles_annotation,
					'steps_style'          => $steps_style,
					'fields_special'       => $fields_special,
					'special_type'         => $special_type
				);
		
		if ($handler_type == 'update') {
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_steps_title'), $parent, 'UPDATE', "tid = '$tid'");
			
			return true;
		} else {
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_steps_title'), $parent, 'INSERT');
			$tid = $GLOBALS['db']->insert_id();
			
			$res['tid'] = $tid;
			$res['true'] = true;

			return $res;
		}
	}
}

//字段循环生成数组
function get_fields_centent_info($id, $textFields, $fieldsDateType, $fieldsLength, $fieldsNotnull, $fieldsFormName, $fieldsCoding, $fieldsForm, $fields_sort, $will_choose, $webType = 'admin', $shop_id = 0) {
	if (!empty($textFields)) {
		$textFields 		= explode(',', $textFields);
		$fieldsDateType 	= explode(',', $fieldsDateType);
		$fieldsLength 		= explode(',', $fieldsLength);
		$fieldsNotnull 		= explode(',', $fieldsNotnull);
		$fieldsFormName 	= explode(',', $fieldsFormName);
		$fieldsCoding 		= explode(',', $fieldsCoding);
		$choose 			= explode('|', $fieldsForm);
		$fields_sort 		= explode(',', $fields_sort);
		$will_choose 		= explode(',', $will_choose);
		
		$arr = array();
		for ($i=0; $i < count($textFields); $i++) {
			$arr[$i+1]['id'] 				= $id;
			$arr[$i+1]['textFields'] 		= !empty($textFields[$i]) 		? $textFields[$i]		: '';
			$arr[$i+1]['fieldsDateType'] 	= !empty($fieldsDateType[$i]) 	? $fieldsDateType[$i]	: '';
			$arr[$i+1]['fieldsLength'] 		= !empty($fieldsLength[$i]) 	? $fieldsLength[$i]		: '';
			$arr[$i+1]['fieldsNotnull'] 	= !empty($fieldsNotnull[$i]) 	? $fieldsNotnull[$i]	: '';
			$arr[$i+1]['fieldsFormName'] 	= !empty($fieldsFormName[$i]) 	? $fieldsFormName[$i]	: '';
			$arr[$i+1]['fieldsCoding'] 		= !empty($fieldsCoding[$i]) 	? $fieldsCoding[$i]		: '';
			$arr[$i+1]['fields_sort'] 		= !empty($fields_sort[$i]) 		? $fields_sort[$i]		: '';
			$arr[$i+1]['will_choose'] 		= !empty($will_choose[$i]) 		? $will_choose[$i] 		: '';
			
			if ($shop_id > 0) {
				$msfdb = RC_Loader::load_app_model('merchants_steps_fields_model','seller');
				//原来逻辑
				//$arr[$i+1]['title_contents'] = $msfdb->field($textFields[$i])->where(array('user_id'=>$user_id))->find();
				//现在逻辑
				$arr[$i+1]['title_contents'] = $msfdb->field($textFields[$i])->where(array('shop_id'=>$shop_id))->find();
			}
			
			$chooseForm = explode(':', $choose[$i]);
			$arr[$i+1]['chooseForm'] = $chooseForm[0];
			$form_special = explode('+',$chooseForm[1]);
			$arr[$i+1]['formSpecial'] = !empty($form_special[1]) ? $form_special[1] : '';	//表单注释
			
			if ($chooseForm[0] == 'input') {
				$arr[$i+1]['inputForm'] = $form_special[0];
			} elseif ($chooseForm[0] == 'textarea') {
				$textareaForm = explode(',', $form_special[0]);
				$arr[$i+1]['rows'] = $textareaForm[0];
				$arr[$i+1]['cols'] = $textareaForm[1];
			} elseif ($chooseForm[0] == 'radio' || $chooseForm[0] == 'checkbox') {
				if (!empty($form_special[0])) {
					$radioCheckbox_sort = get_radioCheckbox_sort(explode(',', $form_special[0]));
					
					if ($webType == 'root') {
						$radioCheckbox_sort = get_array_sort($radioCheckbox_sort, 'rc_sort');
					}
					
					$arr[$i+1]['radioCheckboxForm'] = $radioCheckbox_sort;
				} else {
					$arr[$i+1]['radioCheckboxForm'] = '';
				}
			} elseif ($chooseForm[0] == 'select') {
				if (!empty($form_special[0])) {
					$arr[$i+1]['selectList'] = explode(',', $form_special[0]);
				} else {
					$arr[$i+1]['selectList'] = '';
				}
			} elseif ($chooseForm[0] == 'other') {
				$otherForm = explode(',', $form_special[0]);
				$arr[$i+1]['otherForm'] = $otherForm[0];
				if ($otherForm[0] == 'dateTime') { //日期
					
					if ($webType == 'root') {
						if (!empty($arr[$i+1]['title_contents'])) {
							$arr[$i+1]['dateTimeForm'] = get_dateTimeForm_arr(explode('--', $otherForm[1]), explode(',', $arr[$i+1]['title_contents'][$textFields[$i]]));
						}
					} else {
						$arr[$i+1]['dateTimeForm'] = $otherForm[1];
					}
				} elseif ($otherForm[0] == 'textArea') { //地区
					if ($webType == 'root') {
						if (!empty($arr[$i+1]['title_contents'])) {
							$arr[$i+1]['textAreaForm'] = get_textAreaForm_arr(explode(',', $arr[$i+1]['title_contents'][$textFields[$i]]));
						}
						if (!empty($arr[$i+1]['textAreaForm'])) {
							$arr[$i+1]['province_list'] = get_regions(1,$arr[$i+1]['textAreaForm']['country']);
							$arr[$i+1]['province_list'] = get_regions(1,$arr[$i+1]['textAreaForm']['country']);
							$arr[$i+1]['city_list']     = get_regions(2,$arr[$i+1]['textAreaForm']['province']);
							$arr[$i+1]['district_list'] = get_regions(3,$arr[$i+1]['textAreaForm']['city']);
						}
					}
				}
			}
		}
		return $arr;
	} else {
		return array();
	}
}

//单选或多选表单数据
function get_radioCheckbox_sort($radioCheckbox_sort) {
	$arr = array();
	for ($i=0; $i<count($radioCheckbox_sort); $i++) {
		$rc_sort = explode('*', $radioCheckbox_sort[$i]);
		$arr[$i]['radioCheckbox'] = $rc_sort[0];
		$arr[$i]['rc_sort'] = $rc_sort[1];
	}
	
	return $arr;
}

//日期表单数据
function get_dateTimeForm_arr($dateTime, $date_centent) {
	$arr = array();
	for ($i=0; $i<$dateTime[0]; $i++) {
		if (!empty($dateTime[1])) {
			$arr[$i]['dateSize'] = $dateTime[1];
		}
		if (!empty($date_centent[$i])) {
			$arr[$i]['dateCentent'] = $date_centent[$i];
		}
	}
	
	return $arr;
}

//地区表单数据
function get_textAreaForm_arr($textArea) {
	$arr['country'] 	= !empty($textArea[0]) ? $textArea[0] : '';
	$arr['province']	= !empty($textArea[1]) ? $textArea[1] : '';
	$arr['city'] 		= !empty($textArea[2]) ? $textArea[2] : '';
	$arr['district'] 	= !empty($textArea[3]) ? $textArea[3] : '';
	
	return $arr;
}

//查找字段数据 start
function get_fields_date_title_remove($tid, $objName, $type = 0) {
	$sql = "select * from " .$GLOBALS['ecs']->table('merchants_steps_fields_centent'). " where tid = '$tid'";
	$row = $GLOBALS['db']->getRow($sql);
	
	$textFields 		= explode(',', $row['textFields']);
	$fieldsDateType 	= explode(',', $row['fieldsDateType']);
	$fieldsLength 		= explode(',', $row['fieldsLength']);
	$fieldsNotnull 		= explode(',', $row['fieldsNotnull']);
	$fieldsFormName 	= explode(',', $row['fieldsFormName']);
	$fieldsCoding 		= explode(',', $row['fieldsCoding']);
	$fieldsForm 		= explode('|', $row['fieldsForm']);
	
	$arr = array();
	for ($i=0; $i<count($textFields); $i++) {
		if ($type == 1) {
			if ($textFields[$i] != $objName) {
				$arr[$i]['textFields'] 		= $textFields[$i];
				$arr[$i]['fieldsDateType'] 	= $fieldsDateType[$i];
				$arr[$i]['fieldsLength'] 	= $fieldsLength[$i];
				$arr[$i]['fieldsNotnull'] 	= $fieldsNotnull[$i];
				$arr[$i]['fieldsFormName'] 	= $fieldsFormName[$i];
				$arr[$i]['fieldsCoding'] 	= $fieldsCoding[$i];
				$arr[$i]['fieldsForm'] 		= $fieldsForm[$i];
			}
		} else {
			$arr[$i]['textFields'] 		= $textFields[$i];
		}
	}
	return $arr;
}

function get_title_remove($tid, $fields, $objName) { //$objName 删除字段
	$fields = array_values($fields);
	for ($i=0; $i<count($fields); $i++) {
		$arr[$i] = $fields[$i];
		$arr['textFields'] 		.= $fields[$i]['textFields'].',';
		$arr['fieldsDateType'] 	.= $fields[$i]['fieldsDateType'].',';
		$arr['fieldsLength'] 	.= $fields[$i]['fieldsLength'].',';
		$arr['fieldsNotnull'] 	.= $fields[$i]['fieldsNotnull'].',';
		$arr['fieldsFormName'] 	.= $fields[$i]['fieldsFormName'].',';
		$arr['fieldsCoding'] 	.= $fields[$i]['fieldsCoding'].',';
		$arr['fieldsForm'] 		.= $fields[$i]['fieldsForm'].'|';
	}
	
	$arr['textFields'] 			= substr($arr['textFields'], 0, -1);
	$arr['fieldsDateType'] 		= substr($arr['fieldsDateType'], 0, -1);
	$arr['fieldsLength'] 		= substr($arr['fieldsLength'], 0, -1);
	$arr['fieldsNotnull'] 		= substr($arr['fieldsNotnull'], 0, -1);
	$arr['fieldsFormName'] 		= substr($arr['fieldsFormName'], 0, -1);
	$arr['fieldsCoding'] 		= substr($arr['fieldsCoding'], 0, -1);
	$arr['fieldsForm'] 			= substr($arr['fieldsForm'], 0, -1);
	
	$parent = array(
				'textFields' 		=> $arr['textFields'],
				'fieldsDateType' 	=> $arr['fieldsDateType'],
				'fieldsLength' 		=> $arr['fieldsLength'],
				'fieldsNotnull' 	=> $arr['fieldsNotnull'],
				'fieldsFormName' 	=> $arr['fieldsFormName'],
				'fieldsCoding' 		=> $arr['fieldsCoding'],
				'fieldsForm' 		=> $arr['fieldsForm'],
			);
			
	$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_steps_fields_centent'), $parent, 'UPDATE', "tid = '$tid'");
	get_Add_Drop_fields($objName, '', 'merchants_steps_fields', 'delete');
	
	return $arr;
}
//查找字段数据 end

//添加类目证件标题
function get_documentTitle_insert_update($dt_list, $cat_id, $dt_id = array()) {
	
	for ($i=0; $i<count($dt_list); $i++) {
		
		$dt_list[$i] = trim($dt_list[$i]);
		
		$sql = "select cat_id from " .$GLOBALS['ecs']->table('merchants_documenttitle'). " where dt_id = '" . $dt_id[$i] . "'";
		$catId = $GLOBALS['db']->getOne($sql);
		
		if (!empty($dt_list[$i])) {
			$parent = array(
					'cat_id' 		=> $cat_id,
					'dt_title' 		=> $dt_list[$i]
				);
				
			if ($catId > 0) {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_documenttitle'), $parent, 'UPDATE', "dt_id = '" .$dt_id[$i]. "'");
			} else {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_documenttitle'), $parent, 'INSERT');
			}
		} else {
			if ($catId > 0) {
				$sql = "delete from " .$GLOBALS['ecs']->table('merchants_documenttitle'). " where dt_id = '" . $dt_id[$i] . "' and user_id = '" .$_SESSION['user_id']. "'";
				$GLOBALS['db']->query($sql); //删除二级类目表数据
			}
		}
	}
}

/******************入驻流程函数 end************************/

//获取入驻商家的前台会员ID
function get_admin_ru_id() {
	//$db_admin_user = RC_Loader::load_model('admin_user_model');
	$db_admin_user = RC_Model::model('admin_user_model');
	return $db_admin_user->field('ru_id')->find(array('user_id'=> $_SESSION['admin_id']));
	
// 	$sql = "select ru_id from " .$GLOBALS['ecs']->table('admin_user'). " where user_id = '" .$_SESSION['admin_id']. "'";
// 	return $GLOBALS['db']->getRow($sql);
}

//获取入驻商家的可用分类权限 start
function get_user_category($options, $shopMain_category, $ru_id = 0, $admin_type = 0) {
	if ($ru_id > 0) {
		$shopMain_category = get_category_child_tree($shopMain_category);
		$arr = array();
		if (!empty($shopMain_category)) {
			$category = explode(',', $shopMain_category);
			foreach ($options as $key=>$row) {
				if ($row['level'] < 3) {
					for ($i=0; $i<count($category); $i++) {
						if ($key == $category[$i]) {
							$arr[$key] = $row;
						}
					}
				} else {
					$sql = "select uc_id from " .$GLOBALS['ecs']->table('merchants_category'). " where cat_id = '" .$row['cat_id']. "' and user_id = '$ru_id'";
					$uc_id = $GLOBALS['db']->getOne($sql);
					
					if ($admin_type == 0) {
						if ($uc_id > 0) {
							$arr[$key] = $row;
						}
					}
				}
				
			}
		}
		
		return $arr;
	} else {
		return $options;
	}
}

function get_category_child_tree($shopMain_category) {
	
	$category = explode('-',$shopMain_category);
	
	for ($i=0; $i<count($category); $i++) {
		$category[$i] = explode(':',$category[$i]);
		
		$twoChild = explode(',',$category[$i][1]);
		for ($j=0; $j<count($twoChild); $j++) {
			$sql = " select cat_id, cat_name from " .$GLOBALS['ecs']->table('category'). " where parent_id = '" .$twoChild[$j]. "'";
			$threeChild = $GLOBALS['db']->getAll($sql);
			
			$category[$i]['three_' . $twoChild[$j]] = get_category_three_child($threeChild);
			
			$category[$i]['three'] .= $category[$i][0] .','. $category[$i][1] .','. $category[$i]['three_' . $twoChild[$j]]['threeChild'] . ',';
		}
		
		$category[$i]['three'] = substr($category[$i]['three'], 0, -1);
	}

	$category = get_link_cat_id($category);
	$category = $category['all_cat'];
	
	return $category;
}

function get_category_three_child($threeChild) {
	
	for ($i=0; $i<count($threeChild); $i++) {
		if (!empty($threeChild[$i]['cat_id'])) {
			$threeChild['threeChild'] .= $threeChild[$i]['cat_id'] . ",";
		}
	}
	
	$threeChild['threeChild'] = substr($threeChild['threeChild'], 0, -1);
	
	return $threeChild;
}

function get_link_cat_id($category) {
	
	for ($i=0; $i<count($category); $i++) {
		if (!empty($category[$i]['three'])) {
			$category['all_cat'] .= $category[$i]['three'] . ',';
		}
	}
	
	$category['all_cat'] = substr($category['all_cat'], 0, -1);
	
	return $category;
}
//获取入驻商家的可用分类权限 end

//前端程序代码-------------------------------------

//协议信息
function get_root_directory_steps($sid) {
	$sql = "select process_title, process_article from " .$GLOBALS['ecs']->table('merchants_steps_process'). " where process_steps = '$sid'";
	$row = $GLOBALS['db']->getRow($sql);
	
	if ($row['process_article'] > 0) {
		$row['article_centent'] = $GLOBALS['db']->getOne("select content from " .$GLOBALS['ecs']->table('article'). " where article_id = '" .$row['process_article']. "'");
	}
	
	return $row;
}

//申请步骤列表
function get_root_steps_process_list($sid) {
	$sql = "select id, process_title, fields_next from " .$GLOBALS['ecs']->table('merchants_steps_process'). " where process_steps = '$sid' order by steps_sort ASC";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['id']              = $row['id'];
		$arr[$key]['process_title']   = $row['process_title'];
		$arr[$key]['fields_next']     = $row['fields_next'];
	}
	
	return $arr;
}

function get_merchants_septs_custom_info($table = '', $type = '', $id = '') {
	
	if ($type == 'pingpai') {
		$id = " and bid = '$id'";
	}
	
	$sql = "select * from " .$GLOBALS['ecs']->table($table). " where user_id = '" .$_SESSION['user_id']. "'" . $id;

	return $GLOBALS['db']->getRow($sql);		
}

//流程信息列表
function get_root_merchants_steps_title($pid, $user_id) {
	
	include_once(ROOT_PATH . '/includes/cls_image.php'); 
	$image = new cls_image($_CFG['bgcolor']);
	
	$sql = "select tid, fields_titles, titles_annotation, steps_style, fields_special, special_type from " .$GLOBALS['ecs']->table('merchants_steps_title'). " where fields_steps='$pid'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {

		$arr[$key]['tid']                 = $row['tid'];
		$arr[$key]['fields_titles']       = $row['fields_titles'];
		$arr[$key]['titles_annotation']   = $row['titles_annotation'];
		$arr[$key]['steps_style']         = $row['steps_style'];
		$arr[$key]['fields_special']      = $row['fields_special'];
		$arr[$key]['special_type']        = $row['special_type'];
		
		$sql                              = "select * from " .$GLOBALS['ecs']->table('merchants_steps_fields_centent'). " where tid = '" .$row['tid']. "'"; 
		$centent                          = $GLOBALS['db']->getRow($sql);
		$cententFields                    = get_fields_centent_info($centent['id'],$centent['textFields'],$centent['fieldsDateType'],$centent['fieldsLength'],$centent['fieldsNotnull'],$centent['fieldsFormName'],$centent['fieldsCoding'],$centent['fieldsForm'],$centent['fields_sort'],$centent['will_choose'], 'root', $user_id);	
		$arr[$key]['cententFields']       = get_array_sort($cententFields, 'fields_sort');
		
		//自定义表单数据插入 start
		$ec_shop_bid              = isset($_REQUEST['ec_shop_bid']) ? trim($_REQUEST['ec_shop_bid']) : '';
		$ec_shoprz_type           = isset($_POST['ec_shoprz_type']) ? intval($_POST['ec_shoprz_type']) : 0;
		$ec_subShoprz_type        = isset($_POST['ec_subShoprz_type']) ? intval($_POST['ec_subShoprz_type']) : 0;
		$ec_shop_expireDateStart  = isset($_POST['ec_shop_expireDateStart']) ? trim($_POST['ec_shop_expireDateStart']) : '';
		$ec_shop_expireDateEnd    = isset($_POST['ec_shop_expireDateEnd']) ? trim($_POST['ec_shop_expireDateEnd']) : '';
		$ec_shop_permanent        = isset($_POST['ec_shop_permanent']) ? intval($_POST['ec_shop_permanent']) : 0;
		$ec_shop_categoryMain     = isset($_POST['ec_shop_categoryMain']) ? intval($_POST['ec_shop_categoryMain']) : 0;
		
		//品牌基本信息
		$bank_name_letter         = isset($_POST['ec_bank_name_letter']) ? trim($_POST['ec_bank_name_letter']) : '';
		$brandName                = isset($_POST['ec_brandName']) ? trim($_POST['ec_brandName']) : '';
		$brandFirstChar           = isset($_POST['ec_brandFirstChar']) ? trim($_POST['ec_brandFirstChar']) : '';
		$brandLogo                = isset($_FILES['ec_brandLogo']) ? $_FILES['ec_brandLogo'] : '';
		$brandLogo                = $image->upload_image($brandLogo, 'septs_Image');  //图片存放地址 -- data/septs_Image
		$brandType                = isset($_POST['ec_brandType']) ? intval($_POST['ec_brandType']) : 0;
		$brand_operateType        = isset($_POST['ec_brand_operateType']) ? intval($_POST['ec_brand_operateType']) : 0;
		$brandEndTime             = isset($_POST['ec_brandEndTime']) ? intval($_POST['ec_brandEndTime']) : '';
		$brandEndTime_permanent   = isset($_POST['ec_brandEndTime_permanent']) ? intval($_POST['ec_brandEndTime_permanent']) : 0;
		
		//品牌资质证件
		$qualificationNameInput   = isset($_POST['ec_qualificationNameInput']) ? $_POST['ec_qualificationNameInput'] : array();
		$qualificationImg         = isset($_FILES['ec_qualificationImg']) ? $_FILES['ec_qualificationImg'] : array();
		$expiredDateInput         = isset($_POST['ec_expiredDateInput']) ? $_POST['ec_expiredDateInput'] : array();
		$b_fid                    = isset($_POST['b_fid']) ? $_POST['b_fid'] : array();
		
		//店铺命名信息
		$ec_shoprz_brandName      = isset($_POST['ec_shoprz_brandName']) ? $_POST['ec_shoprz_brandName'] : '';
		$ec_shop_class_keyWords   = isset($_POST['ec_shop_class_keyWords']) ? $_POST['ec_shop_class_keyWords'] : '';
		$ec_shopNameSuffix        = isset($_POST['ec_shopNameSuffix']) ? $_POST['ec_shopNameSuffix'] : '';
		$ec_rz_shopName           = isset($_POST['ec_rz_shopName']) ? $_POST['ec_rz_shopName'] : '';
		$ec_hopeLoginName         = isset($_POST['ec_hopeLoginName']) ? $_POST['ec_hopeLoginName'] : '';
		
		$shop_info    = get_merchants_septs_custom_info('merchants_shop_information'); //店铺类型、 可经营类目---信息表
		$brand_info   = get_merchants_septs_custom_info('merchants_shop_brand', 'pingpai', $ec_shop_bid); //品牌表
		
		$sql      = "select shop_id from " .$GLOBALS['ecs']->table('merchants_shop_information'). " where user_id = '" .$_SESSION['user_id']. "'";
		$shop_id  = $GLOBALS['db']->getOne($sql);
		
		if ($row['steps_style'] == 1) {
			
			$ec_authorizeFile        = $image->upload_image($_FILES['ec_authorizeFile'], 'septs_Image');  //图片存放地址 -- data/septs_Image
			$ec_authorizeFile        = empty($ec_authorizeFile) ? $shop_info['authorizeFile'] : $ec_authorizeFile;
			$ec_shop_hypermarketFile = $image->upload_image($_FILES['ec_shop_hypermarketFile'], 'septs_Image');  //图片存放地址 -- data/septs_Image
			$ec_shop_hypermarketFile = empty($ec_shop_hypermarketFile) ? $shop_info['shop_hypermarketFile'] : $ec_shop_hypermarketFile;
			
			if ($ec_shop_permanent != 1) {
				$ec_shop_expireDateStart = empty($ec_shop_expireDateStart) ? local_date("Y-m-d H:i", $shop_info['shop_expireDateStart']) : $ec_shop_expireDateStart;
				$ec_shop_expireDateEnd   = empty($ec_shop_expireDateEnd)   ? local_date("Y-m-d H:i", $shop_info['shop_expireDateEnd'])   : $ec_shop_expireDateEnd;

				if (!empty($ec_shop_expireDateStart) || !empty($ec_shop_expireDateEnd)) {
					$ec_shop_expireDateStart = local_strtotime($ec_shop_expireDateStart);
					$ec_shop_expireDateEnd   = local_strtotime($ec_shop_expireDateEnd);
				}
			} else {
				$ec_shop_expireDateStart = '';
				$ec_shop_expireDateEnd   = '';
			}
			
			//判断数据是否存在，如果存在则引用 start
			if ($ec_shoprz_type == 0) {
				$ec_shoprz_type = $shop_info['shoprz_type'];
			}
			if ($ec_subShoprz_type == 0) {
				$ec_subShoprz_type = $shop_info['subShoprz_type'];
			}
			if ($ec_shop_categoryMain == 0) {
				$ec_shop_categoryMain = $shop_info['shop_categoryMain'];
			}
			//判断数据是否存在，如果存在则引用 end
			
			$parent = array(  //店铺类型数据插入
						'user_id'                 => $_SESSION['user_id'],
						'shoprz_type'             => $ec_shoprz_type,
						'subShoprz_type'          => $ec_subShoprz_type,
						'shop_expireDateStart'    => $ec_shop_expireDateStart,
						'shop_expireDateEnd'      => $ec_shop_expireDateEnd,
						'shop_permanent'          => $ec_shop_permanent,
						'authorizeFile'           => $ec_authorizeFile,
						'shop_hypermarketFile'    => $ec_shop_hypermarketFile,
						'shop_categoryMain'       => $ec_shop_categoryMain
					);	
					
			if ($_SESSION['user_id'] > 0) {
				if ($shop_id > 0) {
					
					if ($parent['shop_expireDateStart'] == '' || $parent['shop_expireDateEnd'] == '') {
						if ($ec_shop_permanent != 1) {
							if ($shop_info['shop_permanent'] == 1) {
								$parent['shop_permanent'] = $shop_info['shop_permanent'];
							}
						}
					}
					
					if (empty($parent['authorizeFile'])) {
						$parent['shop_permanent'] = 0;
					} else {
						if ($parent['shop_expireDateStart'] == '' || $parent['shop_expireDateEnd'] == '') {
							$parent['shop_permanent']        = 1;
							$parent['shop_expireDateStart']  = '';
							$parent['shop_expireDateEnd']    = '';
						}
					}
					
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_information'), $parent, 'UPDATE', "user_id = '" .$_SESSION['user_id']. "'");
				} else {
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_information'), $parent, 'INSERT');
				}
			}
			
			if ($ec_shop_permanent == 0) {
				if ($parent['shop_expireDateStart'] != '') {
					$parent['shop_expireDateStart'] = local_date("Y-m-d H:i", $shop_info['shop_expireDateStart']);
				}
				if ($parent['shop_expireDateEnd'] != '') {
					$parent['shop_expireDateEnd'] = local_date("Y-m-d H:i", $shop_info['shop_expireDateEnd']);
				}
			}	
			
		} elseif ($row['steps_style'] == 2) { //一级类目列表
		
			//2014-11-19 start
			if ($_SESSION['user_id'] > 0) {
				if ($shop_id < 1) {
					$parent['user_id']             = $_SESSION['user_id'];
					$parent['shop_categoryMain']   = $ec_shop_categoryMain;
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_information'), $parent, 'INSERT');
				}
			}
			//2014-11-19 end
		
			$arr[$key]['first_cate'] = get_first_cate_list(0,0,array(),$_SESSION['user_id']);
			$catId_array = get_catId_array();
			
			$parent['user_shopMain_category'] = implode('-', $catId_array);
			
			//2014-11-19 start
			if ($ec_shop_categoryMain == 0) {
				$ec_shop_categoryMain        = $shop_info['shop_categoryMain'];
				$parent['shop_categoryMain'] = $ec_shop_categoryMain;
			}
			$parent['shop_categoryMain'] = $ec_shop_categoryMain;
			//2014-11-19 end
			
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_information'), $parent, 'UPDATE', "user_id = '" .$_SESSION['user_id']. "'");
			
			if (!empty($parent['user_shopMain_category'])) {
				get_update_temporarydate_isAdd($catId_array);
			}			
			get_update_temporarydate_isAdd($catId_array, 1);
		} elseif ($row['steps_style'] == 3) { //品牌列表
			
			$arr[$key]['brand_list'] = get_septs_shop_brand_list($_SESSION['user_id']); //品牌列表

			if ($ec_shop_bid > 0) { //更新品牌数据
			
				$bank_name_letter       = empty($bank_name_letter)          ? $brand_info['bank_name_letter']       : $bank_name_letter;
				$brandName              = empty($brandName)                 ? $brand_info['brandName']              : $brandName;
				$brandFirstChar         = empty($brandFirstChar)            ? $brand_info['brandFirstChar']         : $brandFirstChar;
				$brandLogo              = empty($brandLogo)                 ? $brand_info['brandLogo']              : $brandLogo;
				$brandType              = empty($brandType)                 ? $brand_info['brandType']              : $brandType;
				$brand_operateType      = empty($brand_operateType)         ? $brand_info['brand_operateType']      : $brand_operateType;
				$brandEndTime           = empty($brandEndTime)              ? $brand_info['brandEndTime']           : local_strtotime($brandEndTime);
				$brandEndTime_permanent = empty($brandEndTime_permanent)    ? $brand_info['brandEndTime_permanent'] : $brandEndTime_permanent;
			
				$brandfile_list = get_shop_brandfile_list($ec_shop_bid);
				$arr[$key]['brandfile_list'] = $brandfile_list;
				
				$parent = array(
						'user_id' 					=> $_SESSION['user_id'],
						'bank_name_letter' 			=> $bank_name_letter,
						'brandName' 				=> $brandName,
						'brandFirstChar' 			=> $brandFirstChar,
						'brandLogo' 				=> $brandLogo,
						'brandType' 				=> $brandType,
						'brand_operateType' 		=> $brand_operateType,
						'brandEndTime' 				=> $brandEndTime,
						'brandEndTime_permanent' 	=> $brandEndTime_permanent
					);
				
				if (!empty($parent['brandEndTime'])) {
					$arr[$key]['parentType']['brandEndTime'] = local_date("Y-m-d H:i", $parent['brandEndTime']); //输出
				}
				
				if ($_SESSION['user_id'] > 0) {
					
					if ($parent['brandEndTime_permanent'] == 1) {
						$parent['brandEndTime'] = '';
					}
					
					$sql = "select bid from " .$GLOBALS['ecs']->table('merchants_shop_brand'). " where brandName = '$brandName' and bid <> '$ec_shop_bid' and user_id = '" .$_SESSION['user_id']. "'";
					$bRes = $GLOBALS['db']->getOne($sql);
					
					if ($bRes > 0) {
						show_message('品牌名称已存在', '返回上一步', 'javascript:history.back()');
						exit;
					} else {
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_brand'), $parent, 'UPDATE', "user_id = '" .$_SESSION['user_id']. "' and bid = '$ec_shop_bid'");
						
						get_shop_brand_file($qualificationNameInput, $qualificationImg, $expiredDateInput, $b_fid, $ec_shop_bid); //品牌资质文件上传
					}
				}	
			} else { //插入品牌数据
				if ($_SESSION['user_id'] > 0) {
					
					if (!empty($bank_name_letter)) {
						$sql = "select bid from " .$GLOBALS['ecs']->table('merchants_shop_brand'). " where brandName = '$brandName' and user_id = '" .$_SESSION['user_id']. "'";
						$bRes = $GLOBALS['db']->getOne($sql);
						
						if ($bRes > 0) {
							show_message('品牌名称已存在', '返回上一步', 'javascript:history.back()');
							exit;
						} else {
							
							$parent = array(
								'user_id' 					=> $_SESSION['user_id'],
								'bank_name_letter' 			=> $bank_name_letter,
								'brandName' 				=> $brandName,
								'brandFirstChar' 			=> $brandFirstChar,
								'brandLogo' 				=> $brandLogo,
								'brandType' 				=> $brandType,
								'brand_operateType' 		=> $brand_operateType,
								'brandEndTime' 				=> $brandEndTime,
								'brandEndTime_permanent' 	=> $brandEndTime_permanent
							);
							
							$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_brand'), $parent, 'INSERT');
							$bid = $GLOBALS['db']->insert_id();
							
							get_shop_brand_file($qualificationNameInput, $qualificationImg, $expiredDateInput, $b_fid, $bid); //品牌资质文件上传
						}
					}
				}
			}
		} elseif ($row['steps_style'] == 4) {
			
			$sql                     = "select bid, brandName from " .$GLOBALS['ecs']->table('merchants_shop_brand'). " where user_id = '" .$_SESSION['user_id']. "'";
			$brand_list              = $GLOBALS['db']->getAll($sql);
			$arr[$key]['brand_list'] = $brand_list;
			
			$ec_shoprz_brandName     = empty($ec_shoprz_brandName)       ? $shop_info['shoprz_brandName']    : $ec_shoprz_brandName;
			$ec_shop_class_keyWords  = empty($ec_shop_class_keyWords)    ? $shop_info['shop_class_keyWords'] : $ec_shop_class_keyWords;
			$ec_shopNameSuffix       = empty($ec_shopNameSuffix)         ? $shop_info['shopNameSuffix']      : $ec_shopNameSuffix;
			$ec_rz_shopName          = empty($ec_rz_shopName)            ? $shop_info['rz_shopName']         : $ec_rz_shopName;
			$ec_hopeLoginName        = empty($ec_hopeLoginName)          ? $shop_info['hopeLoginName']       : $ec_hopeLoginName;
			
			if (!empty($ec_rz_shopName)) {
				$parent = array(
							'shoprz_brandName' 		=> $ec_shoprz_brandName,
							'shop_class_keyWords' 	=> $ec_shop_class_keyWords,
							'shopNameSuffix' 		=> $ec_shopNameSuffix,
							'rz_shopName' 			=> $ec_rz_shopName,
							'hopeLoginName' 		=> $ec_hopeLoginName,
						);
						
				if ($_SESSION['user_id'] > 0) {
					if ($shop_id > 0) {
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_information'), $parent, 'UPDATE', "user_id = '" .$_SESSION['user_id']. "'");
					} else {
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('merchants_shop_information'), $parent, 'INSERT');
					}
				}
			}
			
			$parent['shoprz_type'] = $shop_info['shoprz_type'];
		}
		
		$parent['brandEndTime']  = $arr[$key]['parentType']['brandEndTime']; //品牌使用时间
		$arr[$key]['parentType'] = $parent; //自定义显示
		//自定义表单数据插入 end
	}
	
	//print_r($arr);
	return $arr;
}

//更新临时表中的数据为插入
function get_update_temporarydate_isAdd($catId_array, $type = 0) {
	$arr = array();
	$mctdb = RC_Loader::load_app_model('merchants_category_temporarydate_model','seller');
	if ($type == 0) {
		for ($i=0; $i<count($catId_array); $i++) {
			$parentChild = explode(':', $catId_array[$i]);
			$arr[$i]     = explode(',',$parentChild[1]);
			
			for ($j=0; $j<count($arr[$i]); $j++) {
				$mctdb->where(array('cat_id'=>$arr[$i][$j]))->update(array('is_add'=>1));
			}
		}
	} else {
		$cat_id               = isset($_POST['permanentCat_id'])      ? $_POST['permanentCat_id']      : array();
		$dt_id                = isset($_POST['permanent_title'])      ? $_POST['permanent_title']      : array();
		$permanentFiles       = !empty($_FILES['permanentFile'])      ? $_FILES['permanentFile']       : array();
		$permanent_date       = isset($_POST['categoryId_date'])      ? $_POST['categoryId_date']      : array();
		$cate_title_permanent = isset($_POST['categoryId_permanent']) ? $_POST['categoryId_permanent'] : array();
		
		foreach ($permanentFiles as $k => $v) {
			foreach ($v as $key => $val) {
				$permanentFile[$key][$k] = $val;
			}
		}
		//操作一级类目证件插入或更新数据
		if (count($cat_id) > 0) {
			get_merchants_dt_file_insert_update($cat_id, $dt_id, $permanentFile, $permanent_date, $cate_title_permanent);	//插入类目行业资质
			unset($permanentFile);
		}
	}
	return $arr;
	
}

//类目证件插入或更新数据函数
function get_merchants_dt_file_insert_update($cat_id, $dt_id, $permanentFile, $permanent_date, $cate_title_permanent) {
	$upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => false));
	
	for ($i=0; $i<count($cat_id); $i++) {
		$mdtdb = RC_Loader::load_app_model('merchants_dt_file_model','seller');
		
		$row = $mdtdb->field('permanent_file,dtf_id')->where(array('cat_id'=>$cat_id[$i],'dt_id'=>$dt_id[$i],'user_id'=>$_SESSION['user_id']))->find();
		$permanent_file = $permanentFile[$i];
		if (isset($permanent_file)) {
			$image_info = $upload->upload($permanent_file);
			if (!empty($image_info)) {
				$upload->remove($row['permanent_file']);
			}
			$pFile = $upload->get_position($image_info);
		} else {
			$pFile = '';
		}
		$pFile = empty($pFile) ? $row['permanent_file'] : $pFile;	
		
		if (!empty($cate_title_permanent[$i])) {
			$permanent_date[$i] = '';
			$catPermanent = 1;
		} elseif (!empty($permanent_date[$i])) {
			$permanent_date[$i] = RC_Time::local_strtotime(trim($permanent_date[$i]));
			$catPermanent = 0;
		} else {
			$permanent_date[$i] = '';
			$catPermanent = 0;
		}
		
		$parent = array(
			'cat_id'                 => intval($cat_id[$i]),
			'dt_id'                  => intval($dt_id[$i]),
			//'user_id'              => $_SESSION['user_id'],
			'shop_id'	             => $_SESSION['shop_id'],
			'permanent_file'         => $pFile,
			'permanent_date'         => $permanent_date[$i],
			'cate_title_permanent'   => $catPermanent
		);

		if ($row['dtf_id'] > 0) {
			//$mdtdb->where(array('cat_id'=>$cat_id[$i],'dt_id'=>$dt_id[$i],'user_id'=>$_SESSION['user_id']))->update($parent);
			$mdtdb->where(array('cat_id'=>$cat_id[$i],'dt_id'=>$dt_id[$i],'shop_id'=>$_SESSION['shop_id']))->update($parent);
		} else {
			$mdtdb->insert($parent);
		}
	}
}

//入驻品牌列表 start
function get_septs_shop_brand_list($shop_id = 0) {
	$msb_db = RC_Loader::load_app_model('merchants_shop_brand_model', 'seller');
	$seller_shopinfo = RC_Loader::load_app_model('seller_shopinfo_model', 'seller');
	if ($shop_id > 0) {
		$seller_id = $seller_shopinfo-> where(array('shop_id' => $shop_id))->get_field('id');
		$res = $msb_db
    		->field('bid, bank_name_letter, brandName, brandFirstChar, brandLogo, brandType, brand_operateType, brandEndTime')
    		->where(array('seller_id' => $seller_id))
    		->order('bid asc')
    		->select();
	}
	$arr = array();
	$no_picture = RC_Uri::admin_url('statics/images/nopic.png');
	if (!empty($res)) {
		foreach ($res as $key=>$row) {
			$key = $key + 1;
			$arr[$key]['bid'] 				= $row['bid'];
			$arr[$key]['bank_name_letter'] 	= $row['bank_name_letter'];
			$arr[$key]['brandName'] 		= $row['brandName'];
			$arr[$key]['brandFirstChar'] 	= $row['brandFirstChar'];
			$arr[$key]['brandLogo'] 		= empty($row['brandLogo']) ? $no_picture : RC_Upload::upload_url($row['brandLogo']);
			$arr[$key]['brandType']		 	= $row['brandType'];
			$arr[$key]['brand_operateType'] = $row['brand_operateType'];
			$arr[$key]['brandEndTime'] 		= RC_Time::local_date("Y-m-d H:i", $row['brandEndTime']);
		}	
	}
	
	return $arr;
}

//品牌资质文件上传
function get_shop_brand_file($qInput, $qImg, $eDinput, $eDpermant, $b_fid, $ec_shop_bid) {
	$msb_db = RC_Loader::load_app_model('merchants_shop_brandfile_model','seller');
	$upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => false));
	
	
	//处理提交的资质电子版
	foreach ($qImg as $key => $val) {
		foreach ($val as $k => $v) {
			$row[$k][$key] = $v;
		}
	}
	for ($i=0; $i<count($qInput); $i++) {
		$qInput[$i] = trim($qInput[$i]);
		
		if (!empty($row[$i])) {
			$qImg[$i] = $upload->upload($row[$i]);
		} else {
			$qImg[$i] = '';
		}
		
		if (!empty($qImg[$i])) {
			$qImg[$i] = $upload->get_position($qImg[$i]);
		}
		$eDinput[$i] = trim($eDinput[$i]);
		
		if (!empty($eDpermant[$i])) {
			$eDpermant[$i] = 1;
			$eDinput[$i] = '';
		} else {
			$eDpermant[$i] = 0;
			if (!empty($eDinput[$i])) {
				$eDinput[$i] = RC_Time::local_strtotime($eDinput[$i]);
			} else {
				$eDinput[$i] = '';
			}
		}
		
		if (!empty($qInput[$i])) {
			$parent = array(
				'bid' 						=> $ec_shop_bid,
				'qualificationNameInput' 	=> $qInput[$i],
				'qualificationImg' 			=> $qImg[$i],
				'expiredDateInput' 			=> $eDinput[$i],
				'expiredDate_permanent' 	=> $eDpermant[$i]
			);
			if (!empty($b_fid[$i])) {
				$qualificationImg =	$msb_db->where(array('bid'=>$ec_shop_bid,'b_fid'=>$b_fid[$i]))->get_field('qualificationImg');
				if (empty($parent['qualificationImg'])) {
					$parent['qualificationImg'] = $qualificationImg;
				}
				$msb_db->where(array('bid'=>$ec_shop_bid,'b_fid'=>$b_fid[$i]))->update($parent);
			} else {
				$msb_db->insert($parent);
			}		
		}
	}
}

function get_shop_brandfile_list($ec_shop_bid) {
	$msbm = RC_Loader::load_app_model('merchants_shop_brandfile_model', 'seller');
	
	$res = $msbm->field('b_fid, bid, qualificationNameInput, qualificationImg, expiredDateInput, expiredDate_permanent')->where(array('bid' => $ec_shop_bid))->order('b_fid asc')->select();
	$arr = array();	
	if (!empty($res)) {
		foreach ($res as $key=>$row) {
			$arr[] = $row;
			$arr[$key]['expiredDateInput'] = RC_Time::local_date("Y-m-d H:i", $row['expiredDateInput']);
		}
	}
	return $arr;
}
//入驻品牌列表 end

//会员申请商家入驻表单填写数据插入 start
function get_steps_title_insert_form($pid = 0) {

	$steps_title = get_root_merchants_steps_title($pid);
	
	for ($i=0; $i<count($steps_title); $i++) {

		if (is_array($steps_title[$i]['cententFields'])) {
			$cententFields = $steps_title[$i]['cententFields'];
			for ($j=1; $j<=count($cententFields); $j++) {
				$arr['formName'] .= $cententFields[$j]['textFields'] . ',';
			}
		}
	}
	
	$arr['formName'] = substr($arr['formName'], 0, -1);

	return $arr;
}

//返回插入基本信息字段数据
function get_setps_form_insert_date($formName, $shop_id) {
	$upload    = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => true));
	$msf_db    = RC_Loader::load_app_model('merchants_steps_fields_model','seller');
	$formName  = explode(',', $formName);
	
	$arr = array();
	for ($i=0; $i<count($formName); $i++) {
		if (substr($formName[$i],-3) == 'Img') {  //如果上传文件字段是图片或者压缩包 字段命名必须是 ******Img 格式 (自定义的上传文件)
			if ((isset($_FILES[$formName[$i]]['error']) && $_FILES[$formName[$i]]['error'] == 0) ||(!isset($_FILES[$formName[$i]]['error']) && isset($_FILES[$formName[$i]]['tmp_name'] ) &&$_FILES[$formName[$i]]['tmp_name'] != 'none')) {
				//$arr[$formName[$i]] = $msf_db->where(array('user_id'=>$user_id))->get_field($formName[$i]);//原来图片的地址
				$arr[$formName[$i]] = $msf_db->where(array('shop_id'=>$shop_id))->get_field($formName[$i]);//原来图片的地址
				$info	= $upload->upload($_FILES[$formName[$i]]);
				if (!empty($info)) {
					$setps_thumb = $upload->get_position($info);
					//删除原来的图片
					$upload->remove($arr[$formName[$i]]);
					//文本隐藏域数据
					if (!empty($_POST['text_' . $formName[$i]])) {
						$textImg = $_POST['text_' . $formName[$i]];
					}
					
					if (empty($setps_thumb)) {
						if (!empty($textImg)) {
							$setps_thumb = $textImg;
						}
					}
					$arr[$formName[$i]] = $setps_thumb;
				}
			} else {
				//没有修改上传文件  则为原来的路径
				//$arr[$formName[$i]] = $msf_db->where(array('user_id'=>$user_id))->get_field($formName[$i]);
				$arr[$formName[$i]] = $msf_db->where(array('shop_id'=>$shop_id))->get_field($formName[$i]);
			}
		} else {
			if (!empty($_POST[$formName[$i]])) {
				$arr[$formName[$i]] = $_POST[$formName[$i]];
			}
		}
		if (!empty($arr[$formName[$i]]) && is_array($arr[$formName[$i]])) {
			$arr[$formName[$i]] = implode(',', $arr[$formName[$i]]);
		}
	}
	return $arr;
}
//会员申请商家入驻表单填写数据插入 end

//一级类目列表
function get_first_cate_list($parent_id = 0, $type = 0, $catarr = array(),$shop_id = 0) {
	if ($type == 1) {
		$mctdb = RC_Loader::load_app_model('merchants_category_temporarydate_model','seller');
		for ($i=0; $i<count($catarr); $i++) {
			if (!empty($catarr[$i])) {
				$mctdb->where(array('cat_id'=>$catarr[$i],'user_id'=>$shop_id))->delete();
			}
		}
		return array();
	} else {
		$c_db = RC_Loader::load_app_model('category_model', 'seller');
		$result = $c_db->field('cat_id, cat_name')->where(array('parent_id' => $parent_id))->select();
		return $result;
	}
}

//查询二级类目详细信息 start //ajax返回类目数组
function get_child_category($cat) { 
	
	$arr = array();
	for ($i=0; $i<count($cat); $i++) {
		if (!empty($cat[$i])) {
			$arr[$i] = $cat[$i];
			$arr['cat_id'] .= $cat[$i] . ',';
		}	
	}
	if (!empty($arr['cat_id'])) {
		$arr['cat_id'] = substr($arr['cat_id'], 0, -1);
	}
	return $arr;
}

//二级类目数据插入临时数据表
function get_add_childCategory_info($cat_id,$shop_id) {
	if (empty($cat_id)) {
		$cat_id = 0;
	}
	
	$catdb = RC_Loader::load_app_model('category_model','seller');
	$mctdb = RC_Loader::load_app_model('merchants_category_temporarydate_model','seller');
	
	$res = $catdb->field('cat_id,cat_name,parent_id')->in(array('cat_id'=>$cat_id))->order(array('cat_id'=>DESC))->select();
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$key = $key + 1;
		$arr[$key]['cat_id']      = $row['cat_id'];
		$arr[$key]['cat_name']    = $row['cat_name'];
		$arr[$key]['parent_name'] = $catdb->field('cat_name')->where(array('cat_id'=>$row['parent_id']))->find();
		$parent = array(
			//'user_id' 		=> $user_id,
			'shop_id'		=> $shop_id,
			'cat_id' 		=> $row['cat_id'],
			'parent_id' 	=> $row['parent_id'],
			'cat_name' 		=> $row['cat_name'],
			'parent_name' 	=> $arr[$key]['parent_name']['cat_name']
		);
		if ($cat_id != 0) {
			$ct_id = $mctdb->field('ct_id')->where(array('cat_id'=>$row['cat_id'],'user_id'=>$user_id))->find();
			
			if ($ct_id <= 0) {
				$mctdb->insert($parent);
			}
		}	
	}
	
	return $arr;
}

//查询临时数据表中的数据
function get_fine_category_info($cat_id, $shop_id) {

	if ($cat_id != 0) {
		get_add_childCategory_info($cat_id, $shop_id);
	}
	$mct_db = RC_Loader::load_app_model('merchants_category_temporarydate_model', 'seller');
	//原来逻辑
	//$res = $mct_db->field('ct_id, cat_id, cat_name, parent_name, parent_id')->where(array('user_id' => $user_id))->select();
	//现在逻辑
	$res = $mct_db->field('ct_id, cat_id, cat_name, parent_name, parent_id')->where(array('shop_id' => $shop_id))->select();
	$arr = array();
	if (!empty ($res)) {
		foreach ($res as $key=>$row) {
			$key = $key + 1;
			$arr[$key]['ct_id']          = $row['ct_id'];
			$arr[$key]['cat_id']         = $row['cat_id'];
			$arr[$key]['cat_name']       = $row['cat_name'];
			$arr[$key]['parent_name']    = $row['parent_name'];
			$arr[$key]['parent_id']      = $row['parent_id'];
		}
	}
	return $arr;
}

function get_permanent_parent_cat_id($shop_id = 0, $type = 0) {
	$db = RC_Loader::load_app_model('merchants_category_temporarydate_viewmodel', 'seller');
	$group_by = array();
	if ($type == 1) {
		$group_by = 'c.parent_id';
	}
	$row = $db->join(array('category'))->field('c.parent_id, mct.cat_id')->where(array('shop_id' => $shop_id))->group($group_by)->select();
	return $row;
}

//组合父ID的下级分类数组
function get_catId_array($shop_id = 0) {
    
	if ($shop_id <= 0) {
    	$shop_id = $_SESSION['shop_id'];
	}
	$res = get_permanent_parent_cat_id($shop_id);
	
	if (!empty($res)) {
		foreach ($res as $key=>$row) {
			@$arr[$row['parent_id']] .= $row['cat_id'] . ',';
		}
	}
	@$arr = get_explode_array($arr);
	return $arr;
}

function get_explode_array($arr) {
	$newArr = array();
	$i = 0;
	foreach ($arr as $key=>$row) {	
		$newArr[$i] = substr($key .":". $row, 0, -1);
		$i++;
	}
	
	return $newArr;
}

//查询类目证件标题列表
function get_category_permanent_list($shop_id) {
	$md_db     = RC_Loader::load_app_model('merchants_documenttitle_model','seller');
	$mdf_db    = RC_Loader::load_app_model('merchants_dt_file_model','seller');
	$res       = get_permanent_parent_cat_id($shop_id, 1);
	$c_db      = RC_Loader::load_app_model('category_model', 'seller');
	$arr       = array();
	$arr['parentId'] = '';
	if (!empty($res)) {
		foreach ($res as $key=>$row) {
			$arr[$key]['parent_id'] = $row['parent_id'];
			$arr['parentId'] .= $row['parent_id'] . ',';
		}
	}
	
	$arr['parentId'] = substr($arr['parentId'], 0, -1);
	if (empty($arr['parentId'])) {
		$arr['parentId'] = 0;
	}
	$new_parentId = substr($arr['parentId'], 0, 1);
	if ($new_parentId == ',') {
		$arr['parentId'] = substr($arr['parentId'], 1);
	}
	$res = $md_db->field('dt_id, dt_title, cat_id')->in(array('cat_id' => $arr['parentId']))->order('dt_id asc')->select();
	$parentId = $arr['parentId'];
	$arr = array();
	if (!empty($res)) {
		foreach ($res as $key=>$row) {
			$arr[$key]['dt_id']      = $row['dt_id'];
			$arr[$key]['dt_title']   = $row['dt_title'];
			$arr[$key]['cat_id']     = $row['cat_id'];
			$arr[$key]['cat_name']   = $c_db->where(array('cat_id' => $row['cat_id']))->get_field('cat_name');
		
			$row = $mdf_db->field('permanent_file, permanent_date, cate_title_permanent,dtf_id')->find(array('cat_id'	=> $row['cat_id'],'dt_id'=> $row['dt_id'],'shop_id' 	=> $shop_id));
		
			if (!empty($row['permanent_file'])) {
				$arr[$key]['permanent_file'] = RC_Upload::upload_url($row['permanent_file']);
			} else {
				$arr[$key]['permanent_file'] = '';
			}
			$arr[$key]['dtf_id'] = $row['dtf_id'];
			$arr[$key]['cate_title_permanent'] = $row['cate_title_permanent'];
			if (!empty($row['permanent_date'])) {
				$arr[$key]['permanent_date'] = RC_Time::local_date("Y-m-d H:i", $row['permanent_date']);
			}
		}
	}
	return $arr;
}

//删除类目时查找父级类目的含有数据数量
function get_temporarydate_ctId_catParent($ct_id) {
	$mctdb = RC_Loader::load_app_model('merchants_category_temporarydate_model','seller');
	
	$parent_id         = $mctdb->where(array('ct_id'=>$ct_id))->get_field('parent_id');
	$num               = $mctdb->field('ct_id')->where(array('parent_id'=>$parent_id))->count();
	$arr['parent_id']  = $parent_id;
    $arr['num']        = $num;
	
	
	return $arr;
}
//查询二级类目详细信息 end

//获取地区名称
function get_goods_region_name($region_id) {
	$sql = "select region_name from " .$GLOBALS['ecs']->table('region'). " where region_id = '$region_id'";
	return $GLOBALS['db']->getOne($sql);
}

//获取商品商家信息 start
function get_merchants_shop_info($table = '', $user_id = 0) {

	$sql = "select * from " .$GLOBALS['ecs']->table($table). " where user_id = '$user_id'";

	return $GLOBALS['db']->getRow($sql);		
}

function get_license_comp_adress($steps_adress) {
	$adress = explode(',', $steps_adress);
	
	$arr['province']   = '';
	$arr['city']       = '';
	$arr['province']   = get_goods_region_name($adress[1]);
	$arr['city']       = get_goods_region_name($adress[2]);
	
	if (!empty($arr['city'])) {
		$arr['city'] = $arr['city'] . '市';
	}
	
	return $arr;
}
//获取商品商家信息 end

//仓库 start
//----admin
/**
 * 获取地区仓库列表的函数。 ecmoban模板堂 --zhuo
 *
 * @access  public
 * @param   int     $region_id  上级地区id
 * @return  void
 */
function area_warehouse_list($region_id)
{
    $area_arr = array();

    $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('region_warehouse').
           " WHERE parent_id = '$region_id' ORDER BY region_id";
    $res = $GLOBALS['db']->query($sql);
	$i = 0;
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['type']  = ($row['region_type'] == 0) ? $GLOBALS['_LANG']['country']  : '';
        $row['type'] .= ($row['region_type'] == 1) ? $GLOBALS['_LANG']['province'] : '';
        $row['type'] .= ($row['region_type'] == 2) ? $GLOBALS['_LANG']['city']     : '';
        $row['type'] .= ($row['region_type'] == 3) ? $GLOBALS['_LANG']['cantonal'] : '';

        //$area_arr[] = $row;
		
		$area_arr[$i]['region_id']    = $row['region_id'];
		$area_arr[$i]['regionId']     = $row['regionId'];
		$area_arr[$i]['parent_id']    = $row['parent_id'];
		$area_arr[$i]['region_name']  = $row['region_name'];
		$area_arr[$i]['region_type']  = $row['region_type'];
		$area_arr[$i]['agency_id']    = $row['agency_id'];
		$area_arr[$i]['type']         = $row['type'];
		$area_arr[$i]['child']        = get_child_region($row['regionId']);
		$area_arr[$i]['region_child'] = area_warehouse_list($row['region_id']);
		
		$i++;
    }
	
    return $area_arr;
}

//查询是否还有子地区栏目
function get_child_region($region_id=0) {
	$sql = "select * from " .$GLOBALS['ecs']->table('region'). " where parent_id = '$region_id'";
	
	return $GLOBALS['db']->getAll($sql);
}

//获取配送方式列表
function warehouse_shipping_list($goods = array(), $region_id = 0, $number = 1, $goods_region = array()) {

        $sql = "select s.shipping_id, s.shipping_name, s.shipping_code from " .$GLOBALS['ecs']->table('shipping'). " as s, " .$GLOBALS['ecs']->table('shipping_area')." as sa ". " where 1 and s.shipping_id = sa.shipping_id group by s.shipping_id";
        $res = $GLOBALS['db']->getAll($sql);

        $arr = array();
        foreach ($res as $key=>$row) {
            $arr[$key]['shipping_id']   = $row['shipping_id'];
            $arr[$key]['shipping_name'] = $row['shipping_name'];
            
            if ($region_id > 0) {
                $shipping = get_goods_freight($goods, $region_id, $goods_region, $number, $row['shipping_code']);
                $arr[$key]['shipping_fee'] = price_format($shipping['shipping_fee'], false);
            }
        }
        
        return $arr;
}

//查询地区运费
function get_warehouse_freight_type($region_id) {
	
	//ecmoban模板堂 --zhuo start
	$adminru = get_admin_ru_id();
	if ($adminru['ru_id'] > 0) {
		$ru_id = $adminru['ru_id'];
	} else {
		$ru_id = 0;
	}
	
	$ruCat = " and wf.user_id = '$ru_id' ";
	//ecmoban模板堂 --zhuo end
	
	$sql = "select wf.id, wf.configure, wf.shipping_id, wf.region_id, s.shipping_name, rw1.region_name as region_name1, rw2.region_name as region_name2, s.support_cod, s.shipping_code from " .$GLOBALS['ecs']->table('warehouse_freight'). " as wf " . 
			" left join " .$GLOBALS['ecs']->table('region_warehouse'). " as rw1 on wf.warehouse_id = rw1.region_id" . 
			" left join " .$GLOBALS['ecs']->table('shipping'). " as s on wf.shipping_id = s.shipping_id" . 
			" left join " .$GLOBALS['ecs']->table('region_warehouse'). " as rw2 on wf.region_id = rw2.regionId" . 
			" where wf.region_id = '$region_id' " .$ruCat. " group by wf.shipping_id order by id asc";
	
	return $GLOBALS['db']->getAll($sql);
}
//------root
//查询仓库下的省、直辖市区
function get_warehouse_province($type = 'root', $ra_id = 0) {
	$sql = "select rw2.regionId, rw2.region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " as rw1 left join " .
	
			$GLOBALS['ecs']->table('region_warehouse') . " as rw2" .
			" on rw1.region_id = rw2.parent_id" .
			
			" where rw1.region_type = 0 order by rw2.regionId asc";
			
	$res = $GLOBALS['db']->getAll($sql);
//	print_r($res);
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['region_id']   = $row['regionId'];
		$arr[$key]['region_name'] = $row['region_name'];
		
		$where = '';
		if ($type == 'admin') {
			
			if ($ra_id > 0) {
				$where = "ra_id <> '$ra_id' and ";
			}
			
			$where .= "region_id = '" .$row['regionId']. "'";
			
			$date = array('region_id');
			$region_id = get_table_date('merchants_region_info', $where, $date);
			
			if ($region_id > 0) {
				$arr[$key]['disabled'] = 1;
			} else {
				$arr[$key]['disabled'] = 0;
			}
			
			if ($ra_id > 0) {
				$where      = "ra_id = '$ra_id' and " . "region_id = '" .$row['regionId']. "'";
				$date       = array('region_id');
				$region_id  = get_table_date('merchants_region_info', $where, $date);
				
				if ($region_id > 0) {
					$arr[$key]['checked'] = 1;
				} else {
					$arr[$key]['checked'] = 0;
				}
			}
		}
	}
	
	return $arr;
}

//查询省、直辖市下所有地区
function get_region_city_county($city_district) {
	
	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region'). " where parent_id = '$city_district' group by region_id";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['region_id'] = $row['region_id'];
		$arr[$key]['region_name'] = $row['region_name'];
	}
	
	return $arr;
}

//查询仓库 
function get_warehouse_list_goods($region_type = 0) {
	
	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where region_type = '$region_type'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['region_id'] = $row['region_id'];
		$arr[$key]['region_name'] = $row['region_name'];
	}
	
	return $arr;
}

function get_warehouse_name_id($region_id = 0,$region_name = '') { //获取仓库名称或者ID

	if (!empty($region_name)) {
		$name_type = "region_name = '$region_name' and region_type = '$region_id'";
		$region_id = '';
		$region = "region_id";
	} else {
		$name_type = '';
		$region_type = '';
		
		$region_id = "region_id = '$region_id'";
		
		$region = "region_name";
	}

	$sql = "select " .$region. " from " .$GLOBALS['ecs']->table('region_warehouse'). " where " . $region_id . $name_type;
	
	return $GLOBALS['db']->getOne($sql);
}

//查询地区名称
function get_region_name($region_id) {
	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region'). " where region_id = '$region_id'";
	
	return $GLOBALS['db']->getRow($sql);
}

//查询会员的收货地址
function get_user_address_region($user_id) {
	$sql = "select address_id, province, city, district from " .$GLOBALS['ecs']->table('user_address'). " where user_id = '$user_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['address_id'] = $row['address_id'];
		$arr[$key]['province'] 	 = $row['province'];
		$arr[$key]['city'] 		 = $row['city'];
		$arr[$key]['district'] 	 = $row['district'];
		
		$arr['region_address'] .= $row['province']. "," . $row['city']. "," . $row['district']. ",";
	}
	$arr['region_address'] = substr($arr['region_address'], 0, -1);
	
	return $arr;
}
//查询用户订单
function get_user_order_area($user_id = 0) {
	$sql = "select country, province, city, district from " .$GLOBALS['ecs']->table('order_info'). " where user_id = '$user_id' order by order_id DESC";
	return $GLOBALS['db']->getRow($sql);
}

function get_user_area_reg($user_id) {
	$sql = "select ut.province, ut.city, ut.district from " .$GLOBALS['ecs']->table('users') ." as u " . 
			" left join " .$GLOBALS['ecs']->table('users_type'). " as ut on u.user_id = ut.user_id" .
			" where u.user_id = '$user_id'";
	return $GLOBALS['db']->getRow($sql);
}

function get_province_id_warehouse($province_id) {
	$sql = "select parent_id from " .$GLOBALS['ecs']->table('region_warehouse'). " where regionId = '$province_id'";
	return $GLOBALS['db']->getOne($sql);
}
//查询地区region_id
function get_region_name_goods($region_type = 1, $region_name = '') {
	$sql = "select region_id from " .$GLOBALS['ecs']->table('region'). " where region_name = '$region_name' and region_type = '$region_type'";
	
	return $GLOBALS['db']->getOne($sql);
}
//查询子地区是否存在，有1个或者N个
function get_region_child_num($id = 0) {
	$sql = 'select region_id from ' .$GLOBALS['ecs']->table('region'). " where parent_id = '$id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	return count($res);
}
//查询配送地区所属仓库
function get_warehouse_goods_region($province_id) {
	$sql = "select rw2.region_id, rw2.region_name from" .$GLOBALS['ecs']->table('region_warehouse'). " as rw1 left join " .$GLOBALS['ecs']->table('region_warehouse'). " as rw2 on rw1.parent_id = rw2.region_id" . " where rw1.regionId = '$province_id'";
	return $GLOBALS['db']->getRow($sql);
}

//查询商品的默认配送方式运费金额
function get_goods_freight($goods, $warehouse_id = 0, $goods_region = array(), $buy_number = 1, $shipping_code) {
	
	$sql = "select shipping_code, shipping_name from " .$GLOBALS['ecs']->table('shipping'). " where shipping_code = '$shipping_code'";
	$shipping = $GLOBALS['db']->getRow($sql);
        
	$city_configure = get_goods_freight_configure($goods, $warehouse_id, $goods_region['city'], $shipping_code);
	$province_configure = get_goods_freight_configure($goods, $warehouse_id, $goods_region['province'], $shipping_code);

	if (!empty($city_configure)) {
		$configure = $city_configure;
	} else {
		$configure = $province_configure;
	}
        
    $shipping_cfg = sc_unserialize_config($configure);
	$configure_price = goods_shipping_fee($shipping_code,$configure, $goods['weight'], $goods['goods_price'], $goods['number']);
	
	$arr['shipping_fee']       = $configure_price;
	$arr['configure_price']    = price_format($configure_price, false);
	$arr['shipping_name']      = $shipping['shipping_name'];	
	
	$arr['item_fee']           = price_format($shipping_cfg['item_fee'], false); /* 单件商品的配送价格（默认） */
	$arr['base_fee']           = price_format($shipping_cfg['base_fee'], false); /* N(500或1000克)克以内的价格 */
	$arr['step_fee']           = price_format($shipping_cfg['step_fee'], false); /* 续重每N(500或1000克)克增加的价格 */
	$arr['free_money']         = price_format($shipping_cfg['free_money'], false); //免费额度
	$arr['fee_compute_mode']   = $shipping_cfg['fee_compute_mode']; //费用计算方式
	@$arr['pay_fee']           = price_format($shipping_cfg['pay_fee'], false); //货到付款支付费用
	
	$arr['warehouse_id']       = $warehouse_id;
        
	return $arr;
}

//查询商品设置配送地区运费数据
function get_goods_freight_configure($goods, $warehouse_id, $region_id, $shipping_code) {
	
	$user_id = $goods['ru_id'];
	
	$date = array('shipping_id');
	$where = "shipping_code = '$shipping_code'";
	$shipping_id = get_table_date('shipping', $where, $date, 2);
	
	$sql = "select configure from " .$GLOBALS['ecs']->table('warehouse_freight'). " where user_id = '$user_id' and warehouse_id = '$warehouse_id' and shipping_id = '$shipping_id' and region_id = '$region_id'";
	return $GLOBALS['db']->getOne($sql);
}
//获取仓库数组
function get_warehouse_list($type = 0, $goods_id = 0) { 

	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where 1 and region_type = '$type'";
	
	return $GLOBALS['db']->getAll($sql);
}

//批量添加商品仓库库存
function get_insert_warehouse_goods($goods_id = 0, $warehouse_name = array(), $warehouse_number = array(), $warehouse_price = array(), $warehouse_promote_price = array(), $user_id = 0) {

	$add_time = gmtime();
	for ($i=0;$i<count($warehouse_name);$i++) {
		if (!empty($warehouse_name[$i])) {
			
			if ($warehouse_number[$i] == 0) {
				$warehouse_number[$i] = 1;
			}
			
			$sql = "select w_id from " .$GLOBALS['ecs']->table('warehouse_goods'). " where goods_id = '$goods_id' and region_id = '" .$warehouse_name[$i]. "'";
			$w_id = $GLOBALS['db']->getOne($sql);
			
			if ($w_id > 0) {
				$link[] = array('text' => '返回一页', 'href'=>'goods.php?act=edit&goods_id=' .$goods_id. '&extension_code=');
				sys_msg('该商品的仓库库存已存在', 0, $link);
				break;
			} else {
				$sql = "insert into " .$GLOBALS['ecs']->table('warehouse_goods'). 
						"(goods_id, region_id, region_number, warehouse_price, warehouse_promote_price, user_id, add_time)VALUES('" .
						$goods_id. "','" . $warehouse_name[$i] . "','" . intval($warehouse_number[$i]) . "','" . floatval($warehouse_price[$i]) . "','" . floatval($warehouse_promote_price[$i]) . "','$user_id','$add_time')";
				$GLOBALS['db']->query($sql);
			}
		}
	}
	
}

//批量添加商品地区价格
function get_insert_warehouse_area_goods($goods_id = 0, $area_name = array(), $region_number = array(), $region_price = array(), $region_promote_price = array(), $user_id = 0) {

	$add_time = gmtime();
	for ($i=0;$i<count($area_name);$i++) {
		if (!empty($area_name[$i])) {
			
			$sql = "select a_id from " .$GLOBALS['ecs']->table('warehouse_area_goods'). " where goods_id = '$goods_id' and region_id = '" .$area_name[$i]. "'";
			$a_id = $GLOBALS['db']->getOne($sql);
			
			if ($a_id > 0) {
				$link[] = array('text' => '返回一页', 'href'=>'goods.php?act=edit&goods_id=' .$goods_id. '&extension_code=');
				sys_msg('该商品的地区价格已存在', 0, $link);
				break;
			} else {
				$sql = "insert into " .$GLOBALS['ecs']->table('warehouse_area_goods'). 
						"(goods_id, region_id, region_number, region_price, region_promote_price, user_id, add_time)VALUES('" .
						$goods_id. "','" . $area_name[$i]. "','" . $region_number[$i] . "','" . floatval($region_price[$i]) . "','" . floatval($region_promote_price[$i]) . "','$user_id','$add_time')";
		
				$GLOBALS['db']->query($sql);
			}
		}
	}
	
}
//查询仓库列表
function get_warehouse_goods_list($goods_id = 0) {
	$adminru = get_admin_ru_id();

	if ($adminru['ru_id'] > 0) {
		$ru_id =  " and wg.user_id = '" .$adminru['ru_id']. "'";
	}
	
	$sql = "select wg.w_id, wg.region_id, wg.region_number, wg.warehouse_price, wg.warehouse_promote_price, rw.region_name from " .$GLOBALS['ecs']->table('warehouse_goods'). " as wg left join " .$GLOBALS['ecs']->table('region_warehouse') ." as rw on wg.region_id = rw.region_id". " where wg.goods_id = '$goods_id'" . $ru_id;
	return $GLOBALS['db']->getAll($sql);
}

//查询仓库列表
function get_warehouse_area_goods_list($goods_id = 0) {
	$adminru = get_admin_ru_id();

	if ($adminru['ru_id'] > 0) {
		$ru_id =  " and wag.user_id = '" .$adminru['ru_id']. "'";
	}
	
	$sql = "select wag.a_id, wag.region_id, wag.region_number, wag.region_price, wag.region_promote_price, wag.region_sort, rw.region_name, rw.parent_id from " .$GLOBALS['ecs']->table('warehouse_area_goods'). " as wag left join " .$GLOBALS['ecs']->table('region_warehouse') ." as rw on wag.region_id = rw.region_id". " where wag.goods_id = '$goods_id'" . $ru_id . " order by wag.region_sort asc";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key] = $row;
		$arr[$key]['warehouse_name'] = $GLOBALS['db']->getOne("select region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where region_id = '" .$row['parent_id']. "'");
	}
	
	return $arr;
}

//批量添加货号 start
function get_produts_warehouse_list($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		$arr[$i]['goods_id']          = get_products_name($goods_list[$i]['goods_name'],'goods');
		$arr[$i]['warehouse_id']      = get_products_name($goods_list[$i]['warehouse_id'],'region_warehouse');
		$arr[$i]['goods_attr']        = $goods_list[$i]['goods_attr'];
		$arr[$i]['product_sn']        = $goods_list[$i]['product_sn'];
		$arr[$i]['product_number']    = $goods_list[$i]['product_number'];
	}
	
	return $arr;
}

function get_insert_produts_warehouse($goods_list) {
	$arr = array();
	
	for ($i=0;$i<count($goods_list);$i++) {
		
		if ($goods_list[$i]['goods_id'] > 0) {
			$other['goods_id']       = $goods_list[$i]['goods_id'];
			$goods_attr              = get_produts_warehouse_attr_list($goods_list[$i]['goods_attr'], $goods_list[$i]['goods_id']);
			$other['goods_attr']     = $goods_attr['goods_attr'];
			$other['warehouse_id']   = $goods_list[$i]['warehouse_id'];
			$other['product_sn']     = $goods_list[$i]['product_sn'];
			$other['product_number'] = $goods_list[$i]['product_number'];
			
			

			$sql = "select product_id from " .$GLOBALS['ecs']->table('products_warehouse'). " where goods_id = '" . $other['goods_id'] ."'". 
					" and goods_attr = '" . $other['goods_attr'] ."'".  
					" and warehouse_id = '" . $other['warehouse_id'] . "'";
			
			$res = $GLOBALS['db']->getOne($sql);
			
			if ($res > 0) {
				$return = 1;
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('products_warehouse'), $other, 'UPDATE', "goods_id = '" . $other['goods_id'] ."'". 
					" and goods_attr = '" . $other['goods_attr'] ."'".  
					" and warehouse_id = '" . $other['warehouse_id'] . "'");
			} else {
				$return = 0;
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('products_warehouse'), $other, 'INSERT');
			}
		}		
	}
	
	return $return;
}

function get_produts_area_list($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		$arr[$i]['goods_id']          = get_products_name($goods_list[$i]['goods_name'],'goods');
		$arr[$i]['area_id']           = get_products_name($goods_list[$i]['area_id'],'region_warehouse');
		$arr[$i]['goods_attr']        = $goods_list[$i]['goods_attr'];
		$arr[$i]['product_sn']        = $goods_list[$i]['product_sn'];
		$arr[$i]['product_number']    = $goods_list[$i]['product_number'];
	}
	
	return $arr;
}

function get_insert_produts_area($goods_list) {
	$arr = array();
	
	for ($i=0;$i<count($goods_list);$i++) {
		
		if ($goods_list[$i]['goods_id'] > 0) {
			$other['goods_id']       = $goods_list[$i]['goods_id'];
			$goods_attr              = get_produts_warehouse_attr_list($goods_list[$i]['goods_attr'], $goods_list[$i]['goods_id']);
			$other['goods_attr']     = $goods_attr['goods_attr'];
			$other['area_id']        = $goods_list[$i]['area_id'];
			$other['product_sn']     = $goods_list[$i]['product_sn'];
			$other['product_number'] = $goods_list[$i]['product_number'];
			
			

			$sql = "select product_id from " .$GLOBALS['ecs']->table('products_area'). " where goods_id = '" . $other['goods_id'] ."'". 
					" and goods_attr = '" . $other['goods_attr'] ."'".  
					" and area_id = '" . $other['area_id'] . "'";
			
			$res = $GLOBALS['db']->getOne($sql);
			
			if ($res > 0) {
				$return = 1;
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('products_area'), $other, 'UPDATE', "goods_id = '" . $other['goods_id'] ."'". 
					" and goods_attr = '" . $other['goods_attr'] ."'".  
					" and area_id = '" . $other['area_id'] . "'");
			} else {
				$return = 0;
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('products_area'), $other, 'INSERT');
			}
		}		
	}
	
	return $return;
}

function get_produts_warehouse_attr_list($goods_attr = '', $goods_id = 0) {

	$goods_attr = explode(',', $goods_attr);

	$arr = array();
	for ($i=0; $i<count($goods_attr); $i++) {
		$sql = "select goods_attr_id, attr_value from " .$GLOBALS['ecs']->table('goods_attr'). " where goods_id = '$goods_id' and attr_value = '" .$goods_attr[$i]. "'";
		$row = $GLOBALS['db']->getRow($sql);

		$arr[$i]['goods_attr_id'] = $row['goods_attr_id'];
		$arr[$i]['attr_value']    = $row['attr_value'];
		
		$arr['goods_attr'] .= $row['goods_attr_id'] .'|';
	}

	$arr['goods_attr'] = substr($arr['goods_attr'], 0, -1);
	
	return $arr;
}

//查找商品ID
function get_products_name($name,$table) {
	
	$as = '';
	if ($table === 'goods') {
		$select = "goods_id";
		$whereName = "goods_name = '" .$name. "' and is_delete = 0"; 
	} elseif ($table === 'region_warehouse') {
		$select = "region_id";
		$whereName = "region_name = '" .$name. "'"; 
	}
	
	$sql = "select " .$select. " from " .$GLOBALS['ecs']->table($table) . " where " . $whereName;
	return $GLOBALS['db']->getOne($sql);
}
//批量添加货号 end

//批量添加商品仓库 start
function get_goods_bacth_warehouse_list($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		
		$where_goods = "goods_name = '" .$goods_list[$i]['goods_name']. "'";
		$where_region = "region_name = '" .$goods_list[$i]['warehouse_name']. "'";
		
		$arr[$i]['user_id']                   = get_table_date('goods', $where_goods, array('user_id'), 2);
		$arr[$i]['goods_id']                  = get_table_date('goods', $where_goods, array('goods_id'), 2);
		$arr[$i]['region_id']                 = get_table_date('region_warehouse', $where_region, array('region_id'), 2);
		$arr[$i]['region_number']             = $goods_list[$i]['warehouse_number'];
		$arr[$i]['warehouse_price']           = $goods_list[$i]['warehouse_price'];
		$arr[$i]['warehouse_promote_price']   = $goods_list[$i]['warehouse_promote_price'];
		$arr[$i]['add_time']                  = gmtime();
	}
	
	return $arr;
}

function get_insert_bacth_warehouse($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		
		if ($goods_list[$i]['goods_id'] > 0) {
			if (empty($goods_list[$i]['warehouse_price'])) {
				$goods_list[$i]['warehouse_price'] = 0;
			}
			
			if (empty($goods_list[$i]['warehouse_promote_price'])) {
				$goods_list[$i]['warehouse_promote_price'] = 0;
			}
			
			$other['user_id']                    = $goods_list[$i]['user_id'];
			$other['goods_id']                   = $goods_list[$i]['goods_id'];
			$other['region_id']                  = $goods_list[$i]['region_id'];
			$other['region_number']              = $goods_list[$i]['region_number'];
			$other['warehouse_price']            = $goods_list[$i]['warehouse_price'];
			$other['warehouse_promote_price']    = $goods_list[$i]['warehouse_promote_price'];
			$other['add_time']                   = $goods_list[$i]['add_time'];
			
			$sql = "select w_id from " .$GLOBALS['ecs']->table('warehouse_goods'). " where user_id = '" . $other['user_id'] ."' and goods_id = '" . $other['goods_id'] ."'". 
					" and region_id = '" . $other['region_id'] ."'";
			
			$res = $GLOBALS['db']->getOne($sql);

			if ($res > 0) {
				$return = 1;
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_goods'), $other, 'UPDATE'," user_id = '" . $other['user_id'] ."' and goods_id = '" . $other['goods_id'] ."'". 
					" and region_id = '" . $other['region_id'] ."'");
			} else {
				$return = 0;
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_goods'), $other, 'INSERT');
			}
		}		
	}
	
	return $return;
}
//批量添加商品仓库 end

//批量添加商品地区 start
function get_goods_bacth_area_list($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		
		$where_goods  = "goods_name = '" .$goods_list[$i]['goods_name']. "'";
		$where_region = "region_name = '" .$goods_list[$i]['area_name']. "'";
		
		$arr[$i]['user_id']               = get_table_date('goods', $where_goods, array('user_id'), 2);
		$arr[$i]['goods_id']              = get_table_date('goods', $where_goods, array('goods_id'), 2);
		$arr[$i]['region_id']             = get_table_date('region_warehouse', $where_region, array('region_id'), 2);
		$arr[$i]['region_number']         = $goods_list[$i]['region_number'];
		$arr[$i]['region_price']          = $goods_list[$i]['region_price'];
		$arr[$i]['region_promote_price']  = $goods_list[$i]['region_promote_price'];
		$arr[$i]['add_time']              = gmtime();
		$arr[$i]['region_sort']           = $goods_list[$i]['region_sort'];
	}
	
	return $arr;
}

function get_insert_bacth_area($goods_list) {
	
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		
		if ($goods_list[$i]['goods_id'] > 0) {
			if (empty($goods_list[$i]['region_price'])) {
				$goods_list[$i]['region_price'] = 0;
			}
			
			if (empty($goods_list[$i]['region_promote_price'])) {
				$goods_list[$i]['region_promote_price'] = 0;
			}
			
			$other['user_id']                = $goods_list[$i]['user_id'];
			$other['goods_id']               = $goods_list[$i]['goods_id'];
			$other['region_id']              = $goods_list[$i]['region_id'];
			$other['region_number']          = $goods_list[$i]['region_number'];
			$other['region_price']           = $goods_list[$i]['region_price'];
			$other['region_promote_price']   = $goods_list[$i]['region_promote_price'];
			$other['add_time']               = $goods_list[$i]['add_time'];
			$other['region_sort']            = $goods_list[$i]['region_sort'];
			
			$sql = "select a_id from " .$GLOBALS['ecs']->table('warehouse_area_goods'). " where user_id = '" . $other['user_id'] ."' and goods_id = '" . $other['goods_id'] ."'". 
					" and region_id = '" . $other['region_id'] ."'";
			
			$res = $GLOBALS['db']->getOne($sql);

			$arr['goods_id'] = $other['goods_id'];
			if ($res > 0) {
				$arr['return'] = 1;
				$return = $arr;
			
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_area_goods'), $other, 'UPDATE'," user_id = '" . 
				$other['user_id'] ."' and goods_id = '" . $other['goods_id'] ."'". 
				" and region_id = '" . $other['region_id'] ."'");
			} else {
				$arr['return'] = 0;
				$return = $arr;
				
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_area_goods'), $other, 'INSERT');
			}
		}		
	}

	return $return;
}
//批量添加商品地区 end

//批量添加商品地区属性 start
function get_goods_bacth_area_attr_list($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		
		$where_goods = "goods_name = '" .$goods_list[$i]['goods_name']. "'";
		$where_region = "region_name = '" .$goods_list[$i]['area_name']. "'";
		$where_attr = "attr_value = '" .$goods_list[$i]['attr_name']. "'";
		
		$arr[$i]['goods_id']      = get_table_date('goods', $where_goods, array('goods_id'), 2);
		$arr[$i]['area_id']       = get_table_date('region_warehouse', $where_region, array('region_id'), 2);
		$arr[$i]['goods_attr_id'] = get_table_date('goods_attr', $where_attr, array('goods_attr_id'), 2);
		$arr[$i]['attr_price']    = $goods_list[$i]['attr_price'];
		$arr[$i]['attr_number']   = $goods_list[$i]['attr_number'];
	}
	
	return $arr;
}

function get_insert_bacth_area_attr($goods_list) {
	$arr = array();
	for ($i=0;$i<count($goods_list);$i++) {
		
		if ($goods_list[$i]['goods_id'] > 0) {
			if (empty($goods_list[$i]['attr_price'])) {
				$goods_list[$i]['attr_price'] = 0;
			}
			
			$other['goods_id']       = $goods_list[$i]['goods_id'];
			$other['area_id']        = $goods_list[$i]['area_id'];
			$other['goods_attr_id']  = $goods_list[$i]['goods_attr_id'];
			$other['attr_price']     = $goods_list[$i]['attr_price'];
			$other['attrNumber']     = $goods_list[$i]['attr_number'];
			
			$sql = "select id from " .$GLOBALS['ecs']->table('warehouse_area_attr'). " where goods_id = '" . $other['goods_id'] ."' and area_id = '" . $other['area_id'] ."'". 
					" and goods_attr_id = '" . $other['goods_attr_id'] ."'";
			
			$res = $GLOBALS['db']->getOne($sql);

			$arr['goods_id'] = $other['goods_id'];
			if ($res > 0) {
				$arr['return'] = 1;
				$return = $arr;
			
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_area_attr'), $other, 'UPDATE'," goods_id = '" . $other['goods_id'] ."' and area_id = '" . $other['area_id'] ."'". 
					" and goods_attr_id = '" . $other['goods_attr_id'] ."'");
			} else {
				$arr['return'] = 0;
				$return = $arr;
				
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_area_attr'), $other, 'INSERT');
			}
		}		
	}

	return $return;
}
//批量添加商品地区属性 end

//查询属性商品仓库库存
function get_warehouse_id_attr_number($goods_id, $attr_id = '', $admin_id, $warehouse_id, $area_id, $model_attr = '') {
	
        if (empty($model_attr)) {
            $model_attr = get_table_date("goods", "goods_id = '$goods_id'", array('model_attr'), 2);
        }

	if (empty($attr_id)) {
		$attr_id = 0;
	} else {
		$attr_id = str_replace(',', '|', $attr_id);
	}
	
	$where = '';
	if ($model_attr == 1) {
		$table = "products_warehouse";
		$where = " and warehouse_id = '$warehouse_id'";
	} elseif ($model_attr == 2) {
		$table = "products_area";
		$where = " and area_id = '$area_id'";
	} else {
		$table = "products";
	}
	
	$sql = "select product_number, product_sn from " .$GLOBALS['ecs']->table($table). " where goods_id = '$goods_id' and goods_attr = '$attr_id'" . $where;

	return $GLOBALS['db']->getRow($sql);
}

//计算会员下订单的商品总运费
function get_goods_order_shipping_fee($goods = array(), $region = '', $shipping_code = '') {

	$arr = array();
	$arr['shipping_fee'] = 0;
	
	//订单总运费计算
	$cart_goods            = get_warehouse_cart_goods_info($goods, 1, $region, $shipping_code);
	$arr['shipping_fee']   = $cart_goods['shipping']['shipping_fee'];
	$arr['ru_list']        = $cart_goods['ru_list'];
	return $arr;
}

//获取仓库共有多少个地区数量
function get_all_warehouse_area_count() {
	
	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where parent_id = 0";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $row) {
		$arr[$row['region_id']]['region_id'] = $row['region_id'];
		$arr['region_id'] .= $row['region_id'] . ",";
	}
	
	$arr['region_id'] = substr($arr['region_id'], 0, -1);
	
	if (!empty($arr['region_id'])) {
		$sql = "select count(*) from " .$GLOBALS['ecs']->table('region_warehouse'). " where parent_id in(" .$arr['region_id']. ")";
		$count = $GLOBALS['db']->getOne($sql);
	} else {
		$count = 0;
	}

	return $count;
}

//查询仓库地区列表
function get_warehouse_area_list($warehouse_id = 0) {
	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where parent_id = '$warehouse_id'";
	return $GLOBALS['db']->getAll($sql);
}

//查询地区ID和名称
function get_area_info($province_id = 0) {
	$sql = "select region_id, region_name from " .$GLOBALS['ecs']->table('region_warehouse'). " where regionId = '$province_id'";
	return $GLOBALS['db']->getRow($sql);
}

//操作新数组attr_id --应用后台 start
function get_new_goods_attribute($goods_id, $_attribute = array()) {
	
	$arr = array();
	foreach ($_attribute as $key=>$row) {
		$arr[$key]                    = $row;
		$arr[$key]['attr_valuesId']   = get_goods_attr_values_id($row['attr_values'], $row['goods_attr_id']);
		$arr[$key]['goods_attr']      = get_attribute_goods_attr($row['attr_id']);
		$arr[$key]['goods_attr']      = product_list($goods_id, '', $arr[$key]['goods_attr']['goods_attr_id']);
	}
	
	return $arr;
}

function get_attribute_goods_attr($attr_id = 0) {
	$sql = "select goods_attr_id from " .$GLOBALS['ecs']->table('goods_attr'). " where attr_id = '$attr_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key] = $row;
		$arr['goods_attr_id'] .= $row['goods_attr_id'] . ",";
	}
	
	if (!empty($arr['goods_attr_id'])) {
		$arr['goods_attr_id'] = substr($arr['goods_attr_id'], 0, -1);
	}
	
	return $arr;
}

function get_goods_attr_values_id($attr_values = array(), $goods_attr_id = array()) {
	
	$arr = array();
	for ($i=0; $i<count($attr_values); $i++) {
		$arr[$i]['attr_value']    = $attr_values[$i];
		$arr[$i]['goods_attr_id'] = $goods_attr_id[$i];
	}

	return $arr;	
}
//操作新数组attr_id --应用后台 end

//获取商品的属性ID
function get_goods_attr_nameId($goods_id = 0, $attr_id = 0, $attr_value = '') {
	$sql = "select goods_attr_id from " .$GLOBALS['ecs']->table('goods_attr'). " where goods_id = '$goods_id' and attr_id = '$attr_id' and attr_value = '$attr_value'";
	return $GLOBALS['db']->getOne($sql);
}

//获取所有的仓库地区列表
function get_fine_warehouse_area_all($parent_id = 0, $goods_id = 0, $goods_attr_id = 0) {
	
	$sql = "select region_id, region_name, parent_id from " .$GLOBALS['ecs']->table('region_warehouse'). " where parent_id = '$parent_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['region_id'] = $row['region_id'];
		$arr[$key]['region_name'] = $row['region_name'];
		
		if ($row['parent_id'] == 0) {
			$arr[$key]['child'] = get_fine_warehouse_area_all($row['region_id'], $goods_id, $goods_attr_id);
		}		
		
		$sql = "select * from " .$GLOBALS['ecs']->table('warehouse_area_attr'). " where goods_id = '$goods_id' and goods_attr_id = '$goods_attr_id' and area_id = '" .$row['region_id']. "'";
		$area_attr = $GLOBALS['db']->getRow($sql);
		$arr[$key]['area_attr'] = $area_attr;
	}
	
	return $arr;
}

//插入地区属性价格数据
function get_area_attr_price_insert($area_name, $goods_id, $goods_attr_id) {
	
	$arr = array();
	for ($i=0; $i<count($area_name); $i++) {
		if (!empty($area_name[$i])) {
			
			$parent = array(
					'goods_id'         => $goods_id,
					'goods_attr_id'    => $goods_attr_id,
					'area_id'          => $area_name[$i],
					'attr_price'       => $_POST['attrPrice_' . $area_name[$i]]
				);
			
			$sql = "select id from " .$GLOBALS['ecs']->table('warehouse_area_attr'). " where goods_id = '$goods_id' and goods_attr_id = '$goods_attr_id' and area_id = '" .$area_name[$i]. "'";
			$id = $GLOBALS['db']->getOne($sql);
			
			if ($id > 0) {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_area_attr'), $parent, 'UPDATE',"goods_id = '$goods_id' and goods_attr_id = '$goods_attr_id' and area_id = '" .$area_name[$i]. "'");
			} else {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_area_attr'), $parent, 'INSERT');
			}
		}
	}
}

//获取所有的仓库地区列表
function get_fine_warehouse_all($parent_id = 0, $goods_id = 0, $goods_attr_id = 0) {
	
	$sql = "select rw.region_id, rw.region_name, wa.attr_price from " .$GLOBALS['ecs']->table('region_warehouse') ." as rw". 
			" left join " .$GLOBALS['ecs']->table('warehouse_attr'). " as wa on rw.region_id = wa.warehouse_id and wa.goods_id = '$goods_id' and wa.goods_attr_id = '$goods_attr_id'" .
			" where rw.parent_id = '$parent_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['region_id']   = $row['region_id'];
		$arr[$key]['region_name'] = $row['region_name'];	
		$arr[$key]['attr_price']  = $row['attr_price'];	
	}
	
	return $arr;
}

//插入仓库属性价格数据
function get_warehouse_attr_price_insert($warehouse_name, $goods_id, $goods_attr_id) {
	
	$arr = array();
	for ($i=0; $i<count($warehouse_name); $i++) {
		if (!empty($warehouse_name[$i])) {
			
			$parent = array(
					'goods_id'         => $goods_id,
					'goods_attr_id'    => $goods_attr_id,
					'warehouse_id'     => $warehouse_name[$i],
					'attr_price'       => $_POST['attr_price_' . $warehouse_name[$i]]
				);
			
			$sql = "select id from " .$GLOBALS['ecs']->table('warehouse_attr'). " where goods_id = '$goods_id' and goods_attr_id = '$goods_attr_id' and warehouse_id = '" .$warehouse_name[$i]. "'";
			$id = $GLOBALS['db']->getOne($sql);
			
			if ($id > 0) {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_attr'), $parent, 'UPDATE',"goods_id = '$goods_id' and goods_attr_id = '$goods_attr_id' and warehouse_id = '" .$warehouse_name[$i]. "'");
			} else {
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('warehouse_attr'), $parent, 'INSERT');
			}
		}
	}
}

//查询该地区商品已在购物车中N件
function get_goods_cart_num($goods_id = 0, $warehouse_id = 0) {
	
	if (!empty($_SESSION['user_id'])) {
		$sess_id = " user_id = '" . $_SESSION['user_id'] . "' ";
	} else {
		$sess_id = " session_id = '" . real_cart_mac_ip() . "' ";
	}

	$sql = "SELECT goods_number FROM " .$GLOBALS['ecs']->table('cart') .
			" WHERE goods_id = '$goods_id' AND warehouse_id = '$warehouse_id' AND " . $sess_id;	
	return $GLOBALS['db']->getOne($sql);
}

//仓库 end

//订单分主订单和从订单 start
/**
 * 得到新订单号
 * @return  string
 */
function get_order_child_sn()
{
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);

    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

//获取主订单信息
function get_main_order_info($order_id = 0, $type = 0) { 
	$sql = "select * from " .$GLOBALS['ecs']->table('order_info'). " where order_id = '$order_id'";
	$row = $GLOBALS['db']->getRow($sql);
	
	if ($type == 1) {
		$row['all_ruId'] = get_main_order_goods_info($order_id, 1); //订单中所有商品所属商家ID,0代表自营商品，其它商家商品
		$ru_id = explode(",", $row['all_ruId']['ru_id']);
		if (count($ru_id) > 1) {
			$row['order_goods']      = get_main_order_goods_info($order_id);
			$row['newInfo']          = get_new_ru_goods_info($row['all_ruId'], $row['order_goods']);
			$row['newOrder']         = get_new_order_info($row['newInfo']);
			$row['orderBonus']       = get_new_order_info($row['newInfo'],1, $row['bonus_id']); //处理商家分单红包
			$row['orderFavourable']  = get_new_order_info($row['newInfo'],2); //处理商家分单优惠活动
		}
	}
	
	return $row;
}

//获取订单信息--或者--订单中所有商品所属商家ID,0代表自营商品，其它商家商品
function get_main_order_goods_info($order_id = 0, $type = 0) {
	$sql = "select og.*, g.goods_weight as goodsWeight from " .$GLOBALS['ecs']->table('order_goods') ." as og, " .$GLOBALS['ecs']->table('goods') ." as g". " where og.goods_id = g.goods_id and og.order_id = '$order_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
    if ($type == 1) {
		$arr['ru_id'] = '';
	} 
	foreach ($res as $key=>$row) {
		if ($type == 0) {
			$arr[] = $row;
		} else {
			$arr['ru_id'] .= $row['ru_id'] . ',';
		}
	}
	
	if ($type == 1) {
		$arr['ru_id'] = explode(',', substr($arr['ru_id'], 0, -1));
		$arr['ru_id'] = array_unique($arr['ru_id']);
		$arr['ru_id'] = implode(',', $arr['ru_id']);
	}

	return $arr;
}

//主次订单拆分新数组
function get_new_ru_goods_info($all_ruId = '', $order_goods = array()) {	
	$all_ruId = $all_ruId['ru_id'];
	$arr = array();

    if (!empty($all_ruId)) {
		$all_ruId = explode(',', $all_ruId);
		$all_ruId = array_values($all_ruId);
	}
	
	if ($all_ruId) {
		for ($i=0; $i<count($order_goods); $i++) {
			for ($j=0; $j<count($all_ruId); $j++) {
				if ($order_goods[$i]['ru_id'] == $all_ruId[$j]) {
					$arr[$all_ruId[$j]][$i] = $order_goods[$i];
				}
			}
		}
	}
	
	//get_print_r($arr);
	return $arr;
}

//运算分单后台每个订单商品总金额以及划分红包类型使用所属商家
function get_new_order_info($newInfo, $type = 0, $bonus_id = 0) {
	
	$arr = array();
	
	if ($type == 0) {
		foreach ($newInfo as $key=>$row) { 
			$arr[$key]['goods_amount'] = 0;
			$arr[$key]['shopping_fee'] = 0;
			$arr[$key]['goods_id'] = 0;
	
			$arr[$key]['ru_list'] = get_cart_goods_combined_freight($row, 2); //计算商家运费
			
			$row = array_values($row);
			for ($j=0; $j<count($row); $j++) {
                            $arr[$key]['goods_id'] = $row[$j]['goods_id'];
                                
                            //ecmoban模板堂 --zhuo start 商品金额促销
                            $goods_amount = $row[$j]['goods_price'] * $row[$j]['goods_number'];
                            if ($goods_amount > 0) {
                                    $goods_con = get_con_goods_amount($goods_amount, $row[$j]['goods_id'], 0, 0, $row[$j]['parent_id']);

                                    $goods_con['amount'] = explode(',', $goods_con['amount']);
                                    $amount = min($goods_con['amount']);

                                    $arr[$key]['goods_amount'] += $amount;
                            } else {
                                    $arr[$key]['goods_amount'] += $row[$j]['goods_price'] * $row[$j]['goods_number']; //原始
                            }

                            $arr[$key]['shopping_fee'] = $arr[$key]['ru_list']['shipping_fee'];
                            //ecmoban模板堂 --zhuo end 商品金额促销
			}
		}
	} elseif ($type == 1) { //红包
		foreach ($newInfo as $key=>$row) {
			
			$arr[$key]['user_id'] = $key;
			$bonus = get_bonus_merchants($bonus_id, $key); //红包信息
			$arr[$key]['bonus'] = $bonus;
		}
	} elseif ($type == 2) { //优惠活动
		foreach ($newInfo as $key=>$row) {
			$arr[$key]['user_id'] = $key;
			$arr[$key]['compute_discount'] = compute_discount($type, $row);
		}
	}

	return $arr;
}

//分单插入数据
function get_insert_order_goods_single($orderInfo, $row, $order_id) {
	$newOrder          = $orderInfo['newOrder'];
	$orderBonus        = $orderInfo['orderBonus'];
	$newInfo           = $orderInfo['newInfo'];
	$orderFavourable   = $orderInfo['orderFavourable'];
	$surplus           = $row['surplus'];//余额
	$integral_money    = $row['integral_money'];//积分
    $use_bonus         = 0;
    
    $bonus_id          = $row['bonus_id'];//红包ID
    $bonus             = $row['bonus'];//红包金额
    
    $usebonus_type     = get_bonus_all_goods($bonus_id); //全场通用红包 val:1
	
	$arr = array();
	foreach ($newInfo as $key=>$info) {
		
		$arr[$key] = $info;
		
		// 插入订单表 start

		$error_no = 0;
		do
		{
			$row['order_sn']         = get_order_child_sn(); //获取新订单号
			$row['main_order_id']    = $order_id; //获取主订单ID
			$row['goods_amount']     = $newOrder[$key]['goods_amount']; //商品总金额
			
			$row['discount']         = $orderFavourable[$key]['compute_discount']['discount']; //折扣金额
			$row['shipping_fee']     = $newOrder[$key]['shopping_fee']; //运费金额
			$row['order_amount']     = $newOrder[$key]['goods_amount'] - $row['discount'] + $row['shipping_fee']; //订单应付金额
                        
                        // 减去红包 start
                        if ($usebonus_type == 1) {       
                            if ($bonus > 0) {
                                if ($row['order_amount'] >= $bonus) {
                                    $row['order_amount'] = $row['order_amount'] - $bonus;
                                    $row['bonus'] = $bonus; 
                                    $bonus = 0;
                                } else {
                                    $bonus = $bonus - $row['order_amount'];
                                    $row['bonus'] = $row['order_amount']; 
                                    $row['order_amount'] = 0;
                                }
                                
                                $row['bonus_id'] = $bonus_id; 
                            } else {
                                $row['bonus'] = 0; 
                                $row['bonus_id'] = 0; 
                            }
                              
                        } else {
                            if (isset($orderBonus[$key]['bonus']['type_money'])) {
                                $use_bonus = min($orderBonus[$key]['bonus']['type_money'], $row['order_amount']); // 实际减去的红包金额
                                $row['order_amount'] -= $use_bonus;
                                $row['bonus'] = $orderBonus[$key]['bonus']['type_money']; 
                                $row['bonus_id'] = $row['bonus_id']; 
                            } else {
                                $row['bonus'] = 0; 
                                $row['bonus_id'] = 0; 
                            }
                        }
                        // 减去红包 end
                        
			//余额 start
			if ($surplus > 0) {
				if ($surplus >= $row['order_amount']) {
					$surplus               = $surplus - $row['order_amount'];
					$row['surplus']        = $row['order_amount']; //订单金额等于当前使用余额
					$row['order_amount']   = 0;
				} else {
					$row['order_amount']   = $row['order_amount'] - $surplus;
					$row['surplus']        = $surplus;
					$surplus = 0;
				}
			} else {
				$row['surplus'] = 0;
			}
			//余额 end
			
			//积分 start
			if ($integral_money > 0) {
				if ($integral_money >= $row['order_amount']) {
					$integral_money        = $integral_money - $row['order_amount'];
					$row['integral_money'] = $row['order_amount']; //订单金额等于当前使用余额
					$row['integral']       = $row['order_amount'];
					$row['order_amount']   = 0;
				} else {
					$row['order_amount']   = $row['order_amount'] - $integral_money;
					$row['integral_money'] = $integral_money;
					$row['integral']       = $integral_money;
					$integral_money = 0;
				}
			} else {
				$row['integral_money']  = 0;
				$row['integral']        = 0;
			}
			//积分 end
                        
                        $row['order_amount'] = number_format( $row['order_amount'] ,  2 ,  '.',  ''); //格式化价格为一个数字
                        
			/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
			if ($row['order_amount'] <= 0)
			{
				$row['order_status'] = OS_CONFIRMED;
				$row['confirm_time'] = gmtime();
				$row['pay_status']   = PS_PAYED;
				$row['pay_time']     = gmtime();
			} else {
				$row['order_status'] = 0;
				$row['confirm_time'] = 0;
				$row['pay_status']   = 0;
				$row['pay_time']     = 0;
			}
			
			unset($row['order_id']);
                        
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $row, 'INSERT');
			$new_orderId = $GLOBALS['db']->insert_id();
	
			$error_no = $GLOBALS['db']->errno();
	
			if ($error_no > 0 && $error_no != 1062)
			{
				die($GLOBALS['db']->errorMsg());
			}
                        
                        $sql = "SELECT seller_email FROM " .$GLOBALS['ecs']->table('seller_shopinfo'). " WHERE ru_id = '$key'";
                        $seller_email = $GLOBALS['db']->getOne($sql);
                        
                        /* 给商家发邮件 */
                        /* 增加是否给客服发送邮件选项 */
                        if ($GLOBALS['_CFG']['send_service_email'] && $seller_email != '' && $GLOBALS['_CFG']['seller_email'] == 1)
                        {
                            $cart_goods = $arr[$key];
                            
                            $order['order_sn']          = $row['order_sn']; //订单号
                            $order['order_amount']      = $row['order_amount']; //订单金额
                            $order['consignee']         = $row['consignee']; //收货人
                            $order['address']           = $row['address']; //收货人地址
                            $order['tel']               = $row['tel']; //收货人电话
                            $order['mobile']            = $row['mobile']; //收货人手机
                            $order['shipping_name']     = $row['shipping_name']; //配送方式
                            $order['shipping_fee']      = $row['shipping_fee'];  //运费
                            $order['pay_id']            = $row['pay_id']; //付款ID
                            $order['pay_name']          = $row['pay_name']; //付款名称
                            $order['pay_fee']           = $row['pay_fee']; //付款金额
                            $order['surplus']           = $row['surplus']; //余额支付
                            $order['integral_money']    = $row['integral_money']; //使用积分
                            $order['bonus']             = $row['bonus']; //使用红包
                                    
                            $tpl = get_mail_template('remind_of_new_order');
                            $GLOBALS['smarty']->assign('order', $order);
                            $GLOBALS['smarty']->assign('goods_list', $cart_goods);
                            $GLOBALS['smarty']->assign('shop_name', $GLOBALS['_CFG']['shop_name']);
                            $GLOBALS['smarty']->assign('send_date', date($GLOBALS['_CFG']['time_format']));
                            $content = $GLOBALS['smarty']->fetch('str:' . $tpl['template_content']);
                            send_mail($GLOBALS['_CFG']['shop_name'], $seller_email, $tpl['template_subject'], $content, $tpl['is_html']);
                        }
		}
		while ($error_no == 1062); //如果是订单号重复则重新提交数据
		
		$arr[$key] = array_values($arr[$key]);		
		for ($j=0; $j<count($arr[$key]); $j++) {
			$arr[$key][$j]['order_id'] = $new_orderId;
			unset($arr[$key][$j]['rec_id']);
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_goods'), $arr[$key][$j], 'INSERT');
		}
		
		/* 插入支付日志 by wanganlin */
		$row['log_id'] = insert_pay_log($new_orderId, $row['order_amount'], PAY_ORDER);
	}
}

//查询订单中所使用的红包等归属信息，所属商家(ID : bt.user_id)
function get_bonus_merchants($bonus_id = 0, $user_id = 0) {
	$sql = "select bt.user_id, bt.type_money from " .$GLOBALS['ecs']->table('user_bonus'). " as ub" . 
			" left join " .$GLOBALS['ecs']->table('bonus_type'). " as bt on ub.bonus_type_id = bt.type_id" . 
			" where ub.bonus_id = '$bonus_id' and bt.user_id = '$user_id'";
	
	return $GLOBALS['db']->getRow($sql);		
} 

//根据订单商品查询商品信息
function get_order_goods_toInfo($order_id = 0) {
	$sql = "select g.goods_id, g.goods_name, g.goods_img from " .$GLOBALS['ecs']->table('order_goods')." as og left join " .$GLOBALS['ecs']->table('goods') ." as g on og.goods_id = g.goods_id".  " where og.order_id = '$order_id' group by g.goods_id order by g.goods_id";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();	
	foreach ($res as $key=>$row) {
		$arr[$key]['goods_id'] 		= $row['goods_id'];
		$arr[$key]['goods_name'] 	= $row['goods_name'];
		$arr[$key]['goods_img'] 	= $row['goods_img'];
		$arr[$key]['url']        	= build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
	}
	
	return $arr;
}

//查询订单分单信息
function get_child_order_info($order_id) {
	$sql = "select order_sn, order_amount, shipping_fee, order_id from " .$GLOBALS['ecs']->table('order_info'). " where main_order_id = '$order_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['order_sn']     = $row['order_sn'];
		$arr[$key]['order_id']     = $row['order_id'];
        $arr[$key]['order_amount'] = price_format($row['order_amount'], false);
		$arr[$key]['shipping_fee'] = price_format($row['shipping_fee'], false);
	}
	
	return $arr;
}

//订单分主订单和从订单 end

//获取列表商家
function get_merchants_user_list() {
	$sql = "select msi.* from " .$GLOBALS['ecs']->table('merchants_shop_information') ." as msi". " where 1";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key] = $row;
		
		$date = array('user_name');
		$user_name = get_table_date('users', "user_id = '" .$row['user_id']. "'", $date, 2);
		$arr[$key]['user_name'] = $user_name;
	}
	
	return $arr;
}

//区域划分 start
function get_region_area_divide() {
	$sql = "select ra_id, ra_name from " .$GLOBALS['ecs']->table('merchants_region_area'). " where 1 order by ra_sort asc";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key] = $row;
		$arr[$key]['area_list'] = get_to_area_list($row['ra_id']);
	}
	
	return $arr;
}

function get_to_area_list($ra_id = 0) {
	$sql = "select ra_id, region_id from " .$GLOBALS['ecs']->table('merchants_region_info'). " where ra_id = '$ra_id' order by region_id asc";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key] = $row;
		$date = array('region_name');
		$arr[$key]['region_name'] = get_table_date('region', "region_id = '" .$row['region_id']. "'", $date, 2);
	}
	
	return $arr;
}
//区域划分 end

//独立店铺 start

//店铺导航
function get_user_store_category($ru_id) {
	$sql = "select mc.cat_id, c.cat_name, c.sort_order as vieworder from " .$GLOBALS['ecs']->table('merchants_category'). " as mc " .
			" left join " .$GLOBALS['ecs']->table('category'). " as c on mc.cat_id = c.cat_id " . 
			" where mc.user_id = '$ru_id' and mc.is_show = 1";
	$res = $GLOBALS['db']->getAll($sql);		
			
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]            = $row;
		$arr[$key]['url']     = build_uri('merchants_store', array('cid' => $row['cat_id'], 'urid' => $ru_id), $row['cat_name']);
		$arr[$key]['opennew'] = 0;
		$arr[$key]['child']   = get_store_category_child($row['cat_id'], $ru_id);
	}
	
	$navigator_list = get_merchants_navigator($ru_id);
	$arr = array_merge($navigator_list['middle'], $arr);

	return $arr;
}

function get_store_category_child($parent_id, $ru_id) {
	$sql = "select c.cat_id, c.cat_name from " .$GLOBALS['ecs']->table('merchants_category'). " as mc " . 
			" left join " .$GLOBALS['ecs']->table('category'). " as c on mc.cat_id = c.cat_id ".
			" where c.parent_id = '$parent_id' and mc.user_id = '$ru_id'";
	$res = $GLOBALS['db']->getAll($sql);		
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['cat_id']      = $row['cat_id'];
		$arr[$key]['cat_name']    = $row['cat_name'];
		$arr[$key]['url']         = build_uri('merchants_store', array('cid' => $row['cat_id'], 'urid' => $ru_id), $row['cat_name']);
		$arr[$key]['child']       = get_store_category_child($row['cat_id']);
	}
	
	return $arr;
}
//独立店铺 end

function selled_count($goods_id, $type = '') {
	
	if (!empty($type)) {
		$where = " AND og.order_id = oi.order_id and oi.extension_code = '$type'";
	} else {
		$where = " AND og.order_id = oi.order_id ";
	}
	
	$where .= "AND (oi.order_status = '" . OS_CONFIRMED .  "' OR oi.order_status = '" . OS_SPLITED . "') " .
				"AND (oi.pay_status = '" . PS_PAYED . "' OR oi.pay_status = '" . PS_PAYING . "') " .
				"AND (oi.shipping_status = '" . SS_SHIPPED . "' OR oi.shipping_status = '" . SS_RECEIVED . "')";
	
	$where .= " group by g.goods_id";			
	
	$sql= "select g.sales_volume as count from ".$GLOBALS['ecs']->table('order_goods') ." as og , " .$GLOBALS['ecs']->table('goods') ." as g , " . $GLOBALS['ecs']->table('order_info')." as oi ".
			" where og.goods_id = g.goods_id and og.goods_id ='".$goods_id."'" . $where;	
			
	$res = $GLOBALS['db']->getOne($sql);
	if ($res>0) {
		return $res;
	} else {
		return 0;
	}
}

//查询一级与二级分类
function get_oneTwo_category($parent_id = 0) {
	$sql = "select cat_id, cat_name from " .$GLOBALS['ecs']->table('category'). " where parent_id = '$parent_id'";
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key] = $row;
		$arr[$key]['child'] = get_oneTwo_category($row['cat_id']);
		
		if (empty($arr[$key]['child'])) {
			unset($arr[$key]['child']);
		}
	}
	
	return $arr;
}
  
//通过地区ID查询地区名称
function get_order_region_name($region_id = 0) {
	$where  = "region_id = '$region_id'";
	$date   = array('region_name');
	$region = get_table_date('region', $where, $date);
	
	return $region;
}

//获取购物选择商品最终金额
function get_cart_check_goods($cart_goods, $rec_id = '') {
    
    $arr['amount'] = 0;
    if (!empty($rec_id)) {
        if ($cart_goods) {
            foreach ($cart_goods as $row) {
                $arr['amount'] += $row['subtotal'];
            }
        }
    }
    
    $arr['amount'] = price_format($arr['amount'], false);
    return $arr['amount'];
}

//弹出层数据 
function get_all_area_list($parent_id = 0, $region_type = 1) {
	
	$where = '';
	if ($region_type > 1) {
		$where .= " r.parent_id = '$parent_id' AND r.region_type = '$region_type'";
	} else {
		$where .= " rw.regionId > 0 and r.region_id = rw.regionId AND r.region_type = '$region_type'";
	}
	
	$sql = "SELECT r.region_id, r.region_name FROM " .$GLOBALS['ecs']->table('region_warehouse'). " as rw, " .
			$GLOBALS['ecs']->table('region') ." as r ". " WHERE " . $where . " GROUP BY r.region_id order by r.region_id ASC";
				
	$res = $GLOBALS['db']->getAll($sql);
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['region_id']   = $row['region_id'];
		$arr[$key]['region_name'] = $row['region_name'];
	}
	
	return $arr;
}

//ecmoban模板堂 --zhuo start 天猫属性

//获取商品区间价格的最小和最大值价格 start
function get_goods_minMax_price($goods_id = 0, $warehouse_id = 0, $area_id = 0, $goods_price, $market_price, $type = 1) {
	
	$model_attr = get_table_date("goods", "goods_id = '$goods_id'", array('model_attr'), 2);
	
	if ($model_attr == 1) { //仓库属性
            $where .= " AND wa.warehouse_id = '$warehouse_id'";
            $slelect = ', wa.attr_price as attr_price';

            $leftJoin = " LEFT JOIN " . $GLOBALS['ecs']->table('warehouse_attr'). " AS wa on ga.goods_attr_id = wa.goods_attr_id ";
	} elseif ($model_attr == 2) { //地区属性
            $where .= " AND waa.area_id = '$area_id'";
            $slelect = ', waa.attr_price as attr_price';

            $leftJoin = " LEFT JOIN " . $GLOBALS['ecs']->table('warehouse_area_attr'). " AS waa on ga.goods_attr_id = waa.goods_attr_id ";
	} elseif ($model_attr == 0) {
            $slelect = ', ga.attr_price as attr_price';
            $where = '';
            $leftJoin = '';
	}
	
	$sql = 'SELECT ga.attr_id ' .$slelect. ' FROM ' . $GLOBALS['ecs']->table('goods_attr') ." as ga ".$leftJoin. " WHERE ga.goods_id = '$goods_id' " . $where;
	$arr_res = $GLOBALS['db']->getAll($sql);

	$arr_k = array();
	if ($arr_res) {
            foreach ($arr_res as $val) {
                    $arr_k .= $val['attr_id'].'@';
            }
            $arr_k = rtrim($arr_k,'@');

            $k_res = explode('@',$arr_k);
            $k_res = array_flip(array_flip($k_res));
	}
	 
	$new_arr = array(); 
	if ($k_res) {
            foreach ($k_res as $val) {
                foreach ($arr_res as $v) {
                    if ($v['attr_id'] == $val) {
                       $new_arr[$val][] = $v['attr_price']; 
                    }
                }
            }
	}
	
	if ($type == 1) {
            $new_arr = get_unset_null_array($new_arr, 2);
	}
	
	$new_arr_res = array();
	if ($new_arr) {
            foreach ($new_arr as $k=>$val) {
                $new_arr_res[$k]['max'] = $val[array_search(max($val), $val)];
                $new_arr_res[$k]['min'] = $val[array_search(min($val),$val)];
            }

            $num_res_max = 0; 
            $num_res_min = 0;
            foreach ($new_arr_res as $val) {
                $num_res_max += $val['max'];
                $num_res_min += $val['min'];
            }
	}

	if ($type == 1) { //商品组合购买	
		$arr['goods_min'] = $goods_price + $num_res_min;
		$arr['goods_max'] = $goods_price + $num_res_max;
		
		$arr['market_min'] = $market_price + $num_res_min;
		$arr['market_max'] = $market_price + $num_res_max;
		
	} elseif ($type == 2) { //商品普通购买
		
		$goodsLeftJoin = '';
		$goodsLeftJoin .= " left join " .$GLOBALS['ecs']->table('warehouse_goods'). " as wg on g.goods_id = wg.goods_id and wg.region_id = '$warehouse_id' ";
		$goodsLeftJoin .= " left join " .$GLOBALS['ecs']->table('warehouse_area_goods'). " as wag on g.goods_id = wag.goods_id and wag.region_id = '$area_id' ";

		$sql = 'SELECT ' . 
		
				"IFNULL(mp.user_price, if (g.model_price < 1, g.shop_price, if (g.model_price < 2, wg.warehouse_price, wag.region_price)) * '$_SESSION[discount]') AS shop_price, " .
				"if (g.model_price < 1, g.promote_price, if (g.model_price < 2, wg.warehouse_promote_price, wag.region_promote_price)) as promote_price, " .		
                'g.promote_start_date, g.promote_end_date, g.is_promote ' .
				
				$goodsLeftJoin.
				
				'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . ' AS mp ' .
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " .		
				' FROM ' . $GLOBALS['ecs']->table('goods') ." as g ". 
				"WHERE goods_id = '$goods_id'";
		
		$goods = $GLOBALS['db']->getRow($sql);
		
		if ($goods['promote_price'] > 0)
		{
			$promote_price = bargain_price($goods['promote_price'], $goods['promote_start_date'], $goods['promote_end_date']);
		}
		else
		{
			$promote_price = 0;
		}
		
		$promote_price  = ($promote_price > 0) ? $promote_price : '';
		
		if (!empty($promote_price)) {
			$arr['promote_minPrice'] = price_format($promote_price + $num_res_min);
			$arr['promote_maxPrice'] = price_format($promote_price + $num_res_max);
		} else {
			$arr['promote_minPrice'] = $promote_price;
			$arr['promote_maxPrice'] = $promote_price;
		}
		
		$arr['shop_minPrice'] = price_format($goods['shop_price'] + $num_res_min);
		$arr['shop_maxPrice'] = price_format($goods['shop_price'] + $num_res_max);
	}
	
	return $arr;
}

//删掉值为0的数组
/*
 * 1 = 一维数组
 * 2 = 二维数组
*/
function get_unset_null_array($arr = array(), $type = 0) {
	
	$arr = array_values($arr);
	
	$new_arr = array();
	if ($arr && $type == 2) {
		for ($i=0; $i<count($arr); $i++) {
			for ($j=0; $j<count($arr[$i]); $j++) {
				if ($arr[$i][$j] > 0) {
					$new_arr[$i][$j] = $arr[$i][$j];
				}
			}
		}
	} elseif ($arr && $type == 1) {
		for ($i=0; $i<count($arr); $i++) {
			if ($arr[$i] > 0) {
				$new_arr[$i] = $arr[$i];
			}
		}
	}
	
	return $new_arr;
}

//查询已选择组合购买商品的区间价格
function get_choose_goods_combo_cart($fittings) {
    $arr = array();

    $arr['fittings_min']            = 0;
    $arr['fittings_max']            = 0;
    $arr['market_min']              = 0;
    $arr['market_max']              = 0;
    $arr['save_price']              = '';
    $arr['collocation_number']      = 0;
    $arr['save_minPrice']           = 0;
    $arr['save_maxPrice']           = 0;
    $arr['fittings_price']          = 0;
    $arr['fittings_market_price']   = 0;
    $arr['save_price_amount']       = 0;
    $arr['groupId']                 = 0;
    $arr['all_price_ori']           = 0;
    $arr['return_attr']             = 0;

    if ($fittings) {
        foreach ($fittings as $key=>$row) {
            $arr[$key]['goods_id']              = $row['goods_id'];		
            $arr[$key]['market_price']          = $row['market_price'] + $row['attr_price']; //实际市场价
            $arr[$key]['fittings_minPrice']     = $row['fittings_minPrice'];		//配件区间价格 min
            $arr[$key]['fittings_maxPrice']     = $row['fittings_maxPrice'];		//配件区间价格 max
            $arr[$key]['market_minPrice'] 		= $row['market_minPrice'];		//市场区间价格 min
            $arr[$key]['market_maxPrice'] 		= $row['market_maxPrice'];		//市场区间价格 max
            $arr[$key]['shop_price_ori']        = $row['shop_price_ori'];			//商品原价
            $arr[$key]['fittings_price_ori'] 	= $row['fittings_price_ori'];		//配件价格
            $arr[$key]['attr_price']            = $row['attr_price'];			//配件商品属性金额
            $arr[$key]['spare_price_ori'] 		= $row['spare_price_ori'];		//商品原价 - 配件价格 = 节省价
            $arr[$key]['group_id'] 				= !empty($row['group_id']) ? $row['group_id'] : 0;				//组ID
            $arr[$key]['is_attr'] 				= get_cart_combo_goods_product_list($row['goods_id']); 
            

            if ($arr[$key]['group_id'] == 0) {
                $arr[$key]['price_ori']	= $row['shop_price_ori'] + $row['attr_price'];
            } else {
                $arr[$key]['price_ori']	= $row['fittings_price_ori'] + $row['attr_price'];
            }
            
            $arr['save_price_amount']     += $row['spare_price_ori']; //配件商品节省总金额
            $arr['fittings_price']        += $arr[$key]['price_ori']; //配件商品总金额
            $arr['fittings_market_price'] += $row['market_price']; //配件商品市场价总金额

            $arr['save_price'] .= $row['spare_price_ori'] . ",";

            if (!empty($row['group_id'])) {
                $arr['groupId'] .= $row['group_id'] . ",";
            }
        }	

        $arr['collocation_number'] = count($fittings) - 1;

        $arr['save_price'] = substr($arr['save_price'], 0, -1);
        $arr['save_price'] = explode(',', $arr['save_price']);
        $arr['save_price'] = get_unset_null_array($arr['save_price'], 1);

        $arr['save_minPrice'] = min($arr['save_price']);
        $arr['save_maxPrice'] = get_save_maxPrice($arr['save_price']);

        $arr['groupId'] = substr($arr['groupId'], 1, -1);
        $arr['groupId'] = explode(',', $arr['groupId']);
        $arr['groupId'] = array_unique($arr['groupId']);
        $arr['groupId'] = implode(',', $arr['groupId']);  
        
        $minmax_values = get_min_or_max_values($arr);
        
        $arr['fittings_min']        = $minmax_values['fittings_minPrice'];
        $arr['fittings_max']        = $minmax_values['fittings_maxPrice'];
        $arr['market_min']          = $minmax_values['market_minPrice'];
        $arr['market_max']          = $minmax_values['market_maxPrice'];
        
        $arr['return_attr']         = $minmax_values['return_attr']; //判断配件商品是否有属性
        $arr['all_price_ori']       = $minmax_values['all_price_ori'];
        $arr['all_market_price']    = $minmax_values['all_market_price'];
    }
    
    return $arr;
}

//获取数组里面最小值和最大值
function get_min_or_max_values($arr) {
    
    $unsetStr = "fittings_min,fittings_max,market_min,market_max,save_price,collocation_number,save_minPrice,save_maxPrice,fittings_price,save_price_amount,groupId,all_price_ori,return_attr,fittings_market_price";
    $unsetStr = explode(',', $unsetStr);
    
    foreach ($unsetStr as $str) {
        unset($arr[$str]);
    }
    
    $newArr = array();
    $newArr['fittings_minPrice'] = '';
    $newArr['fittings_maxPrice'] = '';
    $newArr['market_minPrice']  = '';
    $newArr['market_maxPrice']  = '';
    $newArr['is_attr']          = '';
    $shop_price                 = 0;
    $market_price               = 0;
    $newArr['all_price_ori']    = 0;
    $newArr['return_attr']      = 0;
    $newArr['all_market_price'] = 0;
    
    //get_print_r($arr);
    foreach ($arr as $key=>$row) {
        if ($key > 0) {
            $newArr['all_price_ori']        += $row['price_ori'] . ',';
            $newArr['all_market_price']     += $row['market_minPrice'] . ',';
            $newArr['fittings_minPrice']    .= $row['fittings_minPrice'] . ',';
            $newArr['fittings_maxPrice']    .= $row['fittings_maxPrice'] . ',';
            $newArr['market_minPrice']      .= $row['market_minPrice'] . ',';
            $newArr['market_maxPrice']      .= $row['market_maxPrice'] . ',';
            $newArr['is_attr']              .= $row['is_attr'] . ',';
        }
    }
    
    $is_attr = explode(",", substr($newArr['is_attr'], 0, -1));
    
    foreach ($is_attr as $key=>$row) {
        $newArr['return_attr'] += $row;
    }
    
    $fittings_maxPrice = explode(",", substr($newArr['fittings_maxPrice'], 0, -1));
    $market_maxPrice = explode(",", substr($newArr['market_maxPrice'], 0, -1));
    
    foreach ($fittings_maxPrice as $key=>$shop) {
        $shop_price += $shop;
    }
    
    $newArr['fittings_maxPrice'] = $shop_price;
    
    foreach ($market_maxPrice  as $key=>$market) {
        $market_price += $market;
    }
    
    $newArr['market_maxPrice'] = $market_price;
    
    $newArr['fittings_minPrice'] = $arr[0]['fittings_minPrice'] + min(explode(",", substr($newArr['fittings_minPrice'], 0, -1)));
    $newArr['fittings_maxPrice'] = $arr[0]['fittings_maxPrice'] + $newArr['fittings_maxPrice'];
    $newArr['market_minPrice']   = $arr[0]['market_minPrice'] + min(explode(",", substr($newArr['market_minPrice'], 0, -1)));
    $newArr['market_maxPrice']   = $arr[0]['market_maxPrice'] + $newArr['market_maxPrice'];
    
    $newArr['all_price_ori']     = $arr[0]['price_ori'] + $newArr['all_price_ori']; //实际搭配价
    $newArr['all_market_price']  = $arr[0]['market_price'] + $arr[0]['attr_price'] + $newArr['all_market_price']; //实际搭配市场价
    
    return $newArr;
}

//查询组合购买里面的配件商品是否有货品
function get_cart_combo_goods_product_list($goods_id) {
    $sql = "SELECT goods_attr_id, goods_id, attr_id FROM " .$GLOBALS['ecs']->table('goods_attr'). " WHERE goods_id = '$goods_id'";
    $attr_list = $GLOBALS['db']->getAll($sql);
    
    if ($attr_list) { //当商品没有货品时
        return 1;
    } else {
        return 0;
    }
}

function get_save_maxPrice($save_price) {
	$save_maxPrice = 0;
	if ($save_price) {
		foreach ($save_price as $key=>$row) {
			$save_maxPrice += $row;
		}
	}
	
	return $save_maxPrice;
}

//查询商品属性类型列表
function get_goods_attr_type_list($goods_id = 0, $type = 0) {
	$sql = "select a.attr_id, a.attr_name from " .$GLOBALS['ecs']->table('goods_attr') ." as ga " . 
				" left join " .$GLOBALS['ecs']->table('attribute'). " as a on ga.attr_id = a.attr_id " .
				" where goods_id = '$goods_id' group by a.attr_id";
	$attr_list = $GLOBALS['db']->getAll($sql);
	
	if ($type == 1) {
		$attr_list = count($attr_list);
	}
	
	return $attr_list;
}
//获取商品区间价格的最小和最大值价格 end

//查询订单是否全场通用
function get_bonus_all_goods($bonus_id) {
    $sql = "SELECT t.usebonus_type FROM " .$GLOBALS['ecs']->table('bonus_type') ." as t, " .$GLOBALS['ecs']->table('user_bonus') ." as ub". " WHERE t.type_id = ub.bonus_type_id AND ub.bonus_id = '$bonus_id'";
    return $GLOBALS['db']->getOne($sql);
}

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串
 * @param    string   $field_name     字段名称
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '') {
	if (empty($item_list)) {
		return $field_name . " IN ('') ";
	} else {
		if (!is_array($item_list)) {
			$item_list = explode(',', $item_list);
		}
		$item_list = array_unique($item_list);
		$item_list_tmp = '';
		foreach ($item_list AS $item) {
			if ($item !== '')
			{
				$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
			}
		}
		if (empty($item_list_tmp)) {
			return $field_name . " IN ('') ";
		} else {
			return $field_name . ' IN (' . $item_list_tmp . ') ';
		}
	}
}

//end