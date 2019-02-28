<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.ad_position_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" action='{$form_action}' method="post" name="theForm">
			<div class="row-fluid edit-page editpage-rightbar">
				<div class="left-bar move-mod">
			        <div class="control-group formSep">
			        	<label class="control-label">{t domain="adsense"}广告位名称：{/t}</label>
			          	<div class="controls">
			            	<input class="w350" type="text" name="position_name" value="{$data.position_name}" />
			            	<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
			            </div>
			        </div>
			        
			         <div class="control-group formSep">
			        	<label class="control-label">{t domain="adsense"}广告位代号：{/t}</label>
				        <div class="controls">
							{if $data.position_code}
								<input class="w350" type="text" disabled="disabled" value="{$data.position_code}" />
								<input type="hidden" name="position_code_value" value="{$data.position_code}" />
							{elseif $data.position_code eq ''}
								<input class="w350" type="text" name="position_code_ifnull" />
							{/if}
							<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
							<span class="help-block">{t domain="adsense"}广告位调用标识，且在同一地区下该标识不可重复。{/t}<br>{t domain="adsense"}可随意填写，例如：“home_ad_1”  代表首页的第一个广告位{/t}</span>
						</div>
			        </div>
			      
			        <div class="control-group formSep">
			        	<label class="control-label">{t domain="adsense"}广告位描述：{/t}</label>
			          	<div class="controls">
			            	<textarea id="position_desc" name="position_desc" class="w350"  cols="60" rows="5">{$data.position_desc}</textarea>
			            </div>
			        </div>	
			        
			        <div class="control-group formSep">
			        	<label class="control-label">{t domain="adsense"}可展示数量最大值：{/t}</label>
			          	<div class="controls">
			            	<input class="w350" type="text" name="max_number" value="{$data.max_number}" />
			            	<span class="help-block">{t domain="adsense"}在此可设置前台调用该广告位置的显示数量。{/t}</span>
			            </div>
			        </div>	
			        
			        <div class="control-group formSep">
			        	<label class="control-label">{t domain="adsense"}排序：{/t}</label>
			          	<div class="controls">
			            	<input class="w350" type="text" name="sort_order" value="{if $data.sort_order}{$data.sort_order}{else}50{/if}" />
			            </div>
			        </div>		        
			        
			        <div class="control-group">
			        	<div class="controls">
			        		{if $data.position_id}
			        			<input type="hidden" name="position_id" value="{$data.position_id}" />
			        			<input type="submit" value='{t domain="adsense"}更新{/t}' class="btn btn-gebo" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			        			<a class="copy ecjiafc-red" style="cursor: pointer;" data-msg='{t domain="adsense"}您确定要进行复制该广告位信息吗？{/t}' data-href='{url path="adsense/admin_position/copy" args="position_id={$data.position_id}"}' title='{t domain="adsense"}复制{/t}'><button class="btn" type="button">{t domain="adsense"}复制{/t}</button></a>
			        		{else}
			        			<input type="submit" value='{t domain="adsense"}确定{/t}' class="btn btn-gebo" />
			        		{/if}
					    </div>
		        	</div>	  
				</div>
		
				<div class="right-bar move-mod">
					<div class="foldable-list move-mod-group" id="goods_info_sort_author">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_author">
									<strong>{t domain="adsense"}选择城市{/t}</strong>
								</a>
							</div>
							<div class="accordion-body in in_visable collapse" id="goods_info_area_author">
								<div class="accordion-inner">
									<div class="control-group control-group-small formSep" >
										<label class="control-label">{t domain="adsense"}选择城市：{/t}</label>
										<div class="controls">
	        								<select name="city_id" id="city_id">
						                   		<option value='0'>{t domain="adsense"}默认{/t}</option>
						                      	<!-- {html_options options=$city_list selected=$data.city_id} -->
											</select>
										</div>
									</div>	
									
									<div class="control-group control-group-small formSep">
							        	<label class="control-label">{t domain="adsense"}宽度：{/t}</label>
							        	<div class="controls">
								        	<input type="text" name="ad_width" value="{$data.ad_width}"  class="" placeholder='{t domain="adsense"}像素{/t}' />
											<span class="help-block">{t domain="adsense"}建议广告位宽度单位为Px{/t}</span>
										</div>
							        </div>
							        
							  		<div class="control-group control-group-small">
							        	<label class="control-label">{t domain="adsense"}高度：{/t}</label>
							        	<div class="controls">
						            		<input type="text" name="ad_height" value="{$data.ad_height}" class="" placeholder='{t domain="adsense"}像素{/t}' />
						            		<span class="help-block">{t domain="adsense"}建议广告位高度单位为Px{/t}</span>
						            	</div>
							        </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- {/block} -->