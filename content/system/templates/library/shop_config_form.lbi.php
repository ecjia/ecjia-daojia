<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="control-group formSep">
	<label class="control-label">{$var.name}：</label>
	<div class="controls">
		<!-- {if $var.type eq "text"} -->
		<input class="w350" type="text" name="value[{$var.id}]" id="value[{$var.id}]" value="{$var.value}" />
		<!-- {elseif $var.type eq "password"} -->
		<input class="w350" type="password" name="value[{$var.id}]" value="{$var.value}" />
		<!-- {elseif $var.type eq "textarea"} -->
		<textarea class="w350" name="value[{$var.id}]" cols="40" rows="5">{$var.value}</textarea>
		<!-- {elseif $var.type eq "select"} -->
		<!-- {foreach from=$var.store_options key=k item=opt} -->
		<label class="p_r10 ecjiafd-inline" for="value_{$var.id}_{$k}">
			<input type="radio" name="value[{$var.id}]" id="value_{$var.code}_{$k}" value="{$opt}" {if $var.value eq $opt}checked="checked"{/if} />{$var.display_options[$k]}
		</label>
		<!-- {/foreach} -->
		<!-- {elseif $var.type eq "open_radio"} -->
		<div class="warning-toggle-button" data-toggleButton-transitionspeed="300%">
		<input class="nouniform" type="checkbox" name="value[{$var.id}]" value="1" 
			{if $var.value}checked="checked"{/if} 
			{foreach from=$var.store_options key=k item=opt}
			{if $k eq '1'}
			data-on="{$var.display_options[$k]}"
			{else}
			data-off="{$var.display_options[$k]}"
			{/if}
			{/foreach}
			/>
			<input type="hidden" {if $var.value neq '1'}name="value[{$var.id}]"{/if} value="0" />
		</div>
		<!-- {elseif $var.type eq "options"} -->
		<select class="w350" name="value[{$var.id}]" id="value_{$var.id}_{$key}">
			<!-- {html_options options=$cfg_range_lang[$var.code] selected=$var.value} -->
		</select>
		<!-- {elseif $var.type eq "file"} -->
		<div class="fileupload {if $var.value}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
			<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
				<!-- {if $var.code eq 'icp_file'} -->
				<a href="{$var.value}">{$var.file_name}</a>
				<!-- {else} -->
				<img src="{$var.value}" alt="{t}暂无图片{/t}" />
				<!-- {/if} -->
			</div>
			<span class="btn btn-file">
				<span class="fileupload-new">{t}浏览{/t}</span>
				<span class="fileupload-exists">{t}修改{/t}</span>
				<input type="file" name="{$var.code}"/>
			</span>
			<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除此文件吗？{/t}" data-href="{RC_Uri::url('@shop_config/del',"code={$var.code}")}" {if $var.value}data-removefile="true"{/if}>{t}删除{/t}</a>
		</div>
		<!-- {/if} -->
		<!-- {if $var.desc} -->
		<span class="help-block" id="notice{$var.code}">{$var.desc|nl2br}</span>
		<!-- {/if} -->
	</div>
</div>
