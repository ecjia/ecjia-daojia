<?php


namespace Ecjia\System\Hookers;


use RC_Uri;

class DisplayAdminAboutWelcomeAction
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $ecjia_version = VERSION;
        $ecjia_welcome_logo = RC_Uri::admin_url('statics/images/ecjiawelcom.png');
        $welcome_ecjia 	= __('欢迎使用ECJia');
        $description = __('ECJia是一款基于PHP+MYSQL开发的多语言移动电商管理框架，推出了灵活的应用+插件机制，软件执行效率高；简洁超炫的UI设计，轻松上手；多国语言支持、后台管理功能方便等诸多优秀特点。凭借ECJia团队不断的创新精神和认真的工作态度，相信能够为您带来全新的使用体验！');
        $more = __('进入官网 »');
        $ecjia_url = 'https://ecjia.com';

        $welcome = <<<WELCOME
        <div class="hero-unit">
			<div class="row-fluid">
				<div class="span9">
					<h1>{$welcome_ecjia} {$ecjia_version}</h1>
					<p>{$description}</p>
					<p><a class="btn btn-info" href="{$ecjia_url}" target="_bank">{$more}</a></p>
				</div>
				<div class="span3">
					<div><img src="{$ecjia_welcome_logo}" /></div>
				</div>
			</div>
		</div>
WELCOME;
        echo $welcome;
    }

}