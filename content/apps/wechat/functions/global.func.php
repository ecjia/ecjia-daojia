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

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('wechat', RC_Lang::get('wechat::wechat.wechat'));
	ecjia_admin_log::instance()->add_object('menu', RC_Lang::get('wechat::wechat.weixin_menu'));
	ecjia_admin_log::instance()->add_object('template', RC_Lang::get('wechat::wechat.message_template'));
	ecjia_admin_log::instance()->add_object('qrcode', RC_Lang::get('wechat::wechat.channel_code'));
	ecjia_admin_log::instance()->add_object('share', RC_Lang::get('wechat::wechat.sweep_recommend'));
	ecjia_admin_log::instance()->add_object('customer', RC_Lang::get('wechat::wechat.service'));
	
	ecjia_admin_log::instance()->add_object('article_material', RC_Lang::get('wechat::wechat.map_material'));
	ecjia_admin_log::instance()->add_object('articles_material', RC_Lang::get('wechat::wechat.maps_material'));
	
	ecjia_admin_log::instance()->add_object('picture_material', RC_Lang::get('wechat::wechat.picture_material'));
	ecjia_admin_log::instance()->add_object('voice_material', RC_Lang::get('wechat::wechat.voice_material'));
	ecjia_admin_log::instance()->add_object('video_material', RC_Lang::get('wechat::wechat.video_material'));
	
	ecjia_admin_log::instance()->add_object('reply_subscribe', RC_Lang::get('wechat::wechat.attention_auto_reply'));
	ecjia_admin_log::instance()->add_object('reply_msg', RC_Lang::get('wechat::wechat.message_auto_reply'));
	ecjia_admin_log::instance()->add_object('reply_keywords_rule', RC_Lang::get('wechat::wechat.keyword_auto_reply'));
	
	ecjia_admin_log::instance()->add_action('batch_move', RC_Lang::get('wechat::wechat.batch_move'));
	ecjia_admin_log::instance()->add_action('send', RC_Lang::get('wechat::wechat.send_msg'));
	
	ecjia_admin_log::instance()->add_object('users_tag', RC_Lang::get('wechat::wechat.user_tag'));
	ecjia_admin_log::instance()->add_object('users_info', RC_Lang::get('wechat::wechat.user_info'));
	ecjia_admin_log::instance()->add_object('subscribe_message', RC_Lang::get('wechat::wechat.user_message'));
	
	ecjia_admin_log::instance()->add_object('config', RC_Lang::get('wechat::wechat.config'));
}

/**
 * 创建像这样的查询: "IN('a','b')";
 */
function db_create_in($item_list, $field_name = '') {
	if (empty ( $item_list )) {
		return $field_name . " IN ('') ";
	} else {
		if (! is_array ( $item_list )) {
			$item_list = explode ( ',', $item_list );
		}
		$item_list = array_unique ( $item_list );
		$item_list_tmp = '';
		foreach ( $item_list as $item ) {
			if ($item !== '') {
				$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
			}
		}
		if (empty ( $item_list_tmp )) {
			return $field_name . " IN ('') ";
		} else {
			return $field_name . ' IN (' . $item_list_tmp . ') ';
		}
	}
}


/**
 * 截取字符串，字节格式化
 * @param unknown $str
 * @param unknown $length
 * @param number $start
 * @param string $charset
 * @param string $suffix
 * @return string
 */
function msubstr($str, $length, $start = 0, $charset = "utf-8", $suffix = true) {
	if (function_exists("mb_substr")) {
		$slice = mb_substr($str, $start, $length, $charset);
	} elseif (function_exists('iconv_substr')) {
		$slice = iconv_substr($str, $start, $length, $charset);
	} else {
		$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("", array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice . '...' : $slice;
}

/**
 * html代码输出
 * @param unknown $str
 * @return string
 */
function html_out($str) {
	if (function_exists('htmlspecialchars_decode')) {
		$str = htmlspecialchars_decode($str);
	} else {
		$str = html_entity_decode($str);
	}
	$str = stripslashes($str);
	return $str;
}

//end