<section class="panel">
    <div class="panel-body">
		<header class="panel-title">
			快捷入口
		</header>
    </div>
    <div class="panel-body" style="padding-top:0;">
    	<div class="panel-body-fastenter">
    		<!-- {foreach from=$list item=val} -->
    		<div class="fastenter-item">
    			<a href="{$val.url}">
	    			<img src="{$val.img}" />{$val.title}
    			</a>
    		</div>
    		<!-- {/foreach} -->
    	</div>
    </div>
</section>