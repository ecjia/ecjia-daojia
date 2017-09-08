<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
.heading .btn { margin-top:-3px;}
</style>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
		{if $store.status eq 1}<a class="data-pjax btn f_r" href='{RC_Uri::url("store/admin/status","&status=1&store_id={$smarty.get.store_id}")}'><i class="fontello-icon-lock"></i>锁定</a>{/if}
		{if $store.status eq 2}<a class="data-pjax btn f_r" href='{RC_Uri::url("store/admin/status","&status=2&store_id={$smarty.get.store_id}")}'><i class="fontello-icon-lock-open"></i>解锁</a>{/if}
		<!-- {if $action_link_self} -->
		<a class="btn plus_or_reply" target="_blank" id="sticky_a" href="{$action_link_self.href}"><i class="fontello-icon-login"></i>{$action_link_self.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
		<div class="span12">
			<div class="tabbable tabs-left">
				<ul class="nav nav-tabs tab_merchants_nav">
                    <!-- {foreach from=$menu item=val} -->
                    <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                    <!-- {/foreach} -->
				</ul>

				<div class="tab-content tab_merchants">

					<div class="tab-pane active" id="tab1">
						<div class="foldable-list move-mod-group">
            			<div class="accordion-group">
                			<div class="accordion-heading accordion-heading-url">
        						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info">
        							<strong>店铺信息</strong>
        						</div>
    							<a class="data-pjax accordion-url" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=base")}'>编辑</a>
    						</div>
            				<div class="accordion-body in collapse" id="info">
            					<table class="table table-oddtd m_b0">
            						<tbody class="first-td-no-leftbd">
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.store_title_lable'}</strong></div></td>
            							<td><strong>{$store.merchants_name}</strong>
            							{if $store.identity_status eq 2}<span class="label label-success m_l10">已认证</span>{else}<span class="label m_l10">未认证</span>{/if}
            							{if $store.shop_close eq 0}<span class="label label-success m_l10">开店</span>
            							{else if $store.shop_close eq 1}<span class="label label-important m_l10">店铺关闭</span>
            							{/if}
            							{if $store.status eq 2}<span class="label label-important m_l10">锁定</span>{/if}</td>
            							<td><div align="right"><strong>{lang key='store::store.store_cat_lable'}</strong></div></td>
            							<td>{if $store.cat_name eq ''}未分类{else}{$store.cat_name}{/if}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.store_keywords_lable'}</strong></div></td>
            							<td colspan="3">{$store.shop_keyword}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>分成比例：</strong></div></td>
            							<td colspan="3">{if $store.percent_value}{$store.percent_value}%{else}未设置，默认100%{/if}&nbsp;&nbsp;<a href='{RC_Uri::url("store/admin_commission/edit","store_id={$smarty.get.store_id}")}' title="编辑">编辑</a></td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>开店时间：</strong></div></td>
            							<td>{$store.confirm_time}</td>
            							<td><div align="right"><strong>到期时间：</strong></div></td>
            							<td>{$store.expired_time}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>店铺模式：</strong></div></td>
            							<td>{if $store.manage_mode eq 'join'}入驻{else if $store.manage_mode eq 'self'}自营{/if}</td>
            							<td><div align="right"><strong>商品审核：</strong></div></td>
            							<td>{if $store.shop_review_goods eq 1}开启{else}关闭{/if}</td>
            						</tr>
            						<tr>
            						    <td><div align="right"><strong>{lang key='store::store.contact_lable'}</strong></div></td>
            							<td>{$store.contact_mobile}</td>
            							<td><div align="right"><strong>{lang key='store::store.email_lable'}</strong></div></td>
            							<td>{$store.email}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>所在地区：</strong></div></td>
            							<td>{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}</td>
            							<td><div align="right"><strong>经纬度：</strong></div></td>
            							<td>{$store.longitude}&nbsp;&nbsp;{$store.latitude}{if $store.longitude && $store.latitude}&nbsp;&nbsp;<a href="https://apis.map.qq.com/uri/v1/marker?marker=coord:{$store.latitude},{$store.longitude};title:我的位置;addr:{$store.merchants_name}&referer=ecjiacityo2o" title="查看地图" target="_blank">[查看地图]</a>{/if}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.address_lable'}</strong></div></td>
            							<td colspan="3">{$store.address}</td>
            						</tr>
            						</tbody>
            					</table>
            				</div>
            			</div>

            			<div class="accordion-group">
            				<div class="accordion-heading">
            					<div class="accordion-heading accordion-heading-url">
            						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info2">
            							<strong>经营主体信息</strong>
            						</div>
        							<a class="data-pjax accordion-url m_l10" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=identity")}'>编辑</a>
        						</div>
            				</div>
            				<div class="accordion-body in collapse" id="info2">
            					<table class="table table-oddtd m_b0">
            						<tbody class="first-td-no-leftbd">
            						{if $store.validate_type eq 1}
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.validate_type'}</strong></div></td>
            							<td>{if $store.validate_type eq 1}{lang key='store::store.personal'}{else}{lang key='store::store.company'}{/if}</td>
            							<td><div align="right"><strong>负责人:</strong></div></td>
            							<td>{$store.responsible_person}</td>
            						</tr>

            						<tr>
            							<td ><div align="right"><strong>{lang key='store::store.identity_type_lable'}</strong></div></td>
            							{if $store.identity_type eq 1}
            							<td>{lang key='store::store.people_id'}</td>
            							{elseif $store.identity_type eq 2}
            							<td>{lang key='store::store.passport'}</td>
            							{elseif $store.identity_type eq 3}
            							<td>{lang key='store::store.hong_kong_and_macao_pass'}</td>
            							{else}
            							<td></td>
            							{/if}
            							<td><div align="right"><strong>{lang key='store::store.identity_number_lable'}</strong></div></td>
            							<td>{$store.identity_number}</td>
            						</tr>
            						{elseif $store.validate_type eq 2}
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.validate_type'}</strong></div></td>
            							<td>{if $store.validate_type eq 1}{lang key='store::store.personal'}{else}{lang key='store::store.company'}{/if}</td>
            							<td><div align="right"><strong>{lang key='store::store.person_lable'}</strong></div></td>
            							<td>{$store.responsible_person}</td>
            						</tr>

            						<tr>
            						    <td><div align="right"><strong>{lang key='store::store.companyname_lable'}</strong></div></td>
            							<td>{$store.company_name}</td>
            							<td><div align="right"><strong>{lang key='store::store.business_licence_lable'}</strong></div></td>
            							<td >{$store.business_licence}</td>
            						</tr>

            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.identity_type_lable'}</strong></div></td>
            							{if $store.identity_type eq 1}
            							<td>{lang key='store::store.people_id'}</td>
            							{elseif $store.identity_type eq 2}
            							<td>{lang key='store::store.passport'}</td>
            							{elseif $store.identity_type eq 3}
            							<td>{lang key='store::store.hong_kong_and_macao_pass'}</td>
            							{else}
            							<td></td>
            							{/if}
            							<td><div align="right"><strong>{lang key='store::store.identity_number_lable'}</strong></div></td>
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
            							<strong>银行账户信息</strong>
            						</div>
        							<a class="data-pjax accordion-url m_l10" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=bank")}'>编辑</a>
        						</div>
            				</div>

            				<div class="accordion-body in collapse" id="merchant_bank">
            					<table class="table table-oddtd m_b0">
            						<tbody class="first-td-no-leftbd">
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.bank_name_lable'}</strong></div></td>
            							<td>{$store.bank_name}</td>
            							<td><div align="right"><strong>{lang key='store::store.bank_branch_name_lable'}</strong></div></td>
            							<td>{$store.bank_branch_name}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.bank_account_number_lable'}</strong></div></td>
            							<td>{$store.bank_account_number}</td>
            							<td><div align="right"><strong>{lang key='store::store.bank_account_name_label'}</strong></div></td>
            							<td>{$store.bank_account_name}</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.bank_address_lable'}</strong></div></td>
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
            							<strong>证件电子版</strong>
            						</div>
        							<a class="data-pjax accordion-url" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=pic")}'>编辑</a>
        						</div>
            				</div>

            				<div class="accordion-body in collapse" id="identity_pic">
            					<table class="table table-oddtd m_b0">
            						<tbody class="first-td-no-leftbd">
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.identity_pic_front_lable'}</strong></div></td>
            							<td>
                							{if $store.identity_pic_front neq ''}
                							<a href="{RC_Upload::upload_url({$store.identity_pic_front})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_front})}"></a>
                							{else}
                							<div class="l_h30">
                								{lang key='store::store.no_upload'}
                							</div>
                							{/if}
            							</td>
            							<td><div align="right"><strong>{lang key='store::store.identity_pic_back_lable'}</strong></div></td>
            							<td>
                							{if $store.identity_pic_back neq ''}
                							<a href="{RC_Upload::upload_url({$store.identity_pic_back})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_back})}"></a>
                							{else}
                							<div class="l_h30">
                								{lang key='store::store.no_upload'}
                							</div>
                							{/if}
            							</td>
            						</tr>
            						<tr>
            							<td><div align="right"><strong>{lang key='store::store.personhand_identity_pic_lable'}</strong></div></td>
            							<td {if $store.validate_type eq 1} colspan="3"{/if}>
                							{if $store.personhand_identity_pic neq ''}
                							<a href="{RC_Upload::upload_url({$store.personhand_identity_pic})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.personhand_identity_pic})}"></a>
                							{else}
                							<div class="l_h30">
                								{lang key='store::store.no_upload'}
                							</div>
                							{/if}
            							</td>
            						<!-- {if $store.validate_type eq 1} -->
            						<input type="hidden"  name="identity_type" value="{$store.validate_type}" />
            						<!-- {elseif $store.validate_type eq 2} -->
            							<td><div align="right"><strong>{lang key='store::store.business_licence_pic_lable'}</strong></div></td>
            							<td>
                							{if $store.business_licence_pic neq ''}
                							<a href="{RC_Upload::upload_url({$store.business_licence_pic})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.business_licence_pic})}"></a>
                							{else}
                							<div class="l_h30">
                								{lang key='store::store.no_upload'}
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
				</div>
			</div>
		</div>
	</form>
</div>

<!-- {/block} -->
