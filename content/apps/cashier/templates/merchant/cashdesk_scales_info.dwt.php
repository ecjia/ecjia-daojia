<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.cashdesk_scales.init();
</script>
<style>
.rewidth{
	width:95px !important;
}
</style>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal" name="theForm" action="{$form_action}"  method="post" enctype="multipart/form-data" data-toggle='from'>
                        
                        <div class="form-group">
                            <label class="control-label col-lg-2">{t}条码秤模式：{/t}</label>
                            <div class="col-lg-6">
                                <select class="form-control w510" name="barcode_mode">
									<option value="1" {if $scales_info.barcode_mode eq '1'}selected{/if}>金额模式</option>
									<option value="2" {if $scales_info.barcode_mode eq '2'}selected{/if}>重量模式</option>
									<option value="3" {if $scales_info.barcode_mode eq '3'}selected{/if}>重量模式+金额模式</option>
					            </select>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="control-label col-lg-2">{t}条码秤码：{/t}</label>
                            <div class="controls col-lg-6">
                                <input class="form-control" name="scale_sn" type="text" value="{$scales_info.scale_sn}"/>
                                <span class="help-block">条码秤码既条码秤条码标识位（通常有21，22，24，29等）</span>
                            </div>
                            <span class="input-must">{lang key='system::system.require_field'}</span>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t}日期设置：{/t}</label>
                            <div class="col-lg-10">
                                <input id="formatone" type="radio" name="date_format" value="1" {if $scales_info.date_format eq '1'} checked="true" {/if} />
                                <label for="formatone">yyyy-mm-dd</label>
                                <input id="formattwo" type="radio" name="date_format" value="2" {if $scales_info.date_format eq '2'} checked="true" {/if} />
                                <label for="formattwo">yyyy.mm.dd</label>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t}净重单位：{/t}</label>
                            <div class="col-lg-10">
                                <input id="weightunittwo" type="radio" name="weight_unit" value="2" {if $scales_info.weight_unit eq '2'} checked="true" {/if} />
                                <label for="weightunittwo">千克</label>
                                <input id="weightunitone" type="radio" name="weight_unit" value="1" {if $scales_info.weight_unit eq '1'} checked="true" {/if} />
                                <label for="weightunitone">克</label>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t}单价单位：{/t}</label>
                            <div class="col-lg-10">
                            	 <input id="priceunittwo" type="radio" name="price_unit" value="2" {if $scales_info.price_unit eq '2'} checked="true" {/if} />
                                <label for="priceunittwo">千克/元</label>
                                <input id="priceunitone" type="radio" name="price_unit" value="1" {if $scales_info.price_unit eq '1'} checked="true" {/if} />
                                <label for="priceunitone">克/元</label>
                            </div>
                        </div>
                        
						<div class="form-group">
							<label class="control-label col-lg-2">{t}抹零设置：{/t}</label>
							<div class="controls col-lg-10">
					            <div class="info-toggle-button rewidth">
					                <input class="nouniform" name="wipezero" type="checkbox"  {if $scales_info.wipezero eq '1'}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">{t}分位保留：{/t}</label>
							<div class="controls col-lg-10">
					            <div class="info-toggle-button rewidth">
					                <input class="nouniform" name="reserve_quantile" type="checkbox"  {if $scales_info.reserve_quantile eq '1'}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						
                        <div class="form-group">
                            <div class="col-lg-6 col-md-offset-2">
                            	<input type="hidden" name="id" value="{$scales_info.id}">
                                <input class="btn btn-info" type="submit" value="{if $scales_info.id}更新{else}确定{/if}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
