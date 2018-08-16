<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.groupbuy_list.init();
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
        			<li class="{if !$groupbuy_list.filter.type}active{/if}"><a class="data-pjax" href='{url path="groupbuy/merchant/init"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>全部 <span class="badge badge-info">{$groupbuy_list.msg_count.count}</span> </a></li>
        			<li class="{if $groupbuy_list.filter.type eq 'on_going'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/merchant/init" args="type=on_going"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>进行中 <span class="badge badge-info">{$groupbuy_list.msg_count.on_going}</span> </a></li>
        			<li class="{if $groupbuy_list.filter.type eq 'uncheck'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/merchant/init" args="type=uncheck"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>结束未处理 <span class="badge badge-info">{$groupbuy_list.msg_count.uncheck}</span> </a></li>
        			<li class="{if $groupbuy_list.filter.type eq 'successed'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/merchant/init" args="type=successed"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>成功结束 <span class="badge badge-info">{$groupbuy_list.msg_count.successed}</span> </a></li>
        			<li class="{if $groupbuy_list.filter.type eq 'failed'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/merchant/init" args="type=failed"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>失败结束 <span class="badge badge-info">{$groupbuy_list.msg_count.failed}</span> </a></li>
        		</ul>
            </div>
            <div class="panel-body panel-body-small">
        		<div class="btn-group">
        			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {t}批量操作{/t} <span class="caret"></span></button>
        			<ul class="dropdown-menu">
                        <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='groupbuy/merchant/batch'}" data-msg="您确定要这么做吗？" data-noSelectMsg="请先选中要删除的团购活动记录！" data-name="act_id" href="javascript:;"> <i class="fa fa-trash-o"></i> 删除团购</a></li>
                   	</ul>
        		</div>
        		<form class="form-inline pull-right" action='{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
        			<div class="form-group">
        				<input type="text" class="form-control" name="keywords" value="{$groupbuy_list.filter.keywords}" placeholder="请输入团购商品名称"/>
        			</div>
        			<button type="button" class="btn btn-primary search_groupgoods"><i class="fa fa-search"></i> {lang key='system::system.button_search'} </button>
        		</form>
            </div>
            <div class="panel-body panel-body-small">
	            <section class="panel">
	                <table class="table table-striped table-hover table-hide-edit">
	                    <thead>
	                        <tr>
	                        	<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w300">{t}商品名称{/t}</th>
								<th class="w100">{t}限购数量{/t}</th>
								<th class="w100">{t}订单数量{/t}</th>
								<th class="w100">{t}保证金{/t}</th>
								<th class="w100">{t}当前价格{/t}</th>
								<th class="w150">{t}结束时间{/t}</th>
								<th class="w100">{t}状态{/t}</th>
							</tr>
	                    </thead>
						<tbody>
	                    <!-- {foreach from=$groupbuy_list.groupbuy item=list} -->
						<tr>
							<td class="check-list">
								<div class="check-item">
									<input id="checkbox_{$list.act_id}" type="checkbox" name="checkboxes[]" class="checkbox" value="{$list.act_id}"/>
									<label for="checkbox_{$list.act_id}"></label>
								</div>
							</td>
							<td class="hide-edit-area">
								{$list.goods_name}<br>
								<div class="edit-list">
								{assign var=edit_url value=RC_Uri::url('groupbuy/merchant/edit',"id={$list.act_id}")}
								<a class="data-pjax" href="{$edit_url}{if $smarty.get.page}&page={$smarty.get.page}{/if}" title="{t}编辑{/t}">{t}编辑{/t}</a>
								&nbsp;|&nbsp;
								<a href="{RC_Uri::url('orders/merchant/init')}&group_buy_id={$list.act_id}" title="{t}查看{/t}" target="__blank">{t}查看订单{/t}</a>
								{if $list.status neq 0 && $list.status neq 1}
								&nbsp;|&nbsp;
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="您确定要删除这条记录吗？" href='{RC_Uri::url("groupbuy/merchant/remove","id={$list.act_id}")}' title="{t}删除{/t}">{t}删除{/t}</a> 
								{/if}
								</div>
							</td>
							<td>{if $list.restrict_amount}{$list.restrict_amount}{else}0{/if}</td>
							<td>{if $list.total_order}{$list.total_order}{else}0{/if}</td>
							<td>{if $list.deposit}{$list.deposit}{else}0{/if}</td>
							<td>{$list.cur_price}</td>
							<td>{$list.end_time}</td>
							<td>{$list.cur_status}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
	                    </tbody>
	                </table>
	            </section>
	            <!-- {$groupbuy_list.page} -->
	          </div>
        </div>
    </div>
</div>

<!-- {/block} -->