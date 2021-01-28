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
 * 路由配置文件
 */

//注明：
//以下路由只是指明入口，真正的逻辑不应该和入口方法有强依赖关系，所以入口方法和逻辑处理应当分离
//入口和逻辑之间只应保持数据依赖关系，并尽可能排除其他依赖关系，方便其他控制器在使用类似功能时能重用
//所以，最好可以将通用方法封装成组件，路由指定的控制器入口方法只负责实现简单判断、参数过滤和调用
//若存在复杂的逻辑方法，应当尽可能将其分割成多个提供单一功能的子方法，然后进行组合封装，确保子方法可以被充分复用
//因而模板里所呈现的内容，应当是由一个或多个提供简单逻辑和数据获取的方法提供，而不是直接在入口内部实现复杂算法

return [

    //index
    'admincp/index/init'                     => 'Ecjia\System\AdminPanel\Controllers\IndexController@init', //后台控制面板首页
    'admincp/admin_auto_login/init'          => 'Ecjia\System\AdminPanel\Controllers\AdminAutoLoginController@init', //后台自动登录验证

    //about
    'admincp/about/about_us'                 => 'Ecjia\System\AdminPanel\Controllers\AboutController@about_us', //关于 ECJIA
    'admincp/about/about_team'               => 'Ecjia\System\AdminPanel\Controllers\AboutController@about_team', //ECJIA团队
    'admincp/about/about_system'             => 'Ecjia\System\AdminPanel\Controllers\AboutController@about_system', //ECJIA系统检测

    //admin_application
    'admincp/admin_application/init'         => 'Ecjia\System\AdminPanel\Controllers\AdminApplicationController@init', //应用列表
    'admincp/admin_application/clear_cache'  => 'Ecjia\System\AdminPanel\Controllers\AdminApplicationController@clear_cache', //
    'admincp/admin_application/detail'       => 'Ecjia\System\AdminPanel\Controllers\AdminApplicationController@detail', //查看应用
    'admincp/admin_application/install'      => 'Ecjia\System\AdminPanel\Controllers\AdminApplicationController@install', //安装应用
    'admincp/admin_application/uninstall'    => 'Ecjia\System\AdminPanel\Controllers\AdminApplicationController@uninstall', //卸载应用

    //admin_cache
    'admincp/admin_cache/init'               => 'Ecjia\System\AdminPanel\Controllers\AdminCacheController@init', //更新缓存
    'admincp/admin_cache/update_cache'       => 'Ecjia\System\AdminPanel\Controllers\AdminCacheController@update_cache', //更新缓存

    //admin_filehash
    'admincp/admin_filehash/init'            => 'Ecjia\System\AdminPanel\Controllers\AdminFilehashController@init', //文件校验结果显示
    'admincp/admin_filehash/check'           => 'Ecjia\System\AdminPanel\Controllers\AdminFilehashController@check', //文件校验，是否变动

    //admin_file_permission
    'admincp/admin_file_permission/init'     => 'Ecjia\System\AdminPanel\Controllers\AdminFilePermissionController@init', //文件权限检测

    //admin_logs
    'admincp/admin_logs/init'                => 'Ecjia\System\AdminPanel\Controllers\AdminLogsController@init', //
    'admincp/admin_logs/batch_drop'          => 'Ecjia\System\AdminPanel\Controllers\AdminLogsController@batch_drop', //批量删除日志记录

    //admin_plugin
    'admincp/admin_plugin/init'              => 'Ecjia\System\AdminPanel\Controllers\AdminPluginController@init', //插件列表
    'admincp/admin_plugin/install'           => 'Ecjia\System\AdminPanel\Controllers\AdminPluginController@install', //安装插件
    'admincp/admin_plugin/uninstall'         => 'Ecjia\System\AdminPanel\Controllers\AdminPluginController@uninstall', //卸载插件
    'admincp/admin_plugin/config'            => 'Ecjia\System\AdminPanel\Controllers\AdminPluginController@config', //插件配置

    //admin_role
    'admincp/admin_role/init'                => 'Ecjia\System\AdminPanel\Controllers\AdminRoleController@init', //
    'admincp/admin_role/add'                 => 'Ecjia\System\AdminPanel\Controllers\AdminRoleController@add', //添加角色页面
    'admincp/admin_role/insert'              => 'Ecjia\System\AdminPanel\Controllers\AdminRoleController@insert', //添加角色的处理
    'admincp/admin_role/edit'                => 'Ecjia\System\AdminPanel\Controllers\AdminRoleController@edit', //编辑角色信息
    'admincp/admin_role/update'              => 'Ecjia\System\AdminPanel\Controllers\AdminRoleController@update', //更新角色信息
    'admincp/admin_role/remove'              => 'Ecjia\System\AdminPanel\Controllers\AdminRoleController@remove', //删除一个角色

    //admin_session
    'admincp/admin_session/init'             => 'Ecjia\System\AdminPanel\Controllers\AdminSessionController@init', //
    'admincp/admin_session/detail'           => 'Ecjia\System\AdminPanel\Controllers\AdminSessionController@detail', //查看详情
    'admincp/admin_session/remove'           => 'Ecjia\System\AdminPanel\Controllers\AdminSessionController@remove', //删除

    //admin_session_login
    'admincp/admin_session_login/init'       => 'Ecjia\System\AdminPanel\Controllers\AdminSessionLoginController@init', //
    'admincp/admin_session_login/remove'     => 'Ecjia\System\AdminPanel\Controllers\AdminSessionLoginController@remove', //删除

    //admin_user
    'admincp/admin_user/init'                => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@init', //管理员列表页面
    'admincp/admin_user/add'                 => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@add', //添加管理员页面
    'admincp/admin_user/insert'              => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@insert', //添加管理员的处理
    'admincp/admin_user/edit'                => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@edit', //编辑管理员信息
    'admincp/admin_user/update'              => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@update', //更新管理员信息
    'admincp/admin_user/allot'               => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@allot', //为管理员分配权限
    'admincp/admin_user/update_allot'        => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@update_allot', //更新管理员的权限
    'admincp/admin_user/remove'              => 'Ecjia\System\AdminPanel\Controllers\AdminUserController@remove', //删除一个管理员

    //get_password
    'admincp/get_password/forget_pwd'        => 'Ecjia\System\AdminPanel\Controllers\GetPasswordController@forget_pwd', //
    'admincp/get_password/reset_pwd_mail'    => 'Ecjia\System\AdminPanel\Controllers\GetPasswordController@reset_pwd_mail', //
    'admincp/get_password/reset_pwd_form'    => 'Ecjia\System\AdminPanel\Controllers\GetPasswordController@reset_pwd_form', //
    'admincp/get_password/reset_pwd'         => 'Ecjia\System\AdminPanel\Controllers\GetPasswordController@reset_pwd', //

    //license
    'admincp/license/license'                => 'Ecjia\System\AdminPanel\Controllers\LicenseController@license', //证书编辑页
    'admincp/license/license_upload'         => 'Ecjia\System\AdminPanel\Controllers\LicenseController@license_upload', //证书上传
    'admincp/license/license_download'       => 'Ecjia\System\AdminPanel\Controllers\LicenseController@license_download', //证书下载
    'admincp/license/license_delete'         => 'Ecjia\System\AdminPanel\Controllers\LicenseController@license_delete', //证书删除

    //load_scripts
    'admincp/load_scripts/init'              => 'Ecjia\System\AdminPanel\Controllers\LoadScriptsController@init', //

    //load_styles
    'admincp/load_styles/init'               => 'Ecjia\System\AdminPanel\Controllers\LoadStylesController@init', //

    //privilege
    'admincp/privilege/login'                => 'Ecjia\System\AdminPanel\Controllers\PrivilegeController@login', //登录界面
    'admincp/privilege/logout'               => 'Ecjia\System\AdminPanel\Controllers\PrivilegeController@logout', //退出登录
    'admincp/privilege/signin'               => 'Ecjia\System\AdminPanel\Controllers\PrivilegeController@signin', //验证登录信息
    'admincp/privilege/modif'                => 'Ecjia\System\AdminPanel\Controllers\PrivilegeController@modif', //编辑个人资料
    'admincp/privilege/update_self'          => 'Ecjia\System\AdminPanel\Controllers\PrivilegeController@update_self', //更新管理员信息

    //quick_nav
    'admincp/admin_quick_nav/init'           => 'Ecjia\System\AdminPanel\Controllers\AdminQuickNavController@init', //个人快捷导航菜单修改
    'admincp/admin_quick_nav/quick_nav_save' => 'Ecjia\System\AdminPanel\Controllers\AdminQuickNavController@quick_nav_save', //个人快捷导航菜单修改 - 保存

    //upgrade
    'admincp/upgrade/init'                   => 'Ecjia\System\AdminPanel\Controllers\UpgradeController@init', //
    'admincp/upgrade/check_update'           => 'Ecjia\System\AdminPanel\Controllers\UpgradeController@check_update', //


];

