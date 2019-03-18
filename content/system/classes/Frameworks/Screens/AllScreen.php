<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-15
 * Time: 14:16
 */

namespace Ecjia\System\Frameworks\Screens;

use RC_Hook;

class AllScreen
{

    public function __construct()
    {


    }


    public function loading()
    {

        RC_Hook::add_filter('pretty_page_table_data', [__CLASS__, 'remove_env_pretty_page_table_data']);

        RC_Hook::add_action('reset_mail_config', ['Ecjia\System\Frameworks\Component\Mailer', 'ecjia_mail_config']);
    }


    /**
     * 移除$_ENV中的敏感信息
     * @param $tables
     * @return mixed
     */
    public static function remove_env_pretty_page_table_data($tables) {
        $env = collect($tables['Environment Variables']);
        $server = collect($tables['Server/Request Data']);

        $col = collect([
            'AUTH_KEY',
            'DB_HOST',
            'DB_PORT',
            'DB_DATABASE',
            'DB_USERNAME',
            'DB_PASSWORD',
            'DB_PREFIX'
        ]);
        $col->map(function ($item) use ($env, $server) {
            $env->pull($item);
            $server->pull($item);
        });

        $tables['Environment Variables'] = $env->all();
        $tables['Server/Request Data'] = $server->all();
        return $tables;
    }



}