<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{t domain="user"}会员等级名称{/t}</th>
				<th class="w100">{t domain="user"}成长值下限{/t}</th>
				<th class="w100">{t domain="user"}成长值上限{/t}</th>
				<th class="w100">{t domain="user"}初始折扣率(%){/t}</th>
				<th class="w120">{t domain="user"}显示价格{/t}</th>
				<th class="w120">{t domain="user"}特殊会员组{/t}</th>
				<th class="w80">{t domain="user"}操作{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$user_ranks item=rank} -->
			<tr>
				<td>
					<!-- {if $rank.rank_name} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_name'}" data-name="rank_name" data-pk="{$rank.rank_id}" data-title='{t domain="user"}编辑会员名称{/t}'>{$rank.rank_name}</span>
					<!-- {/if} -->
				</td>
				<td>
					<!-- {if $rank.special_rank eq 1} -->
						<span>{$rank.min_points}</span>
					<!-- {else} -->
						<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_min_points'}" data-name="min_points" data-pk="{$rank.rank_id}" data-title='{t domain="user"}成长值下限{/t}'>{$rank.min_points}</span>
					<!-- {/if} -->
				</td>
				<td>
					<!-- {if $rank.special_rank eq 1} -->
						<span>{$rank.max_points}</span>
					<!-- {else} -->
						<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_max_points'}" data-name="max_points" data-pk="{$rank.rank_id}" data-title='{t domain="user"}成长值上限{/t}'>{$rank.max_points}</span>
					<!-- {/if} -->
				</td>
				<td>
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_discount'}" data-name="discount" data-pk="{$rank.rank_id}" data-title='{t domain="user"}编辑初始折扣率{/t}'>{$rank.discount}</span>
				</td>
				<td>
					<i class="cursor_pointer {if $rank.show_price}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_rank/toggle_showprice'}" data-id="{$rank.rank_id}" title='{t domain="user"}点击切换状态{/t}'></i>
				</td>
				<td>
					<i class="cursor_pointer {if $rank.special_rank}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_rank/toggle_special'}" data-id="{$rank.rank_id}" title='{t domain="user"}点击切换状态{/t}'></i>
				</td>
				<td align="center">
					<a class="data-pjax no-underline" href='{url path="user/admin_rank/edit" args="id={$rank.rank_id}"}' title='{t domain="user"}编辑{/t}'><i class="fontello-icon-edit"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="user"}您确定要删除会员等级吗？{/t}' href='{url path="user/admin_rank/remove" args="id={$rank.rank_id}"}' title='{t domain="user"}移除{/t}'><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="7">{t domain="user"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->