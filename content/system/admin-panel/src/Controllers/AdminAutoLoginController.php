<?php


namespace Ecjia\System\AdminPanel\Controllers;


use ecjia;
use Ecjia\Component\AutoLogin\AuthEncrypterInterface;
use Ecjia\Component\AutoLogin\AuthLoginDecrypt;
use Ecjia\System\Admins\Users\AdminUserRepository;
use ecjia_admin;
use ecjia_error;
use RC_Hook;
use RC_Session;
use RC_Uri;

/**
 * Class AdminAutoLoginController
 * @package Ecjia\Theme\AdminPanel\Controllers\Admincp
 */
class AdminAutoLoginController extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 跳转示例
     * /?m=admincp&c=admin_auto_login&a=init&authcode=xxx&redirect_url=xxx
     * @return ecjia_error|\Illuminate\Http\RedirectResponse|string
     */
    public function init()
    {
        $authcode     = trim($this->request->input('authcode'));
        $redirect_url = htmlspecialchars_decode($this->request->input('redirect_url'));
        if (empty($redirect_url)) {
            $redirect_url = RC_Uri::url('@index/init');
        }

        $result = $this->autologin_verification($authcode);

        if (is_ecjia_error($result)) {
            RC_Session::destroy();

            $links[] = array('text' => __('返回重新登录', 'admin'), 'href' => RC_Uri::url('@privilege/login'));
            return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
        }

        return $this->redirect($redirect_url);
    }

    /**
     * @param $authcode
     * @param $redirect_url
     * @return ecjia_error| bool
     */
    private function autologin_verification($authcode)
    {
        if (empty($authcode)) {
            return new ecjia_error('error_message', __('抱歉！数据丢失，登录失败。', 'admin'));
        }

        try {
            $encrypter = royalcms(AuthEncrypterInterface::class);
            $params = (new AuthLoginDecrypt($authcode, $encrypter))->decrypt();
        }
        catch (\Exception $exception) {
            return new ecjia_error('error_message', $exception->getMessage());
        }

        if ( ! (array_key_exists("user_name", $params) && array_key_exists("session_id", $params) ) ) {
            return new ecjia_error('error_message', __('传参出错。', 'admin'));
        }

        //参数值接收
        $user_name  = $params['user_name'];
        $session_id = $params['session_id'];

        $result = 'ok';
        $result = RC_Hook::apply_filters('admin_auto_login_verification', $result, $params);
        if (is_ecjia_error($result)) {
            return $result;
        }

        $model = AdminUserRepository::model()->where('user_name', $user_name)->first();
        if (empty($model)) {
            return new ecjia_error('error_message', __('您输入的帐号信息不正确。', 'admin'));
        }

        $this->admin_session($model->user_id, $model->user_name, $model->action_list, $model->last_login);

        return true;
    }

}