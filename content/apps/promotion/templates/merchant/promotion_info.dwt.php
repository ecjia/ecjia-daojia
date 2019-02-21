<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.promotion_info.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
		{/if}
		</h2>
	</div>
</div>

<div class="row">
  <div class="col-lg-12">
      <section class="panel">
          <div class="panel-body">
              <div class="form">
                  <form class="cmxform form-horizontal tasi-form" name="theForm" method="post" action="{$form_action}">
                  	  <div class="form-group">
                          <label class="control-label col-lg-2">{t domain="promotion"}商品关键字：{/t}</label>
                           <div class="col-lg-6">
                              <input class="form-control" type="text" name="keywords" />
                          </div>
                           <button class="btn btn-primary searchGoods" data-url='{url path="promotion/merchant/search_goods"}' type="button"><i class='fa fa-search'></i> {t domain="promotion"}搜索{/t}</button>
                       </div>
                       <div class="form-group">
							<label class="control-label col-lg-2">{t domain="promotion"}选择活动商品：{/t}</label>
							<div class="controls col-lg-6">
								<select class="goods_list form-control" name="goods_id" >
									<!-- {if !$promotion_info.goods_name} -->
										<option value='-1'>{t domain="promotion"}请选择...{/t}</option>
									<!-- {else} -->
										<option value="{$promotion_info.goods_id}">{$promotion_info.goods_name}</option>
									<!-- {/if} -->
						        </select>
							</div>
							<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					  </div>
					  <div class="form-group">
							<label class="control-label col-lg-2">{t domain="promotion"}活动开始时间：{/t}</label>
							<div class="controls col-lg-6">
								<input class="form-control date"  name="start_time" type="text" placeholder='{t domain="promotion"}请选择活动开始时间{/t}' value="{if $promotion_info.promote_start_date}{$promotion_info.promote_start_date}{else}{$date.sdate}{/if}"/>
							</div>
							<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					  </div>
					  <div class="form-group">
							<label class="control-label col-lg-2">{t domain="promotion"}活动结束时间：{/t}</label>
							<div class="controls col-lg-6">
								<input name="end_time" class="form-control date" type="text" placeholder='{t domain="promotion"}请选择活动结束时间{/t}' value="{if $promotion_info.promote_end_date}{$promotion_info.promote_end_date}{else}{$date.edate}{/if}"/>
							</div>
							<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					  </div>
					  <div class="form-group">
						<label class="control-label col-lg-2">{t domain="promotion"}活动价格：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="price" type="text" value="{$promotion_info.promote_price}"/>
						</div>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					  </div>
                 	 <div class="form-group">
						<div class="col-lg-offset-2 col-lg-6">
							<!-- {if $promotion_info.goods_id} -->
								<input type="submit" value='{t domain="promotion"}更新{/t}' class="btn btn-info" />
								<input type="hidden" name='old_goods_id' value="{$promotion_info.goods_id}">
							<!-- {else} -->
								<input type="submit" value='{t domain="promotion"}确定{/t}' class="btn btn-info" />
							<!-- {/if} -->
						</div>
					</div>
                  </form>
              </div>
          </div>
      </section>
  </div>
</div>
<!-- {/block} -->