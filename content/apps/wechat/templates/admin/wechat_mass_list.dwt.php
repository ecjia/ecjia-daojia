<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mass_message.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $warn}
	{if $type eq 0}
	 	<div class="alert alert-error">
	         <strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
	    </div>
	{/if}
{/if}

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li><a class="data-pjax" href='{url path="wechat/admin_mass_message/init"}'>{lang key='wechat::wechat.send_message'}</a></li>
				<li class="active"><a href="javascript:;">{lang key='wechat::wechat.send_record'}</a></li>
			</ul>
			
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert">×</a>
				<strong>{lang key='wechat::wechat.label_notice'}</strong>
				<p>{lang key='wechat::wechat.mass_remove_info'} </p>
			</div>
			
			<div class="row-fluid list-page">
				<div class="span12">	
					<div class="row-fluid">
						<table class="table table-striped smpl_tbl table-hide-edit">
							<thead>
								<tr>
									<th class="w200">{lang key='wechat::wechat.message_content'}</th>
									<th class="w250">{lang key='wechat::wechat.status'}</th>
									<th class="w150">{lang key='wechat::wechat.time'}</th>
									<th class="w50">{lang key='wechat::wechat.operate'}</th>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$list.list item=item} -->
								<tr>
									<td>
										<!-- {if $item.children} -->
										<div class="wmk_grid ecj-wookmark wookmark_list w200">
											<div class="thumbnail move-mod-group">
												<!-- {foreach from=$item.children.file key=k item=val} -->
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
			                            <!-- {elseif $item.type} -->
			                                <!-- {if $item.type == 'voice' || $item.type == 'video' || $item.type == 'image'} -->
			                                    <img src="{$item.file}" class="material_reply_content material_content m_b5"/><br>
			                                    <span>{$item.file_name}</span>
			                                <!-- {else} -->
			                                	 <span class="ecjiaf-pre">{$item.content}</span>
			                                <!-- {/if} -->
			                           <!-- {/if} -->
									</td>
									
									<td>  
										{if $item.status eq 1}
										<p class="ecjiafc-blue">{lang key='wechat::wechat.send_success'}</p>
										{elseif $item.status eq 2}
										<p class="ecjiafc-red">{lang key='wechat::wechat.send_failed'}</p>
										{elseif $item.status eq 3}
										<p class="ecjiafc-red">{lang key='wechat::wechat.send_error'}</p>
										{elseif $item.status eq 4}
										<p class="ecjiafc-red">{lang key='wechat::wechat.deleted'}</p>
										{/if}
					                    <p>{lang key='wechat::wechat.label_sentcount'}{$item.sentcount}{lang key='wechat::wechat.people'}</p>
					                    <p>{lang key='wechat::wechat.label_errorcount'}{$item.errorcount}{lang key='wechat::wechat.people'}</p>
				                    </td>
				                    <td>
				                    	{$item.send_time}
				                    </td>
				                    <td>
				                    	{if $item.status neq 4}
				                    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_record_confirm'}" href='{RC_Uri::url("wechat/admin_mass_message/mass_del", "id={$item.id}")}' title="{lang key='system::system.drop'}"><i class="fontello-icon-trash"/></i></a>
				                   		{/if}
				                    </td>
								</tr>
								<!--  {foreachelse} -->
								<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
						<!-- {$list.page} -->
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
<!-- {/block} -->