{nocache}
<!DOCTYPE html>
<html>
	<head lang="zh-CN">
	    {include file="./library/head_meta.lbi.php"}
	</head>
	<body id="maincontainer" style="height:auto;">
		{include file="./library/header.lbi.php"}
		<div class="container">
		    <div class="row">
		        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
		            <div class="column-14 start-06 ecjia-install">
						<form method="post" name="check_form" id="js_ecjia_intro">
							<div class="ecjia-install-body">
							    <h5>
							    欢迎使用ECJia到家O2O商城系统，之前正在运行的版本是<span style="text-decoration:underline;font-size:16px;">v{$version_current}</span>，现在您已经覆盖了最新的升级包程序，
							    请确保升级完成，以免造成意外的错误。
							    </h5>
								<h4 class="btn-ghost">最新版本：v{$version_last}</h4>
								<br />
								<h4>当前版本更新内容</h4>

								<pre>{$readme}</pre>
								
								<br>
								<h4>注意事项</h4>
								<p>
								   1. 本升级程序只适合官方发布的未经过修改的版本间升级，不适用于开发修改过的程序。<br />
								   2. 升级前请备份好相关数据和文件，以免出现数据丢失等意外情况。<br />
								   3. 模板堂不对升级ECJia到家系统过程中造成的数据丢失和其他损坏承担责任，继续升级则表示您同意此协议。<br />
								   4. 文件变动中含有“D”标识的表示删除，如是覆盖新版本，请确保这些文件已被手动移除，以免造成无法预料错误。<br />
								</p>
								<br>
								<h4>升级版本</h4>
								<div class="span8 old_version" data-url="{$ajax_change_files}">
								<!-- {foreach from=$version_list item=ver} -->
								<div>
								    <h5>{$ver}</h5><span></span><i class="fontello-icon-angle-double-down" data-ver="{$ver}"></i>
								</div>
							    <!-- {/foreach} -->
							    <p>注：M表示修改，A表示新增，D表示删除（文件需手动删除）</p>
								</div>
								
						    </div>
							<input type="hidden" name="version_current" value="{$version_current}"/>
						    <input type="hidden" name="version_last" value="{$version_last}"/>
						    <input type="hidden" name="version_count" value="{$version_count}"/>
						    <input type="hidden" class="ajax_upgrade_url" value="{$ajax_upgrade_url}"/>
						    <input type="hidden" name="correct_img" value="{$correct_img}" />
		                    <input type="hidden" name="error_img" value="{$error_img}" />
		                    <input type="hidden" name="done" value="{RC_Uri::url('upgrade/index/finish')}" />
							<input type="button" class="btn primary configuration_system_btn" {if $disable} disabled="disabled" {/if}value="下一步：开始升级&raquo;" onclick="return ecjia.front.upgrade.start();" />
						</form>
						
						<div class="ecjia-install-body">
							<div id="js-monitor">
							    <div id="js-monitor-panel">
							    	<h3 class="ecjia-install-title" id="js-monitor-wait-please">正在升级</h3>
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
							    <input id="js-install-return-once" type="button" class="btn primary" value="返回升级说明" onclick="location.href='{$init_url}'" style="display: none;"/>
							</div>
				    	</div>
				    	
					</div>
				</div>
			</div>
		</div>
		
		{include file="./library/footer.lbi.php"}
		<script type="text/javascript">
		   var ver_list = {json_encode($version_list)};
		</script>
		
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
		
		<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
		<script src="{$front_url}/js/upgrade.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
		<script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>

		<script type="text/javascript">
			ecjia.front.upgrade.init();
		</script>
	</body>
</html>
{/nocache}