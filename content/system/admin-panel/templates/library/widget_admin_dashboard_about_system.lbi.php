<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="move-mod-group" id="widget_admin_dashboard_loglist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
	</div>
	<table class="table table-striped table-bordered mediaTable ecjiaf-wwb">
		<tbody>
            <tr>
                <td>{t}ECJia 版本{/t} <span class="ecjiaf-fr">v{$sys_info.ecjia_version} - {$sys_info.ecjia_release}</span></td>
            </tr>
            <tr>
                <td>{t}ROYALCMS 版本{/t} <span class="ecjiaf-fr">v{$sys_info.royalcms_version} release {$sys_info.royalcms_release}</span></td>
            </tr>
            <tr>
                <td>{t}Laravel 版本{/t} <span class="ecjiaf-fr">v{$sys_info.laravel_version}</span></td>
            </tr>
            <tr>
                <td>{t}安装日期{/t} <span class="ecjiaf-fr">{$sys_info.install_date}</span></td>
            </tr>
            <tr>
                <td>{t}服务器操作系统{/t} <span class="ecjiaf-fr">{$sys_info.os} ({$sys_info.ip})</span></td>
            </tr>
            <tr>
                <td>{t}PHP 版本{/t} <span class="ecjiaf-fr">{$sys_info.php_ver}</span></td>
            </tr>
            <tr>
                <td>{t}MySQL 版本{/t} <span class="ecjiaf-fr">{$sys_info.mysql_ver}</span></td>
            </tr>
		</tbody>
	</table>
</div>