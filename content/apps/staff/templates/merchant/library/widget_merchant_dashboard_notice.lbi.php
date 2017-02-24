<section class="panel">
    <div class="task-thumb-details">
        <h1>公告通知</h1>
    </div>
    <table class="table">
        <tbody>
        	<!-- {foreach from=$list item=val} -->
        	<tr>
        		<td><a class="data-pjax" href='{url path="merchant/merchant/shop_notice" args="id={$val.article_id}"}'>{$val.title}</a></td>
        		<td class="w70">{$val.add_time}</td>
        	</tr>
        	<!-- {foreachelse} -->
        	<tr>
        	   <td class="no-records" colspan="1">暂无任何公告通知</td>
        	</tr>
        	<!-- {/foreach} -->
        </tbody>
    </table>
</section>
