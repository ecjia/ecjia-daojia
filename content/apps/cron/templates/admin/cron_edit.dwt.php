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
	<strong>{t domain="cron"}温馨提示：{/t}</strong>{t domain="cron"}系统插件内置执行时间暂不可修改。{/t}
</div>
{/if}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	    <!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax"  id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{t domain="cron"}{$action_link.text}{/t}</a>
	    <!-- {/if} -->
	</h3>
</div>
	
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" name="theForm" action="{RC_Uri::url('cron/admin_plugin/update')}" method="post" >
			<fieldset>
				<div class="control-group formSep">
					<label for="cron_name" class="control-label">{t domain="cron"}计划任务名称：{/t}</label>
					<div class="controls">
						<input id="cron_name" name="cron_name" type="text" value="{$cron.cron_name}" size="40" />
					</div>
				</div>
				<div class="control-group formSep">
					<label for="cron_desc" class="control-label">{t domain="cron"}计划任务描述：{/t}</label>
					<div class="controls">
						<textarea id="cron_desc" name="cron_desc" cols="10" rows="3" class="span8">{$cron.cron_desc}</textarea>
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
                            {if $config.desc}
    						<span class="help-block">{$config.desc}</span>
    						{/if}
						</div>
					<!-- {/foreach} -->
				</div>
				{/if}

				<!-- 计划任务重构时间start -->
				{if $cron_config_file.lock_time}
					<div class="control-group formSep">
						<label class="control-label">{t domain="cron"}执行时间：{/t}</label>
						<div class="controls">
							<div class="f_l">
	     		 				<select class="w220" id="select_cron_config" name="select_cron_config" disabled="disabled">
	     		 					<option value='0'>{t domain="cron"}请选择配置时间{/t}</option>
	     		 					<!-- {foreach from=$config_list key=key item=val} -->
										<option value="{$key}" {if $key eq $cron.expression_alias}selected="selected"{/if}>{$val}</option>
									<!-- {/foreach} -->
	     		 					<option value='cron' {if $cron.expression_alias eq 'cron'} selected="true" {/if}>{t domain="cron"}自定义调度任务{/t}</option>
									<option value='manual' {if $cron.expression_alias eq 'manual'} selected="true" {/if}>{t domain="cron"}手动输入表达式{/t}</option>
	     		 				</select>
	     		 			</div>
	     		 			
							<input type="text" name="cron_tab" value="{$cron.cron_expression}" readonly="readonly" />
						
							<span class="test_cron">
								<button class="btn btn-gebo m_l5" id="test" type="button" >{t domain="cron"}进行检测{/t}</button>
							</span>
							<span class="help-block cron-five">
							</span>
						</div>
					</div>
				{else}
					<div class="control-group formSep">
						<label class="control-label">{t domain="cron"}执行时间：{/t}</label>
						<div class="controls">
							<div class="f_l">
	     		 				<select class="w220" id="select_cron_config" name="select_cron_config" >
	     		 					<option value='0'>{t domain="cron"}请选择配置时间{/t}</option>
	     		 					<!-- {foreach from=$config_list key=key item=val} -->
										<option value="{$key}" {if $key eq $cron.expression_alias}selected="selected"{/if}>{$val}</option>
									<!-- {/foreach} -->
	     		 					<option value='cron' {if $cron.expression_alias eq 'cron'} selected="true" {/if}>{t domain="cron"}自定义调度任务{/t}</option>
									<option value='manual' {if $cron.expression_alias eq 'manual'} selected="true" {/if}>{t domain="cron"}手动输入表达式{/t}</option>
	     		 				</select>
	     		 			</div>
	     		 			
							<input type="text" name="config_time" id="config_time" type="text" value="{$cron.cron_expression}" {if $cron.expression_alias eq 'cron'}style="display:none"{elseif $cron.expression_alias neq 'manual'}readonly="readonly" {/if}/>
							
							<div class="cron_ordinary" {if $cron.expression_alias neq 'cron'}style="display: none;"{/if}>
								<input id="cron_tab" name="cron_tab" type="text" class="form-control" value="{$cron.cron_expression}" /> 
							</div>
							
							<span class="test_cron">
								<button class="btn btn-gebo m_l5" id="test" type="button" >{t domain="cron"}进行检测{/t}</button>
							</span>
							<span class="help-block cron-five">
							</span>
						</div>
					</div>
				{/if}
				
				<!-- 计划任务重构时间end -->


				
				<!-- 执行后关闭 -->
				<div class="control-group formSep">
                    <label class="control-label">{t domain="cron"}执行后关闭：{/t}</label>
				    <div class="controls chk_radio">
				      	<input name="cron_run_once" type="checkbox" value="1" {$cron.autoclose} />
				    </div>
				</div>
					
				<!-- 显示高级选项-->
				<div class="control-group formSep">
                    <label class="control-label">{t domain="cron"}高级选项：{/t}</label>
					<div class="controls chk_radio">
				      	<input name="show_advance" type="checkbox" value="1" {if $cron.allow_ip}checked{/if}/>
				      	{t domain="cron"}显示高级选项{/t}
				    </div>
				</div>
					
				<div class="control-group formSep advance">
                	<label class="control-label">{t domain="cron"}允许执行的服务器IP：{/t}</label>
				    <div class="controls">
				      	<input name="allow_ip" type="text" value="{$cron.allow_ip}" size="40" />
					    <div class="help-block">{t domain="cron"}允许运行计划任务服务器的IP，请用半角逗号分隔多个IP，留空即表示所执行的服务器IP不受限制{/t}</div>
				    </div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<input type="hidden" value="{url path='cron/admin_plugin/ajax_law'}" id="data-href-law"/>
						<input type="hidden" value="{url path='cron/admin_plugin/ajax_five'}" id="data-href-five"/>
					  	<input type="hidden" name="cron_id" value="{$cron.cron_id}" />
				      	<input type="hidden" name="cron_code" value="{$cron.cron_code}" />
				      	<input class="btn btn-gebo" type="submit" value='{t domain="cron"}确定{/t}' />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>   
<!-- {/block} -->