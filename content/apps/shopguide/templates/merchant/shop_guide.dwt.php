<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.shopguide.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				<!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
          		{lang key='shopguide::shopguide.base_info'}
          		<!-- {elseif $smarty.get.step eq '2'} -->
          		{lang key='shopguide::shopguide.goods_info'}
          		<!-- {elseif $smarty.get.step eq '3'} -->
          		<!-- {/if} -->
         	</header>
        	<div class="panel-body">
           		<div class="stepy-tab">
	             	<ul id="default-titles" class="stepy-titles clearfix">
	         			<li id="step1" class="{if !$smarty.get.step || $smarty.get.step eq '1'}current-step{/if}"><div>第一步</div></li>
	    				<li id="step2" class="{if $smarty.get.step eq '2'}current-step{/if}"><div>第二步</div></li>
	                   	<li id="step3" class="{if $smarty.get.step eq '3'}current-step{/if}"><div>第三步</div></li>
	                </ul>
				</div>     
				<form class="form-horizontal cmxform" id="default" action="{url path='shopguide/merchant/step_post'}{if $smarty.get.step}&step={$smarty.get.step}{/if}" method="post" name="theForm" enctype="multipart/form-data" data-toggle='from'>
				    <!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
				    <fieldset class="step1" id="default-step-0">
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
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_nav_background}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_nav_background"}" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：2000x1500px.</span>
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
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_logo}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_logo"}" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：512x512px.</span>
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
                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_banner_pic}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=shop_banner_pic"}" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：500x300px.</span>
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

                        <div class="form-group ">
                            <label for="ccomment" class="control-label col-lg-2">{t}店铺公告：{/t}</label>
                            <div class="controls col-lg-6">
                                <textarea class="form-control required" name="shop_notice">{$data.shop_notice}</textarea>
                            </div>
                            <span class="input-must">
                                <span id="email-error" class="require-field error" style="color:#FF0000,">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{t}店铺简介：{/t}</label>
                            <div class="controls col-lg-6">
                                <textarea class="form-control required" name="shop_description">{$data.shop_description}</textarea>
                            </div>
                            <span class="input-must">
                                <span id="email-error" class="require-field error" style="color:#FF0000,">*</span>
                            </span>
                        </div>
						
						<input class="btn btn-info f_r" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>
				    </fieldset>
				    
				    <!-- {elseif $smarty.get.step eq '2'} -->
				    <fieldset class="step2" id="default-step-1">
				        <div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_cat'}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type="text" name="cat_name" />
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>	
						
						<div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_name'}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type="text" name="goods_name" />
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
							
						<div class="form-group">
							<label class="col-lg-2 control-label">商品类型：</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="goods_type" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_num'}</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="goods_num" />
							</div>
						</div>
							
						<div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_price'}</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name="goods_price" />
							</div>
						</div>
							
						<div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_add_recommend'}</label>
							<div class="col-lg-6">
								<div class="checkbox">
									<input id="is_best" type="checkbox" name="is_best" checked />
									<label for="is_best">{lang key='shopguide::shopguide.is_best'}</label>
									
									<input id="is_new" type="checkbox" name="is_new" checked />
									<label for="is_new">{lang key='shopguide::shopguide.is_new'}</label>
									
									<input id="is_hot" type="checkbox" name="is_hot" checked />
									<label for="is_hot">{lang key='shopguide::shopguide.is_hot'}</label>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_desc'}</label>
							<div class="col-lg-6">
								<textarea class="form-control" name="goods_desc"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_upload_image'}</label>
							<div class="col-lg-6">
								<div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="goods_img" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
							</div>
						</div>
						
					    <input class="btn btn-info f_r" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>
				        
				    </fieldset>
				    <!-- {elseif $smarty.get.step eq '3'} -->
				    <fieldset class="step3" id="default-step-2">
				    	<div class="jumbotron text-center">
				  	  		{lang key='shopguide::shopguide.result_info'}
                    	</div>
				    </fieldset>
				    <!-- {/if} -->
				</form>
			</div>
    	</section>
	</div>
</div>
<!-- {/block} -->