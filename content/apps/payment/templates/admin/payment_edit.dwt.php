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
	<strong>{t domain="payment"}温馨提示：{/t}</strong>{t domain="payment"}该支付方式已经禁用，如果您需要使用，请点击{/t}<a class="switch" href="javascript:;" data-url='{RC_Uri::url("payment/admin_plugin/enable", "code={$pay.pay_code}&from=edit")}' title='{t domain="payment"}启用{/t}'>{t domain="payment"}启用{/t}</a>。
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
<div class="row-fluid edit-page">
	<div class="span12">
		<form id="form-privilege"  class="form-horizontal"  name="editForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="payment"}名称：{/t}</label>
					<div class="controls">
						<input class="w350" name="pay_name" type="text" id="pay_name" value="{$pay.pay_name|escape}" size="40" {if $pay.enabled neq 1}disabled{/if}/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="payment"}描述：{/t}</label>
					<div class="controls">
						<textarea class="w350" id="pay_desc" name="pay_desc" cols="10" rows="6" {if $pay.enabled neq 1}disabled{/if}>{$pay.pay_desc|escape}</textarea>
						<span class="input-must">*</span>
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
							<select class="w350" id="cfg_value[]" name="cfg_value[]">
								<!-- {html_options options=$config.range selected=$config.value} -->
							</select>
                            <!-- {elseif $config.type == "file"} -->

                            {if $config.value}
                            <div class="m_t5 ecjiaf-wwb">{t domain="payment"}文件地址：{/t}{$config.value}</div>
                            <a class="ecjiafc-red cursor_pointer" data-toggle="ajaxremove" data-msg='{t domain="payment"}您确定要删除此文件吗？{/t}'
                               data-href='{RC_Uri::url("payment/admin_plugin/delete_file", "pay_code={$pay.pay_code}&code={$config.name}")}' data-removefile="true">{t domain="payment"}删除文件{/t}</a>
                            <input type="hidden" name="cfg_value[]" value="{$config.value}" />
                            {else}
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <input type="hidden" name="cfg_value[]" value="" />
                                <span class="btn btn-file">
                                    <span class="fileupload-new">{t domain="payment"}浏览{/t}</span>
                                    <span class="fileupload-exists">{t domain="payment"}修改{/t}</span>
                                    <input type="{$config.type}" name="{$config.name}" />
                                </span>
                                <span class="fileupload-preview"></span>
                                <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="index.php-uid=1&page=form_extended.html#">&times;</a>
                            </div>
                            {/if}

							<!-- {/if} -->
							<input name="cfg_name[]" type="hidden" value="{$config.name}" />
							<input name="cfg_type[]" type="hidden" value="{$config.type}" />
							<input name="cfg_lang[]" type="hidden" value="{$config.lang}" />
                            <input name="cfg_dir[]" type="hidden" value="{$config.dir}" />
							{if $config.desc}
    						<span class="help-block">{$config.desc}</span>
    						{/if}
							<!--the tenpay code -->
							{if $key eq "0"}
							{if $smarty.get.code eq "tenpay"}<input type="button" value='{t domain="payment"}立即注册财付通商户号{/t}' onclick='javascript:window.open("http://union.tenpay.com/mch/mch_register_b2c.shtml?sp_suggestuser=542554970")'/>
							{elseif $smarty.get.code eq "tenpayc2c"} <input type="button" value='{t domain="payment"}立即注册财付通商户号{/t}' onclick='javascript:window.open("https://www.tenpay.com/mchhelper/mch_register_c2c.shtml?sp_suggestuser=542554970")'/>
							{/if}
							{/if}
							<!--the tenpay code -->
						</div>
					</div>
					<!-- {/foreach} -->
				<!-- {/if} -->
				<!-- 支付手续费 -->
				<div class="control-group formSep">
					<label class="control-label">{t domain="payment"}支付手续费：{/t}</label>
					<div class="controls">
						{if $pay.is_cod }
						<label class="p_t5">{t domain="payment"}配送决定{/t}</label>
						<input class="w350" name="pay_fee" type="hidden" value="{$pay.pay_fee|default:0}" {if $pay.enabled neq 1}disabled{/if}/>
						{else}
						<input class="w350" name="pay_fee" type="text" value="{$pay.pay_fee|default:0}" {if $pay.enabled neq 1}disabled{/if}/>
						{/if}
					</div>
					<div class="controls help-block">{t domain="payment"}设置方式1：固定手续费，如：5{/t}<br>{t domain="payment"}设置方式2：比例手续费，如：5%{/t}</div>
				</div>
				<!-- 货到付款 -->
				<div class="control-group formSep">
					<label  class="control-label">{t domain="payment"}货到付款：{/t}</label>
					<div class="controls">
						<label class="p_t5">{if $pay.is_cod == "1"}{t domain="payment"}是{/t}{else}{t domain="payment"}否{/t}{/if}</label>
					</div>
				</div>
				<!-- 在线支付 -->
				<div class="control-group formSep">
					<label  class="control-label">{t domain="payment"}在线支付：{/t}</label>
					<div class="controls">
						<label class="p_t5">{if $pay.is_online == "1"}{t domain="payment"}是{/t}{else}{t domain="payment"}否{/t}{/if}</label>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit" {if $pay.enabled neq 1}disabled{/if}>{t domain="payment"}确定{/t}</button>
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