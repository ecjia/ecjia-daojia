<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.adsense_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- 面包导航 -->
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
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
				<fieldset>
			  		<div class="control-group formSep">
			        	<label class="control-label">{lang key='adsense::adsense.outside_address'}</label>
			          	<div class="controls">
			            	<input type="text" name="outside_address" size="30" />
			            	<span class="input-must">{lang key='system::system.require_field'}</span>
			            </div>
			        </div>				
			  		<div class="control-group formSep">
			        	<label class="control-label">{lang key='adsense::adsense.label_charset'}</label>
			          	<div class="controls">
			            	<select name="charset" id="charset">
					        <!-- {html_options options=$lang_list} -->
					      	</select>
			            </div>
			        </div>	
			  		<div class="control-group">
			          	<div class="controls">
			          		<div>
			            		<input type="button" name="gen_code" data-jsurl="{$url}" value="{lang key='adsense::adsense.add_js_code_btn'}"  class="btn btn-gebo" />
			            	</div>
			            </div>
			        </div>	
			        <div class="control-group">
		            	<div>
		            		<textarea name="ads_js" cols="70" rows="6" class="span12">{$js_code}</textarea>
		            	</div>
			        </div>			        				
				</fieldset>
		 	</form>
		</div>
	</div>
</div>
<!-- {/block} -->