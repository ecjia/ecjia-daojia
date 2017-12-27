<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
        <a class="btn plus_or_reply toggle_view" id="sticky_a" href='{url path="printer/admin_store_printer/get_print_status" args="id={$info.id}&store_id={$info.store_id}"}'>刷新小票机状态</a>
    </h3>
</div>

<div class="row-fluid m_b20">
    <div class="span12 admin_printer">
		<div class="printer_box basic_info">
			<div class="title">基本信息</div>
			<div class="info_content">
				<div class="info_left">
					<a data-toggle="modal" href="#uploadLogo"><img class="machine_logo" src="{if $info.machine_logo}{$info.machine_logo}{else}{$statics_url}images/click_upload.png{/if}" /></a>
					<div class="left_bottom">
						<a data-toggle="ajaxremove" data-msg="您确定要关闭该小票机吗？" href='{RC_Uri::url("printer/admin_store_printer/close", "id={$info.id}&store_id={$info.store_id}")}' title="关闭">
							<img class="close_img" src="{$statics_url}images/close.png" />
						</a>
						<a data-toggle="ajaxremove" data-msg="您确定要重启该小票机吗？" href='{RC_Uri::url("printer/admin_store_printer/restart", "id={$info.id}&store_id={$info.store_id}")}' title="重启">
							<img class="refresh_img" src="{$statics_url}images/refresh.png" />
						</a>
					</div>
				</div>
				
				<div class="info_right">
					<span class="name cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('printer/admin_store_printer/edit_machine_name')}" data-name="edit_machine_name" data-pk="{$info.id}" data-title="请输入小票机名称">{$info.machine_name}</span>
					<div class="right-item">终端编号：{$info.machine_code}</div>
					<div class="right-item">终端密钥：<span class="machine_key">{$info.machine_key_star}</span><span class="view_key" data-key="{$info.machine_key_star}" data-value="{$info.machine_key}"><i class="fontello-icon-eye"></i></span></div>
					<div class="right-item">手机卡号：<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('printer/admin_store_printer/edit_machine_mobile')}" data-name="edit_machine_mobile" data-pk="{$info.id}" data-title="请输入手机卡号" data-emptytext="暂无">{if $info.machine_mobile}{$info.machine_mobile}{/if}</span></div>
					<div class="right-item">打印机型：{$info.version}</div>
					<div class="right-item">添加时间：{RC_Time::local_date('Y-m-d H:i:s', $info['add_time'])}</div>
				</div>
				
				<div class="info_status">
					{if $info.online_status eq 1}
        			<span class="status">在线</span>
        			{else if $info.online_status eq 2}
        			<span class="status error">缺纸</span>
        			{else if $info.online_status eq 0}
        			<span class="status error">离线</span>
        			{/if}
				</div>
			</div>
			<div class="info-content status">
				<div class="status-item">
					{if $info.online_status eq 1}
					<img src="{$statics_url}images/status/on-line.png" />
					{else}
					<img src="{$statics_url}images/status/not-no-line.png" />
					{/if}
					在线
				</div>
				<div class="status-item">
					{if $info.online_status eq 0}
					<img src="{$statics_url}images/status/off-line.png" />
					{else}
					<img src="{$statics_url}images/status/not-off-line.png" />
					{/if}
					离线
				</div>
				<div class="status-item">
					{if $info.online_status eq 2}
					<img src="{$statics_url}images/status/abnormal.png" />
					{else}
					<img src="{$statics_url}images/status/normal.png" />
					{/if}
					缺纸
				</div>
			</div>
		</div>
		
		<div class="printer_box voice_handle">
			<div class="title">声音调节</div>
			<div class="info_content">
				<div class="voice_type">
					<span class="label_type">响铃类型</span>
		            <div class="info-toggle-button" data-url="{$control_url}">
		                <input class="nouniform" name="voice_type" type="checkbox" {if $info.voice_type eq 'buzzer'}checked{/if} value="{$info.voice_type}"/>
		            </div>
	            </div>
				<div class="voice-item">音量调节<span class="voice_value">{$info.voice}</span></div>
				<div id="voice-slider" class="voice-slider-handle"></div>
			</div>
		</div>
		
		<div class="printer_box printer_control">
			<div class="title">打印控制</div>
			<div class="info_content">
				<a class="btn btn-info" data-toggle="ajaxremove" data-msg="您确定要取消所有未打印吗？" href='{RC_Uri::url("printer/admin_store_printer/cancel", "id={$info.id}&store_id={$info.store_id}")}'>取消所有未打印</a>
				<div class="help-block m_b10">取消后，此台小票机设备将不再打印剩下的所有订单</div>
				<a class="btn btn-info m_t10" data-toggle="modal" href="#testPrint">打印测试</a>
				<div class="help-block m_b10">点击打印后可测试此台小票机是否可用</div>
				
				<div class="content-item">
					<span class="label_type">按键打印</span>
		            <div class="info-toggle-print-type" data-url="{$print_type_url}">
		                <input class="nouniform" name="print_type" type="checkbox" {if $info.print_type eq 'btnopen'}checked{/if} value="{$info.print_type}"/>
		            </div>
	            </div>
	            <div class="content-item">
					<span class="label_type">订单确认</span>
		            <div class="info-toggle-getorder" data-url="{$getorder_url}">
		                <input class="nouniform" name="getorder" type="checkbox" {if $info.getorder eq 'open'}checked{/if} value="{$info.getorder}"/>
		            </div>
	            </div>
			</div>
		</div>
		
		<div class="printer_box print_stats">
			<div class="title">打印统计</div>
			<div class="stats_content">
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/week_print.png" /></div>
					<div class="item-li count">{$count.week_count}</div>
					<div class="item-li name">本周打印量</div>
				</div>
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/today_print.png" /></div>
					<div class="item-li count">{$count.today_print_count}</div>
					<div class="item-li name">今日打印量</div>
				</div>
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/unprint.png" /></div>
					<div class="item-li count">{$count.today_unprint_count}</div>
					<div class="item-li name">今日未打印量</div>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="modal hide fade" id="uploadLogo">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t}上传LOGO{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<form class="form-horizontal" method="post" name="theForm" action="{url path='printer/admin_store_printer/upload_logo'}">
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label">上传LOGO：</label>
							<div class="controls">
								<div class="fileupload {if $info.machine_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 80px; height: 80px; line-height: 80px;">
										{if $info.machine_logo}
										<img src="{$info.machine_logo}"/>
										{/if}
									</div>
									<span class="btn btn-file">
									<span class="fileupload-new">浏览</span>
									<span class="fileupload-exists">修改</span>
									<input type='file' name='machine_logo' />
									</span>
									<a class="btn fileupload-exists {if $info.machine_logo}remove_logo{/if}" {if !$info.machine_logo}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="您确定要删除该小票机logo吗？" href='{url path="printer/admin_store_printer/del_file" args="id={$info.id}&store_id={$info.store_id}"}' title="{lang key='system::system.drop'}"{/if}>删除</a>
								</div>
								<span class="help-block">推荐图片宽高200px，不超过350px，文件大小不超过40kb</span>
							</div>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
							<input type="hidden" name="store_id" value="{$info.store_id}"/>
							<input type="hidden" name="id" value="{$info.id}"/>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade" id="testPrint">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t}打印测试{/t}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<form class="form-horizontal" method="post" name="testForm" action="{url path='printer/admin_store_printer/printer_test'}">
					<fieldset>
						<div class="control-group">
							<label>打印份数：</label>
							<div>
								<input class="span12" type="text" name="print_number" placeholder="请输入打印份数" value="1"/>
								<span class="help-block">请输入1-9的整数，其他内容无效</span>
							</div>
						</div>
						<div class="control-group">
							<textarea name="content" class="span12 h150" placeholder="请输入要打印的内容"></textarea>
						</div>
						<div class="control-group t_c">
							<button class="btn btn-gebo" type="submit">{t}确定{/t}</button>
							<input type="hidden" name="store_id" value="{$info.store_id}"/>
							<input type="hidden" name="id" value="{$info.id}"/>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
	
<!-- {/block} -->