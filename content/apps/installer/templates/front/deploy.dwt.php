{nocache}
<!DOCTYPE html>
<html>
	<head lang="zh-CN">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ECJIA到家安装程序</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/grid.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
		
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/styles/ecjia.ui.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/bootstrap/css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/chosen/chosen.css" />
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/uniform/Aristo/uniform.aristo.css" />
	</head>
	
	<body id="maincontainer" style="height:auto;">
		{include file="./library/header.lbi.php"}
		<div class="container">
		    <div class="row">
		        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
		            <div class="column-14 start-06 ecjia-install">
						<form id="js-ecjia_deploy">
		                    <h3 class="ecjia-install-title">确认您的配置</h3>
		                    <div class="ecjia-install-body">
		                        <h4>数据库配置</h4>
		                        <ul class="ecjia-option">
								    <li class="control-group">
								        <label class="ecjia-label" for="dbhost">数据库主机</label>
								        <input type="text" class="text" name="dbhost" id="dbhost" value="localhost"/>
								        <p class="description">您可能会使用"localhost"</p>
								    </li>
								    
								    <li class="control-group">
								        <label class="ecjia-label" for="dbport">数据库端口</label>
								        <input type="text" class="text" name="dbport" id="dbport" value="3306"/>
								        <p class="description">如果您不知道此选项的意义， 请保留默认设置</p>
								    </li>
								    
								    <li class="control-group">
								        <label class="ecjia-label" for="dbuser">数据库用户名</label>
								        <input type="text" class="text" name="dbuser" id="dbuser" value="root" />
								        <p class="description">您可能会使用 "root"</p>
								    </li>
								    
								    <li class="control-group">
								    	<div class="check_db_correct" data-url="{RC_Uri::url('installer/index/check_db_correct')}">
									        <label class="ecjia-label" for="dbpassword">数据库密码</label>
									        <input type="password" class="text" name="dbpassword" id="dbpassword" value="" />
								        </div>
								    </li>
								    
								    <li class="control-group">
                                        <div class="check_db_exists" data-url="{RC_Uri::url('installer/index/check_db_exists')}">
	                                        <label class="ecjia-label" for="dbpassword">数据库名称</label>
	                                        <input type="text" class="text" name="dbdatabase" id="dbdatabase" value="" />
                                        </div>
                                        <p class="description">请您指定数据库名称</p>
                                    </li>
								    
		                            <li class="control-group">
			                            <label class="ecjia-label" for="dbprefix">数据库前缀</label>
			                            <input type="text" class="text" name="dbprefix" id="dbprefix" value="ecjia_" />
			                            <p class="description">默认前缀是 "ecjia_"</p>
		                            </li>
		                        </ul>
		                        
		                        <h4>创建您的管理员帐号</h4>
		                        <ul class="ecjia-option">
		                            <li class="control-group">
			                            <label class="ecjia-label" for="username">管理员名称</label>
			                            <input type="text" name="username" id="username" class="text" value="" />
			                            <p class="description">请填写您的用户名</p>
		                            </li>
		                            
		                            <li class="control-group">
			                            <label class="ecjia-label" for="userpassword">登录密码</label>
			                            <input type="password" name="userpassword" id="userpassword" class="text" value="" />
			                            <p class="password-error"></p>
		                            </li>
		                            
		                            <li class="control-group">
			                            <label class="ecjia-label" for="confirmpassword">确认密码</label>
			                            <input type="password" name="confirmpassword" id="confirmpassword" class="text" value="" />
			                            <p class="confirmpassword-error"></p>
		                            </li>
		                            
		                            <li class="control-group">
			                            <label class="ecjia-label" for="usermail">电子邮箱</label>
			                            <input type="text" name="usermail" id="usermail" class="text" value="" />
			                            <p class="description">请填写一个您的常用邮箱</p>
		                            </li>
		                        </ul>
		                        
		              			<h4>杂项</h4>
		                  		<ul class="ecjia-option">
			              			<!--{if $show_timezone eq 'yes'} -->
			                      	<li>
			                   			<label class="ecjia-label" for="zones">设置时区</label>
			                   			<div class="choose_list">
											<select name="js-timezones" id="js-timezones">
												<!-- {foreach from=$timezones item=item key=key} -->
													<option value="{$key}" {if $key == $local_timezone } selected="true"{/if}>{$item}</option>
												<!-- {/foreach} -->
											</select>
										</div>
			                         </li>
			                         <!-- {/if} -->      
			                         <div class="clear_both"></div>                 
			                         <li>
	                                    <label class="ecjia-label" for="good_select">安装测试数据</label>
	                                     <p class="description"><input type="checkbox" class="p" name="js-install-demo" id="js-install-demo">选择此项，将默认安装有关商品以及店铺等默认数据（可选填）</p>
	                                 </li>
		                        </ul>
		                    </div>
		                    
		                    <input type="hidden" name="index" value="{RC_Uri::url('installer/index/init')}" />
		                    <input type="hidden" name="done" value="{RC_Uri::url('installer/index/finish')}" />
		                    <input type="hidden" name="create_config_file" value="{RC_Uri::url('installer/index/create_config_file')}" />
		                    <input type="hidden" name="create_database" value="{RC_Uri::url('installer/index/create_database')}" />
		                   	<input type="hidden" name="install_structure" value="{RC_Uri::url('installer/index/install_structure')}" />
		                    <input type="hidden" name="install_base_data" value="{RC_Uri::url('installer/index/install_base_data')}" />
		                    <input type="hidden" name="install_demo_data" value="{RC_Uri::url('installer/index/install_demo_data')}" />
		                    <input type="hidden" name="create_admin_passport" value="{RC_Uri::url('installer/index/create_admin_passport')}" />
		                    <input type="hidden" name="do_others" value="{RC_Uri::url('installer/index/do_others')}" />
		                    <input type="hidden" name="correct_img" value="{$correct_img}" />
		                    <input type="hidden" name="error_img" value="{$error_img}" />
		                    <input type="hidden" name="is_create" value="1"/>
		                    <input type="hidden" name="database_config" />
		                    
							<input id="ecjia_install" type="button" class="btn primary" value="确认，立即安装 &raquo;" onclick="return ecjia.front.install.start();"/>
						</form>
						
						<div class="ecjia-install-body">
							<div id="js-monitor">
							    <div id="js-monitor-panel">
							    	<h3 class="ecjia-install-title" id="js-monitor-wait-please">正在安装</h3>
					        		<div class="span8" style="margin-left:0;">
										<div class="progress">
										  	<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 20%">20%</div>
										</div>
									</div>
							        <span id="js-monitor-view-detail"></span>
							    </div>
							    <div id="js-monitor-notice" name="js-monitor-notice">
							        <div id="js-notice"></div>
							    </div>
							    <input id="js-install-return-once" type="button" class="btn primary" value="返回配置系统" onclick="ecjia.front.install.return_setting();" style="display: none;"/>
							</div>
				    	</div>
					</div>
				</div>
			</div>
		</div>
		
		{include file="./library/footer.lbi.php"}
	
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
		
		<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
		<script src="{$front_url}/js/install.js" type="text/javascript"></script>
		
		<script src="{$system_statics_url}/lib/chosen/chosen.jquery.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/js/jquery-migrate.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>

		<script type="text/javascript">
			ecjia.front.install.init();
		</script>
	</body>
</html>
{/nocache}