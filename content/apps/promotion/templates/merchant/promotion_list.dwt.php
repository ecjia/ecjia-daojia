<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.promotion_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a  class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-plus"></i> {$action_link.text}</a>
		<!-- {/if} -->
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="promotion/merchant/init" args="{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}全部{/t} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'on_sale'}active{/if}"><a class="data-pjax" href='{url path="promotion/merchant/init" args="type=on_sale{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}正在进行中{/t}<span class="badge badge-info">{if $type_count.on_sale}{$type_count.on_sale}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'coming'}active{/if}"><a class="data-pjax" href='{url path="promotion/merchant/init" args="type=coming{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}即将开始{/t}<span class="badge badge-info">{if $type_count.coming}{$type_count.coming}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'finished'}active{/if}"><a class="data-pjax" href='{url path="promotion/merchant/init" args="type=finished{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}已结束{/t}<span class="badge badge-info">{if $type_count.finished}{$type_count.finished}{else}0{/if}</span> </a></li>
				</ul>	
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$form_search}{if $type}&type={$type}{/if}">
					<div class="form-group">
						<!-- 关键字 -->
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="promotion"}请输入商品名称关键字{/t}"/>
						<button class="btn btn-primary" type="submit"><i class='fa fa-search'></i> {t domain="promotion"}搜索{/t}</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w150">{t domain="promotion"}缩略图{/t}</th>
								<th>{t domain="promotion"}商品名称{/t}</th>
								<th class="w200">{t domain="promotion"}开始时间{/t}</th>
								<th class="w200">{t domain="promotion"}结束时间{/t}</th>
								<th class="w80">{t domain="promotion"}活动价格{/t}</th>
							</tr>
						</thead>
						<!-- {foreach from=$promotion_list.item item=item key=key} -->
						<tr>
							<td class="big">
								<a class="data-pjax" href="{url path='promotion/merchant/edit' args="id={$item.goods_id}"}" title="{$item.goods_name}" >
									<img class="thumbnail w80 h80" alt="{$item.goods_name}" src="{$item.goods_thumb}">
								</a>
							</td>
							<td class="hide-edit-area">
								<span class="{if ($time >= $item.promote_start_date) && ($time <= $item.promote_end_date)}ecjiafc-red{/if}" >{$item.goods_name}</span><br>
								<div class="edit-list">
									<a class="data-pjax" href='{RC_Uri::url("promotion/merchant/edit", "id={$item.goods_id}")}' title='{t domain="promotion"}编辑{/t}'>{t domain="promotion"}编辑{/t}</a>&nbsp;|&nbsp;
									<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="promotion"}您确定要删除该促销活动吗？{/t}' href='{RC_Uri::url("promotion/merchant/remove", "id={$item.goods_id}")}' title='{t domain="promotion"}删除{/t}'>{t domain="promotion"}删除{/t}</a>
							    </div>
							</td>
							<td>{$item.start_time}</td>
							<td>{$item.end_time}</td>
							<td>{$item.promote_price}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="no-records" colspan="5">{t domain="promotion"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</table>
				</section>
				<!-- {$promotion_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->