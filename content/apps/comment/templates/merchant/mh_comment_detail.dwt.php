<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.mh_comment.comment_info();
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
			<i class="fa fa-reply"></i>{$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row" id="home-content">
    <div class="col-lg-8">
        <section class="panel">
            <div class="panel-body">
				<div class="comment_top">
					<div class="panel-body">
						<div class="comment-thumb">
							{if $avatar_img}
			                	<img src="{RC_Upload::upload_url()}/{$avatar_img}" >
			                {else}
			                	<img src="{$ecjia_main_static_url}img/ecjia_avatar.jpg">
			                {/if}
						</div>
						<div class="comment-thumb-details">
							<h1>{$comment_info.user_name}</h1>
							<p>{$comment_info.add_time}<span>IP：{$comment_info.ip_address}</span></p><br>
						</div>
						<div class="comment-goods">
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
						{if $go_on_appeal}
							<button class="btn btn-info" type="button" style="margin-top: 10px;" disabled="disabled">申诉中</button>
						{else}
							<a href='{url path="comment/mh_appeal/add_appeal" args="comment_id={$comment_info.comment_id}"}'><button class="btn btn-info" type="button" style="margin-top: 10px;">申诉</button></a>
						{/if}
						
		            </div>    
				</div><br>
				
		        <div id="accordionOne">
		            <div class="panel panel-info">
		                <div class="panel-heading">
		                    <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" class="accordion-toggle">
		                        <span class="glyphicon"></span>
		                        <h4 class="panel-title">管理员回复内容</h4>
		                    </a>
		                </div>
		                <div id="collapseOne" class="panel-collapse collapse in">
	                         <div class="panel-body">
	                         	  <!-- {foreach from=$replay_admin_list item=list} -->
		                              <div class="text-right">
		                                 <div class="comment-all-right-thumb">
		                                	{if $list.staff_img}
						                		<img src="{RC_Upload::upload_url()}/{$list.staff_img}" >
						                	{else}
						                		<img src="{$ecjia_main_static_url}img/ecjia_avatar.jpg">
						                	{/if}
										 </div>
							  			  <div class="comment-thumb-details">
							  			 	{if $list.user_type eq 'admin'}
							  			 	<h1><span><small class="label label-warning-admin">平台管理员</small></span>&nbsp;{$list.admin_user_name}</h1>
							  			 	{else}
							  			 	<h1><span><small class="label label-warning-admin">商家管理员</small></span>&nbsp;{$list.staff_name}</h1>
							  			 	{/if}
											<p>{$list.add_time_new}</p><br>
										 </div>
										 <p>{$list.content}</p>
		                              </div>
		                          <!-- {foreachelse} -->
		                           <div class="text-center">
		                             	管理员暂时还未回复任何消息
		                           	</div>
	                              <!-- {/foreach} -->
	                          </div>
		                </div>
		              </div>
		        </div>
		        
		       	<div class="comment-reply">
					<div class="panel-body">
						<h4>回复评论</h4>
						<form class="form-horizontal" action="{$from_action}" method="post" name="theForm">
							 <div class="reply-content">
                                 <h5 class="reply-title">回复内容：</h5>
                                 <div class="reply-content-textarea">
                                      <textarea class="form-control" id="reply_content" name="reply_content" placeholder="请输入回复内容" ></textarea>
                                 </div>
                             </div>
                             <div class="text-right">
								<input type="checkbox" id="is_ok" name="is_ok" value="1">
								<label for="is_ok" style="margin-top:18px;">邮件通知</label>
								<div class="reply-email">
									<input class="form-control" placeholder="请输入电子邮箱" type="text" name="reply_email" value="{$comment_info.email}">
								</div>
							 </div>
                             <input type="hidden" name="comment_id" value="{$comment_info.comment_id}" />
							 <div class="reply-btn">
						   		<input class="btn btn-info" type="submit" value="回复"/>
						     </div>
						</form>
		            </div>    
				</div>
            </div>
        </section>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-body">
            <div class="comment-goods-detail">
			  	<h4>商品信息</h4>
			  	<div class="goods-img">
			  		<img src="{RC_Upload::upload_url()}/{$goods_info.goods_thumb}">
			  	</div>
                <p>{$goods_info.goods_name}</p>
                <p>价格：<font color="#FF0000"><strong>¥&nbsp;{$goods_info.shop_price}</strong></font></p>
                <p>购买于：{$order_add_time}</p>
        </div>
        </div>
        <section class="panel panel-body">
          <div class="goods-all-reply">
          	  <h4>其他评价</h4>
	          <!-- {foreach from=$other_comment item=list} -->
		          <p>{$list.user_name}<span><a href='{url path="comment/mh_comment/comment_detail" args="comment_id={$list.comment_id}"}'>查看</a></span></p>
		          <p>{$list.content}</p>
		          <p class="text-right">
		            {section name=loop loop=$list.comment_rank}   
						<i class="fa fa-star" style="color:#FF9933;"></i>
					{/section}
					{section name=loop loop=5-$list.comment_rank}   
						<i class="fa fa-star" style="color:#bbb;"></i>
					{/section}
		          </p>
		          <hr>
	          <!-- {foreachelse} -->
		          <div class="text-center">
		          		暂无其他相关评论
		          </div>
	          <!-- {/foreach} -->
	          {if $other_comment|@count neq 0}
	           	  <p class="text-right"><a href='{url path="comment/mh_comment/init" args="goods_id={$comment_info.id_value}"}'>查看更多</a></p>
			  {/if} 
		  </div>
		</section>
	</div>
</div>
<!-- {/block} -->