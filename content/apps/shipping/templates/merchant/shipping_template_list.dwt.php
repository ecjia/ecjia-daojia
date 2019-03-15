<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>{t domain="shipping"}配送管理{/t}</h2>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                	<div class="col-lg-3">
						<div class="setting-group">
					        <span class="setting-group-title">{t domain="shipping"}配送管理{/t}</span>
					        <ul class="nav nav-list m_t10 change">
						        <li><a class="setting-group-item llv-active" href='{url path="shipping/mh_shipping/shipping_template"}'>{t domain="shipping"}运费模板{/t}</a></li>
						        <li><a class="setting-group-item" href='{url path="express/merchant/init" args="type=wait_grab"}'>{t domain="shipping"}配送任务{/t}</a></li>
						        <li><a class="setting-group-item" href='{url path="express/mh_history/init"}'>{t domain="shipping"}历史配送{/t}</a></li>
					        </ul>
						</div>
					</div>
					
					<div class="col-lg-9">
						<div class="panel-body panel-body-small">
							<h2 class="page-header">
								{if $ur_here}{$ur_here}{/if}
								<div class="pull-right">
									<a class="btn btn-primary data-pjax" href='{RC_Uri::url("shipping/mh_shipping/add_shipping_template")}'><i class="fa fa-plus"></i> {t domain="shipping"}添加运费模板{/t}</a>
								</div>
							</h2>
							
							<section class="panel">
								<!-- {foreach from=$data.item item=list} -->
								<div class="template-item">
									<div class="template-head">
										<div class="head-left">{$list.shipping_area_name}</div>
										<div class="head-right">
											<a class="data-pjax" href='{RC_Uri::url("shipping/mh_shipping/edit_shipping_template")}&template_name={$list.shipping_area_name}'>{t domain="shipping"}查看详情{/t}</a> &nbsp;|&nbsp;
											<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="shipping"}您确定要删除该运费模板吗？{/t}' href='{RC_Uri::url("shipping/mh_shipping/remove_shipping_template", "name={$list.shipping_area_name}")}' title='{t domain="shipping"}删除{/t}'>{t domain="shipping"}删除{/t}</a>
										</div>
									</div>
									<div class="template-content">
										<div class="content-group">
											<div class="content-label">{t domain="shipping"}物流快递：{/t}</div>
											<div class="content-controls">
												{$list.shipping_name}
											</div>
										</div>
										<div class="content-group">
											<div class="content-label">{t domain="shipping"}配送区域：{/t}</div>
											<div class="content-controls">
												{$list.shipping_area}
											</div>
										</div>
									</div>
								</div>
								<!-- {foreachelse} -->
									<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
										<tbody>
											<tr><td class="no-records" colspan="4">{t domain="shipping"}没有找到任何记录{/t}</td></tr>
										</tbody>
									</table>
								<!-- {/foreach} -->
								<!-- {$data.page} -->
							</section>
						</div>
					</div>
                </div>
            </div>
    </div>
</div>

<!-- {/block} -->