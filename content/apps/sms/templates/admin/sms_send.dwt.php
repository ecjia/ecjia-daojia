<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} 
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post"  name="theForm">
			<div class="control-group formSep">
				<label class="control-label">{lang key='sms::sms.label_user_rank'}</label>
				<div class="controls">
					<select name="send_rank">
			        <option value='0'>{lang key='sms::sms.select_user_rank'}</option>
			          <!-- {html_options options=$send_rank} -->
			        </select>
				</div>
			</div>
			
			<div class="control-group formSep">
				<label class="control-label">{lang key='sms::sms.label_send_num'}</label>
				<div class="controls">
					<input type="text" name="send_num"  size="35" class="span8"/>
					<span class="input-must">{lang key='system::system.require_field'}</span>
					<br><span class="help-block">{lang key='sms::sms.send_num_notice'}</span>
				</div>
			</div>
							
			<div class="control-group formSep">
	        	<label class="control-label">{lang key='sms::sms.label_msg'}</label>
	          	<div class="controls">
	            	<textarea name="msg" cols="55" rows="6" class="span8"></textarea>
	            	<span class="input-must">{lang key='system::system.require_field'}</span>
	            </div>
	        </div>	
			
			<div class="control-group">
	        	<div class="controls">
		        	<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
			    </div>
	        </div>	    
		</form>
	</div>
</div>
<!-- {/block} -->
