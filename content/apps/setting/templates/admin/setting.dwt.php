<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_shop_config.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span3">
		<!-- {ecjia:hook id=admin_shop_config_nav arg=$current_code} -->
	</div>
	<div class="span9">
        <!-- {block name="admin_config_form"} -->
		<form class="form-horizontal" action="{$form_action}" name="theForm" method="post" enctype="multipart/form-data">
			
			<div class="row-fluid edit-page">
				<h3 class="heading">{$group.name}</h3>
				<div class="row-fluid">
					<fieldset>
						<!-- {foreach from=$item_list item=var key=key} -->
						<!-- {if $var.type eq "manual"} -->
						<!-- {ecjia:hook id=config_form_|cat:$var.code arg=$var} -->
						<!-- {else} -->
						<!-- #BeginLibraryItem "/library/setting_form.lbi" --><!-- #EndLibraryItem -->
						<!-- {/if} -->
						<!-- {/foreach} -->
						<div class="control-group">
							<div class="controls">
                                <input name="code" type="hidden" value="{$group.code}"  />
								<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>&nbsp;&nbsp;&nbsp;
								<button class="btn" type="reset">{t}重置{/t}</button>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</form>
		<!-- {/block} -->
	</div>
</div>
<!-- {/block} -->