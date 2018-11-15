<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	// ecjia.merchant.menu.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>{if $ur_here}{$ur_here}{/if}</h2>
	</div>
	<div class="pull-right">
		<a  class="btn btn-primary" href="{$action_link.href}" id="sticky_a"><i class="fa fa-plus"></i> {$action_link.text}</a>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq ''}active{/if}">
						<a class="data-pjax" href='{url path="toutiao/merchant/init"}'>今日发送 <span class="badge badge-info">{$type_count.send}</span> </a>
					</li>
					<li class="{if $type eq 'history'}active{/if}">
						<a class="data-pjax" href='{url path="toutiao/merchant/init" args="type=history"}'>历史发送 <span class="badge badge-info">{$type_count.history}</span> </a>
					</li>
					<li class="{if $type eq 'media'}active{/if}">
						<a class="data-pjax" href='{url path="toutiao/merchant/init" args="type=media"}'>图文素材 <span class="badge badge-info">{$type_count.media}</span> </a>
					</li>
				</ul>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w250">今日热点主图</th>
								<th>内容标题</th>
								<th class="w200">发布时间</th>
							</tr>
						</thead>
						<!-- {foreach from=$list.item item=item key=key} -->
						<tr>
							<td>
								<img src="{$item.image}" width="215" height="125" />
							</td>
							<td style="padding-bottom: 30px;">
								<a href='{RC_Uri::url("toutiao/mobile/preview", "id={$item.id}")}' target="__blank">{$key+1}.{$item.title}</a>
								
								<span class="m_l5 ecjiafc-blue"><i class="fa fa-eye m_r5"></i>{$item.click_count}次</span><br/>
								
								{if $item.children}
									{foreach from=$item.children item=val key=k}
									<a href='{RC_Uri::url("toutiao/mobile/preview", "id={$val.id}")}' target="__blank">{$k+2}.{$val.title} </a>
									<span class="m_l5 ecjiafc-blue"><i class="fa fa-eye m_r5"></i>{$val.click_count}次</span><br/>
									{/foreach}
								{/if}

								<div class="edit-list">
									{if $type eq 'media'}
									<a data-toggle="ajaxremove" data-msg="您确定要发送该图文素材吗？" href='{RC_Uri::url("toutiao/merchant/send", "id={$item.id}")}'>发送</a>&nbsp;|&nbsp;
									<a class="data-pjax" href='{RC_Uri::Url("toutiao/merchant/edit", "id={$item.id}")}'>编辑</a>&nbsp;|&nbsp;
									{/if}
									<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="您确定要删除该图文素材吗？" href='{RC_Uri::url("toutiao/merchant/remove", "id={$item.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
								</div>
							</td>
							<td>{RC_Time::local_date('Y-m-d H:i:s', $item.create_time)}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="3" {if !$type}style="height:250px;"{/if}>
								{if !$type}
								<p class="help-block">你今日还可群发 {$residue_degree} 次消息</p>
								<a class="btn btn-info data-pjax" href='{RC_Uri::url("toutiao/merchant/add")}'>去发布</a>
								<a class="btn btn-warning data-pjax" href='{RC_Uri::url("toutiao/merchant/init", "type=media")}'>去图文素材</a><br>
								<div class="m_t10">{lang key='system::system.no_records'}</div>
								{else}
								{lang key='system::system.no_records'}
								{/if}
							</td>
						</tr>
						<!-- {/foreach} -->
					</table>
				</section>
				{if !$type && $list.item}
				<p class="help-block">你今日还可群发 {$residue_degree} 次消息</p>
				{/if}
				<!-- {$list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->