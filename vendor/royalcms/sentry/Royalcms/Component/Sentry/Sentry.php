<?php namespace Royalcms\Component\Sentry;

use Raven_Client;

class Sentry
{
    const VERSION = '0.1.1';

    public static function getClient($user_config)
    {
        $config = array_merge(array(
            'sdk' => array(
                'name' => 'royalcms-sentry',
                'version' => self::VERSION,
            ),
        ), $user_config); 

        return new Raven_Client($config);
    }
}
