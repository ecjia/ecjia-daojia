<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.shipTemplate.init_template_1();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="admin_shipping">
	<div>
		<h3 class="heading">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			{if $action_link}
			<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
			{/if}
		</h3>
	</div>

	<div class="edit-page">
		<table id="general-table" class="w900">
			<tr>
				<td colspan="2" class="chk_radio">
					<span><strong>{lang key='shipping::shipping.select_template_mode'}</strong></span>
					<input type="radio" name="model" class="uni_style" id="model_1" value="1" {if $shipping.print_model == 1}checked="checked"{/if} onclick="javascript:ecjia.admin.shipTemplate.template_radio_click('1');"><span>{lang key='shipping::shipping.code_mode'}</span>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="model" class="uni_style" id="model_2" value="2" {if $shipping.print_model == 2}checked="checked"{/if} onclick="javascript:ecjia.admin.shipTemplate.template_radio_click('2');"><span>{lang key='shipping::shipping.income_model'}</span>
					<span class="help-block cl_both" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeGoodsSN">{lang key='shipping::shipping.mode_notice'}</span>
				</td>
			</tr>
			<tr id="visual" {if $shipping.print_model == 1}style="display:none"{else} style="display:block" {/if}>
				<td colspan="2" style="display: inherit;">
					<!--Flash播放器 start-->
					{assign var=goods_desc_src value=RC_Uri::url('shipping/admin/print_index',"shipping_id={$shipping_id}")}
					<iframe id="goods_desc___Frame" src="{$goods_desc_src}" width="100%" height="800" frameborder="0" ></iframe>
					<!--Flash播放器 end-->
				</td>
			</tr>
			<tr>
				<td>
					{assign var=form_action value=RC_Uri::url('shipping/admin/do_edit_print_template')}
					<form class="form-horizontal" method="post" name="templateForm_1" action="{$form_action}">
						<input type="hidden"  name="shipping_id" value="{$shipping.shipping_id}">
						<fieldset>
							<div class="formSep">
								<table id="general-table" >
									<tr id="code_shipping_help" {if $shipping.print_model == 2}style="display:none"{/if}>
										<td width="75%"> 						    			
											<div class="foldable-list">
												<div class="accordion-group">
													<div class="accordion-heading">
														<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1"><strong>{lang key='shipping::shipping.shipping_template_info_t'}</strong></a>
													</div>
													<div class="accordion-body in collapse" id="telescopic1">
														<div class="accordion-inner">
															<div class="control-group " >
																<div style=" float: left;width:30%;margin-left:10px;">{lang key='shipping::shipping.shipping_template_info_l'}
																</div>
																<div  style=" float: left;width:30%;margin-left:10px;">{lang key='shipping::shipping.shipping_template_info_c'}
																</div>
																<div  style=" float: left;width:30%;margin-left:10px;">{lang key='shipping::shipping.shipping_template_info_r'}
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr id="code_shipping_print" {if $shipping.print_model == 2}style="display:none"{/if}>
										<td><textarea class="span9" id="shipping_print" name="shipping_print" rows="20" cols="100" >{$shipping.shipping_print|escape:html}</textarea></td>
									</tr>
								</table>
							</div>
							<div class="control-group" id="code_submit" {if $shipping.print_model == 2}style="display:none"{/if}>
								<div class="controls" >
									<button class="btn btn-gebo" type="button" id="save_template_1">{lang key='system::system.button_submit'}</button>
									<input type="hidden" name="print_model" value="1">
									<input type="hidden" name="shipping_name" value="{$shipping.shipping_name}">
								</div>
							</div>
						</fieldset>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<!-- {/block} -->