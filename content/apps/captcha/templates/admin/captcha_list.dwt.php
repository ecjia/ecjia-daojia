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
				<label class="control-label"><strong>{lang key='captcha::captcha_manage.captcha_turn_on'}</strong></label>
				<p class="ecjiafc-999">{lang key='captcha::captcha_manage.turn_on_note'}</p>
				<div class="controls chk_radio">
					<input type="checkbox" name="captcha_register" value="1" {$captcha.register} /><span>{lang key='captcha::captcha_manage.captcha_register'}</span>
					<input type="checkbox" name="captcha_login" value="2" {$captcha.login}/><span>{lang key='captcha::captcha_manage.captcha_login'}</span>
					<input type="checkbox" name="captcha_comment" value="4"  {$captcha.comment} /><span>{lang key='captcha::captcha_manage.captcha_comment'}</span>
					<input type="checkbox" name="captcha_admin" value="8" {$captcha.admin} /><span>{lang key='captcha::captcha_manage.captcha_admin'}</span>
					<input type="checkbox" name="captcha_message" value="32" {$captcha.message} /><span>{lang key='captcha::captcha_manage.captcha_message'}</span>
				</div>
			</div>
			<!-- 登录失败时显示验证码 -->
			<div class="control-group formSep clear">
				<label class="control-label"><strong>{lang key='captcha::captcha_manage.captcha_login_fail'}</strong></label>
				<p class="ecjiafc-999">{lang key='captcha::captcha_manage.login_fail_note'}</p>
				<div class="controls chk_radio">
					<input type="radio" name="captcha_login_fail" value="16" {$captcha.login_fail_yes} /><span>{lang key='system::system.yes'}</span>
					<input type="radio" name="captcha_login_fail" value="0" {$captcha.login_fail_no} /><span>{lang key='system::system.no'}</span>
				</div>
			</div>
			<!--TODO验证码宽度高度值目前是写死的。 -->
			<div class="control-group formSep">
				<label class="control-label"><strong>{lang key='captcha::captcha_manage.captcha_width'}</strong></label>
				<p class="ecjiafc-999">{lang key='captcha::captcha_manage.width_note'}</p>
				<div class="controls">
					<input type="text" name="captcha_width" value="{$captcha.captcha_width}" />
					<span class="input-must">{lang key='system::system.require_field'}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label"><strong>{lang key='captcha::captcha_manage.captcha_height'}</strong></label>
				<p class="ecjiafc-999">{lang key='captcha::captcha_manage.height_note'}</p>
				<div class="controls capcha_sl">
					<input type="text" name="captcha_height" value="{$captcha.captcha_height}" />
					<span class="input-must">{lang key='system::system.require_field'}</span>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input class="btn btn-gebo" type="submit" value="{lang key='captcha::captcha_manage.save_setting'}" />
				</div>
			</div>
		</form>
		<h3 class="heading">{lang key='captcha::captcha_manage.code_style'}</h3>
		<div class="media_captcha wookmark">
			<ul>
				<!-- {foreach from=$captchas item=captcha} -->
				<li class="thumbnail">
					<div class="hd">
						<span class="flash-choose error_color {if $captcha.code neq $current_captcha}hidden{/if}">{lang key='captcha::captcha_manage.current_theme'}</span>
						<!-- {$captcha.format_name} -->
					</div>

					<div class="bd">
						<img name="media-boject" src='{url path="captcha/index/init" args="code={$captcha.code}&rand={$rand}"}' alt="captcha" data-toggle="change_captcha" data-src='{url path="captcha/index/init" args="code={$captcha.code}&rand="}' />
					</div>

					<div class="ft">
						<!-- {$captcha.format_description} -->
					</div>
					<div class="input" data-url='{url path="captcha/admin/apply" args="code={$captcha.code}"}'><span>{lang key='captcha::captcha_manage.enable_code'}</span></div>
					
				</li>
				<!-- {/foreach} -->
				<li class="thumbnail">
					<a class="more" href="{url path='@admin_plugin/init'}">
						<i class="fontello-icon-plus"></i>
						<span>{lang key='captcha::captcha_manage.add_code'}</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->