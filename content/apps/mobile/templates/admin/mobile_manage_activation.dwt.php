<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mobile_manage.info();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>


<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mobile"}应用名称：{/t}</label>
					<div class="controls">
						<input class="span4" name="name" type="text" value="{$name}" />
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mobile"}应用包名：{/t}</label>
					<div class="controls">
						<input class="span4" name="bundleid" type="text" value="" />
						<span class="help-block">{t domain="adsense"}若为APP产品则为必填项{/t}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="device_code" value="{$device_code} "/>
						<input type="hidden" name="device_client" value="{$device_client}" />
						<input type="hidden" name="code" value="{$code}" />
						<button class="btn btn-gebo" type="submit">{t domain="mobile"}激活{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->