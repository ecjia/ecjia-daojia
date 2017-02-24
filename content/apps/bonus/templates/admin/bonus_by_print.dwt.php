<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.bonus.send_by_print_init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form method="post" class="form-horizontal" action="{$form_action}" name="bonus_thePrintForm" data-pjax-url="{RC_Uri::url('bonus/admin/bonus_list')}" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='bonus::bonus.bonus_type_id'}</label>
					<div class="controls">
						<select name="bonus_type_id">
							<!-- {html_options options=$type_list selected=$smarty.get.id} -->
						</select>
					</div>
				</div>    
				<div class="control-group formSep">    
					<label class="control-label">{lang key='bonus::bonus.send_bonus_count'}</label>
					<div class="controls">
						<input type="text" name="bonus_sum" size="30" maxlength="6" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="type_id" value="{$bonus_arr.type_id}" />  	
					</div>
				</div>    
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->