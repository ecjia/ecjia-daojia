<div class="col-lg-4 col-md-4 col-xs-12">
      <div class="panel panel-default">
          <div class="panel-body">
	        <div class="text-center" id="author">
				{if $user_info.avatar eq ''}
	                <img src="{$ecjia_main_static_url}img/ecjia_avatar.jpg" /><br>
	            {else}
	            	<img width ="100" height="100" src="{RC_Upload::upload_url()}/{$user_info.avatar}">
	            {/if}
	            <h3>{$user_info.name}</h3>
	            {if $user_info.parent_id eq 0}
	            <small class="label label-warning">店长</small>
	            {/if}
	           	<p>{if $user_info.introduction eq ''}主人你好懒，赶紧去个人中心完善资料吧~~{else}{$user_info.introduction}{/if}</p>
	            <div class="pull-left">
	                 <label class="">{t}上次登录IP：{/t}</label>
	                 {$user_info.last_ip}
	            </div>
	            <div class="pull-left">
	                 <label class="">{t}上次登录时间：{/t}</label>
	                 {$user_info.last_login}
	            </div>
	            
	        </div>
    	</div>
     </div>
</div>
