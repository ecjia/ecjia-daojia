<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cron_config.init();
</script>
<!-- {/block} -->

{*
<!-- {block name="admin_shop_config_nav"} -->
<div class="setting-group">
    <span class="setting-group-title"><i class="fontello-icon-cog"></i>设置</span>
    <ul class="nav nav-list m_t10">
        <li class="nav-header">计划任务</li>
        <li><a class="setting-group-item llv-active" href="{url path='cron/admin_config/init'}">计划任务</a></li>
    </ul>
</div>
<!-- {/block} -->
*}

<!-- {block name="admin_config_form"} -->
<div class="row-fluid">
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" >
		<fieldset>
			<div>
				<h3 class="heading">
					<!-- {if $ur_here}{$ur_here}{/if} -->
				</h3>
			</div>
			
			<div class="control-group formSep">
				<label class="control-label">{t domain="cron"}开启WEB调用计划任务：{/t}</label>
				<div class="controls">
					 <input type="radio" name="cron_method" value="0" {if $cron_method eq 0} checked="true" {/if} />{t domain="cron"}否{/t}
		        	 <input type="radio" name="cron_method" value="1" {if $cron_method eq 1} checked="true" {/if} />{t domain="cron"}是{/t}
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" value='{t domain="cron"}确定{/t}' class="btn btn-gebo" />
				</div>
			</div>
		</fieldset>
	</form>
</div>
	
<div class="row-fluid">
	<div>
		<h3 class="heading">{if $ur_here_key}{$ur_here_key}{/if}</h3>
	</div>
	
	<div class="message_content">{t domain="cron"}消息签名密钥由32位字符组成，字符范围为A-Z，a-z，0-9。{/t}</div>
	<div class="api_secret">{if $cron_secret_key}{$cron_secret_key}{else}<i class="no_content">{t domain="cron"}暂无计划任务秘钥{/t}</i>{/if}</div>
	
	<div class="cron-btn">
		{if $cron_secret_key}
			<a class="update_key" data-msg='{t domain="cron"}若更换，之前的请求地址将不可用。请重新部署计划任务请求地址。{/t}' data-href='{url path="cron/admin_config/update_key"}'>
				<button class="btn btn-gebo" type="button">{t domain="cron"}更换{/t}</button>
			</a>
		{else}
			<a class="get_key" data-href='{url path="cron/admin_config/update_key"}'>
				<button class="btn btn-gebo" type="button">{t domain="cron"}获取{/t}</button>
			</a>
		{/if}
	</div>
</div>
	
<div class="row-fluid">
	<div>
		<h3 class="heading">{if $ur_here_deploy}{$ur_here_deploy}{/if}</h3>
	</div>
	
	<h4>{t domain="cron"}使用Cron的集成路由{/t}</h4><br>
	<div class="message_content">
		<p>{t domain="cron"}如果您没有Shell访问您的服务器，您可以轻松使用在线cronjob服务（Google知道一些好的提供商）。此提供程序将以定义的间隔运行Cron的路由。 Cron路由必须受到保护，因为如果服务提供者之间的其他人调用它，我们的作业将被执行得太频繁。因此，除了路由路径之外，我们还需要一个安全密钥。该密钥可以通过重置命令后生成调用，并且必须在cron配置文件中设置密钥cronSecretKey。{/t}</p>
		<p>{t domain="cron"}现在您必须在在线cronjob服务提供商配置地址和运行间隔。集成Cron路由的地址始终为{/t}</p>
		<p><strong>http://yourdomain.com/sites/cron/?key=securitykey</strong></p>
		<p>{t domain="cron"}对于上述示例，此地址可以是{/t}</p>
		<p><strong>http://exampledomain.com/sites/cron/?key=1PBgabAXdoLTy3JDyi0xRpTR2qNrkkQy</strong>{t domain="cron"}，并且运行间隔必须是每分钟。{/t}</p>
		<p>{t domain="cron"}方式一：Linux服务器上运行，可以使用crontab计划任务执行。{/t}<p>
		<div class="api_secret_cron" style="height:50px;">
			<p>* * * * * wget  -t 1 -T 0 -q --spider {$cron_url}<p>
		</div>
		<p style="margin-top: 10px;">{t domain="cron"}方式二：Linux服务器上运行，可以使用crontab计划任务执行。{/t}</p>
        <p>{t domain="cron"}注：path 换成你网站的根路径{/t}</p>
		<div class="api_secret_cron" style="height:50px;">
            <p>*/1 * * * * /path/ecjia cron:run<p>
		</div>
        <p style="margin-top: 10px;">{t domain="cron"}方式三：在线cronjob服务器，可以配置地址和运行时间间隔。{/t}</p>
        <div class="api_secret_cron" style="height:50px;">
            <p>{$cron_url}<p>
        </div>
	</div>
</div>
<!-- {/block} -->