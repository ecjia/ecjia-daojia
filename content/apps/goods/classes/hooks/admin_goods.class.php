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

class goods_admin_hooks
{

    public static function widget_admin_dashboard_goodsstat()
    {

        if (!ecjia_admin::$controller->admin_priv('goods_manage', ecjia::MSGTYPE_HTML, false)) {
            return false;
        }

        $title1 = __('商品推荐统计', 'goods');
        $title2 = __('商品统计', 'goods');

        $static_url = RC_App::apps_url('goods/statics/images/goodsstats_images/');
        ecjia_admin::$controller->assign('static_url', $static_url);
        
        $goods = RC_Cache::app_cache_get('admin_dashboard_goods', 'goods');
        if (!$goods) {
            $fields = "SUM(IF(goods_id > 0, 1, 0)) as total, SUM(IF(is_new = 1, 1, 0)) as new, SUM(IF(is_best = 1, 1, 0)) as best, SUM(IF(is_hot = 1, 1, 0)) as hot";
            
            $row = RC_DB::table('goods')->select(RC_DB::raw($fields))->where('is_delete', 0)->where('is_real', 1)->whereRaw("(extension_code is null or extension_code ='')")->get();

            $goods['total'] = $row[0]['total'];  	//总数
            $goods['new_goods'] = $row[0]['new'];	//新品
            $goods['best_goods'] = $row[0]['best']; //精品
            $goods['hot_goods'] = $row[0]['hot'];   //热销
            
            //在售商品
            $goods['selling'] 			= RC_DB::table('goods')->where('is_real', 1)->where('is_on_sale', 1)->whereIn('review_status', [3, 5])->where('is_delete', 0)->whereRaw("(extension_code is null or extension_code ='')")->count();
            $goods['selling_goods_url'] = RC_Uri::url('goods/admin/init');
        	//售罄商品
            $goods['finish']  			= RC_DB::table('goods')->where('goods_number', 0)->where('is_on_sale', 0)->whereIn('review_status', [3,5])->where('is_delete', 0)->where('is_real', 1)->whereRaw("(extension_code is null or extension_code ='')")->count();
            $goods['finish_goods_url'] 	= RC_Uri::url('goods/admin/finish');
            //下架商品
            $goods['obtained'] 			= RC_DB::table('goods')->where('goods_number', '>', 0)->where('is_on_sale', 0)->whereIn('review_status', [3, 5])->where('is_delete', 0)->where('is_real', 1)->whereRaw("(extension_code is null or extension_code ='')")->count();
            $goods['obtained_goods_url']= RC_Uri::url('goods/admin/obtained');
            //待审核商品
            $goods['await_check'] 	= RC_DB::table('goods')->where('review_status', 1)->where('is_delete', 0)->where('is_real', 1)->whereRaw("(extension_code is null or extension_code ='')")->count();
            $goods['obtained_goods_url']= RC_Uri::url('goods/admin/check');
			//散装商品
			$goods['bulk']			= RC_DB::table('goods')->where('is_delete', 0)->where('extension_code', 'bulk')->count();
            //收银台商品
            $goods['cashier']		= RC_DB::table('goods')->where('is_delete', 0)->where('extension_code', 'cashier')->count();
            
            //新品首发百分比
            $goods['new_percent'] = intval($goods['new_goods']/$goods['total']*100);
            //精品推荐
            $goods['best_percent'] = intval($goods['best_goods']/$goods['total']*100);
            //热销商品
            $goods['hot_percent']  = intval($goods['hot_goods']/$goods['total']*100);
            
            
            RC_Cache::app_cache_set('admin_dashboard_goods', $goods, 'goods', 120);
        }

        ecjia_admin::$controller->assign('title1', $title1);
        ecjia_admin::$controller->assign('title2', $title2);
        ecjia_admin::$controller->assign('goods', $goods);
        echo ecjia_admin::$controller->fetch(ecjia_app::get_app_template('library/widget_admin_dashboard_goodsstat.lbi', 'goods'));
    }

    public static function append_admin_setting_group($menus)
    {
        $setting = ecjia_admin_setting::singleton();

        $menus[] = ecjia_admin::make_admin_menu('nav-header', __('商品', 'goods'), '', 20)->add_purview(array('goods_setting'));
        $menus[] = ecjia_admin::make_admin_menu('goods', __('商品基本设置', 'goods'), RC_Uri::url('setting/shop_config/init', array('code' => 'goods')), 21)->add_purview('goods_setting')->add_icon('fontello-icon-gift');
        $menus[] = ecjia_admin::make_admin_menu('goods_display', __('商品显示设置', 'goods'), RC_Uri::url('setting/shop_config/init', array('code' => 'goods_display')), 22)->add_purview('goods_setting')->add_icon('fontello-icon-desktop');
        $menus[] = ecjia_admin::make_admin_menu('goods_price', __('商品价格设置', 'goods'), RC_Uri::url('setting/shop_config/init', array('code' => 'goods_price')), 23)->add_purview('goods_setting')->add_icon('fontello-icon-gift');

        return $menus;
    }

    public static function add_admin_setting_command($factories)
    {
        $factories['goods'] = 'Ecjia\App\Goods\SettingComponents\GoodsSetting';
        $factories['goods_display'] = 'Ecjia\App\Goods\SettingComponents\GoodsDisplaySetting';
        $factories['goods_price'] = 'Ecjia\App\Goods\SettingComponents\GoodsPriceSetting';

        return $factories;
    }

    public static function add_maintain_command($factories)
    {
        $factories['goods_spec_parameter_compatible'] = 'Ecjia\App\Goods\Maintains\GoodsSpecParameterCompatible';
        $factories['goods_parameter_attrgroup_compatible'] = 'Ecjia\App\Goods\Maintains\GoodsParameterAttrgroupCompatible';
        $factories['goods_up_levels_catid_compatible'] = 'Ecjia\App\Goods\Maintains\GoodsUpLevelsCatidCompatible';
        return $factories;
    }
}

RC_Hook::add_action('admin_dashboard_top', array('goods_admin_hooks', 'widget_admin_dashboard_goodsstat'), 11);
RC_Hook::add_action( 'append_admin_setting_group', array('goods_admin_hooks', 'append_admin_setting_group') );
RC_Hook::add_action('ecjia_setting_component_filter', array('goods_admin_hooks', 'add_admin_setting_command'));
RC_Hook::add_action('ecjia_maintain_command_filter', array('goods_admin_hooks', 'add_maintain_command'));

// end
