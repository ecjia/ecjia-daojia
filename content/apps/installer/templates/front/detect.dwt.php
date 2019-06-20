<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{extends file="./ecjia_installer.dwt.php"}

{block name="main_content"}
<div class="container">
    <div class="row">
        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
	        {if $path_error}
			<div class="staticalert alert alert-error ui_showmessage path_error">{$path_error}</div>
			{/if}
            {nocache}
            <div class="column-14 start-06 ecjia-install">
				<form method="post" action='{RC_Uri::url("installer/index/deploy")}' name="check_form" onsubmit="return ecjia.front.install.check();">
					<div class="ecjia-install-body">
						<h4>{t domain="installer"}系统环境{/t}</h4>
						<div class="span8">
							<table class="table">
				                <thead>
				                    <tr>
				                        <th width="200px;">{t domain="installer"}检查项目{/t}</th>
				                        <th width="200px;">{t domain="installer"}当前环境{/t}</th>
				                        <th>{t domain="installer"}ECJIA到家建议{/t}</th>
				                        <th>{t domain="installer"}功能影响{/t}</th>
				                    </tr>
				                </thead>
				                <tbody>
									<tr>
										<td>{t domain="installer"}服务器操作系统{/t}</td>
									    <td>{$sys_info.os}</td>
									    <td>Windows_NT/Linux/Freebsd/Darwin</td>
									    <td>{$sys_info.os_info}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}WEB服务器{/t}</td>
									    <td>{$sys_info.web_server}</td>
									    <td>{t domain="installer" 1="Apache/Nginx/IIS"}推荐%1{/t}</td>
									    <td>{$sys_info.web_server_info}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}PHP版本{/t}</td>
									    <td>{$sys_info.php_ver}</td>
									    <td>{t domain="installer"}5.5及以上{/t}</td>
									    <td>{if $sys_info.php_check}<i class="fontello-icon-ok"></i>{else}<i class="fontello-icon-cancel"></i>{/if}</td>
									</tr>
									  
									<tr>
										<td>{t domain="installer"}MySQLi扩展{/t}</td>
									    <td>{$sys_info.mysqli}</td>
									    <td>{t domain="installer"}必须开启，请使用MySQL5.5以上版本{/t}</td>
									    <td>{$sys_info.mysqli}</td>
									</tr>
									
									<tr>
										<td>{t domain="installer"}PDO扩展{/t}</td>
									    <td>{$sys_info.pdo}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.pdo}</td>
									</tr>
									  
									<tr>
									    <td>OpenSSL</td>
									    <td>{$sys_info.openssl}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.openssl}</td>
									</tr>	
									  
									<tr>
									    <td>{t domain="installer"}Socket支持{/t}</td>
									    <td>{$sys_info.socket}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.socket}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}GD扩展{/t}</td>
									    <td>{$sys_info.gd}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.gd_info}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}CURL扩展{/t}</td>
									    <td>{$sys_info.curl}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.curl}</td>
									</tr>
									
									<tr>
									    <td>{t domain="installer"}Fileinfo扩展{/t}</td>
									    <td>{$sys_info.fileinfo}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.fileinfo}</td>
									</tr>	
									  
									<tr>
									    <td>{t domain="installer"}ZLIB扩展{/t}</td>
									    <td>{$sys_info.zlib}</td>
									    <td>{t domain="installer"}必须开启{/t}</td>
									    <td>{$sys_info.zlib}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}DNS解析{/t}</td>
									    <td>{$sys_info.php_dns}</td>
									    <td>{t domain="installer"}建议设置正确{/t}</td>
									    <td>{$sys_info.php_dns}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}安全模式{/t}</td>
									    <td>{$sys_info.safe_mode}</td>
									    <td>{t domain="installer"}否{/t}</td>
									    <td>{if $sys_info.safe_mode eq '否'}<i class="fontello-icon-ok"></i>{else}<i class="fontello-icon-cancel"></i>{/if}</td>
									</tr>
									  
									<tr>
									    <td>{t domain="installer"}文件上传大小{/t}</td>
									    <td>{$sys_info.max_filesize}</td>
									    <td>{t domain="installer"}2M及以上{/t}</td>
									    <td>{$sys_info['filesize']}</td>
									</tr>						                
				                </tbody>
			           		</table>	
						</div>
						
						<h4>{t domain="installer"}目录权限检测{/t}</h4>
						<div class="span8">
							<table class="table">
				                <thead>
				                    <tr>
				                       <th width="200px;">{t domain="installer"}目录文件{/t}</th>
						   			   <th width="200px;">{t domain="installer"}当前状态{/t}</th>
						    		   <th>{t domain="installer"}所需状态{/t}</th>
				                    </tr>
				                </thead>
				                <tbody>
				                     <!-- {foreach from=$list item=item key=key} -->
									 <tr>
									    <td>{$item.item}</td>
									    <td>{if $item.m gt 0}<i class="fontello-icon-ok"></i>{t domain="installer"}可写{/t}{else}<i class="fontello-icon-cancel"></i>{t domain="installer"}不可写{/t}{/if}</td>
									    <td><i class="fontello-icon-ok"></i>{t domain="installer"}可写{/t}</td>
									 </tr>
									 <!-- {/foreach} -->
				                </tbody>
			            	</table>	
						</div>
						
						<h4>{t domain="installer"}模板可写性检查{/t}</h4>
						<div class="span8">
							{if $has_unwritable_tpl eq 'no'}
							<p>{t domain="installer"}所有模板，全部可写{/t}</p>
							{else}
							<p style="color:red;">{t domain="installer"}模板无法写入，请检查目录权限{/t}</p>
							{/if}
						</div>
				    </div> 
					<p class="submit">
						<input type="submit" class="btn primary configuration_system_btn {if $sys_info.is_right neq 1}disabled{/if}" value='{t domain="installer"}开始下一步：配置系统{/t} &raquo;' />
					</p>
				</form>
			</div>
            {/nocache}
		</div>
	</div>
</div>
{/block}