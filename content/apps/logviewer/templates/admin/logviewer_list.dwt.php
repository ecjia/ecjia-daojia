<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.logviewer.init();
	ecjia.admin.admin_template.library();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $groups} -->
		<div class="pull-right list_choose{if !$full} hide{/if}">
            <select name="choose_librarys">
                <!-- {foreach from=$groups key=key item=v} -->
					<!-- {if $type && $key eq $type} -->
						<!-- {foreach from=$v item=val} -->
						<option {if $smarty.get.log_name eq $val} selected="selected"{/if} value="{url path='logviewer/admin/init' args="type={$type}&log_name={$val}&full=1"}">{$val}</option>
						<!-- {/foreach} -->
					<!-- {/if} -->
				<!-- {/foreach} -->
            </select>
        </div>
        <!-- {/if} -->
	</h3>
</div>

<!-- {if $groups} -->
<ul class="nav nav-pills">
	<!-- {foreach from=$groups key=key item=val} -->
	<li class="{if $key eq $type}active{/if}"><a class="data-pjax" href='{url path="logviewer/admin/init" args="type=$key"}'>{$key}<span class="badge badge-info unuse-plugins-num">{count($groups[$key])}</span></a></li>
	<!-- {/foreach} -->
</ul>
<!-- {/if} -->

<div class="row-fluid logviewer-list">
    <div class="span12">
        <div class="chat_box library-content">
            <div class="row-fluid">
                <div class="{if $full}span12{else}span9{/if} chat_content template_info">
                    <form class="template_form">
                        <div class="chat_heading clearfix">
                            <div class="pull-right"><i class="ecjiaf-csp{if $full} fontello-icon-resize-small{else} fontello-icon-resize-full{/if} enlarge"></i></div>
                            <span class="title">{if $log_name}{$log_name}{else}{t domain="logviewer"}未选择日志文件{/t}{/if}</span>
                        </div>

                        <div class="row-fluid">
                        	<div class="span12" id="editor">
								<table class="table table-striped" id="plugin-table">
									<thead>
										<tr>
											<th class="w150">{t domain="logviewer"}日期{/t}</th>
											<th class="w100">{t domain="logviewer"}等级{/t}</th>
							                <th>{t domain="logviewer"}内容{/t}</th>
										</tr>
									</thead>
									<tbody>
										<!-- {foreach from=$logs item=val} -->
										<tr>
											<td>{$val.date}</td>
											<td>
												<!-- {if $val.level_img eq 'emergency' || $val.level_img eq 'error' || $val.level_img eq 'warning' || $val.level_img eq 'critical' || $val.level_img eq 'alert'} -->
												<i class="ecjiafc-red fontello-icon-attention"></i>
												<!-- {elseif $val.level_img eq 'debug' || $val.level_img eq 'info' || $val.level_img eq 'notice'} -->
												<i class="ecjiafc-blue fontello-icon-attention-circled"></i>
												<!-- {/if} -->
												{$val.level}
											</td>
											<td>
                                                <span class="ecjiaf-pre">{$val.text|htmlspecialchars}</span>
                                                <br />
                                                <span class="ecjiaf-pre">{$val.stack|htmlspecialchars}</span>
                                            </td>
										</tr>
										<!-- {/foreach} -->
									</tbody>
								</table>
							</div>
						</div>
                    </form>
                </div>

                <div class="span3 chat_sidebar{if $full} hide{/if}">
                    <div class="chat_heading clearfix">
                        {t domain="logviewer"}日志文件{/t}
                    </div>
                    <div class="ms-selectable">
                        <div class="template_list" id="ms-custom-navigation">
                            <input class="span12" id="ms-search" type="text" placeholder='{t domain="logviewer"}筛选搜索到的日志文件{/t}' autocomplete="off">
                            <ul class="unstyled">
                            <!-- {if $groups} -->
								<!-- {foreach from=$groups key=key item=v} -->
									<!-- {if $type && $key eq $type} -->
										<!-- {foreach from=$v item=val key=k} -->
										<li class="ms-elem-selectable"><a class="no-underline data-pjax{if $smarty.get.log_name eq $val} choose{elseif !$smarty.get.log_name && $k eq 0} choose{/if}" href="{url path='logviewer/admin/init' args="type={$type}&log_name={$val}&full=0"}">{$val}</a></li>
										<!-- {/foreach} -->
									<!-- {/if} -->
								<!-- {/foreach} -->
							<!-- {else} -->
								<li class="ms-elem-selectable">{t domain="logviewer"}暂无日志{/t}</li>
							<!-- {/if} -->
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
