<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_events_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} 
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid search_page">
	<div class="span12">
        <table class="table table-striped smpl_tbl dataTable table-hide-edit" id="plugin-table">
            <thead>
            <tr>
                <th class="w300">{t domain="mail"}事件代号{/t}</th>
                <th>{t domain="mail"}事件名称{/t}</th>
                <th>{t domain="mail"}事件描述{/t}</th>
                <th>{t domain="mail"}事件状态{/t}</th>
                <th>{t domain="mail"}操作{/t}</th>
            </tr>
            </thead>
            <tbody>
            <!-- {foreach from=$data item=list} -->
            <tr>
                <td>{$list.code}</td>
                <td>{$list.name}</td>
                <td>{$list.description}</td>
                <td>{if $list.status eq 'open'}<span class="label label-info">{t domain="mail"}开启中{/t}</span>{else}<span class="label">{t domain="mail"}已关闭{/t}</span>{/if}</td>
                <td>
                    <a class="change_status" style="cursor: pointer;"  data-msg='{if $list.status eq 'open'}{t domain="mail"}您确定要关闭该短信事件吗？{/t}{else}{t domain="mail"}您确定要开启该短信事件吗？{/t}{/if}' data-href='{if $list.status eq "open"}{url path="sms/admin_events/close" args="code={$list.code}&id={$list.id}"}{else}{url path="sms/admin_events/open" args="code={$list.code}&id={$list.id}"}{/if}' >
                    {if $list.status eq 'open'}
                    <button class="btn btn-mini btn-success" type="button">{t domain="mail"}点击关闭{/t}</button>
                    {else}
                    <button class="btn btn-mini" type="button">{t domain="mail"}点击开启{/t}</button>
                    {/if}
                    </a>
                </td>
            </tr>
            <!-- {foreachelse} -->
            <tr><td class="no-records" colspan="5">{t domain="mail"}没有找到任何记录{/t}</td></tr>
            <!-- {/foreach} -->
            </tbody>
        </table>
	</div>
</div>
<!-- {/block} -->