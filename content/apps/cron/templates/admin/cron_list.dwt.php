<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cron.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	    <!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax"  id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	    <!-- {/if} -->
	</h3>
</div>
	
<ul class="nav nav-pills">
	<li class="{if $count.type eq ''}active{/if}"><a class="data-pjax" href='{url path="cron/admin_plugin/init"}'>{t domain="cron"}已启用{/t}<span class="badge badge-info">{$count.enabled}</span> </a></li>
	<li class="{if $count.type eq 'disabled'}active{/if}"><a class="data-pjax" href='{url path="cron/admin_plugin/init" args="type=disabled"}'>{t domain="cron"}已禁用{/t}<span class="badge badge-info">{$count.disabled}</span></a></li>
</ul>
	

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
    	<tr>
        	<th class="w180">{t domain="cron"}计划任务名称{/t}</th>
			<th>{t domain="cron"}计划任务描述{/t}</th>
			<th class="w150">{t domain="cron"}上次执行时间{/t}</th>
			<th class="w150">{t domain="cron"}下次执行时间{/t}</th>
        </tr>
   	</thead>
    <tbody>
       	<!-- {foreach from=$modules item=module} -->
		<tr>
		    <td>{$module.name}</td>
		    <td class="hide-edit-area">{$module.desc|nl2br}
		    <div class="edit-list">
	    		{if $module.enabled == '1'}
		        	<a class="data-pjax" href='{RC_Uri::url("cron/admin_plugin/edit", "code={$module.code}")}'>{t domain="cron"}编辑{/t}</a>&nbsp;|&nbsp;
		        	<a class="cursor_pointer toggle_view" href="{RC_Uri::url('cron/admin_plugin/run')}" data-val="{$module.code}" data-msg='{t domain="cron"}您确定要执行该计划任务吗？{/t}'>{t domain="cron"}执行{/t}</a>&nbsp;|&nbsp;
		        	<a class="cursor_pointer ecjiafc-red toggle_view" href="{RC_Uri::url('cron/admin_plugin/disable')}" data-val="{$module.code}" data-msg='{t domain="cron"}您确定要禁用该计划任务吗？{/t}'>{t domain="cron"}禁用{/t}</a>
		   		{else}
		          	<a class="cursor_pointer toggle_view" href="{RC_Uri::url('cron/admin_plugin/enabled')}" data-val="{$module.code}" data-msg='{t domain="cron"}您确定要启用该计划任务吗？{/t}'>{t domain="cron"}启用{/t}</a>
		    	{/if}
	    	</div>
		    </td>
		    <td align="center">{$module.runtime}</td>
		    <td align="center">{$module.nexttime}</td>
		</tr>
	 	<!-- {foreachelse} -->
	 	<tr><td class="no-records" colspan="4">{t domain="cron"}没有找到任何记录{/t}</td></tr>
	 	<!-- {/foreach} -->
    </tbody>
</table>
 
<!-- {/block} -->