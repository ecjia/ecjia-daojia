<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cycleimage.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link_special} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link_special.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link_special.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
		  	<ul>
			<!-- {foreach from=$cycleimage_list item=cycleimage} -->
				<li class="thumbnail">
					<div class="bd">
						<div class="model-title ware_name">
							<p class="m_t30">{$cycleimage.app_name}</p>
							<p>{$cycleimage.template_subject}</p>
						</div>
					</div>

					<div class="input">
						<a class="no-underline" title="{t}编辑{/t}" value="{$push_event.event_id}" data-toggle="modal" href="#editevent" data-appid="{$push_event.app_id}" data-templateid="{$push_event.template_id}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除该消息事件吗？{/t}" href="{RC_Uri::url('push/admin_event/delete', "id={$push_event.event_id}")}" title="{t}移除{/t}"><i class="fontello-icon-trash ecjiafc-red"></i></a>
					</div>
				</li>
				<!-- {/foreach} -->
				<li class="thumbnail add-ware-house">
					<a class="more data-pjax" href='{url path="cycleimage/admins/add"}'>
						<i class="fontello-icon-plus"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- 轮播图预览隐藏区域 -->
<div class="modal hide fade" id="preview">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='cycleimage::flashplay.preview_style'}</h3>
	</div>
	<div class="modal-body">
	</div>
	<div class="modal-footer">
	</div>
</div>
<!-- {/block} -->