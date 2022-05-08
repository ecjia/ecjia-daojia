<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{extends file="./ecjia_installer.dwt.php"}

{block name="main_content"}
<div class="container">
    <div class="row">
        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
	        {if $install_errors}
            {foreach $install_errors as $error}
			<div class="staticalert alert alert-error ui_showmessage path_error">{$error}</div>
            {/foreach}
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
				                        <th>{t domain="installer"}ECJIA建议{/t}</th>
				                        <th>{t domain="installer"}功能影响{/t}</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    {foreach $sys_info as $sys}
									<tr>
										<td>{$sys.name}</td>
									    <td>{$sys.value}</td>
									    <td>{$sys.suggest_label}</td>
									    <td>{$sys.checked_label}</td>
									</tr>
                                    {/foreach}
				                </tbody>
			           		</table>
						</div>

                        {if $dir_permission}
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
				                     <!-- {foreach from=$dir_permission item=item key=key} -->
									 <tr>
									    <td>{$item.name}</td>
									    <td>{$item.checked_label}</td>
									    <td>{$item.suggest_label}</td>
									 </tr>
									 <!-- {/foreach} -->
				                </tbody>
			            	</table>
						</div>
                        {/if}

                        {if $disable_functions}
                        <h4>{t domain="installer"}被禁用函数检测{/t}</h4>
                        <div class="span8">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="200px;">{t domain="installer"}函数名称{/t}</th>
                                    <th width="200px;">{t domain="installer"}当前状态{/t}</th>
                                    <th>{t domain="installer"}所需状态{/t}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- {foreach from=$disable_functions item=item key=key} -->
                                <tr>
                                    <td>{$item.name}</td>
                                    <td>{$item.checked_label}</td>
                                    <td>{$item.suggest_label}</td>
                                </tr>
                                <!-- {/foreach} -->
                                </tbody>
                            </table>
                        </div>
                        {/if}

				    </div>
					<p class="submit">
						<input type="submit" class="btn primary configuration_system_btn {if $check_right neq 1}disabled{/if}" value='{t domain="installer"}开始下一步：配置系统{/t} &raquo;' />
					</p>
				</form>
			</div>
            {/nocache}
		</div>
	</div>
</div>
{/block}