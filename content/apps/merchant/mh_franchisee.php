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

    private $store_preaudit;
    private $store_franchisee;
    private $db_store_category;

    public function __construct() {
        parent::__construct();

        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');

        // 自定义JS
        RC_Script::enqueue_script('merchant_info', RC_App::apps_url('statics/js/merchant_info.js', __FILE__) , array() , false, true);

        // 页面css样式
        RC_Style::enqueue_style('merchant', RC_App::apps_url('statics/css/merchant.css', __FILE__), array());

        // 步骤导航条
        RC_Style::enqueue_style('bar', RC_App::apps_url('statics/css/bar.css', __FILE__), array());

        // input file 长传
        RC_Style::enqueue_style('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', __FILE__), array());
        RC_Script::enqueue_script('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__) , array() , false, true);

        // select 选择框
        RC_Style::enqueue_style('chosen_style', RC_App::apps_url('statics/assets/chosen/chosen.css', __FILE__), array());
        RC_Script::enqueue_script('chosen', RC_App::apps_url('statics/assets/chosen/chosen.jquery.min.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('qq_map', 'https://map.qq.com/api/js?v=2.exp');
        
        RC_Loader::load_app_func('merchant');
        merchant_assign_adminlog_content();

        $this->store_preaudit = RC_Model::model('merchant/store_preaudit_model');
        $this->store_franchisee = RC_Model::model('merchant/store_franchisee_model');
        $this->db_store_category = RC_Model::model('merchant/store_category_model');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('我的店铺', RC_Uri::url('merchant/mh_franchisee/init')));

        ecjia_merchant_screen::get_current_screen()->set_parentage('store', 'store/mh_franchisee.php');
    }


    /**
     * 店铺入驻信息
     */
    public function init() {
        $this->admin_priv('franchisee_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('入驻信息', RC_Uri::url('merchant/mh_franchisee/init')));
        $this->assign('ur_here', '商家入驻信息');

        $data       = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $count      = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->count();
        $data['identity_pic_front']         = !empty($data['identity_pic_front'])? RC_Upload::upload_url($data['identity_pic_front']) : '';
        $data['identity_pic_back']          = !empty($data['identity_pic_back'])? RC_Upload::upload_url($data['identity_pic_back']) : '';
        $data['personhand_identity_pic']    = !empty($data['personhand_identity_pic'])? RC_Upload::upload_url($data['personhand_identity_pic']) : '';
        $data['business_licence_pic']       = !empty($data['business_licence_pic'])?  RC_Upload::upload_url($data['business_licence_pic']) : '';
        $data['province']                   = !empty($data['province'])? get_region_name($data['province']) : '';
        $data['city']                       = !empty($data['city'])? get_region_name($data['city']): '';
        $data['district']                   = !empty($data['district'])? get_region_name($data['district']): '';
        $data['identity_type']              = !empty($data['identity_type'])? $data['identity_type']: '1';
        $data['cat_name'] = $this->db_store_category->where(array('cat_id' => $data['cat_id']))->get_field('cat_name');
        $this->assign('data',$data);

        $this->display('merchant_info.dwt');
    }

    /**
     * 收款之类的信息
     */
    public function receipt() {
        $this->admin_priv('franchisee_bank');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('收款账号', RC_Uri::url('merchant/mh_franchisee/init')));
        $this->assign('ur_here', '收款账号');
        $data = RC_DB::TABLE('store_franchisee')->where('store_id', $_SESSION['store_id'])->select('bank_name', 'bank_branch_name', 'bank_account_name', 'bank_account_number','bank_address')->first();
        $this->assign('data',$data);
        $this->display('merchant_receipt.dwt');
    }

    /**
     * 编辑收款之类的信息
     */
    public function receipt_edit() {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑收款账号', RC_Uri::url('merchant/mh_franchisee/init')));

        $this->assign('ur_here', '编辑收款账号');
        $this->assign('action_link', array('href' => RC_Uri::url('merchant/mh_franchisee/receipt'), 'text' => '收款账号'));
        $data = RC_DB::TABLE('store_franchisee')->where('store_id', $_SESSION['store_id'])->select('bank_name', 'bank_branch_name', 'bank_account_name', 'bank_account_number','bank_address')->first();
        $this->assign('data',$data);
        $form_action = RC_Uri::url('merchant/mh_franchisee/receipt_update');
        $this->assign('form_action',$form_action);

        $this->display('merchant_receipt_edit.dwt');
    }

    /**
     * 更新收款之类的信息
     */
    public function receipt_update() {
        $this->admin_priv('franchisee_bank', ecjia::MSGTYPE_JSON);

        $bank_name              = !empty($_POST['bank_name'])           ? htmlspecialchars($_POST['bank_name'])             : '';
        $bank_account_number    = !empty($_POST['bank_account_number']) ? htmlspecialchars($_POST['bank_account_number'])   : '';
        $bank_account_name      = !empty($_POST['bank_account_name'])   ? htmlspecialchars($_POST['bank_account_name'])     : '';
        $bank_branch_name       = !empty($_POST['bank_branch_name'])    ? htmlspecialchars($_POST['bank_branch_name'])      : '';
        $bank_address           = !empty($_POST['bank_address'])        ? htmlspecialchars($_POST['bank_address'])          : '';
        if (empty($bank_name) || empty($bank_account_number) || empty($bank_account_name) || empty($bank_branch_name) || empty($bank_address)) {
            return $this->showmessage('请不要提交空值', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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
        ecjia_merchant::admin_log('修改收款账号', 'edit', 'merchant');
        return $this->showmessage('成功修改收款账号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/mh_franchisee/receipt')));
    }

    /**
     * 店铺入驻信息
     */
    public function request_edit() {
        $this->admin_priv('franchisee_request');
        
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('提交申请'));
        $this->assign('ur_here', '提交申请');
        $this->assign('action_link', array('href' => RC_Uri::url('merchant/mh_franchisee/init'), 'text' => '入驻信息'));
        $data       = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $step = empty($step)? 1 : $step;
        $store_info = RC_DB::table('store_preaudit')->where('store_id', intval($_SESSION['store_id']))->first();

        if(!empty($store_info)){
            $step = ($store_info['check_status'] == 1)? 1 : 2;
            $step = ($store_info['check_status'] == 3)? 3 : $step;
            $request_step = intval($_REQUEST['step']);
            $step = empty($request_step)? $step : $request_step;
            $this->assign('ur_here', '修改申请');
            if($step != 3){
                $data       = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->first();
            }else{
                ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('审核状态'));
                $this->assign('ur_here', '审核状态');
                $error_log = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->pluck('remark');

                $string = str_replace("\r\n", ',', $error_log);
                $arr = explode(',', $string);
                $this->assign('logs', $arr);
                $this->assign('step', $step);
                $this->display('merchant_status.dwt');
                exit;
            }

        }
        $data['identity_pic_front'] = !empty($data['identity_pic_front'])? RC_Upload::upload_url($data['identity_pic_front']) : '';
        $data['identity_pic_back'] = !empty($data['identity_pic_back'])? RC_Upload::upload_url($data['identity_pic_back']) : '';
        $data['personhand_identity_pic'] = !empty($data['personhand_identity_pic'])? RC_Upload::upload_url($data['personhand_identity_pic']) : '';
        $data['business_licence_pic'] = !empty($data['business_licence_pic'])?  RC_Upload::upload_url($data['business_licence_pic']) : '';
        $province		= ecjia_region::instance()->region_datas(1, 1);
        $city			= ecjia_region::instance()->region_datas(2, $data['province']);
        $district   	= ecjia_region::instance()->region_datas(3, $data['city']);
        $cat_info 		= RC_DB::table('store_category')->get();
        $request_step 	= intval($_REQUEST['step']);
        $step 			= empty($request_step)? $step : $request_step;
		$data['identity_type'] = !empty($data['identity_type'])? $data['identity_type']: '1';

        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('district', $district);
        $this->assign('data', $data);
        $this->assign('step', $step);
        $this->assign('cat_info', $cat_info);

        $this->assign('form_action', RC_Uri::url('merchant/mh_franchisee/update'));
        $this->display('merchant_edit.dwt');
    }

    /**
     * 编辑入驻信息
     */
    public function update(){
        $this->admin_priv('franchisee_request', ecjia::MSGTYPE_JSON);

        $edit_fields = array(
            'merchants_name'            => '店铺名称',
            'company_name'              => '公司名称',
            'shop_keyword'              => '店铺关键字',
            'cat_id'                    => '店铺分类',
            'responsible_person'        => '负责人',
            'email'                     => '电子邮箱',
            'contact_mobile'            => '联系方式',
            'province'                  => '省',
            'city'                      => '市',
            'district'                  => '区',
            'address'                   => '详细地址',
            'identity_type'             => '证件类型',
            'identity_number'           => '证件号码',
            'business_licence'          => '营业执照注册号',
            'identity_pic_front'        => '证件正面',
            'identity_pic_back'         => '证件反面',
            'personhand_identity_pic'   => '手持证件照',
            'business_licence_pic'      => '营业执照电子版',
            'longitude'                 => '经度',
            'latitude'                  => '纬度',
        );

        $store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $validate_type = $store_info['validate_type'];

        $merchants_name             = !empty($_POST['merchants_name'])? htmlspecialchars($_POST['merchants_name']) : '';
        $company_name               = !empty($_POST['company_name'])? htmlspecialchars($_POST['company_name']) : '';
        $shop_keyword               = !empty($_POST['shop_keyword'])? htmlspecialchars($_POST['shop_keyword']) : '';
        $cat_id                     = !empty($_POST['cat_id'])? intval($_POST['cat_id']) : '';
        $responsible_person         = !empty($_POST['responsible_person'])? htmlspecialchars($_POST['responsible_person']) : '';
        $email                      = !empty($_POST['email'])? htmlspecialchars($_POST['email']) : '';
        $contact_mobile             = !empty($_POST['contact_mobile'])? htmlspecialchars($_POST['contact_mobile']) : '';
        $province                   = !empty($_POST['province'])? intval($_POST['province']) : '';
        $city                       = !empty($_POST['city'])? intval($_POST['city']) : '';
        $district                   = !empty($_POST['district'])? intval($_POST['district']) : '';
        $address                    = !empty($_POST['address'])? htmlspecialchars($_POST['address']) : '';
        $identity_type              = !empty($_POST['identity_type'])? intval($_POST['identity_type']) : '';
        $identity_number            = !empty($_POST['identity_number'])? htmlspecialchars($_POST['identity_number']) : '';
        $business_licence           = !empty($_POST['business_licence'])? htmlspecialchars($_POST['business_licence']) : '';
        $longitude                  = !empty($_POST['longitude'])? htmlspecialchars($_POST['longitude']) : '';
        $latitude                   = !empty($_POST['latitude'])? htmlspecialchars($_POST['latitude']) : '';

        $franchisee_count = RC_DB::table('store_franchisee')->where('email', '=', $email)->where('store_id', '!=', $_SESSION['store_id'])->count();
        $preaudit_count   = RC_DB::table('store_preaudit')->where('email', '=', $email)->where('store_id', '!=', $_SESSION['store_id'])->count();
        if (!empty($franchisee_count) || $preaudit_count) {
            return $this->showmessage('该邮箱已经使用，请填写其他邮箱地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $franchisee_count = RC_DB::table('store_franchisee')->where('contact_mobile', '=', $contact_mobile)->where('store_id', '!=', $_SESSION['store_id'])->count();
        $preaudit_count   = RC_DB::table('store_preaudit')->where('contact_mobile', '=', $contact_mobile)->where('store_id', '!=', $_SESSION['store_id'])->count();
        if (!empty($franchisee_count) || $preaudit_count) {
            return $this->showmessage('该手机号已经使用，请填写其他联系方式', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($longitude) || empty($latitude)) {
            return $this->showmessage('请点击获取精准坐标获取店铺经纬度', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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
            'identity_type'             => $identity_type,
            'identity_number'           => $identity_number,
            'business_licence'          => $business_licence,
            'apply_time'                => RC_Time::gmtime(),
            'validate_type'             => $validate_type,
            'longitude'                 => $longitude,
            'latitude'                  => $latitude,
            'geohash'                   => $geohash_code,
        );
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
                return $this->showmessage(RC_Lang::get('merchant::merchant.'.$k).'不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if (!empty($_FILES['identity_pic_front']) && empty($_FILES['error']) && !empty($_FILES['identity_pic_front']['name'])) {
            $data['identity_pic_front'] = merchant_file_upload_info('identity_pic', 'identity_pic_front');
        } else {
            $data['identity_pic_front'] = $store_info['identity_pic_front'];
        }

        if (!empty($_FILES['identity_pic_back']) && empty($_FILES['error']) && !empty($_FILES['identity_pic_back']['name'])) {
            $data['identity_pic_back'] = merchant_file_upload_info('identity_pic', 'identity_pic_back');
        } else {
            $data['identity_pic_back'] = $store_info['identity_pic_back'];
        }

        if (!empty($_FILES['personhand_identity_pic']) && empty($_FILES['error']) && !empty($_FILES['personhand_identity_pic']['name'])) {
            $data['personhand_identity_pic'] = merchant_file_upload_info('identity_pic', 'personhand_identity_pic');
        } else {
            $data['personhand_identity_pic'] = $store_info['personhand_identity_pic'];
        }

        if (!empty($_FILES['business_licence_pic']) && empty($_FILES['error']) && !empty($_FILES['business_licence_pic']['name'])) {
            $data['business_licence_pic'] = merchant_file_upload_info('business_licence', 'business_licence_pic');
        } else {
            $data['business_licence_pic'] = $store_info['business_licence_pic'];
        }

        $data['store_id'] = intval($_SESSION['store_id']);
        $data['check_status'] = 2;
        $count = RC_DB::table('store_preaudit')->where('store_id', $_SESSION['store_id'])->count();
        if (empty($count)) {
            $preaudit = $this->store_preaudit->insert($data);
        } else {
            $preaudit = $this->store_preaudit->where(array('store_id' => $_SESSION['store_id']))->update($data);
        }

        if (!empty($preaudit)) {
            //审核日志
            //$store_info
            //$data
            foreach ($edit_fields as $field_key => $field_name) {
                if ($store_info[$field_key] != $data[$field_key]) {
                    if ($field_key == 'cat_id') {
                        $store_info[$field_key] = RC_DB::table('store_category')->where('cat_id', $store_info[$field_key])->pluck('cat_name');
                        $data[$field_key] = RC_DB::table('store_category')->where('cat_id', $data[$field_key])->pluck('cat_name');
                    } else if ($field_key == 'identity_type') {
                        $store_info[$field_key] = $store_info[$field_key] == 1 ? '身份证' : ($store_info[$field_key] == 2 ? '护照' : '港澳身份证');
                        $data[$field_key] = $data[$field_key] == 1 ? '身份证' : ($data[$field_key] == 2 ? '护照' : '港澳身份证');
                    } else if ( in_array($field_key, array('province', 'city', 'district'))) {
                        $store_info[$field_key] = ecjia_region::instance()->region_name($store_info[$field_key]);
                        $store_info[$field_key] = empty($store_info[$field_key]) ? "<em><空></em>" : $store_info[$field_key];
                        $data[$field_key] = ecjia_region::instance()->region_name($data[$field_key]);
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
                'info' => '申请修改入驻信息',
            );
            RC_Api::api('store', 'add_check_log', $log);

            // 记录日志
            ecjia_merchant::admin_log('申请修改店铺入驻信息', 'edit', 'merchant');
            return $this->showmessage('成功提交申请', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/mh_franchisee/request_edit')));
        } else {
            return $this->showmessage('提交失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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
            'info' => '撤销修改入驻信息',
        );
        RC_Api::api('store', 'add_check_log', $log);

        RC_DB::table('store_preaudit')->where('store_id', intval($_SESSION['store_id']))->delete();
        // 记录日志
        ecjia_merchant::admin_log('撤销申请修改店铺入驻信息', 'edit', 'merchant');
        return $this->showmessage('成功撤销修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('merchant/mh_franchisee/init')));
    }

    /**
     * 获取指定地区的子级地区
     */
    public function get_region(){
        $type      = !empty($_GET['type'])   ? intval($_GET['type'])   : 0;
        $parent        = !empty($_GET['parent']) ? intval($_GET['parent']) : 0;
        $arr['regions'] = ecjia_region::instance()->region_datas($type, $parent);
        $arr['type']    = $type;
        $arr['target']  = !empty($_GET['target']) ? stripslashes(trim($_GET['target'])) : '';
        $arr['target']  = htmlspecialchars($arr['target']);
        echo json_encode($arr);
    }

    /**
     * 根据地区获取经纬度
     */
    public function getgeohash(){
        $shop_province      = !empty($_REQUEST['province'])    ? intval($_REQUEST['province'])           : 0;
        $shop_city          = !empty($_REQUEST['city'])        ? intval($_REQUEST['city'])               : 0;
        $shop_district      = !empty($_REQUEST['district'])    ? intval($_REQUEST['district'])           : 0;
        $shop_address       = !empty($_REQUEST['address'])     ? htmlspecialchars($_REQUEST['address'])  : 0;
        if(empty($shop_province)){
            return $this->showmessage('请选择省份', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'province'));
        }
        if(empty($shop_city)){
            return $this->showmessage('请选择城市', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'city'));
        }
        if(empty($shop_district)){
            return $this->showmessage('请选择地区', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'district'));
        }
        if(empty($shop_address)){
            return $this->showmessage('请填写详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'address'));
        }
        
        $key = ecjia::config('map_qq_key');
        if (empty($key)) {
        	return $this->showmessage('腾讯地图key不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $city_name    	= RC_DB::table('region')->where('region_id', $shop_city)->pluck('region_name');
        $city_district 	= RC_DB::table('region')->where('region_id', $shop_district)->pluck('region_name');
        $address      	= $city_name.'市'.$city_district.$shop_address;
        $address		= urlencode($address);
        $shop_point   	= RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$address."&key=".$key);
        $shop_point  	= json_decode($shop_point['body'], true);

		if ($shop_point['status'] != 0) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $shop_point);
		}
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $shop_point);
    }
}

//end