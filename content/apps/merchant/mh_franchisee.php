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
 * 店铺入驻信息
 */
class mh_franchisee extends ecjia_merchant {

    //private $store_preaudit;
    private $store_franchisee;
    //private $db_store_category;

    public function __construct() {
        parent::__construct();

        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');

        // 页面css样式
        RC_Style::enqueue_style('merchant', RC_App::apps_url('statics/css/merchant.css', __FILE__), array());

        // 步骤导航条
        RC_Style::enqueue_style('bar', RC_App::apps_url('statics/css/bar.css', __FILE__), array());

        // input file 长传
        RC_Style::enqueue_style('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', __FILE__), array());
        RC_Script::enqueue_script('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', __FILE__), array(), false, 1);
        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
        RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__) , array() , false, 1);
        RC_Script::enqueue_script('yomi', RC_App::apps_url('statics/js/jquery.yomi.js', __FILE__), array(), false, 1);

        // select 选择框
        RC_Style::enqueue_style('chosen_style', RC_App::apps_url('statics/assets/chosen/chosen.css', __FILE__), array());
        RC_Script::enqueue_script('chosen', RC_App::apps_url('statics/assets/chosen/chosen.jquery.min.js', __FILE__), array(), false, 1);
        RC_Script::enqueue_script('qq_map', ecjia_location_mapjs());
        
        RC_Loader::load_app_func('merchant');
        Ecjia\App\Merchant\Helper::assign_adminlog_content();
        // 自定义JS
        RC_Script::enqueue_script('merchant_info', RC_App::apps_url('statics/js/merchant_info.js', __FILE__) , array() , false, 1);
        RC_Script::localize_script('merchant_info', 'js_lang', config('app-merchant::jslang.merchant_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('我的店铺', 'merchant'), RC_Uri::url('merchant/mh_franchisee/init')));

        ecjia_merchant_screen::get_current_screen()->set_parentage('store', 'store/mh_franchisee.php');
    }


    /**
     * 店铺入驻信息
     */
    public function init() {
        $this->admin_priv('franchisee_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('入驻信息', 'merchant'), RC_Uri::url('merchant/mh_franchisee/init')));
        $this->assign('ur_here', __('商家入驻信息', 'merchant'));

        $data   = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $count  = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->count();

        $data['identity_pic_front']         = !empty($data['identity_pic_front'])       ? RC_Upload::upload_url($data['identity_pic_front'])        : '';
        $data['identity_pic_back']          = !empty($data['identity_pic_back'])        ? RC_Upload::upload_url($data['identity_pic_back'])         : '';
        $data['personhand_identity_pic']    = !empty($data['personhand_identity_pic'])  ? RC_Upload::upload_url($data['personhand_identity_pic'])   : '';
        $data['business_licence_pic']       = !empty($data['business_licence_pic'])     ? RC_Upload::upload_url($data['business_licence_pic'])      : '';
        $data['province']                   = !empty($data['province'])                 ? ecjia_region::getRegionName($data['province'])            : '';
        $data['city']                       = !empty($data['city'])                     ? ecjia_region::getRegionName($data['city'])                : '';
        $data['district']                   = !empty($data['district'])                 ? ecjia_region::getRegionName($data['district'])            : '';
        $data['street']                     = !empty($data['street'])                   ? ecjia_region::getRegionName($data['street'])              : '';
        $data['identity_type']              = !empty($data['identity_type'])            ? $data['identity_type']                                    : '1';
        
        //$data['cat_name'] = $this->db_store_category->where(array('cat_id' => $data['cat_id']))->get_field('cat_name');
        $data['cat_name'] = RC_DB::table('store_category')->where('cat_id', $data['cat_id'])->value('cat_name');
        $this->assign('data',$data);

        return $this->display('merchant_info.dwt');
    }

    /**
     * 收款之类的信息
     */
    public function receipt() {
        $this->admin_priv('franchisee_bank');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收款账号', 'merchant'), RC_Uri::url('merchant/mh_franchisee/init')));
        $this->assign('ur_here', __('收款账号', 'merchant'));
        $data = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->select('bank_name', 'bank_branch_name', 'bank_account_name', 'bank_account_number','bank_address')->first();
        $this->assign('data',$data);
        return $this->display('merchant_receipt.dwt');
    }

    /**
     * 编辑收款之类的信息
     */
    public function receipt_edit() {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑收款账号', 'merchant'), RC_Uri::url('merchant/mh_franchisee/init')));

        $this->assign('ur_here', __('编辑收款账号', 'merchant'));
        $this->assign('action_link', array('href' => RC_Uri::url('merchant/mh_franchisee/receipt'), 'text' => __('收款账号', 'merchant')));
        $data = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->select('bank_name', 'bank_branch_name', 'bank_account_name', 'bank_account_number','bank_address')->first();
        $this->assign('data',$data);
        $form_action = RC_Uri::url('merchant/mh_franchisee/receipt_update');
        $this->assign('form_action',$form_action);

        return $this->display('merchant_receipt_edit.dwt');
    }

    /**
     * 更新收款之类的信息
     */
    public function receipt_update() {
        $this->admin_priv('franchisee_bank', ecjia::MSGTYPE_JSON);

        $bank_name              = !empty($_POST['bank_name'])           ? htmlspecialchars(remove_xss($_POST['bank_name']))             : '';
        $bank_account_number    = !empty($_POST['bank_account_number']) ? htmlspecialchars(remove_xss($_POST['bank_account_number']))   : '';
        $bank_account_name      = !empty($_POST['bank_account_name'])   ? htmlspecialchars(remove_xss($_POST['bank_account_name']))     : '';
        $bank_branch_name       = !empty($_POST['bank_branch_name'])    ? htmlspecialchars(remove_xss($_POST['bank_branch_name']))      : '';
        $bank_address           = !empty($_POST['bank_address'])        ? htmlspecialchars(remove_xss($_POST['bank_address']))          : '';
        if (empty($bank_name) || empty($bank_account_number) || empty($bank_account_name) || empty($bank_branch_name) || empty($bank_address)) {
            return $this->showmessage(__('请不要提交空值', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data = array(
            'bank_name'             => $bank_name,
            'bank_account_number'   => $bank_account_number,
            'bank_account_name'     => $bank_account_name,
            'bank_branch_name'      => $bank_branch_name,
            'bank_address'          => $bank_address,
        );
        $result = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update($data);
        // 记录日志
        ecjia_merchant::admin_log(__('修改收款账号', 'merchant'), 'edit', 'merchant');
        return $this->showmessage(__('成功修改收款账号', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/mh_franchisee/receipt')));
    }

    /**
     * 店铺入驻信息
     */
    public function request_edit() {
        $this->admin_priv('franchisee_request');
        
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('提交申请', 'merchant')));
        $this->assign('ur_here', __('提交申请', 'merchant'));
        $this->assign('action_link', array('href' => RC_Uri::url('merchant/mh_franchisee/init'), 'text' => __('入驻信息', 'merchant')));
        $data       = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $step = empty($step) ? 1 : $step;
        $store_info = RC_DB::table('store_preaudit')->where('store_id', intval($_SESSION['store_id']))->first();
        $type = $_REQUEST['type']; //company 升级企业

        if(!empty($store_info)){
            $step = ($store_info['check_status'] == 1)? 1 : 2;
            $step = ($store_info['check_status'] == 3)? 3 : $step;
            $request_step = intval($_REQUEST['step']);
            $step = empty($request_step) ? $step : $request_step;
            $this->assign('ur_here', __('修改申请', 'merchant'));
            if($step != 3){
                $data = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->first();
            }else{
                ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('审核状态', 'merchant')));
                $this->assign('ur_here', __('审核状态', 'merchant'));
                $error_log = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->value('remark');

                $string = str_replace("\r\n", ',', $error_log);
                $arr = explode(',', $string);
                $this->assign('logs', $arr);
                $this->assign('step', $step);
                return $this->display('merchant_status.dwt');
                exit;
            }
        }
        $data['identity_pic_front'] = !empty($data['identity_pic_front'])? RC_Upload::upload_url($data['identity_pic_front']) : '';
        $data['identity_pic_back'] = !empty($data['identity_pic_back'])? RC_Upload::upload_url($data['identity_pic_back']) : '';
        $data['personhand_identity_pic'] = !empty($data['personhand_identity_pic'])? RC_Upload::upload_url($data['personhand_identity_pic']) : '';
        $data['business_licence_pic'] = !empty($data['business_licence_pic'])?  RC_Upload::upload_url($data['business_licence_pic']) : '';
        
        $province = ecjia_region::getSubarea(ecjia::config('shop_country'));
        $city = ecjia_region::getSubarea($data['province']);
        $district = ecjia_region::getSubarea($data['city']);
        $street = ecjia_region::getSubarea($data['district']);
        
        $cat_info 		= RC_DB::table('store_category')->get();
        $request_step 	= intval($_REQUEST['step']);
        $step 			= empty($request_step)? $step : $request_step;
		$data['identity_type'] = !empty($data['identity_type'])? $data['identity_type']: '1';

        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('district', $district);
        $this->assign('street', $street);
        
        $this->assign('data', $data);
        $this->assign('step', $step);
        $this->assign('cat_info', $cat_info);
        $this->assign('type', $type);

        $this->assign('form_action', RC_Uri::url('merchant/mh_franchisee/update'));
        return $this->display('merchant_edit.dwt');
    }

    /**
     * 编辑入驻信息
     */
    public function update(){
        $this->admin_priv('franchisee_request', ecjia::MSGTYPE_JSON);

        $edit_fields = array(
            'merchants_name'            => __('店铺名称', 'merchant'),
            'company_name'              => __('公司名称', 'merchant'),
            'shop_keyword'              => __('店铺关键字', 'merchant'),
            'cat_id'                    => __('店铺分类', 'merchant'),
            'responsible_person'        => __('负责人', 'merchant'),
            'email'                     => __('电子邮箱', 'merchant'),
            'contact_mobile'            => __('联系方式', 'merchant'),
            'province'                  => __('省', 'merchant'),
            'city'                      => __('市', 'merchant'),
            'district'                  => __('区', 'merchant'),
        	'street'					=> __('街道', 'merchant'),
            'address'                   => __('详细地址', 'merchant'),
            'identity_type'             => __('证件类型', 'merchant'),
            'identity_number'           => __('证件号码', 'merchant'),
            'business_licence'          => __('营业执照注册号', 'merchant'),
            'identity_pic_front'        => __('证件正面', 'merchant'),
            'identity_pic_back'         => __('证件反面','merchant'),
            'personhand_identity_pic'   => __('手持证件照', 'merchant'),
            'business_licence_pic'      => __('营业执照电子版', 'merchant'),
            'longitude'                 => __('经度', 'merchant'),
            'latitude'                  => __('纬度', 'merchant'),
        );

        $store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $validate_type = $store_info['validate_type'];

        $merchants_name             = !empty($_POST['merchants_name'])? htmlspecialchars(remove_xss($_POST['merchants_name'])) : '';
        $company_name               = !empty($_POST['company_name'])? htmlspecialchars(remove_xss($_POST['company_name'])) : '';
        $shop_keyword               = !empty($_POST['shop_keyword'])? htmlspecialchars(remove_xss($_POST['shop_keyword'])) : '';
        $cat_id                     = !empty($_POST['cat_id'])? intval($_POST['cat_id']) : '';
        $responsible_person         = !empty($_POST['responsible_person'])? htmlspecialchars(remove_xss($_POST['responsible_person'])) : '';
        $email                      = !empty($_POST['email'])? htmlspecialchars(remove_xss($_POST['email'])) : '';
        $contact_mobile             = !empty($_POST['contact_mobile'])? htmlspecialchars(remove_xss($_POST['contact_mobile'])) : '';

        $province                   = !empty($_POST['province']) ? remove_xss($_POST['province']) : '';
        $city                       = !empty($_POST['city'])     ? remove_xss($_POST['city'])     : '';
        $district                   = !empty($_POST['district']) ? remove_xss($_POST['district']) : '';
        $street                   	= !empty($_POST['street']) ? remove_xss($_POST['street']) : '';
        
        $address                    = !empty($_POST['address'])? htmlspecialchars(remove_xss($_POST['address'])) : '';
        $identity_type              = !empty($_POST['identity_type'])? intval(remove_xss($_POST['identity_type'])) : '';
        $identity_number            = !empty($_POST['identity_number'])? htmlspecialchars(remove_xss($_POST['identity_number'])) : '';
        $business_licence           = !empty($_POST['business_licence'])? htmlspecialchars(remove_xss($_POST['business_licence'])) : '';
        $longitude                  = !empty($_POST['longitude'])? htmlspecialchars(remove_xss($_POST['longitude'])) : '';
        $latitude                   = !empty($_POST['latitude'])? htmlspecialchars(remove_xss($_POST['latitude'])) : '';
        $type                   = !empty($_POST['type'])? htmlspecialchars(remove_xss($_POST['type'])) : '';

        $franchisee_count = RC_DB::table('store_franchisee')->where('email', '=', $email)->where('store_id', '!=', $_SESSION['store_id'])->count();
        $preaudit_count   = RC_DB::table('store_preaudit')->where('email', '=', $email)->where('store_id', '!=', $_SESSION['store_id'])->count();
        if (!empty($franchisee_count) || $preaudit_count) {
            return $this->showmessage(__('该邮箱已经使用，请填写其他邮箱地址', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $franchisee_count = RC_DB::table('store_franchisee')->where('contact_mobile', '=', $contact_mobile)->where('store_id', '!=', $_SESSION['store_id'])->count();
        $preaudit_count   = RC_DB::table('store_preaudit')->where('contact_mobile', '=', $contact_mobile)->where('store_id', '!=', $_SESSION['store_id'])->count();
        if (!empty($franchisee_count) || $preaudit_count) {
            return $this->showmessage(__('该手机号已经使用，请填写其他联系方式', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($longitude) || empty($latitude)) {
            return $this->showmessage(__('请点击获取精准坐标获取店铺经纬度', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($merchants_name)) {
            return $this->showmessage(__('请填写店铺名称', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (mb_strlen($merchants_name) > 20) {
            return $this->showmessage(__('店铺名称不能超过20个字符', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $geohash = RC_Loader::load_app_class('geohash', 'store');
        $geohash_code = $geohash->encode($latitude , $longitude);
        $geohash_code = substr($geohash_code, 0, 10);

        $data = array(
            'merchants_name'            => $merchants_name,
            'company_name'              => $company_name,
            'shop_keyword'              => $shop_keyword,
            'cat_id'                    => $cat_id,
            'responsible_person'        => $responsible_person,
            'email'                     => $email,
            'contact_mobile'            => $contact_mobile,
            'province'                  => $province,
            'city'                      => $city,
            'address'                   => $address,
            'district'                  => $district,
        	'street'					=> $street,
            'identity_type'             => $identity_type,
            'identity_number'           => $identity_number,
            'business_licence'          => $business_licence,
            'apply_time'                => RC_Time::gmtime(),
            'validate_type'             => $validate_type,
            'longitude'                 => $longitude,
            'latitude'                  => $latitude,
            'geohash'                   => $geohash_code,
        );
        if ($type == 'company') {
            $data['validate_type'] = 2;
        }
        if ($store_info['identity_status'] != 2) {
              RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update(array('identity_status' => 1));
        }
        // 非空验证
        foreach( $data as $k => $val) {
            if(empty($val)){
                $k = ($k == 'cat_id')? 'merchant_cat' : $k;
                $k = ($k == 'longitude' || $k == 'latitude')? 'merchant_addres' : $k;
                if($validate_type == 1 && ($k == 'business_licence' || $k == 'company_name')){
                    continue;
                }
                return $this->showmessage(RC_Lang::get('merchant::merchant.'.$k).__('不能为空', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if (!empty($_FILES['identity_pic_front']) && empty($_FILES['error']) && !empty($_FILES['identity_pic_front']['name'])) {
            $identity_pic_front_check = merchant_file_upload_info('identity_pic', 'identity_pic_front');
            if (is_ecjia_error($identity_pic_front_check)) {
                return $identity_pic_front_check;
            } else {
                 $data['identity_pic_front'] = $identity_pic_front_check;
            }
        } else {
            $data['identity_pic_front'] = $store_info['identity_pic_front'];
        }

        if (!empty($_FILES['identity_pic_back']) && empty($_FILES['error']) && !empty($_FILES['identity_pic_back']['name'])) {
            $identity_pic_back_check = merchant_file_upload_info('identity_pic', 'identity_pic_back');
            if (is_ecjia_error($identity_pic_back_check)) {
                return $identity_pic_back_check;
            } else {
                $data['identity_pic_back'] = $identity_pic_back_check;
            }
        } else {
            $data['identity_pic_back'] = $store_info['identity_pic_back'];
        }

        if (!empty($_FILES['personhand_identity_pic']) && empty($_FILES['error']) && !empty($_FILES['personhand_identity_pic']['name'])) {
            $personhand_identity_pic_check = merchant_file_upload_info('identity_pic', 'personhand_identity_pic');
            if (is_ecjia_error($personhand_identity_pic_check)) {
                return $personhand_identity_pic_check;
            } else {
                $data['personhand_identity_pic'] = $personhand_identity_pic_check;
            }
        } else {
            $data['personhand_identity_pic'] = $store_info['personhand_identity_pic'];
        }

        if (!empty($_FILES['business_licence_pic']) && empty($_FILES['error']) && !empty($_FILES['business_licence_pic']['name'])) {
            $business_licence_pic_check =  merchant_file_upload_info('business_licence', 'business_licence_pic');
            if (is_ecjia_error($business_licence_pic_check)) {
                return $business_licence_pic_check;
            } else {
                $data['business_licence_pic'] = $business_licence_pic_check;
            }
        } else {
            $data['business_licence_pic'] = $store_info['business_licence_pic'];
        }

        $data['store_id'] = intval($_SESSION['store_id']);
        $data['check_status'] = 2;
        $count = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->count();
        if (empty($count)) {
            $preaudit = RC_DB::table('store_preaudit')->insert($data);
        } else {
            $preaudit = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->update($data);
        }

        if (!empty($preaudit)) {
            //审核日志
            //$store_info
            //$data
            foreach ($edit_fields as $field_key => $field_name) {
                if ($store_info[$field_key] != $data[$field_key]) {
                    if ($field_key == 'cat_id') {
                        $store_info[$field_key] = RC_DB::table('store_category')->where('cat_id', $store_info[$field_key])->value('cat_name');
                        $data[$field_key] = RC_DB::table('store_category')->where('cat_id', $data[$field_key])->value('cat_name');
                    } else if ($field_key == 'identity_type') {
                        $store_info[$field_key] = $store_info[$field_key] == 1 ? __('身份证', 'merchant') : ($store_info[$field_key] == 2 ? __('护照', 'merchant') : __('港澳身份证', 'merchant'));
                        $data[$field_key] = $data[$field_key] == 1 ? __('身份证', 'merchant') : ($data[$field_key] == 2 ? __('护照', 'merchant') : __('港澳身份证', 'merchant'));
                    } else if ( in_array($field_key, array('province', 'city', 'district', 'street'))) {
                        $store_info[$field_key] = ecjia_region::getRegionName($store_info[$field_key]);
                        $store_info[$field_key] = empty($store_info[$field_key]) ? "<em><空></em>" : $store_info[$field_key];
                        $data[$field_key] = ecjia_region::getRegionName($data[$field_key]);
                    } else if ( in_array($field_key, array('identity_pic_front', 'identity_pic_back', 'personhand_identity_pic', 'business_licence_pic'))) {
                        $store_info[$field_key] = $store_info[$field_key] ? RC_Upload::upload_url($store_info[$field_key]) : '<em><空></em>';
                        $data[$field_key] = $data[$field_key] ? RC_Upload::upload_url($data[$field_key]) : '<em><空></em>';
                    }
                    $log_original[$field_key] = array('name'=>$field_name, 'value'=> (is_null($store_info[$field_key]) || $store_info[$field_key] == '') ? '<em><空></em>' : $store_info[$field_key]);
                    $log_new[$field_key] = array('name'=>$field_name, 'value'=> (is_null($data[$field_key]) || $data[$field_key] == '') ? '<em><空></em>' : $data[$field_key]);
                }
            }
            $log = array(
                'store_id' => $_SESSION['store_id'],
                'type' => 2,
                'name' => $_SESSION['staff_name'],
                'original_data' => serialize($log_original),
                'new_data' => serialize($log_new),
                'info' => __('申请修改入驻信息', 'merchant'),
            );
            RC_Api::api('store', 'add_check_log', $log);

            // 记录日志
            ecjia_merchant::admin_log(__('申请修改店铺入驻信息', 'merchant'), 'edit', 'merchant');
            return $this->showmessage(__('成功提交申请', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/mh_franchisee/request_edit')));
        } else {
            return $this->showmessage(__('提交失败', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 撤销修改
     */
    public function delete() {
        $this->admin_priv('franchisee_request', ecjia::MSGTYPE_JSON);

        $log = array(
            'store_id' => $_SESSION['store_id'],
            'type' => 2,
            'name' => $_SESSION['staff_name'],
            'info' => __('撤销修改入驻信息', 'merchant'),
        );
        RC_Api::api('store', 'add_check_log', $log);

        RC_DB::table('store_preaudit')->where('store_id', intval($_SESSION['store_id']))->delete();
        // 记录日志
        ecjia_merchant::admin_log(__('撤销申请修改店铺入驻信息', 'merchant'), 'edit', 'merchant');
        return $this->showmessage(__('成功撤销修改', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('merchant/mh_franchisee/init')));
    }
    
    /**
     * 根据地区获取经纬度
     */
    public function getgeohash(){
        $shop_province      = !empty($_REQUEST['province'])    ? trim($_REQUEST['province'])             : '';
        $shop_city          = !empty($_REQUEST['city'])        ? trim($_REQUEST['city'])                 : '';
        $shop_district      = !empty($_REQUEST['district'])    ? trim($_REQUEST['district'])             : '';
        $shop_street      	= !empty($_REQUEST['street'])      ? trim($_REQUEST['street'])               : '';
        $shop_address       = !empty($_REQUEST['address'])     ? htmlspecialchars($_REQUEST['address'])  : 0;
        if (empty($shop_province)) {
            return $this->showmessage(__('请选择省份', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'province'));
        }
        if (empty($shop_city)) {
            return $this->showmessage(__('请选择城市', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'city'));
        }
        if (empty($shop_district)) {
            return $this->showmessage(__('请选择地区', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'district'));
        }
        if (empty($shop_street)) {
        	return $this->showmessage(__('请选择街道', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'street'));
        }
        if(empty($shop_address)) {
            return $this->showmessage(__('请填写详细地址', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'address'));
        }
        $key = ecjia::config('map_qq_key');
        if (empty($key)) {
        	return $this->showmessage(__('腾讯地图key不能为空', 'merchant'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $province_name  = ecjia_region::getRegionName($shop_province);
        $city_name      = ecjia_region::getRegionName($shop_city);
        $district_name  = ecjia_region::getRegionName($shop_district);
        $street_name    = ecjia_region::getRegionName($shop_street);
        
        $address = '';
        if (!empty($province_name)) {
            $address .= $province_name;
        }
        if (!empty($city_name)) {
            $address .= $city_name;
        }
        if (!empty($district_name)) {
            $address .= $district_name;
        }
        if (!empty($street_name)) {
            $address .= $street_name;
        }
        $address .= $shop_address;
        $address = urlencode($address);
        
        $shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$address."&key=".$key);
        $shop_point = json_decode($shop_point['body'], true);

		if ($shop_point['status'] != 0) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $shop_point);
		}
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $shop_point);
    }
}

//end