<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
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
        <div class="tab-content tab_merchants">
            <div class="tab-pane active" style="min-height:300px;">
                <div class="row-fluid">
                    <div class="choose_list" >
                        <strong class="f_l">{t domain="staff"}店长：{/t}{$main_staff.name}</strong>
                    </div>
                </div>

                <div class="row-fluid goods_preview">
                    <div class="span12">
                        <div class="row-fluid">
                            <div class="span2 left">
                                {if $main_staff.avatar}
                                <img alt="{$main_staff.name}" class="span10 thumbnail" src="{$main_staff.avatar}">
                                {/if}
                            </div>
                            <div class="span8">
                                <p>{t domain="staff"}编号：{/t}{$main_staff.user_ident}</p>
                                <p>{t domain="staff"}姓名：{/t}{$main_staff.name}{if $main_staff.nick_name}（{$main_staff.nick_name}）{/if}</p>
                                <p>{t domain="staff"}邮箱：{/t}{$main_staff.email}</p>
                                <p>{t domain="staff"}联系方式：{/t}{$main_staff.mobile}</p>
                                <p>{t domain="staff"}加入时间：{/t}{$main_staff.add_time}</p>
                                <p>{t domain="staff"}介绍：{/t}{$main_staff.introduction}</p>
                            </div>
                            {if $store.manage_mode eq 'self'}
                            <div class="span2 left">
                                 <p><a class="data-pjax btn" href='{RC_Uri::url("staff/admin_store_staff/edit", "store_id={$store.store_id}&main_staff=1")}'>{t domain="staff"}编辑店长{/t}</a></p>
                                 <p><a class="toggle_view btn" href='{RC_Uri::url("staff/admin_store_staff/reset_staff", "store_id={$store.store_id}&main_staff=1")}' data-msg='{t domain="staff" escape=no}重置店长登录密码将发送新密码到店长手机短信，<br>您确定要重置吗？{/t}' data-pjax-url="{$current_url}">{t domain="staff"}重置密码{/t}</a></p>
                            </div>
                            {/if}
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-striped smpl_tbl table-hide-edit">
                            <thead>
                                <tr>
                                    <th class="w80">{t domain="staff"}员工编号{/t}</th>
                                    <th class="w80">{t domain="staff"}员工姓名{/t}({t domain="staff"}昵称{/t})</th>
                                    <th class="w80">{t domain="staff"}联系方式{/t}</th>
                                    <th class="w80">{t domain="staff"}邮箱{/t}</th>
                                    <th class="w80">{t domain="staff"}加入时间{/t}</th>
                                    <th class="w80">{t domain="staff"}描述{/t}</th>
                                </tr>
                            </thead>
                            <tbody>
                            {if $staff_list}
                            <!-- {foreach from=$staff_list item=list} -->
                            <tr>
                                <td>{$list.user_ident}</td>
                                <td>{$list.name}({$list.nick_name})</td>
                                <td>{$list.mobile}</td>
                                <td>{$list.email}</td>
                                <td>{$list.add_time}</td>
                                <td>{$list.introduction}</td>
                            </tr>
                            <!-- {/foreach} -->
                            {else}
                            <td class="no-records" colspan="6">{t domain="staff"}没有找到任何记录{/t}</td>
                            {/if}
                            </tbody>
                        </table>
                        <!-- {$store_list.page} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
