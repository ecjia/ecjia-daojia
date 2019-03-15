<div class="row-fluid goods-photo-list">
    <!-- {if $lists.item} -->
    <div class="span12">
        <div class="wmk_grid ecj-wookmark wookmark_list other_material">
            <ul class="wookmark-goods-photo move-mod nomove">
                <!-- {foreach from=$lists.item item=val} -->
                <li class="thumbnail move-mod-group">
                    <div class="attachment-preview">
                        <div class="ecj-thumbnail">
                            <div class="centered">
                                <a target="_blank" href="{$val.file}" title="{$val.title}">
                                    <img data-original="{$val.thumb}" src="{$val.thumb}" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <p>
                        <a href="javascript:;" title='{t domain="wechat"}取消{/t}' data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" title='{t domain="wechat"}保存{/t}' data-toggle="sort-ok" data-imgid="{$val.id}" data-saveurl="{url path='wechat/platform_material/edit_title'}" style="display:none;"><i class="fa fa-check"></i></a>
                        <a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该视频素材吗？{/t}' href='{url path="wechat/platform_material/video_remove" args="id={$val.id}"}' title='{t domain="wechat"}删除{/t}'><i class="ft-trash-2"></i></a>
                        <span class="edit_title f_l f_s15">{if $val.title}{$val.title}{else}{t domain="wechat"}无标题{/t}{/if}</span>
                    </p>
                </li>
                <!-- {/foreach} -->
            </ul>
        </div>
        <!-- {$lists.page} -->
    </div>
    <!-- {else} -->
    <table class="table table-striped m_b0">
        <tr>
            <td class="no-records" colspan="10" style="border-top:0px;line-height:100px;">{t domain="wechat"}没有找到任何记录{/t}</td>
        </tr>
    </table>
    <!-- {/if} -->
</div>