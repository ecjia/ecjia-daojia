<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>当前操作：<span class="action_title">编辑经营城市</span></h3>
</div>
<div class="modal-body" style="height:350px;">
    <form class="form-horizontal" name="Form" method="post" action="{url path='store/admin_store_business_city/update'}">
        <div class="control-group formSep">
            <label class="control-label control-label-new">城市名：</label>
            <div class="controls">
                <span class="parent_name">{$business_city.business_city_name}</span>
            </div>
        </div>
        <div class="control-group formSep">
            <label class="control-label">城市别名：</label>
            <div class="controls">
                <input class="span4" name="business_city_alias" type="text" value="{$business_city.business_city_alias}" />
            </div>
        </div>
        <div class="control-group formSep">
            <label class="control-label">索引首字母：</label>
            <div class="controls">
                <input class="span4" name="index_letter" type="text" value="{$business_city.index_letter}" />
                <span class="help-block">{t}城市名第一个字的拼音首字母{/t}</span>
            </div>
        </div>
        <div class="control-group t_c">
            <button class="btn btn-gebo" type="submit">确定</button>
            <input name="city_id" type="hidden" value="{$business_city.business_city}" />
        </div>
    </form>
</div>