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
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
            	<form name="editForm" action="{$form_action}" method="post">
					<table class="market_activity" style="margin-bottom:10px;">
						<tr>
							<td class="w100">{lang key='market::market.prize_level'}</td>
							<td>{lang key='market::market.prize_name'}</td>
							<td class="w100">{lang key='market::market.prize_type'}</td>
							<td class="w120">{lang key='market::market.prize_content'}</td>
							<td>{lang key='market::market.prize_num'}</td>
							<td>{lang key='market::market.get_prize_probability'}</td>
							<td>&nbsp;</td>
						</tr>
						<!-- {foreach from=$prize_list item=prize name=foo_prize} -->
						<tr class="activity_prize">
							<td>
								<select class="w130 select2 form-control" name="prize_level[]">
									<option value="" >{lang key='market::market.please_select'}</option>
									<option value="0" {if $prize.prize_level eq 0}selected{/if}>{lang key='market::market.grand_prize'}</option>
									<option value="1" {if $prize.prize_level eq 1}selected{/if}>{lang key='market::market.first_prize'}</option>
									<option value="2" {if $prize.prize_level eq 2}selected{/if}>{lang key='market::market.second_prize'}</option>
									<option value="3" {if $prize.prize_level eq 3}selected{/if}>{lang key='market::market.third_prize'}</option>
									<option value="4" {if $prize.prize_level eq 4}selected{/if}>{lang key='market::market.fourth_prize'}</option>
									<option value="5" {if $prize.prize_level eq 5}selected{/if}>{lang key='market::market.fifth_prize'}</option>
                                </select>
							</td>
							<td><input class="w150 input-xlarge form-control" type='text' name='prize_name[]' value="{$prize.prize_name}" /></td>
							
							<td>
								<select  name="prize_type[]" class="w130 span12 select2 form-control">
									<option value="" >{lang key='market::market.please_select'}</option>
									<option value="1" {if $prize.prize_type eq 1}selected{/if}>礼券红包</option>
									<option value="2" {if $prize.prize_type eq 2}selected{/if}>{t}实物奖品{/t}</option>
									<!-- {if $store_id eq 0}  -->
										<option value="3" {if $prize.prize_type eq 3}selected{/if}>{t}积分{/t}</option>
									<!-- {/if}  -->
									<option value="6" {if $prize.prize_type eq 6}selected{/if}>现金红包</option>
									<option value="4" {if $prize.prize_type eq 4}selected{/if}>{lang key='market::market.goods_info'}</option>
									<option value="5" {if $prize.prize_type eq 5}selected{/if}>{lang key='market::market.store_info'}</option>
									<option value="0" {if $prize.prize_type eq 0}selected{/if}>{lang key='market::market.no_prize'}</option>
                                </select>
							</td>
							<td class="prize_value">
								<span {if $prize.prize_type neq '1'}class="ecjiaf-dn"{/if}>
									<select name="prize_value[]" class="w180 span12 select2 form-control">
										<option value="">{lang key='market::market.please_select'}</option>
										<!-- {foreach from=$bonus_list item=bonus } -->
											<option value="{$bonus.type_id}" {if $prize.prize_value eq $bonus.type_id}selected{/if}>{$bonus.type_name}</option>
										<!-- {/foreach} -->
	                                </select>
                                </span>
                                <span  {if $prize.prize_type eq '1'}class="ecjiaf-dn"{/if}>
									<input class="w180 span12 input-xlarge form-control" type='text' name='prize_value_other[]' value="{$prize.prize_value}"/>
								</span>
							</td>
							<td><input class="w100 input-xlarge form-control" type='text' name='prize_number[]' value="{$prize.prize_number}"/></td>
							<td><input class="w100 input-xlarge form-control"  type='text' name='prize_prob[]' value="{$prize.prize_prob}"/></td>
							<td>
								<!-- {if $smarty.foreach.foo_prize.first} -->
	                                <label class="col-md-1">
										<a class="no-underline l_h35" data-toggle="clone-obj-prize" data-parent=".activity_prize" href="javascript:;"><i class="fa fa-plus"></i></a>
									</label>
                                <!-- {else} -->
	                                <label class="col-md-1">
										<a class="no-underline l_h35" data-toggle="remove-obj-prize" data-parent=".activity_prize" href="javascript:;"><i class="fa fa-times ecjiafc-red"></i></a>
									</label>
                                <!-- {/if} -->
							</td>
							<td><input type="hidden" name="prize_id[]" value="{$prize.prize_id}" /></td>
						</tr>
						<!-- {foreachelse} -->
						<tr class="activity_prize">
							<td>
								<select name="prize_level[]" class="w130 span12 select2 form-control">
									<option value="" selected>{lang key='market::market.please_select'}</option>
									<option value="0">{lang key='market::market.grand_prize'}</option>
									<option value="1">{lang key='market::market.first_prize'}</option>
									<option value="2">{lang key='market::market.second_prize'}</option>
									<option value="3">{lang key='market::market.third_prize'}</option>
									<option value="4">{lang key='market::market.fourth_prize'}</option>
									<option value="5">{lang key='market::market.fifth_prize'}</option>
                                </select>
							</td>
							<td><input class="w150 input-xlarge form-control" type='text' name='prize_name[]' /></td>
							<td>
								<select name="prize_type[]" class="w130 span12 select2 form-control">
									<option value="" selected>{lang key='market::market.please_select'}</option>
									<option value="1">{lang key='market::market.bonus'}</option>
									<option value="4">{lang key='market::market.goods_info'}</option>
									<option value="5">{lang key='market::market.store_info'}</option>
									<option value="0">{lang key='market::market.no_prize'}</option>
                                </select>
							</td>
							<td class="prize_value">
								<span class="ecjiaf-dn">
									<select name="prize_value[]" class="w180 span12 select2 form-control">
										<option value="" selected>{lang key='market::market.please_select'}</option>
										<!-- {foreach from=$bonus_list item=bonus } -->
											<option value="{$bonus.type_id}">{$bonus.type_name}</option>
										<!-- {/foreach} -->
	                                </select>
                                </span>
                                <span>
									<input class="w180 input-xlarge form-control" type='text' name='prize_value_other[]'/>
								</span>
							</td>
							<td><input class="w100 input-xlarge form-control" type='text' name='prize_number[]'/></td>
							<td><input class="w100 input-xlarge form-control"  type='text' name='prize_prob[]' /></td>
							<td><label class="col-md-1">
								<a class="no-underline l_h35" data-toggle="clone-obj-prize" data-parent=".activity_prize" href="javascript:;"><i class="fa fa-plus"></i></a>
							</label></td>
						</tr>
						<!-- {/foreach} -->
					</table>
					<div class="modal-footer justify-content-center">
						<input type="submit" value="确定" class="btn btn-outline-primary" />	
						<input type="hidden" name="id" value="{$id}"/>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->