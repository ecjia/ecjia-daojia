<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.staff_group_edit.init();
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
              <div class="form">
                  <form class="cmxform form-horizontal tasi-form" name="groupForm" method="post" action="{$form_action}">
                	 <div class="form-group">
                          <label for="firstname" class="control-label col-lg-2">{lang key='staff::staff.group_name_lable'}</label>
                          <div class="col-lg-6 controls">
                              <input class="form-control" id="group_name" name="group_name" type="text" value="{$staff_group.group_name}"/>
                          </div>
                          <span class="input-must m_l7">{lang key='system::system.require_field'}</span>
                      </div>
                      
                      <div class="form-group">
                        <label for="ccomment" class="control-label col-lg-2">{lang key='staff::staff.group_desc_lable'}</label>
                        <div class="col-lg-6 controls">
                          <textarea class="form-control" id="groupdescribe" name="groupdescribe">{$staff_group.groupdescribe}</textarea>
                        </div>
                        <span class="input-must m_l7">{lang key='system::system.require_field'}</span>
                      </div>

					  	<div class="row priv_list">
							<div class="form-group checkall">
			                     <input name="checkall" id="all" data-toggle="selectall" data-children=".checkbox" type="checkbox" value="checkbox" autocomplete="off">
			                     <label for="all">全选</label>
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
						 
	                 	{if $edit eq 'edit'}
	                      <div class="form-group">
	                          <div class="col-lg-offset-2 col-lg-6">
	                          	  <input type="hidden"  name="group_id" value="{$staff_group.group_id}" />
	                              <button class="btn btn-info" type="submit">{lang key='staff::staff.sub_update'}</button>
	                              <a class="btn btn-danger m_l10" data-toggle="ajaxremove" data-msg="您确定要删除该员工组吗？删除后该组下的员工将被移至到默认员工组" href="{RC_Uri::url('staff/mh_group/remove')}&group_id={$staff_group.group_id}">{lang key='staff::staff.sub_delete'}</a>
	                          </div>
	                      </div>
	                    {else}
	                      <div class="form-group">
	                         <div class="col-lg-offset-2 col-lg-6">
	                             <button class="btn btn-info" type="submit">{lang key='staff::staff.sub'}</button>
	                         </div>
	                     </div>
	                    {/if}
                  </form>
              </div>
          </div>
      </section>
  </div>
</div>
<!-- {/block} -->