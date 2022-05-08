<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h3><span class="action_title">{t domain="store"}查看详情{/t}</span></h3>
</div>
<div class="modal-body">
	<div class="form-horizontal">
        <div class="row-fluid priv_list">
            <!-- {foreach $session_info as $key => $item} -->
            <div class="control-group formSep">
                <label class="control-label control-label-new">{$key}：</label>
                <div class="controls">
                    <span class="parent_name">{$item}</span>
                </div>
            </div>
            <!-- {foreachelse} -->
            <div class="control-group">
                <div class="controls">
                    <span class="parent_name">暂无记录！</span>
                </div>
            </div>
            <!-- {/foreach} -->
        </div>
	</div>
</div>