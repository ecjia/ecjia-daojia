<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.platform_activity.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
<!-- {/if} -->		
		
<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							
							<div class="cannotedit-info">
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='market::market.label_activity_name'}</label>
									<div class="col-lg-8 controls">
										{$activity_info.activity_name}
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='market::market.label_activity_way'}</label>
									<div class="col-lg-8 controls">
										{$activity_info.activity_group}
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='market::market.join_platform'}</label>
									<div class="col-lg-8 controls">
					                    <span>{$activity_info.activity_object}</span>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='market::market.label_activity_restrict_num'}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="limit_num" type="text" value="{$activity_info.limit_num|default:0}" maxlength="4"/>
									<span class="help-block">{lang key='market::market.restrict_num_tips'}</span>
								</div>
							</div>
	
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">活动限制时间：</label>
								<div class="col-lg-8 controls">
									<select name="limit_time" class=" select2 form-control" >
										<option value="">请选择...</option>
										<option value="0" {if $activity_info.limit_time eq '0'}selected{/if}>无限制</option>
										<option value="1" {if $activity_info.limit_time eq 1}selected{/if}>1小时</option>
										<option value="6" {if $activity_info.limit_time eq 6}selected{/if}>6小时</option>
										<option value="12" {if $activity_info.limit_time eq 12}selected{/if}>12小时</option>
										<option value="24" {if $activity_info.limit_time eq 24}selected{/if}>24小时</option>
										<option value="48" {if $activity_info.limit_time eq 48}selected{/if}>48小时</option>
									</select>
									<span class="help-block">{lang key='market::market.time_restrict_tips'}</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='market::market.label_start_date'}</label>
								<div class="col-lg-8 controls">
									<input class="time input-xlarge form-control" name="start_time" type="text" value="{$activity_info.start_time}" />
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='market::market.label_end_date'}</label>
								<div class="col-lg-8 controls">
									<input class="time input-xlarge form-control" name="end_time" type="text" value="{$activity_info.end_time}"/>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='market::market.label_rule_desc'}</label>
								<div class="col-lg-8 controls">
									<textarea class="m_t10 span12 form-control" name="activity_desc" cols="40" rows="3">{$activity_info.activity_desc}</textarea>
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="id" value="{$activity_info.activity_id}" />
						<input type="hidden" name="activity_code" value="{$activity_info.activity_group}" />
						<input type="submit" class="btn btn-outline-primary" value="{lang key='market::market.update'}" />
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->