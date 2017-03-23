<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->

<script type="text/javascript">
	ecjia.merchant.appeal_info.init();



	function getObjectURL(file) {
		var url = null;
		if (window.createObjectURL != undefined) {
			url = window.createObjectURL(file)
		} else if (window.URL != undefined) {
			url = window.URL.createObjectURL(file)
		} else if (window.webkitURL != undefined) {
			url = window.webkitURL.createObjectURL(file)
		}
		return url
	}
	
    $(function() {
		$(".filepath").live("change",function() {
			var srcs = getObjectURL(this.files[0]);
			var htmlImg='<div class="imgbox">'+
					  '<div class="imgnum1">'+
					  '<input type="file" name="file[]" class="filepath" />'+
					  '<img class="pic_close" src="{$ecjia_main_static_url}img/x_alt.png"/>'+
					  '<img src="{$ecjia_main_static_url}img/appeal_pic.png" class="img11"/>'+
					  '<img src="" class="img22"/>'+
					  '</div>'+
					  '</div>';
			$(this).parent().parent().after(htmlImg);
			$(this).parent().children(".img22").attr('src', srcs);
			$(this).parent().children(".img11").hide();
			$(this).parent().children('.pic_close').show(); 
			$(this).attr('disabled', 'disabled');
			
			
			$(".pic_close").on("click",function() {
				 $(this).hide();
				 $(this).nextAll(".img22").hide();
				 $(this).nextAll(".img11").show(); 
				 if($('.imgbox').length>1){
					$(this).parent().parent().remove();
				 }
			})
		});
	});
</script>

<style type="text/css">
	.imgbox{
		float: left;
		margin-right: 5px;	
		position: relative;
		width: 50px;
		height: 50px;
		overflow: hidden;
	}
	.imgnum input,.imgnum1 input {
		position: absolute;
		width: 50px;
		height: 50px;
		opacity: 0;
	}
	.img11,.img22 {
		width: 50px;
		height: 50px;
	}
	.pic_close{
		position: absolute; 
		left: 35px; 
		top: 0px; 
		display: none; 
		z-index:99999;
	}
</style>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<!-- #BeginLibraryItem "/library/appeal_step.lbi" --><!-- #EndLibraryItem -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
  	<div class="pull-right">
		<!-- {if $action_link} -->
			<a class="btn btn-primary data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fa fa-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid edit-page">
   <div class="panel">
        <div class="panel-body">
			<div class="span12">
				<div class="appeal_top">
					<div class="panel-body">
						<a class="appeal-thumb">
							{if $avatar_img}
			                	<img src="{RC_Upload::upload_url()}/{$avatar_img}" >
			                {else}
			                	<img src="{$ecjia_main_static_url}img/ecjia_avatar.jpg">
			                {/if}
						</a>
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
							</p>
			                <p>{$comment_info.content}</p>
			                <!-- {foreach from=$comment_pic_list item=list} -->
			                	<img src="{RC_Upload::upload_url()}/{$list.file_path}">
			                <!-- {/foreach} -->
						</div>
		            </div>    
				</div> 
				<div class="appeal_bottom"> 
					<h4>申诉内容</h4>        
					<form class="form-horizontal" action='{$form_action}' method="post" name="theForm"  enctype="multipart/form-data">
						<textarea class="form-control" id="appeal_content" name="appeal_content" placeholder="请输入申诉理由" ></textarea>
						<br>
						<div class="imgbox">
							<div class="imgnum">
								<input type="file" name="file[]" class="filepath" />
								<img class="pic_close" src="{$ecjia_main_static_url}img/x_alt.png"/>
								<img src="{$ecjia_main_static_url}img/appeal_pic.png" class="img11" />
								<img src="" class="img22" />
							</div>
						</div>
						<br><br><br>
						<input type="hidden" name="comment_id" value="{$comment_info.comment_id}" />
						<button class="btn btn-info" id="appeal_btn" type="submit">提交申诉</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->