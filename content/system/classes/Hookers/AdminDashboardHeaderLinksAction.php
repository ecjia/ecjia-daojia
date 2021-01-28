<?php


namespace Ecjia\System\Hookers;


class AdminDashboardHeaderLinksAction
{

    /**
     * Handle the event.
     * hook:admin_dashboard_header_links
     * @return void
     */
    public function handle()
    {
        echo <<<EOF
		<a data-toggle="modal" data-backdrop="static" href="#myMail" class="label ttip_b" title="New messages">25 <i class="splashy-mail_light"></i></a>
		<a data-toggle="modal" data-backdrop="static" href="#myTasks" class="label ttip_b" title="New tasks">10 <i class="splashy-calendar_week"></i></a>
EOF;

    }

}