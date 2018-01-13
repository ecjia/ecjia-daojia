<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

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
	<div class="span3">
		<!-- {ecjia:hook id=display_admin_store_menus} -->
	</div>
  	<div class="span9">
      	<div class="shipping-template-info">
            <div class="tab-pane active">
                <form class="form-horizontal" >
                    <fieldset>
                        <div class="control-group formSep">
                            <label class="control-label">模版名称：</label>
                            <div class="controls l_h30">
                                {$template_name}
                                <span class="help-block">该名称只在运费模板列表显示，便于管理员查找模板</span>
                            </div>
                        </div>
                        <div class="control-group formSep">
                            <label class="control-label">地区设置：</label>
                            <div class="controls">
                            	<div class="template-info-item">
									<div class="template-info-head">
										<div class="head-left">配送至</div>
									</div>
									<div class="template-info-content">
										<div class="content-area" {if $regions}style="display:block"{/if}>
											<ul class="content-area-list" {if $regions}style="display:block"{/if}>
												<!-- {if $regions} -->
													<!-- {foreach from=$regions item=val} -->
													<li><input type="hidden" value="{$val.region_id}" name="regions[]" id="regions_{$val.region_id}"/>{$val.region_name}</li>
													<!-- {/foreach} -->
												<!-- {/if} -->
											</ul>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">快递方式：</label>
                            <div class="controls">
                                <div class="template-info-item">
									<div class="template-info-head">
										<div class="head-left">快递方式</div>
									</div>
									<div class="template-info-shipping">
										<!-- {foreach from=$data item=list} -->
										<div class="info-shipping-item shipping-item-{$list.shipping_id}">
											<div class="info-shipping-left">
											{$list.shipping_name}
											<!-- {if $list.shipping_code != 'ship_cac'} -->：
												<!-- {foreach from=$list.fields name=f item=field} -->
													<input type="hidden" name="{$field.name}" value="{if $field.value}{$field.value}{else}0{/if}" />
													<!-- {if $list.fee_compute_mode == 'by_number'} -->
														<!--{if $field.name == 'item_fee' || $field.name == 'free_money' || $field.name == 'pay_fee'}-->
															{$field.label}（{if $field.value}{$field.value}{else}0{/if}）{if !$smarty.foreach.f.last}，{/if}
														<!-- {/if} -->
													<!--{else}-->
														<!--{if $field.name != 'item_fee' && $field.name != 'fee_compute_mode'}-->
															{$field.label}（{if $field.value}{$field.value}{else}0{/if}）{if !$smarty.foreach.f.last}，{/if}
														<!-- {/if} -->
													<!-- {/if} -->
												<!-- {/foreach} -->
											<!-- {/if} -->
											</div>
										</div>
										<!-- {/foreach} -->
									</div>
								</div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
 	</div>
</div>

<!-- {/block} -->