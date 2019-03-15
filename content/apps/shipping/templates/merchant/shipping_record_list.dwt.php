<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript"></script>
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
						        <li><a class="setting-group-item data-pjax" href='{url path="shipping/mh_shipping/shipping_template"}'>{t domain="shipping"}运费模板{/t}</a></li>
						        <li><a class="setting-group-item data-pjax" href='{url path="express/merchant/init" args="type=wait_grab"}'>{t domain="shipping"}配送任务{/t}</a></li>
						        <li><a class="setting-group-item data-pjax llv-active" href='{url path="express/mh_history/init"}'>{t domain="shipping"}历史配送{/t}</a></li>
					        </ul>
						</div>
					</div>
					
					<div class="col-lg-9">
						<div class="panel-body panel-body-small">
							<h2 class="page-header">
								{if $ur_here}{$ur_here}{/if}
							</h2>
								<section class="panel">
						            <table class="table table-striped table-hover table-hide-edit">
						                <thead>
						                    <tr>
						                        <th class="w210">{t domain="shipping"}流水号{/t}</th>
						                        <th class="w100">{t domain="shipping"}收货人名称{/t}</th>
						                        <th>{t domain="shipping"}收货地址{/t}</th>
						                        <th class="w110">{t domain="shipping"}创建时间{/t}</th>
						                        <th class="w80">{t domain="shipping"}配送来源{/t}</th>
						                        <th class="w100">{t domain="shipping"}配送状态{/t}</th>
						                    </tr>
						                </thead>
						                <tbody>
						                    <!-- {foreach from=$express_list item=list} -->
						                    <tr>
						                        <td class="hide-edit-area">
						                           	 {t domain="shipping"}配送单：{/t}{$list.express_sn}<br/>
						                           	 {t domain="shipping"}发货单：{/t}{$list.delivery_sn}<br/>
						                            <div class="edit-list">
						                                <a class="data-pjax" href='{RC_Uri::url("shipping/mh_shipping/record_info", "express_id={$list.express_id}")}' title='{t domain="shipping"}查看详情{/t}'>{t domain="shipping"}查看详情{/t}</a>
						                            </div>
						                        </td>
						                        <td>
						                            {$list.consignee}<br>
						                            {$list.mobile}
						                        </td>
						                        <td>{$list.address}</td>
						                        <td>{$list.formatted_add_time}</td>
						                        <td>{$list.label_from}</td>
						                        <td>{$list.label_status}</td>
						                    </tr>
						                    <!-- {foreachelse} -->
						                    <tr><td class="no-records" colspan="8">{t domain="shipping"}没有找到任何记录{/t}</td></tr>
						                    <!-- {/foreach} -->
						                </tbody>
						            </table>
						        </section>
						        <!-- {$page} -->
						</div>
					</div>
                </div>
            </div>
    </div>
</div>

<!-- {/block} -->