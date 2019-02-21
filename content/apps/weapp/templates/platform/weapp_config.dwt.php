<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.platform.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

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
            <div class="col-lg-12">
                <form class="form" method="post" name="theForm" action="{$form_action}">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="col-lg-2 label-control text-right">{t domain="weapp"}URL(服务器地址)：{/t}</label>
                                <div class="col-lg-6 controls">
                                    <input class="input-xlarge form-control" id="external_address" type="text" value="{$data.url}" autocomplete="off" readonly/>
                                    <span class="help-block">{t domain="weapp"}必须以http://或https://开头，分别支持80端口和443端口{/t}</span>
                                </div>
                                <a class="btn btn-outline-primary copy-url-btn" href='javascript:;' data-clipboard-action="copy" data-clipboard-target="#external_address" style="height: 40px;margin-right: 15px;">{t domain="weapp"}复制URL{/t}</a>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 label-control text-right">{t domain="weapp"}Token(令牌)：{/t}</label>
                                <div class="col-lg-6 controls">
                                    <input class="input-xlarge form-control" id="token" name="token" type="text" value="{$data.token}" autocomplete="off"/>
                                    <span class="help-block">{t domain="weapp"}必须为英文或数字，长度为3-32字符{/t}</span>
                                </div>
                                <a class="btn btn-outline-primary generate_token" href="javascript:;" data-url='{url path="weapp/platform_config/generate_token"}' style="height: 40px;margin-right: 15px;">{t domain="weapp"}生成Token{/t}</a>
                                <a class="btn btn-outline-primary copy-token-btn" href='javascript:;' data-clipboard-action="copy" data-clipboard-target="#token" style="height: 40px;margin-right: 15px;">{t domain="weapp"}复制Token{/t}</a>
                                <span class="input-must">*</span>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 label-control text-right">EncodingAESKey<br>{t domain="weapp"}(消息加密密钥)：{/t}</label>
                                <div class="col-lg-6 controls">
                                    <input class="input-xlarge form-control" name="aeskey" type="text" value="{$data.aeskey}" autocomplete="off" maxlength="43"/>
                                    <span class="help-block">{t domain="weapp"}消息加密密钥由43位字符组成，字符范围为A-Z,a-z,0-9{/t}</span>
                                </div>
                                <span class="input-must">*</span>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 label-control text-right">{t domain="weapp"}消息加密方式：{/t}</label>
                                <div class="col-lg-6 controls">
                                    <input type="radio" id="encryption_method_0" name="encryption_method" value="0" {if $data.encryption_method eq 0 || !$data.encryption_method}checked{/if}>
                                    <label for="encryption_method_0">{t domain="weapp"}明文模式{/t}<span class="help-block" style="display: inline-block;margin-top: 0;margin-left: 10px;">{t domain="weapp"}(不使用消息体加解密功能，安全系数较低){/t}</span></label><br>
                                    <!-- <input type="radio" id="encryption_method_1" name="encryption_method" value="1" {if $data.encryption_method eq 1}checked{/if}><label for="encryption_method_1">兼容模式<span class="help-block" style="display: inline-block;margin-top: 0;margin-left: 10px;">(明文、密文将共存，方便开发者调试和维护)</span></label><br>
                                    <input type="radio" id="encryption_method_2" name="encryption_method" value="2" {if $data.encryption_method eq 2}checked{/if}><label for="encryption_method_2">安全模式（推荐）<span class="help-block" style="display: inline-block;margin-top: 0;margin-left: 10px;">(消息包为纯密文，需要开发者加密和解密，安全系数高)</span></label>
                                    <span class="help-block">请根据业务需要，选择消息加密方式，启用后将立即生效</span> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 label-control text-right">{t domain="weapp"}数据格式：{/t}</label>
                                <div class="col-lg-6 controls">
                                    <input type="radio" id="data_type_0" name="data_type" value="xml" checked><label for="data_type_0">XML</label>
                                    <span class="help-block">{t domain="weapp"}请选择微信与开发者服务器间传输的数据格式{/t}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <!-- {if $data.token} -->
                        <input class="btn btn-outline-primary" type="submit" value='{t domain="weapp"}更新{/t}'/>
                        <!-- {else} -->
                        <input class="btn btn-outline-primary" type="submit" value='{t domain="weapp"}确定{/t}'/>
                        <!-- {/if} -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->
