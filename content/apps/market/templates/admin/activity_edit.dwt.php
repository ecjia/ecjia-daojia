<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.activity.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
	    <div class="tabbable">
	  		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				
                <div class="cannotedit-info">
	                <div class="control-group ">
						<label class="control-label">{t domain="market"}活动名称：{/t}</label>
						<div class="controls l_h30">
							{$activity_info.activity_name}
						</div>
					</div>
					<div class="control-group " >
						<label class="control-label">{t domain="market"}活动方式：{/t}</label>
					     <div class="controls l_h30">
	                           {$activity_info.activity_group}
	                     </div>
					</div>
					<div class="control-group ">
	                    <label class="control-label">{t domain="market"}活动参与平台：{/t}</label>
	                    <div class="controls l_h30">
		                    <span>{$activity_info.activity_object}</span>
	                    </div>
	                </div>
                
                </div>
                <div class="control-group formSep">
					<label class="control-label">{t domain="market"}活动限制次数：{/t}</label>
					<div class="controls">
						<input class="" name="limit_num" type="text" value="{$activity_info.limit_num|default:0}" maxlength="4"/>
						<span class="help-block">{t domain="market"}每人可参与活动的次数，0表示不限制{/t}</span>
					</div>
				</div>
								
				<div class="control-group formSep">
					<label class="control-label">{t domain="market"}活动时间限制：{/t}</label>
					<div class="controls">
						<select name='limit_time'>
							<option value="">{t domain="market"}请选择...{/t}</option>
							<option value="0" {if $activity_info.limit_time eq '0'}selected{/if}>0</option>
							<option value="1" {if $activity_info.limit_time eq 1}selected{/if}>{t domain="market"}1小时{/t}</option>
							<option value="6" {if $activity_info.limit_time eq 6}selected{/if}>{t domain="market"}6小时{/t}</option>
							<option value="12" {if $activity_info.limit_time eq 12}selected{/if}>{t domain="market"}12小时{/t}</option>
							<option value="24" {if $activity_info.limit_time eq 24}selected{/if}>{t domain="market"}24小时{/t}</option>
							<option value="48" {if $activity_info.limit_time eq 48}selected{/if}>{t domain="market"}48小时{/t}</option>
						</select>	
						<span class="help-block">{t domain="market"}单位为小时，参与次数在此时间内将被限制，0代表整个活动时间内{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="market"}开始时间：{/t}</label>
					<div class="controls">
						<input class="time" name="start_time" type="text" value="{$activity_info.start_time}" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="market"}结束时间：{/t}</label>
					<div class="controls">
						<input class="time" name="end_time" type="text" value="{$activity_info.end_time}"/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{t domain="market"}规则描述：{/t}</label>
					<div class="controls">
						<textarea class="span8" name="activity_desc" cols="40" rows="3">{$activity_info.activity_desc}</textarea>
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="{$activity_info.activity_id}" />
						<input type="hidden" name="activity_code" value="{$activity_info.activity_group}" />
						<input type="submit" class="btn btn-gebo" value='{t domain="market"}更新{/t}' />
					</div>
				</div>
			</fieldset>
		</form>
	  </div>
	</div>
</div>
<!-- {/block} -->