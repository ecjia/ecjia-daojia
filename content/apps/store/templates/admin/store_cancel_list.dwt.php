<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.admin_cancel.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>

<div class="nav nav-pills">
    <li class="{if !$store_list.filter.type}active{/if}">
        <a class="data-pjax" href='{RC_Uri::url("store/admin_cancel/init", "{if $smarty.get.keywords}keywords={$smarty.get.keywords}{/if}")}'>{t domain="store"}到期等待处理{/t}
            <span class="badge badge-info unuse-plugins-num">{$store_list.filter.expire}</span>
        </a>
    </li>

    <li class="{if $store_list.filter.type eq 'unexpired'}active{/if}">
        <a class="data-pjax" href='{RC_Uri::url("store/admin_cancel/init", "type=unexpired{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>{t domain="store"}未到期{/t}
            <span class="badge badge-info unuse-plugins-num">{$store_list.filter.unexpired}</span>
        </a>
    </li>

    <form class="f_r form-inline" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm" method="post">
        <input type="text" name="keywords" placeholder='{t domain="store"}请输入商家名称或手机号{/t}' value="{$store_list.filter.keywords}"/>
        <input class="btn search_store" type="submit" value='{t domain="store"}搜索{/t}'/>
    </form>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-hide-edit">
            <thead>
                <tr>
                    <th class="w130">{t domain="store"}店铺名称{/t}</th>
                    <th class="w100">{t domain="store"}商家分类{/t}</th>
                    <th class="w100">{t domain="store"}负责人{/t}</th>
                    <th>{t domain="store"}公司名称{/t}</th>
                    <th class="w150">{t domain="store"}手机号{/t}</th>

                    {if $store_list.filter.type eq 'unexpired'}
                    <th class="w150">{t domain="store"}倒计时{/t}</th>
                    {/if}

                    <th class="w150">{t domain="store"}申请时间{/t}</th>
                </tr>
            </thead>
            <tbody>
                <!-- {foreach from=$store_list.item item=list} -->
                <tr>
                    <td class="hide-edit-area">
                        <span>{$list.merchants_name} {if $list.manage_mode eq 'self'}&nbsp;<span class="ecjiafc-red">{t domain="store"}(自营){/t}</span>{/if}</span>
                        <div class="edit-list">
                            <a target="_blank" href='{RC_Uri::url("store/admin/preview", "store_id={$list.store_id}")}' title='{t domain="store"}查看详情{/t}'>{t domain="store"}查看详情{/t}</a>
                            {if !$store_list.filter.type && $action}
                            &nbsp;|&nbsp;
                            <a target="_blank" class="ecjiafc-red" href='{url path="store/admin/remove_store" args="store_id={$list.store_id}"}'>{t domain="store"}删除{/t}</a>
                            {/if}
                        </div>
                    </td>
                    <td>{$list.cat_name}</td>
                    <td>{$list.responsible_person}</td>
                    <td>{$list.company_name}</td>
                    <td>{$list.contact_mobile}</td>
                    {if $store_list.filter.type eq 'unexpired'}
                    <td>{$list.diff}</td>
                    {/if}
                    <td>{$list.delete_time}</td>
                </tr>
                <!-- {foreachelse} -->
                <tr>
                    <td class="no-records" colspan="{if $store_list.filter.type eq 'unexpired'}7{else}6{/if}">{t domain="store"}没有找到任何记录{/t}</td>
                </tr>
                <!-- {/foreach} -->
            </tbody>
        </table>
        <!-- {$store_list.page} -->
    </div>
</div>
<!-- {/block} -->