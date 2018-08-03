<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.mass_message.init();
	ecjia.platform.choose_material.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $warn && $type eq 0}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
 	<div class="alert alert-danger">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<p>该接口暂时仅提供给已微信认证的服务号</p>
	<p>用户每月只能接收4条群发消息，多于4条的群发将对该用户发送失败。</p>
	<p>群发图文消息的标题上限为64个字节,群发内容字数上限为1200个字符、或600个汉字。</p>
	<p>在返回成功时，意味着群发任务提交成功，并不意味着此时群发已经结束，所以，仍有可能在后续的发送过程中出现异常情况导致用户未收到消息，如消息有时会进行审核、服务器不稳定等。此外，群发任务一般需要较长的时间才能全部发送完毕，请耐心等待。</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
     		<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
            
            <div class="card-body">
            	<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link data-pjax active" href='#tab1' data-toggle="tab">{lang key='wechat::wechat.send_message'}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax" href='{url path="wechat/platform_mass_message/mass_list"}'>{lang key='wechat::wechat.send_record'}</a>
					</li>
				</ul>
			</div>
            <div class="col-md-12">
            	<div class="alert alert-info">
					<a class="close" data-dismiss="alert">×</a>
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.mass_notice_info'}
				</div>
            </div>
            
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_mass_type'}</label>
								<div class="col-lg-8 controls">
									<div class="select_type f_l">
										<select name="mass_type" class="w130 select2 form-control">
											<option value="all">{lang key='wechat::wechat.all_user'}</option>
											<option value="by_group">{lang key='wechat::wechat.by_group'}</option>
						                </select>
					                </div>
					                
					                <div class="by_group d-none m_l10 f_l">
										<select name="tag_id" class="select2 w130 form-control">
						                    <!-- {foreach from=$list item=val} -->
						                    <option value="{$val['tag_id']}">{$val['name']}</option>
						                    <!-- {/foreach} -->
						                </select>
					                </div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">
									{lang key='wechat::wechat.label_select_material'}
								</label>
								<div class="col-lg-8 controls material-table">
									<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
										<li class="nav-item" data-type="news">
											<a class="nav-link active" data-toggle="tab" title="{lang key='wechat::wechat.text_message'}"><i class="fa fa-list-alt"> 图文</i></a>
										</li>
										<li class="nav-item" data-type="text">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.text'}"><i class="fa fa-pencil"> 文字</i></a>
										</li>
										<li class="nav-item" data-type="image">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.image'}"><i class="fa fa-file-image-o"> 图片</i></a>
										</li>
										<li class="nav-item" data-type="voice">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.voice'}"><i class="fa fa-music"> 语音</i></a>
										</li>
										<li class="nav-item" data-type="video">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.video'}"><i class="fa fa-video-camera"> 视频</i></a>
										</li>
									</ul>
			                   		<div class="text m_b10">
			                   			<textarea class="m_t10 span12 form-control" name="content" cols="40" rows="5" id="chat_editor" style="display:none;"></textarea>
										<div class="js_appmsgArea" style="display:block;">
											<div class="tab_cont_cover create-type__list">
												<div class="create-type__item">
													<a href="javascript:;" class="create-type__link choose_material" data-type="news" data-url="{RC_Uri::url('wechat/platform_material/choose_material')}&material=1">
														<i class="create-type__icon file"></i>
														<strong class="create-type__title">从素材库选择</strong>
													</a>
												</div>
											</div>
										</div>
			                    	</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="content_type" value="news">
						<input type="hidden" name="preview_url" value="{RC_Uri::url('wechat/platform_mass_message/preview_msg')}">
						<input type="submit" class="btn btn-outline-primary" value="{lang key='wechat::wechat.send_msg'}" {if $errormsg}disabled="disabled"{/if}/>
						<input type="button" class="btn btn-outline-primary preview_msg" value="预览" {if $errormsg}disabled="disabled"{/if}/>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {include file="./library/wechat_choose_material.lbi.php"} -->
<!-- {include file="./library/wechat_preview_msg.lbi.php"} -->

<!-- {/block} -->