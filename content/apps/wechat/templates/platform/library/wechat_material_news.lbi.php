<!--图文信息  -->
<div class="row-fluid goods-photo-list">
    <!-- {if $lists.item} -->
    <div class="wmk_grid ecj-wookmark wookmark_list material_pictures">
        <ul class="wookmark-goods-photo move-mod nomove wookmark-news">

            <div class="weui-desktop-media__list-col">
            <!-- {foreach from=$lists.item item=articles key=k} -->
                {if ($k+4) % 4 == 0}
                <!-- {include file="library/wechat_material_news_child.lbi.php"} -->
                {/if}
            <!-- {/foreach} -->
            </div>

            <div class="weui-desktop-media__list-col">
            <!-- {foreach from=$lists.item item=articles key=k} -->
                {if ($k+3) % 4 == 0}
                <!-- {include file="library/wechat_material_news_child.lbi.php"} -->
                {/if}
            <!-- {/foreach} -->
            </div>

            <div class="weui-desktop-media__list-col">
            <!-- {foreach from=$lists.item item=articles key=k} -->
                {if ($k+2) % 4 == 0}
                <!-- {include file="library/wechat_material_news_child.lbi.php"} -->
                {/if}
            <!-- {/foreach} -->
            </div>

            <div class="weui-desktop-media__list-col">
            <!-- {foreach from=$lists.item item=articles key=k} -->
                {if ($k+1) % 4 == 0}
                <!-- {include file="library/wechat_material_news_child.lbi.php"} -->
                {/if}
            <!-- {/foreach} -->
            </div>

        </ul>
    </div>
    <!-- {else} -->
    <table class="table table-striped">
        <tr>
            <td class="no-records" colspan="10" style="border-top:0px;line-height:100px;">{t domain="wechat"}没有找到任何记录{/t}</td>
        </tr>
    </table>
    <!-- {/if} -->
</div>
<!-- {$lists.page} -->