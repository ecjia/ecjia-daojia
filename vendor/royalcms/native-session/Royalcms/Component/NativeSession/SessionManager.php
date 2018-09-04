<?php

namespace Royalcms\Component\NativeSession;

use Royalcms\Component\Session\SessionManager as RoyalcmsSessionManager;

class SessionManager extends RoyalcmsSessionManager
{

    /**
     * Set session name and session id
     * @param \SessionHandlerInterface $handler
     * @return Store
     */
    protected function buildSession($handler)
    {
        $session = parent::buildSession($handler);

        $session_name = \RC_Hook::apply_filters('royalcms_session_name', $this->royalcms['config']['session.name']);
        $session_id = \RC_Hook::apply_filters('royalcms_session_id', null);
        $session->setId($session_id);
        $session->setName($session_name);

        return new Store($session);
    }

}
