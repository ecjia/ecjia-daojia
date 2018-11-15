<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {foreach from=$menu_list item=list name=m} -->
<li class="menu-item size_{$count} {if $id eq $list.id}size1of1{/if}">
    <div class="menu-item-title" data-toggle="edit-menu" data-id="{$list.id}" data-pid="{$list.pid}">
        {if $list.sub_button}
        <i class="icon_menu_dot"></i>
        {/if}
        <span>{$list.name}</span>
    </div>
    <ul class="weixin-sub-menu {if $pid neq $list.id && $id neq $list.id}hide{/if}">
        <!-- {foreach from=$list.sub_button item=sub name=s} -->
        <li class="menu-sub-item {if $id eq $sub.id}current{/if}">
            <div class="menu-item-title" data-toggle="edit-menu" data-id="{$sub.id}" data-pid="{$sub.pid}">{$sub.name}</div>
        </li>
        <!-- {/foreach} -->
        {if $list.count lt 5}
        <li class="menu-sub-item" data-toggle="add-menu" data-pid="{$list.id}" data-count="{$list.count}">
            <div class="menu-item-title">
                <a class="pre_menu_link" href="javascript:void(0);" title="最多添加5个子菜单"><i class="icon14_menu_add"></i></a>
            </div>
        </li>
        {/if}
        <i class="menu-arrow arrow_out"></i>
        <i class="menu-arrow arrow_in"></i>
    </ul>
</li>
<!-- {/foreach} -->
{if $count lt 3}
<li class="menu-item size_{$count}" data-toggle="add-menu" data-pid="0"><a class="pre_menu_link" href="javascript:void(0);" title="最多添加3个一级菜单"> <i class="icon14_menu_add"></i> {if $count eq 0}<span>添加菜单</span>{/if}</a></li>
{/if}