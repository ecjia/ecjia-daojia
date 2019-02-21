<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_category_move.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
			<strong>{t domain="goods"}提示：{/t}</strong>{t domain="goods"}什么是转移商品分类？{/t}<br/>{t domain="goods"}在添加商品或者在商品管理中，如果需要对商品的分类进行变更，那么你可以通过此功能，正确管理你的商品分类。{/t}
		</div>
	</div>
</div>
                    
<div class="page-header">
	<div class="pull-left">
		<h2>
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>	
	</div>	
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-reply"></i> {$action_link.text} </a>
		<!-- {/if} -->
	</div>	
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
        	<div class="panel-body">
            	<div class="form">
              		<form class="form-horizontal tasi-form" method="post" action="{$form_action}" name="theForm">
              			<div class="form-group">
              				<label class="control-label col-lg-2">{t domain="goods"}从此分类：{/t}</label>
              				<div class="col-lg-6">
                            	<select class="form-control m-bot15" name="cat_id">
                            		<option value="0">{t domain="goods"}请选择...{/t}</option>
									<!-- {foreach from=$cat_select item=cat} -->
									<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
									<!-- {/foreach} -->
                                </select>
                          	</div>
              			</div>
              			
              			<div class="form-group">
              				<label class="control-label col-lg-2">{t domain="goods"}转移到：{/t}</label>
              				<div class="col-lg-6">
                      			<select class="form-control m-bot15" name="target_cat_id">
                      				<option value="0">{t domain="goods"}请选择...{/t}</option>
									<!-- {foreach from=$cat_select item=cat} -->
									<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.target_cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
									<!-- {/foreach} -->
                      			</select>
                         	</div>
              			</div>
              			
              			<div class="form-group">
              				<div class="col-lg-offset-2 col-lg-6">
              					<button class="btn btn-info" type="submit">{t domain="goods"}确定{/t}</button>
              				</div>
              			</div>
                    </form>
              	</div>
          	</div>
    	</section>
	</div>
</div>
<!-- {/block} -->