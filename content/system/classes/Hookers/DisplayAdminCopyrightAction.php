<?php


namespace Ecjia\System\Hookers;


use ecjia;
use RC_Uri;

class DisplayAdminCopyrightAction
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $ecjia_version = ecjia::version();
        $company_msg   = '版权所有 © 2013-2020 上海商创网络科技有限公司，并保留所有权利。';
        $ecjia_icon    = RC_Uri::admin_url('statics/images/ecjia_icon.png');

        echo "<div class='row-fluid footer'>
        		<div class='span12'>
        			<span class='f_l w35'>
        				<img src='{$ecjia_icon}' />
        			</span>
        			{$company_msg}	
        			<span class='f_r muted'>
        				<i>v{$ecjia_version}</i>
        			</span>
        		</div>
        	</div>";
    }

}