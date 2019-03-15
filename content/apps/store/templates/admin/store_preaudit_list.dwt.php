<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="nav nav-pills">
	<li class="{if !$smarty.get.type || $smarty.get.type == 'join'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("store/admin_preaudit/init", "{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}" )}'>{t domain="store"}申请入驻{/t} 
			<span class="badge badge-info">{$store_list.filter.count_join}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 'edit'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("store/admin_preaudit/init", "type=edit{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}")}'>{t domain="store"}资料修改{/t} 
			<span class="badge badge-info use-plugins-num">{$store_list.filter.count_edit}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 'refuse'}active{/if}">	
		<a class="data-pjax" href='{RC_Uri::url("store/admin_preaudit/init", "type=refuse{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}")}'>{t domain="store"}审核未通过{/t}
			<span class="badge badge-info unuse-plugins-num">{$store_list.filter.count_refuse}</span>
		</a>
	</li>
	<form class="f_r form-inline" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm" method="post">
    	<div class="f_l m_r5">
        	<select class="w150 " name="cat_id">
        	   <option value="">{t domain="store"}请选择分类{/t}</option>
        	   <!-- {foreach from=$cat_list key=k item=list} -->
        	   <option value="{$k}" {if $smarty.get.cat_id eq $k}selected="selected"{/if}>{$list}</option>
        	   <!-- {/foreach} -->
        	</select>
    	</div>
		<input type="text" name="keywords" placeholder='{t domain="store"}请输入店铺名称或手机号{/t}' value="{$store_list.filter.keywords}"/>
		<input class="btn search_store" type="submit" value='{t domain="store"}搜索{/t}'/>
  	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="w50">{t domain="store"}编号{/t}</th>
				    <th class="w100">{t domain="store"}店铺名称{/t}</th>
				    <th class="w100">{t domain="store"}商家分类{/t}</th>
				    <th class="w100">{t domain="store"}负责人{/t}</th>
				    <th class="w200">{t domain="store"}公司名称{/t}</th>
				    <th class="w150">{t domain="store"}手机号{/t}</th>
<!--                    <th class="w130">缴纳入驻金</th>-->
<!--                    <th class="w130">支付方式</th>-->
				    <th class="w150">{t domain="store"}申请时间{/t}</th>
			  	</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$store_list.store_list item=list} -->
				<tr>
					<td>{$list.id}</td>
				    <td class="hide-edit-area">
				    	<span>{$list.merchants_name}</span>
				    	<div class="edit-list">
				    		<a class="data-pjax" href='{RC_Uri::url("store/admin_preaudit/edit", "id={$list.id}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}' title='{t domain="store"}编辑{/t}'>{t domain="store"}编辑{/t}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{RC_Uri::url("store/admin_preaudit/check", "id={$list.id}{if $smarty.get.type}&type={$smarty.get.type}{/if}")}' title='{t domain="store"}审核{/t}'>{t domain="store"}审核{/t}</a>
					     </div>
					</td>
					<td>{$list.cat_name}</td>
					<td>{$list.responsible_person}</td>
					<td>{$list.company_name}</td>
					<td>{$list.contact_mobile}</td>
<!--                    <td>{$list.franchisee_amount}</td>-->
<!--                    <td>{$list.pay_name}</td>-->
					<td>{$list.apply_time}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="7">{t domain="store"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
            </tbody>
         </table>
    	<!-- {$store_list.page} -->
	</div>
</div>
<!-- {/block} -->