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
	<strong>{t domain="article"}温馨提示：{/t}</strong>{t domain="article"}您需要到工具->计划任务中开启该功能后才能使用。{/t}
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
				<input type="text" name="select_time" class="w150 date" placeholder='{t domain="article"}请选择时间{/t}'>
				<a class="btn btnSubmit" data-idClass=".checkbox:checked" data-url='{url path="article/admin_article_auto/batch" args="type=batch_start{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg='{t domain="article"}您确定要批量发布选中的文章吗？{/t}' data-noSelectMsg='{t domain="article"}请先选中要批量发布的文章{/t}' data-name="article_id" href="javascript:;" >{t domain="article"}批量发布{/t}</a>
				<a class="btn btnSubmit" data-idClass=".checkbox:checked" data-url='{url path="article/admin_article_auto/batch" args="type=batch_end{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg='{t domain="article"}您确定要批量取消发布选中的文章吗？{/t}' data-noSelectMsg='{t domain="article"}请先选中要批量取消发布的文章{/t}' data-name="article_id" href="javascript:;" >{t domain="article"}批量取消发布{/t}</a>
			</div>
			
			<div class="choose_list f_r" data-url="{$search_action}">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="article"}请输入文章名称关键词{/t}'/>
				<button class="btn search_article" type="button">{t domain="article"}搜索{/t}</button>
			</div>
		</div>
		<div class="row-fluid">
			<table class="table table-striped smpl_tbl">
				<thead>
					<tr>
					  	<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
					  	<th class="w70">{t domain="article"}编号{/t}</th>
					  	<th>{t domain="article"}文章名称{/t}</th>
					  	<th class="w180">{t domain="article"}发布时间{/t}</th>
					  	<th class="w180">{t domain="article"}取消时间{/t}</th>
					  	<th class="w70">{t domain="article"}操作{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$list.item item=val} -->
						<tr>
						  	<td><input name="checkboxes[]" type="checkbox" value="{$val.article_id}" class="uni_style checkbox"/></td>
						  	<td>{$val.article_id}</td>
						  	<td>{$val.title}</td>
						  	<td>
						  		<a href="#" data-trigger="datetable" data-url='{RC_Uri::url("article/admin_article_auto/edit_starttime", "{if $smarty.get.page}page={$smarty.get.page}{/if}")}' data-pk="{$val.article_id}" data-title='{t domain="article"}编辑发布时间{/t}' data-value="{$val.starttime}" data-type="combodate">
								<!-- {if $val.starttime} -->
								{$val.starttime}
								<!-- {else} -->
								0000-00-00
								<!-- {/if} -->
								</a>
							</td>
					  		<td>
					  			<a href="#" data-trigger="datetable" data-url='{RC_Uri::url("article/admin_article_auto/edit_endtime", "{if $smarty.get.page}page={$smarty.get.page}{/if}")}' data-pk="{$val.article_id}" data-title='{t domain="article"}编辑取消时间{/t}' data-value="{$val.endtime}" data-type="combodate">
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
						    			<a class="ajax-remove" data-toggle="ajaxremove" data-msg='{t domain="article"}您确定要撤销该文章吗？{/t}' href='{RC_Uri::url("article/admin_article_auto/del", "id={$val.article_id}")}' title='{t domain="article"}撤销{/t}'><i class="fontello-icon-export-alt"></i></a>
						  			{else}
							    		-
							  		{/if}
							  	</span>
						  	</td>
						</tr>
	    			<!-- {foreachelse} -->
	    				<tr><td class="no-records" colspan="10">{t domain="article"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->