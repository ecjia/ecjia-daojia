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
		      <li>{t domain="h5" 1={$integral_name}}获得%1：{/t}<span class="cart-order">{$total.will_get_integral}{$integral_name}</span></li>
		      <!-- {/if} -->
	      {/if}
	
	      <!-- {if ecjia::config('use_bonus') && $total.will_get_bonus gt 0} 是否使用红包-->
	      <li>{t domain="h5"}获得红包：{/t}<span class="cart-order">{$total.will_get_bonus}{t domain="h5"}红包{/t}</span></li>
	      <!-- {/if} -->
	
	      <!-- 总价 -->
	      <li>{t domain="h5"}商品总价：{/t}<span class="cart-order">{$total.goods_price_formated}</span></li>
	
	      <!-- {if $total.discount gt 0} 折扣 -->
	      <li>{t domain="h5"}折扣：{/t}<span class="cart-order ecjia-color-green">-{$total.discount_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.tax_fee gt 0} 税 -->
	      <li>{t domain="h5"}发票税额：{/t}<span class="cart-order">{$total.tax_fee_formated}</span></li>
	      <input type="hidden" name="inv_type" value="{$temp.inv_type}" />
	      <input type="hidden" name="need_inv" value="{$temp.need_inv}" />
	      <input type="hidden" name="inv_payee" value="{$temp.inv_payee}" />
	      <input type="hidden" name="inv_content" value="{$temp.inv_content}" />
	      <!-- {/if} -->
	
	      <!--  配送费用 -->
	      <!-- {if $total.shipping_fee > 0} 支付手续费 -->
	      <li>{t domain="h5"}运费：{/t}<span class="cart-order">{$total.shipping_fee_formated}</span></li>
		  <!-- {/if} -->
	
	      <!-- {if $total.shipping_insure > 0} 保价费用 -->
	      <li>{t domain="h5"}保价费用：{/t}<span class="cart-order">{$total.shipping_insure_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.pay_fee > 0} 支付手续费 -->
	      <li>{t domain="h5"}支付手续费：{/t}<span class="cart-order">{$total.pay_fee_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.pack_fee > 0} 包装费用-->
	      <li>{t domain="h5"}包装费用：{/t}<span class="cart-order">{$total.pack_fee_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.card_fee > 0} 贺卡费用-->
	      <li>{t domain="h5"}贺卡费用：{/t}<span class="cart-order">{$total.card_fee_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.surplus > 0 or $total.integral > 0 or $total.bonus > 0} 使用余额或积分或红包 -->
	      <!-- {if $total.surplus > 0} 使用余额 -->
	      <li>{t domain="h5"}余额付款：{/t}<span class="cart-order">{$total.surplus_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.integral > 0} 使用积分 -->
	      <li>{t domain="h5" 1={$integral_name}}使用%1：{/t}<span class="cart-order">{$total.integral_formated}</span></li>
	      <!-- {/if} -->
	
	      <!-- {if $total.bonus > 0} 使用红包 -->
	      <li>{t domain="h5"}使用红包：{/t}<span class="cart-order">{$total.bonus_formated}</span></li>
	      <!-- {/if} -->
	      <!-- {/if} 使用余额或积分或红包 -->
	
	      <!-- 总金额 -->
	      <!--<li>应付款金额: <span class="cart-order">{$total.amount_formated}</span></li> -->
	
	      <!-- {if $is_group_buy} -->
	      <li>{t domain="h5"}（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）{/t}</li>
	      <!-- {/if}  -->
	
	      <!--{if $total.exchange_integral }消耗积分-->
	      <li>{t domain="h5"}积分商城商品需要消耗积分：{/t}<span class="cart-order">{$total.exchange_integral}</span></li>
	      <!--{/if}-->
	</ul>
</div>