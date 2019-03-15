<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.push_event.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<a class="all_close plus_or_reply" data-msg='{t domain="push"}您确定要关闭全部推送消息事件吗？{/t}' data-href='{url path="push/admin_events/all_close"}'><button class="btn" type="button">{t domain="push"}全部关闭{/t}</button></a>     
	    <a class="all_open plus_or_reply"  data-msg='{t domain="push"}您确定要开启全部推送消息事件吗？{/t}' data-href='{url path="push/admin_events/all_open"}'><button class="btn btn-gebo" type="button">{t domain="push"}全部开启{/t}</button></a>     
	</h3>
</div>

<div class="row-fluid search_page">
	<div class="span12">
         <div class="search_panel clearfix">
		   <!-- {foreach from=$data item=val} -->
           	 <div class="search_item clearfix">
           	  	<div class="pull-right">
	                <a class="change_status" style="cursor: pointer;"  data-msg='{if $val.status eq 'open'}{t domain="push"}您确定要关闭该消息事件吗？{/t}{else}{t domain="push"}您确定要开启该消息事件吗？{/t}{/if}' data-href='{if $val.status eq "open"}{url path="push/admin_events/close" args="code={$val.code}&id={$val.id}"}{else}{url path="push/admin_events/open" args="code={$val.code}&id={$val.id}"}{/if}' >
                       {if $val.status eq 'open'}
                       <button class="btn" type="button" style="margin-top: 20px;">{t domain="push"}点击关闭{/t}</button>  
                       {else}
                       <button class="btn btn-gebo" type="button" style="margin-top: 20px;">{t domain="push"}点击开启{/t}</button> 
                       {/if}
	                </a>        
                </div>
                
                <div class="search_content" style="padding-left: 0px;">
                    <h4>
                        <a class="sepV_a" style="text-decoration:none;">{$val.name}</a>{if $val.status eq 'open'}<span class="label label-info">{t domain="push"}开启中{/t}</span>{else}<span class="label">{t domain="push"}已关闭{/t}</span>{/if}    
                    </h4>
                    <p class="sepH_a"><strong>{$val.code}</strong></p>
                    <p class="sepH_b item_description">{$val.description}</p>
                </div>
             </div>
         <!-- {/foreach} -->  
        </div>
	</div>
</div>
<!-- {/block} -->