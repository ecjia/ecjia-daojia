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
 * ECJIA Member prepaid cash management language items
 */
return array(
    'edit'           => 'edit',//追加
    'user_surplus'   => 'Advanced payment',
    'surplus_id'     => 'ID',
    'user_id'        => 'Username',
    'surplus_amount' => 'Amount',
    'add_date'       => 'Time',
    'pay_mothed'     => 'Payment method',
    'process_type'   => 'Type',
    'confirm_date'   => 'Confirm date',
    'surplus_notic'  => 'Remarks',
    'surplus_desc'   => 'Description',
    'surplus_type'   => 'Operation type',
    'no_user'        => 'Anonymous buying',

    'surplus_type' => array(
        0 => 'Saving',
        1 => 'Drawing',
    ),

    'admin_user'    => 'Administrator',
    'status'        => 'Status',
    'confirm'       => 'Confirmed',
    'unconfirm'     => 'Unconfirmed',
    'cancel'        => 'Cancel',
    'please_select' => 'Please select...',
    'surplus_info'  => 'Balance information',
    'check'         => 'Check',

    'money_type'           => 'Payment mothod',
    'surplus_add'          => 'Add Apply',
    'surplus_edit'         => 'Edit Apply',
    'attradd_succed'       => 'Successfully!',
    'username_not_exist'   => 'The username is invalid!',
    'cancel_surplus'       => 'Are you sure cancel this record?',
    'surplus_amount_error' => 'Wrong, the drawing money is more than your balance!',
    'edit_surplus_notic'   => 'The status is already complete now, if you want to modify, please config it as confirm.',
    'back_list'            => 'Return to saving and drawing',
    'continue_add'         => 'Continue to add application',
    'user_name_keyword'    => 'Please enter user name keyword',

    /* 提示信息  */
    'delete_success'       => 'Delete success',
    'edit_success'         => 'Edit success',
    'add_success'          => 'Add success',

    /* JS language item */
    'js_languages'         => array(
        'user_id_empty'        => 'Please enter a username',
        'deposit_amount_empty' => 'Please enter saving amount!',
        'pay_code_empty'       => 'Please select a payment mothod!',
        'deposit_amount_error' => 'Please enter a valid format of amount!',
        'deposit_type_empty'   => 'Please select a type!',
        'deposit_notic_empty'  => 'Please enter remarks!',
        'deposit_desc_empty'   => 'Please enter description of users!',
    ),

    'recharge_withdrawal_apply'        => 'Recharge And Withdrawals Apply',
    'log_username'                     => 'Member name',
    'batch_deletes_ok'                 => 'Batch deleted successfully',
    'update_recharge_withdrawal_apply' => 'Updated recharge withdrawal application',
    'bulk_operations'                  => 'Batch Operations',
    'application_confirm'              => 'Completed applications can not be deleted, you sure you want to delete the selected list it?',
    'select_operated_confirm'          => 'Please select the item to be operated.',
    'batch_deletes'                    => 'Delete',
    'to'                               => 'To',
    'filter'                           => 'Filter',
    'start_date'                       => 'start date',
    'end_date'                         => 'end date',
    'delete'                           => 'delete',
    'delete_surplus_confirm'           => 'Are you sure you want to delete recharge withdrawal records?',
    'user_information'                 => 'member information',
    'anonymous_member'                 => 'Anonymous Member',
    'yuan'                             => 'yuan',
    'deposit'                          => 'deposit',
    'withdraw'                         => 'withdraw',
    'edit_remark'                      => 'Notes to editor',

    'label_user_id'        => 'Username:',
    'label_surplus_amount' => 'Amount:',
    'label_pay_mothed'     => 'Payment method:',
    'label_process_type'   => 'Type:',
    'label_surplus_notic'  => 'Remarks:',
    'label_surplus_desc'   => 'Description:',
    'label_status'         => 'Status:',
    'submit_update'        => 'Update',

    'keywords_required' => 'Please enter key words!',
    'username_required' => 'Please enter a member name!',
    'amount_required'   => 'Please enter amount!',
    'check_time'        => 'Start time can not be greater than the end time!',

    'merchants_notice'    => 'Settled businesses do not have the right to operate, please visit the business background operation!',
    'user_name_is'        => 'Member name is %s,',
    'money_is'            => 'Amount is %s',
    'delete_record_count' => 'The deletion of the %s records',
    'select_operate_item' => 'The deletion of the %s records',
    'withdraw_apply'      => 'Withdraw apply',
    'pay_apply'           => 'Pay apply',
);

//end