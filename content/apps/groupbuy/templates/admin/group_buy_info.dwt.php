<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.groupbuy_info.init();
	ecjia.admin.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} 
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" enctype="multipart/form-data" name="theForm">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t}活动商品：{/t}</label>
					<div class="controls">
						<select name="goods_id" class="w350 selectgoods" >
						  <!--  {if $action eq 'insert'} -->
					        <option value="0">{t}请先搜索商品,在此生成选项列表...{/t}</option>
					      <!-- {else} -->
					     <option value="{$group_buy.goods_id}">{$group_buy.goods_name}</option>
					      <!-- {/if} -->
					    </select>   
						 <span class="help-block">{t}需要先在“添加团购商品”区域进行商品搜索，在此会生成商品列表，然后再选择即可{/t}</span>
					</div>
				</div>
							
				<div class="control-group formSep" >
					<label class="control-label">{t}保证金：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="deposit" id="deposit" value="{$group_buy.deposit|default:0}" />
					</div>
				</div>
				
				<div class="control-group formSep" >
					<label class="control-label">{t}限购数量：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="restrict_amount" id="restrict_amount" value="{$group_buy.restrict_amount|default:0}" />
						<span class="help-block">{t}达到此数量，团购活动自动结束。0表示没有数量限制。{/t}</span>
					</div>
				</div>
							
				<div class="control-group formSep">
					<label class="control-label">{t}活动开始时间：{/t}</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								<input name="start_time" class="date w350" type="text" placeholder="{t}请选择活动开始时间{/t}" value="{$group_buy.start_time}"/>
							</div>
						</div>
					</div>
				</div>
					
				<div class="control-group formSep">
					<label class="control-label">{t}活动结束时间：{/t}</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								<input name="end_time" class="date w350" type="text" placeholder="{t}请选择活动结束时间{/t}" value="{$group_buy.end_time}"/>
							</div>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">本店售价：</label>
					<div class="controls l_h30">
						{if $shop_price}{$shop_price}{else}0{/if}
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t}价格阶梯：{/t}</label>
					<div class="controls">
						<!-- {foreach from=$group_buy.price_ladder key=key item=item} -->
 								<!-- {if $key eq 0} -->
						  	<div class="goods_type">
								{t}数量达到{/t}&nbsp;<input type="text" name="ladder_amount[]" value="{$item.amount}" class="w70" />&nbsp;&nbsp;
							    {t}享受价格{/t}&nbsp;<input type="text" name="ladder_price[]"  value="{$item.price}"  class="w70" />
							</div>
						 	<!-- {else} -->
						 	<div class="goods_type">
								{t}数量达到{/t}&nbsp;<input type="text" name="ladder_amount[]" value="{$item.amount}" class="w70" />&nbsp;&nbsp;
								{t}享受价格{/t}&nbsp;<input type="text" name="ladder_price[]"  value="{$item.price}"  class="w70" />
							</div>
						  	<!-- {/if} -->
					  	<!-- {/foreach} -->
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t}活动说明：{/t}</label>
					<div class="controls">
						<textarea class="w350" name="act_desc">{$group_buy.act_desc}</textarea>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->