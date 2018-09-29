<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.response.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

{if $errormsg}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
{/if}

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<p>自动回复的类型 共分三种：消息自动回复、关键词自动回复、打开客服回复。回复内容可以设置为文字，图片。文本消息回复内容可以直接填写，长度限制1024字节（大约200字，含标点以及其他特殊字符），其他素材需要先在素材管理中添加。</p>
	<p>一、关键词自动回复：即自己添加的规则关键词自动回复。</p>
	<p>★ 字数限制：微信公众平台认证与非认证用户的关键字自动回复设置规则上限为200条规则（每条规则名，最多可设置60个汉字），每条规则内最多设置10条关键字（每条关键字，最多可设置30个汉字）。</p>
	<p>★ 规则设置：一个规则您可设置多个关键字，建议使用常用关键字，如关键词：help,帮助。采取中英文结合的方式最佳。如果用户发送的信息中含有您设置的其中一个关键字，则系统会匹配自动回复。</p>
	<p>★ 注意事项：关键词 不能设置系统已经存在的关键词，如功能扩展当中的hot、best、news等。</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
          	<div class="card-body">
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$form_action}" name="search_from">
						<input class="form-control m_r5" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='wechat::wechat.input_keyword'}"/>
						<input type="submit" value="{lang key='wechat::wechat.search'}" class="btn btn-outline-primary search-btn">
					</form>
				</div>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
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
								{assign var=edit_url value=RC_Uri::url('weapp/platform_response/reply_keywords_add',"id={$item.id}")}
								<a class="data-pjax no-underline" href="{$edit_url}" title="{lang key='system::system.edit'}"><i class="ft-edit"></i></a>&nbsp;
								<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除规则[{$item.rule_name}]吗？{/t}" href='{RC_Uri::url("weapp/platform_response/remove_rule","id={$item.id}")}' title="{lang key='wechat::wechat.remove'}"><i class="ft-trash-2"></i></a>
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="dataTables_empty" colspan="4">{lang key='system::system.no_records'}</td></tr>
					  	<!-- {/foreach} -->
					</tbody>
				</table>						
            </div>
            <!-- {$list.page} -->
        </div>
    </div>
</div>
<!-- {/block} -->