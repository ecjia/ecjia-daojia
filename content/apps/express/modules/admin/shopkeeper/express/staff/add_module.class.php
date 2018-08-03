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
 * 掌柜添加配送员
 * @author zrl
 */
class add_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authadminSession();
    	if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		//检查权限，添加员工的权限
        $result = $this->admin_priv('staff_update');
        if (is_ecjia_error($result)) {
        	return $result;
        }
        
        $name 		= $this->requestData('name', '');
        $mobile 	= $this->requestData('mobile', '');
        $user_ident = $this->requestData('user_ident', '');
        $email 		= $this->requestData('email', '');
        $remark 	= $this->requestData('remark', '');
        
		if (empty($name) || empty($mobile) || empty($user_ident) || empty($remark)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
    	}
    	
    	//用户名重复判断
    	$user_name_count = RC_DB::table('staff_user')->where('name', $name)->where('store_id', $_SESSION['store_id'])->count();
    	if ($user_name_count > 0) {
    		return new ecjia_error('staff_name_exist', '该员工名称已存在');
    	}
    	//邮件重复判断
    	$email_count = RC_DB::table('staff_user')->where('email', $email)->where('store_id', $_SESSION['store_id'])->count();
    	if ($email_count > 0) {
    		return new ecjia_error('email_exist', '该邮箱已存在');
    	}
    	//工号重复判断
    	$user_ident_count = RC_DB::table('staff_user')->where('user_ident', $user_ident)->where('store_id', $_SESSION['store_id'])->count();
    	if ($user_ident_count > 0) {
    		return new ecjia_error('user_ident_exist', '该员工工号已存在');
    	}
    	
    	$manager_id = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->pluck('user_id');

    	$password = rand(100000,999999);
    	$salt = rand(1, 9999);
    	$password_last = md5(md5($password) . $salt);
    	
    	$group_id = '-1';
    	
        $data       = array(
            'store_id'     => $_SESSION['store_id'],
            'name'         => $name,
            'nick_name'    => '',
            'user_ident'   => $user_ident,
            'mobile'       => $mobile,
            'email'        => $email,
            'password'     => $password_last,
        	'salt'		   => $salt,
            'group_id'     => $group_id,
            'action_list'  => '',
            'todolist'     => $remark,
            'add_time'     => RC_Time::gmtime(),
            'parent_id'    => $manager_id,
            'introduction' => '',
        );
        
        $staff_id = RC_DB::table('staff_user')->insertGetId($data);
    	if ($staff_id) {
    		//插入配送员关联表
    		if($group_id == '-1') {
    			$data_express = array(
    					'user_id'				=> $staff_id,
    					'store_id'  			=> $_SESSION['store_id'],
    					'work_type' 			=> 1,
    					'shippingfee_percent' 	=> 100,
    					'apply_source' 			=> 'merchant',
    			);
    			$user_id = RC_DB::table('express_user')->insertGetId($data_express);
    		}
    		//记录管理员操作log
    		Ecjia\App\Express\Helper::assign_adminlog_content();
    		RC_Api::api('merchant', 'admin_log', array('text'=> '配送员:'.$name.'【来源掌柜】', 'action'=>'add', 'object'=>'express_user'));
    		
    		//短信发送通知
    		$store_name = $_SESSION['store_name'];
    		$options = array(
    				'mobile' => $mobile,
    				'event'	 => 'sms_store_express_added',
    				'value'  =>array(
    						'user_name'	 => $name,
    						'store_name' => $store_name,
    						'account'	 => $mobile,
    						'password'	 => $password,
    				),
    		);
    		$response = RC_Api::api('sms', 'send_event_sms', $options);
    		return array();
    	} else {
    		return new ecjia_error('add_staff_fail', '添加员工失败！');
    	}
	 }	
}

// end