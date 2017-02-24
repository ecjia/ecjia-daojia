<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.article_auto.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

{if $crons_enable neq 1}
<div class="alert alert-info">
	<strong>{lang key='article::article.tips'}</strong>{lang key='article::article.enable_notice'}
</div>
{/if}
	    
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href} data-pjax" class="btn plus_or_reply" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>	    
	
<div class="row-fluid list-page">
	<div class="span12">
		<div class="row-fluid batch">
			<div class="f_l form-inline">
				<input type="text" name="select_time" class="w150 date" placeholder="{lang key='article::article.choose_time'}">
				<a class="btn btnSubmit" data-idClass=".checkbox:checked" data-url='{url path="article/admin_article_auto/batch" args="type=batch_start{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg="{lang key='article::article.batch_issue_confirm'}" data-noSelectMsg="{lang key='article::article.select_article_msg'}" data-name="article_id" href="javascript:;" >{lang key='article::article.button_start'}</a>
				<a class="btn btnSubmit" data-idClass=".checkbox:checked" data-url='{url path="article/admin_article_auto/batch" args="type=batch_end{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg="{lang key='article::article.batch_cancel_confirm'}" data-noSelectMsg="{lang key='article::article.select_cancel_article'}" data-name="article_id" href="javascript:;" >{lang key='article::article.button_end'}</a>
			</div>
			
			<div class="choose_list f_r" data-url="{$search_action}">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='article::article.article_keywords'}"/>
				<button class="btn search_article" type="button">{lang key='article::article.search'}</button>
			</div>
		</div>
		<div class="row-fluid">
			<table class="table table-striped smpl_tbl">
				<thead>
					<tr>
					  	<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
					  	<th class="w70">{lang key='article::article.id'}</th>
					  	<th>{lang key='article::article.articleatolist_name'}</th>
					  	<th class="w180">{lang key='article::article.starttime'}</th>
					  	<th class="w180">{lang key='article::article.endtime'}</th>
					  	<th class="w70">{lang key='system::system.handler'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$list.item item=val} -->
						<tr>
						  	<td><input name="checkboxes[]" type="checkbox" value="{$val.article_id}" class="uni_style checkbox"/></td>
						  	<td>{$val.article_id}</td>
						  	<td>{$val.title}</td>
						  	<td>
						  		<a href="#" data-trigger="datetable" data-url='{RC_Uri::url("article/admin_article_auto/edit_starttime", "{if $smarty.get.page}page={$smarty.get.page}{/if}")}' data-pk="{$val.article_id}" data-title="{lang key='article::article.edit_issue_time'}" data-value="{$val.starttime}" data-type="combodate">
								<!-- {if $val.starttime} -->
								{$val.starttime}
								<!-- {else} -->
								0000-00-00
								<!-- {/if} -->
								</a>
							</td>
					  		<td>
					  			<a href="#" data-trigger="datetable" data-url='{RC_Uri::url("article/admin_article_auto/edit_endtime", "{if $smarty.get.page}page={$smarty.get.page}{/if}")}' data-pk="{$val.article_id}" data-title="{lang key='article::article.edit_cancel_time'}" data-value="{$val.endtime}" data-type="combodate">
								<!-- {if $val.endtime} -->
									{$val.endtime}
									<!-- {else} -->
									0000-00-00
								<!-- {/if} -->
								</a>
					  		</td>
					  		<td>
						  		<span>
						  			{if $val.endtime || $val.starttime}
						    			<a class="ajax-remove" data-toggle="ajaxremove" data-msg="{lang key='article::article.cancel_confirm'}" href='{RC_Uri::url("article/admin_article_auto/del", "id={$val.article_id}")}' title="{lang key='article::article.delete'}"><i class="fontello-icon-export-alt"></i></a>
						  			{else}
							    		-
							  		{/if}
							  	</span>
						  	</td>
						</tr>
	    			<!-- {foreachelse} -->
	    				<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->