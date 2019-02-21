<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.admin_template.library();
    ecjia.admin.admin_template.library_ace_setval({if $library_html}{$library_html}{else}'请先选择正确的库项目文件！'{/if});
    ecjia.admin.admin_template.library_ace_readonly({if !$is_writable}1{else}0{/if});
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- {if !$libraries} -->
<div class="staticalert alert alert-error ui_showmessage">
    {t domain="theme"}暂无库项目{/t}
</div>
<!-- {else} -->
<!-- {if !$is_writable} -->
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">×</a>
   {t domain="theme" 1={$library_dir}}抱歉，您的%1文件没有写入权限，请开启写入权限。或直接修改库项目文件并上传。{/t}
</div>
<!-- {/if} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
        <div class="pull-right list_choose{if !$full} hide{/if}">
            <select name="choose_librarys">
                <!-- {foreach from=$libraries item=val key=key} -->
                <option {if $val.choose} selected="selected"{/if} value="{url path='theme/admin_library/init' args="lib={$val.File}&full=1"}">{$val.File}{if $val.Name} - {$val.Name}{/if}</option>
                <!-- {/foreach} -->
            </select>
        </div>
    </h3>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="chat_box library-content">
            <div class="row-fluid">
                <div class="{if $full}span12{else}span9{/if} chat_content template_info">
                    <form class="template_form" action="{$form_action}" method="post">
                        <div class="chat_heading clearfix">
                            <div class="pull-right"><i class="ecjiaf-csp{if $full} fontello-icon-resize-small{else} fontello-icon-resize-full{/if} enlarge"></i></div>
                            <span class="title">{if $library_name}{$library_name}{else}{t domain="theme"}未选择库项目{/t}{/if}</span>
                        </div>

                        <div class="row-fluid">
                            <pre class="span12" id="editor"></pre>
                        </div>
                        <div class="submit">
                            <button class="btn btn-gebo ecjiaf-csp fontello-icon-floppy"{if $libraries} type="submit"{/if}{if !$is_writable} disabled="disabled"{/if}>{t domain="theme"}保存{/t}</button>
                            <input type="hidden" name="lib" value="{$lib}">
                            <textarea class="hide" name="html" id="libContent"></textarea>
                        </div>
                    </form>
                </div>
                <div class="span3 chat_sidebar{if $full} hide{/if}">
                    <div class="chat_heading clearfix">
                        {t domain="theme"}库项目{/t}
                    </div>
                    <div class="ms-selectable">
                        <div class="template_list" id="ms-custom-navigation">
                            <input class="span12" id="ms-search" type="text" placeholder='{t domain="theme"}筛选搜索到的商品信息{/t}' autocomplete="off">
                            <ul class="unstyled">
                                <!-- {foreach from=$libraries item=val key=key} -->
                                <li class="ms-elem-selectable"><a class="data-pjax{if $val.choose} choose{/if}" href="{url path='theme/admin_library/init' args="lib={$val.File}&full=0"}">{$val.File} <br /> {$val.Name}</a></li>
                                <!-- {/foreach} -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/if} -->
<!-- {/block} -->
