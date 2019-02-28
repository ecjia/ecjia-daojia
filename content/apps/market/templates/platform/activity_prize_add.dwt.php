<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.platform_activity.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">
					{$ur_here} {if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a">
						<i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
				</h4>
			</div>
			<div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}奖品等级：{/t}</label>
								<div class="col-lg-8 controls">
									<select name="prize_level" class=" select2 form-control">
										<option value="">{t domain="market"}请选择...{/t}</option>
										<option value="0" {if $activity_prize.prize_level eq '0'}selected{/if}>{t domain="market"}特等奖{/t}</option>
										<option value="1" {if $activity_prize.prize_level eq 1}selected{/if}>{t domain="market"}一等奖{/t}</option>
										<option value="2" {if $activity_prize.prize_level eq 2}selected{/if}>{t domain="market"}二等奖{/t}</option>
										<option value="3" {if $activity_prize.prize_level eq 3}selected{/if}>{t domain="market"}三等奖{/t}</option>
										<option value="4" {if $activity_prize.prize_level eq 4}selected{/if}>{t domain="market"}四等奖{/t}</option>
										<option value="5" {if $activity_prize.prize_level eq 5}selected{/if}>{t domain="market"}五等奖{/t}</option>
									</select>
								</div>
								<span class="input-must">*</span>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}奖品名称:{/t}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="prize_name" type="text" value="{$activity_prize.prize_name}" maxlength="30"
									/>
								</div>
								<span class="input-must">*</span>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}奖品类型：{/t}</label>
								<div class="col-lg-8 controls">
									{if $store_id gt 0}
										<select name="prize_type" class="select2 form-control">
											<option value="">{t domain="market"}请选择...{/t}</option>
											<!-- {foreach from=$prize_type key=key item=val} -->
											<!-- {if $key neq '3' && $key neq '6'}-->
												<option value="{$key}" {if $activity_prize.prize_type eq $key}selected{/if}>{$val}</option>
											<!-- {/if}-->
											<!-- {/foreach} -->
										</select>
									{else}
										<select name="prize_type" class="select2 form-control">
											<option value="">{t domain="market"}请选择...{/t}</option>
											<!-- {foreach from=$prize_type key=key item=val} -->
												<option value="{$key}" {if $activity_prize.prize_type eq $key}selected{/if}>{$val}</option>
											<!-- {/foreach} -->
										</select>
									{/if}
								</div>
								<span class="input-must">*</span>
							</div>

							
							<div class="form-group row prize_value_bonus {if $activity_prize.prize_type neq 1}display-dn{/if}">
								<label class="col-lg-2 label-control text-right">{t domain="market"}礼券奖品内容：{/t}</label>
								<div class="col-lg-8 controls">
									<select name="prize_value" class=" select2 form-control">
										<option value="">{t domain="market"}请选择...{/t}</option>
										<!-- {foreach from=$bonus_list item=bonus } -->
										<option value="{$bonus.type_id}" {if $activity_prize.prize_value eq $bonus.type_id}selected{/if}>{$bonus.type_name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
								<span class="input-must">*</span>
							</div>

							<div class="form-group row prize_value_other {if $activity_prize.prize_type neq 2 && $activity_prize.prize_type neq 3 && $activity_prize.prize_type neq 6}display-dn{/if}">
								<label class="col-lg-2 label-control text-right">{t domain="market"}其他奖品内容：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="prize_value_other" type="text" value="{if $activity_prize.prize_type eq 2 || $activity_prize.prize_type eq 3 || $activity_prize.prize_type eq 6}{$activity_prize.prize_value}{/if}"
									/>
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
								<span class="input-must">*</span>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}奖品数量：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="prize_number" type="text" value="{$activity_prize.prize_number}" />
								</div>
								<span class="input-must">*</span>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}获奖概率：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" type='text' name='prize_prob' value="{$activity_prize.prize_prob}" />
									<span class="help-block">{t domain="market"}单位%{/t}</span>
								</div>
								<span class="input-must">*</span>
							</div>
						</div>
					</div>

					<div class="modal-footer justify-content-center">
						<input type="hidden" name="p_id" value="{$activity_prize.prize_id}" />
						<input type="hidden" name="code" value="{$code}" /> {if $p_id}
						<input type="submit" class="btn btn-outline-primary" value='{t domain="market"}更新{/t}' /> {else}
						<input type="submit" class="btn btn-outline-primary" value='{t domain="market"}确定{/t}' /> {/if}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->