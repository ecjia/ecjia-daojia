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
			<table class="table table-striped smpl_tbl">
				<thead>
					<tr>
						<th class="span3">{t}项目{/t}</th>
						<th class="span3">{t}可读权限{/t}</th>
						<th class="span3">{t}可写权限{/t}</th>
						<th class="span3">{t}可修改权限{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$list item=item key=key} -->
					<tr>
						<td width="250px">{$item.item}</td>
						<td>
							<!-- {if $item.r gt 0} -->
							<i class="fontello-icon-ok" title="YES"></i>
							<!-- {else} -->
							<i class="fontello-icon-cancel" title="NO"></i>
							<!-- {if $item.err_msg.w} -->
							&nbsp;<a href="javascript:;" onclick="$('#r_{$key}').toggle();" title="{lang key='system::check_file_priv.detail'}">{t}[详情]{/t}</a><br />
							<span class="notice-span" {if $help_open}style="display:block" {else} style="display:none" {/if} id="r_{$key}">
								<!-- {foreach from=$item.err_msg.r item=msg} -->{$msg}{lang key='system::check_file_priv.unread'}<br /><!-- {/foreach} -->
							</span>
							<!-- {/if} -->
							<!-- {/if} -->
						</td>

						<td>
							<!-- {if $item.w gt 0} -->
							<i class="fontello-icon-ok" title="YES"></i>
							<!-- {else} -->
							<i class="fontello-icon-cancel" title="NO"></i>
							<!-- {if $item.err_msg.w} -->&nbsp;<a href="javascript:;" onclick="$('#w_{$key}').toggle();" title="{lang key='system::check_file_priv.detail'}">{t}[详情]{/t}</a><br />
							<span class="notice-span" {if $help_open}style="display:block" {else} style="display:none" {/if} id="w_{$key}">
								<!-- {foreach from=$item.err_msg.w item=msg} -->{$msg}{lang key='system::check_file_priv.unwrite'}<br /><!-- {/foreach} -->
							</span>
							<!-- {/if} -->
							<!-- {/if} -->
						</td>

						<td>
							<!-- {if $item.m gt 0} -->
							<i class="fontello-icon-ok" title="YES"></i>
							<!-- {else} -->
							<i class="fontello-icon-cancel" title="NO"></i>
							<!-- {if $item.err_msg.m} -->&nbsp;<a href="javascript:;" onclick="$('#m_{$key}').toggle();" title="{lang key='system::check_file_priv.detail'}">{t}[详情]{/t}</a><br />
							<span class="notice-span" {if $help_open} style="display:block" {else} style="display:none" {/if} id="m_{$key}">
								<!-- {foreach from=$item.err_msg.m item=msg} -->{$msg}{lang key='system::check_file_priv.unmodify'}<br /><!-- {/foreach} -->
							</span>
							<!-- {/if} -->
							<!-- {/if} -->
						</td>
					</tr>
					<!-- {/foreach} -->
					<!-- {if $tpl_msg} -->
					<tr>
						<td colspan="4"><img src="images/no.gif" width="14" height="14" alt="NO" /><span style="color:red">{$tpl_msg}</span>{lang key='system::check_file_priv.unrename'}</td>
					</tr>
					<!-- {/if} -->
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- {/block} -->