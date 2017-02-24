<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.bonus.send_by_print_init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
		</h2>
	</div>
</div>

<div class="row">
  <div class="col-lg-12">
      <section class="panel">
          <div class="panel-body">
              <div class="form">
                  <form method="post" class="form-horizontal tasi-form" action="{$form_action}" name="bonus_thePrintForm" data-pjax-url="{RC_Uri::url('bonus/merchant/bonus_list')}" >
						<div class="form-group ">
	                          <label class="control-label col-lg-2">{lang key='bonus::bonus.bonus_type_id'}:</label>
	                          <div class="col-lg-6">
	                              <select class="form-control" name="bonus_type_id">
	                                 <option value="0">{t}请选择...{/t}</option>
									 <!-- {html_options options=$type_list selected=$smarty.get.id} -->
	                              </select>
	                          </div>
	                    </div>
						<div class="form-group">
	                          <label class="control-label col-lg-2">{lang key='bonus::bonus.send_bonus_count'}:</label>
	                           <div class="col-lg-6">
	                              <input class="form-control" name="bonus_sum" type="text" value="" />
	                          </div>
                              <span class="input-must">{lang key='system::system.require_field'}</span>
	                    </div>

	                    <div class="form-group">
	                         <div class="col-lg-offset-2 col-lg-6">
	                              <button class="btn btn-gebo  btn-info" type="submit">{lang key='system::system.button_submit'}</button>
	                              <input type="hidden" name="type_id" value="{$bonus_arr.type_id}" />
	                         </div>
	                    </div>
				</form>
              </div>
          </div>
      </section>
  </div>
</div>
<!-- {/block} -->