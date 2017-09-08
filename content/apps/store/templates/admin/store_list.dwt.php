<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<style>
.wookmark .bd {
    height: 90px;
    overflow: hidden;
	line-height: 150%;
}

.wookmark .mode_self {
	 background: url("../content/apps/store/statics/images/store_self1.png") no-repeat right top;
}
.merchants_name {
    font-size:16px;
    margin-top: 32px;
}
.merchants_name .ecjiaf-fs1 {
	/* color:#666 */
}

</style>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
    	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
    	<!-- {/if} -->
	</h3>
</div>
	
<div class="nav nav-pills">
	<li class="{if !$smarty.get.type}active{/if}">
		<a class="data-pjax" href="{if $manage_mode eq 'self'}{RC_Uri::url('store/admin/init')}{else}{RC_Uri::url('store/admin/join')}{/if}{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}">{lang key='store::store.preaudit_list'} 
			<span class="badge badge-info">{$filter.count_all}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 1}active{/if}">
		{if $manage_mode eq 'self'}
			<a class="data-pjax" href='{RC_Uri::url("store/admin/init", "type=1{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>正常
		{else}
			<a class="data-pjax" href='{RC_Uri::url("store/admin/join", "type=1{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>正常
		{/if}
			<span class="badge badge-info use-plugins-num">{$filter.count_unlock}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 2}active{/if}">	
		{if $manage_mode eq 'self'}
			<a class="data-pjax" href='{RC_Uri::url("store/admin/init", "type=2{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>{lang key='store::store.lock'}
		{else}
			<a class="data-pjax" href='{RC_Uri::url("store/admin/join", "type=2{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>{lang key='store::store.lock'}
		{/if}
			<span class="badge badge-info unuse-plugins-num">{$filter.count_locking}</span>
		</a>
	</li>
	<form class="f_r form-inline" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm" method="post">
		<input type="text" name="keywords" placeholder="{lang key='store::store.pls_name'}" value="{$store_list.filter.keywords}"/>
		<input class="btn search_store" type="submit" value="{lang key='store::store.serach'}"/>
  	</form>
</div>
<div class="row-fluid">
<div class="nav nav-pills">

	<li class="{if !$smarty.get.cat}active{/if}">
		<a class="data-pjax" href="{if $manage_mode eq 'self'}{RC_Uri::url('store/admin/init')}{else}{RC_Uri::url('store/admin/join')}{/if}{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $smarty.get.type}&type={$smarty.get.type}{/if}">全部分类
			<span class="badge badge-info"></span>
		</a>
	</li>
	<li class="{if $smarty.get.cat eq -1}active{/if}">
		<a class="data-pjax" href="{if $manage_mode eq 'self'}{RC_Uri::url('store/admin/init','cat=-1')}{else}{RC_Uri::url('store/admin/join','cat=-1')}{/if}{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $smarty.get.type}&type={$smarty.get.type}{/if}">未分类
			<span class="badge badge-info"></span>
		</a>
	</li>
	<!-- {foreach from=$cat_list key=k item=list} -->
	<li class="{if $smarty.get.cat eq $k}active{/if}">
		{if $manage_mode eq "self"}
		<a class="data-pjax" href='{RC_Uri::url("store/admin/init", "cat={$k}{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>{$list}
		</a>
		{else}
		<a class="data-pjax" href='{RC_Uri::url("store/admin/join", "cat={$k}{if $store_list.status}&merchant_keywords={$store_list.status}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>{$list}
		</a>
		{/if}
	</li>
	<!-- {/foreach} -->
</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="post" action="{$form_action}" name="listForm">
		<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
		{if $store_list.store_list}
		  	<ul>
			<!-- {foreach from=$store_list.store_list item=list} -->
				<li class='thumbnail {if $list.manage_mode eq "self"}mode_self{/if}'>
					<a href='{RC_Uri::url("store/admin/preview", "store_id={$list.store_id}")}'>
					<div class="bd">
						<div class="merchants_name">{$list.merchants_name}<br>
						<span class="ecjiaf-fs1">{if $list.company_name}{$list.company_name}{else}{$list.responsible_person}{/if}</span>
						</div>
					</div>
					</a>
				</li>
			<!-- {/foreach} -->
			</ul>
		{else}
		<pre class="sepH_c" style=" background-color: #fbfbfb; height:80px;line-height:80px;">{lang key='system::system.no_records'}</pre>
		{/if}
		</div>
		</form>
	</div>
</div>
<!-- {$store_list.page} -->

<!-- <div class="row-fluid"> -->
<!-- 	<div class="span12"> -->
<!-- 		<table class="table table-striped smpl_tbl table_vam table-hide-edit"> -->
<!-- 			<thead> -->
<!-- 			  	<tr> -->
<!-- 					<th class="w50">{lang key='store::store.id'}</th> -->
<!-- 				    <th class="w200">{lang key='store::store.store_title'}</th> -->
<!-- 				    <th class="w100">{lang key='store::store.store_cat'}</th> -->
<!-- 				    <th class="w200">{lang key='store::store.companyname'}</th> -->
<!-- 				    <th class="w150">{lang key='store::store.lable_contact_lable'}</th> -->
<!-- 				    <th class="w150">{lang key='store::store.confirm_time'}</th> -->
<!-- 				    <th class="w50">{lang key='store::store.sort_order'}</th> -->
<!-- 			  	</tr> -->
<!-- 			</thead> -->
<!-- 			<tbody> -->
				<!-- {foreach from=$store_list.store_list item=list} -->
<!-- 				<tr> -->
<!-- 					<td>{$list.store_id}</td> -->
<!-- 				    <td class="hide-edit-area"> -->
<!-- 				    	<span>{$list.merchants_name}</span> -->
<!-- 				    	<div class="edit-list"> -->
<!-- 				    		<a class="data-pjax" href='{RC_Uri::url("store/admin/edit", "store_id={$list.store_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp; -->
<!-- 				    		{if $list.status eq 1} -->
<!-- 				    		<a class="data-pjax ecjiafc-red" href='{RC_Uri::url("store/admin/status", "store_id={$list.store_id}&status={$list.status}")}' title="{lang key='store::store.lock'}">{lang key='store::store.lock'}</a>&nbsp;|&nbsp;  -->
<!-- 				    		{else} -->
<!-- 					      	<a class="data-pjax" href='{RC_Uri::url("store/admin/status", "store_id={$list.store_id}&status={$list.status}")}' title="{lang key='store::store.unlock'}">{lang key='store::store.unlock'}</a>&nbsp;|&nbsp;  -->
<!-- 					      	{/if} -->
<!-- 					     	<a class="data-pjax " href='{RC_Uri::url("store/admin_commission/edit", "store_id={$list.store_id}&id={$list.id}")}' title="{lang key='store::store.set_commission'}">{lang key='store::store.set_commission'}</a>&nbsp;|&nbsp; -->
<!-- 					     	<a class="data-pjax " href='{RC_Uri::url("commission/admin/init", "store_id={$list.store_id}")}' title="结算账单">结算账单</a>&nbsp;|&nbsp;   -->
<!-- 					     	<a class="data-pjax" href='{RC_Uri::url("store/admin/preview", "store_id={$list.store_id}")}' title="{lang key='store::store.view'}">{lang key='store::store.view'}</a>&nbsp;|&nbsp; -->
<!-- 							<a class="data-pjax" href='{RC_Uri::url("store/admin/view_staff", "store_id={$list.store_id}")}' title="{lang key='store::store.view_staff'}">{lang key='store::store.view_staff'}</a> -->
<!-- 					     </div> -->
<!-- 					</td> -->
<!-- 					<td>{$list.cat_name}</td> -->
<!-- 					<td>{$list.company_name}</td> -->
<!-- 					<td>{$list.contact_mobile}</td> -->
<!-- 					<td>{$list.confirm_time}</td> -->
<!-- 				    <td>{$list.sort_order}</td> -->
<!-- 				</tr> -->
				<!-- {foreachelse} -->
<!-- 				   <tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr> -->
				<!-- {/foreach} -->
<!--             </tbody> -->
<!--          </table> -->
<!-- 	</div> -->
<!-- </div> -->
<!-- {/block} -->