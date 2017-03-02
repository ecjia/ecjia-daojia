<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_region.init();
</script>

<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="post" action="{$form_action}" name="listForm">
		<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
		  	<ul>
			<!-- {foreach from=$region_arr item=region} -->
				<li class="thumbnail">
					<div class="bd">
						<div class="model-title ware_name">{$region.region_name}</div>
					</div>

					<div class="input">
						<a class="data-pjax no-underline" title="{t}进入{/t}" href="{url path='setting/admin_area_manage/init' args="id={$region.region_id}"}"><i class="fontello-icon-login"></i></a>
						<a class="no-underline" title="{t}编辑{/t}" value="{$region.region_id}" data-toggle="modal" href="#editArea" data-name="{$region.region_name}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除此地区[{$region.region_name}]吗？删除此地区将会同时删除此地区下的所有地区！{/t}" href='{url path="setting/admin_area_manage/drop_area" args="id={$region.region_id}"}' title="{t}删除一级地区{/t}"><i class="fontello-icon-trash ecjiafc-red"></i></a>
					</div>
				</li>
				<!-- {/foreach} -->
				<li class="thumbnail add-ware-house">
					<a class="more" data-type="add"  data-toggle="modal" href="#addArea">
						<i class="fontello-icon-plus"></i>
					</a>
				</li>
			</ul>
		  <!-- {$region_list.page} -->
		</div>
		</form>
	</div>
</div>
<!-- div editArea START -->
	<div class="modal hide fade" id="editArea">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>{t}编辑地区{/t}</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<div class="span12">
				<form class="form-horizontal" method="post" name="editArea" action="{url path='setting/admin_area_manage/edit_area_name'}">
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label old_warehouse_name" for="user_name">{t}原地区名：{/t}</label>
							<div class="controls">
								<span class="parent_name"></span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label new_warehouse_name" for="user_name">{t}新地区名：{/t}</label>
							<div class="controls">
								<input type="text" name="region_name" class="region_input"/>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
							<input type="hidden" name="id" />
						</div>
					</fieldset>
				</form>
				</div>
			</div>
		</div>
	</div>
	<!-- div editArea END -->
	<!-- div addArea START -->
	<div class="modal hide fade" id="addArea">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>{t}新增地区{/t}</h3>
		</div>
		<div class="modal-body h250">
			<div class="row-fluid">
				<div class="span12">
				<form class="form-horizontal" method="post" name="addArea" action="{url path='setting/admin_area_manage/add_area'}">
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label" for="user_name">{t}新增地区名：{/t}</label>
							<div class="controls">
								<input type="text" name="region_name" value=""><br>
								<span class="help-block">{t}地区名称不能重复{/t}</span>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
							<input type="hidden" name="parent_id" value="{$parent_id}" />
							<input type="hidden" name="region_type" value="{$region_type}" />
						</div>
					</fieldset>
				</form>
				</div>
			</div>
		</div>
	</div>
	<!-- div addArea END -->
<!-- {/block} -->