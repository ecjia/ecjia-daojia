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
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}二维码类型：{/t}</label>
								<div class="col-lg-8 controls">
									<select name="type" class="select2 form-control">
										<option value="0">{t domain="wechat"}临时二维码{/t}</option>
										<option value="1">{t domain="wechat"}永久二维码{/t}</option>
									</select>
								</div>
							</div>
						
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}应用场景值：{/t}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="scene_id" id="scene_id" class="form-control"/>
									<div class="help-block">{t domain="wechat"}整型：临时二维码时为32位非0整型（100001-4294967295），永久二维码时最大值为100000（目前参数只支持1--100000）。<br>字符串类型：场景值ID（字符串形式的ID），长度限制为1到64{/t}</div>
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}有效时间：{/t}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="expire_seconds" id="expire_seconds" class="form-control"/>
									<div class="help-block">{t domain="wechat"}该二维码有效时间，以天为单位。 最大不超过30天，此字段如果不填，则默认有效期为30秒。{/t}</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}功能关键词：{/t}</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="keywords_0" name="keywords" checked value="0" /><label for="keywords_0">{t domain="wechat"}选择关键词{/t}</label>
									<input type="radio" id="keywords_1" name="keywords" value="1" /><label for="keywords_1">{t domain="wechat"}自定义关键词{/t}</label>
								</div>
							</div>
							
							<div class="form-group row" id="choose_function">
								<label class="col-lg-2 label-control text-right"></label>
								<div class="col-lg-8 controls">
									<select class="select2 form-control" id="functions" name="functions">
										<option value="">{t domain="wechat"}请选择关键词...{/t}</option>
								   		<!-- {foreach from=$key_list key=key item=val} -->
										<optgroup label="{$key}">
											<!-- {foreach from=$val item=v} -->
											<option value="{$v}">{$v}</option>
											<!-- {/foreach} -->
										</optgroup>
										<!-- {/foreach} -->
									</select>
									<div class="help-block">{t domain="wechat"}该二维码的功能关键词{/t}</div>
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row d-none" id="input_function">
								<label class="col-lg-2 label-control text-right"></label>
								<div class="col-lg-8 controls">
									<input type="text" name="" id="function" class="form-control"/>
									<div class="help-block">{t domain="wechat"}该二维码的功能关键词{/t}</div>
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}排序：{/t}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="sort" id="sort" class="form-control"/>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}状态：{/t}</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="status_0" name="status" value="1" checked><label for="status_0">{t domain="wechat"}启用{/t}</label>
									<input type="radio" id="status_1" name="status" value="0" ><label for="status_1">{t domain="wechat"}禁用{/t}</label>
								</div>
							</div>
							
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="default_type" value="{$default_type}" />
						{if $errormsg || ($type_error && $type neq 2)}
						<input type="submit" name="submit" value='{t domain="wechat"}确定{/t}' class="btn btn-outline-primary" disabled="disabled" />
						{else}
						<input type="submit" name="submit" value='{t domain="wechat"}确定{/t}' class="btn btn-outline-primary" />
						{/if}
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->