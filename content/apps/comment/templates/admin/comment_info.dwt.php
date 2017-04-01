<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.comment_manage.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i> {$action_link.text}</a>
		{/if}
	</h3>
</div>
<!-- start add new category form -->
<form class="form-horizontal comment_info" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data" data-edit-url="{RC_Uri::url('goods/admin_category/edit')}">
	<div class="row-fluid editpage-rightbar">
		<div class="left-bar move-mod">
		
			<div class="control-group">
                <div class="comment_top">
    				<div class="panel-body">
    					<div class="comment-thumb">
    						{if $avatar_img}
    		                	<img src="{$avatar_img}" >
    		                {/if}
    					</div>
    					<div class="comment-thumb-details">
    						<h1>{if $comment_info.is_anonymous eq 1 }{'匿名发表'}{else}{$comment_info.user_name}{/if}</h1>
    						<p>{$comment_info.add_time}<span>IP: {$comment_info.ip_address}</span></p><br>
    					</div>
    					<div class="comment-goods">
    					  	<p>商品评分：{section name=loop loop=$comment_info.comment_rank}<i class="fontello-icon-star" style="color:#FF9933;"></i>{/section}{section name=loop loop=5-$comment_info.comment_rank}<i class="fontello-icon-star" style="color:#bbb;"></i>{/section}</p>
    		                <p>{$comment_info.content}</p>
    		                 <!-- {foreach from=$comment_pic_list item=list} -->
    		                	<img src="{RC_Upload::upload_url()}/{$list.file_path}">
    		                 <!-- {/foreach} -->
    					</div>
    					{if $comment_info.status neq 3}
    					<div class="edit-list">
    					   {if $comment_info.status eq 0}
    							<a class="approve" href='{url path="comment/admin/check" args="list=5&comment_id={$comment_info.comment_id}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg="{t}您确定要更改此评论的状态吗？{/t}" data-status="{$smarty.get.status}" data-val="allow" >
    								{t}批准{/t}
    							</a>&nbsp;|&nbsp;
    						{elseif $comment_info.status eq 1}
    							<a class="approve ecjiafc-red" href='{url path="comment/admin/check" args="list=5&comment_id={$comment_info.comment_id}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg="{t}您确定要更改此评论的状态吗？{/t}" data-status="{$smarty.get.status}" data-val="forbid" >
    								{t}驳回{/t}
    							</a>&nbsp;|&nbsp;
    						{/if}
							<a class="ecjiafc-red toggle_view" href='{url path="comment/admin/check" args="list=5&comment_id={$comment_info.comment_id}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg="{t}您确定要将该用户[{$comment_info.user_name|default:{lang key='comment::comment_manage.anonymous'}}]的评论移至回收站吗？{/t}" data-status="{$smarty.get.status}" data-val="trashed_comment" >{t}移至回收站{/t}</a>
						</div>
						{/if}
    	            </div>    
    			</div><br>
			
			</div>

			<div class="foldable-list move-mod-group" id="goods_info_sort_seo">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_seo">
							<strong>{'回复评价'}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="goods_info_area_seo">
						<div class="accordion-inner">
						      <div class="panel-body">
						          <!-- {foreach from=$replay_admin_list item=list} -->
                                    <div class="text-right admin-reply">
        								 {if $list.user_type eq 'merchant'}
	        								 <div class="comment-thumb-details">
	        									<h1><span><small class="label label-warning-admin">商家管理员</small></span>&nbsp;&nbsp;{$list.staff_name}</h1>
	        									<p>{$list.add_time}</p><br>
	        								 </div>
        								 {elseif $list.user_type eq 'admin'}
	        								 <div class="comment-thumb-details">
	        									<h1><span><small class="label label-warning-admin">平台管理员</small></span>&nbsp;&nbsp;{$list.admin_name}</h1>
	        									<p>{$list.add_time}</p><br>
	        								 </div>
        								 {/if}
        								 <p>{$list.content}</p>
        								 <div class="comment-all-right-thumb" style="margin-left: 10px;">
    	                                	{if $list.user_type eq 'merchant'}
    					                		<img src="{$list.staff_img}" >
    					                	{elseif $list.user_type eq 'admin'}
    					                		<img src="{$list.admin_img}">
    					                	{/if}
    									 </div>
                                    </div>
                                  <!-- {foreachelse} -->
                                    <div class="text-center">管理员暂时还未回复任何消息</div>
                                  <!-- {/foreach} -->
                            </div>
						</div>
					</div>
				</div>
			</div>
			<div class="control-group">
			    <div class="reply-title">回复： </div>
    			<textarea class="span12 form-control" name="reply_content" rows="6" cols="48" placeholder="回复内容"></textarea>
    			<div class="text-right" style="margin: 10px 0">
					<input type="checkbox" name="is_ok" id="is_ok" value="1" /><span>{'邮件通知'}</span>
    			    <input type="text" style="margin-left: 20px;" name="reply_email" value="{$comment_info.email}" placeholder="电子邮箱" />
    			</div>
			</div>
			<input type="hidden" name="comment_id" value="{$comment_info.comment_id}" />
			{if $comment_info.status neq '3'}
				<div class="control-group control-group-small">
					<button class="btn btn-gebo" type="submit">回复</button>
				</div>
			{/if}
		</div>
		
		<div class="right-bar move-mod">
			<div class="foldable-list move-mod-group edit-page" id="goods_info_sort_brand">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_brand">
							<strong>{'店铺信息'}</strong>
						</a>
					</div>
					<div class="accordion-body in in_visable collapse" id="goods_info_area_brand">
						<div class="accordion-inner">
						    <div class="comment-thumb">
        						{if $shop_info.logo}
        		                	<img src="{$shop_info.logo_img}" >
        		                {else}
        		                	<img src="{$shop_info.no_logo}">
        		                {/if}
        					</div>
        					<div class="comment-store-info">
        						{$shop_info.name}
        					</div>
        					<div class="comment-goods" style="font-size: 17px;">
        					   <div class="goods_type">
    					  	       <label class="control-label store-attr">综合评分：</label>
    					  	       <span class="store-grade">
    					  	       	{section name=loop loop=$shop_info.composite}<i class="fontello-icon-star" style="color:#FF9933;"></i>{/section}
    					  	       	{section name=loop loop=5-$shop_info.composite}<i class="fontello-icon-star" style="color:#bbb;"></i>{/section}
    					  	       </span>
        					   </div>
        					   <div class="goods_type">
        					       <label class="control-label store-attr">全部评论： </label>
        					       <span class="store-grade all-comment">{$shop_info.amount}</span>
        					   </div>
        					   <div class="goods_type">
        					       <label class="control-label store-attr">好评率： </label>
        					       <span class="store-grade">{$shop_info.comment_percent}%</span>
        					   </div>
        					</div>
        					{if $comment_info.store_id neq 0}
						          <a class="data-pjax btn btn-gebo" href="{$store_url}" class="btn btn-gebo" type="submit">{'进入店铺评价'}</a>
						    {/if}
						</div>
					</div>
				</div>
			</div>

			<div class="foldable-list move-mod-group" id="goods_info_sort_tvimg">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_tvimg">
							<strong>
							{'该商户其他待审核评价'}
						    <span class="badge badge-info">{$nochecked}</span>
							</strong>
						</a>
					</div>
					<div class="accordion-body in collapse reply_admin_list" id="goods_info_area_tvimg">
						<div class="accordion-inner">
						      <!-- {foreach from=$other_comment item=list} -->
    						          <div class="formSep">
                    		          <p>{$list.user_name}
                    		              <span style="float: right">
                    		                  <a href='{url path="comment/admin/reply" args="comment_id={$list.comment_id}"}'>查看及回复</a>
                    		              </span>
                    		          </p>
                    		          <p>{$list.content}</p>
                    		          <p class="text-right">{section name=loop loop=$list.comment_rank}<i class="fontello-icon-star" style="color:#FF9933;"></i>{/section}{section name=loop loop=5-$list.comment_rank}<i class="fontello-icon-star" style="color:#bbb;"></i>{/section}
                    		          </p>
                    		          </div>
            		          <!-- {foreachelse} -->
                		          <div class="text-center">
                		          		暂无其他相关评论
                		          </div>
                	          <!-- {/foreach} -->
                	          {if $other_comment|@count neq 0}
                	           	  <p class="text-right"><a href='{$store_url}'>查看更多</a></p>
                			  {/if} 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- {/block} -->