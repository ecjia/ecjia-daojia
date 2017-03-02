<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.wechat_qrcodeshare_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<!-- {if $warn} -->
	<!-- {if $type neq 2} -->
		<div class="alert alert-error">
			<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
		</div>
	<!-- {/if} -->
<!-- {/if} -->	

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}
	
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
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
				<div class="tab-content">
					<fieldset>
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_recommended_person'}</label>
							<div class="controls">
								<input type="text" name="username" id="username"  />
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_recommended_id'}</label>
							<div class="controls">
								<input type="text" name="scene_id" id="scene_id"  />
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_expire_seconds'}</label>
							<div class="controls">
								<input type="text" name="expire_seconds" id="expire_seconds"  />
								<span class="help-block">{lang key='wechat::wechat.label_expire_seconds_help'}</span>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_functions'}</label>
							<div class="controls">
								<input type="text" name="functions" id="function" />
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						
						<div class="control-group formSep" >
							<label class="control-label">{lang key='wechat::wechat.label_sort'}</label>		
							<div class="controls">
								<input type="text" name="sort" id="sort"  />
							</div>
						</div>
						
						<div class="control-group">
        					<div class="controls">
        						{if $errormsg || ($type_error && $type neq 2)}
								<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" disabled="disabled" />	
								{else}
								<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" />	
								{/if}
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->