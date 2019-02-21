<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span3">
		<div class="setting-group">
	      <span class="setting-group-title"><i class="fontello-icon-cog"></i>{t domain="theme"}布局设置备份{/t}</span>
	        <ul class="nav nav-list m_t10">
	        	<li class="nav-header">备份</li>
				<li><a class="{if $action eq 'backup'}setting-group-item llv-active{else}setting-group-item{/if} data-pjax" href="{url path='theme/admin_layout_backup/init'}">备份布局设置</a></li>
				<li class="nav-header">还原</li>
				<li><a class="{if $action neq 'backup'}setting-group-item llv-active{else}setting-group-item{/if} data-pjax" href="{url path='theme/admin_layout_backup/restore'}">可使用的布局设置备份</a></li>
	     	</ul>
	    </div>
	</div>

	{if $action eq 'backup'}
	<div class="span9">
		<h3 class="heading">{t domain="theme"}备份布局设置{/t}</h3>
		<form class="form-horizontal" name="theForm" action="{$form_action}" method="post">
			<!-- {if $files} -->
				<div class="control-group formSep">
					<label style="float: left;text-align: right;width: 160px;">{t domain="theme"}选择模板：{/t}</label>
					<div style="margin-left: 145px;">
						<div class="checkall">
							<label class="cuni-checkbox" style="margin-left: 30px;">
								<input name="checkall" data-toggle="selectall" data-children=".checkbox" type="checkbox" value="checkbox" autocomplete="off" />{t domain="theme"}全选{/t}
							</label>
						</div>
						<!-- {foreach from=$files item=file key=key name=template} -->
						<div style="float: left;overflow: hidden;padding-left: 30px;width: 120px;">
							<label><input class="checkbox" type="checkbox" name="files[]" value="{$key}" id="{$priv_key}" /><!-- {$file} --></label>
						</div>
						<!-- {/foreach} -->
					</div>	
				</div>
			
				<div class="control-group formSep">
					<label class="control-label">{t domain="theme"}备份注释：{/t}</label>
					<div class="controls">
		 				<input type="text" name="remarks" size="40" />
						<span id="" class="help-block">请给备份模板添加名称，方便查找。</span>
					</div>	
				</div>
				
				<div class="control-group">
					<label class="control-label" for="user_name"></label>
					<div class="controls">
						<input class="btn" type="submit" value="{t domain="theme"}备份模板设置{/t}" />
					</div>
				</div>
			<!-- {else} -->
				<div class="control-group formSep">
					<label class="control-label" for="user_name">{t domain="theme"}没有可备份的布局设置{/t}</label>
				</div>
			<!-- {/if} -->
		</form>
	</div>
	{else}
	<div class="span9">
		<h3 class="heading">{t domain="theme"}可使用的布局设置备份{/t}</h3>
		<div id="wookmark" >
			<ul class="m_l0">
				<!-- {foreach from=$list item=remarks} -->
				<li class="thumbnail" style="margin-left:35px; margin-bottom:15px; width:200px;height:210px;" >
					<a><img src="{$screenshot}" border="0" style="width:200px;height:150px;"/></a>
					<p style="margin-top: 5px;">{$remarks.content}</p>
					<p style="margin-top: -5px;">
						<a href='{url path="theme/admin_layout_backup/restore_backup" args="remarks={$remarks.url}"}' title="{t domain="theme"}还原{/t}"><i class="fontello-icon-arrows-cw"></i>还原</a>
						<a href='{url path="theme/admin_layout_backup/delete" args="remarks={$remarks.url}"}' title="{t domain="theme"}删除{/t}" ><i class="fontello-icon-trash"></i>删除</a>
					</p>
				</li>
				<!-- {foreachelse} -->
				<label class="control-label" for="user_name">{t domain="theme"}没有可用布局备份{/t}</label>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
	{/if}
</div>
<!-- {/block} -->
