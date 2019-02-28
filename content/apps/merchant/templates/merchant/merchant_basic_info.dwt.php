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
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺名称：{/t}</label>
                            <div class="col-lg-6">
                                <h4>{$data.merchants_name}</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺导航背景图：{/t}</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.shop_nav_background}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.shop_nav_background}
                                    <div class="fileupload-{if $data.shop_nav_background}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.shop_nav_background}" alt='{t domain="merchant"}店铺导航背景图{/t}' style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.shop_nav_background}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="merchant"}浏览{/t}</span>
                                        <span class="fileupload-exists"> {t domain="merchant"}修改{/t}</span>
                                        <input type="file" class="default" name="shop_nav_background" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_nav_background}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_nav_background"}" >删除</a>
                                </div>
                                <span class="help-block">{t domain="merchant"}推荐图片的尺寸为：2000x1500px，大小不超过2M{/t}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺LOGO：{/t}</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.shop_logo}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.shop_logo}
                                    <div class="fileupload-{if $data.shop_logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.shop_logo}" alt='{t domain="merchant"}店铺LOGO{/t}' style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.shop_logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="merchant"}浏览{/t}</span>
                                        <span class="fileupload-exists"> {t domain="merchant"}修改{/t}</span>
                                        <input type="file" class="default" name="shop_logo" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_logo}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_logo"}" >{t domain="merchant"}删除{/t}</a>
                                	<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
                                </div>
                                <span class="help-block">{t domain="merchant"}推荐图片的尺寸为：512x512px{/t}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺顶部Banner图：{/t}</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.shop_banner_pic}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.shop_banner_pic}
                                    <div class="fileupload-{if $data.shop_banner_pic}exists{else}new{/if} thumbnail" style="border: none;width: 240px;height: 80px;">
                                        <img src="{$data.shop_banner_pic}" alt='{t domain="merchant"}banner图{/t}' style="width: 240px;height: 80px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.shop_banner_pic}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {t domain="merchant"}浏览{/t}</span>
                                        <span class="fileupload-exists"> {t domain="merchant"}修改{/t}</span>
                                        <input type="file" class="default" name="shop_banner_pic" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_banner_pic}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_banner_pic"}" >删除</a>
                                </div>
                                <span class="help-block">{t domain="merchant"}推荐图片的尺寸为：3:1（1200x400px）{/t}</span>
                                    
                                {if $data.shop_banner_pic}
                                <div>
                                    <p>{t domain="merchant"}缩略图：{/t}</p>
                                    <p>
                                        {if !$banner_thumb_exists}
                                        <a class="btn btn-primary" href="javascript:;" data-toggle="make_thumb" data-url="{$make_thumb_url}" data-type="make">手动生成</a>
                                        {else}
                                        <img src="{$banner_thumb_url}" alt="banner图" style="width: 120px;height: 40px;"/>
                                        <a class="btn btn-primary" href="javascript:;" data-toggle="make_thumb" data-url="{$make_thumb_url}" data-type="refresh">重新生成</a>
                                        {/if}
                                    </p>
                                    <span class="help-block">{t domain="merchant"}生成后，图片内存将变小，缩略图可以减小存放内存，提高访问效率{/t}</span>
                                </div>
                                {/if}

                            </div>
                        </div>
                        
                      	<div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺二维码：{/t}</label>
                            <div class="col-lg-10">
                            	{if $data.store_qrcode}
                                <div class="fileupload fileupload-{if $data.store_qrcode}exists{else}new{/if}" data-provides="fileupload">
                                    <div class="fileupload-{if $data.store_qrcode}exists{else}new{/if} thumbnail fileupload-store-qrcode f_l">
                                        <img src="{$data.store_qrcode}" alt='{t domain="merchant"}店铺二维码{/t}' style="width:150px; height:150px;"/>
                                    </div>
                                    <div class="help-block f_l" style="width: 700px;margin-left: 10px;">
                                        {t domain="merchant" escape=no}<p>该二维码是您店铺的手机网址；</p>
                                        <p>您可以将此二维码通过网上或线下宣传展示给您的用户；用户使用手机扫描该二维码，就可以访问您的店铺网页并下单哦！</p>
                                        <p>上传店铺logo后，点击刷新按钮可生成店铺二维码。删除店铺logo后，需手动刷新才可删除店铺二维码。</p>{/t}
                                    </div>
                                    <a class="btn btn-primary btn-sm fileupload-exists" {if $data.store_qrcode}data-toggle="ajax_remove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/refresh_qrcode'}" style="margin-top: 5px; margin-left: 10px;">{t domain="merchant"}刷新{/t}</a>
                                    <a class="btn btn-primary btn-sm" href="{url path='merchant/merchant/download'}&type=merchant_qrcode" style="margin-top: 5px;">{t domain="merchant"}下载二维码{/t}</a>
                                </div>
                                {else}
                                <a class="btn btn-primary btn-sm fileupload-exists" data-toggle="ajax_remove" href="{url path='merchant/merchant/refresh_qrcode'}">{t domain="merchant"}刷新{/t}</a>
                                {/if}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺小程序二维码：{/t}</label>
                            <div class="col-lg-10">
                                <div class="fileupload fileupload-exists" data-provides="fileupload">
                                    <div class="fileupload-exists thumbnail fileupload-store-weapp-qrcode f_l">
                                        <img src="{RC_Uri::url('weapp/wxacode/init')}&storeid={$store_id}" alt="店铺二维码" style="width:150px; height:150px;"/>
                                    </div>
                                    <div class="help-block f_l" style="width: 700px;margin-left: 10px;">
                                        {t domain="merchant" escape=no}<p>该二维码是外卖小程序您店铺的手机网址；</p>
                                        <p>您可以将此二维码通过网上或线下宣传展示给您的用户；用户使用手机扫描该二维码，就可以访问您的店铺网页并下单哦！</p>
                                         <p>抓住新的推广方式，快来试试吧！</p>
                                    </div>
                                    <a class="btn btn-primary btn-sm" href="{url path='merchant/merchant/download'}&type=merchant_weapp_qrcode" style="margin-top: 5px;margin-left: 10px;">下载二维码</a>{/t}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}营业时间：{/t}</label>
                            <div class="col-lg-6">
                                <div class="range">
                                    <input class="range-slider" name="shop_trade_time" type="hidden" value="{$data.shop_time_value}"/>
                                </div>
                                <span class="help-block">{t domain="merchant"}拖拽选取营业时间段{/t}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}客服电话：{/t}</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="shop_kf_mobile" type="text" value="{$data.shop_kf_mobile}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ccomment" class="control-label col-lg-2">{t domain="merchant"}店铺公告：{/t}</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_notice">{$data.shop_notice}</textarea>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t domain="merchant"}店铺简介：{/t}</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_description">{$data.shop_description}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t domain="merchant"}自动派单：{/t}</label>
                            <div class="col-lg-10">
                                <input id="open" type="radio" name="express_assign_auto" value="1" {if $data.express_assign_auto eq 1} checked="true" {/if}  />
                                <label for="open">{t domain="merchant"}开启{/t}</label>
                                <input id="close" type="radio" name="express_assign_auto" value="0" {if $data.express_assign_auto eq 0} checked="true" {/if}  />
                                <label for="close">{t domain="merchant"}关闭{/t}</label>
                                <span class="help-block">{t domain="merchant"}（订单使用商家配送方式时。当发货未选择配送员时，系统将自动优先分派配送单，再进入抢单模式，否则进入抢单模式）{/t}</span>
                            </div>
                            
                        </div>
						
						 <div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}最小购物金额：{/t}</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="min_goods_amount" type="text" value="{$data.min_goods_amount}"/>
                                <span class="help-block">{t domain="merchant"}用户下单时达到此购物金额，才能提交订单{/t}</span>
                            </div>
                        </div>
                        
             			<div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}接单类型：{/t}</label>
                            <div class="col-lg-8">
                                <input id="orders_auto_confirm_1" type="radio" name="orders_auto_confirm" value="1" {if $data.orders_auto_confirm eq 1} checked="true" {/if}  />
                                <label for="orders_auto_confirm_1">{t domain="merchant"}自动接单{/t}</label>
                                <input id="orders_auto_confirm_0" type="radio" name="orders_auto_confirm" value="0" {if $data.orders_auto_confirm eq 0} checked="true" {/if}  />
                                <label for="orders_auto_confirm_0">{t domain="merchant"}手动接单{/t}</label>
                                <span class="help-block">{t domain="merchant"}启用自动接单后，所有订单将无需人工处理接单，自动由系统接单，您可以随时切回手动接单模式{/t}</span>
                            </div>
                        </div>
                        
               			<div class="form-group orders_auto_rejection_time {if $data.orders_auto_confirm eq 1}hide{/if}">
                            <label class="control-label col-lg-2">{t domain="merchant"}拒绝接单时间：{/t}</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="orders_auto_rejection_time" type="text" value="{$data.orders_auto_rejection_time}"/>
                                <span class="help-block">{t domain="merchant"}若管理员未操作手动接单，系统将会在设置时间（单位：分钟）后自动拒绝接单，<br/>默认0代表不设置，不设置则需要管理员手动拒单{/t}</span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-lg-2">{t domain="merchant"}小票离线打印：{/t}</label>
                            <div class="col-lg-8">
                                <input id="printer_offline_send_1" type="radio" name="printer_offline_send" value="1" {if $data.printer_offline_send eq 1} checked="true" {/if}  />
                                <label for="printer_offline_send_1">{t domain="merchant"}开启{/t}</label>
                                <input id="printer_offline_send_0" type="radio" name="printer_offline_send" value="0" {if $data.printer_offline_send eq 0} checked="true" {/if}  />
                                <label for="printer_offline_send_0">{t domain="merchant"}关闭{/t}</label>
                                <span class="help-block">{t domain="merchant"}开启后，已支付的订单自动加入打印队列，只要小票机在线后，将自动打印订单{/t}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-6 col-md-offset-2">
                                <input class="btn btn-info" type="submit" name="name" value='{t domain="merchant"}提交信息{/t}'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
