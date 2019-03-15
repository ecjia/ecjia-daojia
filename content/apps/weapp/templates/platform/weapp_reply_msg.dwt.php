<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.platform.response.init();
    ecjia.platform.choose_material.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

{if $errormsg}
<div class="alert alert-danger">
    <strong>{t domain="weapp"}温馨提示：{/t}</strong>{$errormsg}
</div>
{/if}

<div class="alert alert-light alert-dismissible mb-2" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="alert-heading mb-2">{t domain="weapp"}操作提示{/t}</h4>
    <p>{t domain="weapp"}自动回复的类型 共分三种：消息自动回复、关键词自动回复、打开客服回复。回复内容可以设置为文字，图片。文本消息回复内容可以直接填写，长度限制1024字节（大约200字，含标点以及其他特殊字符），其他素材需要先在素材管理中添加。{/t}</p>
    <p>{t domain="weapp"}二、消息自动回复：当用户输入任意消息，匹配不到系统已有关键词时或者没有在关键词自动回复里添加关键词，默认回复一条消息提示。例如：对不起！你输入的关键词不存在，建议你咨询相关客服。你也可以输入help，查看使用帮助。{/t}</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link data-pjax active" href='{url path="weapp/platform_response/reply_msg"}'>{t domain="weapp"}消息自动回复{/t}</a>
                    </li>
                </ul>

                <form class="form" method="post" name="theForm" action="{$form_action}">
                    <div class="m_t10">
                        <div class="form-body">
                            <div class="form-group row">
                                <div class="col-lg-12 controls material-table">
                                    <ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
                                        <li class="nav-item" data-type="text">
                                            <a class="nav-link {if $subscribe.reply_type eq 'text'}active{/if}" data-toggle="tab" title='{t domain="weapp"}文本{/t}'><i class="fa fa-pencil"> {t domain="weapp"}文字{/t}</i></a>
                                        </li>
                                        <li class="nav-item" data-type="image">
                                            <a class="nav-link {if $subscribe.reply_type eq 'image'}active{/if}" data-toggle="tab" title='{t domain="weapp"}图片{/t}'><i class="fa fa-file-image-o"> {t domain="weapp"}图片{/t}</i></a>
                                        </li>
                                    </ul>
                                    <div class="text m_b10">
                                        <textarea class="m_t10 span12 form-control {if $subscribe.reply_type neq 'text'}hide{/if}" name="content" cols="40" rows="5" id="chat_editor">{$subscribe.content}</textarea>
                                        <div class="js_appmsgArea" {if $subscribe.reply_type neq 'text'}style="display: block;"{/if}>
                                            <div class="tab_cont_cover create-type__list" {if $subscribe.id}style="display: none;" {/if}>
                                                <div class="create-type__item">
                                                    <a href="javascript:;" class="create-type__link choose_material" data-type="{$subscribe.reply_type}" data-url="{RC_Uri::url('weapp/platform_material/choose_material')}&material=1">
                                                        <i class="create-type__icon file"></i>
                                                        <strong class="create-type__title">{t domain="weapp"}从素材库选择{/t}</strong>
                                                    </a>
                                                </div>
                                            </div>

                                            {if $subscribe.reply_type neq 'text'}
                                                {if $subscribe.reply_type neq 'news'}
                                                <div class="img_preview">
                                                    <img class="preview_img margin_10" src="{$subscribe.media.file}" alt="">
                                                    <input type="hidden" name="media_id" value="{$subscribe.media_id}">
                                                    <a href="javascript:;" class="jsmsgSenderDelBt link_dele">{t domain="weapp"}删除{/t}</a>
                                                </div>
                                                {else}
                                                <div class="weui-desktop-media__list-col margin_10">
                                                    <li class="thumbnail move-mod-group big grid-item">
                                                        <div class="article">
                                                            <div class="cover">
                                                                <a target="_blank" href="javascript:;">
                                                                    <img src="{$subscribe.media.file}"/>
                                                                </a>
                                                                <span>{$subscribe.media.title}</span>
                                                            </div>
                                                        </div>
                                                        <div class="edit_mask appmsg_mask">
                                                            <i class="icon_card_selected">{t domain="weapp"}已选择{/t}</i>
                                                        </div>
                                                        {if $subscribe.child}
                                                        <!-- {foreach from=$subscribe.child key=key item=val} -->
                                                        <div class="article_list">
                                                            <div class="f_l">{if $val.title}{$val.title}{else}{t domain="weapp"}无标题{/t}{/if}</div>
                                                            <a target="_blank" href="javascript:;">
                                                                <img src="{$val.file}" class="pull-right"/>
                                                            </a>
                                                        </div>
                                                        <!-- {/foreach} -->
                                                        {/if}
                                                    </li>
                                                    <input type="hidden" name="media_id" value="{$subscribe.media_id}"/>
                                                </div>
                                                <a href="javascript:;" class="jsmsgSenderDelBt link_dele p_l0">{t domain="weapp"}删除{/t}</a>
                                                {/if}
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <input type="hidden" name="content_type" value="{if $subscribe['reply_type']}{$subscribe['reply_type']}{else}text{/if}">
                        <input type="hidden" name="id" value="{$subscribe.id}">
                        {if $errormsg}
                        <input type="submit" class="btn btn-outline-primary" disabled="disabled" value='{t domain="weapp"}确定{/t}'>
                        {else}
                        <input type="submit" class="btn btn-outline-primary" value='{t domain="weapp"}确定{/t}'>
                        {/if}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- {include file="./library/weapp_choose_material.lbi.php"} -->

<!-- {/block} -->