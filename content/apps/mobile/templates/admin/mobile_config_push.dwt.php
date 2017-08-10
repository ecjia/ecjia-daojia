<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.mobile_config.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href='javascript:;'>推送配置</a></li>
			<li><a class="data-pjax" href='{url path="mobile/admin_mobile_config/config_pay" args="code={$code}&app_id={$app_id}"}'>支付配置</a></li>
		</ul>
		
		<div class="tab-content">
			<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post"  >
				<fieldset>
					<h3 class="heading">APP推送</h3>
					
					<div class="control-group formSep">
						<label class="control-label">推送环境：</label>
						<div class="controls">
							 <input type="radio" name="push_umeng[environment]" value="develop" checked="true"{if $data.option_value.environment eq 'develop'} checked="true" {/if} />开发环境
				        	 <input type="radio" name="push_umeng[environment]" value="online" {if $data.option_value.environment eq 'online'} checked="true" {/if} />生产环境
				        	 <span class="help-block">App上线运行请务必切换置生产环境</span>
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">App Key：</label>
						<div class="controls">
							<input class="span4" name="push_umeng[app_key]" type="text" value="{$data.option_value.app_key}" />
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">App Secret：</label>
						<div class="controls">
							<input class="span4" name="push_umeng[app_secret]" type="text" value="{$data.option_value.app_secret}" />
							<span class="input-must">{lang key='system::system.require_field'}</span> 
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls">
						<input type="hidden" name="app_id"   value="{$app_id}">
						<input type="hidden" name="code" value="{$code}">
							<button class="btn btn-gebo" type="submit">确定</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	</div>
</div>
<!-- {/block} -->