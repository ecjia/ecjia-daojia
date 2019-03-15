<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.express.info();
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
                          	<label class="control-label col-lg-2">{t domain="shipping"}模板名称：{/t}</label>
                           	<div class="col-lg-8">
                              	<input class="form-control" type="text" name="temp_name" value="{$template_name}" />
                              	<span class="help-block">{t domain="shipping"}该名称只在运费模板列表显示，便于管理员查找模板{/t}</span>
                          	</div>
                          	<span class="input-must">*</span>
                       	</div>
                       	
                      	<div class="form-group">
							<label class="control-label col-lg-2">{t domain="shipping"}地区设置：{/t}</label>
							<div class="controls col-lg-8">
								<div class="template-info-item">
									<div class="template-info-head">
										<div class="head-left">{t domain="shipping"}配送至{/t}</div>
										<div class="head-right">{t domain="shipping"}操作{/t}</div>
									</div>
									<div class="template-info-content">
										<div class="content-area" {if $regions}style="display:block"{/if}>
											<ul class="content-area-list" {if $regions}style="display:block"{/if}>
												<!-- {if $regions} -->
													<!-- {foreach from=$regions item=val} -->
													<li><input type="hidden" value="{$val.region_id}" name="regions[]" id="regions_{$val.region_id}"/>{$val.region_name}</li>
													<!-- {/foreach} -->
												<!-- {/if} -->
											</ul>
											<div class="content-area-handle">
												<a data-toggle="modal" href="#chooseRegion">{t domain="shipping"}编辑{/t}</a> &nbsp;|&nbsp; <a class="reset_region ecjiafc-red" href="javascript:;">{t domain="shipping"}移除{/t}</a>
											</div>
										</div>
										<a class="btn btn-primary add_area" data-toggle="modal" href="#chooseRegion" {if $regions}style="display:none"{/if}>{t domain="shipping"}添加地区{/t}</a>
									</div>
								</div>
							</div>
							<span class="input-must">*</span>
					  	</div>
					  	
                       	<div class="form-group">
							<label class="control-label col-lg-2">{t domain="shipping"}快递方式：{/t}</label>
							<div class="controls col-lg-8">
								<div class="template-info-item">
									<div class="template-info-head">
										<div class="head-left">{t domain="shipping"}快递方式{/t}</div>
										<div class="head-right">{t domain="shipping"}操作{/t}</div>
									</div>
									<div class="template-info-shipping">
										<!-- {foreach from=$data item=list} -->
										<div class="info-shipping-item shipping-item-{$list.shipping_id}">
											<div class="info-shipping-left">
											{$list.shipping_name}
											<!-- {if $list.shipping_code != 'ship_cac'} -->：
												<!-- {foreach from=$list.fields name=f item=field} -->
													<input type="hidden" name="{$field.name}" value="{if $field.value}{$field.value}{else}0{/if}" />
													<!-- {if $list.fee_compute_mode == 'by_number'} -->
														<!--{if $field.name == 'item_fee' || $field.name == 'free_money' || $field.name == 'pay_fee'}-->
															{$field.label}（{if $field.value}{$field.value}{else}0{/if}）{if !$smarty.foreach.f.last}，{/if}
														<!-- {/if} -->
													<!--{else}-->
														<!--{if $field.name != 'item_fee' && $field.name != 'fee_compute_mode'}-->
															{$field.label}（{if $field.value}{$field.value}{else}0{/if}）{if !$smarty.foreach.f.last}，{/if}
														<!-- {/if} -->
													<!-- {/if} -->
												<!-- {/foreach} -->
											<!-- {/if} -->
											</div>
											<div class="info-shipping-right">
												<a class="edit_shipping" href="javascript:;" data-shipping="{$list.shipping_id}" data-area="{$list.shipping_area_id}">{t domain="shipping"}编辑{/t}</a> &nbsp;|&nbsp;
												<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="shipping"}您确定要删除该快递方式吗？{/t}' href='{RC_Uri::url("shipping/mh_shipping/remove_shipping", "id={$list.shipping_area_id}")}' title='{t domain="shipping"}{t domain="shipping"}编辑{/t}{/t}x'>{t domain="shipping"}删除{/t}</a>
											</div>
										</div>
										<!-- {/foreach} -->
									</div>
									<div class="template-info-content">
										<a class="btn btn-primary add_shipping" href="javascript:;">{t domain="shipping"}添加快递{/t}</a>
									</div>
								</div>
							</div>
							<span class="input-must">*</span>
					  	</div>
					  
                 		<div class="form-group">
							<div class="col-lg-offset-2 col-lg-6">
								<input type="hidden" name="template_name" value="{$template_name}"/>
								<input type="submit" value='{t domain="shipping"}确定{/t}' class="btn btn-info" />
							</div>
						</div>
                  	</form>
              	</div>
          	</div>
      	</section>
  	</div>
</div>

<div class="modal fade" id="chooseRegion">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>{t domain="shipping"}选择地区{/t}</h3>
			</div>
			<div class="modal-body form-horizontal">
				<ul class="select-region">
				</ul>
				<div class="form-group">
					<div class="ms-container ms-shipping" id="ms-custom-navigation">
						<div class="ms-selectable col-lg-3">
							<div class="search-header">
								<input class="form-control" type="text" placeholder='{t domain="shipping"}搜索省份{/t}' autocomplete="off" id="selProvinces" />
							</div>
							<ul class="ms-list nav-list-ready selProvinces" data-url="{url path='merchant/region/init' args='target=selCities&type=1'}" data-next="selCities">
								<!-- {foreach from=$provinces item=province key=key} -->
								<li class="ms-elem-selectable" data-val="{$province.region_id}"><span>{$province.region_name|escape:html}</span><span class="edit-list"><a href="javascript:;">{t domain="shipping"}添加{/t}</a></span></li>
								<!-- {foreachelse} -->
								<li class="ms-elem-selectable" data-val="0"><span>{t domain="shipping"}没有可选的省份地区……{/t}</span></li>
								<!-- {/foreach} -->
							</ul>
						</div>

						<div class="ms-selectable col-lg-3">
							<div class="search-header">
								<input class="form-control" type="text" placeholder='{t domain="shipping"}搜索市{/t}' autocomplete="off" id="selCities" />
							</div>
							<ul class="ms-list nav-list-ready selCities" data-url="{url path='merchant/region/init' args='target=selDistricts&type=2'}" data-next="selDistricts">
								<li class="ms-elem-selectable" data-val="0"><span>{t domain="shipping"}请选择市{/t}</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable col-lg-3">
							<div class="search-header">
								<input class="form-control" type="text" placeholder='{t domain="shipping"}搜索区/县{/t}' autocomplete="off" id="selDistricts" />
							</div>
							<ul class="ms-list nav-list-ready selDistricts" data-url="{url path='merchant/region/init' args='target=selStreets&type=3'}" data-next="selStreets">
								<li class="ms-elem-selectable" data-val="0"><span>{t domain="shipping"}请先选择市/区名称...{/t}</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable col-lg-3">
							<div class="search-header">
								<input class="form-control" type="text" placeholder='{t domain="shipping"}搜索街道镇{/t}' autocomplete="off" id="selStreets" />
							</div>
							<ul class="ms-list nav-list-ready selStreets">
								<li class="ms-elem-selectable" data-val="0"><span>{t domain="shipping"}请选择街道/镇{/t}</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="form-group t_c">
					<a class="btn btn-primary close_model" data-dismiss="modal">{t domain="shipping"}确定{/t}</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addShipping">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>{t domain="shipping"}选择快递{/t}</h3>
			</div>
			<div class="modal-body">
				<form class="cmxform form-horizontal tasi-form min_h335" name="shippingForm" method="post" action="{$shipping_form_action}">
					<div class="form-group">
						<label class="control-label col-lg-4">{t domain="shipping"}快递方式：{/t}</label>
						<div class="controls col-lg-6">
							<select name="shipping_id" class="w300 form-control shipping_list" data-url='{url path="shipping/mh_shipping/get_shipping_info"}'>
								<option value="-1">{t domain="shipping"}请选择快递方式...{/t}</option>
								<!-- {foreach from=$shipping item=val} -->
								<option value="{$val.id}">{$val.name}</option>
								<!-- {/foreach} -->
					        </select>
					        <span class="input-must m_l15">*</span>
						</div>
					</div>
					<div id="shipping_info"></div>
					<div class="form-group">
						<label class="control-label col-lg-4"></label>
						<div class="controls col-lg-6">
							<input type="hidden" name="shipping_area_id" />
							<input type="hidden" name="shipping" />
							<input type="hidden" name="temp_name" />
							<input type="hidden" name="template_name" value="{$template_name}"/>
							<input type="submit" value='{t domain="shipping"}确定{/t}' class="btn btn-primary add-shipping-btn" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->