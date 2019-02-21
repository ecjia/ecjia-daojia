<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.weapp.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="staticalert alert alert-dismissable ui_showmessage panel"><a class="close" data-dismiss="alert">×</a>
    <p><h4>{t domain="weapp"}操作提示{/t}</h4></p>
    {t domain="weapp" escape=no 1="https://mp.weixin.qq.com/debug/wxadoc/introduction/index.html" 2="https://mp.weixin.qq.com/"}
    <p>一、配置前先<a href="%1" target="__blank"> 注册小程序 </a>，进行微信认证, 已有微信小程序<a href="%2" target="__blank"> 立即登录 </a>。
    </p>
    {/t}
    {t domain="weapp" escape=no 1="https://mp.weixin.qq.com/"}
    <p>二、登录<a href="%1" target="__blank"> 微信公众号平台 </a>后，在 设置 - 开发者设置 中，查看到微信小程序的 AppID、Appsecret，并配置填写好域名。（注意不可直接使用微信服务号或订阅号的 AppID、AppSecret）
    </p>
    {/t}
    <p>{t domain="weapp"}三、微信认证后，开通小程序微信支付。开通后，配置小程序微信支付的商户号和密钥。{/t}</p>
</div>

<div class="page-header">
    <div class="pull-left">
        <h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
    </div>
    <div class="pull-right">
        {if $action_link}
        <a href="{$action_link.href}" class="btn btn-primary data-pjax">
            <i class="fa fa-reply"></i> {$action_link.text}
        </a>
        {/if}
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <form class="form-horizontal" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data">
                    <div class="tab-content">
                        <fieldset>
                            <div class="row-fluid edit-page">
                                {if $wxapp_info.id neq ''}
                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}UUID：{/t}</label>
                                    <div class="controls col-lg-6 l_h30">
                                        {$wxapp_info.uuid}<br>
                                        <input type="hidden" name="uuid" value="{$wxapp_info.uuid}"/>
                                    </div>
                                </div>
                                {/if}

                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}小程序名称：{/t}</label>
                                    <div class="controls col-lg-6">
                                        <input class="form-control" type="text" name="name" id="name" value="{$wxapp_info.name}"/>
                                    </div>
                                    <span class="input-must">*</span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}Logo：{/t}</label>
                                    <div class="col-lg-6">
                                        <div class="fileupload fileupload-{if $wxapp_info.logo}exists{else}new{/if}" data-provides="fileupload">
                                            {if $wxapp_info.logo}
                                            <div class="fileupload-{if $wxapp_info.logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                                <img src="{$wxapp_info.logo}" alt='{t domain="weapp"}图片预览{/t}' style="width:50px; height:50px;"/>
                                            </div>
                                            {/if}
                                            <div class="fileupload-preview fileupload-{if $wxapp_info.logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                            <span class="btn btn-primary btn-file btn-sm">
		                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {t domain="weapp"}浏览{/t}</span>
		                                        <span class="fileupload-exists"> {t domain="weapp"}修改{/t}</span>
		                                        <input type="file" class="default" name="platform_logo"/>
		                                    </span>
                                            <a class="btn btn-danger btn-sm fileupload-exists" {if $wxapp_info.logo}data-toggle="ajaxremove" data-msg='{t domain="weapp"}您确定要删除该logo吗？{/t}' {else}data-dismiss="fileupload" {/if} href='{url path="weapp/merchant/remove_logo" args="id={$wxapp_info.id}"}'>{t domain="weapp"}删除{/t}</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}AppID：{/t}</label>
                                    <div class="controls col-lg-6">
                                        <input class="form-control" type="text" name="appid" id="appid" value="{$wxapp_info.appid}"/>
                                    </div>
                                    <span class="input-must">*</span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}AppSecret：{/t}</label>
                                    <div class="controls col-lg-6">
                                        <input class="form-control" type="text" name="appsecret" id="appsecret" value="{$wxapp_info.appsecret}"/>
                                    </div>
                                    <span class="input-must">*</span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}状态：{/t}</label>
                                    <div class="col-lg-6 chk_radio">
                                        <input type="radio" name="status" value="1" {if $wxapp_info.status eq 1}checked{/if} id="radio_1"><label for="radio_1">{t domain="weapp"}开启{/t}</label>
                                        <input type="radio" name="status" value="0" {if $wxapp_info.status eq 0}checked{/if} id="radio_0"><label for="radio_0">{t domain="weapp"}关闭{/t}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">{t domain="weapp"}排序：{/t}</label>
                                    <div class="controls col-lg-6">
                                        <input class="form-control" type="text" name="sort" id="sort" value="{$wxapp_info.sort|default:0}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-6">
                                        {if $wxapp_info.id eq ''}
                                        <input type="submit" name="submit" value='{t domain="weapp"}确定{/t}' class="btn btn-info"/>
                                        {else}
                                        <input type="submit" name="submit" value='{t domain="weapp"}更新{/t}' class="btn btn-info"/>
                                        {/if}
                                        <input name="id" type="hidden" value="{$wxapp_info.id}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
