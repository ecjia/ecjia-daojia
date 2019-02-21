<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.merchant_info.confirm_link();
</script>
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
                    <h2 class="page-header">{t domain="merchant"}店铺信息{/t}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="merchant"}入驻类型：{/t}</td>
                                    <td style="border-top:0px;">{if $data.validate_type eq 1}{t domain="merchant"}个人{/t}{else}{t domain="merchant"}企业{/t}{/if}{t domain="merchant"}入驻{/t}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}店铺名称：{/t}</td>
                                    <td>{$data.merchants_name}{if $data.manage_mode eq 'self'}<span class="merchant_tags">{t domain="merchant"}自营{/t}</span>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}店铺分类：{/t}</td>
                                    <td>{if $data.cat_name}{$data.cat_name}{else}<i>< {t domain="merchant"}还未选择{/t} ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}店铺关键字：{/t}</td>
                                    <td>{if $data.shop_keyword}{$data.shop_keyword}{else}<i>< {t domain="merchant"}还未填写{/t}></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}详细地址：{/t}</td>
                                    <td>{if $data.province || $data.city || $data.district || $data.street || $data.address}
                                        {$data.province} {$data.city} {$data.district} {$data.street} {$data.address}
                                        {else}
                                        <i>< {t domain="merchant"}还未填写{/t} ></i>
                                        {/if}
                                    </td>
                                </tr>
                                <!-- {if $data.longitude && $data.latitude} -->
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}店铺精确位置：{/t}</td>
                                    <td>
                                        <div id="allmap" style="height:320px;"></div>
                                        <div class="help-block">{t domain="merchant"}双击放大地图，拖动查看地图其他区域{/t}</div>
                                        <div class="help-block">{t domain="merchant"}当前经纬度：{/t}{$data.longitude},{$data.latitude}</div>
                                    </td>
                                </tr>
                                <!-- {/if} -->
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">{t domain="merchant"}联系人信息{/t}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="merchant"}负责人：{/t}</td>
                                    <td style="border-top:0px;">
                                        <!-- {if $data.responsible_person} -->
                                        {$data.responsible_person}
                                        <!-- {else} -->
                                        <i>< {t domain="merchant"}还未填写{/t} ></i>
                                        <!-- {/if} -->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}联系邮箱：{/t}</td>
                                    <td>
                                        <!-- {if $data.email} -->
                                        {$data.email}
                                        <!-- {else} -->
                                        <i>< {t domain="merchant"}还未填写{/t} ></i>
                                        <!-- {/if} -->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}联系手机：{/t}</td>
                                    <td>
                                        <!-- {if $data.contact_mobile} -->
                                        {$data.contact_mobile}
                                        <!-- {else} -->
                                        <i>< {t domain="merchant"}还未填写{/t} ></i>
                                        <!-- {/if} -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">{t domain="merchant"}资质信息{/t}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="merchant"}证件类型：{/t}</td>
                                    <td style="border-top:0px;">
                                        {if $data.identity_type eq 1}{t domain="merchant"}身份证{/t}{/if}
                                        {if $data.identity_type eq 2}{t domain="merchant"}护照{/t}{/if}
                                        {if $data.identity_type eq 3}{t domain="merchant"}港澳身份证{/t}{/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}证件号码：{/t}</td>
                                    <td>{if $data.identity_number}{$data.identity_number}{else}<i>< {t domain="merchant"}还未填写{/t} ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}证件正面：{/t}</td>
                                    <td>{if $data.identity_pic_front}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_front}" alt='{t domain="merchant"}证件正面{/t}'/>{else}<i>< {t domain="merchant"}还未上传{/t} ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}证件反面：{/t}</td>
                                    <td>{if $data.identity_pic_back}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_back}" alt='{t domain="merchant"}证件反面{/t}'/>{else}<i>< {t domain="merchant"}还未上传{/t} ></i>{/if}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}手持证件拍照：{/t}</td>
                                    <td>{if $data.personhand_identity_pic}<img class="merchant-info-img w200 h120" src="{$data.personhand_identity_pic}" alt='{t domain="merchant"}手持证件拍照{/t}'/>{else}<i>< {t domain="merchant"}还未上传{/t} ></i>{/if}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- {if $data.validate_type eq 2} -->
                <section>
                    <h2 class="page-header">{t domain="merchant"}公司信息{/t}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="merchant"}公司名称：{/t}</td>
                                    <td style="border-top:0px;">{$data.company_name}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}营业执照注册号：{/t}</td>
                                    <td>{$data.business_licence}</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right">{t domain="merchant"}营业执照电子版：{/t}</td>
                                    <td>{if $data.business_licence_pic}<img class="merchant-info-img w200 h120" src="{$data.business_licence_pic}" alt='{t domain="merchant"}营业执照{/t}'/>{/if}</td>
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
                <a class="btn btn-info data-pjax" href='{url path="merchant/mh_franchisee/request_edit"}'>{t domain="merchant"}申请修改{/t}</a>
				<!-- {if $data.validate_type eq 1} -->
				<a class="btn btn-info no-pjax m_l20" data-toggle="confirm_link" data-msg='{t domain="merchant"}您确定要升级为企业入驻吗？升级成功后不可修改为个人入驻！{/t}' href='{url path="merchant/mh_franchisee/request_edit" args="&type=company"}'>{t domain="merchant"}升级企业入驻{/t}</a>
				<!-- {/if} -->
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
