<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.admin_record.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
</div>
<!-- {/if} -->

<!-- {if $warn && $type eq 0} -->
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
<!-- {/if} -->

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
            <div class="col-lg-12 card-body">
				<div class="chat_box row" data-url='{$chat_action}' style="padding-left:15px;">
					<div class="col-xl-8 col-lg-12 chat_content h550">
						<div class="card">
							<div class="card-header popover-header">
								<h4 class="card-title">{t domain="wechat"}交谈用户：{/t}<span class="act_users">{$info.nickname}</span></h4>
							</div>
							<div class="card-content collapse show popover-body">
								<div class="chat_msg clearfix">
									<div class="chat_msg_heading t_c"><a class="readed_message" href="javascript:;" data-chatid="{$info.openid}" data-lastid="{$message.last_id}" data-href="{$last_action}">{t domain="wechat"}查看更早的消息记录{/t}</a></div>
								</div>
								<div class="card-body">
									<div class="chat_msg media-list">
										<!-- {foreach from=$message.item item=msg} -->
										<div class="media {if $msg.opercode eq 2003} chat-msg-you{else if $msg.opercode eq 2002} chat-msg-mine{/if} last_chat">
											<div class="media-body">
												<h5 class="media-heading"><span class="chat_msg_date">{$msg.time}</span><span class="chat_user_name">{if $msg.opercode eq 2003}{$msg.nickname}{else if $msg.opercode eq 2002}{$msg.kf_account}{/if}</span></h5>
												<h5 class="media-text {if $msg.opercode eq 2003}text-left{/if}">{$msg.text}</h5>
											</div>
										</div>
										<!-- {/foreach} -->
										<div class="media msg_clone chat-msg-you" style="display:none">
											<div class="media-body">
												<h5 class="media-heading"><span class="chat_msg_date"></span><span class="chat_user_name"></span></h5>
												<h5 class="media-text"></h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="col-xl-4 col-lg-12">
						<div class="card info_content h550">
							<div class="card-header popover-header">
								<h4 class="card-title">{t domain="wechat"}用户信息{/t}</h4>
							</div>
							<div class="card-body popover-body">
								<div class="form-body">
									<div class="form-group row p_t20">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}用户头像：{/t}</label>
										<div class="col-md-7 controls">
											{if $info['headimgurl']}
												<img class="thumbnail" src="{$info['headimgurl']}" alt="{$info['nickname']}"/>
											{else}
												<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
											{/if}
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}昵称：{/t}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info.nickname}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}备注名：{/t}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">
												<span class="remark_info p_r5">{$info.remark}</span>
											</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}性别：{/t}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{if $info['sex'] == 1}{t domain="wechat"}男{/t}{else if $info.sex == 2}{t domain="wechat"}女{/t}{/if}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}省-市：{/t}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info['province']} - {$info['city']}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}用户组：{/t}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">
												<!-- {foreach from=$group_list item=val} -->
													<!-- {if $val.group_id eq $info.group_id} -->
														<span class="group_info p_r5">{$val.name}</span>
													<!-- {/if} -->
												<!-- {/foreach} -->
											</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{t domain="wechat"}关注时间：{/t}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info['subscribe_time']}</span>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->