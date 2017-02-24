<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_rank.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_rank.label_rank_name'}</label>
					<div class="controls">
						<input type="text" name="rank_name" value="{$rank.rank_name}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_rank.label_integral_min'}</label>
					<div class="controls">
						<input type="text" name="min_points" value="{$rank.min_points}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_rank.label_integral_max'}</label>
					<div class="controls">
						<input type="text" name="max_points" value="{$rank.max_points}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- 在商品详情页显示该会员等级的商品价格 -->
				<div class="control-group formSep">
					<label class="control-label">{lang key='user::user_rank.label_discount'}</label>
					<div class="controls">
						<input type="text" name="discount" value="{$rank.discount}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<span class="help-block">{lang key='user::user_rank.notice_discount'}</span>
					</div>
					<div class="controls chk_radio">
						<input type="checkbox"  name="show_price" value="1" {if $rank.show_price eq 1} checked="true"{/if} /><span>{lang key='user::user_rank.show_price'}</span>
					</div>
					<div class="controls chk_radio">
						<input type="checkbox"   name="special_rank" value="1" {if $rank.special_rank eq 1} checked="true"{/if} /><span>{lang key='user::user_rank.special_rank'}</span>
						<span class="help-block">{lang key='user::user_rank.notice_special'}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
					{if $rank.rank_id}
						<input type="submit" class="btn btn-gebo" value="{lang key='user::user_rank.submit_update'}" />
						<input type="hidden" name="id" value="{$rank.rank_id}" />
						<input type="hidden" name="old_name" value="{$rank.rank_name}" />
						<input type="hidden" name="old_min" value="{$rank.min_points}" />
						<input type="hidden" name="old_max" value="{$rank.max_points}" />
					{else}
						<input type="submit" class="btn btn-gebo" value="{lang key='system::system.button_submit'}" />
					{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->