<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
.table-condensed tr:first-child td {
    border: none;
}
</style>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
        <div class="tab-pane active">
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th class="w120">{t domain="store"}时间{/t}</th>
                      <th>{t domain="store"}操作人{/t}</th>
                      <th>{t domain="store"}日志{/t}</th>
                  </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$log_list.list item=list} -->
                    <tr align="center">
                        <td>{$list.formate_time}</td>
                        <td>{$list.name}</td>
                        <td>
                            <span style="line-height: 170%"> {$list.info}</span>
                            {if $list.log}
                                <table class="table table-condensed table-hover log">
                                    <thead>
                                        <tr>
                                            <th width="20%">{t domain="store"}字段{/t}</th>
                                            <th width="40%">{t domain="store"}旧值{/t}</th>
                                            <th width="40%">{t domain="store"}新值{/t}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- {foreach from=$list.log item=log} -->
                                    <tr>
                                        <td>{$log.name}</td>
                                        <td>{if $log.is_img}{$log.original_data}{else}{$log.original_data}{/if}</td>
                                        <td>{if $log.is_img}{$log.new_data}{else}{$log.new_data}{/if}</td>
                                    </tr>
                                    <!-- {/foreach} -->
                                    </tbody>
                                </table>
                            {/if}
                        </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr><td class="no-records" colspan="3">{t domain="store"}暂无数据{/t}</td></tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
            {$log_list.page}
        </div>
    </div>
</div>
<!-- {/block} -->
