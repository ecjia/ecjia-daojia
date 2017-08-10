<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	//腾讯地图
	var step='{$step}';
	var map, markersArray = [];
    var lat = '{$data.latitude}';
    var lng = '{$data.longitude}';
	var latLng = new qq.maps.LatLng(lat, lng);
	var map = new qq.maps.Map(document.getElementById("allmap"),{
	    center: latLng,
	    zoom: 16
	});
	setTimeout(function(){
	    var marker = new qq.maps.Marker({
	        position: latLng, 
	        map: map
	   	});
	    markersArray.push(marker);
	}, 500);
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<style media="screen" type="text/css">
    label + div.col-lg-6,
    label + div.col-lg-2{
        padding-top: 7px;
    }
    .panel .panel-body{
        padding: 0 15px 15px;
    }
    .table>tbody>tr>td:first{
        border-top: none;
    }
</style>
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
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <section>
                    <h2 class="page-header">店铺信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{lang key='merchant::merchant.merchants_type'}：</td>
                                    <td style="border-top:0px;">{if $data.validate_type eq 1}个人{else}企业{/if}入驻</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.merchants_name'}：</td>
                                    <td>{$data.merchants_name}{if $data.manage_mode eq 'self'}<span class="merchant_tags">自营</span>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.merchant_cat'}：</td>
                                    <td>{if $data.cat_name}{$data.cat_name}{else}<i>< 还未选择 ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.shop_keyword'}：</td>
                                    <td>{if $data.shop_keyword}{$data.shop_keyword}{else}<i>< 还未填写 ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.address'}：</td>
                                    <td>{if $data.province || $data.city || $data.district || $data.address}
                                        {$data.province} {$data.city} {$data.district} {$data.address}
                                        {else}
                                        <i>< 还未填写 ></i>
                                        {/if}
                                    </td>
                                </tr>
                                <!-- {if $data.longitude && $data.latitude} -->
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.merchant_addres'}：</td>
                                    <td>
                                        <div id="allmap" style="height:320px;"></div>
                                        <div class="help-block">双击放大地图，拖动查看地图其他区域</div>
                                        <div class="help-block">当前经纬度：{$data.longitude},{$data.latitude}</div>
                                    </td>
                                </tr>
                                <!-- {/if} -->
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">联系人信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{lang key='merchant::merchant.responsible_person'}：</td>
                                    <td style="border-top:0px;">
                                        <!-- {if $data.responsible_person} -->
                                        {$data.responsible_person}
                                        <!-- {else} -->
                                        <i>< 还未填写 ></i>
                                        <!-- {/if} -->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.email'}：</td>
                                    <td>
                                        <!-- {if $data.email} -->
                                        {$data.email}
                                        <!-- {else} -->
                                        <i>< 还未填写 ></i>
                                        <!-- {/if} -->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.contact_mobile'}：</td>
                                    <td>
                                        <!-- {if $data.contact_mobile} -->
                                        {$data.contact_mobile}
                                        <!-- {else} -->
                                        <i>< 还未填写 ></i>
                                        <!-- {/if} -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">资质信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{lang key='merchant::merchant.identity_type'}：</td>
                                    <td style="border-top:0px;">
                                        {if $data.identity_type eq 1}身份证{/if}
                                        {if $data.identity_type eq 2}护照{/if}
                                        {if $data.identity_type eq 3}港澳身份证{/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.identity_number'}：</td>
                                    <td>{if $data.identity_number}{$data.identity_number}{else}<i>< 还未填写 ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.identity_pic_front'}：</td>
                                    <td>{if $data.identity_pic_front}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_front}" alt="证件正面"/>{else}<i>< 还未上传 ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.identity_pic_back'}：</td>
                                    <td>{if $data.identity_pic_back}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_back}" alt="证件反面"/>{else}<i>< 还未上传 ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.personhand_identity_pic'}：</td>
                                    <td>{if $data.personhand_identity_pic}<img class="merchant-info-img w200 h120" src="{$data.personhand_identity_pic}" alt="手持证件拍照"/>{else}<i>< 还未上传 ></i>{/if}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- {if $data.validate_type eq 2} -->
                <section>
                    <h2 class="page-header">公司信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{lang key='merchant::merchant.company_name'}：</td>
                                    <td style="border-top:0px;">{$data.company_name}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.business_licence'}：</td>
                                    <td>{$data.business_licence}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{lang key='merchant::merchant.business_licence_pic'}：</td>
                                    <td>{if $data.business_licence_pic}<img class="merchant-info-img w200 h120" src="{$data.business_licence_pic}" alt="营业执照"/>{/if}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>
                <!-- {/if} -->

            </div>
        </div>

        <div class="form-group ">
            <div class="col-lg-6 col-md-offset-4">
                <a class="btn btn-info data-pjax" href="{url path="merchant/mh_franchisee/request_edit"}">申请修改</a>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
