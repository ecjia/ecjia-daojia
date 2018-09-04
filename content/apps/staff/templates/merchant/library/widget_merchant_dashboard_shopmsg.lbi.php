<section class="panel">
    <div class="panel-body">
		<header class="panel-title">
			商城消息
			<span class="pull-right">
				<a target="__blank" href="{RC_Uri::url('notification/mh_notification/init')}">查看更多 >></a>
			</span>
		</header>
    </div>
    	<!-- {foreach from=$list item=val} -->
	    <div class="panel-body" style="padding: 10px 15px;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
	   		<i class="fa fa-comment"></i>
	  		<span class="text-content">{$val.content}</span>
		</div>
		<!-- {/foreach} -->
</section>