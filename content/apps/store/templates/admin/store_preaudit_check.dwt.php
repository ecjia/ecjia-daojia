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
	    <div class="row-fluid m_b5"><div class="f_l f_s14">{lang key='store::store.apply_time_lable'}{$store.apply_time}</div><div class="f_r">图例：<div class="high_light h_info">旧值</div>修改前数据，<div class="high_light h_success">新值</div>修改后数据</div></div>
		<div class="foldable-list move-mod-group">		
		<div class="accordion-group">
			<div class="accordion-heading accordion-heading-url">
				<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info">
					<strong>店铺信息</strong>
				</div>
			</div>
			<div class="accordion-body in collapse" id="info">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='store::store.store_title_lable'}</strong></div></td>
						<td>
						{if $log_last.merchants_name}
						<div class="high_light h_info">{$log_last.merchants_name.original_data}</div><br>
						<div class="high_light h_success">{$log_last.merchants_name.new_data}</div>
						{else}
						<strong>{$store.merchants_name}</strong>
						{/if}
						{if $store.identity_status eq 2}<span class="label label-success m_l10">已认证</span>{else}<span class="label m_l10">未认证</span>{/if}
						{if $store.status eq 2}<span class="label label-important m_l10">锁定</span>{/if}</td>
						<td><div align="right"><strong>{lang key='store::store.store_cat_lable'}</strong></div></td>
						<td>{if $store.cat_name eq ''}未分类{else}
    						{if $log_last.cat_name}
    						<div class="high_light h_info">{$log_last.cat_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.cat_name.new_data}</div>
    						{else}
    						{$store.cat_name}
    						{/if}
						{/if}</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='store::store.store_keywords_lable'}</strong></div></td>
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
					    <td><div align="right"><strong>{lang key='store::store.contact_lable'}</strong></div></td>
						<td>
						{if $log_last.contact_mobile}
    						<div class="high_light h_info">{$log_last.contact_mobile.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.contact_mobile.new_data}</div>
    						{else}
    						{$store.contact_mobile}
						{/if}
						</td>
						<td><div align="right"><strong>{lang key='store::store.email_lable'}</strong></div></td>
						<td>
						{if $log_last.email}
    						<div class="high_light h_info">{$log_last.email.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.email.new_data}</div>
						{else}
    						{$store.email}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>所在地区：</strong></div></td>
						<td>
						{if $log_last.province || $log_last.city || $log_last.district}
    						<div class="high_light h_info">{$log_last.province.original_data}&nbsp;{$log_last.city.original_data}&nbsp;{$log_last.district.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.province.new_data}&nbsp;{$log_last.city.new_data}&nbsp;{$log_last.district.new_data}</div>
						{else}
    						{$store.province}&nbsp;{$store.city}&nbsp;{$store.district}
						{/if}
						</td>
						<td><div align="right"><strong>经纬度：</strong></div></td>
						<td>
						{if $log_last.longitude || $log_last.latitude}
    						<div class="high_light h_info">{$log_last.longitude.original_data}&nbsp;{$log_last.latitude.original_data}</div>
    						{if $log_last.longitude.original_data && $log_last.latitude.original_data}&nbsp;&nbsp;<a href="https://apis.map.qq.com/uri/v1/marker?marker=coord:{$log_last.latitude.original_data},{$log_last.longitude.original_data};title:我的位置;addr:{$store.merchants_name}&referer=ecjiacityo2o" title="查看地图" target="_blank">[查看地图]</a>{/if}<br>
    						<div class="high_light h_success">{$log_last.longitude.new_data}&nbsp;{$log_last.latitude.new_data}</div>
    						{if $log_last.longitude.new_data && $log_last.latitude.new_data}&nbsp;&nbsp;<a href="https://apis.map.qq.com/uri/v1/marker?marker=coord:{$log_last.latitude.new_data},{$log_last.longitude.new_data};title:我的位置;addr:{$store.merchants_name}&referer=ecjiacityo2o" title="查看地图" target="_blank">[查看地图]</a>{/if}
						{else}
    						{$store.longitude}&nbsp;&nbsp;{$store.latitude}{if $store.longitude && $store.latitude}&nbsp;&nbsp;<a href="https://apis.map.qq.com/uri/v1/marker?marker=coord:{$store.latitude},{$store.longitude};title:我的位置;addr:{$store.merchants_name}&referer=ecjiacityo2o" title="查看地图" target="_blank">[查看地图]</a>{/if}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='store::store.address_lable'}</strong></div></td>
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
						<strong>经营主体信息</strong>
					</div>
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
						<td><div align="right"><strong>{lang key='store::store.validate_type'}</strong></div></td>
						<td>{if $store.validate_type eq 1}{lang key='store::store.personal'}{else}{lang key='store::store.company'}{/if}</td>
						<td><div align="right"><strong>{lang key='store::store.person_lable'}</strong></div></td>
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
					    <td><div align="right"><strong>{lang key='store::store.companyname_lable'}</strong></div></td>
						<td>
						{if $log_last.company_name}
    						<div class="high_light h_info">{$log_last.company_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.company_name.new_data}</div>
						{else}
    						{$store.company_name}
						{/if}
						</td>
						<td><div align="right"><strong>{lang key='store::store.business_licence_lable'}</strong></div></td>
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
						<td ><div align="right"><strong>{lang key='store::store.identity_type_lable'}</strong></div></td>
						<td>
						{if $log_last.identity_type}
    						<div class="high_light h_info">{$log_last.identity_type.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_type.new_data}</div>
						{else}
    						{if $store.identity_type eq 1}
    						{lang key='store::store.people_id'}
    						{elseif $store.identity_type eq 2}
    						{lang key='store::store.passport'}
    						{elseif $store.identity_type eq 3}
    						{lang key='store::store.hong_kong_and_macao_pass'}
    						{/if}
						{/if}
						</td>
						<td><div align="right"><strong>{lang key='store::store.identity_number_lable'}</strong></div></td>
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
					    <td><div align="right"><strong>认证状态：</strong></div></td>
						<td colspan="3">{if $store.identity_status eq 0}待认证
						{else if $store.identity_status eq 1}认证中
						{else if $store.identity_status eq 2}认证通过
						{else if $store.identity_status eq 3}<span class="ecjiafc_red m_l10">不通过</span>{/if}
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
						<strong>银行账户信息</strong>
					</div>
				</div>
			</div>

			<div class="accordion-body in collapse" id="merchant_bank">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='store::store.bank_name_lable'}</strong></div></td>
						<td>
						{if $log_last.bank_name}
    						<div class="high_light h_info">{$log_last.bank_name.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_name.new_data}</div>
						{else}
    						{$store.bank_name}
						{/if}
						</td>
						<td><div align="right"><strong>{lang key='store::store.bank_branch_name_lable'}</strong></div></td>
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
						<td><div align="right"><strong>{lang key='store::store.bank_account_number_lable'}</strong></div></td>
						<td>
						{if $log_last.bank_account_number}
    						<div class="high_light h_info">{$log_last.bank_account_number.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.bank_account_number.new_data}</div>
						{else}
    						{$store.bank_account_number}
						{/if}
						</td>
						<td><div align="right"><strong>{lang key='store::store.bank_account_name_label'}</strong></div></td>
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
						<td><div align="right"><strong>{lang key='store::store.bank_address_lable'}</strong></div></td>
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
						<strong>证件电子版</strong>
					</div>
				</div>
			</div>

			<div class="accordion-body in collapse" id="identity_pic">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='store::store.identity_pic_front_lable'}</strong></div></td>
						<td>
						{if $log_last.identity_pic_front}
    						<div class="high_light h_info">{$log_last.identity_pic_front.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_pic_front.new_data}</div>
						{else}
    						{if $store.identity_pic_front neq ''}
							<a href="{RC_Upload::upload_url({$store.identity_pic_front})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_front})}"></a>
							{else}
							<div class="l_h30">
								{lang key='store::store.no_upload'}
							</div>
							{/if}
						{/if}
						</td>
						<td><div align="right"><strong>{lang key='store::store.identity_pic_back_lable'}</strong></div></td>
						<td>
						{if $log_last.identity_pic_back}
    						<div class="high_light h_info">{$log_last.identity_pic_back.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.identity_pic_back.new_data}</div>
						{else}
							{if $store.identity_pic_back neq ''}
							<a href="{RC_Upload::upload_url({$store.identity_pic_back})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_back})}"></a>
							{else}
							<div class="l_h30">
								{lang key='store::store.no_upload'}
							</div>
							{/if}
						{/if}
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='store::store.personhand_identity_pic_lable'}</strong></div></td>
						<td {if $store.validate_type eq 1} colspan="3"{/if}>
						{if $log_last.personhand_identity_pic}
    						<div class="high_light h_info">{$log_last.personhand_identity_pic.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.personhand_identity_pic.new_data}</div>
						{else}
							{if $store.personhand_identity_pic neq ''}
							<a href="{RC_Upload::upload_url({$store.personhand_identity_pic})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.personhand_identity_pic})}"></a>
							{else}
							<div class="l_h30">
								{lang key='store::store.no_upload'}
							</div>
							{/if}
						{/if}
						</td>
					<!-- {if $store.validate_type eq 1} -->
					<input type="hidden"  name="identity_type" value="{$store.validate_type}" />
					<!-- {elseif $store.validate_type eq 2} -->
						<td><div align="right"><strong>{lang key='store::store.business_licence_pic_lable'}</strong></div></td>
						<td>
						{if $log_last.business_licence_pic}
    						<div class="high_light h_info">{$log_last.business_licence_pic.original_data}</div><br>
    						<div class="high_light h_success">{$log_last.business_licence_pic.new_data}</div>
						{else}
							{if $store.business_licence_pic neq ''}
							<a href="{RC_Upload::upload_url({$store.business_licence_pic})}" title="点击查看大图" target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.business_licence_pic})}"></a>
							{else}
							<div class="l_h30">
								{lang key='store::store.no_upload'}
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
						<strong>可执行操作</strong>
					</div>
				</div>
			</div>

			<div class="accordion-body in collapse" id="operate">
				<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
					<tr>
						<td><div align="right"><strong>{lang key='store::store.remark_lable'}</strong></div></td>
						<td>
							<textarea class="span12" name="remark" cols="40" rows="2" placeholder="请填写审核不通过的原因，方便商家修改资料，注意换行">{$store.remark}</textarea>
						    <input type="hidden"  name="original" />
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>{lang key='store::store.check_lable'}</strong></div></td>
						<td>
						    <label class="ecjiaf-ib"><input type="radio"  name="check_status" value="2" checked><span>{lang key='store::store.check_yes'}</span></label>
							<label class="ecjiaf-ib"><input type="radio"  name="check_status" value="3" ><span>拒绝</span></label>
						</td>
					</tr>
					<tr>
						<td><div align="right"><strong>操作：</strong></div></td>
						<td>
        					<input type="hidden"  name="id" value="{$store.id}" />
        					<input type="hidden"  name="store_id" value="{$store.store_id}" />
        					<button class="btn btn-gebo" type="submit">{lang key='store::store.sub_check'}</button>
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
				    <th colspan="2" style="font-size:13px;background-color:#fff;">日志记录<a class="f_r data-pjax" href='{RC_Uri::url("store/admin_preaudit/view_log","id={$store.id}")}' style="font-weight:normal">更多</a></th>
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
		                            <th width="20%">字段</th>
		                            <th width="40%">旧值</th>
		                            <th width="40%">新值</th>
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
