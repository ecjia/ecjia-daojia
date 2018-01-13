<?php

namespace Royalcms\Component\NativeSession;

use Royalcms\Component\Session\SessionManager as RoyalcmsSessionManager;

class SessionManager extends RoyalcmsSessionManager
{
    protected function buildSession($handler)
    {
        $session = parent::buildSession($handler);
        return new Store($session);
    }
}
