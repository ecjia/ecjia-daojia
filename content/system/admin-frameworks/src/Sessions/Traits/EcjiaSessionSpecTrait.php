<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-28
 * Time: 16:17
 */

namespace Ecjia\System\Frameworks\Sessions\Traits;

use Ecjia\Component\SessionLogins\AdminSessionLogins;
use Ecjia\Component\SessionLogins\MerchantSessionLogins;
use Ecjia\Component\SessionLogins\UserSessionLogins;
use Royalcms\Component\NativeSession\Serialize;

/**
 * Trait EcjiaSessionSpecAction
 * @package Ecjia\System\Frameworks\Sessions\Traits
 *
 */
trait EcjiaSessionSpecTrait
{

    /**
     * 删除指定用户的session
     * @param int $user_id 用户ID
     * @param int $user_type 用户类型user,admin,merchant
     * @return boolean
     */
    public function deleteSpecSession($userId, $userType)
    {
        if ($userType == 'admin') {
            $session_login = new AdminSessionLogins(null, $userId);
        }
        else if ($userType == 'merchant') {
            $session_login = new MerchantSessionLogins(null, $userId);
        }
        else {
            $session_login = new UserSessionLogins(null, $userId);
        }

        $sessions = $session_login->getByUserId();

        $result = $sessions->map(function ($model) {
            /**
             * @var \SessionHandlerInterface $this
             */
            return $this->destroy($model->id);
        });

        return $result;
    }


    /**
     * 获取当前在线用户总数
     * @return number
     */
    public function getUserCount($userType)
    {
        if ($userType == 'admin') {
            $session_login = new AdminSessionLogins(null, null);
        }
        else if ($userType == 'merchant') {
            $session_login = new MerchantSessionLogins(null, null);
        }
        else {
            $session_login = new UserSessionLogins(null, null);
        }

        $count = $session_login->getUserCount();

        return $count;
    }


    /**
     * 获取指定session_id的数据
     * @param string $session_id
     */
    public function getSessionData($sessionId)
    {
        try {
            /**
             * @var \SessionHandlerInterface $this
             */
            $data = $this->read($sessionId);
            $sessionData = Serialize::unserialize($data);
            return $sessionData;
        }
        catch (\Exception $e) {
            ecjia_log_error($e->getMessage());
            return [];
        }
    }


}