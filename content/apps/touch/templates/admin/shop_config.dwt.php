<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_shop_config.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- 商店设置 -->
<form class="form-horizontal" action="{$form_action}" name="theForm" method="post" enctype="multipart/form-data">
	<!-- {foreach from=$group_list item=group name="bar_group"} -->
	<div class="row-fluid edit-page" id="{$group.code}">
		<div class="span12">
			<h3 class="heading">{$group.name}</h3>
			<div class="row-fluid">
				<div class="span12">
					<fieldset>
						<!-- {foreach from=$group.vars item=var key=key} -->
						<!-- #BeginLibraryItem "/library/shop_config_form.lbi" --><!-- #EndLibraryItem -->
						<!-- {/foreach} -->
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>&nbsp;&nbsp;&nbsp;
								<button class="btn" type="reset">{t}重置{/t}</button>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
	<!-- {/foreach} -->
</form>
<!-- 商店设置结束 -->
<!-- {/block} -->