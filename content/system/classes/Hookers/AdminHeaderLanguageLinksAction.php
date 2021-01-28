<?php


namespace Ecjia\System\Hookers;

class AdminHeaderLanguageLinksAction
{

    /**
     * Handle the event.
     * hook:admin_dashboard_header_links
     * @return void
     */
    public function handle()
    {
        $lang = __('简体中文');

        $nav = <<<EOF
        <li class="divider-vertical hidden-phone hidden-tablet"></li>
        <li class="dropdown">
            <a class="dropdown-toggle nav_condensed" href="#" data-toggle="dropdown"><i class="flag-cn"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)"><i class="flag-cn"></i> $lang</a></li>
            </ul>
        </li>
EOF;

        /**
         * 暂未开启
         * <!-- <li><a href="javascript:void(0)"><i class="flag-us"></i> {t}English{/t}</a></li> -->
         */

        echo $nav;
    }

}