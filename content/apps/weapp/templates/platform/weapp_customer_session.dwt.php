<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.platform.wechat_customer.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
    <strong>{t domain="weapp"}温馨提示：{/t}</strong>{$errormsg}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills float-left">
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $smarty.get.status eq 2 || !$smarty.get.status}active{/if}" href='{url path="weapp/platform_customer/session" args="status=2"}'>{t domain="weapp"}待接入{/t}
                            <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.wait}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $smarty.get.status eq 1}active{/if}" href='{url path="weapp/platform_customer/session" args="status=1"}'>{t domain="weapp"}会话中{/t}
                            <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.going}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $smarty.get.status eq 3}active{/if}" href='{url path="weapp/platform_customer/session" args="status=3"}'>{t domain="weapp"}已关闭{/t}
                            <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.close}</span></a>
                    </li>
                </ul>
            </div>

            <div class="col-md-12">
                <table class="table table-hide-edit">
                    <thead>
                        <tr>
                            <th class="w130">{t domain="weapp"}客服账号{/t}</th>
                            <th>{t domain="weapp"}用户昵称{/t}</th>
                            <th>{t domain="weapp"}状态{/t}</th>
                            <th>{t domain="weapp"}创建时间{/t}</th>
                            <th>{t domain="weapp"}会话结束时间{/t}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {foreach from=$list.item item=val} -->
                        <tr>
                            <td>{if $val.kf_account}{$val.kf_account}{else}{t domain="weapp"}暂无{/t}{/if}</td>
                            <td>
                                <a href='{url path="weapp/platform_user/subscribe_message" args="uid={$val.uid}"}'>{$val.nickname}</a>
                            </td>
                            <td>
                                {if $val.status eq 1}
                                {t domain="weapp"}会话中{/t}
                                {elseif $val.status eq 2}
                                {t domain="weapp"}待接入{/t}
                                {elseif $val.status eq 3}
                                {t domain="weapp"}已关闭{/t}
                                {/if}
                            </td>
                            <td>
                                {if $val.create_time}
                                {date('Y-m-d H:i:s', ($val['create_time']))}
                                {/if}
                            </td>
                            <td>
                                {if $val.latest_time}
                                {date('Y-m-d H:i:s', ($val['latest_time']))}
                                {/if}
                            </td>
                        </tr>
                        <!--  {foreachelse} -->
                        <tr>
                            <td class="no-records" colspan="6">{t domain="weapp"}没有找到任何记录{/t}</td>
                        </tr>
                        <!-- {/foreach} -->
                    </tbody>
                </table>
                <!-- {$list.page} -->
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
