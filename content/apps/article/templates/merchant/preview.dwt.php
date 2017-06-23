<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<h2 class="pull-left">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	</h2>
	<div class="pull-right">
	   {if $action_link}
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i><i class="fontello-icon-reply"></i> {$action_link.text}</a>
		{/if}
		{if $action_linkedit}
		<a class="btn btn-primary data-pjax" href="{$action_linkedit.href}" id="sticky_a"><i class="fa fa-edit"></i><i class="fontello-icon-edit"></i> {$action_linkedit.text}</a>
		{/if}
	</div>
	<div class="clearfix">
	</div>
</div>
<div class="row-fluid edit-page">
	<div class="span12 panel">
		<div class="tabbable panel-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<h3 class="text-center">{$article.title}</h3>
					<p class="text-center">
						{lang key='article::article.label_author'}
						{if $article.author}
							{$article.author}
						{else}
							{lang key='article::article.not_available'}
						{/if}
						&nbsp;&nbsp;
						{lang key='article::article.label_add_time'}{$article.add_time}
					</p>
					{$article.content}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->