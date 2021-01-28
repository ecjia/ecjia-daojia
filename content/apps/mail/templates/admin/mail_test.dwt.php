<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	// ecjia.admin.mail_settings.setmail();
    var $form = $('form[name="theForm"]');
    $form.validate({
        submitHandler: function () {
            $form.ajaxSubmit({
                dataType: "json",
                success: function (data) {
                    ecjia.admin.showmessage(data);
                }
            });
        }
    });
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" name="theForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="user_name">{t domain="mail"}邮件地址：{/t}</label>
					<div class="controls">
						<input class="span4" id="test_mail_address" type="text" name="test_mail_address"/>
						<button class="btn" type="submit">{t domain="mail"}发送测试邮件{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->