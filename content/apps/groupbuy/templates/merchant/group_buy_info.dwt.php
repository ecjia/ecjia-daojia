<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.groupbuy_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
        {/if}
        </h2>
    </div>
</div>

<form class="cmxform form-horizontal tasi-form" name="theForm" method="post" action="{$form_action}">
	<div class="row">
	  	<div class="col-lg-12">
	      	<section class="panel">
	      		<div class="panel-body">
                    {if $group_buy.act_id}
                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="groupbuy"}团购状态：{/t}</label>
                        <div class="col-lg-6 l_h30">
                            <span class="groupbuy-status groupbuy-status-{$group_buy.status}">
                                {if $group_buy.status eq 0}
                                {t domain="groupbuy"}活动未开始{/t}
                                {else if $group_buy.status eq 1}
                                {t domain="groupbuy"}活动进行中{/t}
                                {else if $group_buy.status eq 2}
                                {t domain="groupbuy"}结束未处理{/t}
                                {else if $group_buy.status eq 3}
                                {t domain="groupbuy"}成功结束{/t}
                                {else if $group_buy.status eq 4}
                                {t domain="groupbuy"}失败结束{/t}
                                {/if}
                            </span>
                        </div>
                    </div>
                    {/if}

                    <div class="form-group">
                          <label class="control-label col-lg-2">{t domain="groupbuy"}商品关键字：{/t}</label>
                           <div class="col-lg-6">
                              <input class="form-control" type="text" name="keywords" {if $group_buy.status neq 0}disabled{/if}/>
                          </div>
                           <button class="btn btn-primary searchGoods" data-url='{url path="#merchant/search_goods"}' type="button" {if $group_buy.status neq 0}disabled{/if}><i class='fa fa-search'></i> 搜索</button>
               		</div>

					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="groupbuy"}选择活动商品：{/t}</label>
						<div class="col-lg-6">
							<select name="goods_id" class="col-lg-12 goods_list" {if $group_buy.status neq 0}disabled{/if}>
							  <!--  {if $action eq 'insert'} -->
						        <option value="0">{t domain="groupbuy"}请先搜索商品,在此生成选项列表...{/t}</option>
						      <!-- {else} -->
						     <option value="{$group_buy.goods_id}">{$group_buy.goods_name}</option>
						      <!-- {/if} -->
						    </select>
						</div>
						<span class="input-must">*</span>
					</div>

					<div class="form-group" >
						<label class="control-label col-lg-2">{t domain="groupbuy"}保证金：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="deposit" id="deposit" value="{$group_buy.deposit|default:0}" {if $group_buy.status neq 0}disabled{/if} />
                            <span class="help-block">{t domain="groupbuy"}买家参与该团购活动时，需要预先支付的金额。{/t}</span>
						</div>
                        <span class="input-must">*</span>
					</div>

					<div class="form-group" >
						<label class="control-label col-lg-2">{t domain="groupbuy"}限购数量：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="restrict_amount" id="restrict_amount" value="{$group_buy.restrict_amount|default:0}" {if $group_buy.status neq 0 && $group_buy.status neq 1}disabled{/if}/>
							<span class="help-block">{t domain="groupbuy"}限购数量不可大于商品库存，0表示最大库存数量。{/t}</span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="groupbuy"}活动开始时间：{/t}</label>
						<div class="col-lg-6">
							<input name="start_time" class="date form-control" type="text" placeholder="{t domain="groupbuy"}请选择活动开始时间{/t}" value="{$group_buy.start_time}" {if $group_buy.status neq 0}disabled{/if}/>
						</div>
						<span class="input-must">*</span>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="groupbuy"}活动结束时间：{/t}</label>
						<div class="col-lg-6">
							<input name="end_time" class="date form-control" type="text" placeholder="{t domain="groupbuy"}请选择活动结束时间{/t}" value="{$group_buy.end_time}"/>
						</div>
						<span class="input-must">*</span>
					</div>

					<div class="form-group" >
						<label class="control-label col-lg-2">{t domain="groupbuy"}本店售价：{/t}</label>
						<div class="col-lg-6 l_h30" id="shop_price">{if $shop_price}{$shop_price}{else}0{/if}</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="groupbuy"}价格阶梯：{/t}</label>
						<div class="col-lg-6">
							<!-- {foreach from=$group_buy.price_ladder key=key item=item} -->
	 							<!-- {if $key eq 0} -->
							  	<div class="time-picker">
									{t domain="groupbuy"}数量达到{/t}&nbsp;<input type="text" name="ladder_amount[]" value="{$item.amount}" class="w70 form-control" {if $group_buy.status neq 0}disabled{/if}/>&nbsp;&nbsp;
								    {t domain="groupbuy"}享受价格{/t}&nbsp;<input type="text" name="ladder_price[]"  value="{$item.price}"  class="w70 form-control" {if $group_buy.status neq 0}disabled{/if}/>
                                    {if $group_buy.status eq 0}
									<a class="no-underline" data-toggle="clone-obj" data-parent=".time-picker" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    {/if}
								</div>
							 	<!-- {else} -->
							 	<div class="time-picker">
									{t domain="groupbuy"}数量达到{/t}&nbsp;<input type="text" name="ladder_amount[]" value="{$item.amount}" class="w70 form-control" {if $group_buy.status neq 0}disabled{/if}/>&nbsp;&nbsp;
									{t domain="groupbuy"}享受价格{/t}&nbsp;<input type="text" name="ladder_price[]"  value="{$item.price}"  class="w70 form-control" {if $group_buy.status neq 0}disabled{/if}/>
                                    {if $group_buy.status eq 0}
									<a class="no-underline" data-toggle="remove-obj" data-parent=".time-picker" href="javascript:;"><i class="fa fa-times"></i></a>
                                    {/if}
								</div>
							  	<!-- {/if} -->
						  	<!-- {/foreach} -->
                            <div class="help-block">{t domain="groupbuy"}价格阶梯的数量指以全部用户团购的最终购买数的价格为准。{/t}</div>
						</div>
						<span class="input-must">*</span>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="groupbuy"}活动说明：{/t}</label>
						<div class="col-lg-6">
							<textarea class="form-control" name="act_desc" rows="6" cols="40">{$group_buy.act_desc}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<input name="act_id" type="hidden" id="act_id" value="{$group_buy.act_id}">
							{if $group_buy.status neq 4 && $group_buy.status neq 3 && $group_buy.status neq 2}
						    <input type="submit" name="submit" value='{if $group_buy.act_id}{t domain="groupbuy"}更新{/t}{else}{t domain="groupbuy"}确定{/t}{/if}' class="btn btn-info" />&nbsp;
						   	{/if}

						   	<!-- 进行中 -->
						    {if $group_buy.status eq 1}
						    <input type="submit" name="finish" value='{t domain="groupbuy"}结束活动{/t}' class="btn btn-info all" />&nbsp;

						    <!-- 结束未处理 -->
						    {elseif $group_buy.status eq 2}
						    <input type="submit" name="succeed" value='{t domain="groupbuy"}活动成功{/t}' class="btn btn-info all" />
						    <input type="submit" name="fail" value='{t domain="groupbuy"}活动失败{/t}' class="btn btn-info all" />
                            {/if}
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</form>
<!-- {/block} -->