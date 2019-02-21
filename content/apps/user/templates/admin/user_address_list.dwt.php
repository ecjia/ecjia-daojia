<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<small>{t domain="user" 1={$user_name}}（当前会员：%1）{/t}</small>
	</h3>
</div>

<ul class="nav nav-pills">
	<!-- {if $smarty.get.type eq 1} -->
		<li><a class="data-pjax" href='{url path="user/admin/address_list" args="id={$id}"}'>{t domain="user"}全部地址{/t} <span class="badge badge-info">{$count}</span> </a></li>
		<li class="active"><a>{t domain="user"}默认地址{/t} <span class="badge badge-info">{$default_count}</span></a></li>
	<!-- {else} -->
		<li class="active"><a>{t domain="user"}全部地址{/t} <span class="badge badge-info">{$count}</span></a></li>
		<li><a class="data-pjax" href='{url path="user/admin/address_list" args="type=1&id={$id}"}'>{t domain="user"}默认地址{/t} <span class="badge badge-info">{$default_count}</span> </a></li>
	<!-- {/if} -->
</ul>

<div class="dataTables_wrapper">
	<table class="table table-striped" id="smpl_tbl">
		<thead>
			<tr>
				<th>{t domain="user"}收货人{/t}</th>
				<th>{t domain="user"}所在地区{/t}</th>
				<th>{t domain="user"}详细地址{/t}</th>
				<th>{t domain="user"}邮编{/t}</th>
				<th class="w200">{t domain="user"}电话/手机{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$address_list key=Key item=val} -->
			<tr class="{if $val.default_address}info{/if}">
				<td>{$val.consignee|escape}</td>
				<td>
					{$val.country_name} {$val.province_name} {$val.city_name} {$val.district_name} {$val.street_name}
				</td>
				<td>{$val.address|escape}{$val.address_info|escape}</td>
				<td>{$val.zipcode|escape}</td>
				<td>
                    {t domain="user"}电话：{/t}{$val.tel}<br/>
                    {t domain="user"}手机：{/t}{$val.mobile}
				</td>
				<!-- <td>{$lang.best_time}：{$val.best_time|escape}<br/>{$lang.sign_building}：{$val.sign_building|escape}<br/>email：{$val.email}</td> -->
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="5">{t domain="user"}该用户暂无收货地址{/t}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->
