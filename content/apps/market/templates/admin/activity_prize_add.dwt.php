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
					<label class="control-label">奖品等级：</label>
					<div class="controls">
						<select name='prize_level' class="w350">
							<option value="">请选择...</option>
							<option value="0" {if $activity_prize.prize_level eq '0'}selected{/if}>特等奖</option>
							<option value="1" {if $activity_prize.prize_level eq 1}selected{/if}>一等奖</option>
							<option value="2" {if $activity_prize.prize_level eq 2}selected{/if}>二等奖</option>
							<option value="3" {if $activity_prize.prize_level eq 3}selected{/if}>三等奖</option>
							<option value="4" {if $activity_prize.prize_level eq 4}selected{/if}>四等奖</option>
							<option value="5" {if $activity_prize.prize_level eq 5}selected{/if}>五等奖</option>
						</select>
						<span class="input-must">*</span>	
					</div>
				</div>
				
                <div class="control-group formSep">
					<label class="control-label">奖品名称：</label>
					<div class="controls">
						<input class="w350" name="prize_name" type="text" value="{$activity_prize.prize_name}" maxlength="30"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">奖品类型：</label>
					<div class="controls">
						<select name='prize_type' class="w350">
							<option value="">请选择...</option>
							<!-- {foreach from=$prize_type key=key item=val} -->
							<option value="{$key}" {if $activity_prize.prize_type === $key}selected{/if}>{$val}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
					
				<div class="control-group formSep prize_value_bonus {if $activity_prize.prize_type neq 1}ecjiaf-dn{/if}">
					<label class="control-label">礼券奖品内容：</label>
					<div class="controls">
						<select name="prize_value" class="w350">
							<option value="">{lang key='market::market.please_select'}</option>
							<!-- {foreach from=$bonus_list item=bonus } -->
								<option value="{$bonus.type_id}" {if $activity_prize.prize_value eq $bonus.type_id}selected{/if}>{$bonus.type_name}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep prize_value_other {if $activity_prize.prize_type neq 2 && $activity_prize.prize_type neq 3 && $activity_prize.prize_type neq 6}ecjiaf-dn{/if}">
					<label class="control-label">其他奖品内容：</label>
					<div class="controls">
						<input class="w350" name="prize_value_other" type="text" value="{if $activity_prize.prize_type eq 2 || $activity_prize.prize_type eq 3 || $activity_prize.prize_type eq 6}{$activity_prize.prize_value}{/if}"
									/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep" >
					<label class="control-label">奖品数量：</label>
					<div class="controls">
						<input class="w350" name="prize_number" type="text" value="{$activity_prize.prize_number}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep" >
					<label class="control-label">获奖概率：</label>
					<div class="controls">
						<input class="w350" name="prize_prob" type="text" value="{$activity_prize.prize_prob}"/>
						<span class="input-must">*</span>
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="p_id" value="{$activity_prize.prize_id}" />
						<input type="hidden" name="code" value="{$code}" />
						{if $p_id}
							<input type="submit" class="btn btn-gebo" value="更新" />
						{else}
							<input type="submit" class="btn btn-gebo" value="确定" />
						{/if}
					</div>
					
				</div>
			</fieldset>
		</form>
	  </div>
	</div>
</div>
<!-- {/block} -->