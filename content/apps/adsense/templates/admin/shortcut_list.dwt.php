<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $city_list}
<div class="alert">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>建议您添加为"默认"地区的菜单组，当并未设置地区时就会显示默认的菜单组。
</div>

<div class="row-fluid batch">
	<ul class="nav nav-pills">
	 <!-- {foreach from=$city_list item=val} -->
		<li class="{if $city_id eq $val.city_id}active{/if}"><a class="data-pjax" href='{url path="adsense/admin_shortcut/init" args="city_id={$val.city_id}"}'>{$val.city_name}<span class="badge badge-info"></span></a></li>
	 <!-- {/foreach} -->
	</ul>
</div>
{else}
<div class="alert alert-error">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>请您先添加菜单组。
</div>
{/if}

<div class="row-fluid">
	<div class="span3">
		<div class="setting-group">
	        <span class="setting-group-title"><i class="fontello-icon-cog"></i>菜单组</span>
	        <!-- {if $data} -->
	        <ul class="nav nav-list m_t10">
		        <!-- {foreach from=$data item=val} -->
		        	<li><a class="setting-group-item data-pjax {if $position_id eq $val.position_id}llv-active{/if}" href='{url path="adsense/admin_shortcut/init" args="position_id={$val.position_id}&city_id={$city_id}"}'>{$val.position_name}</a></li>
		        <!-- {/foreach} -->
	        </ul>
	        <!-- {/if} -->
	        <br>
	        <a class="data-pjax" href='{RC_Uri::url("adsense/admin_shortcut/add_group")}'><button class="btn" type="button">添加菜单组</button></a>
		</div>
	</div>
	<div class="span9">
		<h3 class="heading">
			{if $ur_here}{$ur_here}{/if}{if $city_list}（{$position_code}）{/if}
			{if $position_id}
				<a href='{RC_Uri::url("adsense/admin_shortcut/edit_group","position_id={$position_id}&city_id={$city_id}")}' class="btn plus_or_reply data-pjax" ><i class="fontello-icon-edit"></i>编辑菜单组</a>
				<a data-toggle="ajaxremove" class="ajaxremove btn plus_or_reply"  data-msg="您要删除该菜单组么？"  href='{RC_Uri::url("adsense/admin_shortcut/delete_group","position_id={$position_id}&city_id={$city_id}")}' title="删除"><i class="fontello-icon-trash"></i>删除菜单组</a>
			{/if}
		</h3>
		
		<!-- {if $available_clients} -->
		<ul class="nav nav-pills">
	 		<!-- {foreach from=$available_clients key=key item=val} -->
				<li class="{if $show_client eq $client_list.$key}active{/if}"><a class="data-pjax" href='{url path="adsense/admin_shortcut/init" args="show_client={$client_list.$key}&position_id={$position_id}&city_id={$city_id}"}'>{$key}<span class="badge badge-info">{$val}</span></a></li>
			<!-- {/foreach} -->
		</ul>
		<!-- {/if} -->
		
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w150">缩略图</th>
					<th>图片链接</th>
					<th class="w100">是否开启</th>
					<th class="w80">排序</th>
				</tr>
			</thead>
			<!-- {foreach from=$shortcut_list item=item key=key} -->
			<tr>
				<td>
					{if $item.ad_code}
						<img src="{RC_Upload::upload_url()}/{$item.ad_code}" width="100" height="90">
					{/if}
				</td>
				<td class="hide-edit-area">
					<span><a href="{$item.ad_link}" target="_blank">{$item.ad_link}</a></span><br>
					{$item.ad_name}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("adsense/admin_shortcut/edit", "id={$item.ad_id}&city_id={$city_id}&show_client={$show_client}")}' title="编辑">编辑</a>&nbsp;|&nbsp;
						<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="您要删除该快捷菜单么？" href='{RC_Uri::url("adsense/admin_shortcut/delete", "id={$item.ad_id}&position_id={$position_id}&city_id={$city_id}")}' title="删除">删除</a>
				    </div>
				</td>
				<td>
			    	<i class="{if $item.enabled eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url='{RC_Uri::url("adsense/admin_shortcut/toggle_show","position_id={$position_id}&city_id={$city_id}&show_client={$show_client}")}' data-id="{$item.ad_id}" ></i>
				</td>
				<td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("adsense/admin_shortcut/edit_sort", "position_id={$position_id}&city_id={$city_id}&show_client={$show_client}")}' data-name="sort_order" data-pk="{$item.ad_id}" data-title="排序">{$item.sort_order}</span></td>
			</tr>
			<!-- {foreachelse} -->
			   <tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</table>
		{if $city_list}
			<a class="data-pjax" href='{RC_Uri::url("adsense/admin_shortcut/add","position_id={$position_id}&city_id={$city_id}")}'><button class="btn" type="button">添加快捷菜单</button></a>
		{/if}
	</div>
</div>    
<!-- {/block} -->