<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.deposit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="commission"}温馨提示{/t}：</strong>{t domain="commission"}线下充值申请：指商家已通过线下实体店或其他渠道支付相应金额后，由管理员提交申请，记录商家线下充值的数据，方便日后商城财务对账。{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
    <div class="span12">

        <form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
            <fieldset>
                <div class="control-group formSep">
                    <label class="control-label">{t domain="commission"}商家手机号：{/t}</label>
                    <div class="controls">
                        <input class="form-control w350" name="store_phone" type="text" placeholder="" value="">
                        <span class="input-must">*</span>
                        <input type="button" class="btn merchant_search" value="搜索" data-url='{url path="commission/admin/search_merchant"}'>
                        <a class="btn btn-info btn-clear" href="javascript:;">清除重新输入</a>
                        <span class="help-block">{t domain="commission"}请输入正确的手机号，查询商家信息{/t}</span>
                    </div>
                </div>

                <div class="store-show ecjiaf-dn">
                <div class="control-group">
                    <label class="control-label">{t domain="commission"}店铺名称：{/t}</label>
                    <div class="controls l_h30">
                        <span class="data-store-name">{t domain="commission"}请先输入手机号搜索{/t}</span>
                    </div>
                </div>
                <div class="control-group formSep">
                    <label class="control-label">{t domain="commission"}店长：{/t}</label>
                    <div class="controls l_h30">
                        <span class="data-staff-name">{t domain="commission"}请先输入手机号搜索{/t}</span>
                        <span class="help-block">{t domain="commission"}仔细查看店铺手机号、名称是否正确，如不正确，请主动调整手机号{/t}</span>
                    </div>
                </div>
                </div>
                <div class="control-group formSep">
                    <label class="control-label">{t domain="commission"}充值金额：{/t}</label>
                    <div class="controls">
                        <input class="form-control w350" name="amount" type="text" placeholder="{t domain="commission"}充值金额必须大于0的整数{/t}" value=""> {t domain="commission"}元{/t}
                        <span class="input-must">*</span>
                    </div>
                </div>
                <div class="control-group formSep">
                    <label class="control-label">{t domain="commission"}支付方式：{/t}</label>
                    <div class="controls l_h30">
                        <span class="">{t domain="commission"}现金{/t}</span>
                    </div>
                </div>

                <div class="control-group formSep">
                    <label class="control-label">{t domain="commission"}操作备注：{/t}</label>
                    <div class="controls">
                        <textarea name="admin_note" class="span7 select-link-content" placeholder='{t domain="commission"}请输入退款备注{/t}'></textarea>
                        <span class="input-must">*</span>
                    </div>
                    <div class="controls">
                        <select class="form-control select-link w400">
                            <option value="">{t domain="commission"}请选择…{/t}</option>
                            <option value="1">{t domain="commission"}管理员手动充值{/t}</option>
                            <option value="2">{t domain="commission"}商家已在线下门店现金支付{/t}</option>
                            <option value="3">{t domain="commission"}通过线下柜台、手机银行或网银将款项转账至商城账号上{/t}</option>
                        </select>
                        <span class="help-block">{t domain="commission"}此备注仅限管理员查看，备注内容可使用快捷用语。{/t}</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="hidden"  name="store_id" value="{$store.store_id}" />
                        <input type="hidden"  name="step" value="{$step}" />
                        <button class="btn btn-gebo" type="submit">{t domain="commission"}确定{/t}</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- {/block} -->