<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="meta"} -->
<title>
{$article.title} - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
{$article.title} - {ecjia::config('shop_name')}
<!-- {/block} -->

<!-- {block name="common_header"} -->
<!-- #BeginLibraryItem "/library/franchisee_nologin_header.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row faq">
	<div class="col-lg-12">
		<div class="panel-body min_h335">
				<div class="panel panel-group" id="accordion">
					<div class="panel panel-default">
         				<div class="panel-heading">
                   			<h4 class="panel-title">{$article.title}</h4>
                  		</div>
	           			<div id="{$shop_info.article_id}" class="panel-collapse collapse in">
							<div class="panel-body">
								{$article.content}
							</div>
						</div>
     				</div>
   				</div>
		</div>
	</div>
</div>

{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}
<!-- {/block} -->
