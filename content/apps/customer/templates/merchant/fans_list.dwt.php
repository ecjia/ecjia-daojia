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
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" value="{$smarty.get.keywords}" placeholder="{t domain="customer"}请输入会员名{/t}"/>
						<a class="btn btn-primary m_l5 search_articles"><i class="fa fa-search"></i> {t domain="customer"}搜索{/t}</a>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr data-sorthref='{url path="customer/merchant/fans" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $filter.rank_id}&rank_id={$filter.rank_id}{/if}"}'>
							<th>{t domain="customer"}用户{/t}</th>
							<th class="sorting" data-toggle="sortby" data-sortby="buy_times">{t domain="customer"}进店次数{/t}</th>
							<th class="">{t domain="customer"}最后登录地点{/t}</th>
							<th class="">{t domain="customer"}最后进店时间{/t}</th>
							<th>{t domain="customer"}关注时间{/t}</th>
							<th>{t domain="customer"}来源{/t}</th>
							<th style="text-align: center">{t domain="customer"}是否是会员{/t}</th>
						</tr>
					</thead>
					<tbody>
					<!-- {foreach from=$user_list.list item=list} -->
						<tr>
							<td>
								<img alt="" src="{if $list.avatar_img}{$list.avatar_img}{else}{$ecjia_main_static_url}img/ecjia_avatar.jpg{/if}" width="40"><br>
								<span>{$list.user_name}</span>
							</td>
							<td class="">
								<span class="cursor_pointer" >{$list.visit_times}</span>
							</td>
							<td>{$list.last_visit_area}</td>
							<td>{$list.last_visit_time_format}</td>
							<td>{$list.add_time_format}</td>
							<td>
								<span>{$list.referer}</span>
							</td>
							<td align="center">{if $list.is_store_user}<a href="{url path='customer/merchant/info' args='&user_id='}{$list.user_id}"><i class="fa fa-check" title="{t domain="customer"}查看详情{/t}"></i><br>{t domain="customer"}查看详情{/t}</a>{else}<i class="fa fa-times" data-original-title="" title=""></i>{/if}</td>
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