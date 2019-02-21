<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
        <div class="span12">
        	<div class="printer_title">{t domain="printer"}小票机列表{/t}</div>
        	<div class="printer_list wookmark">
        		<ul>
        			{if $list}
        			<!-- {foreach from=$list item=val} -->
        			<li class="thumbnail">
        				<div class="top">
        					<img src="{if $val.machine_logo}{$val.machine_logo}{else}{$statics_url}images/printer_logo.png{/if}" />
        					<div class="top_right">
        						<span class="name">{$val.machine_name}</span>
        						{if $val.online_status eq 1}
        						<span class="status">{t domain="printer"}在线{/t}</span>
        						{else if $val.online_status eq 2}
        						<span class="status error">{t domain="printer"}缺纸{/t}</span>
        						{else if $val.online_status eq 0}
        						<span class="status error">{t domain="printer"}离线{/t}</span>
        						{/if}
        					</div>
        				</div>
        				<div class="bottom">
        					<div class="bottom-item">{t domain="printer"}终端编号{/t}&nbsp;{$val.machine_code}</div>
        					<div class="bottom-item">{t domain="printer"}打印机型{/t}&nbsp;{$val.version}</div>
        					<div class="bottom-item">{t domain="printer"}添加日期{/t}&nbsp;{RC_Time::local_date('Y-m-d H:i:s', $val['add_time'])}</div>
        				</div>
        				<div class="view">
        					<a class="btn btn-gebo data-pjax" href='{RC_Uri::url("printer/admin_store_printer/view", "id={$val.id}&store_id={$val.store_id}")}'>{t domain="printer"}查看{/t}</a>&nbsp;&nbsp;
        					<a class="btn ajaxremove" data-toggle="ajaxremove" data-msg='{t domain="printer"}您确定要删除该小票机吗？{/t}' href='{RC_Uri::url("printer/admin_store_printer/delete", "id={$val.id}&store_id={$val.store_id}")}'>{t domain="printer"}删除{/t}</a>
        				</div>
        			</li>
        			<!-- {/foreach} -->
        			{else}
        			<li class="thumbnail add"><a class="more" href="{$add_url}"><i class="fontello-icon-plus"></i></a></li>
        			{/if}
        		</ul>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
