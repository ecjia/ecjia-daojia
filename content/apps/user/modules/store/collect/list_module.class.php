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
 * 用户收藏的店铺列表
 * @author zrl
 */
class store_collect_list_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $this->authSession();
        $user_id = $_SESSION['user_id'];
        if ($user_id <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        $api_version = $this->request->header('api-version');
        //判断用户有没申请注销
        if (version_compare($api_version, '1.25', '>=')) {
            $account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
            if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
                return new ecjia_error('account_status_error', __('当前账号已申请注销，不可查看此数据！', 'user'));
            }
        }

        $location = $this->requestData('location', array());

        /* 获取数量 */
        $size = $this->requestData('pagination.count', 15);
        $page = $this->requestData('pagination.page', 1);

        if (!is_array($location) || empty($location['longitude']) || empty($location['latitude'])) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'user'), __CLASS__));
        }

        $options = array(
            'size'     => $size,
            'page'     => $page,
            'user_id'  => $user_id,
            'location' => $location,
        );

        $collect_store_list = RC_Api::api('store', 'store_collect_list', $options);

        if (is_ecjia_error($collect_store_list)) {
            return $collect_store_list;
        }
        $arr = array();
        if (!empty($collect_store_list['list'])) {
            foreach ($collect_store_list['list'] as $rows) {
                $arr[] = array(
                    'store_id'               => intval($rows['store_id']),
                    'store_name'             => $rows['merchants_name'],
                    'manage_mode'            => $rows['manage_mode'],
                    'store_logo'             => $rows['store_logo'],
                    'store_notice'           => $rows['store_notice'],
                    'distance'               => $rows['distance'],
                    'label_trade_time'       => $rows['label_trade_time'],
                    'favourable_list'        => $rows['favourable_list'],
                    'allow_use_quickpay'     => $rows['allow_use_quickpay'],
                    'quickpay_activity_list' => $rows['quickpay_activity_list'],
                    'best_goods_count'       => $this->storeBestGoodsCount($rows['store_id']),
                    'store_best_goods'       => $this->storeBestGoods($rows['store_id']),
                );
            }
        }
        return array('data' => $arr, 'pager' => $collect_store_list['page']);
    }


    /**
     * 店铺推荐新品总数
     */
    private function storeBestGoodsCount($store_id)
    {
        $db_goods = RC_DB::table('goods')
            ->where('review_status', '>', 3)
            ->where('is_delete', 0)
            ->where('is_on_sale', 1)
            ->where('is_alone_sale', 1);

        $count = $db_goods->where('store_id', $store_id)->where('store_new', 1)->count();
        return $count;
    }

    /**
     * 店铺推荐商品
     */
    private function storeBestGoods($store_id)
    {
        $goods_list = [];
        $db_goods   = RC_DB::table('goods')
            ->where('review_status', '>', 2)
            ->where('is_delete', 0)
            ->where('is_on_sale', 1)
            ->where('is_alone_sale', 1);

        $list = $db_goods->where('store_id', $store_id)->where('store_new', 1)->take(4)->get();

        if (!empty($list)) {
            foreach ($list as $val) {
                if ($val['promote_price'] > 0) {
                    $promote_price = Ecjia\App\Goods\BargainPrice::bargain_price($val['promote_price'], $val['promote_start_date'], $val['promote_end_date']);
                } else {
                    $promote_price = 0;
                }

                $goods_list[] = array(
                    'goods_id'                     => intval($val['goods_id']),
                    'goods_name'                   => trim($val['goods_name']),
                    'market_price'                 => sprintf("%.2f", $val['market_price']),
                    'formatted_market_price'       => ecjia_price_format($val['market_price'], false),
                    'shop_price'                   => sprintf("%.2f", $val['shop_price']),
                    'formatted_shop_price'         => ecjia_price_format($val['shop_price'], false),
                    'promote_price'                => ($promote_price > 0) ? $promote_price : '',
                    'formatted_promote_price'      => ($promote_price > 0) ? price_format($promote_price) : '',
                    'promote_start_date'           => $val['promote_start_date'],
                    'promote_end_date'             => $val['promote_end_date'],
                    'formatted_promote_start_date' => $val['promote_start_date'] > 0 ? RC_Time::local_date('Y/m/d H:i:s O', $val['promote_start_date']) : '',
                    'formatted_promote_end_date'   => $val['promote_end_date'] > 0 ? RC_Time::local_date('Y/m/d H:i:s O', $val['promote_start_date']) : '',
                    'img'                          => array(
                        'thumb' => empty($val['goods_thumb']) ? '' : RC_Upload::upload_url($val['goods_thumb']),
                        'url'   => empty($val['original_img']) ? '' : RC_Upload::upload_url($val['original_img']),
                        'small' => empty($val['goods_img']) ? '' : RC_Upload::upload_url($val['goods_img']),
                    ),
                );
            }
        }

        return $goods_list;
    }
}
// end