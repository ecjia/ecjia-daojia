<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.article_cat_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" method="post" action="{$form_action}" name="theCatInfoForm">
			<fieldset>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='article::article.cat_name'}：</label>
					<div class="controls">
						<input type="text" name="cat_name" maxlength="60" size="30" value="{$cat.cat_name|escape}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='article::article.parent_cat'}</label>
					<div class="controls">
						<select name="parent_id"  {if $disabled }disabled="disabled"{/if} >
							<option value="0">{lang key='article::article.cat_top'}</option>
							<!-- {$cat_select} -->
						</select>
					</div>
				</div>	
				<div class="control-group formSep" >
					<label class="control-label">{lang key='system::system.sort_order'}：</label>
					<div class="controls">
						<input type="text" name='sort_order' {if $cat.sort_order}value='{$cat.sort_order}'{else} value="50"{/if} size="15" />
					</div>
				</div>
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#collapse001">
								<strong>{lang key='article::article.seo_optimization'}</strong>
							</a>
						</div>
						<div class="accordion-body collapse" id="collapse001">
							<div class="accordion-inner">
							<div class="control-group control-group-small" >
									<label class="control-label">{lang key='article::article.keywords'}</label>
									<div class="controls">
										<input class="span12" type="text" name="keywords" value="{$cat.keywords|escape}" size="40" />
										<br />
										<p class="help-block w280 m_t5">{lang key='article::article.split'}</p>
									</div>
								</div>
								<div class="control-group control-group-small" >
									<label class="control-label">{lang key='article::article.simple_description'}</label>
									<div class="controls">
										<textarea class="span12 h100" name="cat_desc" cols="40" rows="3">{$cat.cat_desc}</textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group" >
					<div class="controls">
						<!-- {if $cat.cat_id} -->
						<button class="btn btn-gebo" type="submit">{lang key='article::article.update'}</button>
						<input type="hidden" name="id" value="{$cat.cat_id}" />
						<!-- {else} -->
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<!-- {/if} -->
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->