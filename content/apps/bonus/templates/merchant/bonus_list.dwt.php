<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.bonus_type.list_init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
        	<div class="panel-body panel-body-small">
        		 <div class="btn-group">
		            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'} <span class="caret"></span></button>
		            <ul class="dropdown-menu">
		               <li><a class="remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="bonus/merchant/batch" args="sel_action=remove&bonus_type_id=$bonus_type_id"}' data-msg="您确定要这么做吗？" data-noSelectMsg="请先选中要删除的红包！" data-name="checkboxes" href="javascript:;"><i class="fa fa-trash-o"></i> {t}删除红包{/t}</a></li>
		            <!-- {if $show_mail} -->
	            <li><a class="send"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="bonus/merchant/batch" args="sel_action=send&bonus_type_id=$bonus_type_id"}' data-msg="您确定要这么做吗？" data-noSelectMsg="您确定要插入邮件发送对列的红包？" data-name="checkboxes" href="javascript:;"><i class="fa fa-hand-o-right"></i> {t}插入邮件发送队列{/t}</a></li>
	            <!-- {/if} -->
		               </ul>
		        </div>
        	</div>
        	<div class="panel-body panel-body-small">
        	   <section class="panel">
	            <table class="table table-striped table-advance table-hover">
	                <thead>
	                    <tr>
	                        <th class="table_checkbox w35">
	                            <div class="check-list">
	                                <div class="check-item">
	                                    <input id="checkall" type="checkbox" data-toggle="selectall"  data-children=".checkbox"/>
	                                    <label for="checkall"></label>
	                                </div>
	                            </div>
	                        </th>
	                        <!-- {if $show_bonus_sn} -->
                        <th>{lang key='bonus::bonus.bonus_sn'}</th>
                        <!-- {/if} -->
                        <th>{lang key='bonus::bonus.bonus_type'}</th>
                        <th>{lang key='bonus::bonus.order_id'}</th>
                        <th>{lang key='bonus::bonus.user_id'}</th>
                        <th>{lang key='bonus::bonus.used_time'}</th>
                        <!-- {if $show_mail} -->
                        <th>{lang key='bonus::bonus.emailed'}</th>
                        <!-- {/if} -->
                        <th>{lang key='bonus::bonus.handler'}</th>
                    </tr>
                </thead>
                <tbody>
                    <!--{foreach from=$bonus_list.item item=bonus} -->
                    <tr>
                        <td>
                            <div class="check-list">
                                <div class="check-item">
                                    <input id="checkbox_{$bonus.bonus_id}" type="checkbox" name="checkboxes[]"  class="checkbox"  value="{$bonus.bonus_id}"/>
                                    <label for="checkbox_{$bonus.bonus_id}"></label>
                                </div>
                            </div>
                        </td>
                        <!-- {if $show_bonus_sn} -->
                        <td>{$bonus.bonus_sn}</td>
                        <!-- {/if} -->
                        <td>{$bonus.type_name}</td>
                        <td>{$bonus.order_sn}</td>
                        <td>{$bonus.user_name}</td>
                        <td>{$bonus.used_time}</td>
                        <!-- {if $show_mail} -->
                        <td>{$bonus.emailed}</td>
                        <!-- {/if} -->
                        <td>
                            <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='goods::goods.trash_goods_confirm'}" href='{RC_Uri::url("bonus/merchant/remove_bonus", "id={$bonus.bonus_id}")}'>{lang key='system::system.drop'}</a>&nbsp;&nbsp;
                            {if $show_mail and $bonus.order_id eq 0 and $bonus.email}<a class="insert_mail_list no-underline" href="javascript:;" data-href="{RC_Uri::url('bonus/merchant/send_mail',"bonus_id={$bonus.bonus_id}&bonus_type={$bonus_type_id}")}" title="{t}插入邮件发送队列{/t}"><i class="fa fa-hand-o-right"></i></a>{/if}
                        </td>
                    </tr>
                    <!-- {foreachelse} -->
                    <tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
            </section>
            <!-- {$bonus_list.page} -->
           </div> 
        </div>
    </div>
</div>
<!-- {/block} -->