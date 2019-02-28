<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.config.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid">
    <div class="row-fluid">
        <form class="form-horizontal" action="{$form_action}" name="theForm" method="post" enctype="multipart/form-data">
			<fieldset>
				<!-- {if $code eq basic_info} -->
					<h3 class="heading">{t domain="mobile"}基本信息{/t}</h3>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动应用名称：{/t}</label>
						<div class="controls">
							<input type="text" name="mobile_app_name" value="{$mobile_app_name}">
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动应用Logo：{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_app_icon}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_app_icon}" alt="{t domain="mobile"}暂无图片{/t}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
								<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
								<input type="file" name="mobile_app_icon"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg='{t domain="mobile"}您确定要删除此文件吗？{/t}' data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_icon')}" {if $mobile_app_icon}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动应用版本号：{/t}</label>
						<div class="controls">
							<input type="text" name="mobile_app_version" value="{$mobile_app_version}">
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动应用简介：{/t}</label>
						<div class="controls">
							<textarea class="span12 h100" name='mobile_app_description'>{$mobile_app_description}</textarea>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动应用视频地址：{/t}</label>
						<div class="controls">
							<input type="text" name="mobile_app_video" value="{$mobile_app_video}" />
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}红包使用说明：{/t}</label>
						<div class="controls">
							<select name='bonus_readme' class="artilce_list">
								<!-- {if !$bonus_readme.title} -->
									<option value='-1'>{t domain="mobile"}请选择...{/t}</option>
								<!-- {else} -->
									<option value="{$bonus_readme.id}">{$bonus_readme.title}</option>
								<!-- {/if} -->
							</select>
							<input type='text' name='article_search' class='m_l5 keywords'/>
							<input type='button' class='btn article_search' value='{t domain="mobile"}搜索{/t}' data-url="{url path='mobile/admin_config/search_article'}"/>
							<span class="help-block">{t domain="mobile"}请选择一篇文章，作为您的红包使用说明{/t}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}请选择一篇文章，作为您的红包使用说明咨询默认回复设置：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_feedback_autoreply' value='{$mobile_feedback_autoreply}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}PC商城地址：{/t}</label>
						<div class="controls">
							<input type='text' name='shop_pc_url' value='{$shop_pc_url}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}WAP/H5商城地址：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_touch_url' value='{$mobile_touch_url}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}分享连接：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_share_link' value='{$mobile_share_link}'>
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}新人有礼红包：{/t}</label>
						<div class="controls">
							<select name="mobile_signup_reward">
								<option value="0">{t domain="mobile"}请选择...{/t}</option>
								<!-- {foreach from=$bonus_type_list item=list} -->
									<option value="{$list.type_id}" {if $mobile_signup_reward eq $list.type_id}selected="true"{/if}>{$list.type_name}</option>	
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}新人有礼说明：{/t}</label>
						<div class="controls">
							<textarea name="mobile_signup_reward_notice" class="span7">{$mobile_signup_reward_notice}</textarea>
						</div>
					</div>
					
				<!-- 登录色值start -->
					<h3 class="heading">{t domain="mobile"}手机端登录页设置{/t}</h3>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}手机端登录页前景色：{/t}</label>
						<div class="controls">
							<div class="input-append color" data-color="{$mobile_phone_login_fgcolor}">
								<input class="w100" name="mobile_phone_login_fgcolor" type="text" value="{$mobile_phone_login_fgcolor}">
								<span class="add-on">
									<i class="dft_color" style='margin-top: 2px;'></i>
								</span>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}手机端登录页背景色：{/t}</label>
						<div class="controls">
							<div class="input-append color" data-color="{$mobile_phone_login_bgcolor}">
								<input class="w100" name="mobile_phone_login_bgcolor" type="text" value="{$mobile_phone_login_bgcolor}">
								<span class="add-on">
									<i class="dft_color" style='margin-top: 2px;'></i>
								</span>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}手机端登录页背景图片：{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_phone_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_phone_login_bgimage}" alt='{t domain="mobile"}暂无图片{/t}' />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
								<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
								<input type="file" name="mobile_phone_login_bgimage"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg='{t domain="mobile"}您确定要删除此文件吗？{/t}' data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_phone_login_bgimage')}" {if $mobile_phone_login_bgimage}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>
				<!-- 登录色值end -->
				
				<!-- iOS智能广告条start -->
					<h3 class="heading">{t domain="mobile"}iOS智能广告条{/t}</h3>
					<div class="control-group formSep">
						<label class="control-label">App Store ID</label>
						<div class="controls">
							<input type='text' name='app_store_id' value='{$app_store_id}'>
							<span class="help-block">{t domain="mobile" escape=no}Apple应用商城中的应用程序ID。可以从<a href="https://linkmaker.itunes.apple.com/" target="_blank">iTunes Link Maker</a>中找到您的应用程序ID，请在搜索字段中输入您的应用程序的名称，然后选择适当的国家和媒体类型。 在结果中，找到您的应用程序并在右侧的列中选择iPhone应用程序链接。 您的应用ID是ID和？mt之间的九位数字。{/t}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">App Argument</label>
						<div class="controls">
							<input type='text' name='app_argument' value='{$app_argument}'>
							<span class="help-block">可以指定从您的网站跳转到iOS应用程序中的相应位置，如不填写为空，会自动获取当前页面地址。</span>
						</div>
					</div>
				<!-- iOS智能广告条end -->
				
				<!-- {/if} -->
				<!-- {if $code eq 'app_download_url'} -->
					<h3 class="heading">{t domain="mobile"}APP下载地址{/t}</h3>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}iPhone下载二维码：{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_iphone_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_iphone_qrcode}" alt="{t domain="mobile"}暂无图片{/t}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
								<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
								<input type="file" name="mobile_iphone_qrcode"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t domain="mobile"}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_iphone_qrcode')}" {if $mobile_iphone_qrcode}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}iPhone下载地址：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_iphone_download' value='{$mobile_iphone_download}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}Android下载二维码：{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_android_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_android_qrcode}" alt='{t domain="mobile"}暂无图片{/t}' />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
								<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
								<input type="file" name="mobile_android_qrcode"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg='{t domain="mobile"}您确定要删除此文件吗？{/t}' data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_android_qrcode')}" {if $mobile_android_qrcode}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}iPhone下载地址：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_android_download' value='{$mobile_android_download}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}WAP/H5访问二维码{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_touch_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_touch_qrcode}" alt='{t domain="mobile"}暂无图片{/t}' />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
								<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
								<input type="file" name="mobile_touch_qrcode"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg='{t domain="mobile"}您确定要删除此文件吗？{/t}' data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_touch_qrcode')}" {if $mobile_touch_qrcode}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>

					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}掌柜UrlScheme设置：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_shopkeeper_urlscheme' value='{$mobile_shopkeeper_urlscheme}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}商城UrlScheme设置：{/t}</label>
						<div class="controls">
							<input type='text' name='mobile_shop_urlscheme' value='{$mobile_shop_urlscheme}'>
						</div>
					</div>
				<!-- {/if} -->
				<!--{if $code eq 'mobile_adsense_set'}-->
					<h3 class="heading">{t domain="mobile"}移动广告位设置{/t}</h3>
					<div class="control-group formSep edit-page">
						<label class="control-label">{t domain="mobile"}移动启动页广告图：{/t}</label>
						<div class="controls">
							<select name='mobile_launch_adsense'>
								<option value='0'>{t domain="mobile"}请选择...{/t}</option>
								<!-- {foreach from=$ad_position_list item=list} -->
									<option value="{$list.position_id}" {if $list.position_id eq $mobile_launch_adsense}selected{/if}>{$list.position_name}</option>
								<!-- {/foreach} -->
							</select>
							<span class="help-block">{t domain="mobile"}请选择所需展示的广告位。{/t}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动首页广告组：{/t}</label>
						<div class="controls control-group draggable">
							<div class="ms-container span9" id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder='{t domain="mobile"}筛选搜索到的应用名称{/t}' autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready select_adsense_group">
										<!-- {foreach from=$ad_position_list item=list} -->
										<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
										<!-- {foreachelse}-->
										<li class="ms-elem-selectable disabled"><span>{t domain="mobile"}暂无内容{/t}</span></li>
										<!-- {/foreach} -->
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">{t domain="mobile"}所选广告位{/t}</div>
									<ul class="ms-list nav-list-content">
										<!-- {foreach from=$mobile_home_adsense_group item=item key=key} -->
										<li class="ms-elem-selection">
											<input type="hidden" value="{$item.position_id}" name="mobile_home_adsense_group[]" />
											<!-- {$item.position_name} -->
											<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
										</li>
										<!-- {/foreach} -->
									</ul>
								</div>
							</div>
						</div>
					</div>
				<!-- {/if} -->
				<!--{if $code eq 'app_screenshots'}-->
				<h3 class="heading">{t domain="mobile"}应用截图{/t}</h3>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}移动应用名称：{/t}</label>
						<div class="controls l_h30">
							<span class="span6">{$mobile_app_name}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}应用预览图1：{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_app_preview1}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_app_preview1}" alt="{t domain="mobile"}暂无图片{/t}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
								<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
								<input type="file" name="mobile_app_preview1"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t domain="mobile"}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_preview1')}" {if $mobile_app_preview1}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}应用预览图2：{/t}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_app_preview2}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_app_preview2}" alt="{t domain="mobile"}暂无图片{/t}" />
								</div>
								<span class="btn btn-file">
									<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
									<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
									<input type="file" name="mobile_app_preview2"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t domain="mobile"}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_preview2')}" {if $mobile_app_preview2}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
							</div>
						</div>
					</div>
				    <div class="control-group formSep">
                        <div class="row-fluid mobile-fileupload" data-action="{url path='mobile/admin_config/insert'}&code={$code}" data-remove="{url path='mobile/admin_config/drop_image'}"></div>
                        <div class="row-fluid {if !$img_list} hide{/if}" style="margin-top:30px;">
                        	<div class="span12">
                        		<h3 class="heading m_b10">{t domain="mobile"}应用截图：{/t}<small>{t domain="mobile"}（编辑、排序、删除）{/t}</small></h3>
                        		<div class="m_b20"><span class="help-inline">{t domain="mobile"}排序后请点击“保存排序”{/t}</span></div>
                        		<div class="wmk_grid ecj-wookmark wookmark_list">
                        			<ul class="wookmark-goods-photo move-mod nomove">
                        				<!-- {foreach from=$img_list item=img} -->
                        				<li class="thumbnail move-mod-group">
                        					<div class="attachment-preview">
                        						<div class="ecj-thumbnail">
                        							<div class="centered">
                        								<a class="bd" title="{$img.img_desc}">
                        									<img data-original="{$img.sort}" src="{$img.img_url}" alt="" />
                        								</a>
                        							</div>
                        						</div>
                        					</div>
                        					<p>
                        						<a href="javascript:;" title='{t domain="mobile"}取消{/t}' data-toggle="sort-cancel" style="display:none;"><i class="fontello-icon-cancel"></i></a>
                        						<a href="javascript:;" title='{t domain="mobile"}保存{/t}' data-toggle="sort-ok" data-imgid="{$img.id}" data-saveurl="{url path='mobile/admin_config/update_image_desc'}" style="display:none;"><i class="fontello-icon-ok"></i></a>
                        						<a class="ajaxremove" data-imgid="{$img.id}" data-toggle="ajaxremove" data-msg="{t domain="mobile"}您确定要删除这张应用截图吗？{/t}" href='{url path="mobile/admin_config/drop_image" args="id={$img.id}"}' title='{t domain="mobile"}移除{/t}'><i class="icon-trash"></i></a>
                        						<a class="move-mod-head" href="javascript:void(0)" title='{t domain="mobile"}移动{/t}'><i class="icon-move"></i></a>
                        						<a href="javascript:;" title='{t domain="mobile"}编辑{/t}' data-toggle="edit"><i class="icon-pencil"></i></a>
                        						<span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{t domain="mobile"}无标题{/t}{/if}</span>
                        					</p>
                        				</li>
                        				<!-- {/foreach} -->
                        			</ul>
                        		</div>
                        	</div>
                        	<a class="btn btn-info save-sort" data-sorturl="{url path='mobile/admin_config/sort_image'}">{t domain="mobile"}保存排序{/t}</a>
                        </div>
					</div>
				<!--{/if}-->
				{if 0}
					<div class="tab-pane" id="touch">
						<div class="control-group formSep">
							<label class="control-label">{t domain="mobile"}是否开启微商城：{/t}</label>
							<div class="controls">
								<div id="info-toggle-button">
					                <input class="nouniform" name="wap_config" type="checkbox"  {if $wap_config eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t domain="mobile"}微商城 Logo：{/t}</label>
							<div class="controls">
								<div class="fileupload {if $wap_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$wap_logo}" alt='{t domain="mobile"}暂无图片{/t}' />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{t domain="mobile"}浏览{/t}</span>
									<span class="fileupload-exists">{t domain="mobile"}修改{/t}</span>
									<input type="file" name="wap_logo"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg='{t domain="mobile"}您确定要删除此文件吗？{/t}' data-href="{RC_Uri::url('mobile/admin_config/del','code=wap_logo')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{t domain="mobile"}删除{/t}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t domain="mobile"}微商城地址：{/t}</label>
							<div class="controls">
								<input type='text' name='shop_touch_url' value='{$shop_touch_url}'>
							</div>
						</div>
					</div>
					{/if}
					{if 0}
						<div class="control-group formSep edit-page">
							<label class="control-label">{t domain="mobile"}TV首页广告位{/t}</label>
							<div class="controls">
								<select name='mobile_tv_home_adsense'>
									<option value='0'>{t domain="mobile"}请选择...{/t}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_home_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{t domain="mobile"}请选择所需展示的广告位。{/t}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t domain="mobile"}TV首页广告组{/t}</label>
							<div class="controls control-group draggable">
								<div class="ms-container span6" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="span12" id="ms-search" type="text" placeholder="{t domain="mobile"}筛选搜索到的广告位名称{/t}" autocomplete="off">
										</div>
										<ul class="ms-list tv-nav-list-ready select_tv_adsense_group">
											<!-- {foreach from=$ad_position_list item=list} -->
											<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
											<!-- {foreachelse}-->
											<li class="ms-elem-selectable disabled"><span>{t domain="mobile"}暂无内容{/t}</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{t domain="mobile"}所选广告位{/t}</div>
										<ul class="ms-list nav-list-ready tv-nav-list-content">
											<!-- {foreach from=$mobile_tv_home_adsense_group item=item key=key} -->
											<li class="tv-ms-elem-selection ms-elem-selection">
												<input type="hidden" value="{$item.position_id}" name="mobile_tv_home_adsense_group[]" />
												<!-- {$item.position_name} -->
												<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</div>
					{/if}

					<!-- {if $code eq 'basic_info'} -->
					<h3 class="heading">{t domain="mobile"}APP入口设置{/t}</h3>
					<div class="alert alert-warnning">
						<a class="close" data-dismiss="alert">×</a>
						<strong>{t domain="mobile"}温馨提示：{/t}</strong>{t domain="mobile"}三端可同时开启，但不能同时关闭，至少必须开启一端；{/t}</a>
					</div>

					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}是否关闭消费端：{/t}</label>
						<div class="controls l_h30">
							<input type="radio" name="app_disable_sale" value="1" {if $app_disable_sale eq 1}checked{/if}/>是&nbsp;&nbsp;&nbsp;
							<input type="radio" name="app_disable_sale" value="0" {if $app_disable_sale eq 0}checked{/if}/>否
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}是否关闭掌柜端：{/t}</label>
						<div class="controls l_h30">
							<input type="radio" name="app_disable_shopkeeper" value="1" {if $app_disable_shopkeeper eq 1}checked{/if}/>是&nbsp;&nbsp;&nbsp;
							<input type="radio" name="app_disable_shopkeeper" value="0" {if $app_disable_shopkeeper eq 0}checked{/if}/>否
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t domain="mobile"}是否关闭配送员端：{/t}</label>
						<div class="controls l_h30">
							<input type="radio" name="app_disable_express" value="1" {if $app_disable_express eq 1}checked{/if}/>是&nbsp;&nbsp;&nbsp;
							<input type="radio" name="app_disable_express" value="0" {if $app_disable_express eq 0}checked{/if}/>否
						</div>
					</div>
					<!-- {/if} -->

					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="code" value="{$code}"/>
							<input type="submit" value="{t domain="mobile"}确定{/t}" class="btn btn-gebo" />
						</div>
					</div>
					
			</fieldset>
        </form>
    </div>
</div>
<!-- {/block} -->
