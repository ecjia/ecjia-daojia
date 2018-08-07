<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.prize_list.init();
</script>
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
            <div class="card-content">
				<div class="card-body">
					<div class="nav-vertical">
                        <!-- {ecjia:hook id=display_ecjia_platform_market_prize_menu} -->
						<div class="tab-content px-1">
							<div class="tab-pane {if {$code}}active{/if}">
								 <div class="col-md-12">
									<table class="table table-hide-edit">
										<thead>
											<tr>
												<th class="w150">{lang key='market::market.member_name'}</th>
												<th class="w70">{lang key='market::market.prize_name'}</th>
												<th class="w50">{lang key='market::market.assign_status'}</th>
												<th>{lang key='market::market.source'}</th>
												<th>{lang key='market::market.assign_time'}</th>
												<th>{lang key='market::market.draw_time'}</th>
											</tr>
										</thead>
										<tbody>
											<!--{foreach from=$activity_record_list.item item=record} -->
											<tr>
												<td>{$record.user_name}</td>
												<td>{$record.prize_name}</td>
												<td  class="hide-edit-area">
													{if $record.issue_status eq '0'}{lang key='market::market.unreleased'}{else}{lang key='market::market.issued'}{/if}
													{if $record.prize_type eq '2' && $record.issue_status eq '0'}
														<div class="edit-list">
															<a class="toggle_view" href='{url path="market/platform_prize/issue_prize" args="id={$record.id}"}' data-val="allow" data-status="1">
																发放奖品
															</a>
														</div>
													{/if}
												</td>
												<td>{$record.source}</td>
												<td>{$record.issue_time}</td>
												<td>{$record.add_time}</td>
											</tr>
											<!--  {foreachelse} -->
											<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
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