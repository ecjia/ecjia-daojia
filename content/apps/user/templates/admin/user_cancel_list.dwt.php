<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.user_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>

<div class="nav nav-pills">
    <li class="{if !$user_list.filter.type}active{/if}">
        <a class="data-pjax" href='{RC_Uri::url("user/admin/cancel", "{if $smarty.get.keywords}keywords={$smarty.get.keywords}{/if}")}'>{t domain="user"}到期等待处理{/t}
            <span class="badge badge-info unuse-plugins-num">{$user_list.filter.expire}</span>
        </a>
    </li>

    <li class="{if $user_list.filter.type eq 'unexpired'}active{/if}">
        <a class="data-pjax" href='{RC_Uri::url("user/admin/cancel", "type=unexpired{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>{t domain="user"}未到期{/t}
            <span class="badge badge-info unuse-plugins-num">{$user_list.filter.unexpired}</span>
        </a>
    </li>

    <form class="f_r form-inline" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm" method="post">
        <input type="text" name="keywords" placeholder='{t domain="user"}请输入商家名称或手机号{/t}' value="{$user_list.filter.keywords}"/>
        <input class="btn search_user" type="submit" value='{t domain="user"}搜索{/t}'/>
    </form>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-hide-edit">
            <thead>
                <tr>
                    <th>{t domain="user"}会员名称{/t}</th>
                    <th class="w130">{t domain="user"}邮件地址{/t}</th>
                    <th class="w100">{t domain="user"}手机号码{/t}</th>
                    <th class="w100">{t domain="user"}可用资金{/t}</th>
                    <th class="w100">{t domain="user"}积分{/t}</th>
                    <th class="w100">{t domain="user"}所属等级{/t}</th>

                    {if $user_list.filter.type eq 'unexpired'}
                    <th class="w100">{t domain="user"}倒计时{/t}</th>
                    {/if}

                    <th class="w130">{t domain="user"}申请时间{/t}</th>
                </tr>
            </thead>
            <tbody>
                <!-- {foreach from=$user_list.item item=list} -->
                <tr>
                    <td class="hide-edit-area">
                        <span>{$list.user_name}</span>
                        <div class="edit-list">
                            <a target="_blank" href='{RC_Uri::url("user/admin/info", "id={$list.user_id}")}' title='{t domain="user"}查看详情{/t}'>{t domain="user"}查看详情{/t}</a>
                            {if !$user_list.filter.type && $action}
                            &nbsp;|&nbsp;
                            <a target="_blank" class="ecjiafc-red" href='{url path="user/admin/remove_user" args="id={$list.user_id}"}'>{t domain="user"}删除{/t}</a>
                            {/if}
                        </div>
                    </td>
                    <td>{$list.email}</td>
                    <td>{$list.mobile_phone}</td>
                    <td>{$list.user_money}</td>
                    <td>{$list.pay_points}</td>
                    <td>{$list.rank_name}</td>
                    {if $user_list.filter.type eq 'unexpired'}
                    <td>{$list.diff}</td>
                    {/if}
                    <td>{$list.delete_time}</td>
                </tr>
                <!-- {foreachelse} -->
                <tr>
                    <td class="no-records" colspan="{if $user_list.filter.type eq 'unexpired'}8{else}7{/if}">{t domain="user"}没有找到任何记录{/t}</td>
                </tr>
                <!-- {/foreach} -->
            </tbody>
        </table>
        <!-- {$user_list.page} -->
    </div>
</div>
<!-- {/block} -->