<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.staff_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
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
                  <form class="cmxform form-horizontal tasi-form" name="staffForm" method="post" action="{$form_action}">
                  	<header class="panel-heading">{t domain="staff"}员工基本信息{/t} <hr></header>
                      <div class="form-group">
                          <label for="firstname" class="control-label col-lg-2">{t domain="staff"}员工名称：{/t}</label>
                          <div class="col-lg-6 controls">
                              <input class="form-control" id="name" name="name" type="text" value="{$staff.name}" />
                          </div>
                          <span class="input-must m_l7"><span class="require-field" style="color:#FF0000,">*</span></span>
                      </div>
                      
                      <div class="form-group">
                          <label for="firstname" class="control-label col-lg-2">{t domain="staff"}员工昵称：{/t}</label>
                          <div class="col-lg-6">
                              <input class="form-control" id="nick_name" name="nick_name" type="text" value="{$staff.nick_name}"/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-lg-2">{t domain="staff"}员工编号：{/t}</label>
                           <div class="col-lg-6 controls">
                              <input class="form-control" id="user_ident" name="user_ident" type="text" value="{$staff.user_ident}" />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="ccomment" class="control-label col-lg-2">{t domain="staff"}员工介绍：{/t}</label>
                          <div class="col-lg-6 controls">
                              <textarea class="form-control" id="introduction" name="introduction">{$staff.introduction}</textarea>
                          </div>
                      </div>
                      
                      {if $parent_id neq 0}
                      <div class="form-group">
                          <label for="firstname" class="control-label col-lg-2">{t domain="staff"}选择员工组：{/t}</label>
                          <div class="col-lg-6">
                              <select class="form-control" name="group_id">
								 <!-- {html_options options=$group_list selected=$staff.group_id} -->
                              </select>
                          </div>
                      </div>
                      {/if}
                      
                      {if $manage_id eq 0}
  					  <div class="form-group">
                          <label for="ccomment" class="control-label col-lg-2">{t domain="staff"}备注：{/t}</label>
                          <div class="col-lg-6">
                              <textarea class="form-control" id="todolist" name="todolist">{$staff.todolist}</textarea>
                               <p class="help-block">{t domain="staff"}该备注仅店长可见{/t}</p>
                          </div>
                      </div>
                      {/if}
                      
                      <div class="form-group">
                          <label class="control-label col-lg-2">{t domain="staff"}加入时间：{/t}</label>
                          <div class="col-lg-6">
                             <p class="form-control-static">{$staff.add_time}</p>
                          </div>
                      </div>
                     
                      <header class="panel-heading">{t domain="staff"}员工账户信息{/t} <hr></header>
                      <div class="form-group">
                          <label for="firstname" class="control-label col-lg-2">{t domain="staff"}手机账号：{/t}</label>
                          <div class="col-lg-6 controls">
                              <input class="form-control" id="mobile" name="mobile" type="text" value="{$staff.mobile}" readonly="true" />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="firstname" class="control-label col-lg-2">{t domain="staff"}邮箱账号：{/t}</label>
                          <div class="col-lg-6 controls">
                              <input class="form-control" id="email" name="email" type="text" value="{$staff.email}" readonly="true" />
                          </div>
                      </div>
                      
                     
                      <div class="form-group">
                          <label for="new_password" class="control-label col-lg-2">{t domain="staff"}新密码：{/t}</label>
                          <div class="col-lg-6 controls">
                              <input class="form-control" type="password"  id="new_password" name="new_password"  value=""/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="confirm_password" class="control-label col-lg-2">{t domain="staff"}确认密码：{/t}</label>
                          <div class="col-lg-6 controls">
                              <input class="form-control" id="edit_confirm_password" name="edit_confirm_password" type="password" value="" />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-6">
                          	  <input type="hidden"  name="user_id" value="{$staff.user_id}" />
                          	  <input type="hidden"  name="parent_id" value="{$parent_id}" />
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