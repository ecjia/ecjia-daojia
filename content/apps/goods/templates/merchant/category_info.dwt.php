<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.goods_category_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div>
    <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn btn-primary data-pjax pull-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}
        </a>
        {/if}
    </h2>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="form-horizontal cmxform" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data" data-edit-url="{RC_Uri::url('goods/mh_category/edit')}">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="control-label col-lg-2">{lang key='goods::category.label_cat_name'}</label>
                                <div class="controls col-lg-8">
                                    <input class="form-control" type='text' name='cat_name' maxlength="20" value='{$cat_info.cat_name|escape:html}' size='27'/>
                                </div>
                                <span class="input-must">{lang key='system::system.require_field'}</span>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">分类图片：</label>
                                <div class="controls col-lg-8">
                                    <div class="fileupload fileupload-{if $cat_info.cat_image}exists{else}new{/if}" data-provides="fileupload">
                                        {if $cat_info.cat_image}
                                        <div class="fileupload-{if $cat_info.cat_image}exists{else}new{/if} thumbnail" style="max-width: 300px;">
                                            <img src="{$cat_info.cat_image}" alt="分类图片" style="max-width: 300px;"/>
                                        </div>
                                        {/if}
                                        <div class="fileupload-preview fileupload-{if $cat_info.cat_image}new{else}exists{/if} thumbnail" style="max-width: 300px;max-height: 60px;line-height: 10px;"></div>
                                        {if $cat_info.cat_image}<div class="m_t10"></div>{/if}
                                        <span class="btn btn-primary btn-file btn-sm">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                            <span class="fileupload-exists"> 修改</span>
                                            <input type="file" class="default" name="cat_image"/>
                                        </span>
                                        <a class="btn btn-danger btn-sm fileupload-exists" {if $cat_info.cat_image}data-toggle="ajaxremove" data-msg="您确定要删除该分类图片吗？" {else}data-dismiss="fileupload" {/if} href="{url path='goods/mh_category/drop_cat_image' args="cat_id={$cat_info.cat_id}"}" >删除</a>
                                    </div>
                                    <span class="help-block">推荐图片的尺寸为：顶级分类为3:1（900x300px），子集分类为1:1（200x200px）</span>
                                </div>
                                <span class="input-must">{lang key='system::system.require_field'}</span>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">{lang key='goods::category.label_parent_cat'}</label>
                                <div class="col-lg-8">
                                    <select class="form-control m-bot15" name="parent_id">
                                        <option value="0">{lang key='goods::category.cat_top'}</option>
                                        <!-- {$cat_select} -->
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">{lang key='goods::category.label_sort_order'}</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name='sort_order' {if $cat_info.sort_order}value='{$cat_info.sort_order}' {else} value="50" {/if} size="15" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">{lang key='goods::category.label_is_show'}</label>
                                <div class="col-lg-8">
                                    <input type="radio" id="is_show_1" name="is_show" value="1" {if $cat_info.is_show neq 0}checked="checked" {/if} />
                                    <label for="is_show_1">{lang key='system::system.yes'}</label>

                                    <input type="radio" id="is_show_2" name="is_show" value="0" {if $cat_info.is_show eq 0}checked="checked" {/if} />
                                    <label for="is_show_2">{lang key='system::system.no'}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">{lang key='goods::category.label_cat_desc'}</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" name='cat_desc' rows="6" cols="48">{$cat_info.cat_desc}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-6">
                                    <!-- {if $cat_info.cat_id} -->
                                    <input type="hidden" name="old_cat_name" value="{$cat_info.cat_name}"/>
                                    <input type="hidden" name="cat_id" value="{$cat_info.cat_id}"/>
                                    <button class="btn btn-info" type="submit">{lang key='goods::category.update'}</button>
                                    <!-- {else} -->
                                    <button class="btn btn-info" type="submit">{lang key='system::system.button_submit'}</button>
                                    <!-- {/if} -->
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="panel-group">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" class="accordion-toggle">
                                            <span class="glyphicon"></span>
                                            <h4 class="panel-title">分类广告</h4>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div style="padding: 0 15px;">
                                                    <span>当前广告：</span>
                                                    {if $category_ad.position_id}
                                                        {$category_ad.position_name}
                                                        <a class="ecjiafc-red m_l10" data-toggle="ajaxremove"
                                                           data-msg="您确定要移除此分类广告么？"
                                                           href='{url path="goods/mh_category/remove_ad" args="cat_id={$cat_info.cat_id}"}'>移除</a>
                                                    {else}
                                                    未设置
                                                    {/if}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" name="keywords" value="" placeholder="请输入关键词进行搜索"/>
                                                </div>
                                                <a class="btn btn-primary ad_search" href="javascript:;" data-url="{RC_Uri::url('goods/mh_category/search_ad')}"><i class="fa fa-search"></i> 搜索 </a>
                                                <span class="help-block" style="padding-left: 15px;">请先搜索并选择一个广告位作为此分类广告<br>建议尺寸：宽284 高572</span>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <select name="category_ad" class="form-control ad_list">
                                                        <!-- {if $category_ad.position_id} -->
                                                        <option value="{$category_ad.position_id}">{$category_ad.position_name}</option>
                                                        <!-- {else} -->
                                                        <option value='-1'>请先搜索再选择</option>
                                                        <!-- {/if} -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->