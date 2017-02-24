<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_user.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<!-- 按用户等级发放红包 -->	
		<div class="row-fluid ">
			<div class="choose_list span12">
				<form class="form-horizontal " action="{$form_action}" method="post" name="userRankForm"  >
					<div class="control-group">
						<span><strong>{lang key='bonus::bonus.senduserrank'}</strong></span>
					</div>
					<div class="control-group">
						<label><span>{lang key='bonus::bonus.user_rank'}</span></label>
						<div>
							<select name="rank_id">
								<option value="">{lang key='bonus::bonus.select_rank'}</option>
								<!-- {html_options options=$ranklist selected=$smarty.get.rank_id} -->
							</select>
						</div>
					</div>
					<div class="control-group">
						<label>
							<span class="p_t3"><input type="checkbox" name="validated_email" value="1"></span>
							<span>{lang key='bonus::bonus.validated_email'}</span>
						</label>
					</div>
					<div class="control-group formSep m_b5">
						<label><button class="btn btn-gebo" type="submit">{lang key='bonus::bonus.confirm_send_bonus'}</button></label>
					</div>
					<input type="hidden" name="act" value="send_by_user" />
					<input type="hidden" name="id" value="{$id}" />
				</form>
			</div>
		</div>
			
		<form class="form-horizontal" action='{$form_user_action}' method="post" name="theForm">
			<div class="tab-content">
				<fieldset>
					<div class="control-group"><strong>{lang key='bonus::bonus.sendtouser'}</strong></div>
					<div class="control-group choose_list" id="search_user"  data-url="{url path='bonus/admin/search_users'}">
						<input type="text" name="keyword" placeholder="{lang key='bonus::bonus.enter_user_keywords'}" />
						<a class="btn" data-toggle="searchuser"><!-- {lang key='system::system.button_search'} --></a><br>
						<span class="help-block m_t5">{lang key='bonus::bonus.search_user_help'}</span>
					</div>
					<div class="control-group draggable">
						<div class="ms-container " id="ms-custom-navigation">
							<div class="ms-selectable">
								<div class="search-header">
									<input class="span12" id="ms-search" type="text" placeholder="{lang key='bonus::bonus.filter_user_info'}" autocomplete="off">
								</div>
								<ul class="ms-list nav-list-ready">
									<li class="ms-elem-selectable disabled"><span>{lang key='bonus::bonus.no_info'}</span></li>
								</ul>
							</div>
							<div class="ms-selection">
								<div class="custom-header custom-header-align">{lang key='bonus::bonus.send_to_user'}</div>
								<ul class="ms-list nav-list-content">
								</ul>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
			<p class="ecjiaf-tac">
				<button class="btn btn-gebo" type="submit">{lang key='bonus::bonus.confirm_send_bonus'}</button>
				<input type="hidden" id="bonus_type_id" value="{$id}" />
			<p>
		</form>
	</div>
</div>
<!-- {/block} -->