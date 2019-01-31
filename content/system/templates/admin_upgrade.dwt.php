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
     {t escape=no url="https://www.ecjia.com/download.html" name="https://www.ecjia.com/download.html"}注意：若您未检测到可用更新，您还可以到 <a target="_blank" href="%1"><strong>%2</strong></a> 查看。{/t}
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
                        {t 1={config('release.version')} 2={config('release.build')}}您当前使用的版本是Ver. %1，构建日期是%2。{/t}<br />
                    </h3>
                    <div class="heading">
                        {t}最后检查于：{/t}{$check_upgrade_time}
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
                                <td>{t}构建日期：{/t}{$version->getBuild()} </td>
                            </tr>
                            <tr class="toggle-display cursor_pointer">
                                <td><h4><i class="fontello-icon-folder-open"></i> {t}更新介绍{/t}<i class="f_r fontello-icon-down-open"></i></h4></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <tr>
                                    <td><pre>{$version->getReadme()}</pre></td>
                                </tr>
                            </tr>
                        </tbody>

                        <!-- {if !empty($version->getModifyFileList())} -->
                        <tbody>
                            <tr class="toggle-display cursor_pointer">
                                <td><h4><i class="fontello-icon-folder"></i> {t 1={count($version->getModifyFileList())}}修改文件 （%1个）{/t}<i class="f_r fontello-icon-up-open"></i></h4></td>
                            </tr>
                        </tbody>
                        <tbody class="ecjiaf-dn">
                            <!-- {foreach $version->getModifyFileList() as $index => $file} -->
                            <tr>
                                <td>{$index+1}. {$file}</td>
                            </tr>
                            <!-- {/foreach} -->
                        </tbody>
                        <!-- {/if} -->


                        <!-- {if !empty($version->getNewFileList())} -->
                        <tbody>
                            <tr class="toggle-display cursor_pointer">
                                <td><h4><i class="fontello-icon-folder"></i> {t 1={count($version->getNewFileList())}}新增文件 （%1个）{/t}<i class="f_r fontello-icon-up-open"></i></h4></td>
                            </tr>
                        </tbody>
                        <tbody class="ecjiaf-dn">
                            <!-- {foreach $version->getNewFileList() as $index => $file} -->
                            <tr>
                                <td>{$index+1}. {$file}</td>
                            </tr>
                            <!-- {/foreach} -->
                        </tbody>
                        <!-- {/if} -->

                        <!-- {if !empty($version->getDeleteFileList())} -->
                        <tbody>
                            <tr class="toggle-display cursor_pointer">
                                <td><h4><i class="fontello-icon-folder"></i> {t 1={count($version->getDeleteFileList())}}删除文件 （%1个）{/t}<i class="f_r fontello-icon-up-open"></i></h4></td>
                            </tr>
                        </tbody>
                        <tbody class="ecjiaf-dn">
                            <!-- {foreach $version->getDeleteFileList() as $index => $file} -->
                            <tr>
                                <td>{$index+1}. {$file}</td>
                            </tr>
                            <!-- {/foreach} -->
                        </tbody>
                        <!-- {/if} -->

                    </table>
                    <!-- {else} -->
                    <div class="m_b20">
                        <h4><i>{t}你当前使用的已经是最新版本了。{/t}</i></h4>
                    </div>
                    <!-- {/if} -->

                    <div class="m_b20">
                        <a class="data-pjax btn plus_or_reply check-btn" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
                        <!-- {if !empty($version)} -->
                        <a class="btn" target="_blank" href="{$version->getHelpLink()}">{t}升级帮助{/t}</a>
                        <a class="btn btn-info" target="_blank" href="{$version->getDownloadLink()}">{t}下载升级补丁{/t}</a>
                        <!-- {/if} -->
                    </div>

                </div>

                <div class="span3">

                    <div class="setting-group m_b20">
                        <span class="setting-group-title"><i class="fontello-icon-cog"></i>{t}更新版本{/t}</span>
                        <ul class="nav nav-list m_t10">
                            <!-- {foreach from=$versions item=version} -->
                            <li><a class="setting-group-item
                            {if $version->getVersion() == $current_version}
                            llv-active
                            {/if}
                            " href='{url path="@upgrade/init" args="version={$version->getVersion()}"}'>Ver. {$version->getVersion()}</a></li>
                            <!-- {foreachelse} -->
                            <li>{t}没有可用更新版本！{/t}</li>
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
            <div>{t}正在进行新版本检测，请稍候...{/t}</div>
            <div><img src="../images/ajax_loader.gif" /></div>
            <div><a href="javascript:location.reload();">{t}如果您的链接没有自动跳转，请点击这里{/t}</a></div>
        </div>
    </div>
</div>

<!-- {/block} -->