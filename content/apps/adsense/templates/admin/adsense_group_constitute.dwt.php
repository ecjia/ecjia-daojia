<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
     <div class="span12">
         <div class="position_detail">
            <h3>{t domain="adsense"}广告组信息{/t}</h3>
            <ul>
                <li><div class="detail"><strong>{t domain="adsense"}广告组名称：{/t}</strong><span>{$position_data.position_name}{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</span></div></li>
                <li>
                	<div class="detail">
		                <strong>{t domain="adsense"}所在城市：{/t}</strong><span>{$position_data.city_name}</span>
		                <p class="f_r"> 
			               <a class="data-pjax ecjiafc-gray" href='{RC_Uri::url("adsense/admin_group/edit", "position_id={$position_data.position_id}&city_id={$city_id}")}'><i class="fontello-icon-edit"></i>{t domain="adsense"}编辑广告组{/t}</a>&nbsp;|&nbsp;
			               <a class="ajaxremove ecjiafc-gray" data-toggle="ajaxremove" data-msg='{t domain="adsense"}你确定要删除该广告组吗？{/t}' href='{RC_Uri::url("adsense/admin_group/remove", "group_position_id={$position_data.position_id}&city_id={$city_id}&key=constitute")}' title='{t domain="adsense"}删除{/t}'><i class="fontello-icon-trash"></i>{t domain="adsense"}删除广告组{/t}</a>
		                </p>
	                </div>
                </li>
            </ul>
          </div>
     </div>		
</div>

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
			<form class="form-horizontal" action='{url path="adsense/admin_group/constitute_insert" args="position_id={$position_id}&city_id={$city_id}"}' method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="control-group draggable">
							<div class="ms-container" id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder='{t domain="adsense"}筛选搜索到的广告位信息{/t}' autocomplete="off" />
									</div>
									<ul class="ms-list nav-list-ready">
										<!-- {foreach from=$opt item=link_position} -->
											<li class="ms-elem-selectable {if in_array($link_position, $group_position_list)}disabled{/if}"  id="{$link_position.position_id}" data-id="{$link_position.position_id}"><span>{$link_position.position_name}</span></li>
										<!-- {foreachelse} -->
											<li class="ms-elem-selectable disabled"><span>{t domain="adsense"}暂无内容{/t}</span></li>
										<!-- {/foreach} -->
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">
                                        {t domain="adsense"}编排广告位{/t}
									</div>
									<ul class="ms-list nav-list-content">
										<!-- {foreach from=$group_position_list item=link_position key=key} -->
										<li class="ms-elem-selection">
											<input type="hidden" value="{$link_position.position_id}" name="position_id[]" />
											{$link_position.position_name}
											<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
										</li>
										<!-- {/foreach} -->
									</ul>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<p class="ecjiaf-tac">
					<button class="btn btn-gebo" type="submit">{t domain="adsense"}确定{/t}</button>
				</p>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->