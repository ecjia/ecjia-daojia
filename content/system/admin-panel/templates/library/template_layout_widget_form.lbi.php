<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="widget ui-draggable" id="{$lib.id}">
	<div class="widget-top">
		<div class="widget-title-action">
			<a class="fontello-icon-down-open widget-action" href="javascript:;"></a>
			<a class="widget-control-edit hide-if-js hide" href="javascript:;" >

			</a>
		</div>
		<div class="widget-title">
			<h4>{$lib.name}<span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside hide">
		<form method="post" action="{$form_action}">
			<div class="widget-content">
				<label for="widget-{$lib.type}-{$key}-title">{t}标题：{/t}</label>
				<input class="widefat" type="text" value="{$lib.title}" name="widget-title" id="widget-{$lib.type}-{$key}-title" />
			</div>
			<input class="widget-sort" type="hidden" value="{$lib.sort_order}" name="widget-sort" />
			<input class="widget-id" type="hidden" value="{$lib.id}" name="widget-id" />
			<input class="widget-type" type="hidden" value="{$lib.type}" name="widget-type" />
			<input class="widget-library" type="hidden" value="{$lib.library}" name="widget-library" />
			<input class="widget-region" type="hidden" value="{$lib.region}" name="widget-region" />
			<input class="add_new" type="hidden" value="{$lib.add_new}" name="add_new" />

			<div class="widget-control-actions">
				<div class="f_l">
					<a class="widget-control-remove" data-url="{$remove_action}" href="#remove">{t}删除{/t}</a> |
					<a class="widget-control-close" href="#close">{t}关闭{/t}</a>
				</div>
				<div class="f_r">
					<input class="btn btn-mini btn-info widget-control-save right" id="widget-{$lib.id}-{$key}-savewidget" name="savewidget" type="submit" value="{t}保存{/t}" />
					<span class="spinner"></span>
				</div>
				<br class="clear">
			</div>
		</form>
	</div>
	<div class="widget-description hide">{$lib.desc}</div>
</div>