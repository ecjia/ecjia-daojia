<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.response.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if}
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="choost_list f_r">
		<form class="form-inline" method="post" action="{$form_action}" name="search_from">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='wechat::wechat.input_keyword'}"/>
			<input type="submit" value="{lang key='wechat::wechat.search'}" class="btn search-btn">
		</form>
	</div>
</div>
	
<div class="row-fluid">
	<table class="table table-striped table-hide-edit">
		<thead>
			<tr>
				<th class="w100">{lang key='wechat::wechat.rule_name'}</th>
				<th class="w120">{lang key='wechat::wechat.keyword'}</th>
				<th class="w200">{lang key='wechat::wechat.reply_message'}</th>
				<th class="w70">{lang key='wechat::wechat.operate'}</th>
			</tr>
		</thead>
		<tbody>
		<!-- {foreach from=$list.item item=item} -->
			<tr>
				<td>{$item.rule_name}</td>
				<td>
					<!-- {foreach from=$item.rule_keywords item=rule} -->
					<span class="label label-default">{$rule}</span>
					<!-- {/foreach} -->
				</td>
				<td>
					<!-- {if $item['medias'] AND $item['reply_type'] eq 'news'} -->
					<div class="wmk_grid ecj-wookmark wookmark_list w200">
						<div class="thumbnail move-mod-group">
							<!-- {foreach from=$item.medias key=k item=val} -->
								<!-- {if $val neq ''} -->
									{if $k == 0}
									<div class="article">
                                		<div class="cover">
                                			<img src="{$val.file}" />
                                			<span>{$val.title}</span>
                                		</div>
									</div>
									{else}
									<div class="article_list">
									 	<div class="f_l">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
                               	 		<img src="{$val.file}" class="pull-right material_content" />
									</div>
									{/if}
								<!-- {else} -->
									<div class="article_list">
									 	<div class="f_l">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
                               	 		<img src="{RC_Uri::admin_url('statics/images/nopic.png')}" class="pull-right material_content" />
									</div>
								<!-- {/if} -->
                        	<!-- {/foreach} -->
			        	</div>
					</div>
                    <!-- {elseif $item['reply_type'] neq 'text' && $item.media neq ''} -->
                    	<!-- {if $item['reply_type'] == 'news'} -->
                        	<div class="wmk_grid ecj-wookmark wookmark_list w200">
								<div class="thumbnail move-mod-group ">
                                	<div class="article_media">
                                       	<div class="article_media_title">{$item['media']['title']}</div>
                                       	<div>{$item['media']['add_time']}</div>
                                       	<div class="cover"><img src="{$item['media']['file']}" /></div>
                                       	<div class="articles_content">{$item['media']['content']}</div>
                                   	</div>
                                </div>
                             </div>
                         <!-- {elseif $item['reply_type'] == 'voice'} -->
                         	<img src="{$item.media.file}" class="material_reply_content material_content m_b5"/><br>
                         	<span class="m_l10">{$item['media']['file_name']}</span>
                         <!-- {elseif $item['reply_type'] == 'video'} -->
                         	<!-- {if $item.media.file} -->
                         	<img src="{$item.media.file}" class="material_reply_content material_content m_b5"/><br>
                         	<span class="m_l10">{$item['media']['file_name']}</span>
                         	<!-- {/if} -->
                         <!-- {else} -->
                                <!-- {if $item['media']['file'] neq ''} -->
                                	<img src="{$item['media']['file']}" class="material_reply_content"/>
                                <!-- {else} -->
                               	 	<span class="ecjiaf-pre stop_color">{lang key='wechat::wechat.the_material_del'}</span>
                                <!-- {/if} -->
                           <!-- {/if} -->
                	<!-- {elseif $item.content neq ''} -->
                		<span class="ecjiaf-pre">{$item.content}</span>
                	<!-- {else} -->
                    	<span class="ecjiaf-pre stop_color">{lang key='wechat::wechat.the_material_del'}</span>
                    <!-- {/if} -->
				</td>
				<td>
					{assign var=edit_url value=RC_Uri::url('wechat/admin_response/reply_keywords_add',"id={$item.id}")}
					<a class="data-pjax no-underline" href="{$edit_url}" title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除规则[{$item.rule_name}]吗？{/t}" href='{RC_Uri::url("wechat/admin_response/remove_rule","id={$item.id}")}' title="{lang key='wechat::wechat.remove'}"><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
		<!-- {foreachelse} -->
    		<tr><td class="dataTables_empty" colspan="4">{lang key='system::system.no_records'}</td></tr>
  		<!-- {/foreach} -->
		</tbody>
	</table>
	<!-- {$list.page} -->
</div>
<!-- {/block} -->