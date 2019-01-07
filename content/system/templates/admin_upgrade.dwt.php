<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.upgrade.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if empty($versions)} -->
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">×</a>
    {t}注意：若您未检测到可用更新，您还可以到{/t} <a target="_blank" href="https://www.ecjia.com/download.html"><strong>https://www.ecjia.com/download.html</strong></a> {t}查看。{/t}
</div>
<!-- {/if} -->

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>

<div id="upgrade">
	<div class="row-fluid">
		<div class="span12">

            <div class="row-fluid">

                <div class="span9">
                    <h3>
                        您当前使用的版本是Ver. {config('release.version')}，构建日期是{config('release.build')}。<br />
                    </h3>
                    <div class="heading">
                        最后检查于：{$check_upgrade_time}
                    </div>

                    <!-- {if !empty($version)} -->
                    <table class="table table-striped smpl_tbl newVer">
                        <thead>
                            <tr>
                                <th>{t}有新版本啦！！！{/t}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td><img src="{RC_Uri::admin_url('statics/images/upgrade.png')}" width="25" height="25" /> Ver. <strong>{$version->getVersion()}</strong> </td>
                            </tr>
                            <tr>
                                <td>构建日期：{$version->getBuild()} </td>
                            </tr>
                            <tr>
                                <td><h4><i class="fontello-icon-folder-open"></i> 更新介绍</h4></td>
                            </tr>
                            <tr>
                                <td><pre>{$version->getReadme()}</pre></td>
                            </tr>

                            <!-- {if !empty($version->getModifyFileList())} -->
                            <tr>
                                <td><h4><i class="fontello-icon-folder-open"></i> 修改文件 （{count($version->getModifyFileList())}个）</h4></td>
                            </tr>
                            <!-- {foreach $version->getModifyFileList() as $index => $file} -->
                            <tr>
                                <td>{$index+1}. {$file}</td>
                            </tr>
                            <!-- {/foreach} -->
                            <!-- {/if} -->


                            <!-- {if !empty($version->getNewFileList())} -->
                            <tr>
                                <td><h4><i class="fontello-icon-folder-open"></i> 新增文件 （{count($version->getNewFileList())}个）</h4></td>
                            </tr>
                            <!-- {foreach $version->getNewFileList() as $index => $file} -->
                            <tr>
                                <td>{$index+1}. {$file}</td>
                            </tr>
                            <!-- {/foreach} -->
                            <!-- {/if} -->


                            <!-- {if !empty($version->getDeleteFileList())} -->
                            <tr>
                                <td><h4><i class="fontello-icon-folder-open"></i> 删除文件 （{count($version->getDeleteFileList())}个）</h4></td>
                            </tr>
                            <!-- {foreach $version->getDeleteFileList() as $index => $file} -->
                            <tr>
                                <td>{$index+1}. {$file}</td>
                            </tr>
                            <!-- {/foreach} -->
                            <!-- {/if} -->

                        </tbody>
                    </table>
                    <!-- {else} -->
                    <div class="m_b20">
                        <h4><i>你当前使用的已经是最新版本了。</i></h4>
                    </div>
                    <!-- {/if} -->

                    <div class="m_b20">
                        <a class="data-pjax btn plus_or_reply check-btn" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
                        <!-- {if !empty($version)} -->
                        <a class="btn" target="_blank" href="{$version->getHelpLink()}">升级帮助</a>
                        <a class="btn btn-info" target="_blank" href="{$version->getDownloadLink()}">下载升级补丁</a>
                        <!-- {/if} -->
                    </div>

                </div>

                <div class="span3">

                    <div class="setting-group m_b20">
                        <span class="setting-group-title"><i class="fontello-icon-cog"></i>更新版本</span>
                        <ul class="nav nav-list m_t10">
                            <!-- {foreach from=$versions item=version} -->
                            <li><a class="setting-group-item
                            {if $version->getVersion() == $current_version}
                            llv-active
                            {/if}
                            " href='{url path="@upgrade/init" args="version={$version->getVersion()}"}'>Ver. {$version->getVersion()}</a></li>
                            <!-- {foreachelse} -->
                            <li>没有可用更新版本！</li>
                            <!-- {/foreach} -->
                        </ul>
                    </div>

                </div>
            </div>
		</div>
	</div>
</div>

<div class="modal hide" id="check_loding" aria-hidden="true" data-backdrop="static">
    <div class="modal-body" style="height: 200px;">
        <div class="check_loding_content" style="width: 300px;margin-top: 9%;margin-left: 24%;text-align: center;line-height: 30px;">
            <div>正在进行新版本检测，请稍候...</div>
            <div><img src="../images/ajax_loader.gif" /></div>
            <div><a href="javascript:location.reload();">如果您的链接没有自动跳转，请点击这里</a></div>
        </div>
    </div>
</div>

<!-- {/block} -->