<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 17:00
 */
namespace Ecjia\App\Cart;

use Ecjia\App\Goods\GoodsFunction;
use RC_Loader;
use RC_DB;

class CartFunction
{

    /**
     * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格
     * 如果商品有促销，价格不变
     * @access public
     * @return void
     * @update 180719 选择性更新内容
     */
    public static function recalculate_price($device = array())
    {
        $db_cart = RC_Loader::load_app_model('cart_model', 'cart');
        $dbview = RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');
        $codes = config('app-cashier::cashier_device_code');
        if (!empty($device)) {
            if (in_array($device['code'], $codes)) {
                $rec_type = CART_CASHDESK_GOODS;
            }
        } else {
            $rec_type = CART_GENERAL_GOODS;
        }

        $discount = $_SESSION['discount'];
        $user_rank = $_SESSION['user_rank'];

        $db = RC_DB::table('cart as c')
            ->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->leftJoin('member_price as mp', function($join) use ($user_rank) {
                $join->where(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))
                    ->where(RC_DB::raw('mp.user_rank'), '=', $user_rank);
            })
            ->select(RC_DB::raw("c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * $discount) AS member_price"));

        /* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
        // @update 180719 选择性更新内容mark_changed=1
        if ($_SESSION['user_id']) {
// 		$res = $dbview->join(array(
// 			'goods',
// 			'member_price'
// 		))
// 		->where('c.mark_changed =1 AND c.user_id = "' . $_SESSION['user_id'] . '" AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 AND c.rec_type = "' . $rec_type . '" ')
// 		->select();


            $res = $db
                ->where(RC_DB::raw('c.mark_changed'), 1)
                ->where(RC_DB::raw('c.user_id'), $_SESSION['user_id'])
                ->where(RC_DB::raw('c.parent_id'), 0)
                ->where(RC_DB::raw('c.is_gift'), 0)
                ->where(RC_DB::raw('c.goods_id'), '>', 0)
                ->where(RC_DB::raw('c.rec_type'), $rec_type)
                ->get();

        } else {
// 		$res = $dbview->join(array(
// 			'goods',
// 			'member_price'
// 		))
// 		->where('c.mark_changed =1 AND c.session_id = "' . SESS_ID . '" AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 AND c.rec_type = "' . $rec_type . '" ')
// 		->select();

            $res = $db
                ->where(RC_DB::raw('c.mark_changed'), 1)
                ->where(RC_DB::raw('c.session_id'), SESS_ID)
                ->where(RC_DB::raw('c.parent_id'), 0)
                ->where(RC_DB::raw('c.is_gift'), 0)
                ->where(RC_DB::raw('c.goods_id'), '>', 0)
                ->where(RC_DB::raw('c.rec_type'), $rec_type)
                ->get();
        }


        if (! empty($res)) {
            RC_Loader::load_app_func('global', 'goods');
            foreach ($res as $row) {
                $attr_id = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);
                $goods_price = GoodsFunction::get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);
                $data = array(
                    'goods_price' => $goods_price > 0 ? $goods_price : 0.00,
                    'mark_changed' => 0
                );
                if ($_SESSION['user_id']) {
                    $db_cart->where('goods_id = ' . $row['goods_id'] . ' AND user_id = "' . $_SESSION['user_id'] . '" AND rec_id = "' . $row['rec_id'] . '"')->update($data);
                } else {
                    $db_cart->where('goods_id = ' . $row['goods_id'] . ' AND session_id = "' . SESS_ID . '" AND rec_id = "' . $row['rec_id'] . '"')->update($data);
                }
            }
        }
        /* 删除赠品，重新选择 */

        if ($_SESSION['user_id']) {
            $db_cart->where('user_id = "' . $_SESSION['user_id'] . '" AND is_gift > 0')->delete();
        } else {
            $db_cart->where('session_id = "' . SESS_ID . '" AND is_gift > 0')->delete();
        }
    }

}