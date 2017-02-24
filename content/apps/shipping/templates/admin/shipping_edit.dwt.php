<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.shopping_admin.editFormSubmit();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a  href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form id="form-privilege"  class="form-horizontal"  name="editForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='shipping::shipping.shipping_name_lable'}</label>
					<div class="controls">
						<input class="w350" name="shipping_name" type="text" id="shipping_name" value="{$shipping.shipping_name|escape}" size="40" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='shipping::shipping.shipping_desc_lable'}</label>
					<div class="controls">
						<textarea class="w350" id="shipping_desc" name="shipping_desc"  cols="10" rows="6">{$shipping.shipping_desc|escape}</textarea>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- 保价费用-->
				<div class="control-group formSep">
					<label  class="control-label">{lang key='shipping::shipping.insure_lable'}</label>
					<div class="controls">
						<label class="p_t5">{if $shipping.insure}{$shipping.insure}{else}{lang key='shipping::shipping.not_support'}{/if}</label>
					</div>
				</div>
				<!-- 货到付款-->
				<div class="control-group formSep">
					<label  class="control-label">{lang key='shipping::shipping.support_cod_label'}</label>
					<div class="controls">
						<label class="p_t5">{if $shipping.support_cod == "1"}{lang key='system::system.yes'}{else}{lang key='system::system.no'}{/if}</label>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="shipping_id" value="{$shipping.shipping_id}" />
						<input type="hidden" name="shipping_code" value="{$shipping.shipping_code}" />
						<input type="hidden" name="is_cod" value="{$shipping.is_cod}" />
						<input type="hidden" name="support_cod" value="{$shipping.support_cod}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->