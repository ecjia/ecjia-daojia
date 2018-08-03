<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_qrcode_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-dismissible mb-2 alert-danger">
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
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_qrcode_type'}</label>
								<div class="col-lg-8 controls">
									<select name="type" class="select2 form-control">
										<option value="0">{lang key='wechat::wechat.qrcode_short'}</option>
										<option value="1">{lang key='wechat::wechat.qrcode_forever'}</option>
									</select>
								</div>
							</div>
						
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_scene_id'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="scene_id" id="scene_id" class="form-control"/>
									<div class="help-block">{lang key='wechat::wechat.scene_id_help'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_expire_seconds'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="expire_seconds" id="expire_seconds" class="form-control"/>
									<div class="help-block">该二维码有效时间，以天为单位。 最大不超过30天，此字段如果不填，则默认有效期为30秒。</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">功能关键词：</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="keywords_0" name="keywords" checked value="0" /><label for="keywords_0">选择关键词</label>
									<input type="radio" id="keywords_1" name="keywords" value="1" /><label for="keywords_1">自定义关键词</label>
								</div>
							</div>
							
							<div class="form-group row" id="choose_function">
								<label class="col-lg-2 label-control text-right"></label>
								<div class="col-lg-8 controls">
									<select class="select2 form-control" id="functions" name="functions">
										<option value="">请选择关键词...</option>
								   		<!-- {foreach from=$key_list key=key item=val} -->
										<optgroup label="{$key}">
											<!-- {foreach from=$val item=v} -->
											<option value="{$v}">{$v}</option>
											<!-- {/foreach} -->
										</optgroup>
										<!-- {/foreach} -->
									</select>
									<div class="help-block">该二维码的功能关键词</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row d-none" id="input_function">
								<label class="col-lg-2 label-control text-right"></label>
								<div class="col-lg-8 controls">
									<input type="text" name="" id="function" class="form-control"/>
									<div class="help-block">该二维码的功能关键词</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="sort" id="sort" class="form-control"/>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_status'}</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="status_0" name="status" value="1" checked><label for="status_0">{lang key='wechat::wechat.enable'}</label>
									<input type="radio" id="status_1" name="status" value="0" ><label for="status_1">{lang key='wechat::wechat.disable'}</label>
								</div>
							</div>
							
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="default_type" value="{$default_type}" />
						{if $errormsg || ($type_error && $type neq 2)}
						<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-outline-primary" disabled="disabled" />	
						{else}
						<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-outline-primary" />	
						{/if}
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->