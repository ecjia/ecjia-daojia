<?php defined('IN_ECJIA') or exit('No permission resources.');?>


<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">配送详情</h4>
        </div>
        <div class="modal-body">
			<div class="express_content">
				<div class="express_order">
					<span>配送单号：<font class="ecjiafc-red">{$content.express_sn}</font></span>
					<span>配送状态：<font class="ecjiafc-red"> 已完成   </font></span>
					<span>取货距离：<font class="ecjiafc-red">{$content.distance}</font> m</span>
					<span>运费：<font class="ecjiafc-red">{$content.commision}</font> 元</span>
				</div>
				
				<div class="pickup_info">
					<ul>
						<li><font class="express_title">取货信息</font></li>
						<li>商家名称：<span>{$content.merchants_name}</span></li>
						<li>商家电话：<span>{$content.contact_mobile}</span></li>
						<li>下单时间：<span>{$content.add_time}</span></li>
						<li>取货地址：<span>{$content.all_address}&nbsp;&nbsp;{$content.address}</span></li>
					</ul>
				</div>
				
				<div class="delivery_info">
					<ul>
						<li><font class="express_title">送货信息</font></li>
						<li>收货人名称：<span>{$content.consignee}</span></li>
						<li>收货人电话：<span>{$content.mobile}</span></li>
						<li>期望送达时间：<span>{$content.expect_shipping_time}</span></li>
						<li>送货地址：<span>{$content.express_all_address}&nbsp;&nbsp;{$content.eoaddress}</span></li>
					</ul>
				</div>
				
				<div class="shipping_info_over">
					<ul>
						<li><font class="express_title">配送信息</font></li>
						<li>配送员名称：<span>{$content.express_user}</span></li>
						<li>配送员电话：<span>{$content.express_mobile}</span></li>
						<li>任务类型：<span>{if $content.from eq 'assign'}派单{else}抢单{/if}</span></li>
						<li>完成时间：<span>{$content.signed_time}</span></li>
					</ul>
				</div>
				
				<div class="order_info">
					<ul>
			         	<li><font class="express_title">订单信息</font></li>
			            <li>
			            	<div class="order">订单编号：<a  href='{url path="orders/merchant/info" args="order_id={$content.order_id}"}' target="_blank">{$content.order_sn}</a></div>
			            	<div class="order">发货单号：<a  href='{url path="orders/mh_delivery/delivery_info" args="delivery_id={$content.delivery_id}"}' target="_blank">{$content.delivery_sn}</a></div>
			            </li>
			        </ul>
				</div>
				
				<div class="order_goods">
					<ul>
			         	<li><font class="express_title">发货单商品</font></li>
			         	<!-- {foreach from=$goods_list item=list} -->
			            <li class="goodslist">
			            	<div class="goods-info">
				            	<div class="info-left" ><img src="{$list.image}" width="50" height="50" /></div>
				            	<div class="info-right">
					            	<span>{$list.goods_name}</span><span class="goods_number">数量：X{$list.send_number}</span>
					            	<p>{$list.formated_goods_price} </p>
				            	</div>
			            	</div>
			            </li>
		            <!-- {/foreach} -->
			        </ul>
				</div>
				
				<div class="order_desc">
					<ul>
			         	<li><font class="express_title">订单备注</font></li>
			            <li>{if $content.postscript}{$content.postscript}{else}此用户没有填写备注内容{/if}</li>
			        </ul>
				</div>
			</div>
		</div>
    </div>
</div>
