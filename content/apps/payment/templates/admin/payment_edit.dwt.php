<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.payment_list.submit();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $pay.enabled neq 1}
<div class="alert alert-error">
	<strong>温馨提示：</strong>该支付方式已经禁用，如果您需要使用，请点击<a class="switch" href="javascript:;" data-url='{RC_Uri::url("payment/admin/enable", "code={$pay.pay_code}&from=edit")}' title="{lang key='payment::payment.enable'}">启用</a>。
</div>
{/if}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a  href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form id="form-privilege"  class="form-horizontal"  name="editForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='payment::payment.label_payment_name'}</label>
					<div class="controls">
						<input class="w350" name="pay_name" type="text" id="pay_name" value="{$pay.pay_name|escape}" size="40" {if $pay.enabled neq 1}disabled{/if}/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='payment::payment.label_payment_desc'}</label>
					<div class="controls">
						<textarea class="w350" id="pay_desc" name="pay_desc" cols="10" rows="6" {if $pay.enabled neq 1}disabled{/if}>{$pay.pay_desc|escape}</textarea>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- {if $pay.enabled eq 1} -->
					<!-- {foreach from=$pay.pay_config item=config key=key} -->
					<div class="control-group formSep">
						<label class="control-label">{$config.label}</label>
						<div class="controls">
							<!-- {if $config.type == "text"} -->
							<input class="w350" id="cfg_value[]" name="cfg_value[]" type="{$config.type}" value="{$config.value}" size="40" />
							<!-- {elseif $config.type == "textarea"} -->
							<textarea class="w350" id="cfg_value[]" name="cfg_value[]" cols="80" rows="5">{$config.value}</textarea>
							<!-- {elseif $config.type == "select"} -->
							<select class="w350" id="cfg_value[]" name="cfg_value[]"  >
								<!-- {html_options options=$config.range selected=$config.value} -->
							</select>
							<!-- {/if} -->
							<input name="cfg_name[]" type="hidden" value="{$config.name}" />
							<input name="cfg_type[]" type="hidden" value="{$config.type}" />
							<input name="cfg_lang[]" type="hidden" value="{$config.lang}" /><br>
							{if $config.desc}
    						<br><span class="help-block">{$config.desc}</span>
    						{/if}
							<!--the tenpay code -->
							{if $key eq "0"}
							{if $smarty.get.code eq "tenpay"}<input type="button" value="{lang key='payment::payment.ctenpay'}" onclick="javascript:window.open('{lang key='payment::payment.ctenpay_url'}')"/>
							{elseif $smarty.get.code eq "tenpayc2c"} <input type="button" value="{lang key='payment::payment.ctenpay'}" onclick="javascript:window.open('{lang key='payment::payment.ctenpayc2c_url'}')"/>
							{/if}
							{/if}
							<!--the tenpay code -->
						</div>
					</div>
					<!-- {/foreach} -->
				<!-- {/if} -->
				<!-- 支付手续费 -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='payment::payment.label_pay_fee'}</label>
					<div class="controls">
						{if $pay.is_cod }
						<label class="p_t5">{lang key='payment::payment.decide_by_ship'}</label>
						<input class="w350" name="pay_fee" type="hidden" value="{$pay.pay_fee|default:0}" {if $pay.enabled neq 1}disabled{/if}/>
						{else}
						<input class="w350" name="pay_fee" type="text" value="{$pay.pay_fee|default:0}" {if $pay.enabled neq 1}disabled{/if}/>
						{/if}
					</div>
				</div>
				<!-- 货到付款 -->
				<div class="control-group formSep">
					<label  class="control-label">{lang key='payment::payment.payment_is_cod'}</label>
					<div class="controls">
						<label class="p_t5">{if $pay.is_cod == "1"}{lang key='system::system.yes'}{else}{lang key='system::system.no'}{/if}</label>
					</div>
				</div>
				<!-- 在线支付 -->
				<div class="control-group formSep">
					<label  class="control-label">{lang key='payment::payment.payment_is_online'}</label>
					<div class="controls">
						<label class="p_t5">{if $pay.is_online == "1"}{lang key='system::system.yes'}{else}{lang key='system::system.no'}{/if}</label>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit" {if $pay.enabled neq 1}disabled{/if}>{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="pay_id" value="{$pay.pay_id}" />
						<input type="hidden" name="pay_code" value="{$pay.pay_code}" />
						<input type="hidden" name="is_cod" value="{$pay.is_cod}" />
						<input type="hidden" name="is_online" value="{$pay.is_online}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->