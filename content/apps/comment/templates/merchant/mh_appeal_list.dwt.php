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
					<li class="{if $smarty.get.type eq ''}active{/if}"><a class="data-pjax" href='{url path="comment/mh_appeal/init"}'>{t domain="comment"}全部{/t}<span class="badge badge-info">{if $count.count}{$count.count}{else}0{/if}</span> </a></li>
					<li class="{if $smarty.get.type eq 'untreated'}active{/if}"><a class="data-pjax" href='{url path="comment/mh_appeal/init" args="type=untreated"}'>{t domain="comment"}待处理{/t}<span class="badge badge-info">{if $count.untreated}{$count.untreated}{else}0{/if}</span></a></li>
					<li class="{if $smarty.get.type eq 'already'}active{/if}"><a class="data-pjax" href='{url path="comment/mh_appeal/init" args="type=already"}'>{t domain="comment"}已处理{/t}<span class="badge badge-info">{if $count.already}{$count.already}{else}0{/if}</span> </a></li>
				</ul>	
			
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
					<div class="form-group">
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="comment"}请输入申诉内容{/t}'/>
						<button type="button" class="btn btn-primary"><i class="fa fa-search"></i> {t domain="comment"}搜索{/t}</button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w200">{t domain="comment"}申诉编号{/t}</th>
								<th>{t domain="comment"}申诉内容{/t}</th>
								<th class="w150">{t domain="comment"}审核状态{/t}</th>
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
										<a class="data-pjax" href='{url path="comment/mh_appeal/detail" args="appeal_sn={$list.appeal_sn}&check_status={$list.check_status}"}' title='{t domain="comment"}查看详情{/t}'>{t domain="comment"}查看详情{/t}</a>
										{if $list.check_status eq 1}&nbsp;|&nbsp;<a class="remove_apply ecjiafc-red" style="cursor: pointer;" data-msg='{t domain="comment"}您确定要撤销该申诉吗？{/t}' data-href='{url path="comment/mh_appeal/revoke" args="appeal_sn={$list.appeal_sn}"}' title='{t domain="comment"}撤销{/t}'>{t domain="comment"}撤销{/t}</a>{/if}
								    </div>
								</td>
								<td>{$list.check_status_name}</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="6">{t domain="comment"}没有找到任何记录{/t}</td></tr>
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