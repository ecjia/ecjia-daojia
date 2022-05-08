<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-15
 * Time: 14:16
 */

namespace Ecjia\System\Subscribers;

use RC_Config;
use RC_Hook;
use RC_Upload;
use Royalcms\Component\Hook\Dispatcher;

class AllScreenSubscriber
{

    /**
     * 移除$_ENV中的敏感信息
     * @param $tables
     * @return mixed
     */
    public function onRemoveEnvPrettyPageTableDataFilter($tables)
    {
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

    public function onSetEcjiaFilterRequestGetAction()
    {
        ecjia_filter_request_input($_GET);
        ecjia_filter_request_input($_REQUEST);
    }


    public function onEcjiaSetHeaderAction()
    {
        header('content-type: text/html; charset=' . RC_CHARSET);
        header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {

        //filter
        $events->addFilter(
            'pretty_page_table_data',
            sprintf('%s@%s', __CLASS__, 'onRemoveEnvPrettyPageTableDataFilter')
        );

        //action
        $events->addAction(
            'ecjia_admin_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onEcjiaSetHeaderAction')
        );
        $events->addAction(
            'ecjia_front_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onEcjiaSetHeaderAction')
        );

        $events->addAction(
            'ecjia_admin_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onSetEcjiaFilterRequestGetAction')
        );
        $events->addAction(
            'ecjia_front_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onSetEcjiaFilterRequestGetAction')
        );
        $events->addAction(
            'ecjia_api_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onSetEcjiaFilterRequestGetAction')
        );
        $events->addAction(
            'ecjia_merchant_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onSetEcjiaFilterRequestGetAction')
        );
        $events->addAction(
            'ecjia_platform_finish_launching',
            sprintf('%s@%s', __CLASS__, 'onSetEcjiaFilterRequestGetAction')
        );

    }

}