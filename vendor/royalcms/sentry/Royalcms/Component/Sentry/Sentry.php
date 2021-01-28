<?php

namespace Royalcms\Component\Sentry;

use Raven_Client;

class Sentry
{
    const VERSION = '0.9.2';

    public static function getClient($user_config)
    {
        $royalcms = royalcms();
        
        $config = array_merge(array(
            'sdk' => array(
                'name' => 'royalcms-sentry',
                'version' => $royalcms::VERSION,
            ),
        ), $user_config); 

        return new Raven_Client($config);
    }
}
