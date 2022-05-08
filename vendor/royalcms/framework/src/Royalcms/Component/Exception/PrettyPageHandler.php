<?php

namespace Royalcms\Component\Exception;


use Whoops\Handler\PrettyPageHandler as WhoopsHandler;


class PrettyPageHandler extends WhoopsHandler
{

    public function __construct()
    {
        parent::__construct();

        $this->registerBlacklist();
    }

    /**
     * Register the blacklist with the handler.
     *
     */
    protected function registerBlacklist()
    {
        foreach (config('system.debug_blacklist', []) as $key => $secrets) {
            foreach ($secrets as $secret) {
                $this->blacklist($key, $secret);
            }
        }
    }

}
