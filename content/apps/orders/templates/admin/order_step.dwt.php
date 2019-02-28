<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order.addedit();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $shipping_list_error}
<div class="alert alert-error">
	<strong>{t domain="orders"}您可能没有添加配送插件或填写收货人地址信息！暂无对应的配送方式！{/t}</strong>
</div>
{/if}
{if $step eq "invoice"}
<div class="alert alert-info">
	<strong>{t domain="orders"}说明：因为订单已发货，修改配送方式将不会改变配送费和保价费。{/t}</strong>
</div>
{/if}
{if $step eq "user"}
<div class="alert alert-info">
	<strong>{t domain="orders"}注意：搜索结果只显示前50条记录，如果没有找到相应会员，请更精确地查找。另外，如果该会员是从论坛注册的且没有在商城登录过，也无法找到，需要先在商城登录。{/t}</strong>
</div>
{/if}
{if $step_act eq 'add'}
<div class="order-time-base m_b20">
	<ul class="">
		<li class="step-first">
			<div class="{if $time_key lt '2'}step-cur{else}step-done{/if}">
				<div class="step-no">{if $time_key lt '2'}1{/if}</div>
				<div class="m_t5">{t domain="orders"}选择购买用户{/t}</div>
			</div>
		</li>
		<li>
			<div class="{if $time_key eq '2'}step-cur{elseif $time_key gt '2'}step-done{/if}">
				<div class="step-no">{if $time_key lt '3'}2{/if}</div>
				<div class="m_t5">{t domain="orders"}选择订单商品{/t}</div>
			</div>
		</li>
		<li>
			<div class="{if $time_key eq '3'}step-cur{elseif $time_key gt '3'}step-done{/if}">
				<div class="step-no">{if $time_key lt '4'}3{/if}</div>
				<div class="m_t5">{t domain="orders"}确认收货地址{/t}</div>
			</div>
		</li>
		<li>
			<div class="{if $time_key eq '4'}step-cur{elseif $time_key gt '4'}step-done{/if}">
				<div class="step-no">{if $time_key lt '5'}4{/if}</div>
				<div class="m_t5">{t domain="orders"}支付方式/配送方式{/t}</div>
			</div>
		</li>
		<li>
			<div class="{if $time_key eq '6'}step-cur{elseif $time_key gt '6'}step-done{/if}">
				<div class="step-no">{if $time_key lt '7'}5{/if}</div>
				<div class="m_t5">{t domain="orders"}其他信息{/t}</div>
			</div>
		</li>
		<li class="step-last">
			<div class="{if $time_key eq '7'}step-cur{/if}">
				<div class="step-no">{if $time_key lt '8'}6{/if}</div>
				<div>{t domain="orders"}确认费用{/t}</div>
			</div>
		</li>
	</ul>
</div>
{/if}
<div style="clear:both;">
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} --><!-- {if $user_name}<small>（当前用户：{$user_name}）</small>{/if} -->
	</h3>
</div>
{if $step eq "user_select"}
<div class="order-select-user h250">
	<ul>
		<a class="anonymous_user ecjiaf-csp" data-href='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}&user=0"}'>
		<li>
			<div class="user-anonymous"></div>
			<div class="user-title">{t domain="orders"}匿名用户{/t}</div>
		</li>
		</a>
		<a class="data-pjax" href='{url path="orders/admin/add" args="step=user"}'>
		<li class="m_l70">
			<div class="user"></div>
			<div class="user-title">{t domain="orders"}会员用户{/t}</div>
		</li>
		</a>
	</ul>
</div>
{/if}
{if $step eq "user"}
<form class="form-horizontal" name="userForm" action='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post" data-search-url='{url path="orders/admin/search_users"}'>
	<fieldset>
<!-- 		<div class="control-group"> -->
<!-- 			<label class="t_l w200"><input type="radio" name="anonymous"  value="1" checked="checked" /><span>&nbsp;匿名用户</span></label> -->
<!-- 		</div> -->
		<div class="control-group">
			<label class="control-label"><span>&nbsp;{t domain="orders"}按会员邮箱或会员名搜索：{/t}</span></label>
			<input type="hidden" name="anonymous" value="0" id="user_useridname" />
			<div class="controls">
				<input type="text" name="keywords" class="f_l m_r5" placeholder='{t domain="orders"}请输入关键字{/t}'/>
				<button class="btn searchUser" type="button">{t domain="orders"}搜索{/t}</button>
				<input type="hidden" name="user" value='0'/>
			</div>
		</div>
		<p><span class="help-inline">{t domain="orders"}搜索会员，搜到的会员将展示在下方列表框中。点击列表中选项，背景变蓝即为选中状态。{/t}</span></p>
		<div class="row-fluid draggable">
			<div class="ms-container ms-container-nobg" id="ms-custom-navigation">
				<div id="userslist" class="ms-selectable ms-not-selectable" data-change-url='{url path="orders/admin/user_info"}'>
					<div class="search-header">
						<input class="span12" id="ms-search" type="text" placeholder='{t domain="orders"}筛选搜索到的会员信息{/t}' autocomplete="off">
					</div>
					<ul class="ms-list nav-list-ready order-select-users">
						<li class="ms-elem-selectable disabled"><span>{t domain="orders"}暂无内容{/t}</span></li>
					</ul>
				</div>
				<div class="ms-selection ms-not-selection order-users-select">
					<div class="custom-header custom-header-align"><span>{t domain="orders"}会员信息{/t}</span>
					</div>
					<div class="ms-list nav-list-content">
						<ul class="ecjiaf-dn users_info">
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}会员名称：{/t}</label>
									<div class="controls" id="user_name">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}会员邮箱：{/t}</label>
									<div class="controls" id="user_email">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}会员手机：{/t}</label>
									<div class="controls" id="user_mobile">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}会员等级：{/t}</label>
									<div class="controls" id="user_rank">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}注册时间：{/t}</label>
									<div class="controls" id="user_regtime">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}邮箱验证：{/t}</label>
									<div class="controls" id="user_isvalidated">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}最后登录时间：{/t}</label>
									<div class="controls" id="user_lasttime">
									</div>
								</div>
							</li>
							<li>
								<div class="control-group">
									<label class="control-label">{t domain="orders"}最后登录IP：{/t}</label>
									<div class="controls" id="user_lastip">
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<p class="ecjiaf-tac m_t15">
			<button class="btn btn-gebo" type="submit">{t domain="orders"}下一步{/t}</button>
			<a class="cancel_order" data-href='{url path="orders/admin/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
		</p>
	</fieldset>
</form>
{elseif $step eq "goods"}
<form name="theForm" action='{url path="orders/admin/step_post" args="step=edit_goods&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<!-- {if $goods_list} -->
	<table class="table order-goods-select form-inline formSep">
		<thead>
			<tr>
				<th class="w200">{t domain="orders"}商品名称{/t}</th>
				<th class="w100">{t domain="orders"}货号{/t}</th>
				<th>{t domain="orders"}价格{/t}</th>
				<th class="w120">{t domain="orders"}数量{/t}</th>
				<th>{t domain="orders"}属性{/t}</th>
				<th class="w100">{t domain="orders"}小计{/t}</th>
				<th class="w150">{t domain="orders"}操作{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$goods_list item=goods name="goods"} -->
			<tr class='edit_order_list'>
				<td>
					{if $goods.goods_id gt 0 && $goods.extension_code neq 'package_buy'}
					<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' id="get_goods_info" target="_blank">{$goods.goods_name}</a>
					{elseif $goods.goods_id gt 0 && $goods.extension_code eq 'package_buy'}
					{$goods.goods_name}
					{/if}
				</td>
				<td>
					{$goods.goods_sn}<input name="rec_id[]" type="hidden" value="{$goods.rec_id}" />
				</td>
				<td>
					<input name="goods_price[]" type="text" class="t_r" value="{$goods.goods_price}" />
					<input name="goods_id[]" type="hidden"  value="{$goods.goods_id}"  />
					<input name="product_id[]" type="hidden"  value="{$goods.product_id}"  />
				</td>
				<td class="edit_numtd">
					<input class="ecjiaf-tac w50 goods_number" name="goods_number[]" type="text" value="{$goods.goods_number}"  />
				</td>
				<td>
					<textarea name="goods_attr[]" cols="30" rows="{$goods.rows}" class="h40">{$goods.goods_attr}</textarea>
				</td>
				<td>{$goods.subtotal}</td>
				<td>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="orders"}您确定要删除订单商品吗？{/t}' href='{url path="orders/admin/process" args="func=drop_order_goods&rec_id={$goods.rec_id}&step_act={$step_act}&order_id={$order_id}"}' title='{t domain="orders"}删除{/t}'><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {/foreach} -->
			<tr>
				<td colspan="4" class="left-td"><span class="input-must">{t domain="orders"}备注：商品价格中已包含属性加价{/t}</span></td>
				<td colspan="1" class="right-td"><strong>{t domain="orders"}合计：{/t}</strong>{$goods_amount}</td>
<!-- 				<td>{$goods_amount}</td> -->
				<td colspan="2" class="right-td">
<!-- 					{if $smarty.foreach.goods.total gt 0} -->
<!-- 					<button class="btn" type="submit" name="edit_goods">更新商品</button> -->
<!-- 					{/if} -->
            			<p class="ecjiaf-tac m_t15">
            				<button class="btn btn-gebo" type="submit" name="{if $step_act eq 'add'}next{else}finish{/if}">{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}更新商品{/t}{/if}</button>&nbsp;&nbsp;&nbsp;
            				<input name="{if $step_act eq 'add'}next{else}finish{/if}" type="hidden" value="{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}" />
            				<a class="cancel_order" data-href='{url path="orders/admin/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
            			</p>
					<input name="goods_count" type="hidden" value="{$smarty.foreach.goods.total}" />
				</td>
			</tr>
		</tbody>
	</table>
	<!-- {/if} -->
</form>

<div class="row-fluid">
	<div class="choose_list span12">
		<span>{t domain="orders"}按商品编号、名称或货号搜索：{/t}</span>
		<input type="text" name="keyword" placeholder='{t domain="orders"}请输入关键字{/t}' />
		<button class="btn searchGoods" type="button">{t domain="orders"}搜索{/t}</button>
	</div>
</div>
<div class="row-fluid draggable">
	<div class="ms-container ms-container-nobg" id="ms-custom-navigation">
		<div class="ms-selectable ms-not-selectable" id="goodslist"  data-change-url='{url path="orders/admin/goods_json"}'>
			<div class="search-header">
				<input class="span12" id="ms-search" type="text" placeholder='{t domain="orders"}筛选搜索到的商品信息{/t}' autocomplete="off">
			</div>
			<ul class="ms-list nav-list-ready order-select-goods">
				<li class="ms-elem-selectable disabled"><span>{t domain="orders"}暂无内容{/t}</span></li>
			</ul>
		</div>
		<form class="form-horizontal" name="goodsForm" action='{url path="orders/admin/step_post" args="step=add_goods&order_id={$order_id}&step_act={$step_act}"}' method="post"  data-search-url='{url path="orders/admin/search_goods" args="step=goods&order_id={$order_id}"}' data-goods-url='{url path="orders/admin/add" args="step=goods&order_id={$order_id}"}'>
			<fieldset class="edit-page">
				<div class="ms-selection order-goods-select">
					<div class="custom-header custom-header-align"><span>{t domain="orders"}商品信息{/t}</span>
					</div>
					<div class="add-goods"><a class="goods_info ecjiaf-dn" href="javascript:;">{t domain="orders"}加入订单{/t}</a></div>
					<div class="ms-list nav-list-content ">
						<div class="ecjiaf-dn goods_info h100 m_t10">
							<div class="ecjiaf-fl span5 ecjiaf-tac m_t5">
								<span id="goods_img"></span>
							</div>
							<div class="ecjiaf-fl m_t15 span7">
								<dl>
									<dd><span id="goods_name"></span></dd>
									<dd>{t domain="orders"}货号：{/t}<span id="goods_sn"></span></dd>
<!-- 									<dd>{t domain="orders"}品牌{/t}：<span id="goods_brand"></span></dd> -->
									<dd>{t domain="orders"}分类：{/t}<span id="goods_cat"></span></dd>
									<!-- {if $use_storage} -->
									<dd>{t domain="orders"}商品库存：{/t}<span id="goods_number"></span></dd>
									<!-- {/if} -->
								</dl>
							</div>
						</div>
						<ul class="ecjiaf-dn goods_info">
							<li>
								<div class="control-group control-group-small">
									<label class="control-label">{t domain="orders"}商品价格：{/t}</label>
									<div class="goods_attr_sel controls" id="add_price">
									</div>
								</div>
							</li>
							<li id="sel_goodsattr"></li>
							<li>
								<div class="control-group control-group-small">
									<label class="control-label">{t domain="orders"}商品数量：{/t}</label>
									<div class="controls">
										<input class="w50 ecjiaf-tac goods_number" name="add_number" type="text" value="1">
									</div>
								</div>
							</li>
							<li class="goods_attr">
								<div>{t domain="orders"}商品属性{/t}</div></li>
							<li>
							<div id="goods_attr"></div><input type="hidden" name="spec_count" value="0" /></li>
						</ul>
					</div>
				</div>
			</fieldset>
			<input name="goodslist" type="hidden" />
		</form>
	</div>
</div>
{elseif $step eq "consignee"}
<form class="form-horizontal" name="consigneeForm" action='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post" >
	<fieldset>
		<!--{if $address_list}-->
			<div class="dataTables_wrapper">
				<table class="table table-striped" id="smpl_tbl">
					<thead>
						<tr>
							<th class="w30">&nbsp;</th>
							<th class="w100">{t domain="orders"}收货人{/t}</th>
							<th class="w200">{t domain="orders"}所在地区{/t}</th>
							<th>{t domain="orders"}详细地址{/t}</th>
							<th class="w80">{t domain="orders"}邮编{/t}</th>
							<th class="w200">{t domain="orders"}电话/手机{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$address_list key=Key item=val} -->
						<tr class="{if $val.default_address}info{/if}">
							<td><input type="radio" name='user_address' value="{$val.address_id}"/></td>
							<td>{$val.consignee|escape}<br>{if $val.default_address}{t domain="orders"}（默认收货地址）{/t}{/if}</td>
							<td>
								{if $val.province}{ecjia_region::getRegionName($val.province)} {/if}
								{if $val.city}{ecjia_region::getRegionName($val.city)} {/if}
								{if $val.district}{ecjia_region::getRegionName($val.district)} {/if}
								{if $val.street}{ecjia_region::getRegionName($val.street)} {/if}
							</td>
							<td>{$val.address|escape}{$val.address_info|escape}</td>
							<td>{$val.zipcode|escape}</td>
							<td>{t domain="orders"}电话：{/t}{$val.tel}<br/>
                                {t domain="orders"}手机：{/t}{$val.mobile}
							</td>
							<!-- <td>{$lang.best_time}：{$val.best_time|escape}<br/>{$lang.sign_building}：{$val.sign_building|escape}<br/>email：{$val.email}</td> -->
						</tr>
						<!-- {/foreach} -->
						<tr>
							<td><input type="radio" name='user_address' {if $order.consignee neq ""}checked{/if} value="-1"/></td>
							<td colspan='5'>{t domain="orders"}填写收货地址{/t}</td>
						</tr>
					</tbody>
				</table>
			</div>
		<!--{/if}-->
		<div class="row-fluid m_t20 {if $address_list && $order.consignee eq ''}ecjiaf-dn{/if}" id='add_address'>
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}收货人：{/t}</label>
				<div class="controls m_l130">
					<input type="text" name="consignee" class="span4" value="{$order.consignee}"/>
					<span class="input-must">*</span>
				</div>
			</div>
			<!--{if $exist_real_goods} -->
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}详细地址：{/t}</label>
				<div class="controls m_l130">
					<input type="text" name="address" class="span4" value="{$order.address}"/>
					<span class="input-must">*</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}所在地区：{/t}</label>
				<div class="controls choose_list not-line-height m_l130">
					<select class="region-summary-provinces w120" name="province" id="selProvinces" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
						<option value='0'>{t domain="orders"}请选择...{/t}</option>
						<!-- {foreach from=$province item=region} -->
						<option value="{$region.region_id}" {if $region.region_id eq $order.province}selected{/if}>{$region.region_name}</option>
						<!-- {/foreach} -->
					</select>
					<select class="region-summary-cities w120" name="city" id="selCities" data-toggle="regionSummary" data-type="3" data-target="region-summary-district">
						<option value='0'>{t domain="orders"}请选择...{/t}</option>
						<!-- {foreach from=$city item=region} -->
						<option value="{$region.region_id}" {if $region.region_id eq $order.city}selected{/if}>{$region.region_name}</option>
						<!-- {/foreach} -->
					</select>
					<select class="region-summary-district w120" name="district" id="seldistrict" data-toggle="regionSummary" data-type="4" data-target="region-summary-street">
						<option value='0'>{t domain="orders"}请选择...{/t}</option>
						<!-- {foreach from=$district item=region} -->
						<option value="{$region.region_id}" {if $region.region_id eq $order.district}selected{/if}>{$region.region_name}</option>
						<!-- {/foreach} -->
					</select>
					<select class="region-summary-street w120" name="street" id="selstreet" >
						<option value='0'>{t domain="orders"}请选择...{/t}</option>
						<!-- {foreach from=$street item=region} -->
						<option value="{$region.region_id}" {if $region.region_id eq $order.street}selected{/if}>{$region.region_name}</option>
						<!-- {/foreach} -->
					</select>
					<span class="input-must">*</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}邮编：{/t}</label>
				<div class="controls m_l130">
					<input type="text" name="zipcode" class="span4" value="{$order.zipcode}" />
				</div>
			</div>
<!-- 			<div class="control-group control-group-small"> -->
<!-- 				<label class="control-label w110">{$lang.label_sign_building}</label> -->
<!-- 				<div class="controls m_l130"> -->
<!-- 					<input type="text" name="sign_building" class="span4" value=""/> -->
<!-- 				</div> -->
<!-- 			</div> -->
<!-- 			<div class="control-group control-group-small"> -->
<!-- 				<label class="control-label w110">{$lang.label_best_time}</label> -->
<!-- 				<div class="controls m_l130"> -->
<!-- 					<input type="text" name="best_time" class="span4" value="" /> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<!--{/if}-->
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}电话：{/t}</label>
				<div class="controls m_l130">
					<input type="text" name="tel" class="span4" value="{$order.tel}" />
					<span class="input-must">*</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}手机：{/t}</label>
				<div class="controls m_l130">
					<input type="text" name="mobile" class="span4" value="{$order.mobile}" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label w110">{t domain="orders"}电子邮件：{/t}</label>
				<div class="controls m_l130">
					<input type="text" name="email" class="span4" value="{$order.email}"/>
					<span class="input-must">*</span>
				</div>
			</div>
		</div>
		<p class="ecjiaf-tac m_t15">
			{if $step_act eq "add"}
			<a class="data-pjax" href='{url path="orders/admin/add" args="order_id={$order_id}&step=goods"}'><button class="btn" type="button">{t domain="orders"}上一步{/t}</button></a>&nbsp;&nbsp;&nbsp;
			{/if}
			<button class="btn btn-gebo" type="submit" name="{if $step_act eq 'add'}next{else}finish{/if}">{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}</button>&nbsp;&nbsp;&nbsp;
			<a class="cancel_order" data-href='{url path="orders/admin/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
			<input name="{if $step_act eq 'add'}next{else}finish{/if}" type="hidden" value="{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}" />
		</p>
	</fieldset>
</form>
{elseif $step eq "shipping"}
<form name="shippingForm" action='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<!-- {if $exist_real_goods} -->
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="w35">&nbsp;</th>
				<th class="w100">{t domain="orders"}名称{/t}</th>
				<th>{t domain="orders"}描述{/t}</th>
				<th class="w120">{t domain="orders"}配送费{/t}</th>
				<th class="w100">{t domain="orders"}免费额度{/t}</th>
				<th class="w120">{t domain="orders"}保价费{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$shipping_list item=shipping} -->
			<tr>
				<td><input name="shipping" type="radio" data-cod="{$shipping.support_cod}" value="{$shipping.shipping_id}" {if $order.shipping_id eq $shipping.shipping_id}checked{/if} /></td>
				<td>{$shipping.shipping_name}</td>
				<td>{$shipping.shipping_desc}</td>
				<td><div>{$shipping.format_shipping_fee}</div></td>
				<td><div>{$shipping.free_money}</div></td>
				<td><div>{$shipping.insure}</div></td>
			</tr>
			<!-- {foreachelse}-->
    		<tr><td class="no-records" colspan="6">{t domain="orders"}没有找到任何记录{/t}</td></tr>
    		<!-- {/foreach} -->
		</tbody>
	</table>
	<p align="right">
		<input name="insure" type="checkbox" value="1" {if $order.insure_fee > 0}checked{/if} />
        {t domain="orders"}我要保价{/t}
	</p>
	<!--{/if}-->

	<div id="exist_real_goods" data-real="{if $exist_real_goods}true{else}false{/if}">
		<h3 class="heading">
			<!-- {if $ur_heres}{$ur_heres}{/if} -->
		</h3>
	</div>
	<div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="w35">&nbsp;</th>
					<th class="w100">{t domain="orders"}名称{/t}</th>
					<th>{t domain="orders"}描述{/t}</th>
					<th class="w100">{t domain="orders"}手续费{/t}</th>
				</tr>
			</thead>
			<!-- {foreach from=$payment_list item=payment} -->
			<tr>
				<td><input type="radio" name="payment" data-cod="{$payment.is_cod}" value="{$payment.pay_id}" {if $order.pay_id eq $payment.pay_id}checked{/if} /></td>
				<td>{$payment.pay_name}</td>
				<td>{$payment.pay_desc}</td>
				<td align="right">{$payment.pay_fee}</td>
			</tr>
			<!-- {foreachelse}-->
    		<tr><td class="no-records" colspan="4">{t domain="orders"}没有找到任何记录{/t}</td></tr>
    		<!-- {/foreach} -->
		</table>
	</div>
	<p align="center">
		{if $step_act eq "add"}<a class="data-pjax" href='{url path="orders/admin/add" args="order_id={$order_id}&step=consignee"}'><button class="btn" type="button">{t domain="orders"}上一步{/t}</button></a>&nbsp;&nbsp;&nbsp;{/if}
		<button class="btn btn-gebo" type="submit" name="{if $step_act eq 'add'}next{else}finish{/if}">{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}</button>&nbsp;&nbsp;&nbsp;
		<a class="cancel_order" data-href='{url path="orders/admin/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
		<input name="{if $step_act eq 'add'}next{else}finish{/if}" type="hidden" value="{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}" />
	</p>
</form>
{elseif $step eq "other"}
<form class="form-horizontal" name="otherForm" action='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<div class="row-fluid">
		<div {if $pack_list || $card_list}class="span6"{/if}>
			<!-- {if $exist_real_goods}-->
			<div class="accordion" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-target="#collapseThree" data-toggle="collapse" data-parent="#collapseThree"><strong>{t domain="orders"}发票相关{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<div class="accordion-inner">
							<p>
								<label class="label-title">{t domain="orders"}发票类型：{/t}</label>
								<input name="inv_type" class="span8" type="text" id="inv_type" value="{$order.inv_type}"/>
							</p>
							<p>
								<label class="label-title">{t domain="orders"}发票抬头：{/t}</label>
								<input name="inv_payee" class="span8" value="{$order.inv_payee}" type="text" />
								<span class="help-block">
									<label class="label-title"></label>
									{t domain="orders"}发票抬头及发票识别码，请用英文逗号（“,”）隔开，例：抬头,识别码。如没有英文逗号，则默认为发票抬头。{/t}
								</span>
							</p>
							<p>
								<label class="label-title">{t domain="orders"}发票内容：{/t}</label>
								<input name="inv_content" class="span8" value="{$order.inv_content}" type="text" />
							</p>
						</div>
					</div>
				</div>
			</div>
			<!--{/if}-->
			<div class="accordion" id="accordion2">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-target="#collapseFour" data-toggle="collapse" data-parent="#collapseFour"><strong>{t domain="orders"}留言/备注{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseFour">
						<div class="accordion-inner">
							<p>
								<label>{t domain="orders"}客户给商家的留言：{/t}</label>
								<textarea name="postscript" class="span12 action_note" cols="60" rows="3">{$order.postscript}</textarea>
							</p>
							<p>
								<label>{t domain="orders"}缺货处理：{/t}</label>
								<textarea name="how_oos" class="span12 action_note" cols="60" rows="3">{$order.how_oos}</textarea>
							</p>
							<p>
								<label>{t domain="orders"}商家给客户的留言：{/t}</label>
								<textarea name="to_buyer" class="span12 action_note" cols="60" rows="3">{$order.to_buyer}</textarea>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- {if $pack_list || $card_list}-->
		<div class="ecjiaf-fr span6">
			<!-- {if $pack_list}-->
			<div id="accordion2" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-parent="#collapseOne" data-toggle="collapse" data-target="#collapseOne"><strong>{t domain="orders"}选择包装{/t}</strong></div>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table m_b0">
							<tbody>
								<tr>
									<td class="span1">&nbsp;</td>
									<td class="span2"><div><strong>{t domain="orders"}名称{/t}</strong></div></td>
									<td><div><strong>{t domain="orders"}包装费{/t}</strong></div></td>
									<td><div><strong>{t domain="orders"}免费额度{/t}</strong></div></td>
								</tr>
								<tr>
									<td><input type="radio" name="pack" value="0" {if $order.pack_id eq 0}checked{/if} /></td>
									<td>{t domain="orders"}不要包装{/t}</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<!-- {foreach from=$pack_list item=pack}-->
								<tr>
									<td><input type="radio" name="pack" value="{$pack.pack_id}" {if $order.pack_id eq $pack.pack_id}checked{/if} /></td>
									<td>{$pack.pack_name}</td>
									<td><div>{$pack.format_pack_fee}</div></td>
									<td><div>{$pack.format_free_money}</div></td>
								</tr>
								<!-- {/foreach}-->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- {/if}-->
			<!-- {if $card_list}-->
			<div id="accordion2" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-parent="#collapseTwo" data-toggle="collapse" data-target="#collapseTwo"><strong>{t domain="orders"}选择贺卡{/t}</strong></div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table m_b0">
							<tbody>
								<tr>
									<td class="span1">&nbsp;</td>
									<td class="span2"><div><strong>{t domain="orders"}名称{/t}</strong></div></td>
									<td><div><strong>{t domain="orders"}贺卡费{/t}</strong></div></td>
									<td><div><strong>{t domain="orders"}免费额度{/t}</strong></div></td>
								</tr>
								<tr>
									<td><input type="radio" name="card" value="0" {if $order.card_id eq 0}checked{/if} /></td>
									<td>{t domain="orders"}不要贺卡{/t}</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<!-- {foreach from=$card_list item=card}-->
								<tr>
									<td><input type="radio" name="card" value="{$card.card_id}" {if $order.card_id eq $card.card_id}checked{/if} /></td>
									<td>{$card.card_name}</td>
									<td><div>{$card.format_card_fee}</div></td>
									<td><div>{$card.format_free_money}</div></td>
								</tr>
								<!-- {/foreach}-->
								<tr>
									<td colspan='4'>{t domain="orders"}贺卡祝福语：{/t}</td>
								</tr>
								<tr>
									<td colspan='4' class="ecjiaf-border">{ecjia:editor content=$order.card_message textarea_name='card_message' editor_height='5'}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- {/if}-->
		</div>
		<!-- {/if}-->
	</div>
	<p align="center">
		{if $step_act eq "add"}<a class="data-pjax" href='{url path="orders/admin/add" args="order_id={$order_id}&step=shipping"}'><button class="btn" type="button">{t domain="orders"}上一步{/t}</button></a>&nbsp;&nbsp;&nbsp;{/if}
		<button class="btn btn-gebo" type="submit" name="{if $step_act eq 'add'}next{else}finish{/if}">{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}</button>&nbsp;&nbsp;&nbsp;
		<a class="cancel_order" data-href='{url path="orders/admin/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
		<input name="{if $step_act eq 'add'}next{else}finish{/if}" type="hidden" value="{if $step_act eq 'add'}{t domain="orders"}下一步{/t}{else}{t domain="orders"}确定{/t}{/if}" />
	</p>
</form>
{elseif $step eq "money"}
<form name="moneyForm" action='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<div class="row-fluid">
		<div class="span12">
			<div class="form-inline foldable-list">
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{t domain="orders"}订单信息{/t}</strong></div>
					</div>
					<div class="accordion-body in in_visable collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="orders"}商品总金额：{/t}</strong></div></td>
									<td>{$order.formated_goods_amount}</td>
									<td><div align="right"><strong>{t domain="orders"}折扣：{/t}</strong></div></td>
									<td><input class="span8" name="discount" type="text" id="discount" value="{$order.discount}" /></td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}发票税额：{/t}</strong></div></td>
									<td><input class="span8" name="tax" type="text" id="tax" value="{$order.tax}" /></td>
									<td><div align="right"><strong>{t domain="orders"}订单总金额：{/t}</strong></div></td>
									<td>{$order.formated_total_fee}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}配送费用：{/t}</strong></div></td>
									<td>{if $exist_real_goods}<input class="span8" name="shipping_fee" type="text" value="{$order.shipping_fee}" >{else}0{/if}</td>
									<td><div align="right"><strong>{t domain="orders"}已付款金额：{/t}</strong></div></td>
									<td>{$order.formated_money_paid} </td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}保价费用：{/t}</strong></div></td>
									<td>{if $exist_real_goods}<input class="span8" name="insure_fee" type="text" value="{$order.insure_fee}" >{else}0{/if}</td>
									<td><div align="right"><strong>{t domain="orders"}使用余额：{/t}</strong></div></td>
									<td>
										{if $order.user_id gt 0}
										<input class="span8" name="surplus" type="text" value="{$order.surplus}"><br/>
										{/if}
                                        {t domain="orders"}可用余额：{/t}{$available_user_money|default:0}
									</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}支付费用：{/t}</strong></div></td>
									<td><input class="span8" name="pay_fee" type="text" value="{$order.pay_fee}"></td>
									<td><div align="right"><strong>{t domain="orders"}使用积分：{/t}</strong></div></td>
									<td>
										{if $order.user_id gt 0}
										<input class="span8" name="integral" type="text" value="{$order.integral}"><br/>
										{/if}
                                        {t domain="orders"}可用积分：{/t}{$available_pay_points|default:0}
									</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}包装费用：{/t}</strong></div></td>
									<td>
										{if $exist_real_goods}
										<input class="span8" name="pack_fee" type="text" value="{$order.pack_fee}" >
										{else}
                                        0
                                        {/if}
									</td>
									<td><div align="right"><strong>{t domain="orders"}使用红包：{/t}</strong></div></td>
									<td>
										<select class="span8" name="bonus_id">
											<option value="0" {if $order.bonus_id eq 0}selected{/if}>{t domain="orders"}请选择...{/t}</option>
											<!-- {foreach from=$available_bonus item=bonus} -->
											<option value="{$bonus.bonus_id}" {if $order.bonus_id eq $bonus.bonus_id}selected{/if} money="{$bonus.type_money}">{$bonus.type_name} - {$bonus.type_money}</option>
											<!--{/foreach}  -->
										</select>
									</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}贺卡费用：{/t}</strong></div></td>
									<td>
										{if $exist_real_goods}
										<input class="span8" name="card_fee" type="text" value="{$order.card_fee}">
										{else}0{/if}
									</td>
									<td><div align="right"><strong>{if $order.order_amount >= 0} {t domain="orders"}应付款金额：{/t} {else} {t domain="orders"}应退款金额：{/t} {/if}</strong></div></td>
									<td>{$order.formated_order_amount}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<p align="center">
				{if $step_act eq "add"}<a class="data-pjax" href='{url path="orders/admin/add" args="order_id={$order_id}&step=other"}'><button class="btn" type="button">{t domain="orders"}上一步{/t}</button></a>&nbsp;&nbsp;&nbsp;{/if}
				<button class="btn btn-gebo" type="submit" name="finish">{t domain="orders"}完成{/t}</button>&nbsp;&nbsp;&nbsp;
				<a class="cancel_order" data-href='{url path="orders/admin/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
				<input name="finish" type="hidden" value="{t domain='orders'}完成{/t}" />
			</p>
		</div>
	</div>
</form>
{elseif $step eq "invoice"}
<form name="invoiceForm" action='{url path="orders/admin/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<div>
		<strong>{t domain="orders"}运单编号：{/t}</strong><input name="invoice_no" type="text" value="{$order.invoice_no}" size="30"/><span id="noticPoints" class="help-block ecjiaf-ib">&nbsp;&nbsp;&nbsp;{t domain="orders"}多个发货单号，请用英文逗号（“,”）隔开。{/t}</span>
	</div>
	<div class="row-fluid">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%">&nbsp;</th>
					<th width="25%">{t domain="orders"}名称{/t}</th>
					<th>{t domain="orders"}描述{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!--{foreach from=$shipping_list item=shipping}-->
				<tr>
					<td><input name="shipping" type="radio" value="{$shipping.shipping_id}" {if $order.shipping_id eq $shipping.shipping_id}checked{/if}/></td>
					<td>{$shipping.shipping_name}</td>
					<td>{$shipping.shipping_desc}</td>
				</tr>
				<!-- {foreachelse}-->
	    		<tr><td class="no-records" colspan="3">{t domain="orders"}没有找到任何记录{/t}</td></tr>
	    		<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
	<p align="center">
		<button class="btn btn-gebo" type="submit" name="finish">{t domain="orders"}确定{/t}</button>&nbsp;&nbsp;&nbsp;
		<input name="finish" type="hidden" value="{t domain='orders'}完成{/t}" />
		<a class="data-pjax" href='{url path="orders/admin/info" args="order_id={$order_id}"}'><button class="btn" type="button">{t domain="orders"}取消{/t}</button></a>
	</p>
</form>
{/if}
<!-- {/block} -->