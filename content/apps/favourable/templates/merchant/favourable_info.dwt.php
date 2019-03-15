<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.favourable_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<style>
{literal}
.wmiddens {text-align: center;width: 10%;}
.panel-primary .panel-title{color: #fff;}
#gift-div .form-control{display: inline-block;}
ul,ol{padding:0;}
#range-div{margin-top:0;}
table{border-collapse: separate; border-spacing: 0 3px;}
{/literal}
</style>
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
        {/if}
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                    <div class="form">
                        <form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" data-edit-url="{url path='user/admin/edit'}" >
                            <div class="col-lg-7" style="padding-left:0px;">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{t domain="favourable"}活动名称：{/t}</label>
                                        <div class="controls col-lg-9">
                                            <input class="form-control" type="text" name="act_name" id="act_name" value="{$favourable.act_name}" size="40" class="w350"  />
                                        </div>
                                        <span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                                    </div>

                                    <div class="form-group">
                                        <label class=" control-label col-lg-2">{t domain="favourable"}活动时间：{/t}</label>
                                        <div class="col-lg-9">
                                            <div class="controls-split">
                                                <div class="ecjiaf-fl wright_wleft">
                                                    <input name="start_time" class="form-control date w170" type="text" placeholder='{t domain="favourable"}请选择活动开始时间{/t}' value="{$favourable.start_time}"/>
                                                </div>
                                                <div class="wmiddens ecjiaf-fl p_t5">{t domain="favourable"}至{/t}</div>
                                                <div class="ecjiaf-fl wright_wleft">
                                                    <input name="end_time" class="form-control date w170" type="text" placeholder="{t domain="favourable"}请选择活动结束时间{/t}" value="{$favourable.end_time}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{t domain="favourable"}会员等级：{/t}</label>
                                        <div class="col-lg-9 m_t5">
                                            <!-- {foreach from=$user_rank_list item=user_rank} -->
                                                <input id="user_rank_{$user_rank.rank_id}" type="checkbox" name="user_rank[]" value="{$user_rank.rank_id}" {if $user_rank.checked}checked="true"{/if} />
                                                <label for="user_rank_{$user_rank.rank_id}">{$user_rank.rank_name}</label>
                                            <!-- {/foreach} -->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{t domain="favourable"}金额下限：{/t}</label>
                                          <div class="col-lg-9">
                                            <input class="form-control" name="min_amount" type="text" id="min_amount" value="{$favourable.min_amount}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{t domain="favourable"}金额上限：{/t}</label>
                                          <div class="col-lg-9">
                                            <input class="form-control" name="max_amount" type="text" id="max_amount" value="{$favourable.max_amount}">
                                            <span class="help-block">{t domain="favourable"}0表示没有上限{/t}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-9">
                                            {if $favourable.act_id eq ''}
                                                <button class="btn btn-info" type="submit">{t domain="favourable"}确定{/t}</button>
                                            {else}
                                                <button class="btn btn-info" type="submit">{t domain="favourable"}更新{/t}</button>
                                            {/if}
                                            <input type="hidden" name="act" value="{$form_action}" />
                                            <input type="hidden" name="act_id" id="isok" value="{$favourable.act_id}" />
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-lg-5">
                                <fieldset>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#telescopic1" class="accordion-toggle">
                                            	<span class="glyphicon"></span>
                                                <h4 class="panel-title">
                                                    {t domain="favourable"}优惠活动范围{/t}
                                                </h4>
                                            </a>
                                        </div>
                                        <div id="telescopic1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="col-lg-8">
                                                        <select class="form-control"  name="act_range" id="act_range_id">
                                                            <option value="0" selected="selected" {if $favourable.act_range eq 0}selected="selected"{/if}>{t domain="favourable"}全部商品{/t}</option>
<!--                                                             <option value="1" {if $favourable.act_range eq 1}selected{/if}>{lang key='favourable::favourable.far_category'}</option> -->
                                                            <option value="3" {if $favourable.act_range eq 3}selected{/if}>{t domain="favourable"}以下商品{/t}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="range_search" {if $favourable.act_range eq 0} style="display:none"{/if} >
                                                    <div class="col-lg-8">
                                                        <input name="keyword" class="form-control" type="text" id="keyword" placeholder='{t domain="favourable"}输入关键字进行搜索{/t}'>
                                                    </div>
                                                    <button class="btn btn-primary" type="button" id="search" data-url='{url path="favourable/merchant/search"}'><i class='fa fa-search'></i> {t domain="favourable"}搜索{/t}</button>
                                                </div>

                                                <ul id="range-div" {if $act_range_ext}style="display:block;"{/if}>
                                                    <!-- {foreach from=$act_range_ext item=item} -->
                                                    <li>
                                                        <input name="act_range_ext[]" type="hidden" value="{$item.id}"  />
                                                        {$item.name}
                                                        <a href="javascript:;" class="delact1"><i class="fa fa-minus-circle ecjiafc-red"></i></a>
                                                    </li>
                                                    <!-- {/foreach} -->
                                                </ul>

                                                <div class="form-group" id="selectbig1" style="display:none">
                                                    <div class="col-lg-10">
                                                        <select name="result" id="result" class="noselect form-control" size="10">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#telescopic2" class="accordion-toggle">
                                                    <span class="glyphicon"></span>
                                                    <h4 class="panel-title">
                                                        {t domain="favourable"}优惠活动方式是 {/t}
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="telescopic2" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-8">
                                                            <select class="form-control" name="act_type" id="act_type_id" >
<!--                                                                 <option value="0" {if $favourable.act_type eq 0}selected="selected"{/if}>{lang key='favourable::favourable.fat_goods'}</option> -->
                                                                <option value="1" {if $favourable.act_type eq 1}selected="selected"{/if}>{t domain="favourable"}享受现金减免{/t}</option>
                                                                <option value="2" {if $favourable.act_type eq 2}selected="selected"{/if}>{t domain="favourable"}享受价格折扣{/t}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 p_l0">
                                                            <input class="form-control" name="act_type_ext" type="text" id="act_type_ext" value="{$favourable.act_type_ext}" />
                                                        </div>
                                                    </div>

                                                    <span class="help-block m_l15 m_r15">{t domain="favourable"}当优惠方式为“享受赠品（特惠品）”时，请输入允许买家选择赠品（特惠品）的最大数量，数量为0表示不限数量；当优惠方式为“享受现金减免”时，请输入现金减免的金额；当优惠方式为“享受价格折扣”时，请输入折扣（1－99），如：打9折，就输入90。{/t}</span>


                                                    <div class="form-group p_t20" id="type_search"{if $favourable.act_type neq 0} style="display:none"{/if}>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" name="keyword1" type="text" id="keyword1"  placeholder='{t domain="favourable"}输入特惠品关键字进行搜索{/t}' />
                                                        </div>
                                                        <button type="button" id="search1" class="btn btn-primary" data-url='{url path="favourable/merchant/search"}'>{t domain="favourable"}搜索{/t}</button>
                                                    </div>
                                                    <div class="form-group choose-list">
                                                        <div id="gift-div" {if $favourable.gift}class="m_b15"{/if}>
                                                            <table id="gift-table" class="m_l15">
                                                                <!-- {if $favourable.gift} -->
                                                                <tr align="center"><td><strong>{t domain="favourable"}赠品（特惠品）{/t}</strong></td><td><strong>{t domain="favourable"}价格{/t}</strong></td></tr>
                                                                <!-- {foreach from=$favourable.gift item=goods key=key} -->
                                                                <tr class="m_t5" align="center">
                                                                    <td class="w100">
                                                                        <input type="hidden" name="gift_id[{$key}]" value="{$goods.id}" />{$goods.name}
                                                                    </td>
                                                                    <td>
                                                                        <input name="gift_price[{$key}]" type="text"  value="{$goods.price}" size="10" class="w180 form-control" />
                                                                        <input name="gift_name[{$key}]"  type="hidden" value="{$goods.name}" />
                                                                        <a href="javascript:;" class="delact "><i class="fa fa-minus-circle ecjiafc-red m_l15"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <!-- {/foreach} -->
                                                                <!-- {/if} -->
                                                            </table>
                                                        </div>
                                                        <div class="col-lg-12" id="selectbig" style="display:none">
                                                            <select name="result1" id="result1" class="form-control noselect" size="10">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->