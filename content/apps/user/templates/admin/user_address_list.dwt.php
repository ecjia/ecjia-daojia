<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<small>（{lang key='user::users.current_members'}{$user_name}）</small>
	</h3>
</div>

<ul class="nav nav-pills">
	<!-- {if $smarty.get.type eq 1} -->
		<li><a class="data-pjax" href='{url path="user/admin/address_list" args="id={$id}"}'>{lang key='user::users.full_address'}<span class="badge badge-info">{$count}</span> </a></li>
		<li class="active"><a>{lang key='user::users.default_address_two'}<span class="badge badge-info">{$default_count}</span></a></li>
	<!-- {else} -->
		<li class="active"><a>{lang key='user::users.full_address'} <span class="badge badge-info">{$count}</span></a></li>
		<li><a class="data-pjax" href='{url path="user/admin/address_list" args="type=1&id={$id}"}'>{lang key='user::users.default_address_two'} <span class="badge badge-info">{$default_count}</span> </a></li>
	<!-- {/if} -->
</ul>

<div class="dataTables_wrapper">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr>
				<th>{lang key='user::users.receiver_name'}</th>
				<th>{lang key='user::users.region'}</th>
				<th>{lang key='user::users.address'}</th>
				<th>{lang key='user::users.zip_code'}</th>
				<th class="w200">{lang key='user::users.telephone_phone'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$address_list key=Key item=val} -->
			<tr class="{if $val.default_address}info{/if}">
				<td>{$val.consignee|escape}</td>
				<td>
					{$val.country_name} {$val.province_name} {$val.city_name} {$val.district_name}
				</td>
				<td>{$val.address|escape}{$val.address_info|escape}</td>
				<td>{$val.zipcode|escape}</td>
				<td>
					{lang key='user::users.tel'}：{$val.tel}<br/>
					{lang key='user::users.mobile'}：{$val.mobile}
				</td>
				<!-- <td>{$lang.best_time}：{$val.best_time|escape}<br/>{$lang.sign_building}：{$val.sign_building|escape}<br/>email：{$val.email}</td> -->
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="5">{lang key='user::users.no_address'}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->
