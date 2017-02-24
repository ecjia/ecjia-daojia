<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.store_log.range();
    ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>
<style media="screen">
    .theme-green .back-bar .pointer:after{
        left: 3px;
        top: 1px;
    }
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="tabbable tabs-left">

            <ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
            </ul>

            <div class="tab-content tab_merchants">
                <div class="tab-pane active " style="min-height:300px;">
                    <form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                        <fieldset>
                            <div class="control-group formSep">
                                <label class="control-label m_t10">店铺LOGO：</label>
                                <div class="controls m_t15 m_b20 p_l10">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
        							    {if $store_info.shop_logo neq ''}
        								<img class="w120 h120"  class="img-polaroid" src="{$store_info.shop_logo}"><br><br>
        								{/if}
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        								    {if $store_info.shop_logo neq ''}
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									{else}
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									{/if}
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='shop_logo' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							</div>
                                </div>
                            </div>
                            <div class="control-group formSep">
                                <label class="control-label m_t10">APP Banner图：</label>
                                <div class="controls m_t15 m_b20 p_l10">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
        							    {if $store_info.shop_banner_pic neq ''}
        								<img class="w120 h120"  class="img-polaroid" src="{$store_info.shop_banner_pic}"><br><br>
        								{/if}
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        								    {if $store_info.shop_banner_pic neq ''}
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									{else}
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									{/if}
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='shop_banner_pic' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							</div>
                                </div>
                            </div>
                            <div class="control-group formSep">
                                <label class="control-label m_t10">店铺导航背景图：</label>
                                <div class="controls m_t15 m_b20 p_l10">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
        							    {if $store_info.shop_nav_background neq ''}
        								<img class="w120 h120"  class="img-polaroid" src="{$store_info.shop_nav_background}"><br><br>
        								{/if}
        								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        								    {if $store_info.shop_nav_background neq ''}
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									{else}
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									{/if}
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='shop_nav_background' size="35" />
        								</span>
        								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
        							</div>
                                </div>
                            </div>

                            <div class="control-group formSep">
                                <label class="control-label m_t10">店铺营业时间：</label>
                                <div class="controls m_t15 m_b20 p_l10">
                                    <input class="range-slider" name="shop_trade_time" type="hidden" value="{$store_info.shop_time_value}" style="display: none;">
                                </div>
                                <span class="m_t30 controls help-block" style="margin-top:30px;">拖拽选取营业时间段</span>
                            </div>

                            <div class="control-group formSep">
                                <label class="control-label">客服电话：</label>
                                <div class="controls">
                                    <input class="span6" name="shop_kf_mobile" type="text" value="{$store_info.shop_kf_mobile}" />
                                </div>
                            </div>

                            <div class="control-group formSep">
                                <label class="control-label">店铺简介：</label>
                                <div class="controls">
                                    <textarea class="span6" name="shop_description" rows="4" cols="20">{$store_info.shop_description}</textarea>
                                </div>
                            </div>

                            <div class="control-group formSep">
                                <label class="control-label">店铺公告：</label>
                                <div class="controls">
                                    <textarea class="span6" name="shop_notice" rows="4" cols="20">{$store_info.shop_notice}</textarea>
                                </div>
                            </div>


                            <div class="control-group">
                                <div class="controls">
                                    <input type="hidden"  name="store_id" value="{$smarty.get.store_id}" />
                                    <button class="btn btn-gebo" type="submit">{lang key='store::store.sub_update'}</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->
