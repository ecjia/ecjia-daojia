<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.merchant_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
    <div class="pull-left">
        <h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
    </div>
    <div class="pull-right">
        {if $action_link}
        <a target="_blank" href="{$action_link.href}" class="btn btn-primary">{$action_link.text}</a>
        {/if}
    </div>
    <div class="clearfix"></div>
</div>
<div class="row">
    <div class="col-lg-12 merchant-template-content">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" data-toggle='from'>
                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}选择模板：{/t}</label>
                            <div class="col-lg-6">
                                <span class="help-block">{t domain="merchant"}此模板只适用于PC端店铺首页（点击图片可查看模板大图）{/t}</span>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-lg-12">
                                <div class="index-template-content img-pwsp-list">
                                    <div class="index-template-item">
                                        <figure>
                                            <span><a class="nopjax" href="{$app_url}01.png" data-size="1251x655" data-med-size="1251x655" title='{t domain="merchant"}点击放大{/t}' data-med="{$app_url}01.png"><img href="{$app_url}01.png" src="{$app_url}01.png" class="w342"/></a></span>
                                        </figure>
                                    </div>
                                    <div class="index-template-item">
                                        <figure>
                                            <span><a class="nopjax" href="{$app_url}02.png" data-size="1251x655" data-med-size="1251x655" title='{t domain="merchant"}点击放大{/t}' data-med="{$app_url}02.png"><img href="{$app_url}02.png" src="{$app_url}02.png" class="w342"/></a></span>
                                        </figure>
                                    </div>
                                    <div class="index-template-item">
                                        <figure>
                                            <span><a class="nopjax" href="{$app_url}03.png" data-size="1251x655" data-med-size="1251x655" title='{t domain="merchant"}点击放大{/t}' data-med="{$app_url}03.png"><img href="{$app_url}03.png" src="{$app_url}03.png" class="w342"/></a></span>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 m_b10">
                                <div class="f_l m_l5">
                                    <input id="template_1" type="radio" name="store_index_template" value="default1" {if $store_index_template eq 'default1'} checked{/if}/>
                                    <label for="template_1">{t domain="merchant"}模板一{/t}</label>
                                </div>
                                <div class="f_l m_l295">
                                    <input id="template_2" type="radio" name="store_index_template" value="default2" {if $store_index_template eq 'default2'} checked{/if}/>
                                    <label for="template_2">{t domain="merchant"}模板二{/t}</label>
                                </div>
                                <div class="f_l m_l295">
                                    <input id="template_3" type="radio" name="store_index_template" value="default3" {if $store_index_template eq 'default3'} checked{/if}/>
                                    <label for="template_3">{t domain="merchant"}模板三{/t}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="index-template-content img-pwsp-list">
                                    <div class="index-template-item">
                                        <figure>
                                            <span><a class="nopjax" href="{$app_url}04.png" data-size="1251x655" data-med-size="1251x655" title='{t domain="merchant"}点击放大{/t}' data-med="{$app_url}04.png"><img href="{$app_url}04.png" src="{$app_url}04.png" class="w342"/></a></span>
                                        </figure>
                                    </div>
                                    <div class="index-template-item">
                                        <figure>
                                            <span><a class="nopjax" href="{$app_url}05.png" data-size="1251x655" data-med-size="1251x655" title='{t domain="merchant"}点击放大{/t}' data-med="{$app_url}05.png"><img href="{$app_url}05.png" src="{$app_url}05.png" class="w342"/></a></span>
                                        </figure>
                                    </div>
                                    <div class="index-template-item">
                                        <figure>
                                            <span><a class="nopjax" href="{$app_url}06.png" data-size="1251x655" data-med-size="1251x655" title='{t domain="merchant"}点击放大{/t}' data-med="{$app_url}06.png"><img href="{$app_url}06.png" src="{$app_url}06.png" class="w342"/></a></span>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 m_b10">
                                <div class="f_l m_l5">
                                    <input id="template_4" type="radio" name="store_index_template" value="default4" {if $store_index_template eq 'default4'} checked{/if}/>
                                    <label for="template_4">{t domain="merchant"}模板四{/t}</label>
                                </div>
                                <div class="f_l m_l295">
                                    <input id="template_5" type="radio" name="store_index_template" value="default5" {if $store_index_template eq 'default5'} checked{/if}/>
                                    <label for="template_5">{t domain="merchant"}模板五{/t}</label>
                                </div>
                                <div class="f_l m_l295">
                                    <input id="template_6" type="radio" name="store_index_template" value="default6" {if $store_index_template eq 'default6'} checked{/if}/>
                                    <label for="template_6">{t domain="merchant"}模板六{/t}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group m_t20">
                            <div class="col-lg-6 col-md-offset-2">
                                <input class="btn btn-info" type="submit" name="name" value='{t domain="merchant"}保存{/t}'>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg">
    </div>
    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">
        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item">
            </div>
            <div class="pswp__item">
            </div>
            <div class="pswp__item">
            </div>
        </div>
        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <!--  Controls are self-explanatory. Order can be changed. -->
                <div class="pswp__counter">
                </div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip">
                </div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->
