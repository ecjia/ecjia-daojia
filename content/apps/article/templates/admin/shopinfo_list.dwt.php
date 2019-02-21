<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
    	<table class="table table-striped" id="smpl_tbl">
    		<thead>
    			<tr>
    				<th class="w70">{t domain="article"}编号{/t}</th>
    				<th>{t domain="article"}网店标题{/t}</th>
    				<th class="w180">{t domain="article"}添加时间{/t}</th>
    				<th class="w70">{t domain="article"}操作{/t}</th>
    			</tr>
    		</thead>
    		<tbody>
    			<!-- {foreach from=$list item=item}-->
    			<tr>
    				<td align="center"><span>{$item.article_id}</span></td>
    				<td>
    					<input type="hidden" value="{$item.article_id}" />
    					<span class="article_info_name">{$item.title|escape:html}</span>
    				</td>
    				<td align="right"><span>{$item.add_time}</span></td>
    				<td align="right">
    					<span>
    						<a class="data-pjax no-underline" href='{RC_Uri::url("article/admin_shopinfo/edit", "id={$item.article_id}")}' title='{t domain="article"}编辑{/t}'><i class="fontello-icon-edit"></i></a>
    						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="article"}您确定要删除该网店信息吗？{/t}' href='{RC_Uri::url("article/admin_shopinfo/remove", "id={$item.article_id}")}' title='{t domain="article"}删除{/t}'><i class="fontello-icon-trash"></i></a>
    					</span>
    				</td>
    			</tr>
    			<!-- {foreachelse} -->
    			<tr><td class="no-records" colspan="4">{t domain="article"}没有找到任何记录{/t}</td></tr>
    			<!-- {/foreach} -->
    		</tbody>
    	</table>
	</div>
</div>
<!-- {/block} -->