<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
     <div class="col-lg-12">
         <div class="position_detail" data-url='{RC_Uri::url("adsense/mh_group/update_sort")}'>
            <h3>广告组信息</h3>
            <ul>
                <li>
	                <div class="detail">
	                	<strong>广告组名称：</strong><span>{$position_data.position_name}{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</span>
	               	</div>
                </li>
            </ul>
          </div>
     </div>		
</div>

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} --><font style="color: #999;">（拖拽列表可排序）</font>
		<div class="pull-right">
			{if $edit_action_link}
				<a href="{$edit_action_link.href}" class="btn btn-primary data-pjax" id="sticky_a"><i class="fa fa-plus"></i> {$edit_action_link.text}</a>
			{/if}
			
			{if $action_link}
				<a href="{$action_link.href}" class="btn btn-primary data-pjax" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
			{/if}
		</div>
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
		   <div class="panel-body panel-body-small">
			   	<div class="panel-heading">
					<form class="form" action='{url path="adsense/mh_group/constitute_insert" args="position_id={$position_id}"}' method="post" name="theForm">
						<fieldset>
							<div class="row draggable">
								<div class="ms-container" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="form-control" id="ms-search" type="text" placeholder="筛选搜索到的广告位信息" autocomplete="off">
										</div>
										<ul class="ms-list nav-list-ready">
											<!-- {foreach from=$opt item=link_position} -->
												<li class="ms-elem-selectable {if in_array($link_position, $group_position_list)}disabled{/if}"  id="{$link_position.position_id}" data-id="{$link_position.position_id}"><span>{$link_position.position_name}</span></li>
											<!-- {foreachelse} -->
												<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
											<!-- {/foreach} -->
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">
											编排广告位
										</div>
										<ul class="ms-list nav-list-content">
											<!-- {foreach from=$group_position_list item=link_position key=key} -->
											<li class="ms-elem-selection">
												<input type="hidden" value="{$link_position.position_id}" name="position_id[]" />
													{$link_position.position_name}
												<span class="edit-list"><i class="fa fa-minus-circle ecjiafc-red del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</fieldset>
						
						<p class="t_c row m_t20">
							<button class="btn btn-info" type="submit">确定</button>
						</p>
					 </form>
				</div>
    	   </div>
		</div>
	</div>
</div>
<!-- {/block} -->