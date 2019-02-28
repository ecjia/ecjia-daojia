<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
		{if $action_linkedit}
		<a class="btn plus_or_reply data-pjax" href="{$action_linkedit.href}" id="sticky_a" ><i class="fontello-icon-edit"></i>{$action_linkedit.text}</a>
		{/if}
	</h3>	
</div>

<!-- {if $topic.now lt $topic.end_time and $topic.now gt $topic.start_time } -->
<div class="row-fluid">
	<h3 class="text-center">{$topic.title}</h3>
	<div class="bigimg">
		{if $topic.htmls eq ''}
		  <script language="javascript">
			var topic_width  = "99%";
			var topic_height = "30%";
			var img_url      = "{$topic.topic_img}";
			
			if (img_url.indexOf('.swf') != -1) {
				document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ topic_width +'" class="thumbnail" height="'+ topic_height +'">');
				document.write('<param name="movie" value="'+ img_url +'"><param name="quality" value="high">');
				document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
				document.write('<embed src="'+ img_url +'" wmode="opaque" menu="false" quality="high"  width="'+ topic_width +'" height="'+ topic_height +'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent"/>');
				document.write('</object>');
			} else {
				document.write('<img width="' + topic_width + '" height="' + topic_height + '" class="thumbnail"  src="' + img_url + '">');
			}
		  </script>
		{else}
			{$topic.htmls}
		{/if}
	</div>
	<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_submit">
					<strong>{t domain="topic"}专题信息{/t}</strong>
				</a>
			</div>
			<div class="accordion-body in collapse" id="goods_info_area_submit">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>{t domain="topic"}活动开始时间：{/t}</strong></div></td>
							<td>{RC_Time::local_date('Y-m-d h:i:s', {$topic.start_time})}</td>
							<td><div align="right"><strong>{t domain="topic"}活动结束时间：{/t}</strong></div></td>
							<td>{RC_Time::local_date('Y-m-d h:i:s', {$topic.end_time})}</td>
						</tr>
						
						<tr>
							<td><div align="right"><strong>{t domain="topic"}关键字：{/t}</strong></div></td>
							<td>{$topic.keywords}</td>
							<td><div align="right"><strong>{t domain="topic"}简单描述：{/t}</strong></div></td>
							<td>{$topic.description}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="topic"}专题介绍：{/t}</strong></div></td>
							<td colspan="3">{$topic.intro}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- {if $topic.title_pic eq ''} -->
		<!-- {foreach from=$topic_cats  item=value  key=k} -->
		<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#{$k}">
						<strong>{$k}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="{$k}">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<div class="box">
							    <ul>
								    <!-- {foreach from=$value item=v key=kk} -->
								    <li>
								   	   {assign var=goods_url value=RC_Uri::url('goods/admin/preview',"id={$kk}")}
								       <div class="imgbox"><a href="{$goods_url}" target="_blank"><img class="thumbnail" src="{$v.goods_thumb}" /></a></div>
								       <a href="{$goods_url}" target="_blank">{$v.name}</a><br>
								       	￥{$v.price}{t domain="topic"}元{/t}
									</li>
								    <!--{/foreach}-->
							    </ul>
						    </div>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--{/foreach}-->
	<!-- {else} -->
		<!-- {foreach from=$topic_cats item=value key=k} -->
		<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head"  style="background: url({RC_Upload::upload_url()}/{$topic.title_pic});  border: 1px solid #ddd;" data-toggle="collapse" data-target="#{$k}">
						<strong>{$k}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="{$k}">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<div class="box">
							    <ul>
								    <!-- {foreach from=$value item=v key=kk} -->
								    <li>
								   	   {assign var=goods_url value=RC_Uri::url('goods/admin/preview',"id={$kk}")}
								       <div class="imgbox"><a href="{$goods_url}" target="_blank"><img class="thumbnail" src="{$v.goods_thumb}" /></a></div>
								       <a href="{$goods_url}" target="_blank">{$v.name}</a><br>
								       	￥{$v.price}{t domain="topic"}元{/t}
									</li>
								    <!--{/foreach}-->
							    </ul>
						    </div>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--{/foreach}-->
	<!-- {/if} -->
</div>
<!-- {elseif $topic.now lt $topic.start_time} -->
<table class="table table-striped">
	<tr>
		<td class="no-records" colspan="10" style=" border-top: 0px;">{t domain="topic"}该专题开始时间未到，敬请期待。{/t}</td>
	</tr>
</table>   
<!-- {else} -->		
<table class="table table-striped">
	<tr>
		<td class="no-records" colspan="10" style=" border-top: 0px;">{t domain="topic"}该专题截止日期已到，系统已下架。{/t}</td>
	</tr>
</table>   
<!-- {/if} -->
<!-- {/block} -->