<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.bonus_info_edit.type_info_init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form method="post" class="form-horizontal" action="{$form_action}" name="typeInfoForm" data-edit-url="{RC_Uri::url('bonus/admin/edit')}" >
			<fieldset>
				<div>
					<input type="hidden" name="type_id" value="{$bonus_arr.type_id}" />
					<input type="hidden" name="send_type" id="send_type" value="{$bonus_arr.send_type}" />
					<input type="hidden" name="old_typename" value="{$bonus_arr.type_name}" />
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="bonus"}类型名称：{/t}</label>
					<div class="controls">
						<input type='text' name='type_name' maxlength="30" value="{$bonus_arr.type_name}" size='20' /> 
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="bonus"}红包金额：{/t}</label>
					<div class="controls">
						<input type="text" name="type_money" value="{$bonus_arr.type_money}" size="20" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>  
				<div class="control-group formSep">
					<label class="control-label">{t domain="bonus"}最小订单金额：{/t}</label>
					<div class="controls">
						<input name="min_goods_amount" type="text" id="min_goods_amount" value="{$bonus_arr.min_goods_amount}" size="20" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
						<span class="help-block">{t domain="bonus"}只有商品总金额达到这个数的订单才能使用这种红包{/t}</span>
					</div>
				</div> 
				<div class="control-group formSep">
					<label class="control-label">{t domain="bonus"}如何发放此类型红包：{/t}</label>
					<div class="controls chk_radio">
						<input type="radio" name="send_type" value="0" {if $bonus_arr.send_type eq 0} checked="true" {/if} onClick="javascript:ecjia.admin.bonus_info_edit.type_info_showunit(0)"  />{t domain="bonus"}按用户发放{/t}
						<input type="radio" name="send_type" value="3" {if $bonus_arr.send_type eq 3} checked="true" {/if} onClick="javascript:ecjia.admin.bonus_info_edit.type_info_showunit(3)"  />{t domain="bonus"}注册送红包{/t}
						<input type="radio" name="send_type" value="1" {if $bonus_arr.send_type eq 1} checked="true" {/if} onClick="javascript:ecjia.admin.bonus_info_edit.type_info_showunit(1)"  />{t domain="bonus"}按商品发放{/t}
						<input type="radio" name="send_type" value="2" {if $bonus_arr.send_type eq 2} checked="true" {/if} onClick="javascript:ecjia.admin.bonus_info_edit.type_info_showunit(2)"  />{t domain="bonus"}按订单金额发放{/t}
					</div>
				</div>
				<div class="control-group formSep" id="min_amount_div" {if $bonus_arr.send_type neq 2} style="display:none" {/if}>
					<label class="control-label">{t domain="bonus"}订单下限：{/t}</label>
					<div class="controls promote_date">
						<input name="min_amount" type="text" id="min_amount" size="20" value='{$bonus_arr.min_amount}' /><br>
						<span class="help-block">{t domain="bonus"}只要订单金额达到该数值，就会发放红包给用户{/t}</span>
					</div>
				</div> 
				<div class="control-group formSep" id="start" {if $bonus_arr.send_type eq 0 || $bonus_arr.send_type eq 3} style="display:none" {/if}>
					<label class="control-label">{t domain="bonus"}发放起始日期：{/t}</label>
					<div class="controls promote_date">
						<input class="date" name="send_start_date" type="text" id="send_start_date" size="22" value='{$bonus_arr.send_start_date}'/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
						<span class="help-block">{t domain="bonus"}只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以发放{/t}</span>
					</div>
				</div>  
				<div class="control-group formSep" id="end" {if $bonus_arr.send_type eq 0 || $bonus_arr.send_type eq 3} style="display:none" {/if}>
					<label class="control-label">{t domain="bonus"}发放结束日期：{/t}</label>
					<div class="controls promote_date">
						<input class="date" name="send_end_date" type="text"  id="send_end_date" size="22"  value='{$bonus_arr.send_end_date}'/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="edit-page control-group formSep">
					<label class="control-label">{t domain="bonus"}使用类型：{/t}</label>
					<div class="controls">
						<select name="bonus_type" id="type_id">
<!-- 							<option value="0" {if $bonus_arr.usebonus_type eq 0}selected="selected"{/if}>{t domain="bonus"}自主使用{/t}</option> -->
							<option value="1" {if $bonus_arr.usebonus_type eq 1}selected="selected"{/if}>{t domain="bonus"}全场使用{/t}</option>
				        </select>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="bonus"}使用起始日期：{/t}</label>
					<div class="controls promote_date">
						<input class="date" name="use_start_date" type="text" class="date" id="use_start_date" size="22" value='{$bonus_arr.use_start_date}'/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
						<span class="help-block" >{t domain="bonus"}只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以使用{/t}</span>
					</div>  
				</div>  
				<div class="control-group formSep">
					<label class="control-label">{t domain="bonus"}使用结束日期：{/t}</label>
					<div class="controls promote_date">
						<input class="date" name="use_end_date" type="text" class="date" id="use_end_date" size="22" value='{$bonus_arr.use_end_date}'/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						{if $bonus_arr.type_id eq ''}
							<button class="btn btn-gebo" type="submit">{t domain="bonus"}确定{/t}</button>
						{else}
							<button class="btn btn-gebo" type="submit">{t domain="bonus"}更新{/t}</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->