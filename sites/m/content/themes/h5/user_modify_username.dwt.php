<?php
/*
Name:  会员中心：编辑用户名模板
Description:  会员中心：编辑用户名首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-user ecjia-login-user-profile-form ecjia-login-padding-top" name="user_profile">
	<div class="ecjia-form">
    	<div class="form-group ecjia-login-margin-lr ecjiaf-bt right-angle">
    		<label class="input">
    		    {if $limit_time}<p class="not_modify">禁止修改</p>{/if}
    			<input class="ecjia-login-pa-left" id="username-modify" {if $limit_time}disabled="true"{/if}name="username" type="text" placeholder="请输入用户名"  value="{$user.name}">
    		</label>
    	</div>
    	<p class="ecjia-margin-l ecjia-margin-t">4-20个字符，可由中英文、数字、"——"、"-"组成</p>
    	<p class="modify-username-info" id="modify-username-info">{if $user.update_username_time eq ''}{'注：用户名一个月只能修改一次'}{else}注：用户名一个月只能修改一次，上次修改时间为：{$update_username_time}{/if}</p>
    	<div class="ecjia-login-b ecjia-button-top-list">
    	    <div class="p-top3">
                <input type="hidden" name="referer" value="{$smarty.get.referer}" />
                <input name="modify_username" {if $limit_time}type="reset"{else}type="submit"{/if} class="btn btn-info nopjax {if $limit_time}not_submit{/if} external" data-url="{url path='user/profile/modify_username_account'}" value="确定" />
    	    </div>	
    	</div>
	</div>
</form>
<!-- {/block} -->