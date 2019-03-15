<div class="header-top">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{if $shop_title_link}{$shop_title_link}{else}{RC_Uri::url('franchisee/merchant/init')}{/if}"><i class="fa fa-cubes"></i> <strong>{ecjia::config('shop_name')} - {if $shop_title}{$shop_title}{else}商家入驻{/if}</strong></a>
            </div>
            <ul class="nav navbar-nav navbar-left top-menu">
            </ul>
            <ul class="nav navbar-nav navbar-right top-menu">
            	<a class="ecjiafc-white l_h30" href='{RC_Uri::home_url()}'><i class="fa fa-reply"></i> {t domain="franchisee"}网站首页{/t}</a>
            </ul>
        </div>
    </nav>
</div>

<div class="height-50"></div>

<div id="header">
	<div class="header-content">
		<a href="{RC_Uri::home_url()}"><img class="wt-10" src="{if $shop_logo_url}{$shop_logo_url}{else}{$static_url}shop_logo.png{/if}"></a>
		<div class="head-item">
			<ul class="item-nav">
				<li {if $active}class="active"{/if}><a href="{RC_Uri::url('franchisee/merchant/init')}">{t domain="franchisee"}首页{/t}</a></li>
				<!-- {foreach from=$data item=val} -->
					{if $val.title eq '{t domain="franchisee"}入驻流程{/t}'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>{t domain="franchisee"}入驻流程{/t}</li></a>
					{else if $val.title eq '{t domain="franchisee"}入驻协议{/t}'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>{t domain="franchisee"}入驻协议{/t}</li></a>
					{else if $val.title eq '{t domain="franchisee"}入驻帮助{/t}'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>{t domain="franchisee"}入驻帮助{/t}</li></a>
					{else if $val.title eq '{t domain="franchisee"}了解更多{/t}'}
						<a href="{RC_Uri::url('franchisee/merchant/article')}&id={$val.article_id}"><li {if $smarty.get.id eq $val.article_id}class="active"{/if}>{t domain="franchisee"}了解更多{/t}</li></a>
					{/if}
				<!-- {/foreach} -->
			</ul>
			<div class="contact-phone">{$service_phone}</div>
		</div>
	</div>
</div>