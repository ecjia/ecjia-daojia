<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<!-- 面包导航 -->
<div id="jCrumbs" class="breadCrumb module">
	<ul>
		<li><a href="index.php?m=admincp"><i class="icon-home"></i></a></li>
		<!-- {if $ur_here} -->
		<li>{$ur_here}</li>
		<!-- {/if} -->
	</ul>
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div>
	<div class="tab-pane">
		<div class="control-group formSep">
			<div >
				{ecjia:editor content=$article.content textarea_name='content'}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->