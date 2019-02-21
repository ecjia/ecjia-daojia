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
					<label class="control-label">{t domain="user"}会员等级：{/t}</label>
					<div class="controls">
						<input type="text" name="rank_name" value="{$rank.rank_name}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="user"}成长值下限：{/t}</label>
					<div class="controls">
						<input type="text" name="min_points" value="{$rank.min_points}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="user"}成长值上限：{/t}</label>
					<div class="controls">
						<input type="text" name="max_points" value="{$rank.max_points}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				<!-- 在商品详情页显示该会员等级的商品价格 -->
				<div class="control-group formSep">
					<label class="control-label">{t domain="user"}初始折扣率：{/t}</label>
					<div class="controls">
						<input type="text" name="discount" value="{$rank.discount}"/>
						<span class="input-must">*</span>
						<span class="help-block">{t domain="user"}请填写为0-100的整数，如填入80，表示初始折扣率为8折{/t}</span>
					</div>
					<div class="controls chk_radio">
						<input type="checkbox" name="show_price" value="1" {if $rank.show_price eq 1} checked="true"{/if} /><span>{t domain="user"}在商品详情页显示该会员等级的商品价格{/t}</span>
					</div>
					<div class="controls chk_radio">
						<input type="checkbox" name="special_rank" value="1" {if $rank.special_rank eq 1} checked="true"{/if} /><span>{t domain="user"}特殊会员组{/t}</span>
						<span class="help-block">{t domain="user"}特殊会员组的会员不会随着积分的变化而变化。{/t}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
					{if $rank.rank_id}
						<input type="submit" class="btn btn-gebo" value='{t domain="user"}更新{/t}' />
						<input type="hidden" name="id" value="{$rank.rank_id}" />
						<input type="hidden" name="old_name" value="{$rank.rank_name}" />
						<input type="hidden" name="old_min" value="{$rank.min_points}" />
						<input type="hidden" name="old_max" value="{$rank.max_points}" />
					{else}
						<input type="submit" class="btn btn-gebo" value='{t domain="user"}确定{/t}' />
					{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->