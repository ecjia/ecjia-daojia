<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->


<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="highlight_box global icon_wrap group" id="js_apply_btn">
							{if $info}
								<a class="ajaxremove f_r btn btn-danger btn-min-width extend_handle" data-toggle="ajaxremove" data-msg='{t domain="market" 1=$activity_detail.name }您确定要关闭营销活动【%1】吗？{/t}' href='{url path="market/platform/close_activity" args="code={$activity_detail.code}"}' title='{t domain="market"}关闭{/t}'>{t domain="market"}关闭{/t}</a>
							{else}
								<a class="ajaxremove f_r btn btn-success btn-min-width extend_handle" data-toggle="ajaxremove" data-msg='{t domain="market" 1=$activity_detail.name }您确定要开通营销活动【%1】吗？{/t}' href='{url path="market/platform/open_activity" args="code={$activity_detail.code}"}' title='{t domain="market"}开通{/t}'>{t domain="market"}开通{/t}</a>
							{/if}
							<div class="fonticon-container">
								<div class="fonticon-wrap">
									<img class="icon-extend" src="{if $activity_detail.icon}{$activity_detail.icon}{else}{$images_url}extend.png{/if}" />
								</div>
							</div>
							<h4 class="title">{$activity_detail.name}</h4>
							<p class="desc" id="js_status">
								{if $info}{t domain="market"}该功能已开通，设置完活动即可正常使用{/t}{else}<span>{t domain="market"}未开通{/t}</span>{/if}
							</p>
							<!-- {if $info} -->
							<div class="justify-content-center" style="padding-left:75px;padding-top:10px;padding-bottom:10px;">
								<input type="hidden" name="id" value="{$activity_info.activity_id}" />
			                   	<a class="btn btn-outline-primary data-pjax" href="{$action_edit}">{t domain="market"}编辑活动{/t}</a>
								<a class="btn btn-outline-primary data-pjax" href="{$action_prize}" style="margin:0px 10px;">{t domain="market"}活动奖品池{/t}</a>
								<a class="btn btn-outline-primary" href="{$action_record}">{t domain="market"}中奖记录{/t}</a>
							</div>
							<!-- {/if} -->
						</div>
						<div class="carkticket_index">
							<div class="intro">
								<dl>
									<dt><span class="ico_intro ico ico_1 l"></span>
										<h4 class="card-title">{t domain="market"}功能介绍{/t}</h4>
									</dt>
									<dd>{$activity_detail.description}</dd>
								</dl>
							</div>
						</div>
					<!-- {if $info} -->
						<div class="form-body">
							<h4 class="card-title" style="padding-top:13px;">{t domain="market"}活动信息{/t}<hr></h4>
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}活动参与平台：{/t}</label>
								<div class="col-lg-8 controls">
				                    <span>{$activity_info.activity_object}</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}活动限制：{/t}</label>
								<div class="col-lg-8 controls">
									{if $activity_info.limit_num eq '0'}
                                        {t domain="market"}在整个活动时间段可参与{/t}<span class="span-font">{t domain="market"}无数次{/t}</span>
									{elseif $activity_info.limit_num gt '0' && $activity_info.limit_time eq '0'}
                                        {t domain="market"}在整个活动时间段可参与{/t}<span class="span-font">{$activity_info.limit_num}次</span>
									{elseif $activity_info.limit_num gt '0' && $activity_info.limit_time gt '0'}
                                        {t domain="market"}在整个活动时间段每隔{/t}<span class="span-font">{$activity_info.limit_time}小时</span>{t domain="market"}可参与{/t}<span style="font-weight: bold;margin-left:5px;margin-right:5px;">{$activity_info.limit_num}{t domain="market"}次{/t}</span>
									{/if}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="market"}活动时间段：{/t}</label>
								<div class="col-lg-8 controls">
									{if $activity_info.formated_start_time neq '' && $activity_info.formated_end_time neq ''}
										{$activity_info.formated_start_time}<pre style="display:inline;"> ~ </pre>{$activity_info.formated_end_time}
									{else}
                                        {t domain="market"}暂未设置{/t}
									{/if}
								</div>
							</div>
							
						</div>
					</div>
				<!-- {/if} -->
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->