<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.customer.init();
</script>
<style>
    .ms-container .select_user li.selected{
        background-color: #48A6D2 !important;
        color: #fff;
    }
    .ms-container .select_adviser li.selected{
        background-color: #48A6D2 !important;
        color: #fff;
    }
    .tips
    {
        padding-left: 10px;
        color: #999;
    }
    .ms-elem-selectable
    {
        padding-left: 5px;
        border-bottom:1px solid #f2f2f2;
    }
 	.ms-elem-selectables
    {
        padding-left: 5px;
        border-bottom:1px solid #f2f2f2;
    }
    .kong
    {
        color: #AAA;
        font-size: 12px;
        line-height: 16px;
        padding: 4px 10px 3px;
		border-bottom:none
    }
   .zanwu
    {
        color: #AAA;
        font-size: 12px;
        line-height: 16px;
        padding: 4px 10px 3px;
		border-bottom:none;
    }
	.new_userinfo_wrap , .new_adviserinfo_wrap{ display:none;}
    .color999 { color:#999; cursor: not-allowed}
</style>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div class="alert alert-info">	
	<strong>提示：未绑定会员账号的客户不能进行其他关联操作</strong>
</div>
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>
</div>
<div class="row-fluid edit-page editpage-rightbar" >
    <div class="span12">
        <form class="form-horizontal" method="post" action="{$form_action}" name="theForm"  data-edit-url="{RC_Uri::url('customer/admin/edit&status')}" >
            <fieldset class="">
                <div class="left-bar move-mod ui-sortable">
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}客户名称：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="customer_name" value="{$customer_info.customer_name}" />
                            <!-- {if $is_open.customer_name eq 1} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div> 
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}主联系人：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="link_man" value="{$customer_info.link_man}" />
                        </div>
                    </div>
                    <div class="control-group control-group-small">
                        <label class="control-label">{t}性别：{/t}</label>
                        <div class="controls chk_radio">
                                    <input type="radio" name="sex" value="0" {if $customer_info.sex eq 0} checked="true" {/if} style="opacity: 0;">
                            <span>男</span>
                                    <input type="radio" name="sex"  value="1" {if $customer_info.sex eq 1} checked="true" {/if}  style="opacity: 0;">
                            <span>女</span>
                        </div>
                    </div>

                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}固定电话：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="telphone1" value="{$customer_info.telphone1}" />
							<!-- {if $is_open.telphone1 eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                     <div class="control-group control-group-small" >
                        <label class="control-label">{t}办公电话：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="telphone2" value="{$customer_info.telphone2}" />
							<!-- {if $is_open.telphone2 eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}手机：{/t}</label>
                        <div class="controls">
                            <input type="text" id="input_1" class="span8" name="mobile" value="{$customer_info.mobile}" />
                            <!-- {if $is_open.mobile eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}邮箱：{/t}</label>
                        <div class="controls">
                            <input type="text" id="input_2" class="span8" name="email" value="{$customer_info.email}" />
                            <!-- {if $is_open.email eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}QQ：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="qq" value="{$customer_info.qq}" />
							<!-- {if $is_open.qq eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                     <div class="control-group control-group-small" >
                        <label class="control-label">{t}微信：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="wechat" value="{$customer_info.wechat}" />
							<!-- {if $is_open.wechat eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}网址：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="web_site" value="{if $customer_info.url !=''}{$customer_info.url}{/if}" />
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}传真：{/t}</label>
                        <div class="controls">
                            <input type="text" name="fax" class="span8"  value="{$customer_info.fax|escape}"/>
                            <!-- {if $is_open.fax eq '1'} --><span class="input-must">*</span><!-- {/if} -->
                        </div>
                    </div>
                    <input type="hidden" name='user_id' value="{$customer_info.user_id}">
                    <!--省市联动-->
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}公司地址：{/t}</label>
                        <div class="controls">

                            <select style="width: 100px;" name="country" data-toggle="regionSummary" data-url='{url path="customer/region/init"}' data-type="1" data-target="region-summary-provinces" >
                                <!--<option value="0">{$lang.select_please}</option>-->
                                <option value="0">请选择</option>
                                <!-- {foreach from=$country_list item=country} -->
                                <option value="{$country.region_id}"{if $proxy_info.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select style="width: 100px;" class="region-summary-provinces" name="province" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
                                <option value="0">{t}请选择{/t}</option>
                                <!--{foreach from=$province_list item=province} -->
                                <option value="{$province.region_id}" {if $proxy_info.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select style="width: 100px;" class="region-summary-cities" name="city" data-toggle="regionSummary" data-type="3" data-target="region-summary-districts" >
                                <option value="0">{t}请选择{/t}</option>
                                <!-- {foreach from=$city_list item=city} -->
                                <option value="{$city.region_id}" {if $proxy_info.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select style="width: 100px;" class="region-summary-districts" name="district">
                                <option value="0">{t}请选择{/t}</option>
                                <!-- {foreach from=$district_list item=district} -->
                                <option value="{$district.region_id}" {if $proxy_info.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
                                <!-- {/foreach} -->
                            </select>				      

                        </div>
                    </div>

                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}详细地址：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="address" value="{$customer_info.address}" />

                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}备注：{/t}</label>
                        <div class="controls">
                            <textarea class="span8" rows="3" cols="40" name="summary" style="height:120px">{$customer_info.summary}</textarea>
                        </div>
                    </div>
                     <div class="control-group control-group-small" >
                  
					   <div class="controls">
							<input type="hidden" name="id" value="{$customer_info.customer_id}" />
							<input type="hidden" name="statu" value="{$status}" />
							<input type="hidden" name="menu" value="{$menu}" />
							<button class="btn btn-gebo"  type="submit">{if $id !=''}更新{else}发布{/if}</button>
					   </div>
                       
                    </div>
                </div>

                <div class="right-bar move-mod ui-sortable">
                	 <!-- 其他信息start -->
                       <div class="foldable-list move-mod-group">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle move-mod-head acc-in" data-toggle="collapse" data-target="#other_info">
                                    <strong>{t}其他信息{/t}</strong>
                                </a>
                            </div>
                            <div id="other_info" class="accordion-body in in_visable collapse">
                                <div class="accordion-inner">
	                                <div class="control-group control-group-small" >
										<label class="control-label">{t}客户来源：{/t}</label>
										<div class="control">
											<select class="span8" name="customer_source">
								                <option value="">请选择...</option>
								                <!-- {foreach from=$source_list item=source } -->
												<option value="{$source.source_id}" {if $source.is_lock eq '1' }selected{elseif $source.source_id == $customer_info.source_id}selected{/if}>{$source.source_name}</option>
												<!-- {/foreach} -->
											</select>
										</div>
									</div> 			  
									<div class="control-group control-group-small" >
										<label class="control-label">{t}客户类别：{/t}</label>
										<div class="control">
											<select class="span8" name="customer_type">
								                <option value="">请选择...</option>
								                <!-- {foreach from=$customer_type_list item=state } -->
												<option value="{$state.state_id}" {if  $state.is_lock eq '1'}selected{elseif $state.state_id == $customer_info.state_id}selected {/if}>{$state.state_name}</option>
												<!-- {/foreach} -->
											</select>
										</div>
									</div>
									<div class="control-group control-group-small" >
										<label class="control-label">{t}所属行业：{/t}</label>
										<div class="control">
											<input type="text" name="industry" class="span8"  value="{$customer_info.industry|escape}"/>
										</div>
									</div>
									<div class="control-group control-group-small" >
										<label class="control-label">{t}合同始日：{/t}</label>
										<div class="control">
											<input type="text" name="contract_start" class="span8 date"  value="{$customer_info.contract_start|escape}"/>
										</div>
									</div>
									<div class="control-group control-group-small" >
										<label class="control-label">{t}合同终日：{/t}</label>
										<div class="control">
											<input type="text" name="contract_end" class="span8 date"  value="{$customer_info.contract_end|escape}"/>
										</div>
									</div>
									<div class="control-group control-group-small" >
										<label class="control-label">{t}当前职位：{/t}</label>
										<div class="control">
											<input type="text" name="position" class="span8"  value="{$customer_info.position|escape}"/>
										</div>
									</div>
									<div class="control-group control-group-small" >
										<label class="control-label">{t}出生日期：{/t}</label>
												
											<div class="control">
												<input type="text" name="birthday" class="span4 date" style="float:left;"  value="{$customer_info.birthday|escape}"/>
												<label for="gongli" class="control-label" style="width:60px">
													<input type="radio" id="gongli" name="birth_type" value="0" {if $customer_info.birth_type eq 0} checked="true" {/if} style="opacity: 0;">{t}公历{/t}
												</label>
												<label for="yingli" class="control-label" style="width:55px">
													<input type="radio" id="yingli" name="birth_type"  value="1" {if $customer_info.birth_type eq 1} checked="true" {/if}  style="opacity: 0;">{t}农历{/t}
												</label>
											</div>
									</div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <!-- 其他信息end -->
                    <!-- 关联用户start -->
                     <div class="foldable-list move-mod-group">
                         <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle move-mod-head acc-in" data-toggle="collapse" data-target="#search">
                                    <strong>{t}关联用户{/t}</strong>
                                </a>
                            </div>
                            <div id="search" class="accordion-body in in_visable collapse">
                                <div class="accordion-inner">
                                    <div class="control-group control-group-small">
										<label>{t}绑定用户：{/t}</label>
										<div>
											{if $id !=''}
											<span>{if $customer_info.user_id neq 0}{$customer_info.user_name}({$customer_info.user_id}) {else}无{/if}</span>
											{else}
											<span class="new_userinfo">{if $customer_info.user_id neq 0}{$customer_info.user_name}({$customer_info.user_id}) {else}无{/if}</span>
											{/if}
										</div>
									</div>
									{if $id !=''}
									<!--变更用户-->
									<div class="control-group control-group-small new_userinfo_wrap">
										<label>{t}变更为：{/t}</label>
										<div>
											<span class="new_userinfo"></span>
										</div>
									</div>
									{/if}
									<div class="control-group control-group-small">
										<input type="hidden" name="url" value='{url path="customer/admin/search_users"}'/>
										<input type="text" class="w140" name="keyword" value="" placeholder="请输入用户名" />
										<button class="btn search_users" type="button">{t}搜索用户{/t}</button>
									</div>
					
									<div class="control-group control-group-small">
										<!--<label>筛选搜索到的用户信息：</label>-->
										<div class="ms-container" style="background: none">
											<div class="search-header">
												<input type="text" autocomplete="off" placeholder="筛选搜索到的用户信息" id="ms-search" class="span12">
											</div>
											<ul class="ms-list nav-list-ready select_user" id="serarch_user_list" style="border:1px solid #dadada;height:114px; overflow-y: auto;">
												  <li class="ms-elem-selectable kong"><span>暂无内容</span></li>
											</ul>
										</div>
									</div>
                                    <div class="control-group control-group-small">
                                        <span class="tips">点击搜索结果绑定填充用户信息</span>
                                    </div>
                              </div>
                          </div>
                      </div>
                </div>
                <!-- 关联用户end -->
                <!-- 关联营销顾问start -->
                       <div class="foldable-list move-mod-group">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle move-mod-head" data-toggle="collapse" data-target="#search_adviser">
                                    <strong>{t}关联营销顾问{/t}</strong>
                                </a>
                            </div>
                            <div id="search_adviser" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <div class="control-group control-group-small">
										<label>{t}绑定顾问：{/t}</label>
										<div>
											{if $id !=''}
											<span>{if $customer_info.adviser_id neq 0}{$customer_info.username}({$customer_info.adviser_id}) {else}无{/if}</span>
											{else}
											<span class="new_adviserinfo">{if $customer_info.adviser_id neq 0}{$customer_info.username}({$customer_info.adviser_id}) {else}无{/if}</span>
											{/if}
										</div>
									</div>
									{if $id !=''}
									<!--变更顾问-->
									<div class="control-group control-group-small new_adviserinfo_wrap">
										<label>{t}变更为：{/t}</label>
										<div>
											<span class="new_adviserinfo"></span>
										</div>
									</div>
									{/if}
									<div class="adviser_display" {if $customer_info.adviser_id neq 0}style="display:none"{/if}>
									<div class="control-group control-group-small">
										<input type="hidden" name="urls" value='{url path="customer/admin/search_adviser"}'/>
										<input type="text" class="w140" name="keywords" value="" placeholder="请输入顾问名"/>
										<button class="btn search_advisers" type="button">{t}搜索顾问{/t}</button>
									</div>
									<div class="control-group control-group-small">
										<div class="ms-container" style="background: none">
											<div class="search-header">
												<input type="text" autocomplete="off" placeholder="筛选搜索到的顾问信息" id="ms-search_adviser" class="span12">
											</div>
											<ul class="ms-list nav-list-readys select_adviser" id="serarch_adviser_list" style="border:1px solid #dadada;height:114px; overflow-y: auto;">
												<li class="ms-elem-selectables zanwu"><span>暂无内容</span></li>
											</ul>
										</div>
									</div>
                                    <div class="control-group control-group-small">
                                        <span class="tips">点击搜索结果选择要绑定的营销顾问</span>
                                        <input type="hidden" name="adviser_id" />
                                    </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 关联营销顾问end -->
			</div>
            </fieldset>
        </form>
    </div>
</div>

<!-- {/block} -->
