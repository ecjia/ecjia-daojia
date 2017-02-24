<?php namespace Royalcms\Component\WeChat;

/**
 * @file
 *
 * 红包
 */

class Coupon {
    
    /**
     * 发送红包
     * @see https://pay.weixin.qq.com/wiki/doc/api/cash_coupon.php?chapter=13_5
     *
     *@todo data {
            'nonce_str'    : 随机字符串,
            'mch_id'       : 商户号,
            'mch_billno'   : 商户订单号,唯一
            'send_name'    : 商户名称
            're_openid'    : 用户openid,
            'wxappid'      : 公众号appid,
            'total_amount' : 金额 单位:分,
            'total_num'    : 红包发放总人数,写1就可,
            'wishing'      : 红包祝福语,
            'client_ip'    : 客户端IP
            'act_name'     : 活动名称,
            'remark'       : 备注,
        }
        
     *@return {
         
         
        }
     */
    
    public static function send($data, $certs = array()) {
        
    }

}
