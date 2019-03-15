<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_log.init();
</script>
<!-- {/block} -->


<!-- {block name="main_content"} -->
<style media="screen">
    .tab_merchants{
        min-height: 400px;
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
        <div class="tab-pane active" id="tab6">
            <div  class="control-group form-horizontal choose_list span12">
                <form name="deleteForm" method="post" action="{url path='store/admin/batch_drop' args="store_id={$smarty.get.store_id}"}">
                    <!-- 批量删除 -->
                    <select class="w110" name="log_date">
                        <option value="0">{t domain="store"}选择日期{/t}</option>
                        <option value="1">{t domain="store"}一周之前{/t}</option>
                        <option value="2">{t domain="store"}一个月前{/t}</option>
                        <option value="3">{t domain="store"}三个月前{/t}</option>
                        <option value="4">{t domain="store"}半年之前{/t}</option>
                        <option value="5">{t domain="store"}一年之前{/t}</option>
                    </select>
                    <input type="hidden" name="drop_type_date" value="true" />
                    <button class="btn f_l" type="submit">{t domain="store"}批量删除{/t}</button>
                </form>
                <form name="siftForm" method="get" action="{$form_search_action}">
                    <span class="separ">&nbsp;</span>
                    <select class="w120" name="ip">
                        <option value="0">{t domain="store"}全部IP{/t}</option>
                        <!-- {foreach from=$ip_list item=list} -->
                        <option value="{$list}" {if $list eq $smarty.get.ip}selected="selected"{/if}>{$list}</option>
                        <!-- {/foreach} -->
                    </select>
                    <select class="w130" name="userid">
                        <option value="0">{t domain="store"}全部管理员{/t}</option>
                        <!-- {foreach from=$user_list item=list key=key} -->
                        <option value="{$key}" {if $key eq $smarty.get.user_id}selected="selected"{/if}>{$list}</option>
                        <!-- {/foreach} -->
                    </select>
                    <button class="btn f_l" type="submit">{t domain="store"}筛选{/t}</button>
                </form>
                <form class="f_r" name="searchForm" method="post" action="{$form_search_action}">
                    <!-- 关键字 -->
                    <input type="text" name="keyword" size="15" placeholder='{t domain="store"}请输入关键字{/t}' value="{$smarty.get.keyword}" />
                    <button class="btn" type="submit">{t domain="store"}搜索{/t}</button>
                </form>
            </div>

            <div class="panel-body panel-body-small">
                <section class="panel">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th class="w50">{t domain="store"}编号{/t}</th>
                                <th class="w120">{t domain="store"}操作者{/t}</th>
                                <th class="w150">{t domain="store"}操作日期{/t}</th>
                                <th class="w120">{t domain="store"}IP地址{/t}</th>
                                <th>{t domain="store"}操作记录{/t}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- {foreach from=$logs.list item=list} -->
                            <tr>
                                <td>{$list.log_id}</td>
                                <td>{$list.name}</td>
                                <td>{$list.log_time}</td>
                                <td>{$list.ip_address}</td>
                                <td>{$list.log_info}</td>
                            </tr>
                            <!-- {foreachelse} -->
                            <tr><td class="no-records" colspan="5">{t domain="store"}没有找到任何记录{/t}</td></tr>
                            <!-- {/foreach} -->
                        </tbody>
                    </table>
                </section>
            <!-- {$logs.page} -->
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->