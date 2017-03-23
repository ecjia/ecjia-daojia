<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.merchant.goods_info.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- #BeginLibraryItem "/library/appeal_step.lbi" --><!-- #EndLibraryItem -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
  	<div class="pull-right">
		<!-- {if $action_link} -->
			<a class="btn btn-primary data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid edit-page">
   <div class="panel">
        <div class="panel-body">
			<div class="span12 appeal_bottom">
				<div class="appeal_top">
					<div class="panel-body">
						<div class="appeal-thumb">
							{if $avatar_img}
			                	<img src="{RC_Upload::upload_url()}/{$avatar_img}" >
			                {else}
			                	<img src="{$ecjia_main_static_url}img/ecjia_avatar.jpg">
			                {/if}
						</div>
						<div class="appeal-thumb-details">
							<h1>{$comment_info.user_name}</h1>
							<p>{$comment_info.add_time}<span>IP：{$comment_info.ip_address}</span></p><br>
						</div>
						<div class="appeal-goods">
						  	<p>商品评分：
						  	{section name=loop loop=$comment_info.comment_rank}   
								<i class="fa fa-star" style="color:#FF9933;"></i>
							{/section}
							{section name=loop loop=5-$comment_info.comment_rank}   
								<i class="fa fa-star" style="color:#bbb;"></i>
							{/section}
			                <p>{$comment_info.content}</p>
			                <!-- {foreach from=$comment_pic_list item=list} -->
			                	<img src="{RC_Upload::upload_url()}/{$list.file_path}">
			                <!-- {/foreach} -->
						</div>
		            </div>    
				</div> 
				<h4>申诉内容</h4>        
				<div class="appeal_top">
					<div class="panel-body">
						<div class="appeal-content">
			                <p>{$appeal.appeal_content}</p>
			               	 <!-- {foreach from=$apple_img_list item=list} -->
			                	<img src="{RC_Upload::upload_url()}/{$list.file_path}">
			                 <!-- {/foreach} -->
			                <p>{$appeal.appeal_time}</p>
						</div>
		            </div>    
				</div> 
				{if $appeal.check_remark}
				<h4>平台回复</h4>        
				<div class="appeal_top">
					<div class="panel-body">
						<div class="appeal-content">
						    <p>{$appeal.check_remark}</p>
		               		<p>{$appeal.process_time}</p>
						</div>
		            </div>    
				</div> 
				{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->