<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.activity.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
	    <div class="tabbable">
	  		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
              	<div class="control-group formSep">
					<label class="control-label">{t domain="market"}奖品等级：{/t}</label>
					<div class="controls">
						<select name='prize_level' class="w350">
							<option value="">{t domain="market"}请选择...{/t}</option>
							<option value="0" {if $activity_prize.prize_level eq '0'}selected{/if}>{t domain="market"}特等奖{/t}</option>
							<option value="1" {if $activity_prize.prize_level eq 1}selected{/if}>{t domain="market"}一等奖{/t}</option>
							<option value="2" {if $activity_prize.prize_level eq 2}selected{/if}>{t domain="market"}二等奖{/t}</option>
							<option value="3" {if $activity_prize.prize_level eq 3}selected{/if}>{t domain="market"}三等奖{/t}</option>
							<option value="4" {if $activity_prize.prize_level eq 4}selected{/if}>{t domain="market"}四等奖{/t}</option>
							<option value="5" {if $activity_prize.prize_level eq 5}selected{/if}>{t domain="market"}五等奖{/t}</option>
						</select>
						<span class="input-must">*</span>	
					</div>
				</div>
				
                <div class="control-group formSep">
					<label class="control-label">{t domain="market"}奖品名称：{/t}</label>
					<div class="controls">
						<input class="w350" name="prize_name" type="text" value="{$activity_prize.prize_name}" maxlength="30"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="market"}奖品类型：{/t}</label>
					<div class="controls">
						<select name='prize_type' class="w350">
							<option value="">{t domain="market"}请选择...{/t}</option>
							<!-- {foreach from=$prize_type key=key item=val} -->
							<option value="{$key}" {if $activity_prize.prize_type eq $key}selected{/if}>{$val}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
					
				<div class="control-group formSep prize_value_bonus {if $activity_prize.prize_type neq 1}ecjiaf-dn{/if}">
					<label class="control-label">{t domain="market"}礼券奖品内容：{/t}</label>
					<div class="controls">
						<select name="prize_value" class="w350">
							<option value="">{t domain="market"}请选择{/t}</option>
							<!-- {foreach from=$bonus_list item=bonus } -->
								<option value="{$bonus.type_id}" {if $activity_prize.prize_value eq $bonus.type_id}selected{/if}>{$bonus.type_name}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep prize_value_other {if $activity_prize.prize_type neq 2 && $activity_prize.prize_type neq 3 && $activity_prize.prize_type neq 6}ecjiaf-dn{/if}">
					<label class="control-label">{t domain="market"}其他奖品内容：{/t}</label>
					<div class="controls">
						<input class="w350" name="prize_value_other" type="text" value="{if $activity_prize.prize_type eq 2 || $activity_prize.prize_type eq 3 || $activity_prize.prize_type eq 6}{$activity_prize.prize_value}{/if}"
									/>
						<span class="input-must">*</span>
						<span class="help-block">
						{if $activity_prize.prize_type eq 2}
						{t domain="market"}填写中奖的实物奖品，如iPhone X或iPad Pro 2{/t}
						{else if $activity_prize.prize_type eq 3}
						{t domain="market"}填写中奖后发放的消费积分数量{/t}
						{else if $activity_prize.prize_type eq 6}
						{t domain="market"}填写中奖后发放的现金红包金额，中奖后直接发放到用户帐户余额{/t}
						{/if}
						</span>
					</div>
				</div>
				
				<div class="control-group formSep" >
					<label class="control-label">{t domain="market"}奖品数量：{/t}</label>
					<div class="controls">
						<input class="w350" name="prize_number" type="text" value="{$activity_prize.prize_number}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep" >
					<label class="control-label">{t domain="market"}获奖概率：{/t}</label>
					<div class="controls">
						<input class="w350" name="prize_prob" type="text" value="{$activity_prize.prize_prob}"/>
						<span class="input-must">*</span>
						<span class="help-block">{t domain="market"}单位%{/t}</span>
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="p_id" value="{$activity_prize.prize_id}" />
						<input type="hidden" name="code" value="{$code}" />
						{if $p_id}
							<input type="submit" class="btn btn-gebo" value='{t domain="market"}更新{/t}' />
						{else}
							<input type="submit" class="btn btn-gebo" value='{t domain="market"}确定{/t}' />
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	  </div>
	</div>
</div>
<!-- {/block} -->