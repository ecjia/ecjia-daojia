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
 * 用户注销账户申请
 * @author zrl
 */
class user_account_delete_apply_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        if ($_SESSION['user_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        $smscode = $this->requestData('smscode', '');
        //参数判断
        if (empty($smscode)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数错误', 'user'), 'user_account_delete_apply_module'));
        }
        $user_id = $_SESSION['user_id'];
        //用户信息
        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));

        //验证验证码
        $check_smscode_result = $this->_checkSmsCode($smscode, $user_info);
        if (is_ecjia_error($check_smscode_result)) {
            return $check_smscode_result;
        }

        $handles = (new \Ecjia\App\User\UserCleanManager($user_id))->getFactories();

        /*账户内是否有余额*/
        $user_money_code   = 'user_money_clear';
        $user_handle       = array_get($handles, $user_money_code);
        $user_money_result = $user_handle->handleCount();
        if (!empty($user_money_result)) {
            return new ecjia_error('user_money_unclear', __('请确保账号内无余额或已结清！', 'user'));
        }

        /* 有没未解除的第三方关联账号 */
        $user_connect_code   = 'user_connect_clear';
        $user_connect_handle = array_get($handles, $user_connect_code);
        $user_connect_count  = $user_connect_handle->handleCount();
        if (!empty($user_connect_count)) {
            return new ecjia_error('connected_user_unclear', __('请先解除要注销账号与其他网站、其他APP的授权登录或绑定关系！', 'user'));
        }

        /*有没未完成（未付款，已付款未发货，未确认收货，退款中）的订单*/
        $unfinish_order_count = $this->_getUnfinishOrder($user_id);
        if (!empty($unfinish_order_count)) {
            return new ecjia_error('unfinished_order_error', __('请确保账号内交易无未完成订单！', 'user'));
        }

        //更新用户账号状态
        RC_DB::table('users')->where('user_id', $user_id)->update(array('account_status' => 'wait_delete', 'delete_time' => RC_Time::gmtime()));

        return array();
    }


    /**
     * 检查验证码
     */
    private function _checkSmsCode($smscode, $user_info)
    {
        //判断校验码是否过期
        if ($_SESSION['captcha']['sms']['user_delete_account']['sendtime'] + 1800 < RC_Time::gmtime()) {
            //过期
            return new ecjia_error('code_timeout', __('验证码已过期，请重新获取！', 'user'));
        }
        //判断校验码是否正确
        if ($smscode != $_SESSION['captcha']['sms']['user_delete_account']['code']) {
            return new ecjia_error('code_error', __('验证码错误，请重新填写！', 'user'));
        }

        //校验其他信息
        if ($user_info['mobile_phone'] != $_SESSION['captcha']['sms']['user_delete_account']['value']) {
            return new ecjia_error('msg_error', __('接受验证码手机号与用户绑定手机号不同！', 'user'));
        }

        return true;
    }

    /**
     * 获取用户未完成订单数（未付款，已付款未发货，未确认收货，退款中）的订单
     */
    private function _getUnfinishOrder($user_id)
    {
        //未付款的
        $unpay_count = RC_DB::table('order_info')
            ->where('is_delete', 0)
            ->where('user_id', $user_id)
            ->where('pay_status', PS_UNPAYED)
            ->whereNotIn('order_status', array(OS_CANCELED, OS_INVALID))
            ->count();
        //待发货的
        $await_ship_count = $this->get_await_order_count($user_id);
        //待确认收货的
        $await_confirm_count = RC_DB::table('order_info')->where('is_delete', 0)
            ->where('user_id', $user_id)
            ->where('shipping_status', '>', SS_UNSHIPPED)
            ->where('shipping_status', '<>', SS_RECEIVED)
            ->whereNotIn('order_status', array(OS_RETURNED, OS_CANCELED, OS_INVALID))
            ->count();
        //退款中的
        $unrefunded_count     = RC_DB::table('refund_order')
            ->where('user_id', $user_id)
            ->where('status', '!=', Ecjia\App\Refund\RefundStatus::ORDER_REFUSED)
            ->where('refund_status', '!=', Ecjia\App\Refund\RefundStatus::PAY_TRANSFERED)
            ->count();
        $total_unfinish_count = $unpay_count + $await_ship_count + $await_confirm_count + $unrefunded_count;

        return $total_unfinish_count;
    }

    /**
     * 待发货订单
     */
    private function get_await_order_count($user_id)
    {
        $count = RC_DB::table('order_info')->whereIn('order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
            ->whereIn('shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
            ->whereIn('pay_status', array(PS_PAYED, PS_PAYING))
            ->where('is_delete', 0)
            ->where('user_id', $user_id)
            ->count();
        return $count;
    }
}



// end