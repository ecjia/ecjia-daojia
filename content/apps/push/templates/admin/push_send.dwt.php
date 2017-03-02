<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.push_send.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid push_list ">
	<div class="span12">
		<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="row-fluid edit-page">
					<div class="control-group formSep">
						<label class="control-label">{lang key='push::push.label_msg_subject'}</label>
						<div class="controls">
							<input type="text" name="title" value="{$push.title}"/>
							<span class="input-must">{lang key='system::system.require_field'}</span>
							<span class="help-block">{lang key='push::push.msg_subject_help'}</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">{lang key='push::push.label_msg_content'}</label>
						<div class="controls">
							<textarea class="span8" name="content">{$push.content}</textarea>
							<span class="input-must">{lang key='system::system.require_field'}</span>
							<span class="help-block">{lang key='push::push.msg_content_help'}</span>
						</div>
					</div>
	
					<h3 class="heading">{lang key='push::push.push_behavior'}</h3>
					<div class="control-group" >
						<label class="control-label">{lang key='push::push.label_open_action'}</label>
						<div class="controls chk_radio">
							<div>
								<div class="choose">
									<label class="nomargin">
										<input type="radio" class="uni_style" name="action" value="main" {if $extradata.open_type eq 'main'}checked{/if}/><span>{lang key='push::push.main_page'}</span>
									</label>
								</div>
							</div>
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="singin" {if $extradata.open_type eq 'singin'}checked{/if}/><span>{lang key='push::push.singin'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="signup" {if $extradata.open_type eq 'signup'}checked{/if}/><span>{lang key='push::push.signup'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="forget_password" {if $extradata.open_type eq 'forget_password'}checked{/if}/><span>{lang key='push::push.forget_password'}</span>
									</label>
								</div>
							</div>
							
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="discover" {if $extradata.open_type eq 'discover'}checked{/if}/><span>{lang key='push::push.discover'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="qrcode" {if $extradata.open_type eq 'qrcode'}checked{/if}/><span>{lang key='push::push.qrcode'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="qrshare" {if $extradata.open_type eq 'qrshare'}checked{/if}/><span>{lang key='push::push.qrshare'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="history" {if $extradata.open_type eq 'history'}checked{/if}/><span>{lang key='push::push.history'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="feedback" {if $extradata.open_type eq 'feedback'}checked{/if}/><span>{lang key='push::push.feedback'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="map" {if $extradata.open_type eq 'map'}checked{/if}/><span>{lang key='push::push.map'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="message" {if $extradata.open_type eq 'message'}checked{/if}/><span>{lang key='push::push.message_center'}</span>
									</label>
								</div>
							</div>
						
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="webview" {if $extradata.open_type eq 'webview'}checked{/if}/><span>{lang key='push::push.webview'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="setting" {if $extradata.open_type eq 'setting'}checked{/if}/><span>{lang key='push::push.setting'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="language" {if $extradata.open_type eq 'language'}checked{/if}/><span>{lang key='push::push.language'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="cart" {if $extradata.open_type eq 'cart'}checked{/if}/><span>{lang key='push::push.cart'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="search" {if $extradata.open_type eq 'search'}checked{/if}/><span>{lang key='push::push.search'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="help" {if $extradata.open_type eq 'help'}checked{/if}/><span>{lang key='push::push.help'}</span>
									</label>
								</div>
							</div>
							
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="goods_seller_list" {if $extradata.open_type eq 'goods_seller_list'}checked{/if}/><span>{lang key='push::push.goods_list'}</span>
									</label>
								</div>
<!-- 								<div class="choose"> -->
<!-- 									<label> -->
<!-- 										<input type="radio" class="uni_style" name="action" value="goods_list" {if $extradata.open_type eq 'goods_list'}checked{/if}/><span>{lang key='push::push.goods_list'}</span> -->
<!-- 									</label> -->
<!-- 								</div> -->
<!-- 								<div class="choose"> -->
<!-- 									<label> -->
<!-- 										<input type="radio" class="uni_style" name="action" value="goods_comment" {if $extradata.open_type eq 'goods_comment'}checked{/if}/><span>{lang key='push::push.goods_comment'}</span> -->
<!-- 									</label> -->
<!-- 								</div> -->
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="goods_detail" {if $extradata.open_type eq 'goods_detail'}checked{/if}/><span>{lang key='push::push.goods_detail'}</span>
									</label>
								</div>
								
								
							</div>
							
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="orders_list" {if $extradata.open_type eq 'orders_list'}checked{/if}/><span>{lang key='push::push.orders_list'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="orders_detail" {if $extradata.open_type eq 'orders_detail'}checked{/if}/><span>{lang key='push::push.orders_detail'}</span>
									</label>
								</div>
							</div>
							
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="user_center" {if $extradata.open_type eq 'user_center'}checked{/if}/><span>{lang key='push::push.user_center'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="user_wallet" {if $extradata.open_type eq 'user_wallet'}checked{/if}/><span>{lang key='push::push.user_wallet'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="user_address" {if $extradata.open_type eq 'user_address'}checked{/if}/><span>{lang key='push::push.user_address'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="user_account" {if $extradata.open_type eq 'user_account'}checked{/if}/><span>{lang key='push::push.user_account'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="user_collect" {if $extradata.open_type eq 'user_collect'}checked{/if}/><span>{lang key='push::push.user_collect'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="user_password" {if $extradata.open_type eq 'user_password'}checked{/if}/><span>{lang key='push::push.user_password'}</span>
									</label>
								</div>
							</div>
							
							<div class="clear_both">
<!-- 								<div class="choose"> -->
<!-- 									<label> -->
<!-- 										<input type="radio" class="uni_style" name="action" value="seller" {if $extradata.open_type eq 'seller'}checked{/if}/><span>{lang key='push::push.seller'}</span> -->
<!-- 									</label> -->
<!-- 								</div> -->
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="seller" {if $extradata.open_type eq 'seller_list'}checked{/if}/><span>{lang key='push::push.seller_list'}</span>
									</label>
								</div>
							</div>
							<div class="clear_both">
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="merchant" {if $extradata.open_type eq 'merchant'}checked{/if}/><span>{lang key='push::push.merchant'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="merchant_goods_list" {if $extradata.open_type eq 'merchant_goods_list'}checked{/if}/><span>{lang key='push::push.merchant_goods_list'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="merchant_suggest_list" {if $extradata.open_type eq 'merchant_suggest_list'}checked{/if}/><span>{lang key='push::push.merchant_suggest_list'}</span>
									</label>
								</div>
								<div class="choose">
									<label>
										<input type="radio" class="uni_style" name="action" value="merchant_detail" {if $extradata.open_type eq 'merchant_detail'}checked{/if}/><span>{lang key='push::push.merchant_detail'}</span>
									</label>
								</div>
							</div>
						</div>
					</div>
					
					<div id="urldiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_url'}</label>
						<div class="controls">
							<input type="text" id="url" name="url" value="{$push.url}"/>
						</div>
					</div>
					<div id="keyworddiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_keywords'}</label>
						<div class="controls">
							<input type="text"  id="keyword" name="keyword" value="{$push.keyword}"/>
						</div>
					</div>
					<div id="catdiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.lable_category_id'}</label>
						<div class="controls">
							<input type="text" id="category_id" name="category_id" value="{$push.category_id}"/>
						</div>
					</div>
					<div id="goodsdiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_goods_id'}</label>
						<div class="controls">
							<input type="text" id="goods_id" name="goods_id" value="{$push.goods_id}"/>
						</div>
					</div>
					<div id="ordersdiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_order_id'}</label>
						<div class="controls">
							<input type="text" id="order_id" name="order_id" value="{$push.order_id}"/>
						</div>
					</div>
					<div id="sellerlist" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_seller_category'}</label>
						<div class="controls">
							<input type="text" id="seller_category" name="seller_category" value="{$push.seller_category}"/>
						</div>
					</div>
					<div id="merchant" class="control-group hide">
						<div class="control-group">
							<label class="control-label">{lang key='push::push.label_merchant_id'}</label>
							<div class="controls">
								<input type="text" id="merchant_id" name="merchant_id" value="{$push.merchant_id}"/>
							</div>
						</div>
						<div class="control-group" id="merchant_category">
							<label class="control-label">{lang key='push::push.lable_category_id'}</label>
							<div class="controls">
								<input type="text" id="goods_category_id" name="goods_category_id" value="{$push.goods_category_id}"/>
							</div>
						</div>
						<div class="control-group" id="merchant_suggest">
							<label class="control-label">{lang key='push::push.label_suggest_type'}</label>
							<div class="controls">
								<input type="text" id="suggest_type" name="suggest_type" value="{$push.suggest_type}"/>
								<span class="help-block">{lang key='push::push.suggest_type_help'}</span>
							</div>
														
						</div>
					</div>
					
					<h3 class="heading">{lang key='push::push.push_object'}</h3>
					<div class="control-group" >
						<label class="control-label">{lang key='push::push.label_push_to'}</label>
						<!-- {if $action eq 'add'} -->
						<div class="controls chk_radio">
							<input type="radio" class="uni_style" name="target" value="0" checked="checked"/><span>{lang key='push::push.all_people'}</span>
							<input type="radio" class="uni_style" name="target" value="1" /><span>{lang key='push::push.unicast'}</span>
							<input type="radio" class="uni_style" name="target" value="2" /><span>{lang key='push::push.user'}</span>
							<input type="radio" class="uni_style" name="target" value="3" /><span>{lang key='push::push.administrator'}</span>
						</div>
						<!-- {else} -->
						<div class="controls chk_radio">
							<input type="radio" class="uni_style" name="target" value="0" {if $push.device_token eq 'broadcast'}checked{/if}/><span>{lang key='push::push.all_people'}</span>
							<input type="radio" class="uni_style" name="target" value="1" {if $push.device_token neq 'broadcast'}checked{/if}/><span>{lang key='push::push.unicast'}</span>
							<input type="radio" class="uni_style" name="target" value="2" /><span>{lang key='push::push.user'}</span>
							<input type="radio" class="uni_style" name="target" value="3" /><span>{lang key='push::push.administrator'}</span>
						</div>
						<!-- {/if} -->
					</div>
				
					<div id="onediv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_device_token'}</label>
						<div class="controls">
							<input type="text" id="device_token" name="device_token" value="{if $push.device_token neq 'broadcast'}{$push.device_token}{/if}"/>
						</div>
					</div>
					
					<div id="userdiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_user_id'}</label>
						<div class="controls">
							<input type="text" id="user_id" name="user_id"/>
						</div>
					</div>
					
					<div id="admindiv" class="control-group hide">
						<label class="control-label">{lang key='push::push.label_admin_id'}</label>
						<div class="controls">
							<input type="text" id="admin_id" name="admin_id"/>
						</div>
					</div>
					
					<h3 class="heading">{lang key='push::push.push_time'}</h3>
					<div class="control-group formSep">
						<label class="control-label">{lang key='push::push.label_send_time'}</label>
						<div class="controls chk_radio">
							<input type="radio" name="priority" value="1" checked="checked" />{lang key='push::push.send_now'}&nbsp;&nbsp;
							<input type="radio" name="priority" value="0" />{lang key='push::push.send_later'}
						</div>
					</div>
					
					<div class="control-group">
						<div class="controls m_t10">
							<input type="hidden" name="appid" value="{$appid}"/>
							<input class="btn btn-gebo" type="submit" value="{lang key='system::system.button_submit'}">&nbsp;&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->