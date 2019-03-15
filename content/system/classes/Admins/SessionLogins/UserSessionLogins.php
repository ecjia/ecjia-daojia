<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 10:10
 */

namespace Ecjia\System\Admins\SessionLogins;


class UserSessionLogins extends SessionLogins
{

    protected $user_type = 'user';

    public function __construct($session_id, $user_id)
    {
        parent::__construct($session_id, $user_id);
    }




}