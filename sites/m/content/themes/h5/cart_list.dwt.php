<?php
/*
Name: 购物车列表模板
Description: 购物车列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->

<div class="ecjia-flow-cart-list">
	<!-- {if $not_login} -->
	<div class="flow-no-pro">
		<div class="ecjia-nolist">
			您还没有登录
			<a class="btn btn-small" type="button" href="{url path='user/user_privilege/login'}{if $referer_url}&referer_url={$referer_url}{/if}">{t}点击登录{/t}</a>
		</div>
	</div>
	<!-- {else} -->
		<!-- {if $cart_list} -->
			<div class="ecjia-flow-cart">
				<div class="a4t">
					<div class="a4u a4u-green">
						<div class="a4v">
							<div class="a4v-address">
								{if $address_id gt 0}
									{$address_info.address}
								{else}
									{$smarty.cookies.location_name}
								{/if}
							</div>
							<i>(当前位置)</i>
						</div>
					</div>
					<!-- {foreach from=$cart_list.local item=val} -->
					<div class="a4w current_place">
						<div class="a4p">
							<a class="a4x" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.seller_id}&from=cart">
								{$val.seller_name}
								{if $val.manage_mode eq 'self'}<span class="self-store">自营</span>{/if}
							</a>
							<div class="a4y {if $val.total.goods_number gt 3}a50{/if}">
								<ul>
									<!-- {foreach $val.goods_list key=key item=v} -->
									<li data-rec="{$v.rec_id}">
										<img src="{$v.img.thumb}">
										{if $v.is_disabled eq 1}
										<div class="product_empty">{$v.disabled_label}</div>
										{/if}
										<em>{if $v.goods_price eq 0}免费{else}{$v.formated_goods_price}{/if}</em>
										{if $v.goods_number gt 1 && $v.is_disabled neq 1}
										<i>{if $v.goods_number gt 99}99+{else}{$v.goods_number}{/if}</i>
										{/if}
									</li>
									<!-- {/foreach} -->
								</ul>
								{if $val.total.goods_number gt 3}
								<div class="a4z">共{$val.total.goods_number}件</div>
								{/if}
							</div>
						</div>
						<div class="w4 remove_all" data-store="{$cart_list.local.0.seller_id}"><span>删除</span></div>
					</div>
					<!-- {foreachelse} -->
					<div class="a57"><span>当前位置购物车空空如也哦～</span></div>
					<!-- {/foreach} -->
					
					<!-- {if $cart_list.other} -->
					<div class="a4u a4u-gray"><div class="a4v"><i>其他位置</i></div></div>
					<!-- {foreach from=$cart_list.other item=val} -->
					<div class="a4w other_place">
						<div class="a4p">
							<a class="a4x" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.seller_id}&from=cart&out=1">
								{$val.seller_name}
								{if $val.manage_mode eq 'self'}<span class="self-store">自营</span>{/if}
							</a>
							<div class="a4y {if $val.total.goods_number gt 3}a50{/if}">
								<ul>
									<!-- {foreach $val.goods_list key=key item=v} -->
									<li data-rec="{$v.rec_id}">
										<img src="{$v.img.thumb}">
										{if $v.is_disabled eq 1}
										<div class="product_empty">{$v.disabled_label}</div>
										{/if}
										<em>{if $v.goods_price eq 0}免费{else}{$v.formated_goods_price}{/if}</em>
										{if $v.goods_number gt 1 && $v.is_disabled neq 1}
										<i>{if $v.goods_number gt 99}99+{else}{$v.goods_number}{/if}</i>
										{/if}
									</li>
									<!-- {/foreach} -->
								</ul>
								{if $val.total.goods_number gt 3}
								<div class="a4z">共{$val.total.goods_number}件</div>
								{/if}
							</div>
						</div>
						<div class="w4 remove_all" data-store="{$cart_list.other.0.seller_id}"><span>删除</span></div>
					</div>
					<!-- {/foreach} -->
					<!-- {/if} -->
				</div>
				<input type="hidden" name="update_cart_url" value="{RC_Uri::url('cart/index/update_cart')}" />
			</div>
		<!-- {else} -->
		<div class="flow-no-pro">
			<div class="ecjia-nolist">
				您还没有添加商品
				<a class="btn btn-small" type="button" href="{url path='touch/index/init'}">{t}去逛逛{/t}</a>
			</div>
		</div>
		<!-- {/if} -->
	<!-- {/if} -->
	<input type="hidden" name="index_url" value="{RC_Uri::url('touch/index/init')}" />
</div>
<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}