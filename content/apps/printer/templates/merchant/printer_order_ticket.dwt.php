<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>
<style media="screen" type="text/css">

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-lg-3">
                    <!-- {ecjia:hook id=display_merchant_printer_menus} -->
                </div>
                
                <div class="col-lg-9">
                	<h3 class="page-header">
                    	<div class="pull-left">{t domain="printer"}打印机自定义设置{/t}</div>
						<div class="clearfix"></div>
  					</h3>
  					<div class="row m_t20">
						<div class="col-lg-6">
							<!-- {if $smarty.get.type eq 'print_buy_orders'} -->
								<!-- #BeginLibraryItem "/library/print_buy_orders.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'print_takeaway_orders'} -->
								<!-- #BeginLibraryItem "/library/print_takeaway_orders.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'print_store_orders'} -->
								<!-- #BeginLibraryItem "/library/print_store_orders.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'print_quickpay_orders'} -->
								<!-- #BeginLibraryItem "/library/print_quickpay_orders.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'print_refund_orders'} -->
								<!-- #BeginLibraryItem "/library/print_refund_orders.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'print_surplus_orders'} -->
								<!-- #BeginLibraryItem "/library/print_surplus_orders.lbi" --><!-- #EndLibraryItem -->
							<!-- {/if} -->
						</div>
						<div class="col-lg-6">
							<div class="ticket_form">
								<form class="form-horizontal ticket_form" name="theForm" method="post" action="{$form_action}">
				                 	<div class="form-group">
			                            <label class="control-label col-lg-5">{t domain="printer"}模板名称{/t}</label>
			                            <div class="col-lg-7">{$template_subject}</div>
			                            <input type="hidden" name="template_subject" value="{$template_subject}" />
			                        </div>
			                       	<div class="form-group">
			                            <label class="control-label col-lg-5">{t domain="printer"}模板代号{/t}</label>
			                            <div class="col-lg-7">{$type}</div>
			                            <input type="hidden" name="template_code" value="{$type}" />
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-lg-5">{t domain="printer"}打印数量{/t}</label>
			                            <div class="col-lg-7">
			                            	<input class="form-control w100" type="number" value="{if $info.print_number}{$info.print_number}{else}1{/if}" min="1" max="9" name="print_number">
			                            	<span class="help-block">{t domain="printer"}默认设置为1份，最多可设置9份{/t}</span>
			                            </div>
			                        </div>
			                        <div class="form-group m_b30">
			                            <label class="control-label col-lg-5">{t domain="printer"}是否启用此模板{/t}</label>
			                            <div class="col-lg-7">
								            <div class="switch info-toggle-status">
								                <input type="checkbox" {if $info.status eq 1}checked{/if} value="1" name="status" class="onoffswitch-checkbox" id="status">
								                <label class="onoffswitch-label" for="status">
								                    <span class="onoffswitch-inner"></span>
								                    <span class="onoffswitch-switch"></span>
								                </label>
								            </div>
			                            </div>
			                        </div>
			                        <div class="form-group m_b30">
			                            <label class="control-label col-lg-5">{t domain="printer"}是否开启自动打印{/t}</label>
			                            <div class="col-lg-7">
			                            	<div class="switch info-toggle-auto-print">
								                <input type="checkbox" {if $info.auto_print eq 1}checked{/if} value="1" name="auto_print" class="onoffswitch-checkbox" id="auto_print">
								                <label class="onoffswitch-label" for="auto_print">
								                    <span class="onoffswitch-inner"></span>
								                    <span class="onoffswitch-switch"></span>
								                </label>
								            </div>
			                            </div>
			                        </div>
			                        
			                        <div class="form-group m_b0">
			                            <label class="control-label col-lg-5">{t domain="printer"}自定义尾部信息{/t}</label>
			                            <div class="col-lg-12 m_t10">
			                            	<textarea class="form-control tail_textarea" name="tail_content">{$info.tail_content}</textarea>
			                            	<span class="help-block">{t domain="printer" 1="<xmp><br/></xmp>"}如需换行，可在输入框中使用%1字符{/t}</span>
			                            </div>
			                        </div>
			                        
			                        <div class="form-group">
			                        	<div class="col-lg-12">
			                                <input class="btn btn-info" type="submit" value='{t domain="printer"}保存打印模板{/t}'>
			                                <a class="btn btn-info m_l10 print_test" data-url="{$print_order_ticker}" data-type="{$smarty.get.type}">{t domain="printer"}打印测试{/t}</a>
			                            </div>
			                        </div>
			                  	</form>
							</div>
						</div>
					</div>
            	</div>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
