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
					<th class="w200">{lang key='mobile::mobile.mobile_news_img'}</th>
					<th>{lang key='mobile::mobile.content_title'}</th>
					<th class="w150">{lang key='mobile::mobile.create_time'}</th>
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
						<a class="data-pjax" href='{RC_Uri::url("mobile/admin_mobile_news/edit", "id={$item.id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{lang key='mobile::mobile.drop_mobile_news_confirm'}" href='{RC_Uri::url("mobile/admin_mobile_news/remove", "id={$item.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
				    </div>
				</td>
				<td>
			    	{$item.create_time}
				</td>
				
			</tr>
			<!-- {foreachelse} -->
			 <tr><td class="no-records" colspan="3">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</table>
		<!-- {$mobile_news.page} -->
	</div>
</div> 
<!-- {/block} -->