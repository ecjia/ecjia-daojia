<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.ad_position_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
	  	<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data">
		    <fieldset>
		  		<div class="control-group formSep">
		        	<label class="control-label">{lang key='adsense::adsense.position_name_lable'}</label>
		          	<div class="controls">
		            	<input type="text" name="position_name" value="{$posit_arr.position_name}" size="30" class="span4" />
		            	<span class="input-must">{lang key='system::system.require_field'}</span>
		            </div>
		        </div>
		  		<div class="control-group formSep">
		        	<label class="control-label">{lang key='adsense::adsense.ad_width_lable'}</label>
		          	<div class="controls">
		            	<input type="text" name="ad_width" value="{$posit_arr.ad_width}" size="30" class="span4" /><span class="input-must">{lang key='system::system.require_field'}</span>{lang key='adsense::adsense.unit_px'}
		            </div>
		        </div>
		  		<div class="control-group formSep">
		        	<label class="control-label">{lang key='adsense::adsense.ad_height_lable'}</label>
		          	<div class="controls">
		            	<input type="text" name="ad_height" value="{$posit_arr.ad_height}" size="30" class="span4" /><span class="input-must">{lang key='system::system.require_field'}</span>{lang key='adsense::adsense.unit_px'}
		            	
		            </div>
		        </div>
		        <div class="control-group formSep">
		        	<label class="control-label">{lang key='adsense::adsense.position_desc_lable'}</label>
		          	<div class="controls">
		            	<textarea name="position_desc" cols="55" rows="6" class="span4">{$posit_arr.position_desc}</textarea>
		            </div>
		        </div>	
		  		<div class="control-group formSep">
		        	<label class="control-label">{lang key='adsense::adsense.posit_style'}</label>
		          	<div class="controls">
		            	<textarea name="position_style" cols="55" rows="6" class="span4">{$posit_arr.position_style}</textarea>
		            </div>
		        </div>	
		        <div class="control-group">
		        	<div class="controls">
			        	<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				        <input type="hidden" name="id" value="{$posit_arr.position_id}" />
				    </div>
		        </div>	        
		    </fieldset>
	  	</form>
	</div>
</div>
<!-- {/block} -->