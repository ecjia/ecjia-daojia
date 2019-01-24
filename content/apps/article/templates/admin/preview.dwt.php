<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
		{if $action_linkedit}
		<a class="btn plus_or_reply data-pjax" href="{$action_linkedit.href}" id="sticky_a" ><i class="fontello-icon-edit"></i>{$action_linkedit.text}</a>
		{/if}
	</h3>	
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<h3 class="text-center">{$article.title}</h3>
					<p  class="text-center">{t domain="article"}文章作者：{/t}{$article.author}&nbsp;&nbsp;{t domain="article"}添加日期：{/t}{$article.add_time}</p>
					{if $article.article_type == 'related'}
						<p>
						{$article.content}
						<a href="{RC_Upload::upload_url()}/{$article.file_url}">{t domain="article"}相关下载{/t}</a>
						</p>
					{elseif $article.article_type == 'download'}
						<a href="{RC_Upload::upload_url()}/{$article.file_url}">{t domain="article"}相关下载{/t}</a>
					{else}
						{if $article.file_url != ''}
							<img  class="thumbnail" src="{RC_Upload::upload_url()}/{$article.file_url}" style="max-width:800px; margin:0 auto">
						{/if}
						{$article.content}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->