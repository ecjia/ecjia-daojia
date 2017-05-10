<?php
defined('IN_ECJIA') or exit('No permission resources.');

class get_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
	    //sms_get_validate 
    
		$type = $this->requestData('type');
		$value = $this->requestData('value', '');
		if (empty($type) || empty($value)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		$code = rand(100001, 999999);
		if ($type == 'mobile') {
		    $chars = "/^1(3|4|5|7|8)\d{9}$/s";
		    if (!preg_match($chars, $value)) {
		        return new ecjia_error('mobile_error', '手机号码格式错误');
		    }
		    if (RC_Time::gmtime() - $_SESSION['validate_code']['sms']['sendtime'] < 60) {
		        return new ecjia_error('send_error', '发送频率过高，请一分钟后再试');
		    }
			//发送短信
			$tpl_name = 'sms_get_validate ';
			$tpl = RC_Api::api('sms', 'sms_template', $tpl_name);
			ecjia_api::$view_object->assign('code', $code);
			ecjia_api::$view_object->assign('service_phone', ecjia::config('service_phone'));
			$content = ecjia_api::$controller->fetch_string($tpl['template_content']);
			$options = array(
				'mobile' 		=> $value,
				'msg'			=> $content,
				'template_id' 	=> $tpl['template_id'],
			);
			
			$response = RC_Api::api('sms', 'sms_send', $options);
			if ($response === true) {
			    $_SESSION['validate_code']['sms'] = array(
			        'value' => $value,
			        'code' => $code,
			        'lifetime' => RC_Time::gmtime() + 1800,
			        'sendtime' => RC_Time::gmtime(),
			    );
				return array();
			} else {
				return new ecjia_error('sms_error', '短信发送失败！');//$response['description']
			}
		} else if ($type == 'email') {
		    
		    $chars = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		    if (!preg_match($chars, $value)) {
		        return new ecjia_error('email_error', '邮箱账号格式错误');
		    }
		    if (RC_Time::gmtime() - $_SESSION['validate_code_sendtime'] < 60) {
		        return new ecjia_error('send_error', '发送频率过高，请一分钟后再试');
		    }

		    $tpl_name = 'send_validate';
		    $tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
		    /* 判断短信模板是否存在*/
		    if (!empty($tpl)) {
		        ecjia_api::$controller->assign('user_name', $_SESSION['user_name']);
		        ecjia_api::$controller->assign('code', $code);
		        ecjia_api::$controller->assign('service_phone', ecjia::config('service_phone'));
		        ecjia_api::$controller->assign('shop_name', ecjia::config('shop_name'));
		        ecjia_api::$controller->assign('send_date', RC_Time::local_date('Y-m-d'));
		        $content  = ecjia_api::$controller->fetch_string($tpl['template_content']);
		        $response = RC_Mail::send_mail(ecjia::config('shop_name'), $value, $tpl['template_subject'], $content, $tpl['is_html']);
		    } else {
		        return new ecjia_error('email_template_error', __('请检查短信模板send_validate'));
		    }
		    
		    /* 判断是否发送成功*/
		    if ($response === true) {
		        $time = RC_Time::gmtime();
		        $_SESSION['validate_code']['email'] = array(
		            'value' => $value,
		            'code' => $code,
		            'lifetime' => RC_Time::gmtime() + 1800,
		            'sendtime' => RC_Time::gmtime(),
		        );
		        return array('data' => '验证码发送成功！');
		    } else {
		        return new ecjia_error('send_code_error', __('验证码发送失败！'));
		    }
		    
		}
	}
}


// end