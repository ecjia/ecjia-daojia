<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.contact_record.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>
</div>
<div class="row-fluid edit-page editpage-rightbar" >
    <div class="span12">
        <form class="form-horizontal" method="post" action="{$form_action}" name="theForm"  data-edit-url="{RC_Uri::url('customer/admin/contact_edit&status')}" >
            <fieldset class="">
                <div class="left-bar move-mod ui-sortable">
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}客户名称：{/t}</label>
                        <div class="controls" style="padding-top:6px;">
                            <strong>{$cus_name}</strong>
                        </div>
                    </div> 
                    <div class="control-group control-group-small formSep" >
                        <label class="control-label">{t}联系内容：{/t}</label>
                        <div class="controls">
                            <textarea class="span10" rows="3" cols="40" name="summary" style="height:120px">{$contact_info.summary}</textarea>
                        	<span class="input-must">*</span>
                        </div>
                    </div>
                    
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}预约时间：{/t}</label>
                        <div class="controls">
                           <input type="text" class="span6 start_date" name="next_time" value="{$contact_info.next_time}" placeholder="预约下次联系时间" />
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}下次目标：{/t}</label>
                        <div class="controls">
                            <textarea class="span10" rows="3" cols="40" name="next_goal" style="height:120px">{$contact_info.next_goal}</textarea>
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label"></label>
                        <div class="controls">
                            <button class="btn btn-gebo"  type="submit">{if $feed_id !=''}更新{else}发布{/if}</button>
                        </div>
                    </div>
                    
                </div>

                <div class="right-bar move-mod ui-sortable">
                	<!-- 其他信息start -->
                    <div class="foldable-list move-mod-group">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle move-mod-head acc-in" data-toggle="collapse" data-target="#other_info">
                                    <strong>{t}相关信息{/t}</strong>
                                </a>
                            </div>
                            <div id="other_info" class="accordion-body in in_visable collapse">
                                <div class="accordion-inner">
                                    <div class="control-group control-group-small" >
    									<label class="control-label">{t}联系类型：{/t}</label>
    									<div class="control">
    										<select class="span8" name="link_type">
    							                <!-- {foreach from=$contact_type_list item=contact_type } -->
    											<option value="{$contact_type.type_id}" {if $contact_type.type_id == $contact_info.link_type}selected{/if}>{$contact_type.type_name}</option>
    											<!-- {/foreach} -->
    										</select>
    									</div>
    								</div> 			  
                                    <div class="control-group control-group-small" >
                                    	<label class="control-label">{t}客户类别：{/t}</label>
                                    	<div class="control">
                                    		<select class="span8" name="customer_type">
                                    			<option value="">请选择...</option>
                                    			<!-- {foreach from=$customer_type_list item=state } -->
                                    			<option  value="{$state.state_id}" {if $state.state_id == $contact_info.state_id}selected{elseif $typeinfo_state_id == $state.state_id}selected{/if}>{$state.state_name}</option>
                                    			<!-- {/foreach} -->
                                    		</select>
                                    	</div>
                                    </div>
    								<div class="control-group control-group-small" >
                                    	<label class="control-label">{t}联系人：{/t}</label>
                                    	<div class="control">
                                    		<select class="span8" name="link_man">
                                                <!-- {foreach from=$linkman_lists item=link } -->
                                    			<option value="{$link.link_id}" data-telphone="{$link.mobile}{if $link.telphone}，{$link.telphone}{/if}" {if $link.link_id == $contact_info.link_man}selected{elseif $feed_id eq ''}selected{/if}>{$link.link_man_name}</option>
                                    			<!-- {/foreach} -->
                                    		</select>
                                    		<span class="input-must">*</span>
                                    	</div>
                                    </div>
                                    <div class="control-group control-group-small" >
                                    	<label class="control-label">{t}联系方式：{/t}</label>
                                    	<div class="control">
                                    		<select class="span8" name="contact_way">
                                                <!-- {foreach from=$contact_way_list item=contact_way } -->
                                    			<option value="{$contact_way.way_id}"  {if $contact_way.way_id == $contact_info.type}selected{/if}>{$contact_way.way_name}</option>
                                    			<!-- {/foreach} -->
                                    		</select>
                                    	</div>
                                    </div>
                                    <div class="control-group control-group-small" >
    									<label class="control-label change-type">{t}联系电话：{/t}</label>
    									<div class="control">
    										<input type="text" name="telphone" class="span8" {if $feed_id eq ''}value="{$mobile_telphone}"{else}value="{$contact_info.telphone|escape}"{/if}/>
    									</div>
    								</div>
    								<div class="control-group control-group-small" >
    									<label class="control-label">{t}联系时间：{/t}</label>
    									<div class="control">
    										<input type="text" name="contact_time" class="span8 end_date" {if $feed_id eq ''}value="{$time}"{else}value="{$contact_info.add_time}"{/if} />
    									</div>
    								</div>
    								<input type="hidden" name="feed_id" value="{$contact_info.feed_id}"/>
        							<input type="hidden" name="customer_id" value="{$id}"/>
        							<input type="hidden" name="types" value="{$type}"/>
        							<input type="hidden" name="page" value="{$page}"/>
        							<input type="hidden" name="keywords" value="{$keywords}"/>
        							<input type="hidden" name="statu" value="{$status}"/>
        							<input type="hidden" name="cus_type" value="{$cus_type}"/>
        							<input type="hidden" name="refer" value="{$refer}"/>
                                </div>
                           </div>
                        </div>
                    </div>
                    <!-- 其他信息end -->
			    </div>
            </fieldset>
        </form>
    </div>
</div>
<div class="foldable-list move-mod-group">
    <div class="accordion-group">
        <div id="" class="accordion-body">
            <table class="table table-striped" style="margin-bottom:0px">
                <thead>
                    <tr>
                        <th class="w100">{t}联系时间{/t}</th>
                        <th class="w50">{t}联系人{/t}</th>
                        <th class="w100">{t}联系电话{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from =$contact_record_list item=list} -->
                    <tr align="center">
                        <td class="center-td">{$list.add_time}</td>
                        <td class="center-td">{if $list.link_man_name}{$list.link_man_name}（{$list.sex_new}）{/if}</td>
                        <td class="center-td">{$list.telphone}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 10px;">{$list.summary}</td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr align="center">
                        <td class="dataTables_empty" colspan="3">{t}暂无任何记录!{/t}</td> 
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- {/block} -->
