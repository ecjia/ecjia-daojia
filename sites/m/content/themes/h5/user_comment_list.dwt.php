<?php
/*
Name: 评价晒单
Description: 获取订单内所有商品
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div>
    <li class="ecjia-order-item ecjia-checkout">
    	<div class="flow-goods-list">
    		<!-- {foreach from=$goods_list item=goods name=goods} -->
    			<ul class="goods-item ecjia-comment-list">
    				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon">
    					<img class="ecjiaf-fl ecjia-margin-r" src="{$goods.img.thumb}" alt="{$goods.goods_name}" title="{$goods.name}" />
    					<div class="comment_list_attr">
        					<span class="ecjiaf-fl cmt-goods-name">{$goods.goods_name}</span>
        					<p class="ecjiaf-fl cmt-goods-attribute">
        					<!-- {foreach from=$goods.goods_attr item=attr} -->
    						{if $attr.name}{$attr.name}:{$attr.value}{/if}
    					    <!-- {/foreach} -->
    					    </p>
    					    <span class="ecjiaf-fl cmt-goods-price">{$goods.goods_price}</span>
    					    <span class="ecjiaf-fr btn-comment">
        		              <a class="nopjax external btn btn-hollow" href='{url path="user/order/goods_comment" args="goods_id={$goods.goods_id}&order_id={$order_id}&rec_id={$goods.rec_id}&is_commented={$goods.is_commented}&is_showorder={$goods.is_showorder}"}'>{if $goods.is_commented eq 1}{if $goods.is_showorder eq 1}查看评价{else}追加晒图{/if}{else}发表评价{/if}</a>
        		            </span>
					    </div>
    				</li>
    			</ul>
    		<!-- {/foreach} -->
    	   </div>
    	</div>
    </li>
</div>
<!-- {/block} -->