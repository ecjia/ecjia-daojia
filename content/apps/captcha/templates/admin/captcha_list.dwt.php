<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.captcha.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">{if $ur_here}  {$ur_here} {/if}</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="m_b20" method="post" action="{$form_action}" name="theForm" >
			<div class="control-group formSep">
				<label class="control-label"><strong>{t domain="captcha"}启用验证码{/t}</strong></label>
				<p class="ecjiafc-999">{t domain="captcha"}图片验证码可以避免恶意批量评论或提交信息，推荐打开验证码功能。注意: 启用验证码会使得部分操作变得繁琐，建议仅在必需时打开{/t}</p>
				<div class="controls chk_radio">
<!--					<input type="checkbox" name="captcha_register" value="1" {$captcha.register} /><span>{t domain="captcha"}新用户注册{/t}</span>-->
<!--					<input type="checkbox" name="captcha_login" value="2" {$captcha.login}/><span>{t domain="captcha"}用户登录{/t}</span>-->
<!--					<input type="checkbox" name="captcha_comment" value="4"  {$captcha.comment} /><span>{t domain="captcha"}发表评论{/t}</span>-->
					<input type="checkbox" name="captcha_admin" value="8" {$captcha.admin} /><span>{t domain="captcha"}后台管理员登录{/t}</span>
<!--					<input type="checkbox" name="captcha_message" value="32" {$captcha.message} /><span>{t domain="captcha"}留言板留言{/t}</span>-->
				</div>
			</div>
			<!-- 登录失败时显示验证码 -->
			<div class="control-group formSep clear">
				<label class="control-label"><strong>{t domain="captcha"}登录失败时显示验证码{/t}</strong></label>
				<p class="ecjiafc-999">{t domain="captcha"}选择“是”将在用户登录失败 3 次后才显示验证码，选择“否”将始终在登录时显示验证码。注意: 只有在启用了用户登录验证码时本设置才有效{/t}</p>
				<div class="controls chk_radio">
					<input type="radio" name="captcha_login_fail" value="16" {$captcha.login_fail_yes} /><span>{t domain="captcha"}是{/t}</span>
					<input type="radio" name="captcha_login_fail" value="0" {$captcha.login_fail_no} /><span>{t domain="captcha"}否{/t}</span>
				</div>
			</div>
			<!--TODO验证码宽度高度值目前是写死的。 -->
			<div class="control-group formSep">
				<label class="control-label"><strong>{t domain="captcha"}验证码图片宽度{/t}</strong></label>
				<p class="ecjiafc-999">{t domain="captcha"}验证码图片的宽度，范围在 40～145 之间{/t}</p>
				<div class="controls">
					<input type="text" name="captcha_width" value="{$captcha.captcha_width}" />
					<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label"><strong>{t domain="captcha"}验证码图片高度{/t}</strong></label>
				<p class="ecjiafc-999">{t domain="captcha"}验证码图片的高度，范围在 15～50 之间{/t}</p>
				<div class="controls capcha_sl">
					<input type="text" name="captcha_height" value="{$captcha.captcha_height}" />
					<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input class="btn btn-gebo" type="submit" value='{t domain="captcha"}保存设置{/t}' />
				</div>
			</div>
		</form>
		<h3 class="heading">{t domain="captcha"}可用验证码样式{/t}</h3>
		<div class="media_captcha wookmark">
			<ul>
				<!-- {foreach from=$captchas item=captcha} -->
				<li class="thumbnail">
					<div class="hd">
						<span class="flash-choose error_color {if $captcha.code neq $current_captcha}hidden{/if}">{t domain="captcha"}当前样式{/t}</span>
						<!-- {$captcha.format_name} -->
					</div>

					<div class="bd">
						<img name="media-boject" src='{url path="captcha/index/init" args="code={$captcha.code}&rand={$rand}"}' alt="captcha" data-toggle="change_captcha" data-src='{url path="captcha/index/init" args="code={$captcha.code}&rand="}' />
					</div>

					<div class="ft">
						<!-- {$captcha.format_description} -->
					</div>
					<div class="input" data-url='{url path="captcha/admin/apply" args="code={$captcha.code}"}'><span>{t domain="captcha"}启用此验证码{/t}</span></div>
					
				</li>
				<!-- {/foreach} -->
				<li class="thumbnail">
					<a class="more" href="{url path='@admin_plugin/init'}">
						<i class="fontello-icon-plus"></i>
						<span>{t domain="captcha"}添加验证码{/t}</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->