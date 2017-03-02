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
    <div class="span12">
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
            </ul>
            <div class="tab-content tab_merchants">
                <div class="tab-pane active" id="tab6">
                    <div  class="control-group form-horizontal choose_list span12">
                        <form name="deleteForm" method="post" action="{url path='store/admin/batch_drop' args="store_id={$smarty.get.store_id}"}">
                            <!-- 批量删除 -->
                            <select class="w110" name="log_date">
                                <option value="0">{t}选择日期{/t}</option>
                                <option value="1">{t}一周之前{/t}</option>
                                <option value="2">{t}一个月前{/t}</option>
                                <option value="3">{t}三个月前{/t}</option>
                                <option value="4">{t}半年之前{/t}</option>
                                <option value="5">{t}一年之前{/t}</option>
                            </select>
                            <input type="hidden" name="drop_type_date" value="true" />
                            <button class="btn f_l" type="submit">{t}批量删除{/t}</button>
                        </form>
                        <form name="siftForm" method="get" action="{$form_search_action}">
                            <span class="separ">&nbsp;</span>
                            <select class="w120" name="ip">
                                <option value="0">{t}全部IP{/t}</option>
                                <!-- {foreach from=$ip_list item=list} -->
                                <option value="{$list}" {if $list eq $smarty.get.ip}selected="selected"{/if}>{$list}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select class="w130" name="userid">
                                <option value="0">{t}全部管理员{/t}</option>
                                <!-- {foreach from=$user_list item=list key=key} -->
                                <option value="{$key}" {if $key eq $smarty.get.user_id}selected="selected"{/if}>{$list}</option>
                                <!-- {/foreach} -->
                            </select>
                            <button class="btn f_l" type="submit">{t}筛选{/t}</button>
                        </form>
                        <form class="f_r" name="searchForm" method="post" action="{$form_search_action}">
                            <!-- 关键字 -->
                            <input type="text" name="keyword" size="15" placeholder="{t}请输入关键字{/t}" value="{$smarty.get.keyword}" />
                            <button class="btn" type="submit">{t}搜索{/t}</button>
                        </form>
                    </div>

                    <div class="panel-body panel-body-small">
                        <section class="panel">
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th>{lang key='store::store.log_id'}</th>
                                        <th>{lang key='store::store.log_name'}</th>
                                        <th>{lang key='store::store.log_time'}</th>
                                        <th>{lang key='store::store.log_ip'}</th>
                                        <th>{lang key='store::store.log_info'}</th>
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
                                       <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
                                    <!-- {/foreach} -->
                                </tbody>
                            </table>
                        </section>
                    <!-- {$logs.page} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
