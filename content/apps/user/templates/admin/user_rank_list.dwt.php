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
				<th>{lang key='user::user_rank.rank_name'}</th>
				<th class="w100">{lang key='user::user_rank.integral_min'}</th>
				<th class="w100">{lang key='user::user_rank.integral_max'}</th>
				<th class="w100">{lang key='user::user_rank.discount'}(%)</th>
				<th class="w120">{lang key='user::user_rank.show_price_short'}</th>
				<th class="w120">{lang key='user::user_rank.special_rank'}</th>
				<th class="w80">{lang key='system::system.handler'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$user_ranks item=rank} -->
			<tr>
				<td>
					<!-- {if $rank.rank_name} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_name'}" data-name="rank_name" data-pk="{$rank.rank_id}" data-title="{lang key='user::user_rank.edit_user_name'}">{$rank.rank_name}</span>
					<!-- {/if} -->
				</td>
				<td>
					<!-- {if $rank.special_rank eq 1} -->
						<span>{$rank.min_points}</span>
					<!-- {else} -->
						<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_min_points'}" data-name="min_points" data-pk="{$rank.rank_id}" data-title="{lang key='user::user_rank.edit_integral_min'}">{$rank.min_points}</span>
					<!-- {/if} -->
				</td>
				<td>
					<!-- {if $rank.special_rank eq 1} -->
						<span>{$rank.max_points}</span>
					<!-- {else} -->
						<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_max_points'}" data-name="max_points" data-pk="{$rank.rank_id}" data-title="{lang key='user::user_rank.edit_integral_max'}">{$rank.max_points}</span>
					<!-- {/if} -->
				</td>
				<td>
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='user/admin_rank/edit_discount'}" data-name="discount" data-pk="{$rank.rank_id}" data-title="{lang key='user::user_rank.edit_discount'}">{$rank.discount}</span>
				</td>
				<td>
					<i class="cursor_pointer {if $rank.show_price}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_rank/toggle_showprice'}" data-id="{$rank.rank_id}" title="{lang key='user::user_rank.click_switch_status'}"></i>
				</td>
				<td>
					<i class="cursor_pointer {if $rank.special_rank}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_rank/toggle_special'}" data-id="{$rank.rank_id}" title="{lang key='user::user_rank.click_switch_status'}"></i>
				</td>
				<td align="center">
					<a class="data-pjax no-underline" href='{url path="user/admin_rank/edit" args="id={$rank.rank_id}"}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='user::user_rank.delete_rank_confirm'}" href='{url path="user/admin_rank/remove" args="id={$rank.rank_id}"}' title="{lang key='user::user_rank.js_languages.lang_remove'}"><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->