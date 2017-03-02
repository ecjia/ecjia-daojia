<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.affiliate.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>	
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
				<i class="fontello-icon-reply"></i>{$action_link.text}
			</a>
		<!-- {/if} -->	
	</h3>
</div>

<form class="form-horizontal" method="post" action='{$form_action}' name="percent_form">
	<div class="row-fluid">
		<div class="span12">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='affiliate::affiliate.label_levels'}</label>
					<div class="controls p_t5">
		 				<span>{$level}</span>
					</div>	
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='affiliate::affiliate.label_level_point'}</label>
					<div class="controls">
		 				<input type="text" name="level_point" value="{$affiliate_percent.level_point}" />&nbsp;%
		 				<label class="input-must">*</label>
					</div>	
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='affiliate::affiliate.label_level_money'}</label>
					<div class="controls">
		 				<input type="text" name="level_money" value="{$affiliate_percent.level_money}" />&nbsp;%
		 				<label class="input-must">*</label>
					</div>	
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" value="{t}确定{/t}" class="btn btn-gebo" />
						<input type="hidden" name="id" value="{$level}" />
					</div>
				</div>		
			</fieldset>
		</div>
	</div>
</form>
<!-- {/block} -->