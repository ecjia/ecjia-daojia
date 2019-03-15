<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.weapp.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
    <div class="pull-left">
        <h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
    </div>
    <div class="pull-right">
        {if $action_link}
        <a href="{$action_link.href}" class="btn btn-primary data-pjax">
            <i class="fa fa-plus"></i> {$action_link.text}
        </a>
        {/if}
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body panel-body-small">
                <div class="btn-group f_l">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cogs"></i> {t domain="weapp"}批量操作{/t} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="weapp/merchant/batch_remove"}' data-msg='{t domain="weapp"}您确定要这么做吗？{/t}' data-noSelectMsg='{t domain="weapp"}请先选择要删除的小程序！{/t}' data-name="id" href="javascript:;"><i class="fa fa-trash-o"></i> {t domain="weapp"}删除小程序{/t}</a>
                        </li>
                    </ul>
                </div>

                <form class="form-inline f_r" action="{$search_action}" method="post" name="searchForm">
                    <div class="screen f_r">
                        <div class="form-group">
                            <input class="form-control" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="weapp"}请输入小程序名称关键词{/t}'/>
                        </div>
                        <button class="btn btn-primary search_wechat" type="submit"><i class="fa fa-search"></i> {t domain="weapp"}搜索{/t}
                        </button>
                    </div>
                </form>
            </div>

            <div class="panel-body panel-body-small">
                <section class="panel">
                    <table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
                        <thead>
                            <tr>
                                <th class="table_checkbox check-list w30">
                                    <div class="check-item">
                                        <input id="checkbox_all" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/><label for="checkbox_all"></label>
                                    </div>
                                </th>
                                <th class="w80">{t domain="weapp"}Logo{/t}</th>
                                <th class="w200">{t domain="weapp"}公众号名称{/t}</th>
                                <th class="w50">{t domain="weapp"}状态{/t}</th>
                                <th class="w50">{t domain="weapp"}排序{/t}</th>
                                <th class="w100">{t domain="weapp"}添加时间{/t}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- {foreach from=$weapp_list.item item=val} -->
                            <tr class="big">
                                <td class="check-list">
                                    <div class="check-item">
                                        <input id="checkbox_{$val.id}" type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/><label for="checkbox_{$val.id}"></label>
                                    </div>
                                </td>
                                <td><img class="thumbnail" src="{$val.logo}"></td>
                                <td class="hide-edit-area">
                                    {$val.name}<br>
                                    <div class="edit-list">
                                        <a target="_blank" href='{RC_Uri::url("weapp/merchant/autologin","id={$val.id}")}' title='{t domain="weapp"}进入管理{/t}'>{t domain="weapp"}进入管理{/t}</a> &nbsp;|&nbsp;
                                        <a class="data-pjax" href='{RC_Uri::url("weapp/merchant/edit", "id={$val.id}")}' title='{t domain="weapp"}编辑{/t}'>{t domain="weapp"}编辑{/t}</a> &nbsp;|&nbsp;
                                        <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="weapp" 1={$val.name}}您确定要删除小程序[%1]吗？{/t}' href='{RC_Uri::url("weapp/merchant/remove", "id={$val.id}")}' title='{t domain="weapp"}删除{/t}'>{t domain="weapp"}删除{/t}</a>
                                    </div>
                                </td>
                                <td>
                                    <i class="fa {if $val.status eq 1}fa-check{else}fa-times{/if} cursor_pointer" data-trigger="toggleState" data-url="{RC_Uri::url('weapp/merchant/toggle_show')}" data-id="{$val.id}"></i>
                                </td>
                                <td>
                                    <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('weapp/merchant/edit_sort')}" data-name="sort" data-pk="{$val.id}" data-title='{t domain="weapp"}编辑排序{/t}'>{$val.sort}</span>
                                </td>
                                <td>
                                    {$val.add_time}
                                </td>
                            </tr>
                            <!--  {foreachelse} -->
                            <tr>
                                <td class="no-records" colspan="6">{t domain="weapp"}没有找到任何记录{/t}</td>
                            </tr>
                            <!-- {/foreach} -->
                        </tbody>
                    </table>
                </section>
                <!-- {$weapp_list.page} -->
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
