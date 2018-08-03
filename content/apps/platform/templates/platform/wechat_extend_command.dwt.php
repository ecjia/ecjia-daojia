<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
                	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            
			<div class="card-body">
				<form class="form-inline float-right" method="post" action="{$search_action}" name="searchForm">
					<div class="choose_list f_r" >
						<input class="form-control" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='platform::platform.command_key'}"/> 
						<button class="btn btn-outline-primary" type="submit">{lang key='platform::platform.search'}</button>
					</div>
				</form>
			</div>
			
            <div class="col-md-12">
	            <form name="editForm" action="{$form_action}" method="post">
					<table class="table table-hide-edit">
						<thead>
							<tr>
								<th class="w200">{lang key='platform::platform.extend_name'}</th>
								<th class="w200">{lang key='platform::platform.keyword'}</th>
								<th class="w200">{lang key='platform::platform.subcommand'}</th>
								<th class="w50">{lang key='platform::platform.operation'}</th>
							</tr>
						</thead>
						<tbody id="edit_tbody">
							<!-- {foreach from=$modules.module item=module} -->
							<tr>
								<td>{$module.ext_name}</td>
								<td>
									<!-- {foreach from=$module.cmd_list item=val} -->
									<div class="border-bottom-eee">{$val.cmd_word}</div>
									<!-- {/foreach} -->
								</td>
								<td>
									{if $module.has_subcode eq 1}
									<!-- {foreach from=$module.cmd_list item=val} -->
									<div class="border-bottom-eee">{if $val.sub_code}{$val.sub_code}{else}&nbsp;{/if}</div>
									<!-- {/foreach} -->
									{/if}
								</td>
								<td>
									<a class="data-pjax" href='{RC_Uri::url("platform/platform_command/edit", "ext_code={$module.ext_code}")}' title="{lang key='platform::platform.edit'}"><i class="ft-edit"></i></a>&nbsp;
									<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{lang key='platform::platform.sure_del_command'}" href='{RC_Uri::url("platform/platform_command/remove", "ext_code={$module.ext_code}")}' title="{lang key='platform::platform.remove'}"><i class="command_icon ft-trash-2"></i></a>
								</td>
							</tr>
							<!-- {foreachelse} -->
						   	<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
					<!-- {$modules.page} -->	
				</form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->