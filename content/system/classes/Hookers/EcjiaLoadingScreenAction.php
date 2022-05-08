<?php


namespace Ecjia\System\Hookers;


use RC_Uri;

class EcjiaLoadingScreenAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * 是否已经安装过ECJia
         */
        if (is_installed_ecjia()) {
            $events = royalcms('Royalcms\Component\Hook\Dispatcher');
            $events->subscribe('Ecjia\System\Subscribers\InstalledScreenSubscriber');
        }

    }

}