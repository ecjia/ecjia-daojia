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
 * ECJIA 促销管理程序
 */
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Promotion\Helper::assign_adminlog_content();

        RC_Loader::load_app_func('merchant_goods', 'goods');

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');

        //时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

        RC_Script::enqueue_script('promotion', RC_App::apps_url('statics/js/promotion.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('promotion', 'js_lang', config('app-promotion::jslang.promotion_page'));

        RC_Style::enqueue_style('mh_promotion', RC_App::apps_url('statics/css/mh_promotion.css', __FILE__), array());

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('促销活动', 'promotion'), RC_Uri::url('promotion/admin/init')));
    }

    /**
     * 促销活动列表页
     */
    public function init()
    {
        $this->admin_priv('promotion_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('促销活动', 'promotion')));
        ecjia_screen::get_current_screen()->set_sidebar_display(true);

        $this->assign('ur_here', __('促销活动列表', 'promotion'));

        $type           = isset($_GET['type']) && in_array($_GET['type'], array('on_sale', 'coming', 'finished', 'self')) ? trim($_GET['type']) : 'on_sale';
        $promotion_list = $this->promotion_list($type);

        $this->assign('promotion_list', $promotion_list);
        $this->assign('type_count', $promotion_list['count']);
        $this->assign('filter', $promotion_list['filter']);

        $this->assign('type', $type);
        $this->assign('form_search', RC_Uri::url('promotion/admin/init'));

        $store_id = intval($_GET['store_id']);
        $this->assign('store_id', $store_id);

        $this->display('promotion_list.dwt');
    }

    /**
     * 查看详情
     */
    public function detail()
    {
        $this->admin_priv('promotion_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('查看促销活动', 'promotion')));
        ecjia_screen::get_current_screen()->set_sidebar_display(false);

        $this->assign('ur_here', __('查看促销活动', 'promotion'));
        $this->assign('action_link', array('href' => RC_Uri::url('promotion/admin/init'), 'text' => __('促销活动列表', 'promotion')));

        $goods_id = intval($_GET['id']);
        $this->assign('id', $goods_id);

        $data = $this->get_goods_detail($goods_id);

        $this->assign('goods', $data['goods']);
        $this->assign('products', $data['products']);
        $this->assign('shop', $data['shop_info']);

        $merchant_cat = merchant_cat_list(0, 0, true, 2); //店铺分类
        $this->assign('merchant_cat', $merchant_cat);

        //其他促销
        $result = [];
        $count  = RC_DB::table('goods')->where('store_id', $data['shop_info']['store_id'])->where('is_promote', 1)->count();
        if ($count != 0) {
            $result = RC_DB::table('goods')
                ->select('goods_id', 'goods_sn', 'goods_name', 'promote_price', 'market_price', 'goods_thumb', 'promote_start_date')
                ->where('store_id', $data['shop_info']['store_id'])
                ->where('is_promote', 1)
                ->orderBy('promote_start_date', 'desc')
                ->take(3)
                ->get();

            if (!empty($result)) {
                $disk = RC_Filesystem::disk();
                foreach ($result as $key => $val) {
                    if (!$disk->exists(RC_Upload::upload_path() . $val['goods_thumb']) || empty($val['goods_thumb'])) {
                        $result[$key]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
                    } else {
                        $result[$key]['goods_thumb'] = RC_Upload::upload_url() . '/' . $val['goods_thumb'];
                    }
                    $result[$key]['formated_promote_price'] = ecjia_price_format($val['promote_price'], 2);
                    $result[$key]['formated_market_price']  = ecjia_price_format($val['market_price'], 2);

                    $products = RC_DB::table('products')->where('goods_id', $val['goods_id'])->where('is_promote', 1)->get();
                    if (!empty($products)) {
                        foreach ($products as $k => $v) {
                            if ($k == 0) {
                                $result[$key]['formated_promote_price'] = ecjia_price_format($v['promote_price'], 2); //取第一件货品的促销价格
                            }
                        }
                    }
                    $result[$key]['products'] = $products;
                }
            }
        }

        $this->assign('count', $count);
        $this->assign('result', $result);

        $action = $_SESSION['action_list'] == 'all' ? true : false;
        $this->assign('action', $action);

        if ($action) {
            if (defined('RC_SITE')) {
                $index = 'sites/' . RC_SITE . '/index.php';
            } else {
                $index = 'index.php';
            }
            $edit_url = RC_Uri::url('promotion/merchant/edit', array('id' => $goods_id));
            $edit_url = str_replace($index, "sites/merchant/index.php", $edit_url);

            $this->assign('edit_url', urlencode($edit_url));

//            $list_url = RC_Uri::url('promotion/merchant/init');
//            $list_url = str_replace($index, "sites/merchant/index.php", $list_url);
//            $this->assign('list_url', urlencode($list_url));
        }

        $this->display('promotion_detail.dwt');
    }

    private function get_goods_detail($goods_id = 0)
    {
        $goods = RC_DB::table('goods')->where('goods_id', $goods_id)->first();

        $goods['goods_thumb']           = !empty($goods['goods_thumb']) && file_exists(RC_Upload::upload_path($goods['goods_thumb'])) ? RC_Upload::upload_url($goods['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png');
        $goods['formated_shop_price']   = ecjia_price_format($goods['shop_price']);
        $goods['formated_market_price'] = ecjia_price_format($goods['market_price']);


        $time = RC_Time::gmtime();
        if ($goods['promote_start_date'] < $time && $goods['promote_end_date'] > $time) {
            $goods['promote_status']       = 'on_sale';
            $goods['promote_status_label'] = __('进行中', 'promotion');
        } elseif ($goods['promote_start_date'] > $time) {
            $goods['promote_status']       = 'coming';
            $goods['promote_status_label'] = __('即将开始', 'promotion');
        } elseif ($goods['promote_end_date'] < $time) {
            $goods['promote_status']       = 'finished';
            $goods['promote_status_label'] = __('已结束', 'promotion');
        }

        $goods['promote_start_date'] = RC_Time::local_date('Y-m-d H:i', $goods['promote_start_date']);
        $goods['promote_end_date']   = RC_Time::local_date('Y-m-d H:i', $goods['promote_end_date']);

        $products = RC_DB::table('products')->where('goods_id', $goods_id)->get();
        if (!empty($products)) {
            foreach ($products as $k => $v) {
                $goods_attr                 = explode('|', $v['goods_attr']);
                $attr_value                 = RC_DB::table('goods_attr')->where('goods_id', $goods_id)->whereIn('goods_attr_id', $goods_attr)->lists('attr_value');
                $attr_value                 = is_array($attr_value) ? implode(' / ', $attr_value) : $attr_value;
                $products[$k]['attr_value'] = $attr_value;
            }
            $goods['range_label'] = __('货品促销', 'promotion');
        } else {
            $goods['range_label'] = __('商品促销', 'promotion');
        }

        $shop_info = RC_api::api('store', 'store_info', array('store_id' => $goods['store_id']));

        $trade_time = '暂未设置';

        if (!empty($shop_info['shop_trade_time'])) {
            $trade_time = unserialize($shop_info['shop_trade_time']);

            $sart_time = $trade_time['start'];
            $end_time  = explode(':', $trade_time['end']);
            if ($end_time[0] >= 24) {
                $end_time[0] = '次日' . ($end_time[0] - 24);
            }
            $trade_time = $sart_time . '-' . $end_time[0] . ':' . $end_time[1];
        }
        $shop_info['trade_time'] = $trade_time;
        $shop_info['address']    = ecjia_region::getRegionName($shop_info['province']) .
            ecjia_region::getRegionName($shop_info['city']) .
            ecjia_region::getRegionName($shop_info['district']) .
            ecjia_region::getRegionName($shop_info['street']) .
            $shop_info['address'];

        $shop_info['shop_logo'] = !empty($shop_info['shop_logo']) ? RC_Upload::upload_url($shop_info['shop_logo']) : RC_Uri::admin_url('statics/images/nopic.png');

        return array(
            'goods'     => $goods,
            'products'  => $products,
            'shop_info' => $shop_info
        );
    }

    //登录到商家促销活动页
    public function autologin()
    {
        $store_id     = intval($_GET['store_id']);
        $redirect_url = urlencode($_GET['url']);

        if ($_SESSION['action_list'] == 'all') {
            $cookie_name    = RC_Config::get('session.session_admin_name');
            $authcode_array = array(
                'admin_token' => RC_Cookie::get($cookie_name),
                'store_id'    => $store_id,
                'time'        => RC_Time::gmtime(),
            );
            $authcode_str   = http_build_query($authcode_array);
            $authcode       = RC_Crypt::encrypt($authcode_str);

            if (defined('RC_SITE')) {
                $index = 'sites/' . RC_SITE . '/index.php';
            } else {
                $index = 'index.php';
            }

            $url = str_replace($index, "sites/merchant/index.php", RC_Uri::url('staff/privilege/autologin')) . '&authcode=' . $authcode;

            $url .= '&redirect_url=' . $redirect_url;
            return $this->redirect($url);
        }
    }

    /**
     * 获取活动列表
     *
     * @access  public
     *
     * @return void
     */
    private function promotion_list($type = '')
    {
        $filter['keywords']          = empty($_GET['keywords']) ? '' : stripslashes(trim($_GET['keywords']));
        $filter['merchant_keywords'] = empty($_GET['merchant_keywords']) ? '' : stripslashes(trim($_GET['merchant_keywords']));

        $db_goods = RC_DB::table('goods as g')
            ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('g.store_id'));

        $db_goods->where(RC_DB::raw('g.is_promote'), '1')->where(RC_DB::raw('g.is_delete'), '!=', 1);

        if (!empty($filter['keywords'])) {
            $db_goods->where(RC_DB::raw('g.goods_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }

        if (!empty($filter['merchant_keywords'])) {
            $db_goods->where(RC_DB::raw('s.merchants_name'), 'like', '%' . mysql_like_quote($filter['merchant_keywords']) . '%');
        }

        $time = RC_Time::gmtime();

        $store_id = intval($_GET['store_id']);
        if (!empty($store_id)) {
            $db_goods->where(RC_DB::raw('g.store_id'), $store_id);
        }

        $type_count = $db_goods->select(
            RC_DB::raw('SUM(IF(promote_start_date <' . $time . ' and promote_end_date > ' . $time . ', 1, 0)) as on_sale'),
            RC_DB::raw('SUM(IF(promote_start_date >' . $time . ', 1, 0)) as coming'),
            RC_DB::raw('SUM(IF(promote_end_date <' . $time . ', 1, 0)) as finished'))->first();

        if ($type == 'on_sale') {
            $db_goods->where(RC_DB::raw('g.promote_start_date'), '<=', $time)->where('promote_end_date', '>=', $time);
        }

        if ($type == 'coming') {
            $db_goods->where(RC_DB::raw('g.promote_start_date'), '>=', $time);
        }

        if ($type == 'finished') {
            $db_goods->where(RC_DB::raw('g.promote_end_date'), '<=', $time)
                ->orderBy('promote_end_date', 'desc');
        }

        $count = $db_goods->count();
        $page  = new ecjia_page($count, 10, 5);

        $result = $db_goods
            ->select(RC_DB::raw('g.goods_id, g.goods_sn, g.goods_name, g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.promote_limited, g.promote_user_limited, s.merchants_name, s.manage_mode'))
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        if (!empty($result)) {
            $disk = RC_Filesystem::disk();
            foreach ($result as $key => $val) {
                $result[$key]['start_time'] = RC_Time::local_date('Y-m-d H:i', $val['promote_start_date']);
                $result[$key]['end_time']   = RC_Time::local_date('Y-m-d H:i', $val['promote_end_date']);

                if (!$disk->exists(RC_Upload::upload_path() . $val['goods_thumb']) || empty($val['goods_thumb'])) {
                    $result[$key]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
                } else {
                    $result[$key]['goods_thumb'] = RC_Upload::upload_url() . '/' . $val['goods_thumb'];
                }
                $result[$key]['formated_promote_price'] = ecjia_price_format($val['promote_price'], 2);

                $products = RC_DB::table('products')->where('goods_id', $val['goods_id'])->where('is_promote', 1)->get();
                if (!empty($products)) {
                    foreach ($products as $k => $v) {
                        $goods_attr                             = explode('|', $v['goods_attr']);
                        $attr_value                             = RC_DB::table('goods_attr')->where('goods_id', $val['goods_id'])->whereIn('goods_attr_id', $goods_attr)->lists('attr_value');
                        $attr_value                             = is_array($attr_value) ? implode(' / ', $attr_value) : $attr_value;
                        $products[$k]['attr_value']             = $attr_value;
                        $products[$k]['formated_promote_price'] = ecjia_price_format($v['promote_price'], 2);
                    }
                    $result[$key]['range_label'] = __('货品促销', 'promotion');
                } else {
                    $result[$key]['range_label'] = __('商品促销', 'promotion');
                }
                $result[$key]['products'] = $products;
            }
        }
        return array('item' => $result, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $type_count);
    }
}

// end