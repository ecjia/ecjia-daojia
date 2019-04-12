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
    <p>{t domain="weapp"}1、微信支付配置：实现用户在线支付的必备条件，请务必设置；{/t}</p>
    <p>{t domain="weapp"}2、正常情况下，请不要轻易修改小程序对应微信支付的商户号和商户密钥，配置不正确将导致小程序微信支付异常。{/t}</p>
    <p>{t domain="weapp"}3、如何配置？详细查看教程{/t} <a target="_blank" href="{$help_url}">{t domain="weapp"}点击此处 >>{/t}</a>
    </p>
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
                    <a class="btn btn-success btn-min-width f_r extend_handle" data-msg='{t domain="weapp"}您确定要开启微信支付吗？{/t}' href="{RC_Uri::url('weapp/platform_wechat_pay/enable')}">{t domain="weapp"}开启{/t}</a>
                    {else}
                    <a class="btn btn-danger btn-min-width f_r extend_handle" data-msg='{t domain="weapp"}您确定要关闭微信支付吗？{/t}' href="{RC_Uri::url('weapp/platform_wechat_pay/disable')}">{t domain="weapp"}关闭{/t}</a>
                    {/if}
                    <div class="fonticon-container">
                        <div class="fonticon-wrap">
                            <img class="icon-extend" src="{$images_url}wechat_pay.png"/>
                        </div>
                    </div>
                    <h4 class="title">{t domain="weapp"}微信支付{/t}</h4>
                    <p class="desc" id="js_status">
                        {t domain="weapp"}启用微信支付后，用户可以在小程序内购物使用微信支付方式。{/t}
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
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}小程序商户号：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" name="wxpay_mchid" type="text" value="{$result.wxpay_mchid}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}支付密钥(Api_Key)：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" name="wxpay_apipwd" type="text" value="{$result.wxpay_apipwd}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}客户端证书文件：{/t}</label>
                            <div class="col-lg-6 controls">
                                {if $result.wxpay_cert_client}
                                <div class="m_t5 ecjiaf-wwb">文件地址：{$result.wxpay_cert_client}</div>
                                <a class="ecjiafc-red cursor_pointer" data-toggle="ajaxremove" data-msg="您確定要刪除此文件嗎？" href="{RC_Uri::url('weapp/platform_wechat_pay/delete_file')}&type=wxpay_cert_client" data-removefile="true">刪除文件</a>
                                {else}
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-outline-primary btn-file">
                                        <span class="fileupload-new">{t domain="weapp"}浏览{/t}</span>
                                        <span class="fileupload-exists">{t domain="weapp"}修改{/t}</span>
                                        <input type="file" name="wxpay_cert_client"/>
                                    </span>
                                    <span class="fileupload-preview m_t10"></span>
                                    <a class="close fileupload-exists" style="float: none" data-dismiss="fileupload" href="javascript:;">&times;</a>
                                </div>
                                {/if}

                                <div class="help-block">{t domain="weapp"}客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式{/t}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}客户端秘钥文件：{/t}</label>
                            <div class="col-lg-6 controls">
                                {if $result.wxpay_cert_key}
                                <div class="m_t5 ecjiaf-wwb">文件地址：{$result.wxpay_cert_key}</div>
                                <a class="ecjiafc-red cursor_pointer" data-toggle="ajaxremove" data-msg="您確定要刪除此文件嗎？" href="{RC_Uri::url('weapp/platform_wechat_pay/delete_file')}&type=wxpay_cert_key" data-removefile="true">刪除文件</a>
                                {else}
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-outline-primary btn-file">
                                        <span class="fileupload-new">{t domain="weapp"}浏览{/t}</span>
                                        <span class="fileupload-exists">{t domain="weapp"}修改{/t}</span>
                                        <input type="file" name="wxpay_cert_key"/>
                                    </span>
                                    <span class="fileupload-preview m_t10"></span>
                                    <a class="close fileupload-exists" style="float: none" data-dismiss="fileupload" href="javascript:;">&times;</a>
                                </div>
                                {/if}

                                <div class="help-block">
                                    {t domain="weapp"}下载证书 cert.zip 中的 apiclient_cert.pem 文件{/t}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 label-control text-right">{t domain="weapp"}支付手续费：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" name="pay_fee" type="text" value="{$result.pay_fee}"/>
                                <div class="help-block">
                                    {t domain="weapp"}设置方式1：固定手续费，如：5{/t}<br>
                                    {t domain="weapp"}设置方式2：比例手续费，如：5%{/t}
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