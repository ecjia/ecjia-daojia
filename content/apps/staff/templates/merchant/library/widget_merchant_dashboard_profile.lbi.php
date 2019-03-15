<!-- start:user info -->
<div class="panel panel-default">
    <div class="panel-heading">
        <header class="panel-title">
            <div class="text-center">
                <strong>{t domain="staff"}个人信息{/t}</strong>
            </div>
        </header>
    </div>
    <div class="panel-body">
        <div class="text-center" id="author">
			<a href="{RC_Uri::url('staff/mh_profile/init')}">
				{if $user_info.avatar eq ''}
	                <img src="{$ecjia_main_static_url}img/ecjia_avatar.jpg" /><br>
	            {else}
	            	<img width ="100" height="100" src="{RC_Upload::upload_url()}/{$user_info.avatar}">
	            {/if}
	   		</a>
			<h3>{$user_info.name}</h3>
            {if $user_info.parent_id eq 0}
            <small class="label label-warning">{t domain="staff"}店长{/t}</small>
            {/if}
           	<p>{if $user_info.introduction eq ''}{t domain="staff"}主人你好懒，赶紧去个人中心完善资料吧~~{/t}{else}{$user_info.introduction}{/if}</p>
            <div class="pull-left">
                 <label class="">{t domain="staff"}上次登录IP：{/t}</label>
                 {$user_info.last_ip}
            </div>
            <div class="pull-left">
                 <label class="">{t domain="staff"}上次登录时间：{/t}</label>
                 {$user_info.last_login}
            </div>
            
        </div>
    </div>

</div>
<!-- end:user info -->