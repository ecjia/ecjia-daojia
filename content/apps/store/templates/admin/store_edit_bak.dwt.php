<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
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
		<div class="tabbable tabs-left">
		
			<ul class="nav nav-tabs tab_merchants_nav">
				<li><a href='{RC_Uri::url("store/admin/preview","store_id={$smarty.get.store_id}")}' class="pjax" >基本信息</a></li>
				<li><a href='{RC_Uri::url("store/admin_commission/edit","store_id={$smarty.get.store_id}")}' class="pjax" >设置佣金</a></li>
				<li><a href='{RC_Uri::url("commission/admin/init","store_id={$smarty.get.store_id}")}' class="pjax" >结算账单</a></li>
				<li><a href='{RC_Uri::url("store/admin/view_staff","store_id={$smarty.get.store_id}")}' class="pjax" >查看员工</a></li>
			</ul>
			
			<div class="tab-content tab_merchants">
				<div class="tab-pane active " style="min-height:300px;">
				<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
        			<fieldset>
        			
        			    <div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.store_title_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="merchants_name" type="text" value="{$store.merchants_name}" />
        					</div>
        				</div>
        			    <div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.store_cat_lable'}</label>
        					<div class="controls">
        						<select name="store_cat">
        							<option value="0">{lang key='store::store.select_plz'}</option>
        							<!-- {html_options options=$cat_list selected=$store.cat_id} -->
        						</select>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.store_keywords_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="shop_keyword" type="text" value="{$store.shop_keyword}" />
        					</div>
        				</div>
        				
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.contact_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="contact_mobile" type="text" value="{$store.contact_mobile}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.email_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="email" type="text" value="{$store.email}" />
        					</div>
        				</div>
        				
        				{if $store.validate_type eq 1}
        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.validate_type'}</label>
        					<div class="controls l_h30">
        						<span class="span6" name="validate_type" value="{$store.validate_type}">{lang key='store::store.personal'}</span>
        						<input type="hidden"  name="validate_type" value="{$store.validate_type}" />
        					</div>
        				</div>
        
        				<div class="control-group formSep">
        					<label class="control-label">负责人：</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>
        
        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.identity_type_lable'}</label>
        					<div class="controls">
        						<select name="identity_type">
        							<option value="0">{lang key='store::store.select_plz'}</option>
        							<!-- {html_options options=$certificates_list selected=$store.identity_type} -->
        						</select>
        					</div>
        				</div>
        
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.identity_number_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="identity_number" type="text" value="{$store.identity_number}" />
        					</div>
        				</div>
        				{elseif $store.validate_type eq 2}
        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.validate_type'}</label>
        					<div class="controls l_h30">
        						<span class="span6 " name="validate_type" value="{$store.validate_type}">{lang key='store::store.company'}</span>
        						<input type="hidden"  name="validate_type" value="{$store.valtidate_type}" />
        					</div>
        				</div>
        
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.companyname_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="company_name" type="text" value="{$store.company_name}" />
        					</div>
        				</div>
        
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.person_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>
        
        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.identity_type_lable'}</label>
        					<div class="controls">
        						<select name="identity_type">
        							<option value="0">{lang key='store::store.select_plz'}</option>
        							<!-- {html_options options=$certificates_list selected=$store.identity_type} -->
        						</select>
        					</div>
        				</div>
        
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.identity_number_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="identity_number" type="text" value="{$store.identity_number}" />
        					</div>
        				</div>
        
        				<div class="control-group formSep">
        					{if $store.business_licence_pic eq ''}
        					<label class="control-label">{lang key='store::store.business_licence_pic_lable'}</label>
        					<div class="controls">
        						<div class="fileupload fileupload-new" data-provides="fileupload">
        							<input type="hidden" name="{$var.code}" />
        							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='one' size="35" />
        								</span>
        							<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        						</div>
        					</div>
        					{else}
        					<label class="control-label">{lang key='store::store.business_licence_pic_lable'}</label>
        					<div class="controls">
        						<div class="fileupload fileupload-new" data-provides="fileupload">
        							<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.business_licence_pic}"><br><br>
        							{lang key='store::store.file_address'}{$store.business_licence_pic}<br><br>
        							<input type="hidden" name="{$var.code}" />
        							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='one' size="35" />
        								</span>
        							<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							<input type="hidden" name="{$var.code}" />
        							<input type="hidden" name="{$store.business_licence_pic}" />
        							<input name="business_licence_pic" value="{$store.business_licence_pic}" class="hide">
        						</div>
        					</div>
        					{/if}
        				</div>
        
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.business_licence_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="business_licence" type="text" value="{$store.business_licence}" />
        					</div>
        				</div>
        				{/if}
        
        				<div class="control-group formSep">
        					{if $store.identity_pic_front eq ''}
        						<label class="control-label">{lang key='store::store.identity_pic_front_lable'}</label>
        						<div class="controls">
        							<div class="fileupload fileupload-new" data-provides="fileupload">
        								<input type="hidden" name="{$var.code}" />
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='two' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							</div>
        						</div>
        					{else}
        						<label class="control-label">{lang key='store::store.identity_pic_front_lable'}</label>
        						<div class="controls">
        							<div class="fileupload fileupload-new" data-provides="fileupload">
        								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.identity_pic_front}"><br><br>
        								{lang key='store::store.file_address'}{$store.identity_pic_front}<br><br>
        								<input type="hidden" name="{$var.code}" />
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='two' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        								<input type="hidden" name="{$var.code}" />
        								<input type="hidden" name="{$store.identity_pic_front}" />
        								<input name="identity_pic_front" value="{$store.identity_pic_front}" class="hide">
        							</div>
        						</div>
        					{/if}
        				</div>
        				
        				<div class="control-group formSep">
        					{if $store.identity_pic_back eq ''}
        						<label class="control-label">{lang key='store::store.identity_pic_back_lable'}</label>
        						<div class="controls">
        							<div class="fileupload fileupload-new" data-provides="fileupload">
        								<input type="hidden" name="{$var.code}" />
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='three' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							</div>
        						</div>
        					{else}
        						<label class="control-label">{lang key='store::store.identity_pic_back_lable'}</label>
        						<div class="controls">
        							<div class="fileupload fileupload-new" data-provides="fileupload">
        								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.identity_pic_back}"><br><br>
        								{lang key='store::store.file_address'}{$store.identity_pic_back}<br><br>
        								<input type="hidden" name="{$var.code}" />
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='three' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        								<input type="hidden" name="{$var.code}" />
        								<input type="hidden" name="{$store.identity_pic_back}" />
        								<input name="identity_pic_back" value="{$store.identity_pic_back}" class="hide">
        							</div>
        						</div>
        					{/if}
        				</div>
        				
        				<div class="control-group formSep">
        					{if $store.personhand_identity_pic eq ''}
        						<label class="control-label">{lang key='store::store.personhand_identity_pic_lable'}</label>
        						<div class="controls">
        							<div class="fileupload fileupload-new" data-provides="fileupload">
        								<input type="hidden" name="{$var.code}" />
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='four' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							</div>
        						</div>
        					{else}
        						<label class="control-label">{lang key='store::store.identity_pic_back_lable'}</label>
        						<div class="controls">
        							<div class="fileupload fileupload-new" data-provides="fileupload">
        								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.personhand_identity_pic}"><br><br>
        								{lang key='store::store.file_address'}{$store.personhand_identity_pic}<br><br>
        								<input type="hidden" name="{$var.code}" />
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='four' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        								<input type="hidden" name="{$var.code}" />
        								<input type="hidden" name="{$store.personhand_identity_pic}" />
        								<input name="personhand_identity_pic" value="{$store.personhand_identity_pic}" class="hide">
        							</div>
        						</div>
        					{/if}
        				</div>
        				<!-- 银行 -->
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_name_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_name" type="text" value="{$store.bank_name}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_account_number_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_account_number" type="text" value="{$store.bank_account_number}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_account_name_label'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_account_name" type="text" value="{$store.bank_account_name}" />
        					</div>
        				</div>
                        <div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_branch_name_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_branch_name" type="text" value="{$store.bank_branch_name}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_address_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_address" type="text" value="{$store.bank_address}" />
        					</div>
        				</div>
        				<!-- 地区 -->
        				<div class="control-group formSep">
        					<label class="control-label">选择地区：</label>
        					<div class="controls choose_list">
        						<select class="region-summary-provinces w120" name="province" id="selProvinces" data-url="{url path='store/admin_preaudit/get_region'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
        							<option value='0'>{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$province item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.province}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-cities w120" name="city" id="selCities" >
        							<option value='0'>{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$city item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.city}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-district w120" name="district" id="seldistrict" >
        							<option value='0'>{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$district item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.district}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.address_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="address" type="text" value="{$store.address}" />
        						<input type="button" class="btn btn-gebo longitude" value="{t}点击获取经纬度{/t}" data-url='{url path="store/admin/get_longitude&store_id={$store.store_id}"}'  title="{lang key='system::system.edit'}"/>
        					</div>
        				</div>
        
        				
        				<div class="control-group formSep">
        					<label class="control-label">经纬度：</label>
        				 	<div class="l_h30 long f_l"></div>
        					<div class="l_h30 latd f_l m_l10"></div>
        				</div>
        				
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.apply_time_lable'}</label>
        				 	<div class="controls l_h30">
        						{$store.apply_time}
        					</div>
        				</div>
        				
        				<div class="control-group">
        					<div class="controls">
        						<input type="hidden"  name="store_id" value="{$store.store_id}" />
        						<button class="btn btn-gebo" type="submit">{lang key='store::store.sub_update'}</button>
        					</div>
        				</div>
        			</fieldset>
        		</form>
			    </div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->