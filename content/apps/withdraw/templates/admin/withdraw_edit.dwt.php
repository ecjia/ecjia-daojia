<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_plugin.submit();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $withdraw.enabled neq 1}
<div class="alert alert-error">
	<strong>温馨提示：</strong>该提现方式已经禁用，如果您需要使用，请点击<a class="switch" href="javascript:;" data-url='{RC_Uri::url("withdraw/admin_plugin/enable", "code={$withdraw.withdraw_code}&from=edit")}' title="{lang key='withdraw::withdraw.enable'}">启用</a>。
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
		<form id="form-privilege" class="form-horizontal" name="editForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='withdraw::withdraw.label_withdraw_name'}</label>
					<div class="controls">
						<input class="w350" name="withdraw_name" type="text" id="withdraw_name" value="{$withdraw.withdraw_name|escape}" size="40" {if $withdraw.enabled neq 1}disabled{/if}/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>

				<div class="control-group formSep">
					<label class="control-label">{lang key='withdraw::withdraw.label_withdraw_desc'}</label>
					<div class="controls">
						<textarea class="w350" id="withdraw_desc" name="withdraw_desc" cols="10" rows="6" {if $withdraw.enabled neq 1}disabled{/if}>{$withdraw.withdraw_desc|escape}</textarea>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>

				<!-- {if $withdraw.enabled eq 1} -->
					<!-- {foreach from=$withdraw.withdraw_config item=config key=key} -->
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
                            <div class="m_t5 ecjiaf-wwb">文件地址：{$config.value}</div>
                            <a class="ecjiafc-red cursor_pointer" data-toggle="ajaxremove" data-msg="{t}您确定要删除此文件吗？{/t}"
                               data-href='{RC_Uri::url("withdraw/admin_plugin/delete_file", "withdraw_code={$withdraw.withdraw_code}&code={$config.name}")}' data-removefile="true">{t}删除文件{/t}</a>
                            <input type="hidden" name="cfg_value[]" value="{$config.value}" />
                            {else}
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <input type="hidden" name="cfg_value[]" value="" />
                                <span class="btn btn-file">
                                    <span class="fileupload-new">浏览</span>
                                    <span class="fileupload-exists">修改</span>
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
                                {if $smarty.get.code eq "tenpay"}<input type="button" value="{lang key='withdraw::withdraw.ctenpay'}" onclick="javascript:window.open('{lang key="withdraw::withdraw.ctenwithdraw_url"}')"/>
                                {elseif $smarty.get.code eq "tenpayc2c"} <input type="button" value="{lang key='withdraw::withdraw.ctenpay'}" onclick="javascript:window.open('{lang key="withdraw::withdraw.ctenpayc2c_url"}')"/>
                                {/if}
							{/if}
							<!--the tenpay code -->
						</div>
					</div>
					<!-- {/foreach} -->
				<!-- {/if} -->

				<!-- 提现手续费 -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='withdraw::withdraw.label_withdraw_fee'}</label>
					<div class="controls">
						{if $withdraw.is_cod }
						<label class="p_t5">{lang key='withdraw::withdraw.decide_by_ship'}</label>
						<input class="w350" name="withdraw_fee" type="hidden" value="{$withdraw.withdraw_fee|default:0}" {if $withdraw.enabled neq 1}disabled{/if}/>
						{else}
						<input class="w350" name="withdraw_fee" type="text" value="{$withdraw.withdraw_fee|default:0}" {if $withdraw.enabled neq 1}disabled{/if}/>
						{/if}
					</div>
				</div>

				<!-- 在线提现 -->
				<div class="control-group formSep">
					<label  class="control-label">{lang key='withdraw::withdraw.withdraw_is_online'}</label>
					<div class="controls">
						<label class="p_t5">{if $withdraw.is_online == "1"}{lang key='system::system.yes'}{else}{lang key='system::system.no'}{/if}</label>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit" {if $withdraw.enabled neq 1}disabled{/if}>{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="withdraw_id" value="{$withdraw.withdraw_id}" />
						<input type="hidden" name="withdraw_code" value="{$withdraw.withdraw_code}" />
						<input type="hidden" name="is_online" value="{$withdraw.is_online}" />
					</div>
				</div>

			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->