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
                                        <label class="control-label col-lg-2">{lang key='favourable::favourable.m_label_act_name'}</label>
                                        <div class="controls col-lg-9">
                                            <input class="form-control" type="text" name="act_name" id="act_name" value="{$favourable.act_name}" size="40" class="w350"  />
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>

                                    <div class="form-group">
                                        <label class=" control-label col-lg-2">{lang key='favourable::favourable.m_farourable_time'}</label>
                                        <div class="col-lg-9">
                                            <div class="controls-split">
                                                <div class="ecjiaf-fl wright_wleft">
                                                    <input name="start_time" class="form-control date w170" type="text" placeholder="{lang key='favourable::favourable.pls_start_time'}" value="{$favourable.start_time}"/>
                                                </div>
                                                <div class="wmiddens ecjiaf-fl p_t5">{lang key='favourable::favourable.to'}</div>
                                                <div class="ecjiaf-fl wright_wleft">
                                                    <input name="end_time" class="form-control date w170" type="text" placeholder="{lang key='favourable::favourable.pls_end_time'}" value="{$favourable.end_time}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{lang key='favourable::favourable.m_label_user_rank'}</label>
                                        <div class="col-lg-9 m_t5">
                                            <!-- {foreach from=$user_rank_list item=user_rank} -->
                                                <input id="user_rank_{$user_rank.rank_id}" type="checkbox" name="user_rank[]" value="{$user_rank.rank_id}" {if $user_rank.checked}checked="true"{/if} />
                                                <label for="user_rank_{$user_rank.rank_id}">{$user_rank.rank_name}</label>
                                            <!-- {/foreach} -->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{lang key='favourable::favourable.label_min_amount'}</label>
                                          <div class="col-lg-9">
                                            <input class="form-control" name="min_amount" type="text" id="min_amount" value="{$favourable.min_amount}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2">{lang key='favourable::favourable.label_max_amount'}</label>
                                          <div class="col-lg-9">
                                            <input class="form-control" name="max_amount" type="text" id="max_amount" value="{$favourable.max_amount}">
                                            <span class="help-block">{lang key='favourable::favourable.notice_max_amount'}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-9">
                                            {if $favourable.act_id eq ''}
                                                <button class="btn btn-info" type="submit">{lang key='system::system.button_submit'}</button>
                                            {else}
                                                <button class="btn btn-info" type="submit">{lang key='favourable::favourable.update'}</button>
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
                                                    {lang key='favourable::favourable.act_range'}
                                                </h4>
                                            </a>
                                        </div>
                                        <div id="telescopic1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="col-lg-8">
                                                        <select class="form-control"  name="act_range" id="act_range_id">
                                                            <option value="0" selected="selected" {if $favourable.act_range eq 0}selected="selected"{/if}>{lang key='favourable::favourable.far_all'}</option>
<!--                                                             <option value="1" {if $favourable.act_range eq 1}selected{/if}>{lang key='favourable::favourable.far_category'}</option> -->
                                                            <option value="3" {if $favourable.act_range eq 3}selected{/if}>{lang key='favourable::favourable.far_goods'}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="range_search" {if $favourable.act_range eq 0} style="display:none"{/if} >
                                                    <div class="col-lg-8">
                                                        <input name="keyword" class="form-control" type="text" id="keyword" placeholder="{lang key='favourable::favourable.keywords'}">
                                                    </div>
                                                    <button class="btn btn-primary" type="button" id="search" data-url='{url path="favourable/merchant/search"}'><i class='fa fa-search'></i> {lang key='system::system.button_search'}</button>
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
                                                        {lang key='favourable::favourable.favourable_way'}
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="telescopic2" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-8">
                                                            <select class="form-control" name="act_type" id="act_type_id" >
<!--                                                                 <option value="0" {if $favourable.act_type eq 0}selected="selected"{/if}>{lang key='favourable::favourable.fat_goods'}</option> -->
                                                                <option value="1" {if $favourable.act_type eq 1}selected="selected"{/if}>{lang key='favourable::favourable.fat_price'}</option>
                                                                <option value="2" {if $favourable.act_type eq 2}selected="selected"{/if}>{lang key='favourable::favourable.fat_discount'}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 p_l0">
                                                            <input class="form-control" name="act_type_ext" type="text" id="act_type_ext" value="{$favourable.act_type_ext}" />
                                                        </div>
                                                    </div>

                                                    <span class="help-block m_l15 m_r15">{lang key='favourable::favourable.notice_act_type'}</span>


                                                    <div class="form-group p_t20" id="type_search"{if $favourable.act_type neq 0} style="display:none"{/if}>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" name="keyword1" type="text" id="keyword1"  placeholder="{lang key='favourable::favourable.enter_keywords'}" />
                                                        </div>
                                                        <button type="button" id="search1" class="btn btn-primary" data-url='{url path="favourable/merchant/search"}'>{lang key='system::system.button_search'}</button>
                                                    </div>
                                                    <div class="form-group choose-list">
                                                        <div id="gift-div" {if $favourable.gift}class="m_b15"{/if}>
                                                            <table id="gift-table" class="m_l15">
                                                                <!-- {if $favourable.gift} -->
                                                                <tr align="center"><td><strong>{lang key='favourable::favourable.gift'}</strong></td><td><strong>{lang key='favourable::favourable.price'}</strong></td></tr>
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