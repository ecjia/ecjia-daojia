<?php
/*
Name: 支付密码验证码检查
Description: 这是支付密码验证码检查页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-user ecjia-form ecjia-user-no-border-b" name="payPassForm" action="{url path='user/profile/check_code'}" method="post">
	<div class="d_bind">
		<p class="p_bind">请输入{$user.str_mobile_phone}收到的短信验证码</p>
		<div class="ecjia-list list-short bind">
			<li>
				<div class="form-group d_input_verification_code">
					<label>
						<input type="number" placeholder="请输入验证码" name="code">
					</label>
				</div>
				<div class="form-group get_code">
					<label class="input_verification_code">
						<input type="hidden" name="mobile" value="{$user.mobile_phone}" />
						<input type="button" value="获取验证码" id="get_code" data-url="{url path='user/profile/get_code'}&type=set_paypass" name="mobile" />
					</label>
				</div>
			</li>
		</div>
		<div class=" ecjia-margin-b">
			<input class="btn btn-info" name="submit" type="submit" value="确定" id="account_bind_btn" />
			<input type="hidden" name="type" value="set_paypass" />
		</div>
	</div>
</form>
<!-- {/block} -->