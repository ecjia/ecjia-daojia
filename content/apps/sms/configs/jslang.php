<?php

return [
    'sms'          => [
        'sFirst'                 => __('首页', 'sms'),
        'sLast'                  => __('尾页', 'sms'),
        'sPrevious'              => __('上一页', 'sms'),
        'sNext'                  => __('下一页', 'sms'),
        'sInfo'                  => __('共_TOTAL_条记录 第_START_条到第_END_条', 'sms'),
        'sZeroRecords'           => __('没有找到任何记录', 'sms'),
        'sEmptyTable'            => __('没有找到任何记录', 'sms'),
        'sInfoEmpty'             => __('共0条记录', 'sms'),
        'sInfoFiltered'          => __('（从_MAX_条数据中检索）', 'sms'),
        'template_code_required' => __('短信模板名称不能为空！', 'sms'),
        'start_lt_end_time'      => __('开始时间不得大于结束时间！', 'sms'),
        'send_num_required'      => __('请填写接收手机号码！', 'sms'),
        'msg_required'           => __('请填写消息内容！', 'sms'),
    ],
    'sms_config'   => [
        'sms_user_name_required' => __('请填写短信平台账号！', 'sms'),
        'sms_password_required'  => __('请输入短信平台密码！', 'sms'),
        'sms_password_minlength' => __('短信平台密码长度不能小于6！', 'sms'),
    ],
    'sms_events'   => [
        'ok'     => __('确定', 'sms'),
        'cancel' => __('取消', 'sms'),
    ],
    'sms_template' => [
        'sFirst'               => __('首页', 'sms'),
        'sLast'                => __('尾页', 'sms'),
        'sPrevious'            => __('上一页', 'sms'),
        'sNext'                => __('下一页', 'sms'),
        'sInfo'                => __('共_TOTAL_条记录 第_START_条到第_END_条', 'sms'),
        'sZeroRecords'         => __('没有找到任何记录', 'sms'),
        'sEmptyTable'          => __('没有找到任何记录', 'sms'),
        'sInfoEmpty'           => __('共0条记录', 'sms'),
        'sInfoFiltered'        => __('（从_MAX_条数据中检索）', 'sms'),
        'enter_mobile'         => __('请输入手机号', 'sms'),
        'enter_sign'           => __('请输入签名', 'sms'),
        'subject_required'     => __('短信主题不能为空！', 'sms'),
        'content_required'     => __('模板内容不能为空！', 'sms'),
        'template_id_required' => __('请输入短信模板ID', 'sms'),
    ],
    'sms_channel'  => [
        'ok'                     => __('确定', 'sms'),
        'cancel'                 => __('取消', 'sms'),
        'channel_name_required'  => __('请输入短信渠道名称', 'sms'),
        'channel_desc_required'  => __('请输入描述', 'sms'),
        'channel_desc_minlength' => __('描述长度不能小于6', 'sms'),
    ]
];