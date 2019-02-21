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

<div class="alert alert-info">
    <strong>{t domain="weapp"}温馨提示：{/t}</strong>
    {t domain="weapp" escape=no 1="https://mpkf.weixin.qq.com/"}
    绑定后的客服帐号，可以登录<a style="text-decoration:none;" target="_blank" href="%1">【在线客服功能】</a>，进行客服沟通。
    {/t}
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    多客服同步操作
                </h4>
            </div>
            <div class="card-body">
                <div>
                    <button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("weapp/platform_customer/get_customer")}'>{t domain="weapp"}获取全部客服{/t}</button>
                    <span style="margin-left: 20px;">{t domain="weapp"}通过点击该按钮可以获取微信端原有的客服到本地。{/t}</span>
                </div>
                <br/>
                <div>
                    <button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("weapp/platform_customer/get_online_customer")}'>{t domain="weapp"}获取在线客服{/t}</button>
                    <span style="margin-left: 20px;">{t domain="weapp"}通过点击该按钮可以获取微信端在线的客服到本地。{/t}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <!-- {if $ur_here}{$ur_here}{/if} -->
                    <a class="btn btn-outline-primary float-right m_r10" href="https://mpkf.weixin.qq.com/" target="__blank"><i class="ft-link"></i>{t domain="weapp"}去微信客服中心{/t}</a>
                </h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills float-left">
                    <li class="nav-item">
                        <a class="nav-link {if !$smarty.get.type}active{/if} data-pjax" href='{url path="weapp/platform_customer/init"}'>{t domain="weapp"}全部客服{/t}
                            <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.all}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {if $smarty.get.type eq 'online'}active{/if} data-pjax" href='{url path="weapp/platform_customer/init" args="type=online"}'>{t domain="weapp"}在线客服{/t}
                            <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.online}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {if $smarty.get.type eq 'deleted'}active{/if} data-pjax" href='{url path="weapp/platform_customer/init" args="type=deleted"}'>{t domain="weapp"}已删客服{/t}
                            <span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.deleted}</span></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <table class="table table-hide-edit">
                    <thead>
                        <tr>
                            <th class="w130">{t domain="weapp"}客服头像{/t}</th>
                            <th class="w250">{t domain="weapp"}客服账号{/t}</th>
                            <th class="w200">{t domain="weapp"}客服昵称{/t}</th>
                            <th class="w150">{t domain="weapp"}在线状态{/t}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {foreach from=$list.item item=val} -->
                        <tr>
                            <td class="big"><img class="thumbnail" src="{$val.kf_headimgurl}"></td>
                            <td class="hide-edit-area">
                                {$val.kf_account}
                                <div class="edit-list">
                                    {if $val.online_status eq 1}
                                    <a class="get_session" href='{RC_Uri::url("weapp/platform_customer/get_session", "kf_account={$val.kf_account}")}' title='{t domain="weapp"}获取客服会话{/t}'>{t domain="weapp"}获取客服会话{/t}</a>&nbsp;|&nbsp;
                                    {/if}

                                    {if $smarty.get.type eq 'deleted'}
                                    <a class="ajaxremove ecjiafc-red"
                                       data-toggle="ajaxremove"
                                       data-msg='{t domain="weapp"}解绑该客服后将无法还原，您确定要解绑该客服吗？'{/t}
                                       href='{RC_Uri::url("weapp/platform_customer/remove", "id={$val.id}")}'
                                       title='{t domain="weapp"}删除{/t}'>
                                        {t domain="weapp"}删除{/t}
                                    </a>
                                    {else}
                                    <a class="ajaxremove ecjiafc-red"
                                       data-toggle="ajaxremove"
                                       data-msg='{t domain="weapp"}您确定要删除该客服吗？'{/t}
                                       href='{RC_Uri::url("weapp/platform_customer/edit_status", "id={$val.id}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'
                                       title='{t domain="weapp"}解绑{/t}'>
                                        {t domain="weapp"}解绑{/t}
                                    </a>
                                    {/if}
                                </div>
                            </td>

                            <td>
                                <span class="cursor_pointer" data-text="text" data-trigger="editable" data-url='{RC_Uri::url("weapp/platform_customer/edit_nick")}' data-name="{$val.kf_nick}" data-pk="{$val.id}" data-title='{t domain="weapp"}编辑客服昵称{/t}'>{$val.kf_nick}</span>
                            </td>
                            <td class="{if $val.online_status}ecjiafc-red{/if}">
                                {if $val.online_status eq 1}
                                {t domain="weapp"}web在线{/t}
                                {elseif $val.online_status eq 0}
                                {t domain="weapp"}不在线{/t}
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="bind_wx">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{t domain="weapp"}绑定微信号{/t}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- {if $errormsg} -->
            <div class="card-body">
                <div class="alert alert-danger m_b0">
                    <strong>{t domain="weapp"}温馨提示：{/t}</strong>{$errormsg}
                </div>
            </div>
            <!-- {/if} -->

            <form class="form" method="post" name="bind_form" action="{url path='weapp/platform_customer/bind_wx'}">
                <div class="card-body">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-right">{t domain="weapp"}微信号：{/t}</label>
                            <div class="col-md-8 controls">
                                <input class="form-control" type="text" name="kf_wx" value="{$smarty.get.kf_wx}" autocomplete="off" placeholder='{t domain="weapp"}请输入需要绑定的客服人员微信号{/t}'/>
                            </div>
                            <div class="col-md-1"><span class="input-must">*</span></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <input type="hidden" name="kf_account"/>
                    <input type="submit" value='{t domain="weapp"}邀请绑定{/t}' class="btn btn-outline-primary"/>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- {/block} -->