<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.express_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}配送员名称：{/t}</label>
					<div class="controls">
						<input class="w480" type='text' name='name' value="{$data.name}" /> 
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}员工编号：{/t}</label>
					<div class="controls">
						<input class="w480" type='text' name='user_ident' value="{$data.user_ident}"  /> 
						<span class="help-block">{t domain="express"}员工编号请以 SC 开始{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}手机号码：{/t}</label>
					<div class="controls">
						<input class="w480" type="text" name="mobile" value="{$data.mobile}" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>  
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}邮箱账号：{/t}</label>
					<div class="controls">
						<input class="w480" type="text" name="email" value="{$data.email}" />
					</div>
				</div>  
				<!-- {if $data.user_id} -->
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}登录密码：{/t}</label>
					<div class="controls">
						<input class="w480" type="password" name="newpassword"  placeholder='{t domain="express"}请输入新的登录密码{/t}'/>
						<span class="help-block">{t domain="express"}请设置配送员在App端的登录密码{/t}</span>
					</div>
				</div>  
				<!-- {else} -->
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}登录密码：{/t}</label>
					<div class="controls">
						<input class="w480" type="password" name="password"  placeholder='{t domain="express"}请输入登录密码{/t}'/>
						<span class="help-block">{t domain="express"}请设置配送员在App端的登录密码{/t}</span>
					</div>
				</div> 
				<!-- {/if} -->
								
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}选择地区：{/t}</label>
					<div class="controls choose_list">
						<select class="region-summary-provinces w120" name="province" id="selProvinces" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
							<option value='0'>{t domain="express"}请选择...{/t}</option>
							<!-- {foreach from=$province item=region} -->
							<option value="{$region.region_id}" {if $region.region_id eq $data.province}selected{/if}>{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select class="region-summary-cities w120" name="city" id="selCities" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="3" data-target="region-summary-district">
							<option value='0'>{t domain="express"}请选择...{/t}</option>
							<!-- {foreach from=$city item=region} -->
							<option value="{$region.region_id}" {if $region.region_id eq $data.city}selected{/if}>{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select class="region-summary-district w120" name="district" id="seldistrict" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="4" data-target="region-summary-street">
							<option value='0'>{t domain="express"}请选择...{/t}</option>
							<!-- {foreach from=$district item=region} -->
							<option value="{$region.region_id}" {if $region.region_id eq $data.district}selected{/if}>{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select class="region-summary-street w120" name="street" id="selstreet" >
							<option value='0'>{t domain="express"}请选择...{/t}</option>
							<!-- {foreach from=$street item=region} -->
							<option value="{$region.region_id}" {if $region.region_id eq $data.street}selected{/if}>{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label"></label>
					<div class="controls">
						<input class="w480" type="text" name="address" placeholder='{t domain="express"}请输入详细地址{/t}'  value="{$data.address}"/>
						<span class="help-block">{t domain="express"}请选择配送员所在地区{/t}</span>
					</div>
				</div>	
			
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}配送费用：{/t}</label>
					<div class="controls">
						<input class="span2" type="text" name="shippingfee_percent" value="{$data.shippingfee_percent}"/>&nbsp;&nbsp;%
						<span class="help-block">{t domain="express"}填写配送员所得配送费用占总配送费的百分比{/t}</span>
					</div>
				</div>  
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="express"}工作类型：{/t}</label>
					<div class="controls chk_radio">
						<input type="radio" name="work_type" value="1" checked="true" {if $data.work_type eq 1} checked="true" {/if} />{t domain="express"}派单{/t}
						<input type="radio" name="work_type" value="2" {if $data.work_type eq 2} checked="true" {/if} />{t domain="express"}抢单{/t}
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						{if $data.user_id eq ''}
							<button class="btn btn-gebo" type="submit">{t domain="express"}确认{/t}</button>
						{else}
							<input type="hidden" name="user_id" value="{$data.user_id}" />
							<button class="btn btn-gebo" type="submit">{t domain="express"}更新{/t}</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->