<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

{if !array_get($_SESSION, 'staff_id')}
<!-- {block name="meta"} -->
<title>
{$shop_info.title} - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
{$shop_info.title} - {ecjia::config('shop_name')}
<!-- {/block} -->
{/if}    

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        </h2>
    </div>
</div>

<div class="row faq">
	<div class="col-lg-12">
		<div class="panel-body min_h335">
			<div class="col-lg-4">
				<ul class="nav nav-pills nav-stacked w300">
					<!-- {foreach from=$info_list item=val} -->
                   		<li {if $val.article_id eq $id}class="active"{/if}>
                   			<a class="data-pjax" style="border-radius:4px;" href='{url path="merchant/merchant/shopinfo" args="id={$val.article_id}"}'>
                   				{$val.file_url} {$val.title}
                   			</a>
                   		</li>
       				<!-- {/foreach} -->
				</ul>
			</div>
			<div class="col-lg-8">
				<div class="panel panel-group" id="accordion">
					<div class="panel panel-default">
         				<div class="panel-heading">
                   			<h4 class="panel-title">{$shop_info.title}</h4>
                  		</div>
	           			<div id="{$shop_info.article_id}" class="panel-collapse collapse in">
							<div class="panel-body">
								{$shop_info.content}
							</div>
						</div>
     				</div>
   				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->