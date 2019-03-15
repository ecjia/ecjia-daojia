<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>{t domain="store"}当前操作：{/t}<span class="action_title">{t domain="store"}编辑经营城市{/t}</span></h3>
</div>
<div class="modal-body" style="height:350px;">
    <form class="form-horizontal" name="Form" method="post" action="{url path='store/admin_store_business_city/update'}">
        <div class="control-group formSep">
            <label class="control-label control-label-new">{t domain="store"}城市名：{/t}</label>
            <div class="controls">
                <span class="parent_name">{$business_city.business_city_name}</span>
            </div>
        </div>
        <div class="control-group formSep">
            <label class="control-label">{t domain="store"}城市别名：{/t}</label>
            <div class="controls">
                <input class="span4" name="business_city_alias" type="text" value="{$business_city.business_city_alias}" />
            </div>
        </div>
        <div class="control-group formSep">
            <label class="control-label">{t domain="store"}索引首字母：{/t}</label>
            <div class="controls">
                <input class="span4" name="index_letter" type="text" value="{$business_city.index_letter}" />
                <span class="help-block">{t domain="store"}城市名第一个字的拼音首字母{/t}</span>
            </div>
        </div>
        <div class="control-group t_c">
            <button class="btn btn-gebo" type="submit">{t domain="store"}确定{/t}</button>
            <input name="city_id" type="hidden" value="{$business_city.business_city}" />
        </div>
    </form>
</div>