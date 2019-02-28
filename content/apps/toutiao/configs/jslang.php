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

/**
 * js语言包设置
 */

defined('IN_ECJIA') or exit('No permission resources.');

return array(
    //toutiao
    'toutiao_page' =>array(
        'sFirst'                => __('首页', 'toutiao'),
        'sLast'                 => __('尾页', 'toutiao'),
        'sPrevious'             => __('上一页', 'toutiao'),
        'sNext'                 => __('下一页', 'toutiao'),
        'sInfo'                 => __('共_TOTAL_条记录 第_START_条到第_END_条', 'toutiao'),
        'sZeroRecords'          => __('没有找到任何记录', 'toutiao'),
        'sEmptyTable'           => __('没有找到任何记录', 'toutiao'),
        'sInfoEmpty'            => __('共0条记录', 'toutiao'),
        'sInfoFiltered'         => __('（从_MAX_条数据中检索）', 'toutiao'),
        'template_code_require' => __('消息模板名称不能为空', 'toutiao'),
        'subject_require'       => __('消息主题不能为空', 'toutiao'),
        'content_require'       => __('消息内容不能为空', 'toutiao'),

        'ok'                  => __('确定', 'toutiao'),
        'cancel'              => __('取消', 'toutiao'),
        'status_edit_success' => __('状态修改成功', 'toutiao'),
        'kf_account_required' => __('请输入客服账号', 'toutiao'),
        'kf_nick_required'    => __('请输入客服昵称', 'toutiao'),
        'password_required'   => __('请输入客服密码', 'toutiao'),
        'kf_wx_required'      => __('请输入需要绑定的微信账号', 'toutiao'),

        'rule_name_required'     => __('请填写规则名称', 'toutiao'),
        'rule_keywords_required' => __('请至少填写1个关键词', 'toutiao'),
        'pls_select_material'    => __('请先选择素材', 'toutiao'),
        'no_title'               => __('无标题', 'toutiao'),
        'no_material_select'     => __('没有素材可以选择', 'toutiao'),

        'male'                 => __('男', 'toutiao'),
        'female'               => __('女', 'toutiao'),
        'not_bind_yet'         => __('暂未绑定', 'toutiao'),
        'label_nick'           => __('昵称：', 'toutiao'),
        'label_remark'         => __('备注名：', 'toutiao'),
        'label_sex'            => __('性别：', 'toutiao'),
        'label_province'       => __('省-市：', 'toutiao'),
        'label_user_tag'       => __('用户标签：', 'toutiao'),
        'label_subscribe_time' => __('关注时间：', 'toutiao'),
        'label_bind_user'      => __('绑定用户：', 'toutiao'),

        'getting'            => __('正在获取中...', 'toutiao'),
        'get_user_tag'       => __('获取用户标签', 'toutiao'),
        'get_user_info'      => __('获取用户信息', 'toutiao'),
        'tag_name_required'  => __('请输入标签名称', 'toutiao'),
        'tag_name_maxlength' => __('不得超过6个汉字或6个字符', 'toutiao'),
        'pls_select_user'    => __('请先选择用户', 'toutiao'),

        'qrcode_username_required'     => __('请填写推荐人', 'toutiao'),
        'qrcode_scene_id_required'     => __('请填写推荐人ID', 'toutiao'),
        'qrcode_funcions_required'     => __('请填写功能', 'toutiao'),
        'application_adsense_required' => __('请填写应用场景', 'toutiao'),
        'qrcode_funcions_empty'        => __('请选择或填写关键词', 'toutiao'),

        'select_material'    => __('请先选择素材！', 'toutiao'),
        'unfind_any_record'  => __('没有找到任何记录', 'toutiao'),
        'Monday'             => __('星期一', 'toutiao'),
        'Tuesday'            => __('星期二', 'toutiao'),
        'Wednesday'          => __('星期三', 'toutiao'),
        'Thursday'           => __('星期四', 'toutiao'),
        'Friday'             => __('星期五', 'toutiao'),
        'Saturday'           => __('星期六', 'toutiao'),
        'Sunday'             => __('星期日', 'toutiao'),
        'num'                => __('次', 'toutiao'),
        'num_time'           => __('次数', 'toutiao'),
        'get_message_record' => __('获取客服聊天记录', 'toutiao'),

        'menu_name_required' => __('请填写菜单名称', 'toutiao'),
        'menu_url_required'  => __('请输入外链URL', 'toutiao'),
        'menu_url_url'       => __('图片链接地址需要以http://开头', 'toutiao'),

        'oauth_redirecturi_required' => __('请填写微信OAuth回调地址！', 'toutiao'),

        //admin_material.js
        'upload_images_area'         => __('将图片拖动至此处上传', 'toutiao'),
        'upload_mp3_area'            => __('将语音拖动至此处上传（格式：mp3）', 'toutiao'),
        'title_placeholder'          => __('请输入标题', 'toutiao'),
        'title_placeholder_title'    => __('请输入视频标题', 'toutiao'),
        'graphic'                    => __('图文', 'toutiao'),
        'clone_no_parent'            => __('clone-obj方法未设置data-parent参数。', 'toutiao'),
        'title'                      => __('标题', 'toutiao'),
        'thumbnail'                  => __('缩略图', 'toutiao'),
        'batch_less_parameter'       => __('批量操作缺少参数！', 'toutiao'),
        'images_most8'               => __('图文最多只能添加8条', 'toutiao'),
        'img_priview'                => __('图片预览', 'toutiao'),
        'remove_material_cover'      => __('您确定要删除该封面素材吗？', 'toutiao'),
        'title_placeholder_graphic'  => __('请输入图文标题', 'toutiao'),

    ),

    'menu_page' => array(
        'whether_to_add_submenu' => __('添加子菜单后，一级菜单的内容将被清除。确定添加子菜单？', 'toutiao'),
        'delete_this_menu'                  => __('您确定要删除该菜单吗？', 'toutiao'),
        'ok'                  => __('确定', 'toutiao'),
        'cancel'              => __('取消', 'toutiao'),
    ),

);
//end
