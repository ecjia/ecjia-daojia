<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.affiliate.init();
</script>
<!-- {/block} -->

<!-- {block name="alert-info"} -->
<!-- {if $config.on eq 0} -->
<div class="alert alert-info">	
	<strong>{t domain="affiliate"}推荐设置已关闭{/t}</strong>
</div>
<!-- {/if} -->
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
		<div class="span12">
			<h3 class="heading">{t domain="affiliate"}推荐基本设置{/t}</h3>
			<div class="control-group formSep">
				<label class="control-label">{t domain="affiliate"}是否开启奖励：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="on" value="1" {if $config.on eq 1} checked="true" {/if}>
					<span>{t domain="affiliate"}开启{/t}</span>
					<input type="radio" name="on" value="0" {if !$config.on || $config.on eq 0} checked="true" {/if}>
					<span>{t domain="affiliate"}关闭{/t}</span>
					<div class="clear"></div>
					<div class="help-block">{t domain="affiliate"}只控制奖励是否发放，关闭奖励时注意修改邀请分享说明。{/t}</div>
				</div>
			</div>
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}推荐分成类型：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="separate_by" value="0" checked="true" {if $config.on eq 0}disabled{/if}>
					<span>{t domain="affiliate"}推荐注册分成{/t}</span>
					<input type="radio" name="separate_by" value="1" {if $config.config.separate_by eq '1'} checked{/if} {if $config.on eq 0}disabled{/if}>
					<span>{t domain="affiliate"}推荐订单分成{/t}</span>
				</div>
			</div>
				
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}推荐时效：{/t}</label>
				<div class="controls">
					<input class="f_l" type="text" name="expire" maxlength="150" size="10" value="{$config.config.expire}" {if $config.on eq 0}readonly{/if}/>
					<span class="f_l">&nbsp;</span>
					<select class="w70" name="expire_unit" {if $config.on eq 0}disabled{/if}>
						<!--{html_options options=$unit selected=$config.config.expire_unit}-->
					</select>
					<div class="clear"></div>
					<div class="help-block">{t domain="affiliate"}访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的。{/t}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}积分分成总额百分比：{/t}</label>
				<div class="controls">
					<input type="text" name="level_point_all" maxlength="150" size="10" value="{$config.config.level_point_all}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{t domain="affiliate"}订单积分的此百分比部分作为分成用积分。{/t}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}现金分成总额百分比：{/t}</label>
				<div class="controls">
					<input type="text" name="level_money_all" maxlength="150" size="10" value="{$config.config.level_money_all}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{t domain="affiliate"}订单金额的此百分比部分作为分成用金额。{/t}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}注册积分分成数：{/t}</label>
				<div class="controls">
					<input type="text" name="level_register_all" maxlength="150" size="10" value="{$config.config.level_register_all}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{t domain="affiliate"}介绍会员注册，介绍人所能获得的成长值。{/t}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}成长值分成上限：{/t}</label>
				<div class="controls">
					<input type="text" name="level_register_up" maxlength="150" size="10" value="{$config.config.level_register_up}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{t domain="affiliate"}成长值到此上限则不再奖励介绍注册积分。{/t}</div>
				</div>
			</div>
			
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}推荐邀请分享内容：{/t}</label>
				<div class="controls">
					<textarea name='invite_template' class="span7">{$invite_template}</textarea>
				</div>
			</div>
			
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}推荐邀请分享说明：{/t}</label>
				<div class="controls">
					<textarea name='invite_explain' class="span7">{$invite_explain}</textarea>
				</div>
			</div>

			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}被邀请分享说明设置：{/t}</label>
				<div class="controls">
					<textarea name='invitee_rule_explain' class="span7">{$invitee_rule_explain}</textarea>
				</div>
			</div>
			
			<h3 class="heading">{t domain="affiliate"}邀请人奖励设置{/t}</h3>
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}奖励发放时间：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="intive_reward_by" value="orderpay" checked="true" {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}首次下单成交后{/t}
					<input type="radio" name="intive_reward_by" value="signup" {if $config.intvie_reward.intive_reward_by eq 'signup'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}注册时{/t}
				</div>
			</div>
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}奖励方式：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="intive_reward_type" value="bonus" checked="true" {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}红包{/t}
					<input type="radio" name="intive_reward_type" value="integral" {if $config.intvie_reward.intive_reward_type eq 'integral'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}积分{/t}
					<input type="radio" name="intive_reward_type" value="balance" {if $config.intvie_reward.intive_reward_type eq 'balance'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}现金{/t}
				</div>
			</div>
			<div class="control-group formSep formSep1 intive_reward_type intive_reward_type_bonus {if $config.intvie_reward.intive_reward_type neq 'bonus' && $config.intvie_reward.intive_reward_type}ecjiaf-dn{/if}" >
				<label class="control-label">{t domain="affiliate"}选择奖励的红包：{/t}</label>
				<div class="controls chk_radio">
					<select name="intive_reward_type_bonus" {if $config.on eq 0}disabled{/if}>
						<option value="0">{t domain="affiliate"}请选择{/t}</option>
						<!-- {foreach from=$bonus_type_list item=list} -->
						<option value="{$list.type_id}" {if $config.intvie_reward.intive_reward_value eq $list.type_id && $config.intvie_reward.intive_reward_type eq 'bonus'}selected="true"{/if}>{$list.type_name}</option>	
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div class="control-group formSep formSep1 intive_reward_type intive_reward_type_integral  {if $config.intvie_reward.intive_reward_type neq 'integral'}ecjiaf-dn{/if}">
				<label class="control-label">{t domain="affiliate"}奖励积分数量：{/t}</label>
				<div class="controls chk_radio">
					<input type="text" name="intive_reward_type_integral" {if $config.on eq 0}disabled{/if} {if $config.intvie_reward.intive_reward_type eq 'integral'}value="{$config.intvie_reward.intive_reward_value}"{/if}/>
				</div>
			</div>
			<div class="control-group formSep formSep1 intive_reward_type intive_reward_type_balance  {if $config.intvie_reward.intive_reward_type neq 'balance'}ecjiaf-dn{/if}">
				<label class="control-label">{t domain="affiliate"}奖励现金数量：{/t}</label>
				<div class="controls chk_radio">
					<input type="text" name="intive_reward_type_balance" {if $config.on eq 0}disabled{/if} {if $config.intvie_reward.intive_reward_type eq 'balance'}value="{$config.intvie_reward.intive_reward_value}"{/if}/>
				</div>
			</div>
			
			
			<h3 class="heading">{t domain="affiliate"}受邀人奖励设置{/t}</h3>
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}奖励发放时间：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="intivee_reward_by" value="orderpay" checked="true" {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}首次下单成交后{/t}
					<input type="radio" name="intivee_reward_by" value="signup"  {if $config.intviee_reward.intivee_reward_by eq 'signup'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}注册时{/t}
				</div>
			</div>
			<div class="control-group formSep formSep1">
				<label class="control-label">{t domain="affiliate"}奖励方式：{/t}</label>
				<div class="controls chk_radio">
					<input type="radio" name="intivee_reward_type" value="bonus" checked="true" {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}红包{/t}
					<input type="radio" name="intivee_reward_type" value="integral" {if $config.intviee_reward.intivee_reward_type eq 'integral'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}积分{/t}
					<input type="radio" name="intivee_reward_type" value="balance"  {if $config.intviee_reward.intivee_reward_type eq 'balance'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
                    {t domain="affiliate"}现金{/t}
				</div>
			</div>
			<div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_bonus {if $config.intviee_reward.intivee_reward_type neq 'bonus'  && $config.intviee_reward.intivee_reward_type}ecjiaf-dn{/if}">
				<label class="control-label">{t domain="affiliate"}选择奖励的红包：{/t}</label>
				<div class="controls chk_radio">
					<select name="intivee_reward_type_bonus" {if $config.on eq 0}disabled{/if}>
						<option value="0">{t domain="affiliate"}请选择{/t}</option>
						<!-- {foreach from=$bonus_type_list item=list} -->
							<option value="{$list.type_id}" {if $config.intviee_reward.intivee_reward_value eq $list.type_id && $config.intviee_reward.intivee_reward_type eq 'bonus'}selected="true"{/if}>{$list.type_name}</option>	
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_integral {if $config.intviee_reward.intivee_reward_type neq 'integral'}ecjiaf-dn{/if}">
				<label class="control-label">{t domain="affiliate"}奖励积分数量：{/t}</label>
				<div class="controls chk_radio">
					<input type="text" name="intivee_reward_type_integral" {if $config.on eq 0}disabled{/if} {if $config.intviee_reward.intivee_reward_type eq 'integral'}value="{$config.intviee_reward.intivee_reward_value}"{/if}/>
				</div>
			</div>
			<div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_balance {if $config.intviee_reward.intivee_reward_type neq 'balance'}ecjiaf-dn{/if}">
				<label class="control-label">{t domain="affiliate"}奖励现金数量：{/t}</label>
				<div class="controls chk_radio">
					<input type="text" name="intivee_reward_type_balance" {if $config.on eq 0}disabled{/if} {if $config.intviee_reward.intivee_reward_type eq 'balance'}value="{$config.intviee_reward.intivee_reward_value}"{/if}/>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" value='{t domain="affiliate"}确定{/t}' class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->