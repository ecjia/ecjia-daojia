<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.prize_list.init();
</script>
<style>
.col-lg-8{
	padding-right:0px;
}
.col-md-6{
	padding-right:0px;
} 
.col-sm-12{
	padding-right:0px;
}
.col-md-12{
	padding-right:0px;
}
.card-body{
	padding-top: 1.5rem;
    padding-right: 1.3rem;
    padding-bottom: 1.5rem;
    padding-left: 1.5rem;
}
h3{
	margin-top:0px;
}
</style>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
				{/if}
            </div>
            <div>
            	<ul class="nav nav-pills pull-left" style="padding-left:20px;">
					<li class="nav-item">
						<a class="nav-link {if $type eq ''}active{/if} data-pjax" href='{url path="market/platform_prize/init" args="code={$smarty.get.code}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>全部 <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $count.count_total}{$count.count_total}{else}0{/if}</span> </a>
					</li>
					<li class="nav-item">
						<a class="nav-link {if $type eq 'real_object'}active{/if} data-pjax" href='{url path="market/platform_prize/init" args="type=real_object&code={$smarty.get.code}{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>实物 <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $count.count_real}{$count.count_real}{else}0{/if}</span> </a>
					</li>
				</ul>
				<!-- {if $smarty.get.type eq 'real_object'} -->
					<div class="pull-right" style="padding-right:20px;">
						<a class="btn btn-info round btn-min-width mr-1 mb-1"  href='{url path="market/platform_prize/export" args="type=real_object&activity_id={$info.activity_id}"}'><i class="ft-download"></i>导出实物中奖用户信息</a>
					</div>
				<!-- {/if} -->
            </div>
			
            <div class="card-content">
				<div class="card-body">
					<div class="nav-vertical">
                        <!-- {ecjia:hook id=display_ecjia_platform_market_prize_menu} -->
						<div class="tab-content">
							<div class="tab-pane {if {$code}}active{/if}">
								 <div class="col-md-12">
									<table class="table table-hide-edit">
										<thead>
											<tr>
												<th class="w150">微信昵称</th>
												<th class="w100">{lang key='market::market.prize_name'}</th>
												<th class="w100">{lang key='market::market.assign_status'}</th>
												<th class="w150">{lang key='market::market.assign_time'}</th>
											</tr>
										</thead>
										<tbody>
											<!--{foreach from=$activity_record_list.item item=record} -->
											<tr>
												<td>{$record.user_name}</td>
												<td class="hide-edit-area">
													{$record.prize_name}<br>
													<div class="edit-list">
														{if $record.prize_type eq '2'}
															<a  href="javascript:;" data-toggle="popover" data-placement="top" data-container="body" data-original-title="中奖用户信息" data-content="{if {$record.is_issue_extend eq '1'}}收货人：{if $record.issue_extend_name}{$record.issue_extend_name}{else}未填写{/if}&nbsp;&nbsp;&nbsp;&nbsp;{if $record.issue_extend_mobile}手机号：{$record.issue_extend_mobile}{else}未填写{/if}&nbsp;&nbsp;&nbsp;&nbsp;{if $record.issue_extend_address}收货地址：{$record.issue_extend_address}{else}未填写{/if}{/if}">
																用户信息
															</a>
														{/if}
													</div>
												</td>
												<td  class="hide-edit-area">
													{if $record.issue_status eq '0'}{lang key='market::market.unreleased'}{else}{lang key='market::market.issued'}{/if}
													{if $record.prize_type eq '2' && $record.issue_status eq '0'}
														<div class="edit-list">
															<a class="toggle_view" href='{url path="market/platform_prize/issue_prize" args="id={$record.id}{if $type}&type={$type}{/if}"}' data-val="allow" data-status="1">
																发放奖品
															</a>
														</div>
													{/if}
												</td>
												<td>{$record.issue_time}</td>
											</tr>
											<!--  {foreachelse} -->
											<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
											<!-- {/foreach} -->
										</tbody>
									</table>
									<!-- {$activity_record_list.page} -->			
					            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
      
        </div>
    </div>
</div>
<!-- {/block} -->