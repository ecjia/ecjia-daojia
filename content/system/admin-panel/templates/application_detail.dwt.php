<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.application.install();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="stepy-wizzard form-horizontal application-installer" id="validate_wizard" action='{url path="@admin_application/install" args="id={$smarty.get.id}"}' method="post">
			<fieldset title="{t}查看详情{/t}">
				<legend class="hide">{t}查看应用的详细信息{/t}&hellip;</legend>
				<div class="formSep control-group">
					<div class="application-info">
						<p class="muted">{t}应用名称{/t}</p>
						<h2 class="text-info">{$application.format_name}</h2>
						<input name="v_requirestate" type="hidden" />
						<br />
						<ul class="application-sketch inline">
							<li>
								<p><i class="fontello-icon-angle-circled-right"></i>{t}应用包名：{/t}</p>
								<span>{$application.identifier}</span>
							</li>
							<li>
								<p><i class="fontello-icon-angle-circled-right"></i>{t}应用版本：{/t}</p>
								<span>{$application.version}</span>
							</li>
							<li>
								<p><i class="fontello-icon-angle-circled-right"></i>{t}应用目录：{/t}</p>
								<span>{$application.directory}/</span>
							</li>
						</ul>

					</div>
				</div>
				<div>
					<dl class="application-detailed">
						<dt>{t}应用作者：{/t}</dt>
						<dd><a href="{$application.website}" target="_blank">{$application.author}</a></dd>
						<dt>{t}版权信息：{/t}</dt>
						<dd>{$application.copyright}</dd>
						<dt>{t}应用描述：{/t}</dt>
						<dd>{$application.format_description}</dd>
					</dl>
				</div>
			</fieldset>
			<!-- {if $is_install} -->
			<fieldset title="{t}安装完成{/t}">
				<legend class="hide">{t}安装进度及完成结果{/t}&hellip;</legend>
				<div class="control-group">
				</div>
				<div class="control-group">
					<div class="successfully-installed">
						<div class="media ecjiaf-opa0">
							<i class="pull-left fontello-icon-ok-circled"></i>
							<div class="media-body">
								<h4 class="media-heading">{t}应用安装成功！{/t}</h4>
								{$application.format_name}{t}应用已经安装到您的系统中！{/t}
								<div class="media-href">
									<a href="{url path='@admin_application/init'}">{t}返回应用列表{/t}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- {/if} -->
		</form>
	</div>
</div>
<!-- {/block} -->