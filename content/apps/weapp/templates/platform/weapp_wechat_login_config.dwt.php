<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.platform.platform.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="alert alert-light alert-dismissible mb-2" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="alert-heading mb-2">{t domain="weapp"}操作提示{/t}</h4>
    <p>{t domain="weapp"}1、微信登录配置：实现用户使用微信，授权绑定登录小程序，用户购物无需繁琐的注册流程；{/t}</p>
    <p>{t domain="weapp"}2、确保信息都填写正确，若内容已配置好，请不要随意修改，避免导致微信登录异常情况；{/t}</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {$ur_here}
                    {if $action_link}
                    <a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
                    {/if}
                </h4>
            </div>
            <div class="card-body">
                <div class="highlight_box global icon_wrap group" id="js_apply_btn">
                    {if !$enabled}
                    <a class="btn btn-success btn-min-width f_r extend_handle" data-msg='{t domain="weapp"}您确定要开启微信登录吗？{/t}' href="{RC_Uri::url('weapp/platform_wechat_login/enable')}">{t domain="weapp"}开启{/t}</a>
                    {else}
                    <a class="btn btn-danger btn-min-width f_r extend_handle" data-msg='{t domain="weapp"}您确定要关闭微信登录吗？{/t}' href="{RC_Uri::url('weapp/platform_wechat_login/disable')}">{t domain="weapp"}关闭{/t}</a>
                    {/if}
                    <div class="fonticon-container">
                        <div class="fonticon-wrap">
                            <img class="icon-extend" src="{$images_url}wechat_login.png"/>
                        </div>
                    </div>
                    <h4 class="title">{t domain="weapp"}微信登录{/t}</h4>
                    <p class="desc" id="js_status">
                        {t domain="weapp"}启用微信登录后，用户打开小程序后，可使用授权绑定微信快捷登录。{/t}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{if $enabled}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {t domain="weapp"}配置信息{/t}
                </h4>
            </div>
            <div class="card-body">
                <form class="form" method="post" name="theForm" action="{$form_action}">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}AppID：{/t}</label>
                            <div class="col-lg-6 controls">{$account.appid}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}AppSecret：{/t}</label>
                            <div class="col-lg-6 controls">{$account.appsecret}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}回调地址：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" name="sns_wechat_callback" type="text" placeholder="xx.com" value="{$result.sns_wechat_callback}"/>
                                <div class="help-block">
                                    {t domain="weapp"}(请勿修改，仅供参考)此回调地址的格式，用于填写申请微信公众平台的网页授权域名。{/t}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <input type="submit" class="btn btn-outline-primary" value='{t domain="weapp"}保存{/t}'/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{/if}
<!-- {/block} -->