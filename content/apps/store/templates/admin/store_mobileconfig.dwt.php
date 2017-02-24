<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_mobileconfig.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group formSep edit-page">
					<label class="control-label">{t}店铺街首页头部广告：{/t}</label>
					<div class="controls">
						<select name='mobile_store_home_adsense'>
							<option value='0'>{t}请选择...{/t}</option>
							<!-- {foreach from=$ad_position_list item=list} -->
								<option value="{$list.position_id}" {if $list.position_id eq $mobile_store_home_adsense}selected{/if}>{$list.position_name}</option>
							<!-- {/foreach} -->
						</select>
						<span class="help-block">{t}请选择所需展示的广告位。{/t}</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<input type="submit" value="确定" class="btn btn-gebo" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<!-- {/block} -->