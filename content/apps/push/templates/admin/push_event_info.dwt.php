<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.push_event.info();
</script>

<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="codeForm" action="{$insert_form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t}消息事件名称：{/t}</label>
					<div class="controls">
						<input class="span4" name="name" type="text" value="{$push_event.event_name}" />
						<span class="input-must"><span class="require-field">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t}消息事件Code：{/t}</label>
					<div class="controls">
						<!-- {if $push_event.event_code} -->
							<div class="p_t5">
							{$push_event.event_code}</div>
							<input name="code" type="hidden" value="{$push_event.event_code}" />
						<!-- {else} -->
							<input class="span4" name="code" type="text" value="" />
							<span class="input-must"><span class="require-field">*</span></span>
						<!-- {/if} -->
					</div>
				</div>
				<!-- {if !$push_event} -->
				<div class="control-group ">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
					</div>
				</div>
				<!-- {/if} -->
			</fieldset>
		</form>
	</div>
</div>
<!-- {if $push_event} -->
<div>
	<h3 class="heading">
	绑定客户端应用
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
		  	<ul>
			<!-- {foreach from=$push_event_group item=push_event} -->
				<li class="thumbnail">
					<div class="bd">
						<div class="model-title ware_name">
							<p class="m_t30">{$push_event.app_name}</p>
							<p>{$push_event.template_subject}</p>
						</div>
					</div>

					<div class="input">
						<a class="no-underline" title="{t}编辑{/t}" value="{$push_event.event_id}" data-toggle="modal" href="#editevent" data-appid="{$push_event.app_id}" data-templateid="{$push_event.template_id}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除该消息事件吗？{/t}" href="{RC_Uri::url('push/admin_event/delete', "id={$push_event.event_id}")}" title="{t}移除{/t}"><i class="fontello-icon-trash ecjiafc-red"></i></a>
					</div>
				</li>
				<!-- {/foreach} -->
				<li class="thumbnail add-ware-house">
					<a class="more" data-type="add"  data-toggle="modal" href="#addevent">
						<i class="fontello-icon-plus"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- div editevent START -->
<div class="modal hide fade" id="editevent">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t}编辑客户端应用{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
			<form class="form-horizontal" id="form-privilege" name="updateForm" action="{$update_form_action}" method="post" enctype="multipart/form-data" >
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label">{t}客户端应用：{/t}</label>
						<div class="controls">
							<select name='app_id' class="w200 app_id">
								<option value=''>{t}请选择{/t}</option>
								<!-- {foreach from=$mobile_manage item=item key=key} -->
								<option value='{$item.app_id}'>{$item.app_name}</option>
								<!-- {/foreach} -->
							</select>
							<span class="input-must"><span class="require-field">*</span></span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t}消息模板：{/t}</label>
						<div class="controls">
							<select name='template_id' class="w200 tempalteid">
								<option value=''>{t}请选择{/t}</option>
								<!-- {foreach from=$template_data item=item key=key} -->
								<option value='{$item.template_id}'>{$item.template_subject}</option>
								<!-- {/foreach} -->
							</select>
							<span class="input-must"><span class="require-field">*</span></span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t}是否启用：{/t}</label>
						<div class="controls">
				            <div class="info-toggle-button">
				                <input class="nouniform" name="status" type="checkbox"  {if $push_event.is_open eq 1}checked="checked"{/if}  value="1"/>
				            </div>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
						<input type='hidden' name='event_name' />
						<input type='hidden' name='id' />
						<input type='hidden' name='code' value="{$push_event.event_code}" />
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
</div>
<!-- div editevent END -->
<!-- div addevent START -->
<div class="modal hide fade" id="addevent">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t}绑定客户端应用{/t}</h3>
	</div>
	<div class="modal-body h250">
		<div class="row-fluid">
			<div class="span12">
			<form class="form-horizontal" id="form-privilege" name="addForm" action="{$insert_form_action}" method="post" enctype="multipart/form-data" >
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label">{t}客户端应用：{/t}</label>
						<div class="controls">
							<select name='app_id' class="w200">
								<option value=''>{t}请选择{/t}</option>
								<!-- {foreach from=$mobile_manage item=item key=key} -->
								<option value='{$item.app_id}'>{$item.app_name}</option>
								<!-- {/foreach} -->
							</select>
							<span class="input-must"><span class="require-field">*</span></span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t}消息模板：{/t}</label>
						<div class="controls">
							<select name='template_id' class="w200">
								<option value=''>{t}请选择{/t}</option>
								<!-- {foreach from=$template_data item=item key=key} -->
								<option value='{$item.template_id}'>{$item.template_subject}</option>
								<!-- {/foreach} -->
							</select>
							<span class="input-must"><span class="require-field">*</span></span>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">{t}是否启用：{/t}</label>
						<div class="controls">
				            <div class="info-toggle-button">
				                <input class="nouniform" name="status" type="checkbox"  {if $push_event.is_open eq 1}checked="checked"{/if}  value="1"/>
				            </div>
						</div>
					</div>
					<div class="control-group t_c">
						<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
						<input type='hidden' name='event_name' />
						<input type='hidden' name='event_code' value=""/>
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
</div>
<!-- div addevent END -->
<!-- {/if} -->
<!-- {/block} -->