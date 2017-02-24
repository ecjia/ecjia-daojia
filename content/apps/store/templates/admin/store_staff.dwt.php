<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<!--<div>-->
<!--	<strong class="f_l span10 m_b10">{lang key='store::store.shopowner'}{t}：{/t}{$main_staff.name}</strong>-->
<!--</div>-->

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable tabs-left">

			<ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
			</ul>

			<div class="tab-content tab_merchants">
				<div class="tab-pane active" style="min-height:300px;">
				<div class="row-fluid">
                	<div class="choose_list" >
                		<strong class="f_l">{lang key='store::store.shopowner'}{$main_staff.name}</strong>
                	</div>
                </div>

                <div class="row-fluid goods_preview">
                	<div class="span12">
                		<div class="row-fluid">
                			<div class="span2 left">
                				{if $main_staff.avatar}
                				<img alt="{$main_staff.name}" class="span10 thumbnail" src="{$main_staff.avatar}">
                				{/if}
                			</div>
                			<div class="span8">
                				<h2 class="m_b10">{lang key='store::store.introduction'}</h2>
                				<p>{lang key='store::store.user_ident'}{$main_staff.user_ident}</p>
                				<p>{lang key='store::store.main_name'}{$main_staff.name}</p>
                				<p>{lang key='store::store.main_email'}{$main_staff.email}</p>
                				<p>{lang key='store::store.mobile'}{$main_staff.mobile}</p>
                				<p>{lang key='store::store.main_add_time'}{$main_staff.add_time}</p>
                				<p>{lang key='store::store.main_introduction'}{$main_staff.introduction}</p>
                			</div>
                		</div>
                	</div>
                </div>

                <div class="row-fluid">
                	<div class="span12">
                		<table class="table table-striped smpl_tbl table-hide-edit">
                			<thead>
                			<tr>
                				<th class="w80">{lang key='store::store.employee_number'}</th>
                				<th class="w80">{lang key='store::store.employee_name'}({lang key='store::store.nick_name'})</th>
                				<th class="w80">{lang key='store::store.lable_contact_lable'}</th>
                				<th class="w80">{lang key='store::store.email'}</th>
                				<th class="w80">{lang key='store::store.add_time'}</th>
                				<th class="w80">{lang key='store::store.introduction'}</th>
                			</tr>
                			</thead>
                			<tbody>
                			{if $staff_list}
                			<!-- {foreach from=$staff_list item=list} -->
                			<tr>
                				<td>{$list.user_ident}</td>
                				<td>{$list.name}({$list.nick_name})</td>
                				<td>{$list.mobile}</td>
                				<td>{$list.email}</td>
                				<td>{$list.add_time}</td>
                				<td>{$list.introduction}</td>
                			</tr>
                			<!-- {/foreach} -->
                			{else}
                			<td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td>
                			{/if}
                			</tbody>
                		</table>
                		<!-- {$store_list.page} -->
                	</div>
                </div>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- {/block} -->
