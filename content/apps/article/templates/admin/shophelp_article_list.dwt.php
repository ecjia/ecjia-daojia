<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} --><small>{t}（{lang key='article::article.total'} {$list.num} {lang key='article::article.piece'}）{/t}</small>
		{if $action_linkadd}
		<a class="btn plus_or_reply data-pjax" href="{$action_linkadd.href}" id="sticky_a" ><i class="fontello-icon-plus"></i>{$action_linkadd.text}</a>
		{/if}
		
		{if $back_helpcat}
		<a class="btn plus_or_reply data-pjax" href="{$back_helpcat.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$back_helpcat.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
    	<table class="table table-striped" id="smpl_tbl">
    		<thead>
    			<tr>
    				<th>{lang key='article::shophelp.title'}</th>
    				<th class="w180">{lang key='article::shophelp.add_time'}</th>
    				<th class="w70">{lang key='system::system.handler'}</th>
    			</tr>
    		</thead>
    		<tbody>
    			<!-- {foreach from=$list.item item=item}-->
    			<tr>
    				<td>
    					<input type="hidden" value="{$item.article_id}" />
    					<span class="article_info_name">{$item.title|escape:html}</span>
    				</td>
    				
    				<td align="right"><span>{$item.add_time}</span></td>
    				<td align="right">
    					<span>
    						<a class="data-pjax no-underline" href='{url path="article/admin_shophelp/edit" args="cat_id=$cat_id&id={$item.article_id}"}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
    						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_article_confirm'}" href='{RC_Uri::url("article/admin_shophelp/remove_art","id={$item.article_id}")}' title="{lang key='system::system.remove'}"><i class="fontello-icon-trash"></i></a>
    					</span>
    				</td>
    			</tr>
    			<!-- {foreachelse} -->
    			<tr><td class="no-records" colspan="3">{lang key='system::system.no_records'}</td></tr>
    			<!-- {/foreach} -->
    		</tbody>
    	</table>
    	<!-- {$list.page} -->
	</div>
</div>
<!-- {/block} -->