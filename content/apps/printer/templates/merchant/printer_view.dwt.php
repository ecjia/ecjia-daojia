<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
		<a class="btn btn-primary plus_or_reply toggle_view" id="sticky_a" href='{url path="printer/mh_print/get_print_status" args="id={$info.id}"}'>{t domain="printer"}刷新小票机状态{/t}</a>
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
				<div class="printer_box basic_info">
					<div class="title">{t domain="printer"}基本信息{/t}</div>
					<div class="info_content">
						<div class="info_left">
							<a data-toggle="modal" href="#uploadLogo"><img class="machine_logo" src="{if $info.machine_logo}{$info.machine_logo}{else}{$statics_url}images/click_upload.png{/if}" /></a>
							<div class="left_bottom">
								<a data-toggle="ajaxremove" data-msg='{t domain="printer"}您确定要关闭该小票机吗？{/t}' href='{RC_Uri::url("printer/mh_print/close", "id={$info.id}")}' title='{t domain="printer"}关闭{/t}'>
									<img class="close_img" src="{$statics_url}images/close.png" />
								</a>
								<a data-toggle="ajaxremove" data-msg='{t domain="printer"}您确定要重启该小票机吗？{/t}' href='{RC_Uri::url("printer/mh_print/restart", "id={$info.id}")}' title='{t domain="printer"}重启{/t}'>
									<img class="refresh_img" src="{$statics_url}images/refresh.png" />
								</a>
							</div>
						</div>
						
						<div class="info_right">
							<span class="name cursor_pointer merchant_printer" data-placement="bottom" data-trigger="editable" data-url="{RC_Uri::url('printer/mh_print/edit_machine_name')}" data-name="edit_machine_name" data-pk="{$info.id}" data-title='{t domain="printer"}请输入小票机名称{/t}'>{$info.machine_name}</span>
							<div class="right-item">{t domain="printer"}终端编号：{/t}{$info.machine_code}</div>
							<div class="right-item">{t domain="printer"}终端密钥：{/t}<span class="machine_key">{$info.machine_key_star}</span><span class="view_key" data-key="{$info.machine_key_star}" data-value="{$info.machine_key}"><i class="fontello-icon-eye"></i></span></div>
							<div class="right-item">{t domain="printer"}手机卡号：{/t}<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('printer/mh_print/edit_machine_mobile')}" data-name="edit_machine_mobile" data-pk="{$info.id}" data-title='{t domain="printer"}请输入手机卡号{/t}' data-emptytext='{t domain="printer"}暂无{/t}'>{$info.machine_mobile}</span></div>
							<div class="right-item">{t domain="printer"}打印机型：{/t}{$info.version}</div>
							<div class="right-item">{t domain="printer"}添加时间：{/t}{RC_Time::local_date('Y-m-d H:i:s', $info['add_time'])}</div>
						</div>
						
						<div class="info_status">
							{if $info.online_status eq 1}
		        			<span class="status">{t domain="printer"}在线{/t}</span>
		        			{else if $info.online_status eq 2}
		        			<span class="status">{t domain="printer"}缺纸{/t}</span>
		        			{else if $info.online_status eq 0}
		        			<span class="status error">{t domain="printer"}离线{/t}</span>
		        			{/if}
						</div>
					</div>
					<div class="info-content status merchant_printer">
						<div class="status-item">
							{if $info.online_status eq 1}
							<img src="{$statics_url}images/status/on-line.png" />
							{else}
							<img src="{$statics_url}images/status/not-no-line.png" />
							{/if}
                            {t domain="printer"}在线{/t}
						</div>
						<div class="status-item">
							{if $info.online_status eq 0}
							<img src="{$statics_url}images/status/off-line.png" />
							{else}
							<img src="{$statics_url}images/status/not-off-line.png" />
							{/if}
                            {t domain="printer"}离线{/t}
						</div>
						<div class="status-item">
							{if $info.online_status eq 2}
							<img src="{$statics_url}images/status/abnormal.png" />
							{else}
							<img src="{$statics_url}images/status/normal.png" />
							{/if}
                            {t domain="printer"}缺纸{/t}
						</div>
					</div>
				</div>
				
				<div class="printer_box voice_handle">
					<div class="title">{t domain="printer"}声音调节{/t}</div>
					<div class="info_content">
						<div class="voice_type">
							<span class="label_type">{t domain="printer"}响铃类型{/t}</span>
							<div class="switch info-toggle-button" data-url="{$control_url}">
				                <input type="checkbox" {if $info.voice_type eq 'buzzer'}checked value="buzzer"{else}value="horn"{/if} name="voice_type" class="onoffswitch-checkbox" id="voice_type">
				                <label class="onoffswitch-label" for="voice_type">
				                    <span class="onoffswitch-inner"></span>
				                    <span class="onoffswitch-switch"></span>
				                </label>
				            </div>
			            </div>
						<div class="voice-item">{t domain="printer"}音量调节{/t}<span class="voice_value">{$info.voice}</span></div>
						<div id="voice-slider"></div>
					</div>
				</div>
				
				<div class="printer_box printer_control">
					<div class="title">{t domain="printer"}打印控制{/t}</div>
					<div class="info_content">
						<a class="btn btn-primary" data-toggle="ajaxremove" data-msg='{t domain="printer"}您确定要取消所有未打印吗？{/t}' href='{RC_Uri::url("printer/mh_print/cancel", "id={$info.id}")}'>{t domain="printer"}取消所有未打印{/t}</a>
						<div class="help-block">{t domain="printer"}取消后，此台小票机设备将不再打印剩下的所有订单{/t}</div>
						<a class="btn btn-primary m_t10" data-toggle="modal" href="#testPrint">{t domain="printer"}打印测试{/t}</a>
						<div class="help-block">{t domain="printer"}点击打印后可测试此台小票机是否可用{/t}</div>
					
						<div class="content-item">
							<span class="label_type">{t domain="printer"}按键打印{/t}</span>
							<div class="switch info-toggle-print-type" data-url="{$print_type_url}">
				                <input type="checkbox" {if $info.print_type eq 'btnopen'}checked value="btnopen"{else}value="btnclose"{/if} name="print_type" class="onoffswitch-checkbox" id="print_type">
				                <label class="onoffswitch-label" for="print_type">
				                    <span class="onoffswitch-inner"></span>
				                    <span class="onoffswitch-switch"></span>
				                </label>
				            </div>
			            </div>
			            <div class="content-item">
							<span class="label_type">{t domain="printer"}订单确认{/t}</span>
							<div class="switch info-toggle-getorder" data-url="{$getorder_url}">
				                <input type="checkbox" {if $info.getorder eq 'open'}checked value="open"{else}value="close"{/if} name="getorder" class="onoffswitch-checkbox" id="getorder">
				                <label class="onoffswitch-label" for="getorder">
				                    <span class="onoffswitch-inner"></span>
				                    <span class="onoffswitch-switch"></span>
				                </label>
				            </div>
			            </div>
					</div>
				</div>
				
				<div class="printer_box print_stats">
					<div class="title">{t domain="printer"}打印统计{/t}</div>
					<div class="stats_content">
						<div class="stats-item">
							<div class="item-li"><img src="{$statics_url}images/week_print.png" /></div>
							<div class="item-li count">{if $count.week_count}{$count.week_count}{else}0{/if}</div>
							<div class="item-li name">{t domain="printer"}本周打印量{/t}</div>
						</div>
						<div class="stats-item">
							<div class="item-li"><img src="{$statics_url}images/today_print.png" /></div>
							<div class="item-li count">{if $count.today_print_count}{$count.today_print_count}{else}0{/if}</div>
							<div class="item-li name">{t domain="printer"}今日打印量{/t}</div>
						</div>
						<div class="stats-item">
							<div class="item-li"><img src="{$statics_url}images/unprint.png" /></div>
							<div class="item-li count">{if $count.today_unprint_count}{$count.today_unprint_count}{else}0{/if}</div>
							<div class="item-li name">{t domain="printer"}今日未打印量{/t}</div>
						</div>
					</div>
				</div>
			</div>
	    </div>
    </div>
</div>

<div class="modal fade" id="uploadLogo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>{t domain="printer"}上传LOGO{/t}</h3>
			</div>
			<div class="modal-body form-horizontal">
				<form class="form-horizontal" method="post" name="theForm" action="{url path='printer/mh_print/upload_logo'}">
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="printer"}上传LOGO：{/t}</label>
						<div class="col-lg-8">
							<div class="fileupload fileupload-{if $info.machine_logo}exists{else}new{/if}" data-provides="fileupload">
		                        {if $info.machine_logo}
		                        <div class="fileupload-{if $info.machine_logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
		                            <img src="{$info.machine_logo}" style="width:50px; height:50px;"/>
		                        </div>
		                        {/if}
		                        <div class="fileupload-preview fileupload-{if $info.machine_logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
		                        <span class="btn btn-primary btn-file btn-sm">
		                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="printer"}浏览{/t}</span>
		                            <span class="fileupload-exists"> {t domain="printer"}修改{/t}</span>
		                            <input type="file" class="default" name="machine_logo" />
		                        </span>
		                        <a class="btn btn-danger btn-sm fileupload-exists {if $info.machine_logo}remove_logo{/if}" {if $info.machine_logo}data-toggle="ajaxremove" data-msg='{t domain="printer"}您确定要删除该小票机logo吗？{/t}' {else}data-dismiss="fileupload"{/if} data-href='{url path='printer/mh_print/del_file' args="id={$info.id}"}' >{t domain="printer"}删除{/t}</a>
		                    </div>
		                    <span class="help-block">{t domain="printer"}推荐图片宽高200px，不超过350px，文件大小不超过40kb{/t}</span>
						</div>
					</div>
					<div class="form-group t_c">
						<button class="btn btn-primary" type="submit">{t domain="printer"}确定{/t}</button>
						<input type="hidden" name="id" value="{$info.id}"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="testPrint">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>{t domain="printer"}打印测试{/t}</h3>
			</div>
			<div class="modal-body form-horizontal">
				<form class="form-horizontal" method="post" name="testForm" action="{url path='printer/mh_print/printer_test'}">
					
					<div class="form-group">
						<label>{t domain="printer"}打印份数：{/t}</label>
						<div>
							<input class="form-control" type="text" name="print_number" placeholder='{t domain="printer"}请输入打印份数{/t}' value="1"/>
							<span class="help-block">{t domain="printer"}请输入1-9的整数，其他内容无效{/t}</span>
						</div>
					</div>
						
					<div class="form-group">
						<textarea name="content" class="test_textarea form-control" placeholder='{t domain="printer"}请输入要打印的内容{/t}'></textarea>
						<span class="help-block">{t domain="printer"}点击打印后可测试此台小票机是否可用{/t}</span>
					</div>
					<div class="t_c m_t10">
						<button class="btn btn-primary" type="submit">{t domain="printer"}确定{/t}</button>
						<input type="hidden" name="id" value="{$info.id}"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->