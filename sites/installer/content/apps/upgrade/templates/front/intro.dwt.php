<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{extends file="./ecjia_upgrade.dwt.php"}

{block name="footer"}
<script type="text/javascript">

</script>
{/block}

{block name="main_content"}
	<div class="container">
	    <div class="row">
	        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
	            <div class="column-14 start-06 ecjia-install">
					<form method="post" name="check_form" id="js_ecjia_intro">
                        <div class="ecjia-install-body">
                            {t domain="installer" escape=no}<h5>
                                欢迎使用ECJia新零售商城系统，之前正在运行的版本是<span style="text-decoration:underline;font-size:16px;">v{$version_current}</span>，现在您已经覆盖了最新的升级包程序，
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
                                3. 模板堂不对升级ECJia系统过程中造成的数据丢失和其他损坏承担责任，继续升级则表示您同意此协议。<br />
                                4. 文件变动中含有“D”标识的表示删除，如是覆盖新版本，请确保这些文件已被手动移除，以免造成无法预料错误。<br />
                            </p>
                            <br>
                            <h4>升级版本</h4>
                            <div class="span8 old_version" data-url="{$ajax_change_files}">
                                <!-- {foreach from=$version_list item=ver} -->
                                <div>
                                    <h5>{$ver}</h5>
                                    <span></span>
                                    <i class="fontello-icon-angle-double-down old_version_item" data-ver="{$ver}"></i>
                                </div>
                                <!-- {/foreach} -->
                                <p>注：升级时遇到问题，可查看升级帮助文档说明（<a href="https://ecjia.com/wiki/%E5%88%86%E7%B1%BB:ECJiaWiki:Version" target="_blank">ECJia到家版本历史</a>）。</p>{/t}
                            </div>

                        </div>
						<input type="hidden" name="version_current" value="{$version_current}"/>
					    <input type="hidden" name="version_last" value="{$version_last}"/>
					    <input type="hidden" name="version_count" value="{$version_count}"/>
					    <input type="hidden" class="ajax_upgrade_url" value="{$ajax_upgrade_url}"/>
					    <input type="hidden" name="correct_img" value="{$correct_img}" />
	                    <input type="hidden" name="error_img" value="{$error_img}" />
	                    <input type="hidden" name="done" value="{RC_Uri::url('upgrade/index/finish')}" />
						<input type="button" id="ecjia_upgrade" class="btn primary configuration_system_btn" {if $disable} disabled="disabled" {/if}value="{t domain="upgrade"}下一步：开始升级{/t}&raquo;" />
					</form>
					<div class="ecjia-install-body">
						<div id="js-monitor">
						    <div id="js-monitor-panel">
						    	<h3 class="ecjia-install-title" id="js-monitor-wait-please">{t domain="upgrade"}正在升级{/t}</h3>
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
						    <input id="js-install-return-once" type="button" class="btn primary" value='{t domain="upgrade"}返回升级说明{/t}' onclick="location.href='{$init_url}'" style="display: none;"/>
						</div>
			    	</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
       var ver_list = {json_encode($version_list)};
    </script>
{/block}