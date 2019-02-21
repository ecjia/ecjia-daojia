<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.appeal.init();
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
<!-- #BeginLibraryItem "/library/appeal_step.lbi" --><!-- #EndLibraryItem -->
<!-- start add new category form -->
<form class="form-horizontal comment_info" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data" data-edit-url="">
	<div class="row-fluid">
		<div class="left-bar move-mod">
			<div class="foldable-list move-mod-group" id="goods_info_sort_seo">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_seo">
							<strong>{t domain="comment"}评价内容{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="goods_info_area_seo">
						<div class="accordion-inner" style="padding-top:1em;padding-bottom:1em;">
						      <div class="panel-body">
                                    <div class="text-right-commentinfo">
                                        <div class="comment-users-img">
									       <img src="{$avatar_img}" style="width:60px;height:60px;border-radius:100%;">
								        </div>
        					  			 <div class="comment-userinfo">
        									<div>
        										<div>{if $comment_info.is_anonymous eq 0}{t domain="comment"}匿名发表{/t}{else}{$comment_info.user_name}{/if}</div>
        										<div class="comment-time"><span class="commen-ip">{$comment_info.add_time}</span>{t domain="comment"}IP：{/t}{$comment_info.ip_address}</div>
        									</div>
        								 </div>
                                    </div>
                                    <div>
                                        {t domain="comment"}商品相符：{/t}{section name=loop loop=$comment_info.comment_rank}<i class="fontello-icon-star" style="color:#FF9933;"></i>{/section}
                                    		   {section name=loop loop=5-$comment_info.comment_rank}<i class="fontello-icon-star" style="color:#bbb;"></i>{/section}
                                    </div>
                                    <div class="comment-content-info">{$comment_info.content}</div>
									{if $comment_imgs_list}
											<!-- {foreach from=$comment_imgs_list item=img_list} -->
													<img style="margin-right:8px;margin-top:10px;margin-bottom:8px;height:75px;width:75px;" alt="" src="{$img_list.file_path}">
											<!-- {/foreach} -->
									{/if}
									{if $comment_info.status neq 3}
									<div class="commentinfo-can-btn">
										<a class="data-pjax btn toggle_view" href='{url path="comment/admin/check" args="list=4&comment_id={$appeal_info.comment_id}&id={$appeal_info.id}"}' data-msg='{t domain="comment" 1="{$comment_info.user_name}"}您确定要将该用户[%1]的评论移至回收站吗？{/t}' data-val="trashed_comment"  type="button">{t domain="comment"}删除至回收站{/t}</a>
									</div>
									{/if}
                             </div>
						</div>
					</div>
				</div>
			</div>
			<div class="control-group">
			    <div class="reply-title">{t domain="comment"}申诉内容：{/t} </div>
			    <div class="appeal-content-style">
			    	<div class="appeal-content-padding">
					    <div class="appeal-content-info">{$appeal_info.appeal_content}</div>
					    <!-- {if $appeal_imgs_list}-->
								<!-- {foreach from=$appeal_imgs_list item=list} -->
										<img style="margin-right:8px;margin-top:10px;margin-bottom:6px;height:75px;width:75px;" alt="" src="{$list.file_path}">
								<!-- {/foreach} -->
						<!-- {/if}-->
						<div style="margin-bottom:8px;">{$appeal_info.appeal_time}</div>
					</div>
				</div>
			</div>
			<!-- {if $check_comment }-->
				<div>
					<!-- {if $appeal_info.check_status eq 1 }--> 
	    			<textarea class="span12 form-control ckeck_remark" name="ckeck_remark" rows="6" cols="48" placeholder='{t domain="comment"}请输入内容{/t}'></textarea>
	    			<!-- {/if}-->
	    			<!--{if $appeal_info.check_status eq 1} -->
						<div class="control-group control-group-small button-style">
							<button class="btn btn-gebo ckeck-comment-appeal" data-url="{url path='comment/appeal/check_appeal'}" data-status="{2}" type="button">{t domain="comment"}通过{/t}</button>&nbsp;&nbsp;
							<button class="btn ckeck-comment-appeal" data-url="{url path='comment/appeal/check_appeal'}" data-status="{3}" type="button">{t domain="comment"}驳回{/t}</button>
						</div>
					<!--{/if} -->
				</div>
			<!--{/if} -->
			<input type="hidden" name="comment_id" value="{$appeal_info.comment_id}"/>
			<input type="hidden" name="appeal_id" value="{$appeal_info.id}"/>
			<input type="hidden" name="ckeck_stauts" value="{$appeal_info.ckeck_stauts}"/>
			<!--{if $appeal_info.check_status eq 2 OR $appeal_info.check_status eq 3} -->
				<div class="control-group">
					<div class="reply-title">{t domain="comment"}申诉回复：{/t} </div>
				</div>
				<div class="appeal-check-reply-info" >
					<div class="admin-remark">
						<div>{$appeal_info.check_remark}</div>
						<div class="process-time-style">{$appeal_info.process_time}</div>
					</div>
				</div>
			<!--{/if} -->
		</div>
	</div>
</form>
<!-- {/block} -->