<?php
/*
Name: 订单合计
Description: 这是给结算页面使用的订单合计模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div id="total_number">
	<ul class="ecjia-list">
	      {if 0}
		      <!-- {if ecjia::config('use_integral')} 是否使用积分-->
		      <li>获得积分：<span class="cart-order">{$total.will_get_integral}积分</span></li>
		      <!-- {/if} -->
	      {/if}
	
	      <!-- {if ecjia::config('use_bonus') && $total.will_get_bonus gt 0} 是否使用红包-->
	      <li>获得{$lang.bonus}：<span class="cart-order">{$total.will_get_bonus}{$lang.bonus}</span></li>
	      <!-- {/if} -->
	
	      <!-- 总价 -->
	      <li>{$lang.goods_all_price}: <span class="cart-order">{$total.goods_price_formated}</span></li>
	
	      <!-- {if $total.discount gt 0} 折扣 -->
	      <li>{$lang.discount}:<span class="cart-order ecjia-color-green">-{$total.discount_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.tax_fee gt 0} 税 -->
	      <li>{$lang.tax}:<span class="cart-order">{$total.tax_fee_formated}</span></li>
	      <input type="hidden" name="inv_type" value="{$temp.inv_type}" />
	      <input type="hidden" name="need_inv" value="{$temp.need_inv}" />
	      <input type="hidden" name="inv_payee" value="{$temp.inv_payee}" />
	      <input type="hidden" name="inv_content" value="{$temp.inv_content}" />
	      <!-- {/if} -->
	
	      <!--  配送费用 -->
	      <li>运费:<span class="cart-order">{$total.shipping_fee_formated}</span></li>
	
	      <!-- {if $total.shipping_insure > 0} 保价费用 -->
	      <li>{$lang.insure_fee}:<span class="cart-order">{$total.shipping_insure_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.pay_fee > 0} 支付手续费 -->
	      <li>{$lang.pay_fee}:<span class="cart-order">{$total.pay_fee_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.pack_fee > 0} 包装费用-->
	      <li>{$lang.pack_fee}:<span class="cart-order">{$total.pack_fee_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.card_fee > 0} 贺卡费用-->
	      <li>{$lang.card_fee}:<span class="cart-order">{$total.card_fee_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.surplus > 0 or $total.integral > 0 or $total.bonus > 0} 使用余额或积分或红包 -->
	      <!-- {if $total.surplus > 0} 使用余额 -->
	      <li> {$lang.use_surplus}:<span class="cart-order">{$total.surplus_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.integral > 0} 使用积分 -->
	      <li>  {$lang.use_integral}:<span class="cart-order">{$total.integral_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.bonus > 0} 使用红包 -->
	      <li> {$lang.use_bonus}:<span class="cart-order">{$total.bonus_formated}</span></li>
	      <!-- {/if} -->
	      <!-- {/if} 使用余额或积分或红包 -->
	
	      <!-- 总金额 -->
	      <!-- <li>{$lang.total_fee}: <span class="cart-order">{$total.amount_formated}</span></li> -->
	
	      <!-- {if $is_group_buy} -->
	      <li>{$lang.notice_gb_order_amount}</li>
	      <!-- {/if}  -->
	
	      <!--{if $total.exchange_integral }消耗积分-->
	      <li>{$lang.notice_eg_integral}<span class="cart-order">{$total.exchange_integral}</span></li>
	      <!--{/if}-->
	</ul>
</div>