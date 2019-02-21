<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.appeal.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid batch">
	<ul class="nav nav-pills">
		<li class="{if $appeal_list.filter.type eq '0'}active{/if}"><a class="data-pjax" href='{url path="comment/appeal/init" args="type=0{if $appeal_list.filter.keywords}&keywords={$appeal_list.filter.keywords}{/if}"}'>{t domain="comment"}全部{/t} <span class="badge badge-info">{$appeal_list.current_count.count}</span> </a></li>
		<li class="{if $appeal_list.filter.type eq '1'}active{/if}"><a class="data-pjax" href='{url path="comment/appeal/init" args="type=1{if $appeal_list.filter.keywords}&keywords={$appeal_list.filter.keywords}{/if}"}'>{t domain="comment"}待处理{/t}<span class="badge badge-info use-plugins-num">{$appeal_list.current_count.waithandle}</span></a></li>
		<li class="{if $appeal_list.filter.type eq '2'}active{/if}"><a class="data-pjax" href='{url path="comment/appeal/init" args="type=2{if $appeal_list.filter.keywords}&keywords={$appeal_list.filter.keywords}{/if}"}'>{t domain="comment"}已处理{/t}<span class="badge badge-info unuse-plugins-num">{$appeal_list.current_count.handled}</span></a></li>
	</ul>
	<div class="choose_list f_r" >
		<form class="f_r form-inline" action="{RC_Uri::url('comment/appeal/init')}{if $appeal_list.filter.type neq null}&type={$appeal_list.filter.type}{/if}"  method="post" name="searchForm">
			<input type="text" name="keyword" value="{$smarty.get.keywords}" placeholder='{t domain="comment"}输入申诉编号或商家名称{/t}' size="15" />
			<button class="btn search_appeal" type="button">{t domain="comment"}搜索{/t}</button>
		</form>
		<div class="choose_list f_r" >
			<input class="date f_r w230" name="start_date" type="text" value="{$appeal_list.filter.start_date}" placeholder='{t domain="comment"}开始时间{/t}'>
			<span class="f_l">{t domain="comment"}至{/t}</span>
			<input class="date f_r w230" name="end_date" type="text" value="{$appeal_list.filter.end_date}" placeholder='{t domain="comment"}截止时间{/t}'>&nbsp;
		</div>
	</div>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="w120">{t domain="comment"}申诉编号{/t}</th>
					<th class='w100'>{t domain="comment"}商家名称{/t}</th>
					<th>{t domain="comment"}申诉内容{/t}</th>
					<th class="w100">{t domain="comment"}审核状态{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$appeal_list.item item=appeal} -->
				<tr>
					<td>{$appeal.appeal_sn}</td>
					<td>{$appeal.merchants_name}</td>
					<td class="hide-edit-area">
						<div>{$appeal.appeal_content|truncate:100|escape:html}</div>
						<div>{t domain="comment"}{t domain="comment"}申诉于{/t}{/t}&nbsp;&nbsp;{$appeal.appeal_time}</div>
							{if $appeal.imgs}
								<!-- {foreach from=$appeal.imgs item=img_list} -->
										<img style="margin-right:8px;margin-top:10px;width:75px;height:75px;" alt="" src="{$img_list.file_path}">
								<!-- {/foreach} -->
							{/if}
						<div class="edit-list">
							<a class="data-pjax" href='{url path="comment/appeal/detail" args="id={$appeal.id}&comment_id={$appeal.comment_id}"}'>{t domain="comment"}查看详情{/t}</a>
						</div>
					</td>
					<td>{$appeal.label_check_status}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="4">{t domain="comment"}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$appeal_list.page} -->
	</div>
</div>
<!-- {/block} -->