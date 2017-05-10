<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.ad_group_edit.init();
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
			        	<label class="control-label">广告组名称：</label>
			          	<div class="controls">
			            	<input class="w350" type="text" name="position_name" value="{$data.position_name}" />
			            	<span class="input-must">{lang key='system::system.require_field'}</span>
			            </div>
			        </div>
			        
			        <div class="control-group formSep">
			        	<label class="control-label">广告组代号：</label>
				        <div class="controls">
							{if $data.position_code}
								<input class="w350" type="text" disabled="disabled" value="{$data.position_code}" />
								<input type="hidden" name="position_code" value="{$data.position_code}"  />
							{else}
								<input class="w350" type="text" name="position_code" />
							{/if}
							<span class="input-must">{lang key='system::system.require_field'}</span>
							<span class="help-block">广告组调用标识，且在同一地区下该标识不可重复。</span>
						</div>
			        </div>
			      
			        <div class="control-group formSep">
			        	<label class="control-label">广告组描述：</label>
			          	<div class="controls">
			            	<textarea id="position_desc" name="position_desc" class="w350"  cols="60" rows="5">{$data.position_desc}</textarea>
			            </div>
			        </div>	
			        
			        <div class="control-group formSep">
			        	<label class="control-label">排序：</label>
			          	<div class="controls">
			            	<input class="w350" type="text" name="sort_order" value="{if $data.sort_order}{$data.sort_order}{else}50{/if}" />
			            </div>
			        </div>
			        
			        <div class="control-group">
			        	<div class="controls">
			        		{if $data.position_id}
			        			<input type="hidden" name="position_id" value="{$data.position_id}" />
			        			<input type="submit" value="更新" class="btn btn-gebo" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			        			<a class="copy ecjiafc-red" style="cursor: pointer;" data-msg="您确定要进行复制该广告组信息吗？" data-href='{url path="adsense/admin_group/copy" args="position_id={$data.position_id}"}' title="复制"><button class="btn" type="button">复制</button></a>
			        		{else}
			        			<input type="submit" value="确定" class="btn btn-gebo" />
			        		{/if}
					    </div>
		        	</div>	
				</div>
		
				<div class="right-bar move-mod">
					<div class="foldable-list move-mod-group" id="goods_info_sort_author">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_author">
									<strong>选择城市</strong>
								</a>
							</div>
							<div class="accordion-body in in_visable collapse" id="goods_info_area_author">
								<div class="accordion-inner">
									<div class="control-group control-group-small">
										<label class="control-label">选择城市：</label>
										<div class="controls">
	        								<select name="city_id" id="city_id">
						                   		<option value='0'>默认</option>
						                      	<!-- {html_options options=$city_list selected=$data.city_id} -->
											</select>
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