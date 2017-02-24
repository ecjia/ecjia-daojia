<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.admin_license.init();
</script>
<!-- {/block} -->


<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t}ECJia证书{/t}</strong>{t}是您享受ECJia软件服务的唯一标识，它记录了您的网店的授权信息、购买官方服务记录、短信帐户等重要信息。您需要通过“证书下载备份”功能备份证书，并妥善保管。在您遇到商店系统需要重新安装时，可以在新安装的系统中使用“证书上传恢复”功能将之前备份的证书恢复，这样新系统就可以继续使用证书内的重要信息。{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="fileupload {if $is_download eq 1}hide{/if}" data-action="{url path='@index/license_upload'}"></div>
		<div class="license-info {if $is_download eq 0}hide{/if}">
			<div class="certificate">
				<div class="license-detail">
					<p>{t}兹授予：{/t}</p>
					<p><span class="company-name">{$license_info.company_name}</span></p>
					<p>{t}为上海商创网络科技有限公司企业解决方案与产品商业伙伴{/t}</p>
					<p class="m_t10px">{t}授权级别：{/t}<span class="license-lv m_r30">{$license_info.license_level}</span>{t}授权域名：{/t}<span class="license-domain">{$license_info.license_domain}</span></p>
				</div>

				<div class="license-time">
					<p class="t_c">{t}授权时间：{/t}<span class="time">{$license_info.license_time}</span></p>
				</div>
			</div>
			<div class="t_c">
				<a class="btn btn-info m_r10" href="{url path='@index/license_download'}">{t}备份证书{/t}</a>
				<a class="btn btn-danger license-del" href="{url path='@index/license_delete'}">{t}删除证书{/t}</a>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->