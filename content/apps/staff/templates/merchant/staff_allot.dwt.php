<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.staff_info.theForm();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<style>
.priv_list{
    width: 100%;
    overflow: hidden;
	margin-left:50px;
}
.priv_list .check{
    float: left;
    overflow: hidden;
    padding-left: 30px;
    width: 150px;
}
.priv_list .group_children{
   overflow: hidden;
}
</style>

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-primary data-pjax pull-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text} </a>
		{/if}
		</h2>
	</div>
</div>

<div class="row">
  <div class="col-lg-12">
      <section class="panel">
          <div class="panel-body">
    		  <!-- {ecjia:hook id=display_merchant_privilege_menus} -->
              <div class="form">
                  <form class="cmxform form-horizontal tasi-form" name="theForm" method="post" action="{$form_action}">
					  <div class="row priv_list">
							<div class="form-group checkall">
			                     <input name="checkall" id="all" data-toggle="selectall" data-children=".checkbox" type="checkbox" value="checkbox" autocomplete="off">
			                     <label for="all">{t domain="staff"}全选{/t}</label>
							</div>
							<hr>
							
						    {foreach from=$priv_group item=group}
							<div class="form-group">
								<div class="check">
									<input id="{$group.group_name}" class="checkbox"  name="chkGroup" data-toggle="selectall" data-children=".{$group.group_code} .checkbox" type="checkbox" value="checkbox" autocomplete="off" />
									<label for="{$group.group_name}">{$group.group_name}</label>
								</div>
								
								<div class="group_children {$group.group_code} ">
									{foreach from=$group.group_purview key=priv_key item=list}
									<div class="choose">
										<input id="{$list.action_code}" class="checkbox" type="checkbox" name="action_code[]" value="{$list.action_code}"  {if $list.cando eq 1} checked="true" {/if} title="{$list.relevance}" autocomplete="off" />
										<label for="{$list.action_code}"><!-- {$list.action_name} --></label>
									</div>
									{/foreach}
								</div>
							 </div>
							 <hr>
							 {/foreach}
						 </div>
						 
	                     <div class="form-group">
	                          <div class="col-lg-offset-2 col-lg-6">
	                          	  <input type="hidden"  name="user_id"  value="{$user_id}" />
	                              <button class="btn btn-info" type="submit">{t domain="staff"}更新{/t}</button>
	                          </div>
	                     </div>
                  </form>
              </div>
          </div>
      </section>
  </div>
</div>
<!-- {/block} -->