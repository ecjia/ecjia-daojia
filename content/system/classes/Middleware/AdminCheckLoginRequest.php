<?php


namespace Ecjia\System\Middleware;


use admin_nav_here;
use Closure;
use ecjia;
use ecjia_admin;
use ecjia_screen;
use RC_Cookie;
use RC_Ip;
use RC_Session;
use RC_Time;
use RC_Uri;

class AdminCheckLoginRequest
{

    public function handle($request, Closure $next)
    {
        // 判断用户是否登录
        if (!$this->_check_login()) {
            RC_Session::destroy();
            if (is_pjax()) {
                ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('系统提示')));
                return ecjia_admin::$controller->showmessage(__('对不起,您没有执行此项操作的权限!'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('重新登录'), 'href' => RC_Uri::url('@privilege/login')))));
            }
            elseif (is_ajax()) {
                return ecjia_admin::$controller->showmessage(__('对不起,您没有执行此项操作的权限!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            else {
                RC_Cookie::set('admin_login_referer', RC_Uri::current_url());
                return ecjia_admin::$controller->redirect(RC_Uri::url('@privilege/login'));
            }
        }

        return $next($request);
    }

    /**
     * 后台判断是否登录
     */
    private function _check_login()
    {
        /* 验证公开路由 */
        if (ecjia_admin::$controller->isVerificationPublicRoute()) {
            return true;
        }

        /* 验证管理员身份 */
        if (ecjia_admin::$controller->authSession()) {
            return true;
        }

        return (new \Ecjia\System\Admins\RememberPassword\RememberPassword)->verification(function($model) {
            ecjia_admin::$controller->admin_session($model['user_id'], $model['user_name'], $model['action_list'], $model['last_time']);

            $model->last_login = RC_Time::gmtime();
            $model->last_ip = RC_Ip::client_ip();
            $model->save();
        });
    }

}