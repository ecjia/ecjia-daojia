<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.bonus_info_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
		{/if}
		</h2>
	</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="form-horizontal tasi-form" id="signupForm" name="typeInfoForm" method="post" action="{$form_action}">
                        <div>
                            <input type="hidden" name="type_id" value="{$bonus_arr.type_id}" />
                            <input type="hidden" name="send_type" id="send_type" value="{$bonus_arr.send_type}" />
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="bonus"}类型名称：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" type='text' name='type_name'  value='{$bonus_arr.type_name}'/>
                            </div>
                            <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="control-label col-lg-2">{t domain="bonus"}红包金额：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" name="type_money" type="text" value="{$bonus_arr.type_money}" />
                            </div>
                            <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                        </div>

                        <div class="form-group ">
                            <label for="firstname" class="control-label col-lg-2">{t domain="bonus"}最小订单金额：{/t}</label>
                            <div class="col-lg-6 controls">
                                <input class="form-control" id="min_goods_amount" name="min_goods_amount" type="text" value="{$bonus_arr.min_goods_amount}"/>
                                <span class="help-block">{t domain="bonus"}只有商品总金额达到这个数的订单才能使用这种红包{/t}</span>
                            </div>
                            <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="control-label col-lg-2">{t domain="bonus"}如何发放此类型红包：{/t}</label>
                            <div class="col-lg-6 chk_radio">
                                <input id="send_type_0" type="radio" name="send_type" value="0" {if $bonus_arr.send_type eq 0} checked="true" {/if} onClick="javascript:ecjia.merchant.bonus_info_edit.type_info_showunit(0)"/>
                                <label for="send_type_0">{t domain="bonus"}按用户发放{/t}</label>

                                <input id="send_type_3" type="radio" name="send_type" value="3" {if $bonus_arr.send_type eq 3} checked="true" {/if} onClick="javascript:ecjia.merchant.bonus_info_edit.type_info_showunit(3)"  />
                                <label for="send_type_3">{t domain="bonus"}注册送红包{/t}</label>

                                <input id="send_type_1" type="radio" name="send_type" value="1" {if $bonus_arr.send_type eq 1} checked="true" {/if} onClick="javascript:ecjia.merchant.bonus_info_edit.type_info_showunit(1)"  />
                                <label for="send_type_1">{t domain="bonus"}按商品发放{/t}</label>

                                <input id="send_type_2" type="radio" name="send_type" value="2" {if $bonus_arr.send_type eq 2} checked="true" {/if} onClick="javascript:ecjia.merchant.bonus_info_edit.type_info_showunit(2)"  />
                                <label for="send_type_2">{t domain="bonus"}按订单金额发放{/t}</label>
                            </div>
                        </div>

                        <div class="form-group" id="min_amount_div" {if $bonus_arr.send_type neq 2} style="display:none" {/if}>
                            <label class="control-label col-lg-2">{t domain="bonus"}订单下限：{/t}</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="min_amount" type="text" id="min_amount" size="20" value='{$bonus_arr.min_amount}' />
                                <span class="help-block">{t domain="bonus"}只要订单金额达到该数值，就会发放红包给用户{/t}</span>
                            </div>
                        </div>

                        <div class="form-group" id="start" {if $bonus_arr.send_type eq 0 || $bonus_arr.send_type eq 3} style="display:none" {/if}>
                            <label class="control-label col-lg-2">{t domain="bonus"}发放起始日期：{/t}</label>
                            <div class="col-lg-6 promote_date">
                                <div class="input-append">
                                    <input class="form-control date" name="send_start_date" type="text" id="send_start_date"  value='{$bonus_arr.send_start_date}'  />
                                </div>
                                <span class="help-block">{t domain="bonus"}只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以发放{/t}</span>
                            </div>
                        </div>

                        <div class="form-group" id="end" {if $bonus_arr.send_type eq 0 || $bonus_arr.send_type eq 3} style="display:none" {/if}>
                            <label class="control-label col-lg-2">{t domain="bonus"}发放结束日期：{/t}</label>
                            <div class="col-lg-6 promote_date">
                                <div class="input-append">
                                    <input class="form-control date" name="send_end_date" type="text"  id="send_end_date"   value='{$bonus_arr.send_end_date}'  />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="bonus"}使用起始日期：{/t}</label>
                            <div class="col-lg-6 promote_date">
                                <div class="input-append">
                                    <input class="form-control date" name="use_start_date" type="text" id="use_start_date"  value='{$bonus_arr.use_start_date}'  />
                                </div>
                                <span class="help-block" >{t domain="bonus"}只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以使用{/t}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="bonus"}使用结束日期：{/t}</label>
                            <div class="col-lg-6 promote_date">
                                <div class="input-append">
                                    <input class="form-control date" name="use_end_date" type="text" id="use_end_date"  value='{$bonus_arr.use_end_date}' />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-6">
                                {if $bonus_arr.type_id eq ''}
                                    <button class="btn btn-info" type="submit">{t domain="bonus"}确定{/t}</button>
                                {else}
                                    <button class="btn btn-info" type="submit">{t domain="bonus"}更新{/t}</button>
                                {/if}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->