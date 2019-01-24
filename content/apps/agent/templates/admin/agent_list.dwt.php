<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.agent.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid batch">
    <div class="btn-group f_l m_r5">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:;">
            <i class="fontello-icon-cog"></i>{t}批量操作{/t}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='agent/admin/batch'}" data-msg="您确定要这么做吗？" data-noSelectMsg="请先选择要删除的代理商！" data-name="id" href="javascript:;">
                    <i class="fontello-icon-trash"></i>{t}删除{/t}
                </a>
            </li>
        </ul>
    </div>

    <div class="f_l">
        <select name="agent_rank" class="w150">
            <option value="0" {if $smarty.get.agent_rank eq ''} selected{/if}>代理等级</option>
            <option value="1" {if $smarty.get.agent_rank eq '1'} selected{/if}>省级代理</option>
            <option value="2" {if $smarty.get.agent_rank eq '2'} selected{/if}>市级代理</option>
            <option value="3" {if $smarty.get.agent_rank eq '3'} selected{/if}>区级代理</option>
        </select>
        <a class="btn m_l5 filter-btn" data-url="{RC_Uri::url('agent/admin/init')}">筛选</a>
    </div>

    <div class="f_r">
        <input class="m_b0" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入代理商名称/手机号">
        <a class="btn m_l5 search-btn" data-url="{RC_Uri::url('agent/admin/init')}">搜索</a>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-hide-edit">
            <thead>
                <tr>
                    <th class="table_checkbox">
                        <input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
                    </th>
                    <th>姓名</th>
                    <th>手机号码</th>
                    <th>代理等级</th>
                    <th>累计管辖店铺</th>
                    <th>管辖区域</th>
                    <th class="w130">添加时间</th>
                </tr>
            </thead>
            <tbody>
                <!-- {foreach from=$list.item item=val} -->
                <tr>
                    <td>
                        <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.user_id}"/></span>
                    </td>
                    <td class="hide-edit-area">
                        {$val.name}
                        <div class="edit-list">
                            <a class="data-pjax" href="{RC_Uri::url('agent/admin/edit')}&id={$val.user_id}">编辑</a>&nbsp;|&nbsp;
                            <a class="data-pjax" href="{RC_Uri::url('agent/admin/detail')}&id={$val.user_id}">查看详情</a>&nbsp;|&nbsp;
                            <a class="ecjiafc-red" data-toggle="ajaxremove" data-msg="您确定要删除该代理商吗？" href="{RC_Uri::url('agent/admin/delete')}&id={$val.user_id}">删除</a>
                        </div>
                    </td>
                    <td>{$val.mobile}</td>
                    <td>{$val.rank_name}</td>
                    <td>{$val.store_count}</td>
                    <td>{$val.area_region}</td>
                    <td>{$val.add_time}</td>
                </tr>
                <!-- {foreachelse} -->
                <tr>
                    <td class="no-records" colspan="7">{lang key='system::system.no_records'}</td>
                </tr>
                <!-- {/foreach} -->
            </tbody>
        </table>
        <!-- {$list.page} -->
    </div>
</div>
<!-- {/block} -->