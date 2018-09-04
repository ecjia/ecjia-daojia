<div class="row-fluid ecjia-order-search {if !$smarty.get.show_search}display-none{/if}">
	<form class="form-horizontal search-form" action="{RC_Uri::url('orders/merchant/init')}{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}" name="advancedSearchForm" method="post">
		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">订单号：</label>
					<div class="controls">
						<input class="w180 form-control" name="order_sn" type="text" value="{$filter.order_sn}" size="40" placeholder="请输入订单编号关键字" />
					</div>
				</div>
			</div>
			<div class="item w520">
				<div class="form-group">
					<label class="control-label col-lg-2">下单时间：</label>
					<div class="controls">
						<input class="w180 form-control date" name="start_time" type="text" value="{$filter.start_time}" size="40" placeholder="请选择开始时间" /> &nbsp;至&nbsp;
						<input class="w180 form-control date" name="end_time" type="text" value="{$filter.end_time}" size="40" placeholder="请选择结束时间" />
					</div>
				</div>
			</div>
		</div>

		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">订单状态：</label>
					<div class="controls">
						<select name="composite_status" class="w180 form-control">
							<option value="">请选择订单状态</option>
							<!-- {html_options options=$status_list selected=$filter.composite_status} -->
						</select>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">配送方式：</label>
					<div class="controls">
						<select name="shipping_id" class="w180 form-control">
							<option value="">请选择配送方式</option>
							{foreach from=$shipping_list item=val}
							<option value="{$val.shipping_id}" {if $filter.shipping_id eq $val.shipping_id}selected{/if}>{$val.shipping_name}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">支付方式：</label>
					<div class="controls">
						<select name="pay_id" class="w180 form-control">
							<option value="">请选择支付方式</option>
							{foreach from=$pay_list item=val}
							<option value="{$val.pay_id}" {if $filter.pay_id eq $val.pay_id}selected{/if}>{$val.pay_name}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">下单渠道：</label>
					<div class="controls">
						<select name="referer" class="w180 form-control">
							<option value="">请选择下单渠道</option>
							{foreach from=$referer_list key=key item=val}
							<option value="{$key}" {if $filter.referer eq $key}selected{/if}>{$val}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">商品名称：</label>
					<div class="controls">
						<input class="w180 form-control" name="goods_keywords" type="text" value="{$filter.goods_keywords}" size="40" placeholder="请输入商品名称关键字"
						/>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">购买人：</label>
					<div class="controls">
						<input class="w180 form-control" name="consignee" type="text" value="{$filter.consignee}" size="40" placeholder="请输入购买人关键字"
						/>
					</div>
				</div>
			</div>
		</div>

		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">手机号：</label>
					<div class="controls">
						<input class="w180 form-control" name="mobile" type="text" value="{$filter.mobile}" size="40" placeholder="请输入手机号" />
					</div>
				</div>
			</div>
		</div>

		<div class="search-item w520">
			<div class="item w350">
				<div class="form-group">
					<label class="control-label col-lg-2"></label>
					<div class="controls">
						<input class="btn btn-info" type="submit" value="查询" />
						<input class="btn btn-info m_l10 btn-reset" type="button" value="重置" />
						{if $filter.show_search}
						<a class="btn btn-info m_l10" href="{$import_url}{if $smarty.get.composite_status}&composite_status={$smarty.get.composite_status}{/if}">导出报表</a>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</form>
</div>