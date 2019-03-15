<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.profile_setting.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-info data-pjax pull-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text} </a>
		{/if}
		</h2>
	</div>
</div>

<div class="row" id="real-estates-detail">
	<!-- #BeginLibraryItem "/library/profile_setting.lbi" --><!-- #EndLibraryItem -->
    <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <ul id="myTab" class="nav nav-pills">
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/init"}'>{t domain="staff"}个人资料{/t}</a></li>
                    <li class="active"><a href="#photos">{t domain="staff"}账户设置{/t}</a></li>
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/avatar"}'>{t domain="staff"}头像设置{/t}</a></li>
                </ul>
                
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="photos">  
                       <form method="post" name="profileForm" id="profileForm" action="{$form_action}">
                       		<br>
                            <label>{t domain="staff"}手机账号{/t}</label>
                            <div class="input-group m-bot15">
                                <input class="form-control" id="mobile" name="mobile" type="text" value="{$user_info.mobile}" readonly="true" />
                                <span class="input-group-btn">
	                                <a href="#mobilemodal" data-toggle="modal">
	                                   <button class="btn btn-primary" type="button" style="margin-left: -2px;">{t domain="staff"}更换手机账号{/t}</button>
	                                </a>
                                </span>
                            </div>
                            
                            <label>{t domain="staff"}邮箱账号{/t}</label>
                            <div class="input-group m-bot15">
                                <input class="form-control" id="email" name="email" type="text" value="{$user_info.email}" readonly="true"/>
                                <span class="input-group-btn">
	                                <a href="#emailmodal" data-toggle="modal">
	                                    <button class="btn btn-primary" type="button" style="margin-left: -2px;">{t domain="staff"}更换邮箱账号{/t}</button>
	                                </a>
                                </span>
                            </div>
                            
                            <div class="form-group controls">
                                <label>{t domain="staff"}当前密码{/t}</label>
                                <input type="password" id="old_password"  name="old_password"  class="form-control"  placeholder='{t domain="staff"}请先填写旧密码{/t}' />
                            </div>
                            
                            <div class="form-group controls">
                                <label>{t domain="staff"}新密码{/t}</label>
                                <input type="password" id="new_password"  name="new_password" class="form-control"  placeholder='{t domain="staff"}请输入新密码{/t}' />
                            </div>
                            
                            <div class="form-group controls">
                                <label>{t domain="staff"}确认密码{/t}</label>
                                <input type="password" id="pwd_confirm"  name="pwd_confirm" class="form-control"  placeholder='{t domain="staff"}确认密码和新密码需保持一致{/t}' />
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{t domain="staff"}提交{/t}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="mobilemodal" class="modal fade">
                    <div class="modal-dialog" style="margin-top: 200px;">
	                    <div class="modal-content">
		                    <div class="modal-header">
			                    <button data-dismiss="modal" class="close" type="button">×</button>
			                    <h4 class="modal-title">{t domain="staff"}更换手机账号{/t}</h4>
		                    </div>
		                    
		                    <div class="modal-body">
		                     <div class="success-msg"></div>
		                     <div class="error-msg"></div>
			                    <form class="form-horizontal" method="post" name="mobileForm" id="mobileForm" action='{RC_Uri::url("staff/mh_profile/update_mobile")}'>
			                       <div class="form-group">
			                           <div class="col-lg-12">
			                               <input type="text" class="form-control" id="newmobile" name="newmobile" placeholder='{t domain="staff"}请输入新的手机账号{/t}'>
			                           </div>
			                       </div>
			                        
			                       <div class="input-group">
					                   <input type="text" class="form-control" name="mobilecode" placeholder='{t domain="staff"}请输入短信验证码{/t}'>
					                   <span class="input-group-btn">
					                       <input class="btn btn-info" id="get_mobile_code" data-url='{RC_Uri::url("staff/mh_profile/get_mobile_code")}' type="button" value='{t domain="staff"}获取短信校验码{/t}'>
					                   </span>
					               </div>
					               <br>  
					                
			                       <div class="form-group">
			                          <div class="col-lg-10">
			                               <button type="submit" class="btn btn-primary ">{t domain="staff"}提交{/t}</button>
			                          </div>
			                       </div>
			                    </form>
		                    </div>
	                    </div>
                    </div>
               </div>

               <div id="emailmodal" class="modal fade">
                    <div class="modal-dialog" style="margin-top: 200px;">
	                    <div class="modal-content">
		                    <div class="modal-header">
			                    <button data-dismiss="modal" class="close" type="button">×</button>
			                    <h4 class="modal-title">{t domain="staff"}更换邮箱账号{/t}</h4>
		                    </div>
		                   
		                    <div class="modal-body">
		                     <div class="success-msg"></div>
		                     <div class="error-msg"></div>
			                    <form class="form-horizontal" method="post" name="emailForm" id="emailForm"  action='{RC_Uri::url("staff/mh_profile/update_email")}'>
			                       <div class="form-group">
			                           <div class="col-lg-12">
			                               <input type="email" class="form-control" id="newemail" name="newemail" placeholder='{t domain="staff"}请输入新的邮箱账号{/t}'>
			                           </div>
			                       </div>
			                        
			                       <div class="input-group">
					                   <input type="text" class="form-control" name="emailcode"  placeholder='{t domain="staff"}请输入邮箱验证码{/t}'>
					                   <span class="input-group-btn">
					                       <input class="btn btn-info" id="get_email_code" data-url='{RC_Uri::url("staff/mh_profile/get_email_code")}' type="button" value='{t domain="staff"}获取邮箱验证码{/t}'>
					                   </span>
					               </div>
					               <br>  
					                
			                       <div class="form-group">
			                          <div class="col-lg-10">
			                               <button type="submit" class="btn btn-primary ">{t domain="staff"}提交{/t}</button>
			                          </div>
			                       </div>
			                    </form>
		                    </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->