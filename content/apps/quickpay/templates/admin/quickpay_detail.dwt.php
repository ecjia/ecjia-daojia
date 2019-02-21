<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.quickpay_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>{/if}
	</h3>
</div>

<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" data-edit-url="{url path='user/admin/edit'}" >
	<fieldset>
		<div class="row-fluid editpage-rightbar edit-page">
			<div class="left-bar">
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}买单名称：{/t}</label>
					<div class="controls">
						<input type="text" name="title" id="title" value="{$data.title}" class="w350" disabled="disabled" />
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}买单描述：{/t}</label>
					<div class="controls">
						<textarea name="description" id="description" class="w350" disabled="disabled">{$data.description}</textarea>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}买单优惠类型：{/t}</label>
					<div class="controls">
						<select name='activity_type' id="activity_type" class="w350"  disabled="disabled">
							<!-- {foreach from=$type_list item=list key=key} -->
							<option value="{$key}" {if $key eq $data.activity_type}selected="selected"{/if}>{$list}</option>
							<!-- {/foreach} -->
						</select>
					</div>
				</div>
				
				<div id="activity_type_discount" {if $data.activity_type neq 'discount'}style="display:none"{/if}>
					<div class="control-group formSep">
                        <label class="control-label">{t domain="quickpay"}折扣价：{/t}</label>
                        <div class="controls">
                            <input class="w350" type="text" name="activity_discount_value" value="{$data.activity_value}" disabled="disabled" />
                            <span class="help-block">{t domain="quickpay"}如：打9折，请输入90{/t}</span>
                        </div>
                    </div>
				</div>
				
				<div id="activity_type_reduced" {if $data.activity_type neq 'reduced'}style="display:none"{/if}>
					<div class="control-group formSep">
                        <label class="control-label">{t domain="quickpay"}满金额：{/t}</label>
                        <div class="controls">
                            <div class="controls-split">
                                <div class="ecjiaf-fl wright_wleft">
                                    <input name="activity_value[]" class="span12" type="text" placeholder='{t domain="quickpay"}消费达到的金额{/t}' value="{$data.activity_value.0}" disabled="disabled" />
                                </div>
                                <div class="ecjiaf-fl p_t5 wmidden">{t domain="quickpay"}减{/t}</div>
                                <div class="ecjiaf-fl wright_wleft">
                                    <input name="activity_value[]" class="span12" type="text" placeholder='{t domain="quickpay"}优惠金额{/t}' value="{$data.activity_value.1}" disabled="disabled" />
                                </div>
                        	</div>
                        </div>
                    </div>
				</div>
				
				<div id="activity_type_everyreduced" {if $data.activity_type neq 'everyreduced'}style="display:none"{/if}>
					<div class="control-group formSep">
                        <label class="control-label">{t domain="quickpay"}每满金额：{/t}</label>
                        <div class="controls">
                            <div class="controls-split">
                                <div class="ecjiaf-fl wright_wleft">
                                    <input name="activity_value[]" class="span12" type="text" placeholder='{t domain="quickpay"}消费达到的金额{/t}' value="{$data.activity_value.0}" disabled="disabled" />
                                </div>
                                <div class="ecjiaf-fl p_t5 wmidden">{t domain="quickpay"}减{/t}</div>
                                <div class="ecjiaf-fl wright_wleft">
                                    <input name="activity_value[]" class="span12" type="text" placeholder='{t domain="quickpay"}优惠金额{/t}' value="{$data.activity_value.1}" disabled="disabled"/>
                                </div><br><br>
                                
                                <div class="ecjiaf-fl p_t5">{t domain="quickpay"}最高减：{/t}</div>
                                
                                <div class="ecjiaf-fl wright_wleft">
                                    <input name="activity_value[]" style="width: 299px;"type="text" placeholder='{t domain="quickpay"}优惠金额{/t}' value="{$data.activity_value.2}" disabled="disabled" />
                                </div>
                        	</div>
                        </div>
                      </div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}具体时间：{/t}</label>
					<div class="controls">
						 <select name="limit_time_type" id="limit_time_type" class="w350" disabled="disabled">
							<option value='nolimit' {if $data.limit_time_type eq 'nolimit'}selected{/if}>{t domain="quickpay"}不限制时间{/t}</option>
							<option value='customize' {if $data.limit_time_type eq 'customize'}selected{/if}>{t domain="quickpay"}自定义时间{/t}</option>
						</select>
					</div>
				</div>
				
				 <div id="limit_time_type_customize" {if $data.limit_time_type neq 'customize'}style="display:none"{/if}>
                 	<div class="control-group formSep">
						<label class="control-label">{t domain="quickpay"}每天限天：{/t}</label>
						<div class="controls" style="width:330px;">
							 <!-- {foreach from=$week_list key=key item=val} -->
								<input type="checkbox" name="limit_time_weekly[]" value="{$val}"  id="{$val}" {if in_array($val, $data.limit_time_weekly)}checked="true"{/if} disabled="disabled"/>{$key}
							 <!-- {/foreach} -->
							 <span class="help-block">{t domain="quickpay"}勾选星期一，则表示一周中只有星期一可以使用，可多选。{/t}</span>
						</div>
					</div>
					
                    <div class="control-group formSep">
						<label class="control-label">{t domain="quickpay"}每天限时：{/t}</label>
						<div class="controls">
							<!-- {foreach from=$data.limit_time_daily item=daily_time name=daily} -->
								<div class='time-picker'>
									{t domain="quickpay"}从{/t}&nbsp;&nbsp;<input placeholder='{t domain="quickpay"}开始时间{/t}' class="w100 form-control tp_1" name="start_ship_time[]" type="text" value="{$daily_time.start}" autocomplete="off" disabled="disabled" />&nbsp;&nbsp;
									{t domain="quickpay"}至{/t}&nbsp;&nbsp;<input placeholder='{t domain="quickpay"}结束时间{/t}' class="w100 form-control tp_1" name="end_ship_time[]" type="text" value="{$daily_time.end}" autocomplete="off" disabled="disabled" />
								</div> 
							<!-- {/foreach} -->   
							<span class="help-block">{t domain="quickpay"}例如，如果开始时间设9点，结束时间设12点，则表示每天9点到12点时段才可使用此优惠{/t}</span>
						</div>
					</div>
                    
					<div class="control-group formSep">
                        <label class="control-label">{t domain="quickpay"}限制日期：{/t}</label>
                        <div class="controls">
                        	<!-- {foreach from=$data.limit_time_exclude item=exclude_time name=exclude} -->
							<div class='date-picker'>
                                <input name="limit_time_exclude[]" class="form-control date w200" type="text" placeholder='{t domain="quickpay"}请选择日期{/t}' value="{$exclude_time}" disabled="disabled"/>
							</div> 
							<!-- {/foreach} -->   
                             <span class="help-block">{t domain="quickpay"}选择某天时间内不可使用买单功能，可增加多个日期{/t}</span>
                        </div>
                    </div>
				</div>
									
				<div class="control-group formSep">
					<label class="control-label">{t domain="quickpay"}有效时间：{/t}</label>
					<div class="controls">
						<div class="controls-split">
							<div class="ecjiaf-fl wright_wleft">
								 <input name="start_time" class="date span12" type="text" placeholder='{t domain="quickpay"}请输入开始时间{/t}' value="{$data.start_time}" disabled="disabled" />
							</div>
							<div class="ecjiaf-fl p_t5 wmidden">{t domain="quickpay"}至{/t}</div>
							<div class="ecjiaf-fl wright_wleft">
								<input name="end_time" class="date span12" type="text" placeholder='{t domain="quickpay"}请输入结束时间{/t}' value="{$data.end_time}" disabled="disabled" />
							</div>
						</div>
					</div>
				</div>
	
				<div class="control-group">
					<label class="control-label">{t domain="quickpay"}是否开启：{/t}</label>
					<div class="controls">
			            <div class="info-toggle-button">
			                <input class="nouniform" name="comment_check" type="checkbox" {if $data.enabled eq 1}checked="checked"{/if}  value="1" disabled="disabled" />
			            </div>
					</div>
				</div>
			</div>

			
			<div class="right-bar move-mod">
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#telescopic1">
								<strong>{t domain="quickpay"}红包优惠{/t}</strong>
							</a>
						</div>
						<div class="accordion-body in in_visable collapse" id="telescopic1">
							<div class="accordion-inner">
								<div class="control-group-small">
							    	<span class="f_l w180 t_l l_h30">{t domain="quickpay"}是否允许同时使用红包抵现：{/t}</span>
									<div class="info-toggle-button" style="margin-left:32px;">
						                <input class="nouniform"  type="checkbox" {if $data.use_bonus neq 'close'}checked="checked"{/if} disabled="disabled" />
						            </div>	
				  					<div class="edit-page">
										<select name="use_bonus_select" id="use_bonus_select" class="w300" disabled="disabled">
										 	<option value="nolimit" {if $data.use_bonus eq 'nolimit'}selected{/if}>{t domain="quickpay"}全部红包{/t}</option>
											<option value="bonus_id" {if $act_range_ext}selected{/if}>{t domain="quickpay"}指定红包{/t}</option>
								        </select>
									</div>
									<div class="m_t10">
								        <input name="keyword" class="form-control" type="text" id="keyword" placeholder='{t domain="quickpay"}请输入关键词进行搜索{/t}' disabled="disabled" />
								        <button class="btn" type="button" id="search" disabled="disabled"><i class='fa fa-search'></i> {t domain="quickpay"}搜索{/t}</button>
							        </div>
								    <span class="help-block">
								  		 {t domain="quickpay"}当红包优惠设为“指定红包”时，需要输入关键词搜索并且设置指定红包， 如果优惠设为“不指定红包”则不需要设置。{/t} 
								    </span>
									<ul id="range-div" style="display:block;">
								        <!-- {foreach from=$act_range_ext item=item} -->
								        <li>
								            <input name="act_range_ext[]" type="hidden" value="{$item.type_id}" />
								            {$item.type_name}
								            <i class="fontello-icon-minus-circled ecjiafc-red"></i>
								        </li>
								        <!-- {/foreach} -->
								    </ul>
								    	    	
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#telescopic2">
								<strong>{t domain="quickpay"}积分优惠{/t}</strong>
							</a>
						</div>
						<div class="accordion-body in in_visable collapse" id="telescopic2">
							<div class="accordion-inner">
								<div class="control-group-small">
							    	<span class="f_l w180 t_l l_h30">{t domain="quickpay"}是否允许同时使用积分抵现：{/t}</span>
									<div class="info-toggle-button" style="margin-left:32px;">
						                <input class="nouniform" type="checkbox" {if $data.use_integral neq 'close'}checked="checked"{/if} disabled="disabled" />
						            </div> 	
				  					<div class="edit-page">
										<select name="use_integral_select" id="use_integral_select" class="w300" disabled="disabled">
											<option value="nolimit" {if $data.use_integral eq 'close' || $data.use_integral eq 'nolimit'}selected{/if}>{t domain="quickpay"}不限制积分{/t}</option>
										 	<option value="integral"{if $data.use_integral neq 'close' && $data.use_integral neq 'nolimit'}selected{/if}>{t domain="quickpay"}限制积分{/t}</option>
								        </select>
									</div>
									<div class="m_t10">
							        	<input name="integral_keyword" class="form-control" type="text" value="{if $data.use_integral eq 'close' || $data.use_integral eq 'nolimit'}0{else}{$data.use_integral}{/if}"  id="integral_keyword" disabled="disabled"/>
							        </div>
								    <span class="help-block">
								    	{t domain="quickpay"}当积分优惠设为“限制积分”时，可设置最大可用积分数与优惠同时使用， 数量为0时则是不限制，如果选择“不限制积分”则不需要设置。{/t}
								    </span>	    	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
</form>
<!-- {/block} -->