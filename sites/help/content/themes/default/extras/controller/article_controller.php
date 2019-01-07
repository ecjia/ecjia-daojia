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
 * 分类控制器
 */
class article_controller
{
    public static function init()
    {

        $article_id = trim($_GET['aid']);
        $article_type =   'shop_help';

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $article_id . '-' .  $article_type;
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('article_help.dwt', $cache_id)) {
            $options = array(
                'page_size'     =>  99999999,
                'article_type'  => $article_type,
                'sort_order'    => 'DESC',
                'sort_by'    => 'add_time',
            );

            $data = RC_Api::api('article', 'article_list', $options);

            $article_list = array();
            foreach($data['arr'] as $key => $row)
            {
                $article_list[$row['cat_id']]['name']   = $row['cat_name'];
                $article_list[$row['cat_id']]['article'][$key]['id']    = $row['article_id'];
                $article_list[$row['cat_id']]['article'][$key]['title'] = $row['title'];
                $article_list[$row['cat_id']]['article'][$key]['date']  = $row['date'];
                $article_list[$row['cat_id']]['article'][$key]['short_title']   = ecjia::config('article_title_length') > 0 ? RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
            }

            if (!is_ecjia_error($article_list)) {
                ecjia_front::$controller->assign('article_list', $article_list);
            }

            if(empty($article_id)) {
                $article_id = (head(head($article_list)['article'])['id']);
            }

            $shop_help_detail = RC_Api::api('article', 'article_info', array('id' => $article_id));

            ecjia_front::$controller->assign('aid',     $article_id);
            ecjia_front::$controller->assign('article_type',     $article_type);
            ecjia_front::$controller->assign('article', $shop_help_detail);

            ecjia_front::$controller->assign_title('帮助中心');
        }

        ecjia_front::$controller->display('article_help.dwt', $cache_id);
    }

    public static function info()
    {
        $article_id = trim($_GET['aid']);
        $article_type =   'shop_info';

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $article_id . '-' .  $article_type;
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('article_info.dwt', $cache_id)) {
            $options = array(
                'page_size'     =>  99999999,
                'article_type'  => $article_type,
                'sort_order'    => 'DESC',
                'sort_by'    => 'add_time',
            );

            $data = RC_Api::api('article', 'article_list', $options);

            $article_list = array();
            foreach($data['arr'] as $key => $row)
            {
                $article_list[$row['cat_id']]['name']   = $row['cat_name'];
                $article_list[$row['cat_id']]['article'][$key]['id']    = $row['article_id'];
                $article_list[$row['cat_id']]['article'][$key]['title'] = $row['title'];
                $article_list[$row['cat_id']]['article'][$key]['date']  = $row['date'];
                $article_list[$row['cat_id']]['article'][$key]['short_title']   = ecjia::config('article_title_length') > 0 ? RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
            }

            if (!is_ecjia_error($article_list)) {
                ecjia_front::$controller->assign('article_list', $article_list);
            }

            if(empty($article_id)) {
                $article_id = (head(head($article_list)['article'])['id']);
            }

            $shop_help_detail = RC_Api::api('article', 'article_info', array('id' => $article_id));

            ecjia_front::$controller->assign('aid',     $article_id);
            ecjia_front::$controller->assign('article_type',     $article_type);
            ecjia_front::$controller->assign('article', $shop_help_detail);

            $friendlink_list = RC_Api::api('friendlink', 'friendlink_list', array('type' => 'logo'));
            ecjia_front::$controller->assign('friendlink_list', $friendlink_list);

            ecjia_front::$controller->assign_title('关于我们');
        }

        ecjia_front::$controller->display('article_info.dwt', $cache_id);
    }


    public static function notice()
    {
        $article_id     = trim($_GET['aid']);
        $article_type   =   'shop_notice';
        $page_size      =   !empty($_GET['page_size']) ? trim($_GET['page_size']) : 99999999;

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $article_id . '-' .  $article_type . '-' .  $page_size;
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('article_notice.dwt', $cache_id)) {
            $options = array(
                'page_size'     =>  $page_size,
                'article_type'  => $article_type,
                'sort_order'    => 'DESC',
                'sort_by'    => 'add_time',
            );

            $data = RC_Api::api('article', 'article_list', $options);

            $article_list = array();
            foreach($data['arr'] as $key => $row)
            {
                $article_list[$row['cat_id']]['name']                                           = $row['cat_name'];
                $row['month']                                                                   = RC_Time::local_date('Y-m', $row['add_time']);    ;
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['id']             = $row['article_id'];
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['title']          = $row['title'];
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['date']           = $row['date'];
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['short_title']   = ecjia::config('article_title_length') > 0 ? RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
            }
            $date = !empty($_GET['date']) ? trim($_GET['date']) : head(array_keys(head($article_list)['article']));

            if (!is_ecjia_error($article_list)) {
                ecjia_front::$controller->assign('article_list', $article_list);
            }

            if(empty($article_id)) {
                $article_id = (head(head(head($article_list)['article']))['id']);
            }

            $shop_notice_detail = RC_Api::api('article', 'article_info', array('id' => $article_id));

            ecjia_front::$controller->assign('date',     $date);
            ecjia_front::$controller->assign('aid',     $article_id);
            ecjia_front::$controller->assign('article_type',     $article_type);
            ecjia_front::$controller->assign('article', $shop_notice_detail);

            ecjia_front::$controller->assign_title('商家公告');
        }
        ecjia_front::$controller->display('article_notice.dwt', $cache_id);
    }

    public static function detail()
    {
        $article_id     = trim($_GET['aid']);
        $article_type   =   'shop_notice';
        $page_size      =   !empty($_GET['page_size']) ? trim($_GET['page_size']) : 99999999;

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $article_id . '-' .  $article_type . '-' .  $page_size;
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('article_detail.dwt', $cache_id)) {
            $options = array(
                'page_size'     =>  $page_size,
                'article_type'  => $article_type,
                'sort_order'    => 'DESC',
                'sort_by'    => 'add_time',
            );

            $data = RC_Api::api('article', 'article_list', $options);

            $article_list = array();
            foreach($data['arr'] as $key => $row)
            {
                $article_list[$row['cat_id']]['name']                                           = $row['cat_name'];
                $row['month']                                                                   = RC_Time::local_date('Y-m', $row['add_time']);    ;
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['id']             = $row['article_id'];
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['title']          = $row['title'];
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['date']           = $row['date'];
                $article_list[$row['cat_id']]['article'][$row['month']][$key]['short_title']   = ecjia::config('article_title_length') > 0 ? RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
            }
            $date = !empty($_GET['date']) ? trim($_GET['date']) : head(array_keys(head($article_list)['article']));

            if (!is_ecjia_error($article_list)) {
                ecjia_front::$controller->assign('article_list', $article_list);
            }

            $shop_notice_detail = RC_Api::api('article', 'article_info', array('id' => $article_id));

            ecjia_front::$controller->assign('date',     $date);
            ecjia_front::$controller->assign('aid',     $article_id);
            ecjia_front::$controller->assign('article_type',     $article_type);
            ecjia_front::$controller->assign('article', $shop_notice_detail);

            ecjia_front::$controller->assign_title('商家公告');
        }
        ecjia_front::$controller->display('article_detail.dwt', $cache_id);
    }


    public static function friendlink()
    {
        $friendlink_list = RC_Api::api('friendlink', 'friendlink_list', array('type' => 'logo'));
        $article_type =   'shop_info';

        $cache_id = $_SERVER['QUERY_STRING'] . '-' .  $friendlink_list . '-' .  $article_type;
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('article_friendlink.dwt', $cache_id)) {
            $options = array(
                'page_size'     =>  99999999,
                'article_type'  => $article_type,
                'sort_order'    => 'DESC',
                'sort_by'    => 'add_time',
            );

            $data = RC_Api::api('article', 'article_list', $options);

            $article_list = array();
            foreach($data['arr'] as $key => $row)
            {
                $article_list[$row['cat_id']]['name']   = $row['cat_name'];
                $article_list[$row['cat_id']]['article'][$key]['id']    = $row['article_id'];
                $article_list[$row['cat_id']]['article'][$key]['title'] = $row['title'];
                $article_list[$row['cat_id']]['article'][$key]['date']  = $row['date'];
                $article_list[$row['cat_id']]['article'][$key]['short_title']   = ecjia::config('article_title_length') > 0 ? RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
            }

            if (!is_ecjia_error($article_list)) {
                ecjia_front::$controller->assign('article_list', $article_list);
            }

            $friendlink_list = RC_Api::api('friendlink', 'friendlink_list', array('type' => 'logo'));
            ecjia_front::$controller->assign('friendlink_list', $friendlink_list);

            ecjia_front::$controller->assign_title('关于我们');
        }

        ecjia_front::$controller->display('article_friendlink.dwt', $cache_id);
    }

}