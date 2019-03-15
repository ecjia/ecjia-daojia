<?php
/*
Name: 申请售后模板
Description: 这是申请售后首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form name='theForm' action="{url path='user/order/add_return'}" enctype="multipart/form-data" method="post">
	<div class="ecjia-order-detail">
		<div class="ecjia-checkout ecjia-margin-b">
			<div class="flow-goods-list">
				<ul class="goods-item">
					<!-- {foreach from=$order.goods_list item=goods} -->
					<li>
						<div class="ecjiaf-fl goods-img">
							<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
						</div>
						<div class="ecjiaf-fl goods-info">
							<p class="ecjia-truncate2">{$goods.name}</p>
							<p class="ecjia-goods-attr goods-attr">
							<!-- {foreach from=$goods.goods_attr item=attr} -->
							{if $attr.name}{$attr.name}:{$attr.value}{/if}
							<!-- {/foreach} -->
							</p>
							<p class="ecjia-color-red goods-attr-price">{$goods.formated_shop_price}</p>
						</div>
						<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				
				<ul class="ecjia-list">
					<div class="return-fee-list">
						<p>{t domain="h5"}退商品金额{/t}<span class="ecjiaf-fr">{$refund_fee_info.refund_goods_amount}</span></p>
						{if $refund_fee_info.refund_shipping_fee neq '0'}
						<p>{t domain="h5"}退配送费{/t}<span class="ecjiaf-fr">{$refund_fee_info.refund_shipping_fee}</span></p>
						{/if}
						{if $refund_fee_info.refund_integral neq '0'}
						<p>{t domain="h5"}退{/t}{$integral_name}<span class="ecjiaf-fr ">{$refund_fee_info.refund_integral}</span></p>
						{/if}
						{if $refund_fee_info.refund_inv_tax neq '0'}
						<p>{t domain="h5"}退发票{/t}<span class="ecjiaf-fr ">{$refund_fee_info.refund_inv_tax}</span></p>
						{/if}
						<p>{t domain="h5"}退总金额{/t}<span class="ecjiaf-fr ecjia-red">{$refund_fee_info.refund_total_amount}</span></p>
					</div>
					<li class="notice">
						<div class="notice-content">
							<span class="title">{t domain="h5"}温馨提示：{/t}</span>
							<div class="content">
							{t domain="h5"}1.退商品金额是按照您实际支付的商品金额进行退回，如有问题，请联系客服。{/t}<br/>
							{t domain="h5"}2.如需退货请准备好发票，附件等资料，与商品一并寄回。{/t}
							</div>
						</div>
					</li>
					<li class="return-reason">
						<span class="input-must">*</span>
						<span class="title">{t domain="h5"}售后原因{/t}</span>
						<div class="choose_reason">
							<span>{if $refund_info.reason}{$refund_info.reason}{else}{t domain="h5"}请选择售后原因{/t}{/if}</span>
							<img src="{$theme_url}images/address_list/down_eee.png"></i>
							<input type="hidden" name="reason_id" value="{$refund_info.reason_id}"/>
						</div>
					</li>
					<li class="return-reason desc">
						<span class="input-must">*</span>
						<div class="title question-desc-title">{t domain="h5"}问题描述{/t}</div>
						<div class="text question-desc-content">
							<textarea class="question_desc reset_top_text" type="text" name="question_desc" placeholder='{t domain="h5"}请填写问题描述{/t}'>{$refund_info.refund_desc}</textarea>
						</div>
					</li>
					
					<li class="ecjia-met-goods-info">
						<div class="push_img">
							<div class="push_photo_img" id="result"></div>
							
							<!-- {foreach from=$img_list item=list key=k} -->
			            	<div class="push_photo" id="result{$k}">
			            	   <div class="push_result_img">
			            	       <img src="{$theme_url}images/photograph.png">
			            	       <input type="file" class="push_img_btn" id="filechooser{$k}" name="refund_images[]" accept="image/jpeg,image/jpg,image/png,image/bmp,image/gif">
			            	   </div>
			            	</div>
			            	<!-- {/foreach} -->
			            	
		                </div>
		                <p class="push_img_fonz">{t domain="h5"}为了帮助我们更好的解决问题，请上传照片，最多5张。{/t}</p>
					</li>
				</ul>
			</div>
			
			<div class="order-ft-link">
				<input type="hidden" name="order_id" value="{$order_id}">
				<input type="hidden" name="refund_type" value="{$type}">
				<input type="hidden" name="refund_sn" value="{$order.refund_info.refund_sn}">
				
				<input class="btn btn-small btn-hollow" name="add-return-btn" type="submit" value='{t domain="h5"}提交{/t}' />
			</div>
		</div>
	</div>
</form>
<input type="hidden" name="reason_list" value='{$reason_list}'>
<!-- #BeginLibraryItem "/library/shipping_fee_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}