<!-- {if !$list} -->
	<div class="empty_material">暂无素材</div>
<!-- {else} -->
	<!-- {if $type eq 'news'} -->
	<div class="row-fluid goods-photo-list">
	    <div class="wmk_grid ecj-wookmark wookmark_list material_pictures">
	        <ul class="wookmark-goods-photo move-mod nomove wookmark-news">
	            <div class="weui-desktop-media__list-col">
	            <!-- {foreach from=$list item=articles key=k} -->
	                {if ($k+4) % 4 == 0}
	                <!-- {include file="library/wechat_choose_material_newchild_list.lbi.php"} -->
	                {/if}
	            <!-- {/foreach} -->
	            </div>

	            <div class="weui-desktop-media__list-col">
	            <!-- {foreach from=$list item=articles key=k} -->
	                {if ($k+3) % 4 == 0}
	                <!-- {include file="library/wechat_choose_material_newchild_list.lbi.php"} -->
	                {/if}
	            <!-- {/foreach} -->
	            </div>

	            <div class="weui-desktop-media__list-col">
	            <!-- {foreach from=$list item=articles key=k} -->
	                {if ($k+2) % 4 == 0}
	                <!-- {include file="library/wechat_choose_material_newchild_list.lbi.php"} -->
	                {/if}
	            <!-- {/foreach} -->
	            </div>

	            <div class="weui-desktop-media__list-col">
	            <!-- {foreach from=$list item=articles key=k} -->
	                {if ($k+1) % 4 == 0}
	                <!-- {include file="library/wechat_choose_material_newchild_list.lbi.php"} -->
	                {/if}
	            <!-- {/foreach} -->
	            </div>
	        </ul>
	    </div>
	</div>
	<!-- {else} -->
		<!-- {foreach from=$list item=val} -->
		<li class="img_item">
			<label class="img_item_bd">
				<div class="pic_box"><img class="pic" src="{if $val.type eq 'voice' || $val.type eq 'video'}{$val.thumb}{else}{$val.file}{/if}" data-media="{$val.media_id}" data-id="{$val.id}"/></div>
				<span class="lbl_content">{$val.file_name}</span>
				<div class="selected_mask">
		            <div class="selected_mask_inner"></div>
		            <div class="selected_mask_icon"></div>
		        </div>
			</label>
		</li>
		<!-- {/foreach} -->
	<!-- {/if} -->
<!-- {/if} -->
