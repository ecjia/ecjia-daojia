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
class merchant extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Promotion\Helper::assign_adminlog_content();

        RC_Loader::load_app_func('merchant_goods', 'goods');

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');

        RC_Style::enqueue_style('uniform-aristo');

        /*时间控件*/
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

        RC_Script::enqueue_script('promotion', RC_App::apps_url('statics/js/promotion_merchant.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('promotion', 'js_lang', config('app-promotion::jslang.promotion_page'));

        RC_Style::enqueue_style('mh_promotion', RC_App::apps_url('statics/css/mh_promotion.css', __FILE__), array());

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('促销管理', 'promotion'), RC_Uri::url('promotion/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('promotion', 'promotion/merchant.php');
    }

    /**
     * 促销活动列表页
     */
    public function init()
    {
        $this->admin_priv('promotion_manage');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('促销活动列表', 'promotion')));

        $this->assign('ur_here', __('促销活动列表', 'promotion'));
        $this->assign('action_link', array('href' => RC_Uri::url('promotion/merchant/add'), 'text' => __('促销活动', 'promotion')));

        $type           = isset($_GET['type']) && in_array($_GET['type'], array('on_sale', 'coming', 'finished', 'merchant')) ? remove_xss($_GET['type']) : 'on_sale';
        $promotion_list = $this->promotion_list($type);

        $this->assign('promotion_list', $promotion_list);
        $this->assign('type_count', $promotion_list['count']);
        $this->assign('filter', $promotion_list['filter']);

        $this->assign('type', $type);
        $this->assign('form_search', RC_Uri::url('promotion/merchant/init'));

        return $this->display('promotion_list.dwt');
    }

    /**
     * 添加促销活动
     */
    public function add()
    {
        $this->admin_priv('promotion_update');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加促销活动', 'promotion')));

        $this->assign('ur_here', __('添加促销活动', 'promotion'));
        $this->assign('action_link', array('href' => RC_Uri::url('promotion/merchant/init'), 'text' => __('活动列表', 'promotion')));

        $date          = array();
        $date['sdate'] = RC_Time::local_date('Y-m-d H:i', RC_Time::gmtime());
        $date['edate'] = RC_Time::local_date('Y-m-d H:i', RC_Time::local_strtotime("+1 months", RC_Time::local_strtotime($date['sdate']) + 28800));

        $this->assign('date', $date);

        $goods_id = intval($_GET['id']);

        if (!empty($goods_id)) {
            $data = $this->get_goods_detail($goods_id);

            $this->assign('goods', $data['goods']);
            $this->assign('products', $data['products']);
        }

        $this->assign('form_action', RC_Uri::url('promotion/merchant/insert'));
        $this->assign('search_action', RC_Uri::url('promotion/merchant/search_goods'));

        $merchant_cat = merchant_cat_list(0, 0, true, 2); //店铺分类
        $this->assign('merchant_cat', $merchant_cat);

        return $this->display('promotion_info.dwt');
    }

    /**
     * 处理添加促销活动
     */
    public function insert()
    {
        $this->admin_priv('promotion_update', ecjia::MSGTYPE_JSON);

        $goods_id = intval($_POST['id']);


        if (empty($goods_id)) {
            return $this->showmessage(__('请选择活动商品', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $start_time = RC_Time::local_strtotime(remove_xss($_POST['start_time']));
        $end_time   = RC_Time::local_strtotime(remove_xss($_POST['end_time']));

        if ($start_time >= $end_time) {
            return $this->showmessage(__('请输入一个有效的促销时间', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $time = RC_Time::gmtime();
        $info = RC_DB::table('goods')
            ->where('store_id', $_SESSION['store_id'])
            ->where('is_promote', 1)
            ->where('goods_id', $goods_id)
            ->where('promote_start_date', '<=', $time)
            ->where('promote_end_date', '>=', $time)
            ->first();

        if (!empty($info)) {
            return $this->showmessage(__('您选择的商品目前正在进行促销活动，请选择其他商品', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //商品信息
        $goods_info = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->first();

        //查询该商品是否有货品
        $products = RC_DB::table('products')->where('goods_id', $goods_id)->get();
        if (!empty($products)) {
            $checkbox = $_POST['checkboxes'];
            if (empty($checkbox)) {
                return $this->showmessage(__('请选择SKU商品参与活动', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $promote_price        = $_POST['promote_price'];
            $promote_limited      = $_POST['promote_limited'];
            $promote_user_limited = $_POST['promote_user_limited'];
            $product_ids          = $_POST['product_id'];

            $data = [];
            foreach ($checkbox as $k => $v) {
                if ($promote_price[$k] > $goods_info['shop_price']) {
                    return $this->showmessage(sprintf(__('您设置的活动价不能超过商品原价，请重新设置', 'promotion')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($promote_user_limited[$k] > $promote_limited[$k]) {
                    return $this->showmessage(__('每人限购不能大于限购总数量', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $product_number = RC_DB::table('products')->where('product_id', $product_ids[$k])->value('product_number');
                if ($promote_limited[$k] > $product_number) {
                    return $this->showmessage(__('您设置的限购总数量不能超过商品总库存，请重新设置', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($promote_price[$k] == 0) {
                    return $this->showmessage(__('活动价不能为0', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            foreach ($checkbox as $k => $v) {
                $data['promote_price']        = $promote_price[$k];
                $data['promote_limited']      = $promote_limited[$k];
                $data['promote_user_limited'] = $promote_user_limited[$k];
                $data['is_promote']           = 1;
                $product_id                   = $product_ids[$k];

                RC_DB::table('products')->where('goods_id', $goods_id)->where('product_id', $product_id)->update($data);
            }

            $result = array(
                'is_promote'         => 1,
                'promote_start_date' => $start_time,
                'promote_end_date'   => $end_time,
            );
            RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->update($result);
        } else {
            $promote_price        = is_numeric($_POST['promote_price']) ? floatval($_POST['promote_price']) : 0;
            $promote_limited      = intval($_POST['promote_limited']);
            $promote_user_limited = intval($_POST['promote_user_limited']);

            if ($promote_price > $goods_info['shop_price']) {
                return $this->showmessage(sprintf(__('您设置的活动价不能超过商品原价，请重新设置', 'promotion')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($promote_user_limited > $promote_limited) {
                return $this->showmessage(__('每人限购不能大于限购总数量', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($promote_limited > $goods_info['goods_number']) {
                return $this->showmessage(__('您设置的限购总数量不能超过商品总库存，请重新设置', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($promote_price == 0) {
                return $this->showmessage(__('活动价不能为0', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $data = array(
                'is_promote'           => 1,
                'promote_price'        => $promote_price,
                'promote_start_date'   => $start_time,
                'promote_end_date'     => $end_time,
                'promote_limited'      => $promote_limited,
                'promote_user_limited' => $promote_user_limited
            );
            RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->update($data);
        }

        /* 释放app缓存*/
        $orm_goods_db      = RC_Model::model('goods/orm_goods_model');
        $goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
        if (!empty($goods_cache_array)) {
            foreach ($goods_cache_array as $val) {
                $orm_goods_db->delete_cache_item($val);
            }
            $orm_goods_db->delete_cache_item('goods_list_cache_key_array');
        }

        ecjia_merchant::admin_log($goods_info['goods_name'], 'add', 'promotion');

        $links[] = array('text' => __('返回促销活动列表', 'promotion'), 'href' => RC_Uri::url('promotion/merchant/init'));
        $links[] = array('text' => __('继续添加促销活动', 'promotion'), 'href' => RC_Uri::url('promotion/merchant/add'));

        $res = array(
            'links'   => $links,
            'pjaxurl' => RC_Uri::url('promotion/merchant/edit', array('id' => $goods_id))
        );

        return $this->showmessage(__('添加促销活动成功', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $res);
    }

    /**
     * 编辑促销活动
     */
    public function edit()
    {
        $this->admin_priv('promotion_update');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑促销活动', 'promotion')));

        $this->assign('ur_here', __('编辑促销活动', 'promotion'));
        $this->assign('action_link', array('href' => RC_Uri::url('promotion/merchant/init'), 'text' => __('促销活动列表', 'promotion')));

        $goods_id = intval($_GET['id']);
        $this->assign('id', $goods_id);

        $data = $this->get_goods_detail($goods_id);

        $this->assign('goods', $data['goods']);
        $this->assign('products', $data['products']);

        $this->assign('form_action', RC_Uri::url('promotion/merchant/update'));
        $this->assign('search_action', RC_Uri::url('promotion/merchant/search_goods'));

        $merchant_cat = merchant_cat_list(0, 0, true, 2); //店铺分类
        $this->assign('merchant_cat', $merchant_cat);

        return $this->display('promotion_info.dwt');
    }

    /**
     * 更新促销活动
     */
    public function update()
    {
        $this->admin_priv('promotion_update', ecjia::MSGTYPE_JSON);

        $goods_id = intval($_POST['id']);
        $old_id   = intval($_POST['old_id']);

        if (empty($goods_id)) {
            return $this->showmessage(__('请选择活动商品', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $start_time = RC_Time::local_strtotime(remove_xss($_POST['start_time']));
        $end_time   = RC_Time::local_strtotime(remove_xss($_POST['end_time']));

        if ($start_time >= $end_time) {
            return $this->showmessage(__('请输入一个有效的促销时间', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $db = RC_DB::table('goods')->where('store_id', $_SESSION['store_id']);

        if ($goods_id != $old_id) {
            $time = RC_Time::gmtime();
            $info = $db->where('goods_id', $goods_id)
                ->where('is_promote', 1)
                ->where('promote_start_date', '<=', $time)
                ->where('promote_end_date', '>=', $time)
                ->first();

            if (!empty($info)) {
                return $this->showmessage(__('您选择的商品目前正在进行促销活动，请选择其他商品', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        //商品信息
        $goods_info = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->first();

        //查询该商品是否有货品
        $products = RC_DB::table('products')->where('goods_id', $goods_id)->get();
        if (!empty($products)) {
            $checkbox = $_POST['checkboxes'];
            if (empty($checkbox)) {
                return $this->showmessage(__('请选择SKU商品参与活动', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $promote_price        = $_POST['promote_price'];
            $promote_limited      = $_POST['promote_limited'];
            $promote_user_limited = $_POST['promote_user_limited'];
            $product_ids          = $_POST['product_id'];

            $data = [];
            foreach ($checkbox as $k => $v) {
                if ($promote_price[$k] > $goods_info['shop_price']) {
                    return $this->showmessage(sprintf(__('您设置的活动价不能超过商品原价，请重新设置', 'promotion')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($promote_user_limited[$k] > $promote_limited[$k]) {
                    return $this->showmessage(__('每人限购不能大于限购总数量', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $product_number = RC_DB::table('products')->where('product_id', $product_ids[$k])->value('product_number');
                if ($promote_limited[$k] <= 0) {
                	return $this->showmessage(__('您设置的限购总数量不能等于0', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($promote_limited[$k] > $product_number) {
                    return $this->showmessage(__('您设置的限购总数量不能超过商品总库存，请重新设置', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($promote_price[$k] == 0) {
                    return $this->showmessage(__('活动价不能为0', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }

            $update_data = array(
                'is_promote'           => 0,
                'promote_price'        => 0,
                'promote_start_date'   => 0,
                'promote_end_date'     => 0,
                'promote_limited'      => 0,
                'promote_user_limited' => 0
            );
            RC_DB::table('products')->where('goods_id', $goods_id)->update($update_data);

            foreach ($checkbox as $k => $v) {
                $data['promote_price']        = $promote_price[$k];
                $data['promote_limited']      = $promote_limited[$k];
                $data['promote_user_limited'] = $promote_user_limited[$k];
                $data['is_promote']           = 1;
                $product_id                   = $product_ids[$k];

                RC_DB::table('products')->where('goods_id', $goods_id)->where('product_id', $product_id)->update($data);
            }

            $result = array(
                'is_promote'         => 1,
                'promote_start_date' => $start_time,
                'promote_end_date'   => $end_time,
            );
            RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->update($result);
        } else {
            $promote_price        = is_numeric($_POST['promote_price']) ? floatval($_POST['promote_price']) : 0;
            $promote_limited      = intval($_POST['promote_limited']);
            $promote_user_limited = intval($_POST['promote_user_limited']);

            if ($promote_price > $goods_info['shop_price']) {
                return $this->showmessage(sprintf(__('您设置的活动价不能超过商品原价，请重新设置', 'promotion')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($promote_user_limited > $promote_limited) {
                return $this->showmessage(__('每人限购不能大于限购总数量', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($promote_limited > $goods_info['goods_number']) {
                return $this->showmessage(__('您设置的限购总数量不能超过商品总库存，请重新设置', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($promote_price == 0) {
                return $this->showmessage(__('活动价不能为0', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $data = array(
                'is_promote'           => 1,
                'promote_price'        => $promote_price,
                'promote_start_date'   => $start_time,
                'promote_end_date'     => $end_time,
                'promote_limited'      => $promote_limited,
                'promote_user_limited' => $promote_user_limited
            );
            RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->update($data);
        }

        //更新原来的商品为非促销活动
        if ($goods_id != $old_id) {
            $update_data = array(
                'is_promote'           => 0,
                'promote_price'        => 0,
                'promote_start_date'   => 0,
                'promote_end_date'     => 0,
                'promote_limited'      => 0,
                'promote_user_limited' => 0
            );
            RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $old_id)->update($update_data);
            RC_DB::table('products')->where('goods_id', $old_id)->update($update_data);
        }

        /* 释放app缓存*/
        $orm_goods_db      = RC_Model::model('goods/orm_goods_model');
        $goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
        if (!empty($goods_cache_array)) {
            foreach ($goods_cache_array as $val) {
                $orm_goods_db->delete_cache_item($val);
            }
            $orm_goods_db->delete_cache_item('goods_list_cache_key_array');
        }

        ecjia_merchant::admin_log($goods_info['goods_name'], 'edit', 'promotion');

        $res = array(
            'pjaxurl' => RC_Uri::url('promotion/merchant/edit', array('id' => $goods_id))
        );
        return $this->showmessage(__('编辑促销活动成功', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $res);
    }

    /**
     * 删除促销活动
     */
    public function remove()
    {
        $this->admin_priv('promotion_delete', ecjia::MSGTYPE_JSON);

        $id   = intval($_GET['id']);
        $db   = RC_DB::table('goods');
        $from = remove_xss($_GET['from']);

        $goods_name = $db->where('store_id', $_SESSION['store_id'])->where('goods_id', $id)->value('goods_name');

        //更新商品为非促销活动
        $update_data = array(
            'is_promote'           => 0,
            'promote_price'        => 0,
            'promote_start_date'   => 0,
            'promote_end_date'     => 0,
            'promote_limited'      => 0,
            'promote_user_limited' => 0
        );
        RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $id)->update($update_data);
        RC_DB::table('products')->where('goods_id', $id)->update($update_data);

        /* 释放app缓存*/
        $orm_goods_db      = RC_Model::model('goods/orm_goods_model');
        $goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
        if (!empty($goods_cache_array)) {
            foreach ($goods_cache_array as $val) {
                $orm_goods_db->delete_cache_item($val);
            }
            $orm_goods_db->delete_cache_item('goods_list_cache_key_array');
        }

        ecjia_merchant::admin_log($goods_name, 'remove', 'promotion');

        if ($from == 'edit') {
            return $this->showmessage(__('删除成功', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('promotion/merchant/init')));
        } else {
            return $this->showmessage(__('删除成功', 'promotion'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }

    }

    /**
     * 添加/编辑页搜索商品
     */
    public function search_goods()
    {
        $merchant_cat_id = intval($_POST['merchant_cat_id']);
        $goods_keywords  = remove_xss($_POST['goods_keywords']);
        $goods_sn        = remove_xss($_POST['goods_sn']);

        $db_goods = RC_DB::table('goods as g')
            ->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
            ->where(RC_DB::raw('g.store_id'), $_SESSION['store_id']);

        if (!empty($merchant_cat_id)) {
            $where = merchant_get_children($merchant_cat_id);
            $db_goods->whereRaw($where);
        }
        if (!empty($goods_keywords)) {
            $db_goods->where(RC_DB::raw('g.goods_name'), 'like', '%' . mysql_like_quote($goods_keywords) . '%');
        }

        if (!empty($goods_sn)) {
            $db_goods->where(RC_DB::raw('g.goods_sn'), 'like', '%' . mysql_like_quote($goods_sn) . '%');
        }

        $goods_list = $db_goods
            ->select(RC_DB::raw('g.goods_id, g.goods_name'))
            ->where(RC_DB::raw('g.is_delete'), 0)
            ->orderBy(RC_DB::raw('g.store_sort_order'), 'asc')
            ->orderBy('goods_id', 'desc')
            ->take(50)
            ->get();

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $goods_list));
    }

    public function get_goods_info()
    {
        $goods_id = intval($_POST['id']);

        $data = $this->get_goods_detail($goods_id);

        $this->assign('goods', $data['goods']);
        $this->assign('products', $data['products']);

        $type = remove_xss($_POST['type']);
        if ($type == 'add') {
            $content = $this->fetch('library/goods.lbi');
        } else {
            $content = $this->fetch('library/goods_info.lbi');
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $content));
    }

    private function get_goods_detail($goods_id = 0)
    {
        $goods = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->first();

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

        $attr_price = $goods['shop_price'];
        if (!empty($products)) {
            foreach ($products as $k => $v) {
                $goods_attr = explode('|', $v['goods_attr']);
                $attr_list  = RC_DB::table('goods_attr')->where('goods_id', $goods_id)->whereIn('goods_attr_id', $goods_attr)->select('goods_attr_id', 'attr_value', 'attr_price')->get();

                $attr_value = [];
                foreach ($attr_list as $attr) {
                    $attr_price   += $attr['attr_price'];
                    $attr_value[] = $attr['attr_value'];
                }
                
                $products[$k]['product_thumb'] = empty($v['product_thumb']) ? $goods['goods_thumb'] : (file_exists(RC_Upload::upload_path($v['product_thumb'])) ? RC_Upload::upload_url($v['product_thumb']) : RC_Uri::admin_url('statics/images/nopic.png'));
                $products[$k]['product_name'] = empty($v['product_name']) ? $goods['goods_name'] : $v['product_name'];
                $products[$k]['attr_value'] = is_array($attr_value) ? implode(' / ', $attr_value) : $attr_value;;
                $products[$k]['formated_attr_price'] = $products[$k]['product_shop_price'] > 0 ? ecjia_price_format($products[$k]['product_shop_price']) : ecjia_price_format($attr_price);
            }
            $goods['range_label'] = __('货品促销', 'promotion');
        } else {
            $goods['range_label'] = __('商品促销', 'promotion');
        }

        return array(
            'goods'    => $goods,
            'products' => $products
        );
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
        $filter['keywords'] = empty($_GET['keywords']) ? '' : stripslashes(remove_xss($_GET['keywords']));

        $db_goods = RC_DB::table('goods as g');

        $db_goods->where('store_id', $_SESSION['store_id'])->where('is_promote', '1')->where('is_delete', '!=', 1);

        if (!empty($filter['keywords'])) {
            $db_goods->where('goods_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }

        $time = RC_Time::gmtime();

        $type_count = $db_goods->select(
            RC_DB::raw('SUM(IF(promote_start_date <' . $time . ' and promote_end_date > ' . $time . ', 1, 0)) as on_sale'),
            RC_DB::raw('SUM(IF(promote_start_date >' . $time . ', 1, 0)) as coming'),
            RC_DB::raw('SUM(IF(promote_end_date <' . $time . ', 1, 0)) as finished'))->first();

        if ($type == 'on_sale') {
            $db_goods->where('promote_start_date', '<=', $time)->where('promote_end_date', '>=', $time);
        }

        if ($type == 'coming') {
            $db_goods->where('promote_start_date', '>=', $time);
        }

        if ($type == 'finished') {
            $db_goods->where('promote_end_date', '<=', $time)
                ->orderBy('promote_end_date', 'desc');
        }

        $count = $db_goods->count();
        $page  = new ecjia_merchant_page($count, 10, 5);

        $result = $db_goods
            ->select('goods_id', 'goods_sn', 'goods_name', 'promote_price', 'promote_start_date', 'promote_end_date', 'goods_thumb', 'promote_limited', 'promote_user_limited')
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
        return array('item' => $result, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $type_count);
    }
}

// end