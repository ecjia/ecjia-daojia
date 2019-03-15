<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.profile_avatar.init();
</script>
<!-- {/block} -->


<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-info data-pjax pull-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text} </a>
		{/if}
		</h2>
	</div>
</div>

<div class="row" id="real-estates-detail">
   	<!-- #BeginLibraryItem "/library/profile_setting.lbi" --><!-- #EndLibraryItem -->
    <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <ul id="myTab" class="nav nav-pills">
                	<li class=""><a class="data-pjax" href='{url path="staff/mh_profile/init"}'>{t domain="staff"}个人资料{/t}</a></li>
                    <li class=""><a class="data-pjax" href='{url path="staff/mh_profile/setting"}'>{t domain="staff"}账户设置{/t}</a></li>
                    <li class="active"><a href="#avatar">{t domain="staff"}头像设置{/t}</a></li>
                </ul>
                <br>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="avatar"> 
                        <div class="profile">
					        <div class="imageBox">
					            <div class="thumbBox">
					            </div>
					            <div class="spinner" style="display: none"> <img src="{$ecjia_main_static_url}img/crop_avatar.jpg"/><br><br></div>
					        </div>
					        <div class="action">
					            <div class="new-contentarea tc">
					                <a href="javascript:void(0)" class="upload-img">
					                    <label for="upload-file">{t domain="staff"}选择图像{/t}</label>
					                </a>
					                <input type="file" class="" name="avatar" id="upload-file" />
					            </div>
					            <input type="button" id="btnSubmit" class="Btnsty_peyton" data-url="{$form_action}" value='{t domain="staff"}上传{/t}' />
					            <input type="button" id="btnCrop" class="Btnsty_peyton" value='{t domain="staff"}裁切{/t}' />
					            <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+" />
					            <input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-" />
					        </div>
					        <div class="cropped">
					        </div>
					    </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
              

