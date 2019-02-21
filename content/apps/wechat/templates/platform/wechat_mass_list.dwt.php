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
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
</div>
{/if}

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">{t domain="wechat"}操作提示{/t}</h4>
	<p>{t domain="wechat"}1、只有已经发送成功的消息才能删除。{/t}</p>
	<p>{t domain="wechat"}2、删除消息是将消息的图文详情页失效，已经收到的用户，还是能在其本地看到消息卡片。{/t}</p>
	<p>{t domain="wechat"}3、如果多次群发发送的是一个图文消息，那么删除其中一次群发，就会删除掉这个图文消息也，导致所有群发都失效。{/t}</p>
	<p>{t domain="wechat"}★ 发送人数，即排除发送时过滤、用户拒收、接收已达到4条的用户数。{/t}</p>
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
						<a class="nav-link data-pjax" href='{url path="wechat/platform_mass_message/init"}'>{t domain="wechat"}发送消息{/t}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax active" href='javascript:;'>{t domain="wechat"}发送记录{/t}</a>
					</li>
				</ul>
			</div>
            <div class="col-md-12">
            	<div class="alert alert-info">
					<a class="close" data-dismiss="alert">×</a>
					<strong>{t domain="wechat"}温馨提示：{/t}</strong>
					<p>{t domain="wechat"}只有已经发送成功的消息才能删除，删除消息只是将消息的图文详情页失效，已经收到的用户，还是能在其本地看到消息卡片。 另外，删除群发消息只能删除图文消息和视频消息，其他类型的消息一经发送，无法删除。{/t}</p>
				</div>
            </div>
            
            <div class="col-lg-12">
				<table class="table table-striped smpl_tbl table-hide-edit">
					<thead>
						<tr>
							<th class="w100">{t domain="wechat"}ID{/t}</th>
							<th class="w200">{t domain="wechat"}消息内容{/t}</th>
							<th class="w180">{t domain="wechat"}状态{/t}</th>
							<th class="w130">{t domain="wechat"}时间{/t}</th>
							<th class="w30">{t domain="wechat"}操作{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.list item=item} -->
						<tr>
							<td>
								{$item.id}<br /><br />
                                <strong>
								{if $item.type eq 'text'}{t domain="wechat"}文字{/t}{/if}
								{if $item.type eq 'mpnews'}{t domain="wechat"}图文{/t}{/if}
								{if $item.type eq 'image'}{t domain="wechat"}图片{/t}{/if}
								{if $item.type eq 'voice'}{t domain="wechat"}语音{/t}{/if}
								{if $item.type eq 'mpvideo'}{t domain="wechat"}视频{/t}{/if}
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
			                    <i>{t domain="wechat" 1={$item.sentcount}}成功：%1人{/t}</i><br />
                                <i>{t domain="wechat" 1={$item.errorcount}}失败：%1人{/t}</i>
		                    </td>
		                    <td>{$item.send_time}</td>
		                    <td>
		                    	{if $item.status neq 4}
		                    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该记录吗？{/t}' href='{RC_Uri::url("wechat/platform_mass_message/mass_del", "id={$item.id}")}' title='{t domain="wechat"}删除{/t}'><i class="ft-trash-2"/></i></a>
		                   		{/if}
		                    </td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="5">{t domain="wechat"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$list.page} -->
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->