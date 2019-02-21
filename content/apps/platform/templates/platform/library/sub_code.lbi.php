<div class="col-md-4 p_l0 p_r0">
    <select name="sub_code[]" class="select2 form-control">
        <option value="">{t domain="platform"}空子命令（默认）{/t}</option>
        <!-- {foreach from=$sub_code item=val} -->
        <option value="{$val}">{$val}</option>
        <!-- {/foreach} -->
    </select>
</div>