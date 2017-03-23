<?php
/*
Name: 选择商品规格
Description: 这是选择商品规格弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<div class="ecjia-attr-static ecjia-attr-modal">
	<div class="modal-inners">
		<span class="ecjia-close-modal-icon"><i class="iconfont icon-close"></i></span>
		<div class="modal-title"></div>
		<div class="goods-attr-list"></div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<div class="modal-left">
			<span class="goods-attr-price"></span>
			<span class="goods-attr-name"></span>
		</div>
		<div class="ecjia-choose-attr-box box">
			<span class="add add_spec" data-toggle="add-to-cart"></span>
		    <label></label>
		    <span class="reduce remove_spec" data-toggle="remove-to-cart"></span>
		</div>           
		<a class="add-tocart add_spec" data-toggle="add-to-cart">加入购物车</a>
		<input type="hidden" name="goods_price"  />
		<input type="hidden" name="check_spec" value="{RC_Uri::url('cart/index/check_spec')}&store_id={if $goods_info.seller_id}{$goods_info.seller_id}{else}{$store_id}{/if}" />
	</div>
</div>
<div class="ecjia-attr-static-overlay ecjia-attr-static-overlay-visible"></div>
{/nocache}