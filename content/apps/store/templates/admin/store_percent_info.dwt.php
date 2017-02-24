<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.commission.init();
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
					<label class="control-label">{t}奖励额度：{/t}</label>
					<div class="controls">
		 				<input type="text" name="percent_value" maxlength="60" value="{$percent.percent_value}" />&nbsp;%
		 				<label class="input-must">*</label>
					</div>	
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{t}排序：{/t}</label>
					<div  class="controls">
						<input type="text" name="sort_order" maxlength="60" value="{$percent.sort_order}"/>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" value="{t}确定{/t}" class="btn btn-gebo" />
						<input type="hidden" name="id" value="{$id}" />
					</div>
				</div>		
			</fieldset>
		</div>
	</div>
</form>
  
<!-- {/block} -->