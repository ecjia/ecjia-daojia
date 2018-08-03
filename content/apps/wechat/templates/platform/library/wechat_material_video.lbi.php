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
                                <a target="__blank" href="{$val.file}" title="{$val.title}">
                                    <img data-original="{$val.thumb}" src="{$val.thumb}" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <p>
                        <a href="javascript:;" title="{lang key='wechat::wechat.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" title="{lang key='wechat::wechat.save'}" data-toggle="sort-ok" data-imgid="{$val.id}" data-saveurl="{url path='wechat/platform_material/edit_title'}" style="display:none;"><i class="fa fa-check"></i></a>
                        <a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_video_material'}" href='{url path="wechat/platform_material/video_remove" args="id={$val.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
                        <span class="edit_title f_l f_s15">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</span>
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
            <td class="no-records" colspan="10" style="border-top:0px;line-height:100px;">{lang key='wechat::wechat.unfind_any_recode'}</td>
        </tr>
    </table>
    <!-- {/if} -->
</div>
