<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.bind_adviser.init();
</script>
<style>
    .ms-container .select_user li.selected{
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
    .kong
    {
        color: #AAA;
        font-size: 12px;
        line-height: 16px;
        padding: 4px 10px 3px;
		border-bottom:none
    }
	.new_userinfo_wrap{ display:none;}
</style>


<!-- {/block} -->
<!-- {block name="main_content"} -->
<div class="alert alert-info">	
	<strong>提示：未绑定会员账号的客户不能进行其他绑定操作</strong>
</div>
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>
</div>
<div class="row-fluid">
	<form name="queryinfo" action='{url path="customer/admin/query_customer_info"}' method="post">
		<div class="row-fluid">
		  <span class="choose_list"><input type="text" name="keyword_customer" class="ecjiaf-fn w300" placeholder="请输入客户邮箱或者手机号" value="{$adviser.c_email}" /><button class="btn ecjiaf-fn" type="submit">{t}搜索客户{/t}</button></span>
		</div>
		<input type="hidden" name="page" value="{$page}"/>
        <input type="hidden" name="status" value="{$status}"/>
	</form>
</div>
<div class="row-fluid edit-page editpage-rightbar" >
    <div class="span12">
		<div><h3>当前客户：{$adviser.c_name} <span style="font-size:14px; font-weight:normal;color:#666 ">(Email:{if $adviser.c_email neq ''}{$adviser.c_email}{else}{$adviser.email}{/if} 会员ID：{$adviser.user_name})</span></h3></div>
        <form class="form-horizontal" method="post" action="{$form_action}" name="theForm" data-edit-url="{RC_Uri::url('customer/admin/init')}" >
            <fieldset class="">
                <div class="left-bar move-mod ui-sortable" style="width:650px;">
					      <div class="foldable-list move-mod-group">
                            <div class="accordion-body in in_visable collapse" style="padding-top: 8px;">
                                <div class="control-group control-group-small">
								    <label>{t}绑定的营销顾问：{/t}</label>
									<div>
										<span>{if $adviser.ad_id neq ''}{$adviser.ad_name}({$adviser.ad_id}){else}暂无{/if}</span>
									</div>
								</div>
								<!--变更用户-->
								<div class="control-group control-group-small new_userinfo_wrap">
									<label>{t}变更为：{/t}</label>
									<div>
										<span class="new_userinfo"></span>
									</div>
								</div>
								<div class="control-group control-group-small">
									<input type="hidden" name="url" value='{url path="customer/admin/search_adviser"}'/>
									<input type="text" class="w300" name="keywords" value="" placeholder="请输入营销顾问姓名" />
									<button class="btn search_users" type="button">{t}搜索顾问{/t}</button>
								</div>
								<div class="control-group control-group-small">
									<div class="ms-container" style="background: none">
										<div class="search-header">
											<input type="text" autocomplete="off" placeholder="筛选搜索到的顾问信息" id="ms-search" class="span12">
										</div>
										<ul class="ms-list nav-list-ready select_user" id="serarch_user_list" style="border:1px solid #dadada;height:150px; overflow-y: auto;">
												  <li class="ms-elem-selectable kong"><span>暂无内容</span></li>
										</ul>
									</div>
								</div>
                                <div class="control-group control-group-small">
                                    <span class="tips">点击搜索结果选择要绑定的营销顾问</span>
                                    <input type="hidden" name="adviser_id" /><input type="hidden" name="user_id" value="{$user_id}" />
                                    <input type="hidden" name="customer_id" value="{$customer_id}"/>
                                    <input type="hidden" name="page" value="{$page}"/>
                                    <input type="hidden" name="status" value="{$status}"/>
                                </div>
                                <button class="btn btn-gebo"  type="submit">更新</button>
                          </div>
                    </div> 
                </div>
            </fieldset>
        </form>
    </div>
</div>

<!-- {/block} -->
