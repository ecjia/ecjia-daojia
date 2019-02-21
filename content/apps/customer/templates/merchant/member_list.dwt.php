<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.customer_list.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="page-header">
	<h2 class="pull-left">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	</h2>
	<!-- {if $action_link} -->
	<div class="pull-right">
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-plus"></i><i class="fontello-icon-plus"></i> {$action_link.text}</a>
	</div>
	<!-- {/if} -->
	<div class="clearfix">
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
					<select class="w250" name="rank_id" id="select-cat">
						<option value="0">{t domain="customer"}全部会员等级{/t}</option>
						<!-- {foreach from=$rank_list key=key item=val} -->
						<option value="{$key}" {if $smarty.get.rank_id eq $key}selected{/if} >{$val}</option>
						<!-- {/foreach} -->
					</select>
					<a class="btn btn-primary m_l5 screen-btn"><i class="fa fa-search"></i> {t domain="customer"}筛选{/t}</a>
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" value="{$smarty.get.keywords}" placeholder="{t domain="customer"}请输入会员名{/t}"/>
						<a class="btn btn-primary m_l5 search_articles"><i class="fa fa-search"></i> {t domain="customer"}搜索{/t}</a>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr data-sorthref='{url path="customer/merchant/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.rank_id}&rank_id={$filter.rank_id}{/if}"}'>
							<th>{t domain="customer"}会员{/t}</th>
							<th class="w200">{t domain="customer"}手机号{/t}</th>
							<th class="w130 sorting" data-toggle="sortby" data-sortby="buy_times">{t domain="customer"}购次{/t}</th>
							<th class="w130 sorting" data-toggle="sortby" data-sortby="buy_amount">{t domain="customer"}消费金额{/t}</th>
							<th>{t domain="customer"}会员等级{/t}</th>
							<th>{t domain="customer"}最近购买时间{/t}</th>
							<th>{t domain="customer"}开通时间{/t}</th>
						</tr>
					</thead>
					<tbody>
					<!-- {foreach from=$user_list.list item=list} -->
						<tr>
							<td>
								<img alt="" src="{if $list.avatar_img}{$list.avatar_img}{else}{$ecjia_main_static_url}img/ecjia_avatar.jpg{/if}" width="40"><br>
								<span>{$list.user_name}</span>
							</td>
							<td class="hide-edit-area">
								<span class="cursor_pointer" >{$list.mobile_phone}</span>
								<div class="edit-list">
									<a class="data-pjax" href='{RC_Uri::url("customer/merchant/info", "user_id={$list.user_id}")}' title="{t domain="customer"}查看详情{/t}">{t domain="customer"}查看详情{/t}</a>
								</div>
							</td>
							<td>{$list.buy_times}</td>
							<td>{$list.buy_amount}</td>
							<td>{$list.rank_name}</td>
							<td>
								<span>{if $list.last_buy_time_format}{$list.last_buy_time_format}{else}/{/if}</span>
							</td>
							<td>{$list.add_time_format}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="7">
                                {t domain="customer"}没有找到任何记录{/t}
							</td>
						</tr>
					<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$user_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->