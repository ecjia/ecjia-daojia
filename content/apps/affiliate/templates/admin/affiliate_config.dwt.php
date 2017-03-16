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
	<strong>{lang key='affiliate::affiliate.notice'}</strong>
</div>
<!-- {/if} -->
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
		<div class="span12">
			<h3 class="heading">推荐基本设置</h3>
			<div class="control-group formSep">
				<label class="control-label">{lang key='affiliate::affiliate.is_on'}：</label>
				<div class="controls chk_radio">
					<input type="radio" name="on" value="1" {if $config.on eq 1} checked="true" {/if}>
					<span>{lang key='affiliate::affiliate.on'}</span>
					<input type="radio" name="on" value="0" {if !$config.on || $config.on eq 0} checked="true" {/if}>
					<span>{lang key='affiliate::affiliate.off'}</span>
					<div class="clear"></div>
					<div class="help-block">{lang key='affiliate::affiliate.help_is_on'}</div>
				</div>
			</div>
			<div class="control-group formSep formSep1">
				<label class="control-label">{lang key='affiliate::affiliate.affiliate_type'}</label>
				<div class="controls chk_radio">
					<input type="radio" name="separate_by" value="0" checked="true" {if $config.on eq 0}disabled{/if}>
					<span>{lang key='affiliate::affiliate.separate_by.0'}</span>
					<input type="radio" name="separate_by" value="1" {if $config.config.separate_by eq '1'} checked{/if} {if $config.on eq 0}disabled{/if}>
					<span>{lang key='affiliate::affiliate.separate_by.1'}</span>
				</div>
			</div>
				
			<div class="control-group formSep formSep1">
				<label class="control-label">{lang key='affiliate::affiliate.expire'}</label>
				<div class="controls">
					<input class="f_l" type="text" name="expire" maxlength="150" size="10" value="{$config.config.expire}" {if $config.on eq 0}readonly{/if}/>
					<span class="f_l">&nbsp;</span>
					<select class="w70" name="expire_unit" {if $config.on eq 0}disabled{/if}>
						<!--{html_options options=$unit selected=$config.config.expire_unit}-->
					</select>
					<div class="clear"></div>
					<div class="help-block">{lang key='affiliate::affiliate.help_expire'}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{lang key='affiliate::affiliate.level_point_all'}</label>
				<div class="controls">
					<input type="text" name="level_point_all" maxlength="150" size="10" value="{$config.config.level_point_all}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{lang key='affiliate::affiliate.help_lpa'}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{lang key='affiliate::affiliate.level_money_all'}</label>
				<div class="controls">
					<input type="text" name="level_money_all" maxlength="150" size="10" value="{$config.config.level_money_all}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{lang key='affiliate::affiliate.help_lma'}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{lang key='affiliate::affiliate.level_register_all'}</label>
				<div class="controls">
					<input type="text" name="level_register_all" maxlength="150" size="10" value="{$config.config.level_register_all}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{lang key='affiliate::affiliate.help_lra'}</div>
				</div>
			</div>
					
			<div class="control-group formSep formSep1">
				<label class="control-label">{lang key='affiliate::affiliate.level_register_up'}</label>
				<div class="controls">
					<input type="text" name="level_register_up" maxlength="150" size="10" value="{$config.config.level_register_up}" {if $config.on eq 0}readonly{/if}/>
					<div class="help-block">{lang key='affiliate::affiliate.help_lru'}</div>
				</div>
			</div>
			
			<div class="control-group formSep formSep1">
				<label class="control-label">推荐邀请分享内容：</label>
				<div class="controls">
					<textarea name='invite_template' class="span7">{$invite_template}</textarea>
				</div>
			</div>
			
			<div class="control-group formSep formSep1">
				<label class="control-label">推荐邀请分享说明：</label>
				<div class="controls">
					<textarea name='invite_explain' class="span7">{$invite_explain}</textarea>
				</div>
			</div>
			
			<h3 class="heading">邀请人奖励设置</h3>
			<div class="control-group formSep formSep1">
				<label class="control-label">奖励发放时间：</label>
				<div class="controls chk_radio">
					<input type="radio" name="intive_reward_by" value="orderpay" checked="true" {if $config.on eq 0}disabled{/if}>
					首次下单成交后
					<input type="radio" name="intive_reward_by" value="signup" {if $config.intvie_reward.intive_reward_by eq 'signup'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
					注册时
				</div>
			</div>
			<div class="control-group formSep formSep1">
				<label class="control-label">奖励方式：</label>
				<div class="controls chk_radio">
					<input type="radio" name="intive_reward_type" value="bonus" checked="true" {if $config.on eq 0}disabled{/if}>
					红包
					<input type="radio" name="intive_reward_type" value="integral" {if $config.intvie_reward.intive_reward_type eq 'integral'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
					积分
					<input type="radio" name="intive_reward_type" value="balance" {if $config.intvie_reward.intive_reward_type eq 'balance'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
					现金
				</div>
			</div>
			<div class="control-group formSep formSep1 intive_reward_type intive_reward_type_bonus {if $config.intvie_reward.intive_reward_type neq 'bonus' && $config.intvie_reward.intive_reward_type}ecjiaf-dn{/if}" >
				<label class="control-label">选择奖励的红包：</label>
				<div class="controls chk_radio">
					<select name="intive_reward_type_bonus" {if $config.on eq 0}disabled{/if}>
						<option value="0">请选择</option>
						<!-- {foreach from=$bonus_type_list item=list} -->
						<option value="{$list.type_id}" {if $config.intvie_reward.intive_reward_value eq $list.type_id && $config.intvie_reward.intive_reward_type eq 'bonus'}selected="true"{/if}>{$list.type_name}</option>	
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div class="control-group formSep formSep1 intive_reward_type intive_reward_type_integral  {if $config.intvie_reward.intive_reward_type neq 'integral'}ecjiaf-dn{/if}">
				<label class="control-label">奖励积分数量：</label>
				<div class="controls chk_radio">
					<input type="text" name="intive_reward_type_integral" {if $config.on eq 0}disabled{/if} {if $config.intvie_reward.intive_reward_type eq 'integral'}value="{$config.intvie_reward.intive_reward_value}"{/if}/>
				</div>
			</div>
			<div class="control-group formSep formSep1 intive_reward_type intive_reward_type_balance  {if $config.intvie_reward.intive_reward_type neq 'balance'}ecjiaf-dn{/if}">
				<label class="control-label">奖励现金数量：</label>
				<div class="controls chk_radio">
					<input type="text" name="intive_reward_type_balance" {if $config.on eq 0}disabled{/if} {if $config.intvie_reward.intive_reward_type eq 'balance'}value="{$config.intvie_reward.intive_reward_value}"{/if}/>
				</div>
			</div>
			
			
			<h3 class="heading">受邀人奖励设置</h3>
			<div class="control-group formSep formSep1">
				<label class="control-label">奖励发放时间：</label>
				<div class="controls chk_radio">
					<input type="radio" name="intivee_reward_by" value="orderpay" checked="true" {if $config.on eq 0}disabled{/if}>
					首次下单成交后
					<input type="radio" name="intivee_reward_by" value="signup"  {if $config.intviee_reward.intivee_reward_by eq 'signup'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
					注册时
				</div>
			</div>
			<div class="control-group formSep formSep1">
				<label class="control-label">奖励方式：</label>
				<div class="controls chk_radio">
					<input type="radio" name="intivee_reward_type" value="bonus" checked="true" {if $config.on eq 0}disabled{/if}>
					红包
					<input type="radio" name="intivee_reward_type" value="integral" {if $config.intviee_reward.intivee_reward_type eq 'integral'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
					积分
					<input type="radio" name="intivee_reward_type" value="balance"  {if $config.intviee_reward.intivee_reward_type eq 'balance'}checked="true"{/if} {if $config.on eq 0}disabled{/if}>
					现金
				</div>
			</div>
			<div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_bonus {if $config.intviee_reward.intivee_reward_type neq 'bonus'  && $config.intviee_reward.intivee_reward_type}ecjiaf-dn{/if}">
				<label class="control-label">选择奖励的红包：</label>
				<div class="controls chk_radio">
					<select name="intivee_reward_type_bonus" {if $config.on eq 0}disabled{/if}>
						<option value="0">请选择</option>
						<!-- {foreach from=$bonus_type_list item=list} -->
							<option value="{$list.type_id}" {if $config.intviee_reward.intivee_reward_value eq $list.type_id && $config.intviee_reward.intivee_reward_type eq 'bonus'}selected="true"{/if}>{$list.type_name}</option>	
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_integral {if $config.intviee_reward.intivee_reward_type neq 'integral'}ecjiaf-dn{/if}">
				<label class="control-label">奖励积分数量：</label>
				<div class="controls chk_radio">
					<input type="text" name="intivee_reward_type_integral" {if $config.on eq 0}disabled{/if} {if $config.intviee_reward.intivee_reward_type eq 'integral'}value="{$config.intviee_reward.intivee_reward_value}"{/if}/>
				</div>
			</div>
			<div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_balance {if $config.intviee_reward.intivee_reward_type neq 'balance'}ecjiaf-dn{/if}">
				<label class="control-label">奖励现金数量：</label>
				<div class="controls chk_radio">
					<input type="text" name="intivee_reward_type_balance" {if $config.on eq 0}disabled{/if} {if $config.intviee_reward.intivee_reward_type eq 'balance'}value="{$config.intviee_reward.intivee_reward_value}"{/if}/>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->