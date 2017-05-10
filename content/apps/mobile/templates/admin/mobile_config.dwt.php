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
					<h3 class="heading">基本信息</h3>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_name'}</label>
						<div class="controls">
							<input type="text" name="mobile_app_name" value="{$mobile_app_name}">
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.label_mobile_logo'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_app_icon}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_app_icon}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
								<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
								<input type="file" name="mobile_app_icon"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_icon')}" {if $mobile_app_icon}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_version'}</label>
						<div class="controls">
							<input type="text" name="mobile_app_version" value="{$mobile_app_version}">
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_description'}</label>
						<div class="controls">
							<textarea class="span12 h100" name='mobile_app_description'>{$mobile_app_description}</textarea>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_video'}</label>
						<div class="controls">
							<input type="text" name="mobile_app_video" value="{$mobile_app_video}" />
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.label_bonus_readme'}</label>
						<div class="controls">
							<select name='bonus_readme' class="artilce_list">
								<!-- {if !$bonus_readme.title} -->
									<option value='-1'>{lang key='mobile::mobile.pls_select'}</option>
								<!-- {else} -->
									<option value="{$bonus_readme.id}">{$bonus_readme.title}</option>
								<!-- {/if} -->
							</select>
							<input type='text' name='article_search' class='m_l5 keywords'/>
							<input type='button' class='btn article_search' value="{lang key='mobile::mobile.search'}" data-url="{url path='mobile/admin_config/search_article'}"/>
							<span class="help-block">{lang key='mobile::mobile.search_notice'}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_feedback_autoreply'}</label>
						<div class="controls">
							<input type='text' name='mobile_feedback_autoreply' value='{$mobile_feedback_autoreply}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.shop_pc_url'}</label>
						<div class="controls">
							<input type='text' name='shop_pc_url' value='{$shop_pc_url}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_touch_url'}</label>
						<div class="controls">
							<input type='text' name='mobile_touch_url' value='{$mobile_touch_url}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_share_link'}</label>
						<div class="controls">
							<input type='text' name='mobile_share_link' value='{$mobile_share_link}'>
						</div>
					</div>
					
					<div class="control-group formSep">
						<label class="control-label">新人有礼红包：</label>
						<div class="controls">
							<select name="mobile_signup_reward">
								<option value="0">{lang key='mobile::mobile.pls_select'}</option>
								<!-- {foreach from=$bonus_type_list item=list} -->
									<option value="{$list.type_id}" {if $mobile_signup_reward eq $list.type_id}selected="true"{/if}>{$list.type_name}</option>	
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">新人有礼说明：</label>
						<div class="controls">
							<textarea name="mobile_signup_reward_notice" class="span7">{$mobile_signup_reward_notice}</textarea>
						</div>
					</div>
					
				<!-- 登录色值start -->
					<h3 class="heading">{lang key='mobile::mobile.mobile_login_set'}</h3>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_login_fgcolor'}</label>
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
						<label class="control-label">{lang key='mobile::mobile.mobile_login_bgcolor'}</label>
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
						<label class="control-label">{lang key='mobile::mobile.mobile_login_bgimage'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_phone_login_bgimage}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_phone_login_bgimage}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
								<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
								<input type="file" name="mobile_phone_login_bgimage"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_phone_login_bgimage')}" {if $mobile_phone_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>
				<!-- 登录色值end -->
				<!-- 热门城市start -->
					<h3 class="heading">热门城市设置</h3>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.selected_area'}</label>
						<div class="controls selected_area chk_radio">
							<!-- {foreach from=$mobile_recommend_city item=region key=id} -->
							<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" /> <span class="m_r10">{$region}&nbsp;&nbsp;</span>
							<!-- {/foreach} -->
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.hot_city'}</label>
						<div class="controls">
							<div class="ms-container ms-shipping span12" id="ms-custom-navigation">
								<div class="ms-selectable ms-mobile-selectable span2">
									<div class="search-header">
										<input class="span12" type="text" placeholder="{lang key='mobile::mobile.search_country_name'}" autocomplete="off" id="selCountry" />
									</div>
									<ul class="ms-list ms-list-mobile nav-list-ready selCountry" data-url="{url path='shipping/region/init' args='target=selProvinces&type=1'}" data-next="selProvinces">
										<!-- {foreach from=$countries item=country key=key} -->
										<li class="ms-elem-selectable select_hot_city" data-val="{$country.region_id}"><span>{$country.region_name|escape:html}</span></li>
										<!-- {foreachelse} -->
										<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{lang key='mobile::mobile.empty_country'}</span></li>
										<!-- {/foreach} -->
									</ul>
								</div>
								<div class="ms-selectable ms-mobile-selectable span2">
									<div class="search-header">
										<input class="span12" type="text" placeholder="{lang key='mobile::mobile.search_province_name'}" autocomplete="off" id="selProvinces" />
									</div>
									<ul class="ms-list ms-list-mobile nav-list-ready selProvinces" data-url="{url path='shipping/region/init' args='target=selCities&type=2'}" data-next="selCities">
										<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{lang key='mobile::mobile.select_province_first'}</span></li>
									</ul>
								</div>
								<div class="ms-selectable ms-mobile-selectable span2">
									<div class="search-header">
										<input class="span12" type="text" placeholder="{lang key='mobile::mobile.search_city_name'}" autocomplete="off" id="selCities" />
									</div>
									<ul class="ms-list ms-list-mobile nav-list-ready selCities">
										<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{lang key='mobile::mobile.select_city_first'}</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				<!-- 热门城市end -->
				<!-- 短信提醒start -->
					<h3 class="heading">短信提醒</h3>
					<div class="control-group formSep edit-page">
						<label class="control-label">{lang key='mobile::mobile.remind_seller_ship'}</label>
						<div class="controls chk_radio">
							<input type='radio' name='order_reminder_type' value='2' {if $order_reminder_type eq 2}checked='checked'{/if} />{lang key='mobile::mobile.message_notice'}
							<input type='radio' name='order_reminder_type' value='1' {if $order_reminder_type eq 1}checked='checked'{/if} />{lang key='mobile::mobile.push_notice'}
							<input type='radio' name='order_reminder_type' value='0' {if $order_reminder_type eq 0}checked='checked'{/if} />{lang key='mobile::mobile.not_notice'}
						</div>
					</div>

					<div class="control-group formSep order_reminder_2 {if $order_reminder_type eq '0' || $order_reminder_type eq '1'}ecjiaf-dn{/if}">
						<label class="control-label order_reminder_2">{lang key='mobile::mobile.order_remind_by_message'}</label>
						<div class="controls chk_radio order_reminder_2">
							<input type='text' name='order_reminder_mobile' value='{$order_reminder_value}'>
						</div>
					</div>
					<div class="control-group formSep order_reminder_1 {if $order_reminder_type eq '0' || $order_reminder_type eq '2'}ecjiaf-dn{/if}">
						<label class="control-label">{lang key='mobile::mobile.order_remind_by_push'}</label>
						<div class="controls chk_radio">
							<select name='order_reminder_push'>
								<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
								<!-- {foreach from=$admin_user_list item=list} -->
									<option value="{$list.user_id}" {if $list.user_id eq $order_reminder_value}selected{/if}>{$list.user_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
				<!-- 短信提醒end -->
				<!-- {/if} -->
				<!-- {if $code eq 'app_download_url'} -->
					<h3 class="heading">APP下载地址</h3>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.iphone_qr_code'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_iphone_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_iphone_qrcode}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
								<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
								<input type="file" name="mobile_iphone_qrcode"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_iphone_qrcode')}" {if $mobile_iphone_qrcode}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_iphone_download'}</label>
						<div class="controls">
							<input type='text' name='mobile_iphone_download' value='{$mobile_iphone_download}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.android_qr_code'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_android_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_android_qrcode}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
								<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
								<input type="file" name="mobile_android_qrcode"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_android_qrcode')}" {if $mobile_android_qrcode}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_android_download'}</label>
						<div class="controls">
							<input type='text' name='mobile_android_download' value='{$mobile_android_download}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_touch_qrcode'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_touch_qrcode}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_touch_qrcode}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
								<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
								<input type="file" name="mobile_touch_qrcode"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_touch_qrcode')}" {if $mobile_touch_qrcode}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>

					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.shopkeeper_urlscheme'}</label>
						<div class="controls">
							<input type='text' name='mobile_shopkeeper_urlscheme' value='{$mobile_shopkeeper_urlscheme}'>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.shop_urlscheme'}</label>
						<div class="controls">
							<input type='text' name='mobile_shop_urlscheme' value='{$mobile_shop_urlscheme}'>
						</div>
					</div>
				<!-- {/if} -->
				<!--{if $code eq 'mobile_adsense_set'}-->
					<h3 class="heading">移动广告位设置</h3>
					<div class="control-group formSep edit-page">
						<label class="control-label">{lang key='mobile::mobile.mobile_launch_adsense'}</label>
						<div class="controls">
							<select name='mobile_launch_adsense'>
								<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
								<!-- {foreach from=$ad_position_list item=list} -->
									<option value="{$list.position_id}" {if $list.position_id eq $mobile_launch_adsense}selected{/if}>{$list.position_name}</option>
								<!-- {/foreach} -->
							</select>
							<span class="help-block">{lang key='mobile::mobile.launch_adsense_notice'}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.launch_adsense_group'}</label>
						<div class="controls control-group draggable">
							<div class="ms-container span9" id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder="{lang key='mobile::mobile.filter_app_name'}" autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready select_adsense_group">
										<!-- {foreach from=$ad_position_list item=list} -->
										<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
										<!-- {foreachelse}-->
										<li class="ms-elem-selectable disabled"><span>{lang key='mobile::mobile.no_content'}</span></li>
										<!-- {/foreach} -->
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">{lang key='mobile::mobile.selected_ad_position'}</div>
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
				<h3 class="heading">应用截图</h3>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_name'}</label>
						<div class="controls l_h30">
							<span class="span6">{$mobile_app_name}</span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_preview1'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_app_preview1}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_app_preview1}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
								<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
								<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
								<input type="file" name="mobile_app_preview1"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_preview1')}" {if $mobile_app_preview1}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{lang key='mobile::mobile.mobile_app_preview2'}</label>
						<div class="controls">
							<div class="fileupload {if $mobile_app_preview2}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
								<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
									<img src="{$mobile_app_preview2}" alt="{lang key='mobile::mobile.no_image'}" />
								</div>
								<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="mobile_app_preview2"/>
								</span>
								<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=mobile_app_preview2')}" {if $mobile_app_preview2}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
							</div>
						</div>
					</div>
				    <div class="control-group formSep">
                        <div class="row-fluid mobile-fileupload" data-action="{url path='mobile/admin_config/insert'}&code={$code}" data-remove="{url path='mobile/admin_config/drop_image'}"></div>
                        <div class="row-fluid {if !$img_list} hide{/if}" style="margin-top:30px;">
                        	<div class="span12">
                        		<h3 class="heading m_b10">{lang key='mobile::mobile.mobile_app_screenshots'}<small>{lang key='goods::goods.goods_photo_notice'}</small></h3>
                        		<div class="m_b20"><span class="help-inline">{lang key='goods::goods.goods_photo_help'}</span></div>
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
                        						<a href="javascript:;" title="{lang key='goods::goods.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fontello-icon-cancel"></i></a>
                        						<a href="javascript:;" title="{lang key='goods::goods.save'}" data-toggle="sort-ok" data-imgid="{$img.id}" data-saveurl="{url path='mobile/admin_config/update_image_desc'}" style="display:none;"><i class="fontello-icon-ok"></i></a>
                        						<a class="ajaxremove" data-imgid="{$img.id}" data-toggle="ajaxremove" data-msg="{lang key='mobile::mobile.drop_screenshots_confirm'}" href='{url path="mobile/admin_config/drop_image" args="id={$img.id}"}' title="{lang key='system::system.remove'}"><i class="icon-trash"></i></a>
                        						<a class="move-mod-head" href="javascript:void(0)" title="{lang key='goods::goods.move'}"><i class="icon-move"></i></a>
                        						<a href="javascript:;" title="{lang key='system::system.edit'}" data-toggle="edit"><i class="icon-pencil"></i></a>
                        						<span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{lang key='goods::goods.no_title'}{/if}</span>
                        					</p>
                        				</li>
                        				<!-- {/foreach} -->
                        			</ul>
                        		</div>
                        	</div>
                        	<a class="btn btn-info save-sort" data-sorturl="{url path='mobile/admin_config/sort_image'}">{lang key='goods::goods.save_sort'}</a>
                        </div>
					</div>
				<!--{/if}-->
				{if 0}
					<div class="tab-pane" id="touch">
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.is_open_config'}</label>
							<div class="controls">
								<div id="info-toggle-button">
					                <input class="nouniform" name="wap_config" type="checkbox"  {if $wap_config eq 1}checked="checked"{/if}  value="1"/>
					            </div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.wap_Logo'}</label>
							<div class="controls">
								<div class="fileupload {if $wap_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
										<img src="{$wap_logo}" alt="{lang key='mobile::mobile.no_image'}" />
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
									<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
									<input type="file" name="wap_logo"/>
									</span>
									<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{lang key='mobile::mobile.drop_confirm'}" data-href="{RC_Uri::url('mobile/admin_config/del','code=wap_logo')}" {if $mobile_pad_login_bgimage}data-removefile="true"{/if}>{lang key='system::system.drop'}</a>
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{lang key='mobile::mobile.shop_touch_url'}</label>
							<div class="controls">
								<input type='text' name='shop_touch_url' value='{$shop_touch_url}'>
							</div>
						</div>
					</div>
					{/if}
					{if 0}
						<div class="control-group formSep edit-page">
							<label class="control-label">TV首页广告位</label>
							<div class="controls">
								<select name='mobile_tv_home_adsense'>
									<option value='0'>{lang key='mobile::mobile.pls_select'}</option>
									<!-- {foreach from=$ad_position_list item=list} -->
										<option value="{$list.position_id}" {if $list.position_id eq $mobile_tv_home_adsense}selected{/if}>{$list.position_name}</option>
									<!-- {/foreach} -->
								</select>
								<span class="help-block">{lang key='mobile::mobile.launch_adsense_notice'}</span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">TV首页广告组</label>
							<div class="controls control-group draggable">
								<div class="ms-container span6" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="span12" id="ms-search" type="text" placeholder="{lang key='mobile::mobile.filter_adsense_name'}" autocomplete="off">
										</div>
										<ul class="ms-list tv-nav-list-ready select_tv_adsense_group">
											<!-- {foreach from=$ad_position_list item=list} -->
											<li data-id="{$list.position_id}" id="position_id_{$list.position_id}" class="ms-elem-selectable isShow"><span>{$list.position_name}</span></li>
											<!-- {foreachelse}-->
											<li class="ms-elem-selectable disabled"><span>{lang key='mobile::mobile.no_content'}</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{lang key='mobile::mobile.selected_ad_position'}</div>
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
					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="code" value="{$code}"/>
							<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
						</div>
					</div>
			</fieldset>
        </form>
    </div>
</div>
<!-- {/block} -->
