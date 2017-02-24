<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span12">
		<!-- {ecjia:hook id=admin_about_welcome} -->
		<ul class="nav nav-tabs">
			<li><a class="data-pjax" href="{url path='admincp/index/about_us'}">{t}关于ECJia{/t}</a></li>
			<li><a class="data-pjax"href="{url path='admincp/index/about_team'}">{t}ECJia团队{/t}</a></li>
			<li class="active"><a href="javascript:;">{t}系统信息{/t}</a></li>
		</ul>
		<div class="vcard">
			<ul style="margin-left: 0px;">
			    <li class="v-heading">
					{t}系统信息{/t}
				</li>
				<li>
					<span class="item-key">{t}ECJia 版本:{/t}</span>
					<div class="vcard-item">v{$ecjia_version} - {$ecjia_release}</div>
				</li>
				<li>
					<span class="item-key">{t}安装日期:{/t}</span>
					<div class="vcard-item">{$install_date}</div>
				</li>
				<li>
					<span class="item-key">{t}服务器操作系统:{/t}</span>
					<div class="vcard-item">{$sys_info.os} ({$sys_info.ip})</div>
				</li>
				<li>
					<span class="item-key">{t}PHP 版本:{/t}</span>
					<div class="vcard-item">{$sys_info.php_ver}</div>
				</li>
				<li>
					<span class="item-key">{t}MySQL 版本:{/t}</span>
					<div class="vcard-item">{$sys_info.mysql_ver}</div>
				</li>
				<li>
					<span class="item-key">{t}安全模式:{/t}</span>
					<div class="vcard-item">{$sys_info.safe_mode}</div>
				</li>
				<li>
					<span class="item-key">{t}Socket 支持:{/t}</span>
					<div class="vcard-item">{$sys_info.socket}</div>
				</li>
				<li>
					<span class="item-key">{t}时区设置:{/t}</span>
					<div class="vcard-item">{$sys_info.timezone}</div>
				</li>
				<li>
					<span class="item-key">{t}Zlib 支持:{/t}</span>
					<div class="vcard-item">{$sys_info.zlib}</div>
				</li>
				<li>
					<span class="item-key">{t}文件上传的最大大小:{/t}</span>
					<div class="vcard-item">{$sys_info.max_filesize}</div>
				</li>
				<li>
					<span class="item-key">{t}ROYALCMS 版本：{/t}</span>
					<div class="vcard-item">v{$sys_info.royalcms_version} release {$sys_info.royalcms_release}</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->