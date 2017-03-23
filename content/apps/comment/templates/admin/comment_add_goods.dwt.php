<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.comment_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
			<div class="tab-content">
				<form class="form-horizontal" action='{url path="comment/admin/insert" args="type=1"}' method="post" name="goods_comment_form">
					<div class="row-fluid edit-page editpage-rightbar">
						<div class="left-bar move-mod">
							<div class="shop-rating formSep">
								<label class="control-label">{lang key='comment::comment_manage.comment_rank'}</label>
								<div class="controls chk_radio">
									<ul class="rating-level" id="stars1">
										<li><a class="one-star" data-value="1"></a></li>
										<li><a class="two-stars" data-value="2"></a></li>
										<li><a class="three-stars" data-value="3"></a></li>
										<li><a class="four-stars" data-value="4"></a></li>
										<li><a class="five-stars" data-value="5"></a></li>
									</ul>
									<span class="result" id="stars1-tips"></span>
									<input type="hidden" id="stars1-input" name="comment_rank" value="" size="2" />
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{lang key='comment::comment_manage.content'}</label>
								<div class="controls">
									<textarea class="span10 h180" name="content" ></textarea>
								</div>
							</div>
							
							<div class="controls">
								<input type="hidden" name="user_id" />
								<input type="hidden" name="user_name" />
								<input type="hidden" name="goods_id" />
								<input type="submit" value="{lang key='system::system.button_submit'}" name="one" class="btn btn-gebo" />
							</div>
						</div>
				
						<div class="right-bar move-mod">
							<div class="foldable-list move-mod-group" id="goods_info_sort_author">
								<div class="accordion-group">
									<div class="accordion-heading">
										<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_author">
											<strong>{lang key='comment::comment_manage.bind_goods_lable'}</strong>
										</a>
									</div>
									<div class="accordion-body in in_visable collapse" id="goods_info_area_author">
										<div class="accordion-inner">
											<div class="control-group-small" >
												<label class="control-label">{lang key='comment::comment_manage.binding_goods'}</label>
												<div class="controls l_h30">
													<span class="new_goodsinfo">{lang key='comment::comment_manage.search_goods_notice'}</span>
												</div>
											</div>
											<div class="control-group-small" >
												<input type="hidden" name="url_goods" value='{url path="comment/admin/get_goods_name"}' />
												<div class="m_b10">
													<input type="text" class="w140" name="keywords" value="" placeholder="{lang key='comment::comment_manage.enter_goods_name'}" />
													<button class="btn search_goods" type="button">{lang key='comment::comment_manage.search_goods'}</button>
												</div>
												<div class="ms-container" style="background: none">
													<div class="search-header">
														<input type="text" autocomplete="off" placeholder="{lang key='comment::comment_manage.filter_goods_info'}" id="ms-search-goods" class="span12">
													</div>
													<ul class="ms-list nav-list-ready-goods select_goods" id="serarch_goods_list" style="border: 1px solid #dadada; height: 150px; overflow-y: auto;">
														<li class="ms-elem-selectable kong">
															<span>{lang key='comment::comment_manage.no_content'}</span>
														</li>
													</ul>
												</div>
												<span class="help-block">{lang key='comment::comment_manage.bind_goods_info'}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="foldable-list move-mod-group">
								<div class="accordion-group">
									<div class="accordion-heading">
										<a class="accordion-toggle move-mod-head" data-toggle="collapse" data-target="#telescopic2"><strong>{lang key='comment::comment_manage.bind_user_lable'}</strong></a>
									</div>
									<div class="accordion-body collapse" id="telescopic2">
										<div class="accordion-inner">
											<div class="control-group-small" >
												<label class="control-label">{lang key='comment::comment_manage.binding_user'}</label>
												<div class="controls l_h30">
													<span class="new_userinfo">{lang key='comment::comment_manage.search_user_notice'}</span>
												</div>
											</div>	
											<div class="control-group-small">
												<input type="hidden" name="url" value='{url path="comment/admin/get_user_name"}' />
												<div class="m_b10">
													<input type="text" class="w140" name="keyword" value="" placeholder="{lang key='comment::comment_manage.enter_user_name'}" />
													<button class="btn search_users" type="button">{lang key='comment::comment_manage.search_user'}</button>
												</div>
												<div class="ms-container" style="background: none">
													<div class="search-header">
														<input type="text" autocomplete="off" placeholder="{lang key='comment::comment_manage.filter_user_name'}" id="ms-search" class="span12">
													</div>
													<ul class="ms-list nav-list-ready select_user" id="serarch_user_list" style="border: 1px solid #dadada; height: 150px; overflow-y: auto;">
														<li class="ms-elem-selectable kong">
															<span>{lang key='comment::comment_manage.no_content'}</span>
														</li>
													</ul>
												</div>
												<span class="help-block">{lang key='comment::comment_manage.bind_user_info'}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->