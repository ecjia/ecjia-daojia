<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.mass_message.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $warn && $type eq 0}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
{/if}

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
	<p>1、只有已经发送成功的消息才能删除。</p>
	<p>2、删除消息是将消息的图文详情页失效，已经收到的用户，还是能在其本地看到消息卡片。</p>
	<p>3、如果多次群发发送的是一个图文消息，那么删除其中一次群发，就会删除掉这个图文消息也，导致所有群发都失效。</p>
	<p>★ 发送人数，即排除发送时过滤、用户拒收、接收已达到4条的用户数。</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
     		<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
			
            <div class="card-body">
            	<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link data-pjax" href='{url path="wechat/platform_mass_message/init"}'>{lang key='wechat::wechat.send_message'}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax active" href='javascript:;'>{lang key='wechat::wechat.send_record'}</a>
					</li>
				</ul>
			</div>
            <div class="col-md-12">
            	<div class="alert alert-info">
					<a class="close" data-dismiss="alert">×</a>
					<strong>{lang key='wechat::wechat.label_notice'}</strong>
					<p>{lang key='wechat::wechat.mass_remove_info'} </p>
				</div>
            </div>
            
            <div class="col-lg-12">
				<table class="table table-striped smpl_tbl table-hide-edit">
					<thead>
						<tr>
							<th class="w100">ID</th>
							<th class="w200">{lang key='wechat::wechat.message_content'}</th>
							<th class="w180">{lang key='wechat::wechat.status'}</th>
							<th class="w130">{lang key='wechat::wechat.time'}</th>
							<th class="w30">{lang key='wechat::wechat.operate'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.list item=item} -->
						<tr>
							<td>
								{$item.id}<br /><br />
                                <strong>
								{if $item.type eq 'text'}文字{/if}
								{if $item.type eq 'mpnews'}图文{/if}
								{if $item.type eq 'image'}图片{/if}
								{if $item.type eq 'voice'}语音{/if}
								{if $item.type eq 'mpvideo'}视频{/if}
                                </strong>
							</td>
							<td>
								{if $item.type eq 'text'}{$item.media_content.content}{/if}
								{if $item.type eq 'mpnews'}
								<div class="weui-desktop-media__list-col margin_10">
									<li class="thumbnail move-mod-group big grid-item">
										<!-- {foreach from=$item.media_content.articles key=key item=val} -->
										{if $key eq 0}
									    <div class="article">
									        <div class="cover">
									            <a target="__blank" href="{$val.url}">
									                <img src="{$val.picurl}" />
									            </a>
									            <span>{$val.title}</span>
									        </div>
									    </div>
									    {else}
									    <div class="article_list">
									        <div class="f_l">{$val.title}</div>
									        <a target="__blank" href="{$val.url}">
									            <img src="{$val.picurl}" class="pull-right" />
									        </a>
									    </div>
										{/if}
									    <!-- {/foreach} -->
									</li>
								</div>
								{/if}
								{if $item.type eq 'image'}
								<div class="img_preview">
									<img class="preview_img margin_10" src="{$item.media_content.img_url}" data-type="image">
								</div>
								{/if}
								{if $item.type eq 'voice'}
								<div class="img_preview">
									<img class="preview_img margin_10" src="{$item.media_content.img_url}" data-src="{$item.media_content.voice_url}" data-type="voice"></img>
								</div>
								{/if}
								{if $item.type eq 'mpvideo'}
								<div class="img_preview">
									<img class="preview_img margin_10" src="{$item.media_content.img_url}" data-src="{$item.media_content.video_url}" data-type="video"></img>
								</div>	
								{/if}
							</td>
							<td>  
                                <strong>{$item.status}</strong><br />
			                    <i>成功：{$item.sentcount}{lang key='wechat::wechat.people'}</i><br />
                                <i>失败：{$item.errorcount}{lang key='wechat::wechat.people'}</i>
		                    </td>
		                    <td>{$item.send_time}</td>
		                    <td>
		                    	{if $item.status neq 4}
		                    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_record_confirm'}" href='{RC_Uri::url("wechat/platform_mass_message/mass_del", "id={$item.id}")}' title="{lang key='system::system.drop'}"><i class="ft-trash-2"/></i></a>
		                   		{/if}
		                    </td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$list.page} -->
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->