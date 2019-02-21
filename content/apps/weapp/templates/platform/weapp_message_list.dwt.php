<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.platform.admin_subscribe.init();
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

                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $list.filter.status eq 1}active{/if}" href='{url path="weapp/platform_message/init" args="status=1"}'>{t domain="weapp"}最近五天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.last_five_days}{$list.filter.last_five_days}{else}0{/if}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $list.filter.status eq 2}active{/if}" href='{url path="weapp/platform_message/init" args="status=2"}'>{t domain="weapp"}今天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.today}{$list.filter.today}{else}0{/if}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $list.filter.status eq 3}active{/if}" href='{url path="weapp/platform_message/init" args="status=3"}'>{t domain="weapp"}昨天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.yesterday}{$list.filter.yesterday}{else}0{/if}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $list.filter.status eq 4}active{/if}" href='{url path="weapp/platform_message/init" args="status=4"}'>{t domain="weapp"}前天{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.the_day_before_yesterday}{$list.filter.the_day_before_yesterday}{else}0{/if}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $list.filter.status eq 5}active{/if}" href='{url path="weapp/platform_message/init" args="status=5"}'>{t domain="weapp"}更早{/t}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.earlier}{$list.filter.earlier}{else}0{/if}</span></a>
                    </li>
                </ul>
            </div>

            <div class="col-md-12">
                <table class="table table-hide-edit">
                    <thead>
                        <tr>
                            <th class="w130">用户信息</th>
                            <th>消息内容</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {foreach from=$list.item item=val} -->
                        <tr>
                            <td class="big">
                                <a tabindex="0" class="user_info" title='{t domain="weapp"}详细资料{/t}' data-toggle="popover" data-uid="{$val.uid}" data-url='{RC_Uri::url("weapp/platform_message/get_user_info", "uid={$val.uid}")}'>
                                    <img class="thumbnail" src="{if $val.headimgurl}{$val.headimgurl}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}">
                                </a>
                                <div class="w80 m_t5 ecjiaf-tac">{$val.nickname}</div>
                                <div id="popover-content_{$val.uid}" class="hide"></div>
                            </td>
                            <td class="hide-edit-area">
                                <div>{t domain="weapp"}发送于：{/t}{$val.send_time}</div>
                                <span class="ecjiaf-pre">{$val.msg}</span>
                                <div class="edit-list">
                                    <a target="_blank" href='{RC_Uri::url("weapp/platform_user/subscribe_message", "uid={$val.uid}")}' title='{t domain="weapp"}回复{/t}'>{t domain="weapp"}回复{/t}</a>
                                </div>
                            </td>
                        </tr>
                        <!--  {foreachelse} -->
                        <tr>
                            <td class="no-records" colspan="2">{t domain="weapp"}没有找到任何记录{/t}</td>
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