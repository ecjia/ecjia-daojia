<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w200">{t domain="mobile"}今日热点主图{/t}</th>
					<th>{t domain="mobile"}内容标题{/t}</th>
					<th class="w150">{t domain="mobile"}创建时间{/t}</th>
				</tr>
			</thead>
			<!-- {foreach from=$mobile_news.item item=item key=key name=children} -->
			<tr>
				<td>
					<a href="{$item.image}" title="Image 10" target="_blank">
						<img class="w200 h100" alt="{$item.image}" src="{$item.image}">
					</a>
				</td>
				<td class="hide-edit-area">
					1、<span>{$item.title}</span><br>
					<!-- {foreach from=$item.children item=childitem key=k} -->
						{$k+2}、<span>{$childitem.title}</span><br>
					<!-- {/foreach} -->
					{$item.text}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("mobile/admin_mobile_news/edit", "id={$item.id}")}' title='{t domain="mobile"}编辑{/t}'>{t domain="mobile"}编辑{/t}</a>&nbsp;|&nbsp;
						<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="mobile"}您确定要删除该今日热点吗？{/t}' href='{RC_Uri::url("mobile/admin_mobile_news/remove", "id={$item.id}")}' title="{t domain="mobile"}删除{/t}">{t domain="mobile"}删除{/t}</a>
				    </div>
				</td>
				<td>
			    	{$item.create_time}
				</td>
				
			</tr>
			<!-- {foreachelse} -->
			 <tr><td class="no-records" colspan="3">{t domain="mobile"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
		</table>
		<!-- {$mobile_news.page} -->
	</div>
</div> 
<!-- {/block} -->