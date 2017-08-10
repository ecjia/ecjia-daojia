<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.merchant_info.init();
	ecjia.merchant.merchant_info.range();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>
<style media="screen" type="text/css">
label + div.col-lg-6, label + div.col-lg-2 {
    padding-top: 3px;
    color: #333;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal" name="theForm" action="{$form_action}"  method="post" enctype="multipart/form-data" data-toggle='from'>
                  	    <div class="form-group">
                            <label class="control-label col-lg-2">{t}店铺名称：{/t}</label>
                            <div class="col-lg-6">
                                <h4>{$data.merchants_name}</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t}店铺导航背景图：{/t}</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.shop_nav_background}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.shop_nav_background}
                                    <div class="fileupload-{if $data.shop_nav_background}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.shop_nav_background}" alt="店铺导航背景图" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.shop_nav_background}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_nav_background" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_nav_background}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_nav_background"}" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：2000x1500px，大小不超过2M</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t}店铺LOGO：{/t}</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.shop_logo}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.shop_logo}
                                    <div class="fileupload-{if $data.shop_logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.shop_logo}" alt="店铺LOGO" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.shop_logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_logo" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_logo}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_logo"}" >删除</a>
                                	<span class="input-must">{lang key='system::system.require_field'}</span>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：512x512px</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t}APP Banner图：{/t}</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.shop_banner_pic}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.shop_banner_pic}
                                    <div class="fileupload-{if $data.shop_banner_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.shop_banner_pic}" alt="banner图" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.shop_banner_pic}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_banner_pic" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_banner_pic}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_banner_pic"}" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：3:1（600x200px）</span>
                            </div>
                        </div>
                        
                      	<div class="form-group">
                            <label class="control-label col-lg-2">{t}店铺二维码：{/t}</label>
                            <div class="col-lg-10">
                            	{if $data.store_qrcode}
                                <div class="fileupload fileupload-{if $data.store_qrcode}exists{else}new{/if}" data-provides="fileupload">
                                    <div class="fileupload-{if $data.store_qrcode}exists{else}new{/if} thumbnail fileupload-store-qrcode">
                                        <img src="{$data.store_qrcode}" alt="店铺二维码" style="width:150px; height:150px;"/>
                                    </div>
                                    <a class="btn btn-primary btn-sm fileupload-exists" {if $data.store_qrcode}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/refresh_qrcode'}" style="margin-top: 120px;">刷新</a>
                                </div>
                                {else}
                                <a class="btn btn-primary btn-sm fileupload-exists" data-toggle="ajax_remove" href="{url path='merchant/merchant/refresh_qrcode'}">刷新</a>
                                {/if}
                                <span class="help-block">上传店铺logo后，点击刷新按钮可生成店铺二维码。删除店铺logo后，需手动刷新才可删除店铺二维码。</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t}营业时间：{/t}</label>
                            <div class="col-lg-6">
                                <div class="range">
                                    <input class="range-slider" name="shop_trade_time" type="hidden" value="{$data.shop_time_value}"/>
                                </div>
                                <span class="help-block">拖拽选取营业时间段</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t}客服电话：{/t}</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="shop_kf_mobile" type="text" value="{$data.shop_kf_mobile}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ccomment" class="control-label col-lg-2">{t}店铺公告：{/t}</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_notice">{$data.shop_notice}</textarea>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t}店铺简介：{/t}</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_description">{$data.shop_description}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t}自动派单：{/t}</label>
                            <div class="col-lg-6">
                                <input id="open" type="radio" name="express_assign_auto" value="1" {if $data.express_assign_auto eq 1} checked="true" {/if}  />
                                <label for="open">开启</label>
                                <input id="close" type="radio" name="express_assign_auto" value="0" {if $data.express_assign_auto eq 0} checked="true" {/if}  />
                                <label for="close">关闭</label>
                                <span class="help-block">（订单使用o2o配送方式时。当发货未选择配送员时，系统将自动优先分派配送单，再进入抢单模式，否则进入抢单模式）</span>
                            </div>
                            
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-6 col-md-offset-2">
                                <input class="btn btn-info" type="submit" name="name" value="提交信息">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
