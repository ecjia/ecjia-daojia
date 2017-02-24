<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $add_percent} -->				
			<!-- 添加佣金百分比 -->
			<a href="{$add_percent.href}" class="btn plus_or_reply data-pjax" id="sticky_b">
				<i class="fontello-icon-plus"></i>{$add_percent.text}
			</a>
		<!-- {/if} -->
	</h3>
</div>

<!-- 批量操作 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='store/admin_percent/batch'}" data-msg="您确定要删除选中的佣金比例吗？" data-noSelectMsg="请先选中要删除的佣金比例！" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{t}删除佣金比例{/t}</a></li>
			</ul>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<div class="tab-content">
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead >
					    <tr data-sorthref='{url path="store/admin_percent/init"}'>
					    	<th class="table_checkbox">
					    		<input type="checkbox" data-toggle="selectall" data-children=".checkbox"/>
					    	</th>
					      	<th>{t}奖励额度{/t}</th>
					      	<th class="sorting" data-toggle="sortby" data-sortby="add_time">{t}添加时间{/t} </th>
					      	<th class="sorting w75" data-toggle="sortby" data-sortby="sort_order">{t}排序{/t}</th>
					      	<th class="w75">{t}操作{/t}</th>
					    </tr>
					</thead>
					<tbody>    
							<!-- {foreach from=$percent_list.item item=percent} -->
						<tr>
					      	<td>
					      		<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$percent.percent_id}"/>
					      	</td>
					    	<td class="cursor_pointer">
					    		<span>{$percent.percent_value}</span>%
						  	</td>
					      	<td align="center">{$percent.add_time}</td>
					      	<td>{$percent.sort_order}</td>  
					      	<td>
					      		<a class="data-pjax" href="{RC_Uri::url('store/admin_percent/edit',"id={$percent.percent_id}")}" title="编辑"><i class="fontello-icon-edit"></i></a>
      							<a data-toggle="ajaxremove" class="ecjiafc-red" data-msg="{t}您确定要删除吗？{/t}" href="{RC_Uri::url('store/admin_percent/remove',"id={$percent.percent_id}")}" title="删除"><i class="fontello-icon-trash"></i></a>
					      	</td>
					    </tr>
					    <!-- {foreachelse} -->
					    <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
					    <!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$percent_list.page} -->
			</div>
		</div>
	</div>
</div> 
<!-- {/block} -->