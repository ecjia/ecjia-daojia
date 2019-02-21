<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_category_move.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="goods"}提示：{/t}</strong>{t domain="goods"}什么是转移商品分类？{/t}<br/>{t domain="goods"}在添加商品或者在商品管理中，如果需要对商品的分类进行变更，那么你可以通过此功能，正确管理你的商品分类。{/t}
</div>
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
			<fieldset>
				<div class="cat_move">
					<div class="control-group">
						<label class="control-label">
							{t domain="goods"}从此分类：{/t}
						</label>
						<div class="controls">
							<select name="cat_id">
								<option value="0">{t domain="goods"}请选择...{/t}</option>
								<!-- {$cat_select} -->
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							{t domain="goods"}转移到：{/t}
						</label>
						<div class="controls">
							<select name="target_cat_id">
								<option value="0">{t domain="goods"}请选择...{/t}</option>
								<!-- {$cat_select} -->
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-gebo" type="submit">{t domain="goods"}开始转移{/t}</button>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->