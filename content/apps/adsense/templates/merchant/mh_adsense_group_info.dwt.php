<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.merchant_group_edit.init();
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
                        <form class="form-horizontal"  name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">广告组名称：</label>
                                        <div class="controls col-lg-6">
                                            <input class="form-control" type="text" name="position_name" id="position_name" value="{$data.position_name}" />
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">广告组代号：</label>
                                        <div class="controls col-lg-6">
	                                        {if $data.position_code}
												<input class="form-control" name="position_code" type="text" disabled="disabled" value="{$data.position_code}" />
											{elseif $data.position_code eq ''}
												 <input class="form-control" type="text" name="position_code" id="position_code"/>
											{/if}
											<span class="help-block">广告组调用标识，且在同门店下该标识不可重复。</span>
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>
                                    
 									<div class="form-group">
				                        <label class="control-label col-lg-2">广告组描述：</label>
				                        <div class="controls col-lg-6 ">
				                          <textarea class="form-control" id="position_desc" name="position_desc">{$data.position_desc}</textarea>
				                        </div>
			                      	</div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">排序：</label>
                                        <div class="controls col-lg-6">
                                            <input class="form-control" type="text" name="sort_order" id="sort_order" value="{$data.sort_order}" />
                                        </div>
                                    </div>
			                      	
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
					        			<input type="hidden" name="position_id" value="{$data.position_id}" />
					        			<input type="submit" value="确定" class="btn btn-info" />
                                        </div>
                                    </div>
                                </fieldset>
                           </form>
                        </div>
                   </div>
              </div>
          </div>
     </div>
 </div>
<!-- {/block} -->