<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.merchant_info.mh_switch();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>温馨提示：</strong>{t}当您的店铺还未完善店铺信息、未完整上架商品以及您临时有事不能正常运营时可暂时下线店铺。{/t}
</div>

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
</style>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                {if $tips}
                <h4>{$tips}</h4>
                {else}
				<form class="cmxform form-horizontal" name="theForm" action="{$form_action}"  method="post" enctype="multipart/form-data" data-toggle='from'>
					<div class="form-group">
				        <label class="control-label col-lg-2">{t}店铺上下线：{/t}</label>
				        <div class="col-lg-6">
				            <!-- <div id="danger-toggle-button"  data-toggleButton-width="170">
				                <input type="checkbox" checked="checked">
				            </div> -->
				            <input id="close1" type="radio" name="shop_close" value="0" {if $merchant_info.shop_close eq 0} checked="true" {/if}  />
				            <label for="close1">上线</label>
				            <input id="close2" type="radio" name="shop_close" value="1" {if $merchant_info.shop_close eq 1} checked="true" {/if}  />
				            <label for="close2">下线</label>
				        </div>
				    </div>
				
				    <div class="form-group">
					  	<label class="control-label col-lg-2">手机号码：</label>
					  	<div class="controls col-lg-6">
					      	<input class="form-control" name="mobile" id="mobile" placeholder="请输入手机号码" type="text" value="{$merchant_info.mobile}" readonly/>
					  	</div>
					  	{if $type neq 'edit_apply'}
					 	<a class="btn btn-primary" data-url="{url path='merchant/merchant/get_code_value'}" id="get_code">获取短信验证码</a>
					 	{/if}
					</div>
				
					<div class="form-group">
					  	<label class="control-label col-lg-2">{t}短信验证码：{/t}</label>
					  	<div class="col-lg-6">
					      	<input class="form-control" name="code" placeholder="请输入手机短信验证码" type="text" />
					  	</div>
					</div>
				
					<div class="form-group ">
				        <div class="col-lg-6 col-md-offset-2">
				            <input class="btn btn-info unset_SetRemain" type="submit" name="name" value="提交信息">
				        </div>
				    </div>
				</form>
                {/if}
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->