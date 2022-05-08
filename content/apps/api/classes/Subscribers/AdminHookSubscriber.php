<?php


namespace Ecjia\App\Api\Subscribers;


use ecjia;
use Ecjia\App\Api\ApiGroupMenu;
use ecjia_admin;
use ecjia_config;
use RC_Package;
use Royalcms\Component\Hook\Dispatcher;

class AdminHookSubscriber
{
    /**
     * Handle events.
     */
    public function onDisplayApiGroupNavAction($code)
    {
        $menus = ApiGroupMenu::singleton()->getMenus();

        echo '<div class="setting-group">' . PHP_EOL;
        echo '<span class="setting-group-title"><i class="fontello-icon-cog"></i>API组</span>' . PHP_EOL;
        echo '<ul class="nav nav-list m_t10">' . PHP_EOL;

        foreach ($menus as $key => $group) {
            if ($group->action == 'divider') {
                echo '<li class="divider"></li>';
            } elseif ($group->action == 'nav-header') {
                echo '<li class="nav-header">' . $group->name . '</li>';
            } else {
                echo '<li><a class="setting-group-item'; //data-pjax

                if ($code == $group->action) {
                    echo ' llv-active';
                }

                echo '" href="' . $group->link . '">' . $group->name . '</a></li>' . PHP_EOL;
            }
        }

        echo '</ul>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param \Royalcms\Component\Hook\Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {

        $events->addAction(
            'admin_api_group_nav',
            sprintf('%s@%s', __CLASS__, 'onDisplayApiGroupNavAction')
        );

    }

}