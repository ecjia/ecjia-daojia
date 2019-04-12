<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 13:32
 */
namespace Ecjia\App\Weapp\Contracts;

interface WeappMerchantPayment
{

    /**
     * 重新设置微信支付配置项
     * @param \Ecjia\App\Platform\Frameworks\Platform\Account $account
     *
     * @return \ecjia_error | bool
     */
    public function resetWechatPayConfig($account);

}