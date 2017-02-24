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
 * 认证申请
 * @author will.chen
 */
class validate_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }

		$validate_code = $this->requestData('validate_code', '');

		$time = RC_Time::gmtime();
		if (empty($validate_code) || $_SESSION['merchant_validate_code'] != $validate_code || $_SESSION['merchant_validate_expiry'] < $time) {
			return new ecjia_error('code_error', '验证码不正确！');
		}

		$merchant_info = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();

		$responsible_person 		= $this->requestData('responsible_person', '');
		$identity_type 				= $this->requestData('identity_type', '');
		$identity_number 			= $this->requestData('identity_number', '');
		$company_name 				= $this->requestData('company_name', '');
		

		$data = array();

		if (!empty($responsible_person)) {
			$data['responsible_person'] = $responsible_person;
			unset($merchant_info['responsible_person']);
		}
		
		if (!empty($identity_type)) {
			$data['identity_type'] = $identity_type;
			unset($merchant_info['identity_type']);
		}

		if (!empty($identity_number)) {
			$data['identity_number'] = $identity_number;
			unset($merchant_info['identity_number']);
		}

		if (!empty($company_name)) {
			$data['company_name'] = $company_name;
			unset($merchant_info['company_name']);
		}

		$store_preaudit_info   = RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();
		$store_franchisee_info = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();

		$save_path = 'merchant/'.$_SESSION['store_id'].'/data/identity_pic';
		$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));

		/* 手持身份证*/
		if (isset($_FILES['identity_pic'])) {
			$image_info	= $upload->upload($_FILES['identity_pic']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$personhand_identity_pic = $upload->get_position($image_info);
// 				if (!empty($store_preaudit_info['personhand_identity_pic'])) {
// 					$upload->remove($store_preaudit_info['personhand_identity_pic']);
// 				}
				$data['personhand_identity_pic'] = $personhand_identity_pic;
				unset($merchant_info['personhand_identity_pic']);
			}
		}

		/* 身份证正面*/
		if (isset($_FILES['identity_pic_front'])) {
			$image_info	= $upload->upload($_FILES['identity_pic_front']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$identity_pic_front = $upload->get_position($image_info);
// 				if (!empty($store_preaudit_info['identity_pic_front'])) {
// 					$upload->remove($store_preaudit_info['identity_pic_front']);
// 				}
				$data['identity_pic_front'] = $identity_pic_front;
				unset($merchant_info['identity_pic_front']);
			}
		} 

		/* 手持身反面*/
		if (isset($_FILES['identity_pic_back'])) {
			$image_info	= $upload->upload($_FILES['identity_pic_back']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$identity_pic_back = $upload->get_position($image_info);
// 				if (!empty($store_preaudit_info['identity_pic_back'])) {
// 					$upload->remove($store_preaudit_info['identity_pic_back']);
// 				}
				$data['identity_pic_back'] = $identity_pic_back;
				unset($merchant_info['identity_pic_back']);
			}
		}

		/* 营业执照*/
		if (isset($_FILES['business_licence_pic'])) {
			$save_path = 'merchant/'.$_SESSION['store_id'].'/data/business_licence';
			$upload_business_licence = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));

			$image_info	= $upload_business_licence->upload($_FILES['business_licence_pic']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$business_licence_pic = $upload_business_licence->get_position($image_info);
// 				if (!empty($store_preaudit_info['business_licence_pic'])) {
// 					$upload_business_licence->remove($store_preaudit_info['business_licence_pic']);
// 				}
				$data['business_licence_pic'] = $business_licence_pic;
				unset($merchant_info['business_licence_pic']);
			}
		}

		$data['identity_status'] = 1;
		if ($merchant_info['identity_status'] != 2) {
		    RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update(array('identity_status' => 1));
		}
		$data['apply_time'] = RC_Time::gmtime();
		unset($merchant_info['manage_mode']);unset($merchant_info['status']);unset($merchant_info['shop_close']);unset($merchant_info['apply_time']);
		unset($merchant_info['confirm_time']);unset($merchant_info['identity_status']);unset($merchant_info['percent_id']);unset($merchant_info['sort_order']);
		$data = array_merge($data, $merchant_info);

		if ($store_preaudit_info) {
			RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->update($data);
		} else {
			RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->insertGetId($data);
		}
		
		//审核日志
		RC_Loader::load_app_func('merchant_franchisee', 'franchisee');
		add_check_log($data, $store_franchisee_info);

		return array();
    }

}

//end