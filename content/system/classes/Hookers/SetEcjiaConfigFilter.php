<?php


namespace Ecjia\System\Hookers;


class SetEcjiaConfigFilter
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($arr)
    {

        /* 对数值型设置处理 */
        $arr['watermark_alpha']      = isset($arr['watermark_alpha']) ? intval($arr['watermark_alpha']) : 0;
        $arr['market_price_rate']    = isset($arr['market_price_rate']) ? floatval($arr['market_price_rate']) : 0;
        $arr['integral_scale']       = isset($arr['integral_scale']) ? floatval($arr['integral_scale']) : 0;
        $arr['integral_percent']     = isset($arr['integral_percent']) ? floatval($arr['integral_percent']) : 0;
        $arr['cache_time']           = isset($arr['cache_time']) ? intval($arr['cache_time']) : 0;
        $arr['thumb_width']          = isset($arr['thumb_width']) ? intval($arr['thumb_width']) : 0;
        $arr['thumb_height']         = isset($arr['thumb_height']) ? intval($arr['thumb_height']) : 0;
        $arr['image_width']          = isset($arr['image_width']) ? intval($arr['image_width']) : 0;
        $arr['image_height']         = isset($arr['image_height']) ? intval($arr['image_height']) : 0;
        $arr['best_number']          = !empty($arr['best_number']) && intval($arr['best_number']) > 0 ? intval($arr['best_number'])     : 3;
        $arr['new_number']           = !empty($arr['new_number']) && intval($arr['new_number']) > 0 ? intval($arr['new_number'])      : 3;
        $arr['hot_number']           = !empty($arr['hot_number']) && intval($arr['hot_number']) > 0 ? intval($arr['hot_number'])      : 3;
        $arr['promote_number']       = !empty($arr['promote_number']) && intval($arr['promote_number']) > 0 ? intval($arr['promote_number'])  : 3;
        $arr['top_number']           = (isset($arr['top_number']) && intval($arr['top_number']) > 0) ? intval($arr['top_number'])      : 10;
        $arr['history_number']       = (isset($arr['history_number']) && intval($arr['history_number']) > 0) ? intval($arr['history_number'])  : 5;
        $arr['comments_number']      = (isset($arr['comments_number']) && intval($arr['comments_number']) > 0) ? intval($arr['comments_number']) : 5;
        $arr['article_number']       = (isset($arr['article_number']) && intval($arr['article_number']) > 0) ? intval($arr['article_number'])  : 5;
        $arr['page_size']            = (isset($arr['page_size']) && intval($arr['page_size']) > 0) ? intval($arr['page_size'])       : 10;
        $arr['bought_goods']         = isset($arr['bought_goods']) ? intval($arr['bought_goods']) : 0;
        $arr['goods_name_length']    = isset($arr['goods_name_length']) ? intval($arr['goods_name_length']) : 0;
        $arr['top10_time']           = isset($arr['top10_time']) ? intval($arr['top10_time']) : 0;
        $arr['goods_gallery_number'] = (isset($arr['goods_gallery_number']) && intval($arr['goods_gallery_number'])) ? intval($arr['goods_gallery_number']) : 5;
        $arr['no_picture']           = !empty($arr['no_picture']) ? str_replace('../', './', $arr['no_picture']) : 'images/no_picture.gif'; // 修改默认商品图片的路径
        $arr['qq']                   = !empty($arr['qq']) ? $arr['qq'] : '';
        $arr['ww']                   = !empty($arr['ww']) ? $arr['ww'] : '';
        $arr['default_storage']      = isset($arr['default_storage']) ? intval($arr['default_storage']) : 1;
        $arr['min_goods_amount']     = isset($arr['min_goods_amount']) ? floatval($arr['min_goods_amount']) : 0;
        $arr['one_step_buy']         = empty($arr['one_step_buy']) ? 0 : 1;
        $arr['invoice_type']         = empty($arr['invoice_type']) ? array('type' => array(), 'rate' => array()) : unserialize($arr['invoice_type']);
        $arr['show_order_type']      = isset($arr['show_order_type']) ? $arr['show_order_type'] : 0;    // 显示方式默认为列表方式
        $arr['help_open']            = isset($arr['help_open']) ? $arr['help_open'] : 1;    // 显示方式默认为列表方式


        //限定语言项
        $lang_array = array('zh_cn', 'zh_tw', 'en_us');
        if (empty($arr['lang']) || !in_array($arr['lang'], $lang_array)) {
            $arr['lang'] = 'zh_cn'; // 默认语言为简体中文
        }

        if (empty($arr['integrate_code'])) {
            $arr['integrate_code'] = 'ecjia'; // 默认的会员整合插件为 ecjia
        }

        return $arr;

    }

}