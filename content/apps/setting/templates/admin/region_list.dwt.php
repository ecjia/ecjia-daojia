<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<style>
/*.kind-notice{
	display:none;*/
}
</style>
<script type="text/javascript">
	ecjia.admin.setting.init();
	ecjia.admin.admin_region_manage.init();
</script>

<!-- {/block} -->
<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
	{t}地区云同步 {/t}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label"><button type="button" class="ajaxmenu btn" data-url='{RC_Uri::url("setting/admin_region/get_regioninfo")}' data-value="get_regioninfo">{t}同步地区表信息{/t}</button></label>
				<div class="controls">
					通过点击该按钮可以获取云平台地区信息到本地。<br/>
					执行该同步操作，会先<strong>清空本地地区表数据</strong>后再同步，同步时间较久，请确认好之后再操作。
				</div>
			</div>
		</form>
	</div>
</div>

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
						<div class="model-title ware_name"><span style="font-size:16px;">{$region.region_name}</span></div>
					</div>

					<div class="input">
						{if $region_type lt 5}
							<a class="data-pjax no-underline" title="{t}进入{/t}" href="{url path='setting/admin_region/init' args="id={$region.region_id}"}"><i class="fontello-icon-login"></i></a>
						{/if}
						<a class="no-underline" title="{t}编辑{/t}" value="{$region.region_id}" data-toggle="modal" href="#editArea" data-name="{$region.region_name}"  data-index-letter="{$region.index_letter}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除此地区[{$region.region_name}]吗？删除此地区将会同时删除此地区下的所有地区！{/t}" href='{url path="setting/admin_region/drop_area" args="id={$region.region_id}"}' title="{t}删除一级地区{/t}"><i class="fontello-icon-trash ecjiafc-red"></i></a>
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
				<form class="form-horizontal" method="post" name="editArea" action="{url path='setting/admin_region/edit_area_name'}">
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label old_warehouse_name">{t}原地区名：{/t}</label>
							<div class="controls">
								<span class="parent_name"></span>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label new_warehouse_name">{t}新地区名：{/t}</label>
							<div class="controls">
								<input type="text" name="region_name" class="region_input"/>
								<span class="input-must">{lang key='system::system.require_field'}</span><br>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}索引首字母：{/t}</label>
							<div class="controls">
								<input type="text" name="index_letter" value="">
								<span class="help-block">{t}地区名第一个字的首字母{/t}</span>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
							<input type="hidden" name="region_id" value=""/>
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
		<div class="modal-body h380">
			<div class="row-fluid">
				<div class="span12">
				<form class="form-horizontal" method="post" name="addArea" action="{url path='setting/admin_region/add_area'}">
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label">{t}新增地区名：{/t}</label>
							<div class="controls">
								<input type="text" name="region_name" value="">
								<span class="input-must">{lang key='system::system.require_field'}</span><br>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}地区码：{/t}</label>
							<div class="controls">
								{if $region_type gt 1}<span>{$parent_id}</span>&nbsp;&nbsp;{/if}
								{if $region_type eq 1} CN {/if}<input type="text" style="width:50px;" name="region_id" value="" >
								<span class="input-must">{lang key='system::system.require_field'}</span><br>
								{if ($region_type eq 4) || ($region_type eq 5)}
									<span class="help-block">{t}当前级地区码只能填写3位数字，且不可与同级其他地区码相同{/t}</span>
								{else}
									<span class="help-block">{t}当前级地区码只能填写2位数字，且不可与同级其他地区码相同{/t}</span>
								{/if}
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">{t}索引首字母：{/t}</label>
							<div class="controls">
								<input type="text" name="index_letter" value="">
								<span class="help-block">{t}地区名第一个字的首字母{/t}</span>
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