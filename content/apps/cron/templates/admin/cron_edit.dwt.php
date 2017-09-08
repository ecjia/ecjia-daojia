<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cron.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $cron_config_file.lock_time}
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>系统插件内置执行时间暂不可修改。
</div>
{/if}
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	    <!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax"  id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{t}{$action_link.text}{/t}</a>
	    <!-- {/if} -->
	</h3>
</div>
	
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" name="theForm" data-edit-url="{RC_Uri::url('cron/admin_plugin/edit')}" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group formSep">
					<label for="cron_name" class="control-label">{lang key='cron::cron.label_cron_name'}</label>
					<div class="controls">
						<input id="cron_name" name="cron_name" type="text" value="{$cron.cron_name|escape}" size="40" />
					</div>
				</div>
				<div class="control-group formSep">
					<label for="cron_desc" class="control-label">{lang key='cron::cron.label_cron_desc'}</label>
					<div class="controls">
						<textarea id="cron_desc" name="cron_desc" cols="10" rows="3" class="span8">{$cron.cron_desc|escape}</textarea>
					</div>
				</div>
				{if $cron.cron_config}
				<div class="control-group formSep">
					<!-- {foreach from=$cron.cron_config item=config} -->
						<label class="control-label">{$config.label}</label>
						<div class="controls">
                        	<!-- {if $config.type == "text"} -->
                            	<input name="cfg_value[]" type="text" value="{$config.value}" size="40" />
                        	<!-- {elseif $config.type == "textarea"} -->
                            	<textarea name="cfg_value[]" cols="80" rows="5">{$config.value}</textarea>
                            <!-- {elseif $config.type == "select"} -->
                            	<select name="cfg_value[]">
                            		<!-- {html_options options=$config.range selected=$config.value} -->
                            	</select>
                            <!-- {/if} -->
                            <input name="cfg_name[]" type="hidden" value="{$config.name}" />
                            <input name="cfg_type[]" type="hidden" value="{$config.type}" />
						</div>
					<!-- {/foreach} -->
				</div>
				{/if}
				
				<!-- 计划任务执行时间 -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='cron::cron.label_cron_time'}</label>
					<div class="controls">
						<div class="f_l">
							<select name="ttype" class="w110 remove_select" {if $cron_config_file.lock_time}disabled="true"{/if}>
								<option value="day" {if $cron.cronday gt 0}selected{/if}>{lang key='cron::cron.cron_month'}</option>
								<option value="week" {if $cron.cronweek gt 0}selected{/if}>{lang key='cron::cron.cron_week'}</option>
								<option value="unlimit" {if $cron.cronweek eq 0 && $cron.cronday eq 0}selected{/if}>{lang key='cron::cron.cron_unlimit'}</option>
							</select>
						</div>
							
						<div class="ttype_day f_l m_l5 {if $cron.cronday gt 0}ecjiaf-db{else}ecjiaf-dn{/if}">
							<select class="w100 remove_select" name="cron_day" id="cron_day" {if $cron_config_file.lock_time}disabled="true"{/if}> <!-- {html_options options=$days selected=$cron.cronday} --></select>
     		 			</div>
     		 				
     		 			<div class="ttype_week f_l m_l5 {if $cron.cronweek gt 0}ecjiaf-db{else}ecjiaf-dn{/if}">
     		 				<select class="w100 remove_select" name="cron_week" id="cron_week" {if $cron_config_file.lock_time}disabled="true"{/if}><!-- {html_options options=$week selected=$cron.cronweek} --></select>
     		 			</div>
     		 				
     		 			<div class="f_l m_l5">
     		 				<select class="w100 remove_select" name="cron_hour" {if $cron_config_file.lock_time}disabled="true"{/if}><!-- {html_options options=$hours selected=$cron.cronhour} --></select>
     		 			</div>
					</div>
				</div>
                    
           		<div class="control-group formSep">
					<label class="control-label">{lang key='cron::cron.label_cron_minute'}</label>
					<div class="controls">
						<div class="f_l">
     		 				<select class="w100 remove_select" name="select_cron_minute" {if $cron_config_file.lock_time}disabled="true"{/if}><!-- {html_options options=$minute selected=$cron.cronminute} --></select>
     		 			</div>
						<input class="remove_select" name="cron_minute" id="cron_minute" type="text" value="{$cron.cronminute}" size="40"  {if $cron_config_file.lock_time}disabled="true"{/if}/>
					    <div class="help-block">{lang key='cron::cron.notice_minute'}</div>
					</div>
				</div>
					
				<!-- 执行后关闭 -->
				<div class="control-group formSep">
                    <label class="control-label">{lang key='cron::cron.label_cron_run_once'}</label>
				    <div class="controls chk_radio">
				      	<input name="cron_run_once" type="checkbox" value="1" {$cron.autoclose} />
				    </div>
				</div>
					
				<!-- 显示高级选项-->
				<div class="control-group formSep">
                    <label class="control-label">{lang key='cron::cron.label_cron_advance'}</label>
					<div class="controls chk_radio">
				      	<input name="show_advance" type="checkbox" value="1" {if $cron.alow_files OR $cron.allow_ip}checked{/if}/>
				      	{lang key='cron::cron.cron_show_advance'}
				    </div>
				</div>
					
				<div class="control-group formSep advance">
                	<label class="control-label">{lang key='cron::cron.label_cron_allow_ip'}</label>
				    <div class="controls">
				      	<input name="allow_ip" type="text" value="{$cron.allow_ip}" size="40" />
					    <div class="help-block">{lang key='cron::cron.notice_alow_ip'}</div>
				    </div>
				</div>
				<!-- 允许执行页面 -->
				<div class="control-group formSep advance">
					<div class="control-label">{lang key='cron::cron.label_cron_advance'}</div>
					<div class="controls chk_radio">
						<!-- {foreach from=$app_lists key=key item=app} -->
						<div class="choose">
							<span>
								<input type="checkbox" name="alow_files[]" value="{$app.code}" id="{$app.code}" class="checkbox" {if $app.checked eq 1}checked{/if} />
	      						{$app.name}
	      					</span>
      					</div>
      					<!-- {foreachelse} -->
						<span class="l_h30">{lang key='cron::cron.no_page_allowed'}</span>
      					<!-- {/foreach} -->
      					<div class="clear"></div>
      					<div class="help-block">{lang key='cron::cron.notice_alow_files'}</div>
					</div>
				</div>
					
				<div class="control-group">
					<div class="controls">
					  	<input type="hidden" name="cron_id" value="{$cron.cron_id}" />
				      	<input type="hidden" name="step" value="2" />
				      	<input type="hidden" name="cron_code" value="{$cron.cron_code}" />
				      	<input class="btn btn-gebo" type="submit" value="{lang key='system::system.button_submit'}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>   
<!-- {/block} -->