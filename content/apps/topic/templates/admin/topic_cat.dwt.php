<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_cat.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li><a class="data-pjax" href='{url path="topic/admin/edit" args="id={$smarty.get.id}"}'>{t domain="topic"}通用信息{/t}</a></li>
				<li class="active"><a href="javascript:;">{t domain="topic"}专题分类{/t}</a></li>
				<li><a class="data-pjax" href='{url path="topic/admin/topic_goods" args="id={$smarty.get.id}"}'>{t domain="topic"}专题商品{/t}</a></li>
			</ul>
			<form class="form-horizontal" action='{$form_action}' method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="row-fluid editpage-leftbar">
							<div class="left-bar">
					            <h4>{t domain="topic"}添加专题分类：{/t}</h4> <br>
					            <input type="text" name="topic_cat_name" id="keyword" /><br><br>
				        		<input type="submit"  value="{t domain="topic"}确定{/t}" class="btn btn-gebo" />
							</div>
						
							<div class="right-bar">
								<table class="table dataTable table-hide-edit table-striped">
									<thead>
										<tr>
											<th>{t domain="topic"}分类名称{/t}</th>
											<th class="w70">{t domain="topic"}操作{/t}</th>
										</tr>
									</thead>
									<tbody>
										<!-- {foreach from=$topic_cat item=value key=key} -->
										<tr>
											<td>
												{$key}
											</td>
											<td align="center">
												<span>
													<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="topic"}您确定要删除专题分类吗？{/t}' href='{RC_Uri::url("topic/admin/remove_catname","key={$key}")}&id={$topic_id}' title='{t domain="topic"}删除{/t}'><i class="fontello-icon-trash"></i></a>
												</span>
											</td>
										</tr>
										<!-- {foreachelse} -->
										<tr>
											<td class="no-records" colspan="10">{t domain="topic"}没有找到任何记录{/t}</td>
										</tr>
										<!-- {/foreach} -->
									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->