<?php

namespace Royalcms\Component\NativeSession;

use Royalcms\Component\Session\SessionManager as RoyalcmsSessionManager;
<<<<<<< HEAD
=======
use RC_Hook;
>>>>>>> v2-test

class SessionManager extends RoyalcmsSessionManager
{

    /**
     * Set session name and session id
     * @param \SessionHandlerInterface $handler
     * @return Store
     */
    protected function buildSession($handler)
    {
<<<<<<< HEAD
        $session = parent::buildSession($handler);

        $session_name = \RC_Hook::apply_filters('royalcms_session_name', $this->royalcms['config']['session.name']);
        $session_id = \RC_Hook::apply_filters('royalcms_session_id', null);
        $session->setId($session_id);
        $session->setName($session_name);

        return new Store($session);
=======
        $session_name = RC_Hook::apply_filters('royalcms_session_name', $this->royalcms['config']['session.name']);
        $session_id = RC_Hook::apply_filters('royalcms_session_id', null);

        if ($this->royalcms['config']['session.encrypt']) {
            $session = new EncryptedStore(
                $this->royalcms['config']['session.cookie'], $handler, $this->royalcms['encrypter']
            );
        } else {
            $session = new Store($this->royalcms['config']['session.cookie'], $handler);
        }

        $session->setId($session_id);
        $session->setName($session_name);

        return $session;
>>>>>>> v2-test
    }

}
