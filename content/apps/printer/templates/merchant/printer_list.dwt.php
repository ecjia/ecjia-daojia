<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
//     ecjia.merchant.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-lg-3">
                    <!-- {ecjia:hook id=display_merchant_printer_menus} -->
                </div>
                
                <div class="col-lg-9">
                	<h3 class="page-header">
                    	<div class="pull-left">小票机列表</div>
						<div class="clearfix"></div>
  					</h3>
		  			<div class="printer_list wookmark merchant_printer">
		        		<ul>
		        			<!-- {foreach from=$list item=val} -->
		        			<li class="thumbnail">
		        				<div class="top printer_logo">
		        					<img src="{if $val.machine_logo}{$val.machine_logo}{else}{$statics_url}images/printer_logo.png{/if}" />
		        					<div class="top_right">
		        						<span class="name">{$val.machine_name}</span>
		        						{if $val.online_status eq 1}
		        						<span class="status">在线</span>
		        						{else if $val.online_status eq 2}
		        						<span class="status error">缺纸</span>
		        						{else if $val.online_status eq 0}
		        						<span class="status error">离线</span>
		        						{/if}
		        					</div>
		        				</div>
		        				<div class="bottom">
		        					<div class="bottom-item">终端编号&nbsp;&nbsp;{$val.machine_code}</div>
		        					<div class="bottom-item">打印机型&nbsp;&nbsp;{$val.version}</div>
		        					<div class="bottom-item">添加日期&nbsp;&nbsp;{RC_Time::local_date('Y-m-d H:i:s', $val['add_time'])}</div>
		        				</div>
		        				<div class="view">
		        					<a class="btn btn-primary data-pjax" href='{RC_Uri::url("printer/mh_print/view", "id={$val.id}")}'>查看</a>
		        				</div>
		        			</li>
		        			<!-- {foreachelse} -->
		        			<div class="no_printer">没有找到任何记录</div>
		        			<!-- {/foreach} -->
		        		</ul>
		        	</div>
            	</div>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
