<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.express_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<h2 class="pull-left">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<!-- {/if} -->
	</h2>
	<div class="pull-right">
		<a class="btn btn-primary" target="_blank" href="{$action_link.href}" id="sticky_a"><i class="fa fa-plus"></i><i class="fontello-icon-plus"></i> {$action_link.text}</a>
	</div>
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/mh_express/init" args="{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>全部 <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'online'}active{/if}"><a class="data-pjax" href='{url path="express/mh_express/init" args="type=online{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>在线 <span class="badge badge-info">{if $type_count.online}{$type_count.online}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'offline'}active{/if}"><a class="data-pjax" href='{url path="express/mh_express/init" args="type=offline{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>离线 <span class="badge badge-info">{if $type_count.offline}{$type_count.offline}{else}0{/if}</span> </a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
					<div class="btn-group f_l m_r5">
						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-cogs"></i>
							<i class="fontello-icon-cog"></i>批量操作
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a class="button_remove" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{url path='express/mh_express/batch'}" data-msg="您确实要删除选中的配送员吗？" data-noselectmsg="请先选中要删除的配送员！" data-name="user_id" href="javascript:;"><i class="fa fa-trash-o"></i> 删除配送员</a></li>
						</ul>
					</div>
					<div class="f_r form-group">
						<input type="text" name="keyword" class="form-control" value="{$smarty.get.keyword}" placeholder="请输入名称或手机号"/>
						<a class="btn btn-primary m_l5 search_express"><i class="fa fa-search"></i> 搜索</a>
					</div>
				</form>
			</div>

			<div id="actionmodal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
	                    <div class="modal-header">
		                    <button data-dismiss="modal" class="close" type="button">×</button>
		                    <h4 class="modal-title">配送员当前位置</h4>
	                    </div>
	                    <div class="modal-body">
							<div id="allmap"></div>
						</div>
                    </div>
                </div>
           </div>
			
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr>
							<th class="table_checkbox check-list w30">
								<div class="check-item">
									<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
									<label for="checkall"></label>
								</div>
							</th>
						  	<th class="w150">配送员名称</th>
						    <th class="w150">手机号</th>
						    <th class="w150">信用等级</th>
						    <th class="w100">账户余额</th>
						    <th class="w100">工作类型</th>
						    <th class="w100">工作状态</th>
						    <th class="w150">添加时间</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$data.list item=express} -->
					    <tr>
							<td class="check-list">
								<div class="check-item">
									<input id="check_{$list.article_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$express.user_id}"/>
									<label for="check_{$list.article_id}"></label>
								</div>
							</td>
					      	<td class="hide-edit-area">
								{$express.name}
					     	  	<div class="edit-list">
								  	<a target="_blank" href='{url path="staff/merchant/edit" args="user_id={$express.user_id}"}' title="编辑">编辑</a>&nbsp;|&nbsp;
								  	<a class="data-pjax" href='{url path="express/mh_express/detail" args="user_id={$express.user_id}"}' title="查看详情">查看详情</a>&nbsp;|&nbsp;
								  	{if $express.online_status eq '1'}<a data-toggle="modal" href="#actionmodal" home_url="{RC_Uri::home_url()}" exmobile="{$express.mobile}" exname="{$express.name}" exlng="{$express.longitude}" exlat="{$express.latitude}" title="当前位置">当前位置</a>&nbsp;|&nbsp;{/if}
								  	<a target="_blank"   href='{url path="express/mh_express/account_list" args="user_id={$express.user_id}"}' title="查看账目明细">查看账目明细</a>&nbsp;|&nbsp;
						          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="你确定要删除该配送员吗？" href='{url path="express/mh_express/remove" args="user_id={$express.user_id}"}' title="删除">删除</a>
					    	  	</div>
					      	</td>
					      	<td>{$express.mobile}</td>
					      	<td>
						      	{section name=loop loop=$express.comment_rank}
						      		<i class="fa fa-star" style="color:#FF9933;"></i>
								{/section}
								{section name=loop loop=5-$express.comment_rank}   
									<i class="fa fa-star" style="color:#bbb;"></i>
								{/section}
							</td>
					      	<td>{$express.user_money}</td>
					      	<td>{if $express.work_type eq 1}派单{else}抢单{/if}</td>
					      	<td>{if $express.online_status eq 1}在线{else}<font class="ecjiafc-red">离线</font>{/if}</td>
					      	<td>{$express.add_time}</td>
					    </tr>
					    <!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="8">
								{lang key='system::system.no_records'}
							</td>
						</tr>
					<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->