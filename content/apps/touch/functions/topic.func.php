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
 * 专题页列表
 */
function get_topic_list() {
    $arr_library   = array();

    $curr_theme = ecjia::config('template') ? ecjia::config('template') : RC_Config::system('TPL_STYLE');
    $theme_dir = SITE_THEME_PATH . $curr_theme . DIRECTORY_SEPARATOR;
    $library_dir = $theme_dir. 'library' . DIRECTORY_SEPARATOR.'topic'.DIRECTORY_SEPARATOR;

    $library_handle = opendir($library_dir);
    if($library_handle){
        while (false !== ($file = readdir($library_handle))) {
            if (substr($file, -7) == 'dwt.php') {
                $library_data = get_library_info($library_dir . $file);
                $arr_library[$file]['File'] = $file;
                $arr_library[$file]['Name'] = $library_data['Name'];
                $arr_library[$file]['Description'] = $library_data['Description'];
            }
        }
    }
    closedir($library_handle);
    return $arr_library;
}

function get_library_info($file) {
    $default_headers = array(
        'Name' => 'Name',
        'Description' => 'Description',
    );
    $library_data = RC_File::get_file_data( $file, $default_headers, 'topic' );

    return $library_data;
}
/**
 * 载入自定义橱窗模板
 *
 * @access  public
 * @param   string  $curr_template  模版名称
 * @param   string  $lib_name       库项目名称
 * @return  array
 */
function load_library($lib_name) {
    $lib_name = str_replace("0xa", '', $lib_name); // 过滤 0xa 非法字符

    $curr_theme = ecjia::config('template') ? ecjia::config('template') : RC_Config::system('TPL_STYLE');
    $theme_dir = SITE_THEME_PATH . $curr_theme . DIRECTORY_SEPARATOR;
    $library_dir = $theme_dir. 'library' . DIRECTORY_SEPARATOR.'topic'.DIRECTORY_SEPARATOR;
    $lib_file    = $library_dir . $lib_name ;

    RC_Loader::load_sys_func('upload');

    $arr['mark'] = RC_File::file_mode_info($lib_file);
    $arr['html'] = str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_file));
    return $arr;
}

/**
 * 更新自定义橱窗
 */
function update_library($lib_name, $content){

    $curr_theme = ecjia::config('template') ? ecjia::config('template') : RC_Config::system('TPL_STYLE');
    $theme_dir = SITE_THEME_PATH . $curr_theme . DIRECTORY_SEPARATOR;
    $library_dir = $theme_dir. 'library' . DIRECTORY_SEPARATOR.'topic'. DIRECTORY_SEPARATOR;

    $lib_file = $library_dir. $lib_name ;
    $lib_file = str_replace("0xa", '', $lib_file); // 过滤 0xa 非法字符
    $lib_file = str_replace("\\", '/', $lib_file); //windows兼容处理
    $org_html = str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_file));
    $library_bak_dir = SITE_CACHE_PATH . 'backup' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR.'topic'. DIRECTORY_SEPARATOR;
    if (file_exists($lib_file) === true && file_put_contents($lib_file, $content)) {
        file_put_contents($library_bak_dir . ecjia::config('template') . '-' . $lib_name , $org_html);
        return true;
    } else {
        return false;
    }
}
/**
 * 获取专题列表
 * @access  public
 * @return void
 */
function  get_touch_topic_list() {
    $db_topic = RC_Loader::load_app_model('topic_model');
    $res = array();
    $data = $db_topic->field('topic_id, title, start_time, end_time')->where($where)->order('topic_id DESC')->select();
    if(!empty($data)) {
        foreach ($data as $topic) {
            $topic['is_overdue'] = !($topic['start_time'] < RC_Time::gmtime()) && ($topic['end_time'] > RC_Time::gmtime());
            $topic['start_time'] = RC_Time::local_date('Y-m-d',$topic['start_time']);
            $topic['end_time']   = RC_Time::local_date('Y-m-d',$topic['end_time']);
            $res[] = $topic;
        }
    }
    return $res;
}

// end