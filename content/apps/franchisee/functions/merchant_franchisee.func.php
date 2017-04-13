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
 * @param array $data 插入更新数据
 * @param array $store_info 原有信息
 * @param number $insert_id
 */
function add_check_log($data, $store_info = array(), $insert_id = 0) {
    //审核日志
    //add
    if ($insert_id && empty($data['store_id'])) {
        $log = array(
            'store_id'          => $insert_id,
            'type'              => 1,
            'name'              => $data['responsible_person'],
            'original_data'     => '',
            'new_data'          => '',
            'info'              => '申请入驻信息第一次提交',
        );
    } else {
        //edit
        //$store_info
        //$data
         
        //审核日志字段
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
         
        foreach ($edit_fields as $field_key => $field_name) {
            if (trim($store_info[$field_key]) != trim($data[$field_key])) {
                if ($field_key == 'cat_id') {
                    $store_info[$field_key] = RC_DB::table('store_category')->where('cat_id', $store_info[$field_key])->pluck('cat_name');
                    $data[$field_key]       = RC_DB::table('store_category')->where('cat_id', $data[$field_key])->pluck('cat_name');
                } else if ($field_key == 'identity_type') {
                    $store_info[$field_key] = $store_info[$field_key] == 1  ? '身份证' : ($store_info[$field_key] == 2 ? '护照' : '港澳身份证');
                    $data[$field_key]       = $data[$field_key] == 1        ? '身份证' : ($data[$field_key] == 2       ? '护照' : '港澳身份证');
                } else if ( in_array($field_key, array('province', 'city', 'district'))) {
                    $store_info[$field_key] = ecjia_region::instance()->region_name($store_info[$field_key]);
                    $data[$field_key]       = ecjia_region::instance()->region_name(intval($data[$field_key]));
                } else if ( in_array($field_key, array('identity_pic_front', 'identity_pic_back', 'personhand_identity_pic', 'business_licence_pic'))) {
                    $store_info[$field_key] = $store_info[$field_key] ? '<图片已删除>'                               : '<em><空></em>';
                    $data[$field_key]       = $data[$field_key]       ? RC_Upload::upload_url($data[$field_key])  	: '<em><空></em>';
                }
                $log_original[$field_key] = array('name'=>$field_name, 'value'=> (is_null($store_info[$field_key]) || $store_info[$field_key] == '') ? '<em><空></em>' : $store_info[$field_key]);
                $log_new[$field_key]      = array('name'=>$field_name, 'value'=> (is_null($data[$field_key])       || $data[$field_key] == '')       ? '<em><空></em>' : $data[$field_key]);
            }
        }
         
        $log = array(
            'store_id' 		=> $store_info['id'],
            'type' 			=> 1,
            'name' 			=> $data['responsible_person'],
            'original_data' => serialize($log_original),
            'new_data' 		=> serialize($log_new),
            'info' 			=> '申请入驻信息修改',
        );
    }
     
    RC_Api::api('store', 'add_check_log', $log);
}

//end