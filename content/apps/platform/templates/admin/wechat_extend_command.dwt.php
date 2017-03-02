<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
	var rowtypedata = [
		[
			[1,'<input type="text" class="txt w180" name="newcmd_word[]">'],
			[1,'<input type="text" class="txt w180" name="newsub_code[]">'],
			[1,'<a class="ecjiafc-red cursor_pointer l_h30" title="取消" data-toggle="remove-node"><i class="command_icon fontello-icon-cancel"></i></a>']
		]
	]
	{literal}
	var addrowdirect = 0;
	function addrow(obj, type) {
	// 	var table = obj.parentNode.parentNode.parentNode;
		var table = document.getElementById("edit_tbody");
		var tr = table.getElementsByTagName("tr");
	
		if(!addrowdirect) {
			var row = table.insertRow(tr.length);
		} else {
			var row = table.insertRow(tr.length + 1);
		}
		var typedata = rowtypedata[type];
		for(var i = 0; i <= typedata.length - 1; i++) {
			var cell = row.insertCell(i);
	// 		cell.colSpan = typedata[i][0];
			$("select").not(".noselect").chosen();
			var tmp = typedata[i][1];
			if (typedata[i][2]) {
				cell.className = typedata[i][2];
			}
			tmp = tmp.replace(/\{(\d+)\}/g, function($1, $2) {return addrow.arguments[parseInt($2) + 1];});
			cell.innerHTML = tmp;
		}
		addrowdirect = 0;
	}
	
	$(document).on('click', '[data-toggle="remove-node"]', function(e){
		e.preventDefault();
		var $this	= $(this),
		$parentobj	= $this.parent().parent();
		$parentobj.remove();
	});
	{/literal}
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		{$ext_name}<small>（{$code}）</small>
		{if $back_link}
		<a class="btn plus_or_reply data-pjax" href="{$back_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$back_link.text}</a>
		{/if}
	</h3>
</div>	

<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='platform::platform.command_key'}"/> 
			<button class="btn" type="submit">{lang key='platform::platform.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<form name="editForm" action="{$form_action}" method="post">
			<table class="table table-striped" data-rowlink="a">
				<thead>
					<tr>
						<th class="w200">{lang key='platform::platform.keyword'}</th>
						<th class="w200">{lang key='platform::platform.subcommand'}</th>
						<th class="w50">{lang key='platform::platform.operation'}</th>
					</tr>
				</thead>
				<tbody id="edit_tbody">
					<!-- {foreach from=$modules.module item=module} -->
					<tr>
						<!-- {if $cmd_id eq $module.cmd_id} -->
						<td><input class="w180" type="text" name="cmd_word" value="{$module.cmd_word}"></td>
						<td><input class="w180" type="text" name="sub_code" value="{$module.sub_code}"></td>
						<td>
							<a class="cursor_pointer" data-toggle="edit_toggle" data-href='{RC_Uri::url("platform/admin_command/update", "code={$code}&account_id={$module.account_id}&cmd_id={$module.cmd_id}")}' title="{lang key='system::system.edit'}"><i class="command_icon fontello-icon-ok l_h30"></i></a>
							<a class="data-pjax" href='{RC_Uri::url("platform/admin_command/init", "code={$code}&account_id={$module.account_id}")}' title="{lang key='platform::platform.close'}"><i class="command_icon fontello-icon-cancel l_h30"></i></a>
						</td>
						<!-- {else} -->
						<td>{$module.cmd_word}</td>
						<td>{$module.sub_code}</td>
						<td>
							<a class="cursor_pointer" data-toggle="edit_toggle" data-href='{RC_Uri::url("platform/admin_command/init", "code={$code}&account_id={$module.account_id}&cmd_id={$module.cmd_id}")}' title="{lang key='system::system.edit'}"><i class="command_icon fontello-icon-edit"></i></a>
							<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{lang key='platform::platform.sure_del_command'}" href='{RC_Uri::url("platform/admin_command/remove", "cmd_id={$module.cmd_id}")}' title="{lang key='platform::platform.remove'}"><i class="command_icon fontello-icon-trash"></i></a>
						</td>
						<!-- {/if} -->
					</tr>
					<!-- {foreachelse} -->
				   	<tr>
				   		<td><input type="text" class="txt w180" name="newcmd_word[]"></td>
						<td><input type="text" class="txt w180" name="newsub_code[]"></td>
						<td></td>
				   	</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$modules.page} -->
			<div class="m_b20"><a href="javascript:;" onclick="addrow(this,0)" class="addtr">{lang key='platform::platform.add_again'}</a></div>
			<button class="btn btn-gebo" type="submit">{lang key='platform::platform.addition'}</button>
		</form>
	</div>
</div>
<!-- {/block} -->