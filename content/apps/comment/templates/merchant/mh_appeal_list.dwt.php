<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.appeal_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			<div class="pull-right">
				{if $action_link}
					<a href="{$action_link.href}" class="btn btn-primary data-pjax">
						<i class="fa fa-plus"></i> {$action_link.text}
					</a>
				{/if}
			</div>
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $smarty.get.type eq ''}active{/if}"><a class="data-pjax" href='{url path="comment/mh_appeal/init"}'>全部<span class="badge badge-info">{if $count.count}{$count.count}{else}0{/if}</span> </a></li>
					<li class="{if $smarty.get.type eq 'untreated'}active{/if}"><a class="data-pjax" href='{url path="comment/mh_appeal/init" args="type=untreated"}'>待处理<span class="badge badge-info">{if $count.untreated}{$count.untreated}{else}0{/if}</span></a></li>
					<li class="{if $smarty.get.type eq 'already'}active{/if}"><a class="data-pjax" href='{url path="comment/mh_appeal/init" args="type=already"}'>已处理<span class="badge badge-info">{if $count.already}{$count.already}{else}0{/if}</span> </a></li>
				</ul>	
			
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
					<div class="form-group">
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入申诉内容"/> 
						<button type="button" class="btn btn-primary"><i class="fa fa-search"></i>搜索</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w200">申诉编号</th>
								<th>申诉内容</th>
								<th class="w150">审核状态</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$data.appeal_list item=list} -->
							<tr>
								<td>{$list.appeal_sn}</td>
								<td class="hide-edit-area">
									<span>
										{$list.appeal_content}<br>{$list.appeal_time}
									</span>
									<br>
									<!-- {foreach from=$list.appeal_pic_list item=list_pic} -->
										<img src="{RC_Upload::upload_url()}/{$list_pic.file_path}" width="50" height="50" style="margin-top: 10px;">
									<!-- {/foreach} -->
									<div class="edit-list">
										<a class="data-pjax" href='{url path="comment/mh_appeal/detail" args="appeal_sn={$list.appeal_sn}&check_status={$list.check_status}"}' title="查看详情">查看详情</a>
										{if $list.check_status eq 1}&nbsp;|&nbsp;<a class="remove_apply ecjiafc-red" style="cursor: pointer;" data-msg="您确定要撤销该申诉吗？" data-href='{url path="comment/mh_appeal/revoke" args="appeal_sn={$list.appeal_sn}"}' title="撤销">撤销</a>{/if}
								    </div>
								</td>
								<td>{$list.check_status_name}</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->