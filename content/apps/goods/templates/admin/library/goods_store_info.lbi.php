<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="row-fluid">
	<div class="foldable-list move-mod-group" id="merchants_info_sort_cat">
	      <div class="accordion-group">
	           <div class="accordion-heading">
	               <a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#area_one">
	                    <strong>{t domain="promotion"}店铺信息{/t}</strong>
	               </a>
	           </div>
	           <div class="accordion-body in in_visable collapse" id="area_one">
	               <div class="accordion-inner">
	                   <div class="merchants_info">
	                       <div class="logo-info">
	                           <img src="{$goods.shop_logo}" alt="">
	                           <div class="info">
	                               <div class="name">{$goods.merchants_name}</div>
	                               <span class="self-mode">{$goods.manage_mode}</span>
	                           </div>
	                       </div>
	
	                       <div class="other-info">
	                           <div class="info-item"><label>营业时间：</label>
	                               <div class="content">{$goods.shop_trade_time}</div>
	                           </div>
	                           <div class="info-item"><label>商家电话：</label>
	                                <div class="content">{$goods.shop_kf_mobile}</div>
	                           </div>
	                           <div class="info-item"><label>商家地址：</label>
	                                <div class="content">{$goods.shop_address}</div>
	                           </div>
	                       </div>
	                   </div>
	               </div>
	          </div>
	      </div>
	</div>
</div>
 

            
            


