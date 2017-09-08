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
		<a class="btn plus_or_reply data-pjax"  id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{t}{$action_link.text}{/t}</a>
	    <!-- {/if} -->
	</h3>
</div>
	
<ul class="nav nav-pills">
	<li class="{if $count.type eq ''}active{/if}"><a class="data-pjax" href='{url path="cron/admin_plugin/init"}'>{t}已启用{/t}<span class="badge badge-info">{$count.enabled}</span> </a></li>
	<li class="{if $count.type eq 'disabled'}active{/if}"><a class="data-pjax" href='{url path="cron/admin_plugin/init" args="type=disabled"}'>{t}已禁用{/t}<span class="badge badge-info">{$count.disabled}</span></a></li>
</ul>
	

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
    	<tr>
        	<th class="w180">{lang key='cron::cron.cron_name'}</th>
			<th>{lang key='cron::cron.cron_desc'}</th>
			<th class="w150">{lang key='cron::cron.cron_this'}</th>
			<th class="w170">{lang key='cron::cron.cron_next'}</th>
        </tr>
   	</thead>
    <tbody>
       	<!-- {foreach from=$modules item=module} -->
		<tr>
		    <td>{$module.name}</td>
		    <td class="hide-edit-area">{$module.desc|nl2br}
		    <div class="edit-list">
	    		{if $module.enabled == '1'}
		        	<a class="data-pjax" href='{RC_Uri::url("cron/admin_plugin/edit", "code={$module.code}")}'>{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
		        	<a class="cursor_pointer toggle_view" href="{RC_Uri::url('cron/admin_plugin/run')}" data-val="{$module.code}" data-msg="{lang key='cron::cron.do_confirm'}">{lang key='cron::cron.cron_do'}</a>&nbsp;|&nbsp;
		        	<a class="cursor_pointer ecjiafc-red toggle_view" href="{RC_Uri::url('cron/admin_plugin/disable')}" data-val="{$module.code}" data-msg="{lang key='cron::cron.disabled_confirm'}">{lang key='cron::cron.disable'}</a>
		   		{else}
		          	<a class="cursor_pointer toggle_view" href="{RC_Uri::url('cron/admin_plugin/enable')}" data-val="{$module.code}" data-msg="{lang key='cron::cron.enable_confirm'}">{lang key='cron::cron.enable'}</a>
		    	{/if}
	    	</div>
		    </td>
		    <td align="center">{$module.thistime}</td>
		    <td align="center">{$module.nextime}</td>
		</tr>
	 	<!-- {foreachelse} -->
	 	<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
	 	<!-- {/foreach} -->
    </tbody>
</table>
 
<!-- {/block} -->