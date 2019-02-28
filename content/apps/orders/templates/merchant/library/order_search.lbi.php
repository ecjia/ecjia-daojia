<div class="row-fluid ecjia-order-search {if !$smarty.get.show_search}display-none{/if}">
	<form class="form-horizontal search-form" action="{RC_Uri::url('orders/merchant/init')}{if $smarty.get.extension_code}&extension_code={$smarty.get.extension_code}{/if}" name="advancedSearchForm" method="post">
		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}订单号：{/t}</label>
					<div class="controls">
						<input class="w180 form-control" name="order_sn" type="text" value="{$filter.order_sn}" size="40" placeholder='{t domain="orders"}请输入订单编号关键字{/t}' />
					</div>
				</div>
			</div>
			<div class="item w520">
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}下单时间：{/t}</label>
					<div class="controls">
						<input class="w180 form-control date" name="start_time" type="text" value="{$filter.start_time}" size="40" placeholder='{t domain="orders"}请选择开始时间{/t}' /> &nbsp;{t domain="orders"}至{/t}&nbsp;
						<input class="w180 form-control date" name="end_time" type="text" value="{$filter.end_time}" size="40" placeholder='{t domain="orders"}请选择结束时间{/t}' />
					</div>
				</div>
			</div>
		</div>

		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">>{t domain="orders"}订单状态：{/t}</label>
					<div class="controls">
						<select name="composite_status" class="w180 form-control">
							<option value="">>{t domain="orders"}请选择订单状态{/t}</option>
							<!-- {html_options options=$status_list selected=$filter.composite_status} -->
						</select>
					</div>
				</div>
			</div>
			{if $filter.extension_code neq 'cashdesk'}
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">>{t domain="orders"}配送方式：{/t}</label>
					<div class="controls">
						<select name="shipping_id" class="w180 form-control">
							<option value="">>{t domain="orders"}请选择配送方式{/t}</option>
							{foreach from=$shipping_list item=val}
							<option value="{$val.shipping_id}" {if $filter.shipping_id eq $val.shipping_id}selected{/if}>{$val.shipping_name}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>
			{/if}
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">>{t domain="orders"}支付方式：{/t}</label>
					<div class="controls">
						<select name="pay_id" class="w180 form-control">
							<option value="">>{t domain="orders"}请选择支付方式{/t}</option>
							{foreach from=$pay_list item=val}
							<option value="{$val.pay_id}" {if $filter.pay_id eq $val.pay_id}selected{/if}>{$val.pay_name}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="search-item">
			{if $filter.extension_code neq 'cashdesk'}
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">>{t domain="orders"}下单渠道：{/t}</label>
					<div class="controls">
						<select name="referer" class="w180 form-control">
							<option value="">>{t domain="orders"}请选择下单渠道{/t}</option>
							{foreach from=$referer_list key=key item=val}
							<option value="{$key}" {if $filter.referer eq $key}selected{/if}>{$val}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>
			{/if}
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}商品名称：{/t}</label>
					<div class="controls">
						<input class="w180 form-control" name="goods_keywords" type="text" value="{$filter.goods_keywords}" size="40" placeholder='{t domain="orders"}请输入商品名称关键字{/t}' />
					</div>
				</div>
			</div>
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}购买人：{/t}</label>
					<div class="controls">
						<input class="w180 form-control" name="consignee" type="text" value="{$filter.consignee}" size="40" placeholder='{t domain="orders"}请输入购买人关键字{/t}' />
					</div>
				</div>
			</div>
		</div>

		<div class="search-item">
			<div class="item">
				<div class="form-group">
					<label class="control-label col-lg-2">{t domain="orders"}手机号：{/t}</label>
					<div class="controls">
						<input class="w180 form-control" name="mobile" type="text" value="{$filter.mobile}" size="40" placeholder='{t domain="orders"}请输入手机号{/t}' />
					</div>
				</div>
			</div>
		</div>

		<div class="search-item w520">
			<div class="item w350">
				<div class="form-group">
					<label class="control-label col-lg-2"></label>
					<div class="controls">
						<input class="btn btn-info" type="submit" value='{t domain="orders"}查询{/t}' />
						<input class="btn btn-info m_l10 btn-reset" type="button" value='{t domain="orders"}重置{/t}' />
						{if $filter.show_search}
						<a class="btn btn-info m_l10" href="{$import_url}{if $smarty.get.composite_status}&composite_status={$smarty.get.composite_status}{/if}">{t domain="orders"}导出报表{/t}</a>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</form>
</div>