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
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
<!-- {/if} -->		
		
<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
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
									<label class="col-lg-2 label-control text-right">{t domain="market"}活动名称：{/t}</label>
									<div class="col-lg-8 controls">
										{$activity_info.activity_name}
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="market"}活动方式：{/t}</label>
									<div class="col-lg-8 controls">
										{$activity_info.activity_group}
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="market"}活动参与平台：{/t}</label>
									<div class="col-lg-8 controls">
					                    <span>{$activity_info.activity_object}</span>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}活动限制次数：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="limit_num" type="text" value="{$activity_info.limit_num|default:0}" maxlength="4"/>
									<span class="help-block">{t domain="market"}每人可参与活动的次数，0表示不限制{/t}</span>
								</div>
							</div>
	
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}活动限制时间：{/t}</label>
								<div class="col-lg-8 controls">
									<select name="limit_time" class=" select2 form-control" >
										<option value="">{t domain="market"}请选择...{/t}</option>
										<option value="0" {if $activity_info.limit_time eq '0'}selected{/if}>{t domain="market"}无限制{/t}</option>
										<option value="1" {if $activity_info.limit_time eq 1}selected{/if}>{t domain="market"}1小时{/t}</option>
										<option value="6" {if $activity_info.limit_time eq 6}selected{/if}>{t domain="market"}6小时{/t}</option>
										<option value="12" {if $activity_info.limit_time eq 12}selected{/if}>{t domain="market"}12小时{/t}</option>
										<option value="24" {if $activity_info.limit_time eq 24}selected{/if}>{t domain="market"}24小时{/t}</option>
										<option value="48" {if $activity_info.limit_time eq 48}selected{/if}>{t domain="market"}48小时{/t}</option>
									</select>
									<span class="help-block">{t domain="market"}规则描述：{/t}</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}开始时间：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="time input-xlarge form-control" name="start_time" type="text" value="{$activity_info.start_time}" />
								</div>
								<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}结束时间：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="time input-xlarge form-control" name="end_time" type="text" value="{$activity_info.end_time}"/>
								</div>
								<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}规则描述：{/t}</label>
								<div class="col-lg-8 controls">
									<textarea class="m_t10 span12 form-control" name="activity_desc" cols="40" rows="3">{$activity_info.activity_desc}</textarea>
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="id" value="{$activity_info.activity_id}" />
						<input type="hidden" name="activity_code" value="{$activity_info.activity_group}" />
						<input type="submit" class="btn btn-outline-primary" value='{t domain="market"}更新{/t}' />
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->