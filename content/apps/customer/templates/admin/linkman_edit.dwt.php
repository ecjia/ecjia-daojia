<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.linkman.init();
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
        <form class="form-horizontal" method="post" action="{$form_action}" name="theForm"  data-edit-url="{RC_Uri::url('customer/admin/linkman_edit')}" >
            <fieldset class="">
                <div class="left-bar move-mod ui-sortable">
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}联系人：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="link_man_name" value="{$linkman_info.link_man_name}" />
                            <span class="input-must">*</span>
                        </div>
                    </div> 
                    <div class="control-group control-group-small">
                        <label class="control-label">{t}性别：{/t}</label>
                        <div class="controls chk_radio">
                                    <input type="radio" name="sex" value="0" {if $linkman_info.sex eq 0} checked="true" {/if} style="opacity: 0;">
                            <span>男</span>
                                    <input type="radio" name="sex"  value="1" {if $linkman_info.sex eq 1} checked="true" {/if}  style="opacity: 0;">
                            <span>女</span>
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}手机：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="mobile" value="{$linkman_info.mobile}" />
                            <span class="input-must">*</span>
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}固定电话：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="telphone" value="{$linkman_info.telphone}" />

                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}邮箱：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="email" value="{$linkman_info.email}" />
                            <span class="input-must">*</span>
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}QQ/旺旺：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="qq" value="{$linkman_info.qq}" />

                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}微信：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="wechat" value="{$linkman_info.wechat}" />

                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}备注：{/t}</label>
                        <div class="controls">
                            <textarea class="span10" rows="3" cols="40" name="summary" style="height:80px">{$linkman_info.summary}</textarea>
                        </div>
                    </div>
                    
                </div>

                <div class="right-bar move-mod ui-sortable">
                	<!-- 其他信息start -->
                    <div class="foldable-list move-mod-group">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle move-mod-head acc-in" data-toggle="collapse" data-target="#other_info">
                                    <strong>{t}其他信息{/t}</strong>
                                </a>
                            </div>
                            <div id="other_info" class="accordion-body in in_visable collapse">
                                <div class="accordion-inner">
                                    <div class="control-group control-group-small" >
    									<label class="control-label">{t}所在部门：{/t}</label>
    									<div class="control">
    										<input type="text" name="department" class="span8"  value="{$linkman_info.department|escape}"/>
    									</div>
    								</div>
    								<div class="control-group control-group-small" >
    									<label class="control-label">{t}当前职位：{/t}</label>
    									<div class="control">
    										<input type="text" name="duty" class="span8"  value="{$linkman_info.duty|escape}"/>
    									</div>
    								</div>
    								<div class="control-group control-group-small" >
										<label class="control-label">{t}出生日期：{/t}</label>
										<div class="control">
											<input type="text" name="birthday" class="span4 date" style="float:left;" value="{$linkman_info.birthday|escape}" />
											<label for="gongli" class="control-label" style="width:60px">
												<input type="radio" id="gongli" name="birth_type" value="0" {if $linkman_info.birth_type eq 0} checked="true" {/if} style="opacity: 0;">{t}公历{/t}
											</label>
											<label for="yingli" class="control-label" style="width:55px">
												<input type="radio" id="yingli" name="birth_type"  value="1" {if $linkman_info.birth_type eq 1} checked="true" {/if}  style="opacity: 0;">{t}农历{/t}
											</label>
										</div>
									</div>
    								<input type="hidden" name="id" value="{$id}" />
    								<input type="hidden" name="link_id" value="{$linkman_info.link_id}" />
    								<input type="hidden" name="types" value="{$type}"/>
        							<input type="hidden" name="page" value="{$page}"/>
        							<input type="hidden" name="keywords" value="{$keywords}"/>
        							<input type="hidden" name="statu" value="{$status}" />
        							<button class="btn btn-gebo"  type="submit">{if $link_id !=''}更新{else}发布{/if}</button>
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

<!-- {/block} -->
