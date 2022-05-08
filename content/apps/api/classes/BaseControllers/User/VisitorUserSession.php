<?php

namespace Ecjia\App\Api\BaseControllers\User;

use RC_Session;

class VisitorUserSession
{

    /**
     * 游客状态也需要设置一下session值
     */
    public function resetSession()
    {
        if (! (RC_Session::exists('session_user_id') && RC_Session::exists('session_user_type'))) {
            RC_Session::put('user_id', 0);
            RC_Session::put('user_name', '');
            RC_Session::put('email', '');
            RC_Session::put('user_rank', 0);
            RC_Session::put('discount', 1.00);

            if (! RC_Session::exists('login_fail')) {
                RC_Session::put('login_fail', 0);
            }

        }

    }

}