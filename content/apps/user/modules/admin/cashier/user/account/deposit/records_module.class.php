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
 * 收银员查看用户充值记录
 * @author zrl
 */
class admin_cashier_user_account_deposit_records_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        $user_id     = $this->requestData('user_id', '0');
        
        if (empty($user_id)) {
        	return new ecjia_error('invalid_parameter', __('参数无效', 'user'));
        }
        
        $api_version = $this->request->header('api-version');
        //判断用户有没申请注销
        if (version_compare($api_version, '1.25', '>=')) {
            $account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
            if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
                return new ecjia_error('account_status_error', __('当前账号已申请注销，不可查看此数据！', 'user'));
            }
        }

        $size         = $this->requestData('pagination.count', '15');
        $page         = $this->requestData('pagination.page', '1');
       	
        $deposit_records = $this->_get_deposit_records($user_id, $page, $size);
        
		$result = ['data' => $deposit_records['list'], 'pager' => $deposit_records['page']];
		
		return $result;
    }
    
    
    /**
     * 获取用户充值记录
     */
    private function _get_deposit_records($user_id, $page, $size)
    {
    	$db = RC_DB::table('user_account as ua')->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'));
    	$db->where(RC_DB::raw('u.user_id'), $user_id)->where(RC_DB::raw('ua.process_type'), SURPLUS_SAVE)->where(RC_DB::raw('ua.is_paid'), '!=', Ecjia\App\Withdraw\WithdrawConstant::ORDER_PAY_STATUS_CANCEL);
    	//获取记录条数
    	$record_count = $db->count(RC_DB::raw('ua.id'));
    	$page_row = new ecjia_page($record_count, $size, 6, '', $page);
    	$record_list = $db->select(RC_DB::raw('ua.*, u.user_id, u.user_name, u.avatar_img'))->take($size)->skip($page_row->start_id - 1)->orderBy(RC_DB::raw('ua.add_time'), 'desc')->get();

    	$list = [];
    	if (!empty($record_list)) {
    		foreach ($record_list as $row) {
    			//获取支付方式名称
    			$payment_info = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataByCode($row['payment']);
    			if ($row['is_paid'] == '1') {
    				$pay_status = __('已完成', 'user');
    			} elseif ($row['is_paid'] == '2') {
    				$pay_status = __('已取消', 'user');
    			} else {
    				$pay_status = __('未确认', 'user');
    			}
    			$list[] = array(
    					'user_id' 			=> intval($row['user_id']),
    					'user_name'			=> $row['user_name'],
    					'avatar_img'		=> empty($row['avatar_img']) ? '' : RC_Upload::upload_url($row['avatar_img']),
    					'account_id'		=> intval($row['id']),
    					'order_sn'			=> $row['order_sn'],
    					'amount'			=> $row['amount'],
    					'formatted_amount'	=> ecjia_price_format($row['amount']),
    					'type'				=> 'deposit',
    					'type_label'		=> __('充值', 'user'),
    					'payment_id'		=> $payment_info['pay_id'],
    					'payment_name'		=> $payment_info['pay_name'],
    					'pay_status'		=> $pay_status,
    					'add_time'			=> RC_Time::local_date('Y-m-d H:i:s', $row['add_time']),
    			);
    		}
    	}
    	
    	if (empty($list)) {
    		return array('list' => array(), 'page' => ['total' => 0, 'count' => 0, 'more' => 0]);
    	} else {
    		$pager = array(
    				"total" => $page_row->total_records,
    				"count" => $page_row->total_records,
    				"more"  => $page_row->total_pages <= $page ? 0 : 1,
    		);
    		return ['list' => $list, 'page' => $pager];
    	}
    }
}

// end