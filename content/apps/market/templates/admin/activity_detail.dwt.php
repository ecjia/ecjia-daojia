<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.activity.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
			<div class="tabbable">
		  		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
					<div class="func-detail">
						<p class="m_b15 title-size">{t domain="market"}功能详情{/t}</p>
						<div class="detail">
							<div class="func-detail-margin">
								{if $info}
									<a class="ajaxremove f_r btn btn-danger activity-open-btn" data-toggle="ajaxremove" data-msg='{t domain="market" 1=$activity_detail.name }您确定要关闭营销活动【%1】吗？{/t}' href='{url path="market/admin/close_activity" args="code={$activity_detail.code}"}' title='{t domain="market"}关闭{/t}'>{t domain="market"}关闭{/t}</a>
								{else}
									<a class="ajaxremove f_r btn btn-gebo activity-open-btn" data-toggle="ajaxremove" data-msg='{t domain="market" 1=$activity_detail.name }您确定要开通营销活动【%1】吗？{/t}' href='{url path="market/admin/open_activity" args="code={$activity_detail.code}"}' title='{t domain="market"}开通{/t}'>{t domain="market"}开通{/t}</a>
								{/if}
								<div class="fonticon-container">
									<div class="fonticon-img-wrap">
										<img class="activity-icon" src="{if $activity_detail.icon}{$activity_detail.icon}{else}{$images_url}extend.png{/if}"/>
									</div>
									<div class="f_l literal-wrap">
										<h3 class="title">{$activity_detail.name}</h3>
										<p class="desc">
											{if $info}{t domain="market"}该功能已开通，设置完活动即可正常使用{/t}{else}<span>{t domain="market"}未开通{/t}</span>{/if}
										</p>
									</div>
								</div>
							</div>
						<!-- {if $info} -->
							<div style="margin-left:30px;">
								<input type="hidden" name="id" value="{$activity_info.activity_id}" />
								<a class="btn btn-gebo data-pjax" href="{$action_edit}">{t domain="market"}编辑活动{/t}</a>
								<a class="btn btn-gebo data-pjax" href="{$action_prize}" style="margin:0px 10px;">{t domain="market"}活动奖品池{/t}</a>
								<a class="btn btn-gebo data-pjax" href="{$action_record}">{t domain="market"}中奖记录{/t}</a>
							</div>
						<!-- {/if} -->
						</div>
					</div>
					<div class="func-intrduction">
						<p class="m_b15 m_t15 title-size">{t domain="market"}功能介绍{/t}</p>
						<p class="intrduction">{$activity_detail.description}</p>
					</div>
				<!-- {if $info} -->
					<div class="func-intrduction">
						<p class="m_b10  title-size">{t domain="market"}活动信息{/t}</p>
					</div>
					<hr>
					<fieldset>
						<div class="control-group formSep">
		                    <label class="control-label">{t domain="market"}活动参与平台：{/t}</label>
		                    <div class="controls l_h30">
			                    <span>{$activity_info.activity_object}</span>
		                    </div>
		                </div>
						<div class="control-group formSep">
							<label class="control-label">{t domain="market"}活动限制：{/t}</label>
							<div class="controls l_h30">
								{if $activity_info.limit_num eq '0'}
									{t domain="market"}在整个活动时间段可参与{/t}<span style="font-weight: bold;margin-left:5px;margin-right:5px;">{t domain="market"}无数次{/t}</span>
								{elseif $activity_info.limit_num gt '0' && $activity_info.limit_time eq '0'}
                                    {t domain="market"}在整个活动时间段可参与{/t}<span style="font-weight: bold;margin-left:5px;margin-right:5px;">{$activity_info.limit_num}次</span>
								{elseif $activity_info.limit_num gt '0' && $activity_info.limit_time gt '0'}
                                    {t domain="market"}在整个活动时间段每隔{/t}<span style="font-weight: bold;margin-left:5px;margin-right:5px;">{$activity_info.limit_time}{t domain="market"}小时{/t}</span>{t domain="market"}可参与{/t}<span style="font-weight: bold;margin-left:5px;margin-right:5px;">{$activity_info.limit_num}次</span>
								{/if}
							</div>
						</div>
						
						<div class="control-group formSep">
							<label class="control-label">{t domain="market"}活动时间段：{/t}</label>
							<div class="controls l_h30">
								{if $activity_info.formated_start_time neq '' && $activity_info.formated_end_time neq ''}
									{$activity_info.formated_start_time} ~ {$activity_info.formated_end_time}
								{else}
                                    {t domain="market"}暂未设置{/t}
								{/if}
								
							</div>
						</div>
						
						<div class="control-group" >
							<label class="control-label">{t domain="market"}规则描述：{/t}</label>
							<div class="controls l_h30">
								{$activity_info.activity_desc}
							</div>
						</div>
					
					</fieldset>
				</form>
		  	</div>
		<!-- {/if} -->
	  </div>
</div>
<!-- {/block} -->