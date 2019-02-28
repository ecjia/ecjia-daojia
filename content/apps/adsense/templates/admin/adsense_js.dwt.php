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
			        	<label class="control-label">{t domain="adsense"}投放广告的站点名称：{/t}</label>
			          	<div class="controls">
			            	<input type="text" name="outside_address" size="30" />
			            	<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
			            </div>
			        </div>				
			  		<div class="control-group formSep">
			        	<label class="control-label">{t domain="adsense"}选择编码：{/t}</label>
			          	<div class="controls">
			            	<select name="charset" id="charset">
					        <!-- {html_options options=$lang_list} -->
					      	</select>
			            </div>
			        </div>	
			  		<div class="control-group">
			          	<div class="controls">
			          		<div>
			            		<input type="button" name="gen_code" data-jsurl="{$url}" value='{t domain="adsense"}生成并复制JS代码{/t}'  class="btn btn-gebo" />
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