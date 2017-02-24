<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mail_settings.setmail();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t}提示：{/t}</strong>{t}如果您的服务器支持 Mail 函数（具体信息请咨询您的空间提供商）。我们建议您使用系统的 Mail 函数。{/t}<br />{t}当您的服务器不支持 Mail 函数的时候您也可以选用 SMTP 作为邮件服务器。{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" name="theForm" action="{$form_action}" method="post">
			<fieldset>
				<!-- {foreach from=$cfg item=var key=key} -->
				<!-- #BeginLibraryItem "/library/shop_config_form.lbi" --><!-- #EndLibraryItem -->
				<!-- {/foreach} -->
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
						<input name="type" type="hidden" value="mail_setting"/>
					</div>
				</div>
				<h3 class="heading">
					<!-- {if $ur_heretest}{$ur_heretest}{/if} -->
				</h3>
				<div class="control-group">
					<label class="control-label" for="user_name">{t}邮件地址：{/t}</label>
					<div class="controls">
						<input class="span4" id="test_mail_address" type="text" name="test_mail_address"/>
						<button class="btn test_mail" type="button" name="test_mail" data-href="{url path='mail/admin_mail_settings/send_test_email'}">{t}发送测试邮件{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->