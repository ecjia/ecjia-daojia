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
						<label class="control-label">{lang key='market::market.label_activity_name'}</label>
						<div class="controls l_h30">
							{$activity_info.activity_name}
						</div>
					</div>
					<div class="control-group " >
						<label class="control-label">{lang key='market::market.label_activity_way'}</label>
					     <div class="controls l_h30">
	                           {$activity_info.activity_group}
	                     </div>
					</div>
					<div class="control-group ">
	                    <label class="control-label">{lang key='market::market.join_platform'}</label>
	                    <div class="controls l_h30">
		                    <span>{$activity_info.activity_object}</span>
	                    </div>
	                </div>
                
                </div>
                <div class="control-group formSep">
					<label class="control-label">{lang key='market::market.label_activity_restrict_num'}</label>
					<div class="controls">
						<input class="" name="limit_num" type="text" value="{$activity_info.limit_num|default:0}" maxlength="4"/>
						<span class="help-block">{lang key='market::market.restrict_num_tips'}</span>
					</div>
				</div>
								
				<div class="control-group formSep">
					<label class="control-label">{lang key='market::market.label_activity_time_restrict'}</label>
					<div class="controls">
						<select name='limit_time'>
							<option value="">请选择...</option>
							<option value="0" {if $activity_info.limit_time eq '0'}selected{/if}>0</option>
							<option value="1" {if $activity_info.limit_time eq 1}selected{/if}>1小时</option>
							<option value="6" {if $activity_info.limit_time eq 6}selected{/if}>6小时</option>
							<option value="12" {if $activity_info.limit_time eq 12}selected{/if}>12小时</option>
							<option value="24" {if $activity_info.limit_time eq 24}selected{/if}>24小时</option>
							<option value="48" {if $activity_info.limit_time eq 48}selected{/if}>48小时</option>
						</select>	
						<span class="help-block">{lang key='market::market.time_restrict_tips'}</span>					
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{lang key='market::market.label_start_date'}</label>
					<div class="controls">
						<input class="time" name="start_time" type="text" value="{$activity_info.start_time}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='market::market.label_end_date'}</label>
					<div class="controls">
						<input class="time" name="end_time" type="text" value="{$activity_info.end_time}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='market::market.label_rule_desc'}</label>
					<div class="controls">
						<textarea class="span8" name="activity_desc" cols="40" rows="3">{$activity_info.activity_desc}</textarea>
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="{$activity_info.activity_id}" />
						<input type="hidden" name="activity_code" value="{$activity_info.activity_group}" />
						<input type="submit" class="btn btn-gebo" value="{lang key='market::market.update'}" />
					</div>
				</div>
			</fieldset>
		</form>
	  </div>
	</div>
</div>
<!-- {/block} -->