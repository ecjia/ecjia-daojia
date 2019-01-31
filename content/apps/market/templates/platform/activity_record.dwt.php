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
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th>{t domain="market"}会员名称{/t}</th>
							<th>{t domain="market"}奖品名称{/t}</th>
							<th>{t domain="market"}发放状态{/t}</th>
							<th>{t domain="market"}来源{/t}</th>
							<th>{t domain="market"}发放时间{/t}</th>
							<th>{t domain="market"}抽奖时间{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!--{foreach from=$activity_record_list.item item=record} -->
						<tr>
							<td>{$record.user_name}</td>
							<td>{$record.prize_name}</td>
							<td>
								{if $record.issue_status eq '0'}{t domain="market"}未发放{/t}{else}{t domain="market"}已发放{/t}{/if}
							</td>
							<td>{$record.source}</td>
							<td>{$record.issue_time}</td>
							<td>{$record.add_time}</td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="6">{t domain="market"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$activity_record_list.page} -->			
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->