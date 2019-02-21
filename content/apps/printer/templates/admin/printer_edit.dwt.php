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
    </h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
		<form id="form-privilege" class="form-horizontal" name="theForm" method="post" action="{$form_action}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="printer"}打印机名称：{/t}</label>
					<div class="controls">
						<input type="text" name="machine_name" class="span6" placeholder='{t domain="printer"}请输入打印机名称{/t}' value="{$machine_name}" />
						<span class="input-must">*</span>
						<span class="help-block">{t domain="printer"}该名称只在打印机列表显示，便于管理员查找打印机{/t}</span>
					</div>
				</div>
								
				<div class="control-group formSep">
					<label class="control-label">{t domain="printer"}终端编号：{/t}</label>
					<div class="controls">
						<input type="text" name="machine_code" class="span6" placeholder='{t domain="printer"}请输入终端编号{/t}' />
						<span class="input-must">*</span>
						<span class="help-block">{t domain="printer"}请输入打印机设备上的终端编号{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="printer"}终端密钥：{/t}</label>
					<div class="controls">
						<input type="text" name="machine_key" class="span6" placeholder='{t domain="printer"}请输入终端密钥{/t}' />
						<span class="input-must">*</span>
						<span class="help-block">{t domain="printer"}请输入打印机设备上的终端密钥{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="printer"}手机卡号：{/t}</label>
					<div class="controls">
						<input type="text" name="machine_mobile" class="span6" placeholder='{t domain="printer"}请输入手机卡号{/t}' />
						<span class="help-block">{t domain="printer"}如果打印机设备上有放手机卡，请输入放在设备内的手机卡号{/t}</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<input class="btn btn-gebo" type="submit" value='{t domain="printer"}确定{/t}' />
					</div>
				</div>
			</fieldset>
		</form>
    </div>
</div>
<!-- {/block} -->