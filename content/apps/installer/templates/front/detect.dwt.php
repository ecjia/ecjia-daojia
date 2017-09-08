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
		<link rel="stylesheet" type="text/css" href="{$system_statics_url}/lib/fontello/css/fontello.css" />
	</head>
	
	<body id="maincontainer" style="height:auto;">
		{include file="./library/header.lbi.php"}
		<div class="container">
		    <div class="row">
		        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
			        {if $path_error}
					<div class="staticalert alert alert-error ui_showmessage path_error">{$path_error}</div>
					{/if}
		            <div class="column-14 start-06 ecjia-install">
						<form method="post" action='{RC_Uri::url("installer/index/deploy")}' name="check_form" onsubmit="return ecjia.front.install.check();">
							<div class="ecjia-install-body">
								<h4>系统环境</h4>
								<div class="span8">
									<table class="table">
						                <thead>
						                    <tr>
						                        <th width="200px;">检查项目</th>
						                        <th width="200px;">当前环境</th>
						                        <th>ECJIA到家建议</th>
						                        <th>功能影响</th>
						                    </tr>
						                </thead>
						                <tbody>
											<tr>
												<td>服务器操作系统</td>
											    <td>{$sys_info.os}</td>
											    <td>Windows_NT/Linux/Freebsd/Darwin</td>
											    <td>{$sys_info.os_info}</td>
											</tr>
											  
											<tr>
											    <td>WEB服务器</td>
											    <td>{$sys_info.web_server}</td>
											    <td>推荐Apache/Nginx/IIS</td>
											    <td>{$sys_info.web_server_info}</td>
											</tr>
											  
											<tr>
											    <td>PHP版本</td>
											    <td>{$sys_info.php_ver}</td>
											    <td>5.4及以上</td>
											    <td>{if $sys_info.php_ver gte '5.4'}<i class="fontello-icon-ok"></i>{else}<i class="fontello-icon-cancel"></i>{/if}</td>
											</tr>
											  
											<tr>
												<td>MySQLi扩展</td>
											    <td>{$sys_info.mysqli}</td>
											    <td>必须开启，请使用MySQL5.5以上版本</td>
											    <td>{$sys_info.mysqli}</td>
											</tr>
											
											<tr>
												<td>PDO扩展</td>
											    <td>{$sys_info.pdo}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.pdo}</td>
											</tr>
											  
											<tr>
											    <td>OpenSSL</td>
											    <td>{$sys_info.openssl}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.openssl}</td>
											</tr>	
											  
											<tr>
											    <td>Socket支持</td>
											    <td>{$sys_info.socket}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.socket}</td>
											</tr>
											  
											<tr>
											    <td>GD扩展</td>
											    <td>{$sys_info.gd}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.gd_info}</td>
											</tr>
											  
											<tr>
											    <td>CURL扩展</td>
											    <td>{$sys_info.curl}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.curl}</td>
											</tr>
											
											<tr>
											    <td>Fileinfo扩展</td>
											    <td>{$sys_info.fileinfo}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.fileinfo}</td>
											</tr>	
											  
											<tr>
											    <td>ZLIB扩展</td>
											    <td>{$sys_info.zlib}</td>
											    <td>必须开启</td>
											    <td>{$sys_info.zlib}</td>
											</tr>
											  
											<tr>
											    <td>DNS解析</td>
											    <td>{$sys_info.php_dns}</td>
											    <td>建议设置正确</td>
											    <td>{$sys_info.php_dns}</td>
											</tr>
											  
											<tr>
											    <td>安全模式</td>
											    <td>{$sys_info.safe_mode}</td>
											    <td>否</td>
											    <td>{if $sys_info.safe_mode eq '否'}<i class="fontello-icon-ok"></i>{else}<i class="fontello-icon-cancel"></i>{/if}</td>
											</tr>
											  
											<tr>
											    <td>文件上传大小</td>
											    <td>{$sys_info.max_filesize}</td>
											    <td>2M及以上</td>
											    <td>{$sys_info['filesize']}</td>
											</tr>						                
						                </tbody>
					           		</table>	
								</div>
								
								<h4>目录权限检测</h4>
								<div class="span8">
									<table class="table">
						                <thead>
						                    <tr>
						                       <th width="200px;">目录文件</th>
								   			   <th width="200px;">当前状态</th>
								    		   <th>所需状态</th>
						                    </tr>
						                </thead>
						                <tbody>
						                     <!-- {foreach from=$list item=item key=key} -->
											 <tr>
											    <td>{$item.item}</td>
											    <td>{if $item.m gt 0}<i class="fontello-icon-ok"></i>可写{else}<i class="fontello-icon-cancel"></i>不可写{/if}</td>
											    <td><i class="fontello-icon-ok"></i>可写</td>
											 </tr>
											 <!-- {/foreach} -->
						                </tbody>
					            	</table>	
								</div>
								
								<h4>模板可写性检查</h4>
								<div class="span8">
									{if $has_unwritable_tpl eq 'no'}
									<p>所有模板，全部可写</p>
									{else}
									<p style="color:red;">模板无法写入，请检查目录权限</p>
									{/if}
								</div>
						    </div> 
							<p class="submit">
								<input type="submit" class="btn primary configuration_system_btn {if $sys_info.is_right neq 1}disabled{/if}" value="开始下一步：配置系统 &raquo;" />
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		{include file="./library/footer.lbi.php"}
		
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
		
		<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
		<script src="{$front_url}/js/install.js" type="text/javascript"></script>
	</body>
</html>
{/nocache}