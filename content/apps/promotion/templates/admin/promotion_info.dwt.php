<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.promotion_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='promotion::promotion.label_goods_keywords'}</label>
					<div class="controls">
						<input type="text" name="keywords" />
						<input type="hidden" name="goods_id" value="{$promotion_info.goods_id}">
						<input type="button" value="{lang key='promotion::promotion.search'}" class="btn searchGoods" data-url='{url path="promotion/admin/search_goods"}'>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='promotion::promotion.lable_goods'}</label>
					<div class="controls">
						<select name="goods_id" class='goods_list'>
							<!-- {if !$promotion_info.goods_name} -->
								<option value='-1'>{lang key='promotion::promotion.pls_select'}</option>
							<!-- {else} -->
								<option value="{$promotion_info.goods_id}">{$promotion_info.goods_name}</option>
							<!-- {/if} -->
						</select>
						<span class="help-block">{lang key='promotion::promotion.select_goods_notice'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='promotion::promotion.label_start_time'}</label>
					<div class="controls">
						<input name="start_time" class="date" type="text" placeholder="{lang key='promotion::promotion.select_start_time'}" value="{$promotion_info.promote_start_date}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='promotion::promotion.label_end_time'}</label>
					<div class="controls">
						<input name="end_time" class="date" type="text" placeholder="{lang key='promotion::promotion.select_end_time'}" value="{$promotion_info.promote_end_date}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='promotion::promotion.label_price'}</label>
					<div class="controls">
						<input name="price" type="text" value="{$promotion_info.promote_price}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<!-- {if $promotion_info.goods_id} -->
							<input type="submit" value="{lang key='promotion::promotion.update'}" class="btn btn-gebo" />
							<input type="hidden" name='old_goods_id' value="{$promotion_info.goods_id}">
						<!-- {else} -->
							<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
						<!-- {/if} -->
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<!-- {/block} -->