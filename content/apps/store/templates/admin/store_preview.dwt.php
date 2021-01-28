<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<!-- #BeginLibraryItem "/library/map.lbi" --><!-- #EndLibraryItem -->

<style>
.heading .btn { margin-top:-3px;}
</style>

{if $is_expired eq 1}
<div class="alert alert-danger">
    <a class="close" data-dismiss="alert">×</a>
    <strong>
        <p>{t domain="store"}温馨提示{/t}</p>
    </strong>
    <p>{t domain="store"}当前店铺注销申请到期还未处理，等待您删除店铺数据。{/t}</p>
</div>
{/if}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
		{if $store.status eq 1}<a class="data-pjax btn f_r" href='{RC_Uri::url("store/admin/status","&status=1&store_id={$smarty.get.store_id}")}'><i class="fontello-icon-lock"></i>{t domain="store"}锁定{/t}</a>{/if}
		{if $store.status eq 2}<a class="data-pjax btn f_r" href='{RC_Uri::url("store/admin/status","&status=2&store_id={$smarty.get.store_id}")}'><i class="fontello-icon-lock-open"></i>{t domain="store"}解锁{/t}</a>{/if}
		<!-- {if $action_link_self} -->

		<a class="btn plus_or_reply" target="_blank" id="sticky_a" href="{$action_link_self.href}"><i class="fontello-icon-login"></i>{$action_link_self.text}</a>
		<!-- {/if} -->

        <a class="btn plus_or_reply" id="sticky_a" href="{$duplicate.href}"><i class="fontello-icon-login"></i>{$duplicate.text}</a>

	</h3>
</div>
<div class="row-fluid">
	<div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
	</div>
	<div class="span9">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
	   		<div class="tab-pane active" id="tab1">
            	<div class="foldable-list move-mod-group">
                	<div class="accordion-group">
                    	<div class="accordion-heading accordion-heading-url">
        		          	<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info">
    							<strong>{t domain="store"}店铺信息{/t}</strong>
    						</div>
							<a class="data-pjax accordion-url" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=base")}'>{t domain="store"}编辑{/t}</a>
						</div>
        				<div class="accordion-body in collapse" id="info">
        					<table class="table table-oddtd m_b0">
        						<tbody class="first-td-no-leftbd">
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}店铺名称：{/t}</strong></div></td>
        							<td><strong>{$store.merchants_name}</strong>
        							{if $store.identity_status eq 2}<span class="label label-success m_l10">{t domain="store"}已认证{/t}</span>{else}<span class="label m_l10">{t domain="store"}未认证{/t}</span>{/if}
        							{if $store.shop_close eq 0}<span class="label label-success m_l10">开店</span>
        							{else if $store.shop_close eq 1}<span class="label label-important m_l10">{t domain="store"}店铺关闭{/t}</span>
        							{/if}
        							{if $store.status eq 2}<span class="label label-important m_l10">{t domain="store"}锁定{/t}</span>{/if}</td>
        							<td><div align="right"><strong>{t domain="store"}商家分类：{/t}</strong></div></td>
        							<td>{if $store.cat_name eq ''}{t domain="store"}未分类{/t}{else}{$store.cat_name}{/if}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}店铺关键词：{/t}</strong></div></td>
        							<td colspan="3">{$store.shop_keyword}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}订单结算比例：{/t}</strong></div></td>
        							<td>{if $store.percent_value}{$store.percent_value}%{else}{t domain="store"}未设置，默认{/t}100%{/if}&nbsp;&nbsp;<a href='{RC_Uri::url("store/admin_commission/edit","store_id={$smarty.get.store_id}")}' title='{t domain="store"}编辑{/t}'>{t domain="store"}编辑{/t}</a></td>
                                    <td><div align="right"><strong>{t domain="store"}会员总数：{/t}</strong></div></td>
                                    <td>{$member_count}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}开店时间：{/t}</strong></div></td>
        							<td>{$store.confirm_time}</td>
        							<td><div align="right"><strong>{t domain="store"}到期时间：{/t}</strong></div></td>
        							<td>{$store.expired_time}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}店铺模式：{/t}</strong></div></td>
        							<td>{if $store.manage_mode eq 'join'}{t domain="store"}入驻{/t}{else if $store.manage_mode eq 'self'}{t domain="store"}自营{/t}{/if}</td>
        							<td><div align="right"><strong>{t domain="store"}商品审核：{/t}</strong></div></td>
        							<td>{if $store.shop_review_goods eq 1}{t domain="store"}开启{/t}{else}{t domain="store"}关闭{/t}{/if}</td>
        						</tr>
        						<tr>
        						    <td><div align="right"><strong>{t domain="store"}联系方式：{/t}</strong></div></td>
        							<td>{$store.contact_mobile}</td>
        							<td><div align="right"><strong>{t domain="store"}电子邮箱：{/t}</strong></div></td>
        							<td>{$store.email}</td>
        						</tr>
<!--                                <tr>-->
<!--                                    <td><div align="right"><strong>缴纳入驻金：</strong></div></td>-->
<!--                                    <td>-->
<!--                                        {$store.franchisee_amount}-->
<!--                                    </td>-->
<!--                                    <td><div align="right"><strong>支付方式：</strong></div></td>-->
<!--                                    <td>-->
<!--                                        {$store.pay_name}-->
<!--                                    </td>-->
<!--                                </tr>-->
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}所在地区：{/t}</strong></div></td>
        							<td>{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}&nbsp;{$store.street}</td>
        							<td><div align="right"><strong>{t domain="store"}经纬度：{/t}</strong></div></td>
        							<td>{$store.longitude}&nbsp;&nbsp;{$store.latitude}{if $store.longitude && $store.latitude}&nbsp;&nbsp;
        							<a href="#mapModal" title='{t domain="store"}查看地图{/t}' data-toggle="modal" exname="{$store.merchants_name}" exlng="{$store.longitude}" exlat="{$store.latitude}" data-address="{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}&nbsp;{$store.street}&nbsp;{$store.address}">{t domain="store"}[查看地图]{/t}</a>{/if}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}通讯地址：{/t}</strong></div></td>
        							<td colspan="3">{$store.address}</td>
        						</tr>

                                <tr>
                                    <td><div align="right"><strong>{t domain="store"}删除商家：{/t}</strong></div></td>
                                    <td colspan="3"><a class="btn data-pjax" href="{RC_Uri::url('store/admin/remove_store')}&store_id={$store.store_id}">{t domain="store"}去删除店铺数据{/t}</a></td>
                                </tr>

        						</tbody>
        					</table>
        				</div>
                    </div>

        			<div class="accordion-group">
        				<div class="accordion-heading">
        					<div class="accordion-heading accordion-heading-url">
        						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info2">
        							<strong>{t domain="store"}经营主体信息{/t}</strong>
        						</div>
    							<a class="data-pjax accordion-url m_l10" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=identity")}'>{t domain="store"}编辑{/t}</a>
    						</div>
        				</div>
        				<div class="accordion-body in collapse" id="info2">
        					<table class="table table-oddtd m_b0">
        						<tbody class="first-td-no-leftbd">
        						{if $store.validate_type eq 1}
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}入驻类型：{/t}</strong></div></td>
        							<td>{if $store.validate_type eq 1}{t domain="store"}个人{/t}{else}{t domain="store"}企业{/t}{/if}</td>
        							<td><div align="right"><strong>{t domain="store"}负责人:{/t}</strong></div></td>
        							<td>{$store.responsible_person}</td>
        						</tr>

        						<tr>
        							<td ><div align="right"><strong>{t domain="store"}证件类型：{/t}</strong></div></td>
        							{if $store.identity_type eq 1}
        							<td>{t domain="store"}身份证{/t}</td>
        							{elseif $store.identity_type eq 2}
        							<td>{t domain="store"}护照{/t}</td>
        							{elseif $store.identity_type eq 3}
        							<td>{t domain="store"}港澳身份证{/t}</td>
        							{else}
        							<td></td>
        							{/if}
        							<td><div align="right"><strong>{t domain="store"}证件号码：{/t}</strong></div></td>
        							<td>{$store.identity_number}</td>
        						</tr>
        						{elseif $store.validate_type eq 2}
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}入驻类型：{/t}</strong></div></td>
        							<td>{if $store.validate_type eq 1}{t domain="store"}个人{/t}{else}{t domain="store"}企业{/t}{/if}</td>
        							<td><div align="right"><strong>{t domain="store"}负责人：{/t}</strong></div></td>
        							<td>{$store.responsible_person}</td>
        						</tr>

        						<tr>
        						    <td><div align="right"><strong>{t domain="store"}公司名称：{/t}</strong></div></td>
        							<td>{$store.company_name}</td>
        							<td><div align="right"><strong>{t domain="store"}营业执照注册号：{/t}</strong></div></td>
        							<td >{$store.business_licence}</td>
        						</tr>

        						<tr>
        							<td><div align="right"><strong>{t domain="store"}证件类型：{/t}</strong></div></td>
        							{if $store.identity_type eq 1}
        							<td>{t domain="store"}身份证{/t}</td>
        							{elseif $store.identity_type eq 2}
        							<td>{t domain="store"}护照{/t}</td>
        							{elseif $store.identity_type eq 3}
        							<td>{t domain="store"}港澳身份证{/t}</td>
        							{else}
        							<td></td>
        							{/if}
        							<td><div align="right"><strong>{t domain="store"}证件号码：{/t}</strong></div></td>
        							<td>{$store.identity_number}</td>
        						</tr>
        						{/if}
        						</tbody>
        					</table>
        				</div>
        			</div>

        			<div class="accordion-group">
        				<div class="accordion-heading">
        					<div class="accordion-heading accordion-heading-url">
        						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#merchant_bank">
        							<strong>{t domain="store"}银行账户信息{/t}</strong>
        						</div>
    							<a class="data-pjax accordion-url m_l10" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=bank")}'>{t domain="store"}编辑{/t}</a>
    						</div>
        				</div>

        				<div class="accordion-body in collapse" id="merchant_bank">
        					<table class="table table-oddtd m_b0">
        						<tbody class="first-td-no-leftbd">
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}收款银行：{/t}</strong></div></td>
        							<td>{$store.bank_name}</td>
        							<td><div align="right"><strong>{t domain="store"}开户银行支行名称：{/t}</strong></div></td>
        							<td>{$store.bank_branch_name}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}银行账号：{/t}</strong></div></td>
        							<td>{$store.bank_account_number}</td>
        							<td><div align="right"><strong>{t domain="store"}账户名称：{/t}</strong></div></td>
        							<td>{$store.bank_account_name}</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}户银行支行地址：{/t}</strong></div></td>
        							<td colspan="3">{$store.bank_address}</td>
        						</tr>
        						</tbody>
        					</table>
        				</div>
        			</div>

        			<div class="accordion-group">
        				<div class="accordion-heading">
        					<div class="accordion-heading accordion-heading-url">
        						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#identity_pic">
        							<strong>{t domain="store"}证件电子版{/t}</strong>
        						</div>
    							<a class="data-pjax accordion-url" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=pic")}'>{t domain="store"}编辑{/t}</a>
    						</div>
        				</div>

        				<div class="accordion-body in collapse" id="identity_pic">
        					<table class="table table-oddtd m_b0">
        						<tbody class="first-td-no-leftbd">
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}证件正面：{/t}</strong></div></td>
        							<td>
            							{if $store.identity_pic_front neq ''}
            							<a href="{RC_Upload::upload_url({$store.identity_pic_front})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_front})}"></a>
            							{else}
            							<div class="l_h30">
            								{t domain="store"}还未上传{/t}
            							</div>
            							{/if}
        							</td>
        							<td><div align="right"><strong>{t domain="store"}证件反面：{/t}</strong></div></td>
        							<td>
            							{if $store.identity_pic_back neq ''}
            							<a href="{RC_Upload::upload_url({$store.identity_pic_back})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_back})}"></a>
            							{else}
            							<div class="l_h30">
            								{t domain="store"}还未上传{/t}
            							</div>
            							{/if}
        							</td>
        						</tr>
        						<tr>
        							<td><div align="right"><strong>{t domain="store"}手持证件：{/t}</strong></div></td>
        							<td {if $store.validate_type eq 1} colspan="3"{/if}>
            							{if $store.personhand_identity_pic neq ''}
            							<a href="{RC_Upload::upload_url({$store.personhand_identity_pic})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.personhand_identity_pic})}"></a>
            							{else}
            							<div class="l_h30">
            								{t domain="store"}还未上传{/t}
            							</div>
            							{/if}
        							</td>
        						<!-- {if $store.validate_type eq 1} -->
        						<input type="hidden"  name="identity_type" value="{$store.validate_type}" />
        						<!-- {elseif $store.validate_type eq 2} -->
        							<td><div align="right"><strong>{t domain="store"}营业执照电子版：{/t}</strong></div></td>
        							<td>
            							{if $store.business_licence_pic neq ''}
            							<a href="{RC_Upload::upload_url({$store.business_licence_pic})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.business_licence_pic})}"></a>
            							{else}
            							<div class="l_h30">
            								{t domain="store"}还未上传{/t}
            							</div>
            							{/if}
        							</td>
        						</tr>
        						<!-- {/if} -->
        						</tbody>
        					</table>
        				</div>
        			</div>
                </div>
			</div>
        </form>
	</div>
</div>
<!-- {/block} -->