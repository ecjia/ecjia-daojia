<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.merchant_ad_position_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        	<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
        {/if}
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                    <div class="form">
                        <form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" >
                            <div class="col-lg-8" style="padding-left:0px;">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">广告位名称：</label>
                                        <div class="controls col-lg-8">
                                            <input class="form-control" type="text" name="position_name" id="position_name" value="{$data.position_name}" />
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>
                                    
<!-- 									<div class="form-group"> -->
<!-- 									 	<label class="control-label col-lg-3">广告位代号：</label> -->
<!--                                      	<div class="controls col-lg-8"> -->
<!--                                              <select class="form-control"  name="" id=""> -->
<!--                                                   <option value="0" selected="selected" >请选择广告位代号</option> -->
<!--                                              </select> -->
<!--                                         </div> -->
<!-- 									</div> -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">广告位代号：</label>
                                        <div class="controls col-lg-8">
	                                        {if $data.position_code}
												<input class="form-control" name="position_code" type="text" disabled="disabled" value="{$data.position_code}" />
											{elseif $data.position_code eq ''}
												 <input class="form-control" type="text" name="position_code" id="position_code"/>
											{/if}
											<span class="help-block">广告位调用标识，且在同门店下该标识不可重复。<br>可随意填写，例如：“home_ad_1”  代表首页的第一个广告位</span>
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>
                                    
 									<div class="form-group">
				                        <label class="control-label col-lg-3">广告位描述：</label>
				                        <div class="controls col-lg-8 ">
				                          <textarea class="form-control" id="position_desc" name="position_desc">{$data.position_desc}</textarea>
				                        </div>
			                      	</div>
			                      	
			                      	<div class="form-group">
                                        <label class="control-label col-lg-3">可展示数量最大值：</label>
                                        <div class="controls col-lg-8">
                                            <input class="form-control" type="text" name="max_number" id="max_number" value="{$data.max_number}" />
                                            <span class="help-block">在此可设置前台调用该广告位的显示数量。</span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">排序：</label>
                                        <div class="controls col-lg-8">
                                            <input class="form-control" type="text" name="sort_order" id="sort_order" value="{$data.sort_order}" />
                                        </div>
                                    </div>
			                      	
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-8">
                                           {if $data.position_id}
							        			<input type="hidden" name="position_id" value="{$data.position_id}" />
							        			<input type="submit" value="更新" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							        		{else}
							        			<input type="submit" value="确定" class="btn btn-info" />
							        		{/if}
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-lg-4">
                                <fieldset>
                                    <div class="panel-group">
							            <div class="panel panel-info">
							                <div class="panel-heading">
							                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseNine" class="accordion-toggle">
							                        <span class="glyphicon"></span>
							                        <h4 class="panel-title">其它信息</h4>
							                    </a>
							                </div>
							                <div id="collapseNine" class="panel-collapse collapse in">
						              			<div class="panel-body">
			                                        <div class="form-group">
							              				<label class="control-label col-lg-3">宽度：</label>
							              				<div class="col-lg-9">
							                            	<input class="form-control" name="ad_width" value="{$data.ad_width}" type="text" placeholder="像素">
							                            	<span class="help-block">建议广告位宽度单位为Px</span>
							                          	</div>
							              			</div>
							              			
							              			<div class="form-group">
							              				<label class="control-label col-lg-3">高度：</label>
							              				<div class="col-lg-9">
							                          		<input class="form-control" name="ad_height" value="{$data.ad_height}" type="text" placeholder="像素">
							                          		<span class="help-block">建议广告位高度单位为Px</span>
							                          	</div>
							              			</div>
			                                    </div>
					              			</div>
						        		</div>
					        		</div>
                                </fieldset>
                            </div>
                         </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->