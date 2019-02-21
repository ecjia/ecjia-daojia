<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
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
<div class="row-fluid edit-page">
	<div class="span12">
		<form id="form-privilege" class="form-horizontal" name="editForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="control-group formSep" >
					<label class="control-label">{t domain="platform"}名称：{/t}</label>
					<div class="controls l_h30">
						<input class="w350" type="text" name="ext_name" value="{$bd.ext_name}" />
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="platform"}描述：{/t}</label>
					<div class="controls">
						<textarea class="w350" id="ext_desc" name="ext_desc" cols="10" rows="6">{$bd.ext_desc}</textarea>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="platform"}更新{/t}</button>
						<input type="hidden" name="ext_id" value="{$bd.ext_id}" />
						<input type="hidden" name="ext_code" value="{$bd.ext_code}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->