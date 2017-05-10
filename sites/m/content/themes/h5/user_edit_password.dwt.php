<?php
/*
Name: 修改密码页面模板
Description: 这是修改密码页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
{foreach from=$lang.profile_js item=item key=key}
	var {$key} = "{$item}";
{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-form ecjia-login-edit-password-form ecjia-login-padding-top ecjia-user-no-border-b" name="formPassword" action="{url path='user/profile/edit_password'}&type=ajax" method="post" >
	<div class="ecjia-user ecjia-account ecjia-form border-t">
        <ul>
            <div class="ecjia-list ecjia-list-normal form-group right-angle ecjia-user-no-border-b">
                <li>
                	<label class="input">
            			<input class="ecjia-account-passwd-on ecjia-user-height-2" name="old_password" placeholder="请输入旧密码" type="password">
            		</label>
                </li>
                <li>
                	<label class="input">
            			<input class="ecjia-account-passwd-on ecjia-user-height-2" name="new_password" placeholder="请输入新密码" type="password">
            		</label>
                </li>
                 <li>
            		<label class="input">
            			<input class="ecjia-account-passwd-on ecjia-user-height-2" name="comfirm_password" placeholder="请确认新密码" type="password">
            		</label>
                </li>
            </div>
        </ul>
    </div>
    <input name="act" type="hidden" value="edit_password" />
    <div class="ecjia-button-top-list ecjia-margin-b">
    	<input class="btn btn-info" name="submit" type="submit" value="确定" />
    </div>
</form>
<!-- {/block} -->