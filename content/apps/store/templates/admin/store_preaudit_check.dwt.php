<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
.table thead th { background-color:#F5F5F5}
.high_light { padding: 3px;border-radius: 4px;display:inline-block;}
.h_success { background-color:#aedb97;border-color:#aedb97;margin-top:3px;}
.h_info { background-color:#fffad7;border-color:#fffad7;}

</style>

<!-- #BeginLibraryItem "/library/map.lbi" --><!-- #EndLibraryItem -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
	    <div class="row-fluid m_b5"><div class="f_l f_s14">{t domain="store"}申请时间：{/t}{$store.apply_time}</div><div class="f_r">{t domain="store"}图例：{/t}<div class="high_light h_info">{t domain="store"}旧值{/t}</div>{t domain="store"}修改前数据，{/t}<div class="high_light h_success">{t domain="store"}新值{/t}</div>{t domain="store"}修改后数据{/t}</div></div>
		<div class="foldable-list move-mod-group">		
		<div class="accordion-group">
			<div class="accordion-heading accordion-heading-url">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info">
					<strong>{t domain="store"}店铺信息{/t}</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="info">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{t domain="store"}店铺名称：{/t}</strong></div></td>
						<td>
						{if $log_last.merchants_name}
						<div class="high_light h_info">{$log_last.merchants_name.original_data}</div><br>
						<div class="high_light h_success">{$log_last.merchants_name.new_data}</div>
						{else}
						<strong>{$store.merchants_name}</strong>
						{/if}
						{if $store.identity_status eq 2}<span class="label label-success m_l10">{t domain="store"}已认证{/t}</span>{else}<span class="label m_l10">{t domain="store"}未认证{/t}</span>{/if}
						{if $store.status eq 2}<span class="label label-important m_l10">{t domain="store"}锁定{/t}</span>{/if}</td>
						<td><div align="right"><strong>{t domain="store"}商家分类：{/t}</strong></div></td>
						<td>{if $store.cat_name eq ''}{t domain="store"}未分类{/t}{else}
    						{if $log_last.cat_name}
    						<div class="high_light h_info">{$log_last.cat_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.cat_name.new_data}</div>
    						{else}
    						{$store.cat_name}
    						{/if}
						{/if}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}店铺关键词：{/t}</strong></div></td>
						<td colspan="3">
						{if $log_last.shop_keyword}
    						<div class="high_light h_info">{$log_last.shop_keyword.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.shop_keyword.new_data}</div>
    						{else}
						    {$store.shop_keyword}
						{/if}
						</td>
					</tr>
					<tr>
					    <td><div align="right"><strong>{t domain="store"}联系方式：{/t}</strong></div></td>
						<td>
						{if $log_last.contact_mobile}
    						<div class="high_light h_info">{$log_last.contact_mobile.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.contact_mobile.new_data}</div>
    						{else}
    						{$store.contact_mobile}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}电子邮箱：{/t}</strong></div></td>
						<td>
						{if $log_last.email}
    						<div class="high_light h_info">{$log_last.email.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.email.new_data}</div>
						{else}
    						{$store.email}
						{/if}
						</td>
					</tr>

<!--                    <tr>-->
<!--                        <td><div align="right"><strong>缴纳入驻金：</strong></div></td>-->
<!--                        <td>-->
<!--                            {$store.franchisee_amount}-->
<!--                        </td>-->
<!--                        <td><div align="right"><strong>支付方式：</strong></div></td>-->
<!--                        <td>-->
<!--                            {$store.pay_name}-->
<!--                        </td>-->
<!--                    </tr>-->

					<tr>
						<td><div align="right"><strong>{t domain="store"}所在地区：{/t}</strong></div></td>
						<td>
						{if $log_last.province || $log_last.city || $log_last.district || $log_last.street}
    						<div class="high_light h_info">{$log_last.province.original_data}&nbsp;{$log_last.city.original_data}&nbsp;{$log_last.district.original_data}&nbsp;{$log_last.street.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.province.new_data}&nbsp;{$log_last.city.new_data}&nbsp;{$log_last.district.new_data}&nbsp;{$log_last.street.new_data}</div>
						{else}
    						{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}&nbsp;{$store.street}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}经纬度：{/t}</strong></div></td>
						<td>
						{if $log_last.longitude || $log_last.latitude}
    						<div class="high_light h_info">{$log_last.longitude.original_data}&nbsp;{$log_last.latitude.original_data}</div>
    						{if $log_last.longitude.original_data && $log_last.latitude.original_data}&nbsp;&nbsp;
        						{if $log_last.province || $log_last.city || $log_last.district || $log_last.street}
        						<a href="#mapModal" title='{t domain="store"}查看地图{/t}' data-toggle="modal" exname="{$store.merchants_name}" exlng="{$log_last.longitude.original_data}" exlat="{$log_last.latitude.original_data}" data-address="{$log_last.province.original_data}&nbsp;{$log_last.city.original_data}&nbsp;{$log_last.district.original_data}&nbsp;{$log_last.street.original_data}&nbsp;{$log_last.address.original_data}">{t domain="store"}[查看地图]{/t}</a>
        						{else}
        						<a href="#mapModal" title='{t domain="store"}查看地图{/t}' data-toggle="modal" exname="{$store.merchants_name}" exlng="{$store.longitude}" exlat="{$store.latitude}" data-address="{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}&nbsp;{$store.street}&nbsp;{$store.address}">{t domain="store"}[查看地图]{/t}</a>
        						{/if}
    						{/if}
    						<div class="high_light h_success">{$log_last.longitude.new_data}&nbsp;{$log_last.latitude.new_data}</div>
    						{if $log_last.longitude.new_data && $log_last.latitude.new_data}&nbsp;&nbsp;
        						{if $log_last.province || $log_last.city || $log_last.district || $log_last.street}
        						<a href="#mapModal" title='{t domain="store"}查看地图{/t}' data-toggle="modal" exname="{$store.merchants_name}" exlng="{$log_last.longitude.new_data}" exlat="{$log_last.latitude.new_data}" data-address="{$log_last.province.new_data}&nbsp;{$log_last.city.new_data}&nbsp;{$log_last.district.new_data}&nbsp;{$log_last.street.new_data}&nbsp;{$log_last.address.new_data}">{t domain="store"}[查看地图]{/t}</a>
        						{else}
        						<a href="#mapModal" title='{t domain="store"}查看地图{/t}' data-toggle="modal" exname="{$store.merchants_name}" exlng="{$store.longitude}" exlat="{$store.latitude}" data-address="{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}&nbsp;{$store.street}&nbsp;{$store.address}">{t domain="store"}[查看地图]{/t}</a>
        						{/if}
    						{/if}
						{else}
    						{$store.longitude}&nbsp;&nbsp;{$store.latitude}{if $store.longitude && $store.latitude}&nbsp;&nbsp;
    						<a href="#mapModal" title='{t domain="store"}查看地图{/t}' data-toggle="modal" exname="{$store.merchants_name}" exlng="{$store.longitude}" exlat="{$store.latitude}" data-address="{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}&nbsp;{$store.street}&nbsp;{$store.address}">{t domain="store"}[查看地图]{/t}</a>{/if}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}通讯地址：{/t}</strong></div></td>
						<td colspan="3">
						{if $log_last.address}
    						<div class="high_light h_info">{$log_last.address.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.address.new_data}</div>
						{else}
    						{$store.address}
						{/if}
						</td>
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
						<td>
						{if $log_last.responsible_person}
    						<div class="high_light h_info">{$log_last.responsible_person.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.responsible_person.new_data}</div>
						{else}
    						{$store.responsible_person}
						{/if}
						</td>
					</tr>

					{elseif $store.validate_type eq 2}
					<tr>
						<td><div align="right"><strong>{t domain="store"}入驻类型：{/t}</strong></div></td>
						<td>{if $store.validate_type eq 1}{t domain="store"}个人{/t}{else}{t domain="store"}企业{/t}{/if}</td>
						<td><div align="right"><strong>负责人：</strong></div></td>
						<td>
						{if $log_last.responsible_person}
    						<div class="high_light h_info">{$log_last.responsible_person.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.responsible_person.new_data}</div>
						{else}
    						{$store.responsible_person}
						{/if}
						</td>
					</tr>

					<tr>
					    <td><div align="right"><strong>{t domain="store"}公司名称：{/t}</strong></div></td>
						<td>
						{if $log_last.company_name}
    						<div class="high_light h_info">{$log_last.company_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.company_name.new_data}</div>
						{else}
    						{$store.company_name}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}营业执照注册号：{/t}</strong></div></td>
						<td>
						{if $log_last.business_licence}
    						<div class="high_light h_info">{$log_last.business_licence.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.business_licence.new_data}</div>
						{else}
    						{$store.business_licence}
						{/if}
						</td>
					</tr>
					{/if}
					<tr>
						<td ><div align="right"><strong>{t domain="store"}证件类型：{/t}</strong></div></td>
						<td>
						{if $log_last.identity_type}
    						<div class="high_light h_info">{$log_last.identity_type.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_type.new_data}</div>
						{else}
    						{if $store.identity_type eq 1}
    							{t domain="store"}身份证{/t}
    						{elseif $store.identity_type eq 2}
    							{t domain="store"}护照{/t}
    						{elseif $store.identity_type eq 3}
    							{t domain="store"}港澳身份证{/t}
    						{/if}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}证件号码：{/t}</strong></div></td>
						<td>
						{if $log_last.identity_number}
    						<div class="high_light h_info">{$log_last.identity_number.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_number.new_data}</div>
						{else}
    						{$store.identity_number}
						{/if}
						</td>
					</tr>
					<tr>
					    <td><div align="right"><strong>{t domain="store"}认证状态：{/t}</strong></div></td>
						<td colspan="3">{if $store.identity_status eq 0}{t domain="store"}待认证{/t}
						{else if $store.identity_status eq 1}{t domain="store"}认证中{/t}
						{else if $store.identity_status eq 2}{t domain="store"}认证通过{/t}
						{else if $store.identity_status eq 3}<span class="ecjiafc_red m_l10">{t domain="store"}不通过{/t}</span>{/if}
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		{if !$store.store_id}
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#merchant_bank">
						<strong>{t domain="store"}银行账户信息{/t}</strong>
					</div>
				</div>
			</div>

			<div class="accordion-body in collapse" id="merchant_bank">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{t domain="store"}收款银行：{/t}</strong></div></td>
						<td>
						{if $log_last.bank_name}
    						<div class="high_light h_info">{$log_last.bank_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_name.new_data}</div>
						{else}
    						{$store.bank_name}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}开户银行支行名称：{/t}</strong></div></td>
						<td>
						{if $log_last.bank_branch_name}
    						<div class="high_light h_info">{$log_last.bank_branch_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_branch_name.new_data}</div>
						{else}
    						{$store.bank_branch_name}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}银行账号：{/t}</strong></div></td>
						<td>
						{if $log_last.bank_account_number}
    						<div class="high_light h_info">{$log_last.bank_account_number.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_account_number.new_data}</div>
						{else}
    						{$store.bank_account_number}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}账户名称：{/t}</strong></div></td>
						<td>
						{if $log_last.bank_account_name}
    						<div class="high_light h_info">{$log_last.bank_account_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_account_name.new_data}</div>
						{else}
    						{$store.bank_account_name}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}开户银行支行地址：{/t}</strong></div></td>
						<td colspan="3">
						{if $log_last.bank_address}
    						<div class="high_light h_info">{$log_last.bank_address.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_address.new_data}</div>
						{else}
    						{$store.bank_address}
						{/if}
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		{/if}
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#identity_pic">
						<strong>{t domain="store"}证件电子版{/t}</strong>
					</div>
				</div>
			</div>

			<div class="accordion-body in collapse" id="identity_pic">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{t domain="store"}证件正面：{/t}</strong></div></td>
						<td>
						{if $log_last.identity_pic_front}
    						<div class="high_light h_info">{$log_last.identity_pic_front.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_pic_front.new_data}</div>
						{else}
    						{if $store.identity_pic_front neq ''}
							<a href="{RC_Upload::upload_url({$store.identity_pic_front})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_front})}"></a>
							{else}
							<div class="l_h30">
								{t domain="store"}还未上传{/t}
							</div>
							{/if}
						{/if}
						</td>
						<td><div align="right"><strong>{t domain="store"}证件反面：{/t}</strong></div></td>
						<td>
						{if $log_last.identity_pic_back}
    						<div class="high_light h_info">{$log_last.identity_pic_back.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_pic_back.new_data}</div>
						{else}
							{if $store.identity_pic_back neq ''}
							<a href="{RC_Upload::upload_url({$store.identity_pic_back})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_back})}"></a>
							{else}
							<div class="l_h30">
								{t domain="store"}还未上传{/t}
							</div>
							{/if}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}手持证件：{/t}</strong></div></td>
						<td {if $store.validate_type eq 1} colspan="3"{/if}>
						{if $log_last.personhand_identity_pic}
    						<div class="high_light h_info">{$log_last.personhand_identity_pic.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.personhand_identity_pic.new_data}</div>
						{else}
							{if $store.personhand_identity_pic neq ''}
							<a href="{RC_Upload::upload_url({$store.personhand_identity_pic})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.personhand_identity_pic})}"></a>
							{else}
							<div class="l_h30">
								{t domain="store"}还未上传{/t}
							</div>
							{/if}
						{/if}
						</td>
					<!-- {if $store.validate_type eq 1} -->
					<input type="hidden"  name="identity_type" value="{$store.validate_type}" />
					<!-- {elseif $store.validate_type eq 2} -->
						<td><div align="right"><strong>{t domain="store"}营业执照电子版：{/t}</strong></div></td>
						<td>
						{if $log_last.business_licence_pic}
    						<div class="high_light h_info">{$log_last.business_licence_pic.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.business_licence_pic.new_data}</div>
						{else}
							{if $store.business_licence_pic neq ''}
							<a href="{RC_Upload::upload_url({$store.business_licence_pic})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.business_licence_pic})}"></a>
							{else}
							<div class="l_h30">
								{t domain="store"}还未上传{/t}
							</div>
							{/if}
						{/if}
						</td>
					</tr>
					<!-- {/if} -->
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#operate">
						<strong>{t domain="store"}可执行操作{/t}</strong>
					</div>
				</div>
			</div>

			<div class="accordion-body in collapse" id="operate">
				<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{t domain="store"}备注信息：{/t}</strong></div></td>
						<td>
							<textarea class="span12" name="remark" cols="40" rows="2" placeholder='{t domain="store"}请填写审核不通过的原因，方便商家修改资料，注意换行{/t}'>{$store.remark}</textarea>
						    <input type="hidden"  name="original" />
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}审核：{/t}</strong></div></td>
						<td>
						    <label class="ecjiaf-ib"><input type="radio"  name="check_status" value="2" checked><span>{t domain="store"}通过{/t}</span></label>
							<label class="ecjiaf-ib"><input type="radio"  name="check_status" value="3" ><span>{t domain="store"}拒绝{/t}</span></label>
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{t domain="store"}操作：{/t}</strong></div></td>
						<td>
        					<input type="hidden"  name="id" value="{$store.id}" />
        					<input type="hidden"  name="store_id" value="{$store.store_id}" />
        					<button class="btn btn-gebo" type="submit">{t domain="store"}处理{/t}</button>
						</td>
					</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>

	{if $log_list}
	<div class="control-group control-group-small">
		<table class="table">
			<thead>
			  	<tr>
				    <th colspan="2" style="font-size:13px;background-color:#fff;">{t domain="store"}日志记录{/t}<a class="f_r data-pjax" href='{RC_Uri::url("store/admin_preaudit/view_log","id={$store.id}")}' style="font-weight:normal">{t domain="store"}更多{/t}</a></th>
			  	</tr>
		  	</thead>
		  	<tbody>
		  		{foreach from=$log_list item=list}
		  		<tr align="center">
				    <td style="padding:8px 0; width:5px; overflow:hidden;"><i class=" fontello-icon-right-dir"></i></td>
				    <td class="center-td" style="border-top:1px solid #e5e5e5; padding-left:0;">
				    	<span>{$list.formate_time}，</span><span style="line-height: 170%">{$list.name} {$list.info}</span>
					    {if $list.log}
		    			    <table class="table">
		                        <thead>
		                            <tr>
		                            <th width="20%">{t domain="store"}字段{/t}</th>
		                            <th width="40%">{t domain="store"}旧值{/t}</th>
		                            <th width="40%">{t domain="store"}新值{/t}</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        <!-- {foreach from=$list.log item=log} -->
		                        <tr>
		                            <td>{$log.name}</td>
		                            <td>{if $log.is_img}{$log.original_data}{else}{$log.original_data}{/if}</td>
		                            <td>{if $log.is_img}{$log.new_data}{else}{$log.new_data}{/if}</td>
		                        </tr>
		                        <!-- {/foreach} -->
		                        </tbody>
		                    </table>
		                {/if}
				    </td>
			    </tr>
		    {/foreach}
			</tbody>
		</table>
	</div>
    {/if}
	</div>
</div>
<!-- {/block} -->
