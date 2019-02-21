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
                    	<div class="pull-left">{t domain="printer"}小票机列表{/t}</div>
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
		        						<span class="status">{t domain="printer"}在线{/t}</span>
		        						{else if $val.online_status eq 2}
		        						<span class="status error">{t domain="printer"}缺纸{/t}</span>
		        						{else if $val.online_status eq 0}
		        						<span class="status error">{t domain="printer"}离线{/t}</span>
		        						{/if}
		        					</div>
		        				</div>
		        				<div class="bottom">
		        					<div class="bottom-item">{t domain="printer"}终端编号{/t}&nbsp;{$val.machine_code}</div>
		        					<div class="bottom-item">{t domain="printer"}打印机型{/t}&nbsp;{$val.version}</div>
		        					<div class="bottom-item">{t domain="printer"}添加日期{/t}&nbsp;{RC_Time::local_date('Y-m-d H:i:s', $val['add_time'])}</div>
		        				</div>
		        				<div class="view">
		        					<a class="btn btn-primary data-pjax" href='{RC_Uri::url("printer/mh_print/view", "id={$val.id}")}'>{t domain="printer"}查看{/t}</a>
		        				</div>
		        			</li>
		        			<!-- {foreachelse} -->
		        			<div class="no_printer">{t domain="printer"}没有找到任何记录{/t}</div>
		        			<!-- {/foreach} -->
		        		</ul>
		        	</div>
            	</div>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
