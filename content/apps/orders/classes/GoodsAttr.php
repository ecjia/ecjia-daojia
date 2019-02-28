<?php

namespace Ecjia\App\Orders;

class GoodsAttr
{

    public static function encodeGoodsAttr($attr)
    {

    }


    public static function decodeGoodsAttr($goods_attr)
    {
        $attr = array();
        if (!empty($goods_attr)) {
            $goods_attr = explode("\n", $goods_attr);
            $goods_attr = array_filter($goods_attr);

            foreach ($goods_attr as $val) {
                $a = explode(':', $val);
                if (!empty($a[0]) && !empty($a[1])) {
                    $attr[] = array('name' => $a[0], 'value' => $a[1]);
                }
            }
        }

        return $attr;
    }

}
