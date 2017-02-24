<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
	<div>
		<h3 class="heading">
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h3>
	</div>

	<div id="upgrade">
		<!-- {if $nav_tabs} -->
		<ul class="nav nav-tabs">
			<!-- {foreach from=$nav_tabs item=tab} -->
			<!-- {if $tab.key neq $smarty.const.ROUTE_A} -->
			<li><a class="data-pjax" href="{$tab.url}">{$tab.title}</a></li>
			<!-- {else} -->
			<li class="active"><a href="javascript:;">{$tab.title}</a></li>
			<!-- {/if} -->
			<!-- {/foreach} -->
		</ul>
		<!-- {/if} -->

		<div class="row-fluid">
			<div class="span12">
				<!-- {if $smarty.get.step neq 2} -->
				<div class="alert alert-info">
					<a class="close" data-dismiss="alert">×</a>
					<span>{t}文件校验是针对 ECJia 官方发布的文件为基础进行核对，点击下面按钮开始进行校验。{/t}</span>
				</div>
				<p class="t_c"><a class="btn data-pjax start-check" href="{url path='@upgrade/check_file_md5' args='step=2'}">{t}开始校验{/t}</a></p>
				<!-- {else} -->
				<div class="alert alert-info">
					<a class="close" data-dismiss="alert">×</a>
					
					<div style="padding:10px;font-weight:bold">{t}技巧提示:{/t}</div>
					<ul id="tipslis">
							<li>“<span class="stop_color"><i class="fontello-icon-attention-circled"></i>{t}被修改{/t}</span>”、“<span class="error_color"><i class="fontello-icon-minus-circled"></i>{t}被删除{/t}</span>{t}” 中的列出的文件，请即刻通过 FTP 或其他工具检查其文件的正确性，以确保ECJia网店功能的正常使用。{/t}</li>
						    <li>“<span class="ok_color"><i class="fontello-icon-help-circled"></i>{t}未知{/t}</span>” 中的列出的文件，请检查网店是否被人非法放入了其他文件。</li>
						    <li style="">{t}“{/t}<em class="unknown">{t}一周内被修改{/t}</em>{t}” 中列出的文件，请确认最近是否修改过。{/t}</li>

					</ul>
				</div>
				<table class="table table-striped smpl_tbl stop_color" >
					<thead>
						<tr>
							<th colspan="15">{t}校验结果{/t}</th>
						</tr>
					</thead>

					<tr>
						<td colspan="4">
							<div class="stop_color">
							<!-- {foreach from=$result key=files item=nums} -->
								{$files} ：{$nums}&nbsp;&nbsp;&nbsp;
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
							<!-- <div class="left"> -->
							<a class="ofolder" onclick="$('#{$status.marker}').toggle()" href="javascript:;"><i class="fontello-icon-folder-open"></i>{$dir}/</a>
							<!-- </div> -->
							<!-- {foreach from=$status key=type item=nums} -->
							<!-- {if $type eq 'modify'} -->
							<span class="stop_color">{t}被修改：{/t}{$nums}   </span>
							<!--{/if}-->
							<!-- {if $type eq 'del'} -->
							<span class="stop_color">{t}被删除：{/t}{$nums}   </span>
							<!--{/if}-->
							<!-- {if $type eq 'add'} -->
							<span class="stop_color">{t}未知：{/t}{$nums}   </span>
							<!--{/if}-->
							<!-- {/foreach} -->
						</td>
					</tr>
					<tbody id="{$status.marker}">
					<!-- {foreach from=$filelist key=dirs item=files} -->
					<!-- {if $dirs == $dir}-->
					<!-- {foreach from=$files item=file} -->
					<tr>
						<td><b><i class="fontello-icon-doc-inv m_l15"></i>{$file.file}</b></td>
						<td>{$file.size}</td>
						<td>{$file.filemtime}</td>
						<td>{$file.status}</td>
					</tr>
					<!-- {/foreach} -->
					<!--{/if}-->
					<!-- {/foreach} -->
					</tbody>
					<!-- {/foreach} -->
					<!--{/if}-->

				</table>
				{/if}
			</div>
		</div>
	</div>
<!-- {/block} -->