<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_config.init();
</script>
<!-- {/block} -->

<!-- {block name="alert_info"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>{t}这里的后台设置仅限改善商家后台的显示效果。{/t}
</div>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
	<form class="form-horizontal"  name="theForm" action="{$form_action}" method="post"  enctype="multipart/form-data" >
		<div class="span12">
			<h3 class="heading">
				{if $ur_here}{$ur_here}{/if}
				{if $action_link}
				<a href="{$action_link.href}" class="btn data-pjax"  style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
				{/if}
			</h3>
    		<div class="control-group formSep">
    			<label class="control-label">{t}登录Logo：{/t}</label>
    			<div class="controls">
    				<div class="fileupload {if $config_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
    				<a tabindex="0" role="button" href="javascript:;" class="no-underline cursor_pointor" data-trigger="focus" data-toggle="popover" data-placement="top">	
    					<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
    						<img src="{$config_logoimg}" alt="{t}预览图片{/t}" />
    					</div>
    				</a>
    				<div class="hide" id="content_1"><img class="mh150" src="{$config_logoimg}"></div> 
    					<span class="btn btn-file">
    					<span class="fileupload-new">{t}浏览{/t}</span>
    					<span class="fileupload-exists">{t}修改{/t}</span>
    					<input type="file" name="merchant_admin_login_logo"/>
    					</span>
    					<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除该图片吗？{/t}" data-href="{RC_Uri::url('store/admin_config/del')}&type=logo" {if $config_logo}data-removefile="true"{/if}>{t}删除{/t}</a>
    					<span class="help-block">推荐尺寸：230*50px</span>
    				</div>
    			</div>
    		</div>
		    <h3 class="heading">
				定位设置
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t}定位范围：{/t}</label>
    			<div class="controls">
    				<select name="mobile_location_range">
    					<option value='0' {if $mobile_location_range eq '0'}selected="true"{/if}>全城</option>
    					<option value='3' {if $mobile_location_range eq '3'}selected="true"{/if}>约周边120公里</option>
    					<option value='4' {if $mobile_location_range eq '4'}selected="true"{/if}>约周边30公里</option>
    					<option value='5' {if $mobile_location_range eq '5'}selected="true"{/if}>约周边4公里</option>
    					<option value='6' {if $mobile_location_range eq '6'}selected="true"{/if}>约周边1公里</option>
    					<option value='7' {if $mobile_location_range eq '7'}selected="true"{/if}>约周边200米</option>
    				</select>
    			</div>
    		</div>
    		<div class="control-group">
				<div class="controls">
					<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->