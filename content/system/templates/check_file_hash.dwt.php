<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->


<!-- {block name="footer"} -->
<script type="text/javascript">
    
    $('.ofolder').off('click').on('click', function() {
        var $this = $(this),
            i = $this.find('i');
        if (i.hasClass('fontello-icon-folder')) {
            i.addClass('fontello-icon-folder-open').removeClass('fontello-icon-folder');
        } else {
            i.addClass('fontello-icon-folder').removeClass('fontello-icon-folder-open');
        }
    });
    $('.check-btn').off('click').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
            href = $this.attr('href');
        $('#filehash_check_loding').modal('show');

        setTimeout(function () {
            ecjia.pjax(href, function () {
                $('#filehash_check_loding').modal('hide');
                $('.modal-backdrop').remove();
            })
        }, 500);
    });
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
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

                    <div class="alert alert-info">
                        <a class="close" data-dismiss="alert">×</a>
                        <div>{t}文件校验是针对 ECJia 官方发布的文件为基础进行核对，点击下面按钮开始进行校验。{/t}</div>
                        <div><strong>{t}技巧提示:{/t}</strong></div>
                        <ul id="tipslis">
                            <li>“<span class="stop_color"><i class="fontello-icon-attention-circled"></i>{t}被修改{/t}</span>”、
                                “<span class="error_color"><i class="fontello-icon-minus-circled"></i>{t}被删除{/t}</span>”
                                中的列出的文件，请即刻通过 FTP或其他工具检查其文件的正确性，以确保ECJia网站功能的正常使用。</li>
                            <li>“<span class="ok_color"><i class="fontello-icon-help-circled"></i>{t}未知{/t}</span>”
                                中的列出的文件，请检查网站是否被人非法放入了其他文件。</li>
                            <li style="">“<em class="unknown">一周内被修改</em>” 中列出的文件，请确认最近是否修改过。</li>

                        </ul>
                    </div>

                    <!-- {if empty($hashstatus)} -->
                    <div class="m_b20">
                    <p class="t_c">
                        <a class="btn data-pjax start-check check-btn" href="{$action_link.href}">
                            {t}开始校验{/t}
                        </a>
                    </p>
                    </div>
                    <!-- {else} -->
                    <h4 class="heading">
                        检测版本：{config('release.version')} <br />
                        上次检测时间：{date('Y-m-d H:i:s', $hashstatus->getMTime())}
                    </h4>

                    <table class="table table-striped smpl_tbl stop_color">
                        <thead>
                        <tr>
                            <th colspan="15">{t}校验结果{/t}</th>
                        </tr>
                        </thead>

                        <tr>
                            <td colspan="4">
                                <div class="stop_color">
                                    <!-- {foreach from=$counter key=key item=nums} -->
                                    {$counter_label.{$key}} ：{$nums}&nbsp;&nbsp;&nbsp;
                                    <!-- {/foreach} -->
                                </div>
                            </td>
                        </tr>

                        <!-- {if $dirlog } -->
                        <tr>
                            <th>{t}文件名{/t}</th>
                            <th>{t}文件大小{/t}</th>
                            <th>{t}最后修改时间{/t}</th>
                            <th>{t}状态{/t}</th>
                        </tr>

                        <!-- {foreach from=$dirlog key=dir item=status} -->
                        <tr>
                            <td colspan="4">
                                <a class="ofolder" onclick="$('#{$status.marker}').toggle()" href="javascript:;">
                                    <i class="fontello-icon-folder"></i>{$dir}
                                </a>
                                （
                                <!-- {if $status.modify} -->
                                <span class="stop_color">{t}被修改：{/t}{$status.modify} </span>
                                <!--{/if}-->
                                <!-- {if $status.missing} -->
                                <span class="stop_color">{t}被删除：{/t}{$status.missing} </span>
                                <!--{/if}-->
                                <!-- {if $status.new} -->
                                <span class="stop_color">{t}未知：{/t}{$status.new} </span>
                                <!--{/if}-->
                                ）
                            </td>
                        </tr>

                        <tbody id="{$status.marker}" style="display: none;">
                            <!-- {foreach from=$status.files item=file} -->
                            <tr>
                                <td><b><i class="fontello-icon-doc-inv m_l15"></i>{$file.file}</b></td>
                                <td>{$file.size}</td>
                                <td>{$file.filemtime}</td>
                                <td>{$file.status}</td>
                            </tr>
                            <!-- {/foreach} -->
                        </tbody>

                        <!-- {/foreach} -->
                        <!--{/if}-->

                    </table>

                    <!-- {if $action_link} -->
                    <div class="m_b20">
                        <a class="data-pjax btn plus_or_reply check-btn" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
                    </div>
                    <!-- {/if} -->

                    <!-- {/if} -->
				</div>

                <div class="span3">
                    <div class="setting-group m_b20">
                        <span class="setting-group-title"><i class="fontello-icon-cog"></i>文件校验</span>
                        <ul class="nav nav-list m_t10">
                            <!-- {foreach from=$sidebar_menus item=menu} -->
                            <!-- {if $menu.type == 'nav-header'} -->
                            <li class="nav-header">{$menu.title}</li>
                            <!-- {else} -->
                            <li><a class="setting-group-item
                            {if $menu.name == $group}
                            llv-active
                            {/if}
                            " href='{url path="@admin_filehash/init" args="group={$menu.name}"}'>{$menu.title}</a></li>
                            <!-- {/if} -->
                            <!-- {/foreach} -->
                        </ul>
                    </div>
                </div>
			</div>


		</div>
	</div>
</div>

<div class="modal hide" id="filehash_check_loding" aria-hidden="true" data-backdrop="static">
    <div class="modal-body" style="height: 200px;">
        <div class="check_loding_content" style="width: 300px;margin-top: 9%;margin-left: 24%;text-align: center;line-height: 30px;">
            <div>正在进行文件校验，请稍候...</div>
            <div><img src="../images/ajax_loader.gif" /></div>
            <div><a href="javascript:location.reload();">如果您的链接没有自动跳转，请点击这里</a></div>
        </div>
    </div>
</div>

<!-- {/block} -->