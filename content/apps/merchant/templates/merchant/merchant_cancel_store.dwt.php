<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.merchant_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
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
        <section class="panel">
            <div class="panel-body">
                <ul id="validate_wizard-titles" class="stepy-titles clearfix">
                    <li id="step1" class="{if $step gt 0}current-step{/if}">
                        <div>
                            {t domain="merchant"}申请注销{/t}
                        </div>
                        <span class="m_t5">{t domain="merchant"}确保必须满足以下条件{/t}</span><span class="stepNb">1</span>
                    </li>
                    <li id="step2" class="{if $step gt 1}current-step{/if}">
                        <div>
                            {t domain="merchant"}验证手机号{/t}
                        </div>
                        <span class="m_t5">{t domain="merchant"}验证店铺已绑定的手机号码{/t}</span><span class="stepNb">2</span>
                    </li>
                    <li id="step3" class="{if $step gt 2}current-step{/if}">
                        <div>
                            {t domain="merchant"}提交成功{/t}
                        </div>
                        <span class="m_t5">{t domain="merchant"}申请已提交，默认30日等待期{/t}</span><span class="stepNb">3</span>
                    </li>
                </ul>
            </div>

            <!-- {if $step eq 1} -->
            <div class="panel-body">
                <form class="form-horizontal">

                    <div class="merchant-main-info">
                        <div class="left"><img src="{$store_info.shop_logo}"></div>
                        <div class="right">
                            <p>
                                <span class="bold">{$store_info.merchants_name}</span>
                                {if $store_info.shop_closed eq 1 || $data.shop_close eq 1}
                                <span class="closed">{t domain="merchant"}休息中{/t}</span>
                                {else}
                                <span class="unclose">{t domain="merchant"}营业中{/t}</span>
                                {/if}
                            </p>
                            <p>{t domain="merchant"}负责人：{/t}{$store_info.responsible_person} {if $store_info.contact_mobile}&nbsp;({$store_info.contact_mobile}){/if}</p>
                            <p>{t domain="merchant"}开店时间：{/t}{$store_info.confirm_time}</p>
                            {if $diff}
                            <p>{t domain="merchant"}开店时长：{/t}{$diff}</p>
                            {/if}
                        </div>
                        <a class="link" target="_blank" href="{RC_Uri::url('merchant/mh_franchisee/init')}">{t domain="merchant"}店铺详细信息 >>{/t}</a>
                    </div>
                </form>
            </div>
            <!-- {/if} -->

            <!-- {if $step eq 1} -->
            <div class="panel-body">
                <div class="merchant-cancel-notice">
                    <div class="header">{t domain="merchant"}注销之前，请先确认以下信息，以保证您的账号、财产安全：{/t}</div>
                    <div class="notice-item">
                        <div class="left">{t domain="merchant"}1、{/t}</div>
                        {t domain="merchant"}确保店铺内所有商品已全部删除，避免出现新的交易；{/t}
                    </div>
                    <div class="notice-item">
                        <div class="left">{t domain="merchant"}2、{/t}</div>
                        {t domain="merchant"}确保没有进行中的交易，且最后一笔订单完成时间大于15天，若有，建议等待交易完成后再注销；{/t}
                    </div>
                    <div class="notice-item">
                        <div class="left">{t domain="merchant"}3、{/t}</div>
                        {t domain="merchant"}确保没有进行中的退货退款订单，若有，建议等待售后完成后再注销；{/t}
                    </div>
                    <div class="notice-item">
                        <div class="left">{t domain="merchant"}4、{/t}</div>
                        {t domain="merchant"}店铺没有被处罚或违规过记录，包括被举报、被投诉等，若有，则无法注销；{/t}
                    </div>
                    <div class="notice-item">
                        <div class="left">{t domain="merchant"}5、{/t}</div>
                        {t domain="merchant"}确保店铺内所有资金已全部提取出，方可申请注销；{/t}
                    </div>
                    <div class="notice-item">
                        <div class="left">{t domain="merchant"}6、{/t}</div>
                        <div class="right">{t domain="merchant"}为了账户安全，申请提交后，我们将会给您30日的“后悔期”，即先将您的店铺锁定30日，30日后，如您未提出异议或未重新“激活账号”，我们将注销您的店铺及账号，一旦被注销将不可恢复；{/t}</div>
                    </div>
                    <div class="notice-item">
                        <input id="agree" type="checkbox" name="agree" value="1" data-msg='{t domain="merchant"}请先阅读并同意《店铺注销须知》{/t}'>
                        <label for="agree">{t domain="merchant"}已阅读并同意{/t}</label><a class="cancel_notice_link" data-toggle="modal" href="#cancel_model">{t domain="merchant"}《店铺注销须知》{/t}</a>
                    </div>
                    <div class="form-group">
                        <input class="m_l20 btn btn-info cancel_store_btn" type="button" name="name" value='{t domain="merchant"}注销{/t}'
                               data-msg='{t domain="merchant"}您确定要注销当前店铺吗？{/t}' data-url="{RC_Uri::url('merchant/merchant/cancel_store_confirm')}">
                    </div>
                </div>
            </div>

            <!-- {else if $step eq 2} -->
            <div class="merchant-cancel-two">
                <form class="form-horizontal" name="cancelForm" action="{RC_Uri::url('merchant/merchant/check_cancel_sms')}" method="post">
                    <div class="header-step-two">{t domain="merchant"}请使用店铺已绑定的手机号获取短信验证码{/t}</div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="merchant"}手机号码：{/t}</label>
                        <div class="controls col-lg-6">
                            <input class="form-control" name="mobile" id="mobile" placeholder='{t domain="merchant"}请输入手机号码{/t}' type="text" value="{$store_info.contact_mobile}" readonly/>
                        </div>
                        <a class="btn btn-primary" data-url="{url path='merchant/merchant/get_code_value'}&type=cancel_store" id="get_code">{t domain="merchant"}获取验证码{/t}</a>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="merchant"}短信验证码：{/t}</label>
                        <div class="col-lg-6">
                            <input class="form-control" name="code" placeholder='{t domain="merchant"}请输入验证码{/t}' type="text"/>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-lg-6 col-md-offset-2">
                            <input type="hidden" name="type" value="cancel_store"/>
                            <input class="btn btn-info" type="submit" value='{t domain="merchant"}确认{/t}'>
                        </div>
                    </div>
                </form>
            </div>
            <!-- {else if $step eq 3} -->

            <div class="merchant-cancel-three">
                {if $wait_delete eq 1}
                <div><img src="{$cancel_png}" alt=""></div>
                <p class="bold">{t domain="merchant"}已提交注销！{/t}</p>
                <p class="time lefttime" data-time="{$store_info.delete_time}">
                    {t domain="merchant"}倒计时：{/t}
                    <span class="days"></span>{t domain="merchant"}天{/t}
                    <span class="hours"></span>{t domain="merchant"}时{/t}
                    <span class="minutes"></span>{t domain="merchant"}分{/t}
                    <span class="seconds"></span>{t domain="merchant"}秒{/t}
                </p>
                <div class="notice">
                    {t domain="merchant"}为了您的账户安全，我们将会给您30日的“后悔期”，即先将您的店铺锁定30日，30日后，
                    如您未提出异议或未重新点击下方按钮“激活账号”，我们将注销您的店铺及账户，账户一旦
                    被注销将不可恢复。{/t}
                </div>
                <div>
                    <a class="btn btn-info active_store_btn" data-url="{RC_Uri::url('merchant/merchant/active_store')}" data-msg='{t domain="merchant"}您确定要激活当前店铺吗？{/t}'>{t domain="merchant"}激活店铺{/t}</a>
                </div>
                {else}
                <div class="merchant-cancel-active"><img src="{$cancel_png}" alt=""></div>
                <p class="bold">{t domain="merchant"}已成功激活！可继续使用您的店铺{/t}</p>
                <div>
                    <a class="btn btn-info" href="{RC_Uri::url('merchant/dashboard/init')}">{t domain="merchant"}完成{/t}</a>
                </div>
                {/if}
            </div>
            <!-- {/if} -->

        </section>
    </div>
</div>


<div id="cancel_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">{$article_detail.title}</h4>
            </div>
            <div class="modal-body">{$article_detail.content}</div>
        </div>
    </div>
</div>


<div id="check_active_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">验证手机号</h4>
            </div>
            <div class="modal-body">
                <div class="merchant-cancel-two">
                    <form class="form-horizontal" name="theForm" action="{RC_Uri::url('merchant/merchant/check_cancel_sms')}" method="post">
                        <div class="header-step-two">{t domain="merchant"}请使用店铺已绑定的手机号获取短信验证码{/t}</div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}手机号码：{/t}</label>
                            <div class="controls col-lg-6">
                                <input class="form-control" name="mobile" id="mobile" placeholder='{t domain="merchant"}请输入手机号码{/t}' type="text" value="{$store_info.contact_mobile}" readonly/>
                            </div>
                            <a class="btn btn-primary" data-url="{url path='merchant/merchant/get_code_value'}&type=active_store" id="get_code">{t domain="merchant"}获取验证码{/t}</a>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}短信验证码：{/t}</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="code" placeholder='{t domain="merchant"}请输入验证码{/t}' type="text"/>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-6 col-md-offset-2">
                                <input type="hidden" name="type" value="active_store"/>
                                <input class="btn btn-info" type="submit" value='{t domain="merchant"}确认{/t}'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- {/block} -->
