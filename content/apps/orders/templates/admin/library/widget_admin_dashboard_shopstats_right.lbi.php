<div class="move-mod-group" id="widget_admin_dashboard_express_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{t domain="orders"}配送调度统计{/t}</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}待派单（单）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("express/admin/init")}&type=wait_grab'>{if $data.express_count.wait_grab}{$data.express_count.wait_grab}{else}0{/if}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}待取货（单）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("express/admin/wait_pickup")}&type=wait_pickup'>{if $data.express_count.wait_pickup}{$data.express_count.wait_pickup}{else}0{/if}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}配送中（单）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("express/admin/wait_pickup")}&type=sending'>{if $data.express_count.sending}{$data.express_count.sending}{else}0{/if}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}总配送单（单）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("express/admin_history/init")}'>{if $data.express_count.count}{$data.express_count.count}{else}0{/if}</a></div>
		</div>
	</div>
</div>
<div class="move-mod-group" id="widget_admin_dashboard_promotion_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{t domain="orders"}促销活动{/t}</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}促销（个）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("promotion/admin/init")}'>{$data.promotion_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}优惠（个）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("favourable/admin/init")}'>{$data.favourable_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}团购（个）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("groupbuy/admin/init")}'>{$data.groupbuy_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}买单（个）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("quickpay/admin/init")}'>{$data.quickpay_count}</a></div>
		</div>
	</div>
</div>
<div class="move-mod-group" id="widget_admin_dashboard_article_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{t domain="orders"}文章统计情况{/t}</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}今日新增（篇）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("article/admin/init")}'>{$data.today_article_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}待审核文章（篇）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("article/admin/init")}&type=wait_check'>{$data.waitcheck_article_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}待审核评论（条）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("article/admin/article_comment_list")}&type=wait_check&publishby=total_comments'>{$data.waitcheck_comment_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}总文章数（篇）{/t}</div>
			<div class="num"><a target="_blank" href='{RC_Uri::url("article/admin/init")}'>{$data.article_count}</a></div>
		</div>
	</div>
</div>