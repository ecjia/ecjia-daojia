<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
.table-condensed tr:first-child td {
    border: none;
}
</style>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable tabs-left">
		    {if $menu}
			<ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
			</ul>
			{/if}
			<div class="tab-content">
			<div class="tab-pane active">
				<table class="table table-striped">
        		    <thead>
        		      <tr>
            		      <th class="w120">时间</th>
            		      <th>操作人</th>
            		      <th>日志</th>
        		      </tr>
        		    </thead>
        		  	<tbody>
        		  		<!-- {foreach from=$log_list.list item=list} -->
        		  		<tr align="center">
	        			    <td>{$list.formate_time}</td>
	        			    <td>{$list.name}</td>
	        			    <td>
	        			    	<span style="line-height: 170%"> {$list.info}</span>
	            			    {if $list.log}
	                			    <table class="table table-condensed table-hover log">
	                                    <thead>
	                                        <tr>
		                                        <th width="20%">字段</th>
		                                        <th width="40%">旧值</th>
		                                        <th width="40%">新值</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    <!-- {foreach from=$list.log item=log} -->
	                                    <tr>
	                                        <td>{$log.name}</td>
	                                        <td>{if $log.is_img}{$log.original_data}{else}{$log.original_data}{/if}</td>
	                                        <td>{if $log.is_img}{$log.new_data}{else}{$log.new_data}{/if}</td>
	                                    </tr>
	                                    <!-- {/foreach} -->
	                                    </tbody>
	                                </table>
	                            {/if}
	        			    </td>
        			    </tr>
        				<!-- {foreachelse} -->
					    <tr><td class="no-records" colspan="3">暂无数据</td></tr>
        		    	<!-- {/foreach} -->
        			</tbody>
        		</table>
		      {$log_list.page}
			
			</div>
			</div>
      </div>
	</div>
</div>
<!-- {/block} -->
