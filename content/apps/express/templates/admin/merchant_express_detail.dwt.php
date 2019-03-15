<?php defined('IN_ECJIA') or exit('No permission resources.');?>
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t domain="express"}配送详情{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="express_content">
			<div class="express_order">
				<span>{t domain="express"}配送单号：{/t}<font class="ecjiafc-red">{$content.express_sn}</font></span>
				<span>{t domain="express"}配送状态：{/t}<font class="ecjiafc-red">{if $content.status eq 0}<font class="ecjiafc-red">{t domain="express"}待抢单{/t}</font>{elseif $content.status eq 1}<font class="ecjiafc-red">{t domain="express"}待取货{/t}</font>{elseif $content.status eq 2}<font class="ecjiafc-red">{t domain="express"}配送中{/t}</font>{elseif $content.status eq 3}{t domain="express"}退货中{/t}{elseif $content.status eq 4}{t domain="express"}已拒收{/t}{elseif $content.status eq 5}{t domain="express"}已完成{/t}{else}{t domain="express"}已退回{/t}{/if}</font></span>
				<span>{t domain="express"}取货距离：{/t}<font class="ecjiafc-red">{$content.distance}</font> m</span>
				<span>{t domain="express"}运费：{/t}<font class="ecjiafc-red">¥{$content.commision}</font> {t domain="express"}元{/t}</span>
			</div>
			
			<div class="pickup_info">
				<ul>
					<li><h3>{t domain="express"}取货信息{/t}</h3></li><li>{t domain="express"}商家名称：{/t}<span>{$content.merchants_name}</span></li>
					<li>{t domain="express"}商家电话：{/t}<span>{$content.contact_mobile}</span></li>
					<li>{t domain="express"}下单时间：{/t}<span>{$content.add_time}</span></li>
					<li>{t domain="express"}取货地址：{/t}<span>{$content.all_address}&nbsp;&nbsp;{$content.address}</span></li>
				</ul>
			</div>
			
			<div class="delivery_info">
				<ul>
					<li><h3>{t domain="express"}送货信息{/t}</h3></li>
					<li>{t domain="express"}收货人名称：{/t}<span>{$content.consignee}</span></li>
					<li>{t domain="express"}收货人电话：{/t}<span>{$content.mobile}</span></li>
					<li>{t domain="express"}期望送达时间：{/t}<span>{$content.expect_shipping_time}</span></li>
					<li>{t domain="express"}送货地址：{/t}<span>{$content.express_all_address}&nbsp;&nbsp;{$content.eoaddress}</span></li>
				</ul>
			</div>
			{if $content.status neq 0}
			<div class="shipping_info">
				<ul>
					<li><h3>{t domain="express"}配送信息{/t}</h3></li>
					<li>{t domain="express"}配送员名称：{/t}<span>{$content.express_user}</span></li>
					<li>{t domain="express"}配送员电话：{/t}<span>{$content.express_mobile}</span></li>
					<li>{t domain="express"}任务类型：{/t}<span>{$content.from}</span></li>
				</ul>
			</div>
			{/if}
			<div class="order_info">
				<ul>
		         	<li><h3>{t domain="express"}订单信息{/t}</h3></li>
		            <li>
		            	<div class="order">{t domain="express"}订单编号：{/t}<a  href='{url path="orders/admin/info" args="order_id={$content.order_id}"}' target="_blank">{$content.order_sn}</a></div>
		            	<div class="order">{t domain="express"}发货单号：{/t}<a  href='{url path="orders/admin_order_delivery/delivery_info" args="delivery_id={$content.delivery_id}"}' target="_blank">{$content.delivery_sn}</a></div>
		            </li>
		        </ul>
			</div>
			<div class="order_goods">
				<ul>
		         	<li><h3>{t domain="express"}发货单商品{/t}</h3></li>
		         	<!-- {foreach from=$goods_list item=list} -->
			            <li class="goodslist">
			            	<div class="goods-info">
				            	<div class="info-left" ><img src="{$list.image}" width="50" height="50" /></div>
				            	<div class="info-right">
					            	<span>{$list.goods_name}</span><span class="goods_number">{t domain="express"}数量：{/t}X{$list.send_number}</span>
					            	<p>{$list.formated_goods_price} </p>
				            	</div>
			            	</div>
			            </li>
		            <!-- {/foreach} -->
		        </ul>
			</div>
			
			<div class="order_desc">
				<ul>
		         	<li><h3>{t domain="express"}订单备注{/t}</h3></li>
		            <li>{if $content.postscript}{$content.postscript}{else}{t domain="express"}此用户没有填写备注内容{/t}{/if}</li>
		        </ul>
			</div>
		</div>
	</div>