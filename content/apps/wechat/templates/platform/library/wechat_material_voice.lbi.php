<div class="row-fluid">
    <div class="span12">
        <div class="fileupload" data-type="voice" data-action="{$form_action}{if $smarty.get.material}&material=1{/if}"></div>
    </div>
</div>
<div class="row-fluid goods-photo-list{if !$lists.item} hide{/if}">
    <div class="span12">
        <div class="wmk_grid ecj-wookmark wookmark_list other_material">
            <ul class="wookmark-goods-photo move-mod nomove">
                <!-- {foreach from=$lists.item item=val} -->
                <li class="thumbnail move-mod-group">
                    <div class="attachment-preview">
                        <div class="ecj-thumbnail">
                            <div class="centered">
                                <a target="__blank" href="{$val.file}" title="{$val.file_name}">
                                    <img src="{$val.thumb}" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <p>
                        <a href="javascript:;" title="{lang key='wechat::wechat.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
                        <a href="javascript:;" title="{lang key='wechat::wechat.save'}" data-toggle="sort-ok" data-imgid="{$val.id}" data-saveurl="{url path='wechat/platform_material/edit_file_name' args='type=voice'}" style="display:none;"><i class="fa fa-check"></i></a>
                        <a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_voice_material'}" href='{url path="wechat/platform_material/voice_remove" args="id={$val.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
                        <a href="javascript:;" title="{lang key='wechat::wechat.edit'}" data-toggle="edit"><i class="ft-edit-2"></i></a>
                        <span class="edit_title">{if $val.file_name}{$val.file_name}{else}{lang key='wechat::wechat.no_title'}{/if}</span>
                    </p>
                </li>
                <!-- {/foreach} -->
            </ul>
        </div>
        <!-- {$lists.page} -->
    </div>
</div>
