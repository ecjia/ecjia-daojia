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
		                <div class="accordion-group">
                			<div class="accordion-heading">
                				<div class="accordion-heading accordion-heading-url">
                					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#operate">
                						<strong>认证操作</strong>
                					</div>
                				</div>
                			</div>
            
                			<div class="accordion-body in collapse" id="operate">
                				<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                				<table class="table table-oddtd m_b0">
                					<tbody class="first-td-no-leftbd">
<!--                 					<tr> -->
<!--                 						<td><div align="right"><strong>认证：</strong></div></td> -->
<!--                 						<td> -->
<!--                 							<label class="ecjiaf-ib"><input type="radio"  name="identity_status" value="0" {if $store.identity_status eq 0}checked{/if}><span>待审核</span></label> -->
<!--                     						<label class="ecjiaf-ib"><input type="radio"  name="identity_status" value="3" {if $store.identity_status eq 3}checked{/if}><span>{lang key='store::store.check_no'}</span></label> -->
<!--                     						<label class="ecjiaf-ib"><input type="radio"  name="identity_status" value="2" {if $store.identity_status eq 2}checked{/if}><span>{lang key='store::store.check_yes'}</span></label> -->
<!--                 						</td> -->
<!--                 					</tr> -->
                					<tr>
                						<td><div align="right"><strong>当前认证状态：</strong></div></td>
                						<td colspan="3">{if $store.identity_status eq 0}待认证
            							{else if $store.identity_status eq 1}认证中
            							{else if $store.identity_status eq 2}认证通过
            							{else if $store.identity_status eq 3}<span class="ecjiafc_red m_l10">不通过</span>{/if}
            							</td>
                					</tr>
                					<tr>
                						<td><div align="right"><strong>可执行操作：</strong></div></td>
                						<td>
                        					<input type="hidden" name="store_id" value="{$store.store_id}" />
                        					<button class="btn operatesubmit" type="submit" name="check_ing">认证中</button>&nbsp;
                        					<button class="btn operatesubmit" type="submit" name="check_no">不通过</button>&nbsp;
                        					<button class="btn operatesubmit" type="submit" name="check_yes">{lang key='store::store.check_yes'}</button>
                        					<!-- <button class="btn btn-gebo" type="submit">{lang key='store::store.sub_check'}</button> -->
                						</td>
                					</tr>
                					</tbody>
                				</table>
                				</form>
                			</div>
            		  </div>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- {/block} -->
