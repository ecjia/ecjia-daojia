<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{lang key='platform::platform.lable_warm_prompt'}</strong> {lang key='platform::platform.click_plug_add'}
</div>
    
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid editpage-rightbar">
	<form class="form-horizontal" method="post" action="{$form_action}" name="platform">
		<fieldset>
			<div class="left-bar move-mod ui-sortable">
				<table class="table table-striped table-hide-edit">
					<thead>
						<tr>
							<th class="w80">{lang key='platform::platform.plug_name'}</th>
							<th class="w150">{lang key='platform::platform.plug_num'}</th>
							<th class="w180">{lang key='platform::platform.keyword'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$arr.item item=module} -->
						<tr>
							<td>{$module.ext_name}</td>
							<td class="hide-edit-area">
								{$module.ext_code}
								<div class="edit-list">
									<a class="data-pjax" href='{RC_Uri::url("platform/admin_command/init", "code={$module.ext_code}&account_id={$module.account_id}")}' title="{lang key='platform::platform.help_command'}">{lang key='platform::platform.help_command'}</a>&nbsp;|&nbsp;
									<a class="data-pjax" href='{RC_Uri::url("platform/admin/wechat_extend_edit", "code={$module.ext_code}&id={$module.account_id}")}' title="{lang key='platform::platform.edit_deploy'}">{lang key='platform::platform.edit_deploy'}</a>&nbsp;|&nbsp;
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除该公众号下的扩展[{$module.ext_name}]吗？{/t}" href='{RC_Uri::url("platform/admin/wechat_extend_remove", "code={$module.ext_code}&id={$module.account_id}")}' title="{lang key='platform::platform.delete'}">{lang key='platform::platform.delete'}</a>
								</div>
							</td>
							<td>{$module.command_list}</td>
						</tr>
						<!-- {foreachelse} -->
						   <tr><td class="no-records" colspan="3">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$arr.page} -->
			</div>
			
			<div class="right-bar move-mod">
				<div class="move-mod-group foldable-list">
					 <div class="accordion-group">
                     	<div class="accordion-heading">
                        	<a class="accordion-toggle move-mod-head acc-in" data-toggle="collapse" data-target="#search">
                            	<strong>{lang key='platform::platform.plug_message'}</strong>
                            </a>
                       	</div>
                        <div class="accordion-body in in_visable collapse" id="search">
                       		<div class="accordion-inner">
								<div class="control-group control-group-small choose_list" data-url="{url path='platform/admin/get_extend_list'}" data-id="{$id}">
									<input class="w243" type="text" name='keywords' value="{$smarty.get.keywords}" placeholder="{lang key='platform::platform.input_plugname_keywords'}" size="16"/>
									<a class="btn search_platform">{lang key='platform::platform.search'}</a>
								</div>
			
								<div class="control-group control-group-small draggable">
									<div class="ms-container" id="ms-custom-navigation" style="background:none;">
										<div class="ms-selectable">
											<div class="search-header">
												<input class="span12" id="ms-search" type="text" placeholder="{lang key='platform::platform.search_plug_message'}" autocomplete="off">
											</div>
											<ul class="ms-list nav-list-ready m_b0">
												<li class="ms-elem-selectable disabled"><span>{lang key='platform::platform.null_content'}</span></li>
											</ul>
										</div>
									</div>
								</div>
								
								<div class="control-group control-group-small m_b0">
									<input type="submit" value="{lang key='platform::platform.addition'}" class="btn btn-gebo" />
									<input type="hidden" value="{$id}" name="id" />
								</div>
		                     </div>
	                	</div>
                	</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>
<!-- {/block} -->