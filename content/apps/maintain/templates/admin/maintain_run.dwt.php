<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.maintain_run.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid">	
	<div class="span12">
		<fieldset title="" class="step" id="validate_wizard-step-0">
            <div class="control-group formSep" style="margin-top: 10px;">
                         工具名称：{$config.name}（{$config.code}）
            </div>
            <div class="control-group formSep priv_list">
			 工具描述：{$config.description}
            </div>
            <input type="hidden" name="code" value="{$config.code}"/>
	   		<a class="btn btn-inverse button-next"  href='{RC_Uri::url("maintain/admin/command_run")}' id="maintain_run"><span id="start">开始运行</span></a>
	    </fieldset>         
	</div>
</div>
<!-- {/block} -->