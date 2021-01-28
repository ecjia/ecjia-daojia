<?php


namespace Ecjia\System\Hookers;


use ecjia_utility;

class EcjiaFrontAccessSessionAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        if (ecjia_utility::is_spider()) {
            /* 如果是蜘蛛的访问，那么默认为访客方式，并且不记录到日志中 */
            $_SESSION = array();
            $_SESSION['user_id']     = 0;
            $_SESSION['user_name']   = '';
            $_SESSION['email']       = '';
            $_SESSION['user_rank']   = 0;
            $_SESSION['discount']    = 1.00;
        }

        //游客状态也需要设置一下session值
        if (empty($_SESSION['user_id'])) {
            $_SESSION['user_id']     = 0;
            $_SESSION['user_name']   = '';
            $_SESSION['email']       = '';
            $_SESSION['user_rank']   = 0;
            $_SESSION['discount']    = 1.00;

            if (!isset($_SESSION['login_fail'])) {
                $_SESSION['login_fail'] = 0;
            }
        }

    }

}