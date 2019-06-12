<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/2
 * Time: 11:43 AM
 */

namespace Ecjia\App\Touch;

use RC_DB;
use RC_Uri;
use RC_Loader;
use ecjia_integrate;
use ecjia_touch_user;
use ecjia_front;

class EcjiaSyncAppLogin
{

    protected $origin;

    protected $openid;

    protected $usertype;

    protected $token;

    public function __construct()
    {
        $request = royalcms('request');

        $this->origin   = $request->query('origin');
        $this->openid   = $request->query('openid');
        $this->usertype = $request->query('usertype');
        $this->token    = $request->query('token');

    }

    /**
     * 自动判断H5是否自动登录
     */
    public function justAutologin()
    {
        if ($this->origin && $this->openid && $this->usertype && $this->token) {

            $row = RC_DB::table('connect_user')->where('connect_code', $this->origin)
                ->where('open_id', $this->openid)
                ->where('user_type', $this->usertype)
                ->where('access_token', $this->token)
                ->first();

            if (! empty($row)) {
                $user_id = $row['user_id'];
                RC_Loader::load_app_func('admin_user', 'user');
                $user_info = EM_user_info($user_id);

                if (! empty($user_info)) {
                    ecjia_integrate::setSession($user_info['name']);
                    ecjia_integrate::setCookie($user_info['name']);

                    $res = [
                        'token' => $this->token,
                        'user' => $user_info,
                    ];
                    ecjia_touch_user::singleton()->setUserinfo($res);

                    //组装跳转地址
                    $querys = royalcms('request')->query();
                    unset($querys['origin']);
                    unset($querys['openid']);
                    unset($querys['usertype']);
                    unset($querys['token']);
                    $query_str = http_build_query($querys);
                    $url = RC_Uri::site_url(). '/index.php?' .$query_str;

                    ecjia_front::$controller->redirectWithExited($url);
                }

            }


        }

    }


}