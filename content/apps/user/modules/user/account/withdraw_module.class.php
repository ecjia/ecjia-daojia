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
 * 用户提现申请 替换 user/account/raply
 * @author hyy
 *
 * @add 1.25
 * @lastupdate 1.25
 */
class user_account_withdraw_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $user_id = $_SESSION['user_id'];
        if ($_SESSION['user_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        //判断用户有没申请注销
        $account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
        if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
            return new ecjia_error('account_status_error', __('当前账号已申请注销，不可执行此操作！', 'user'));
        }

        $amount           = $this->requestData('amount');
        $user_note        = $this->requestData('note', '');
        $withdraw_way     = $this->requestData('withdraw_way', '');//提现方式（wechat微信钱包，bank银行转账） 
        $withdraw_way_arr = array('wechat', 'bank');

        if (empty($withdraw_way) || !in_array($withdraw_way, $withdraw_way_arr)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数错误！', 'user'), 'user_account_withdraw_module'));
        }

        //判断用户有没绑定微信钱包和银行卡
        $withdraw_way_bind = $this->is_bind_withdraw_way($withdraw_way, $user_id);
        if (!$withdraw_way_bind) {
            return new ecjia_error('not_bind_withdraw_way', __('您还未绑定此提现方式！', 'user'));
        }

        $amount = floatval($amount);
        if ($amount <= 0) {
            return new ecjia_error('amount_gt_zero', __('请在“金额”栏输入大于0的数字！', 'user'));
        }

        $pay_fee     = '0.00';
        $real_amount = $amount;

        /* 最小提现金额 */
        $withdraw_min_amount = ecjia::config('withdraw_min_amount');
        if ($withdraw_min_amount > 0) {
            if ($amount < $withdraw_min_amount) {
                return new ecjia_error('withdraw_min_amount_error', sprintf(__('提现金额不可小于最小提现金额：%s元', 'user'), $withdraw_min_amount));
            }
        }

        RC_Loader::load_app_func('admin_user', 'user');
        /* 判断是否有足够的余额的进行退款的操作 */
        //会员可用余额 ，即 用户现有余额;
        RC_Loader::load_app_class('user_account', 'user', false);
        $user_current_money = user_account::get_user_money($user_id);
        if ($amount > $user_current_money) {
            return new ecjia_error('surplus_amount_error', __('您申请提现的金额超过了现有余额，此操作将不可进行！', 'user'));
        }

        /* 提现手续费 */
        $withdraw_fee = ecjia::config('withdraw_fee');
        if ($withdraw_fee > 0) {
            $pay_fee = $amount * ($withdraw_fee / 100);
            if ($pay_fee > $amount) {
                $pay_fee = $amount;
            }
            $real_amount = $amount - $pay_fee;
        }


        //支付方式
        $payment = [
            'bank'   => [
                'pay_code' => 'withdraw_bank',
                'pay_name' => __('银行转账提现', 'user')
            ],
            'wechat' => [
                'pay_code' => 'withdraw_wxpay',
                'pay_name' => __('微信钱包提现', 'user')
            ],
        ];


        /* 变量初始化 */
        $surplus = array(
            'user_id'      => $user_id,
            'order_sn'     => ecjia_order_deposit_sn(),
            'process_type' => 1,
            'payment'      => isset($payment[$withdraw_way]['pay_code']) ? $payment[$withdraw_way]['pay_code'] : '',
            'payment_name' => isset($payment[$withdraw_way]['pay_name']) ? $payment[$withdraw_way]['pay_name'] : '',
            'user_note'    => $user_note,
            'amount'       => $amount,
            'from_type'    => 'user',
            'from_value'   => $user_id,
            'pay_fee'      => $pay_fee,
            'real_amount'  => $real_amount,
        );

        //绑定的提现方式信息
        $bank_info = RC_DB::table('withdraw_user_bank')->where('user_id', $user_id)->where('user_type', 'user')->where('bank_type', $withdraw_way)->first();

        $surplus['bank_name']        = empty($bank_info['bank_name']) ? '' : $bank_info['bank_name'];
        $surplus['bank_branch_name'] = empty($bank_info['bank_branch_name']) ? '' : $bank_info['bank_branch_name'];
        $surplus['bank_card']        = empty($bank_info['bank_card']) ? '' : $bank_info['bank_card'];
        $surplus['cardholder']       = empty($bank_info['cardholder']) ? '' : $bank_info['cardholder'];
        $surplus['bank_en_short']    = empty($bank_info['bank_en_short']) ? '' : $bank_info['bank_en_short'];


        //插入会员账目明细
        $change_amount         = $amount * -1;
        $surplus['account_id'] = insert_user_account($surplus, $change_amount);

        /* 如果成功提交 */
        if ($surplus['account_id'] > 0) {

            //提现申请成功，记录account_log；从余额中冻结提现金额
            $frozen_money = $amount;

            $options = array(
                'user_id'      => $_SESSION['user_id'],
                'frozen_money' => $frozen_money,
                'user_money'   => $change_amount,
                'change_type'  => ACT_DRAWING,
                'change_desc'  => __('【申请提现】', 'user')
            );

            RC_Api::api('user', 'account_change_log', $options);

            return array('data' => __("您的提现申请已成功提交，请等待管理员的审核！", 'user'));
        } else {
            $result = new ecjia_error('process_false', __('此次操作失败，请返回重试！', 'user'));
            return $result;
        }
    }

    /**
     * 判断是否有绑定此提现方式
     */
    private function is_bind_withdraw_way($withdraw_way, $user_id)
    {
        $withdraw_way_arr = array('wechat', 'bank');
        if (in_array($withdraw_way, $withdraw_way_arr)) {
            $withdraw_way_info = RC_DB::table('withdraw_user_bank')->where('user_id', $user_id)->where('user_type', 'user')->where('bank_type', $withdraw_way)->first();
            if (empty($withdraw_way_info)) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }
}

// end