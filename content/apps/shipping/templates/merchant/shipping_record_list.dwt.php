<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript"></script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>配送管理</h2>
  	</div>
  	<div class="clearfix"></div>
</div>
<div class="row">
    <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                	<div class="col-lg-3">
						<div class="setting-group">
					        <span class="setting-group-title">配送管理</span>
					        <ul class="nav nav-list m_t10 change">
						        <li><a class="setting-group-item data-pjax" href='{url path="shipping/mh_shipping/shipping_template"}'>运费模板</a></li>
						        <li><a class="setting-group-item data-pjax llv-active" href='{url path="shipping/mh_shipping/shipping_record"}'>配送记录</a></li>
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
						                        <th class="w210">流水号</th>
						                        <th class="w100">{lang key='express::express.consignee'}</th>
						                        <th>{lang key='express::express.address'}</th>
						                        <th class="w110">{lang key='express::express.add_time'}</th>
						                        <th class="w80">{lang key='express::express.from'}</th>
						                        <th class="w100">{lang key='express::express.express_status'}</th>
						                    </tr>
						                </thead>
						                <tbody>
						                    <!-- {foreach from=$express_list item=list} -->
						                    <tr>
						                        <td class="hide-edit-area">
						                           	 配送：{$list.express_sn}<br/>
						                           	 发货单：{$list.delivery_sn}<br/>
						                            <div class="edit-list">
						                                <a class="data-pjax" href='{RC_Uri::url("shipping/mh_shipping/record_info", "express_id={$list.express_id}")}' title="{lang key='express::express.view_info'}">{lang key='express::express.view_info'}</a><!-- &nbsp;|&nbsp;
						                                <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='bonus::bonus.remove_bonustype_confirm'}" href='{RC_Uri::url("bonus/merchant/remove","id={$type.type_id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a> -->
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
						                    <tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
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