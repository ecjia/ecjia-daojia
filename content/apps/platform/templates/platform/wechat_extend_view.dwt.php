<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="card-body">
				<div class="highlight_box global icon_wrap group" id="js_apply_btn">
					{if !$bd}
						<a class="btn btn-success btn-min-width f_r extend_handle" data-msg='{t domain="platform"}开通该插件将添加该插件的默认命令为关键词命令，您确定要执行该操作吗？{/t}' href="{RC_Uri::url('platform/platform_extend/wechat_extend_insert')}" data-code="{$info.ext_code}">{t domain="platform"}开通{/t}</a>
					{else}
						<a class="btn btn-danger btn-min-width f_r extend_handle" data-msg='{t domain="platform"}关闭该插件将删除该插件相关的关键词命令，您确定要执行该操作吗？{/t}' href="{RC_Uri::url('platform/platform_extend/wechat_extend_remove')}" data-code="{$info.ext_code}">{t domain="platform"}关闭{/t}</a>
					{/if}
					<div class="fonticon-container">
						<div class="fonticon-wrap">
							<img class="icon-extend" src="{if $info.icon}{$info.icon}{else}{$images_url}extend.png{/if}" />
						</div>
					</div>
					<h4 class="title">{$info.ext_name}</h4>
					<p class="desc" id="js_status">
					{if !$bd}<span>{t domain="platform"}未开通{/t}</span>{else}{t domain="platform"}该功能已通过申请，可正常使用{/t}{/if}
					</p>
				</div>
				<div class="carkticket_index">
					<div class="intro">
						<dl>
							<dt><span class="ico_intro ico ico_1 l"></span>
								<h4 class="card-title">{t domain="platform"}功能介绍{/t}</h4>
							</dt>
							<dd>{$info.ext_desc}</dd>
						</dl>
					</div>
				</div>

				{if $default_commands}
				<div class="carkticket_index m_t20">
					<div class="intro">
						<dl>
							<dt><span class="ico_intro ico ico_1 l"></span>
								<h4 class="card-title">{t domain="platform"}插件默认命令{/t}</h4>
							</dt>
							<dd>
							<!-- {foreach from=$default_commands item=val name=v} -->
							<span>{$val}{if !$smarty.foreach.v.last}、{/if}</span>
							<!-- {/foreach} -->
							</dd>
						</dl>
					</div>
				</div>
				{/if}

				{if $sub_codes}
				<div class="carkticket_index m_t20">
					<div class="intro">
						<dl>
							<dt><span class="ico_intro ico ico_1 l"></span>
								<h4 class="card-title">{t domain="platform"}插件子命令{/t}</h4>
							</dt>
							<dd>
							<!-- {foreach from=$sub_codes item=val name=v} -->
							<span> {$val}{if !$smarty.foreach.v.last}、{/if}</span>
							<!-- {/foreach} -->
							</dd>
						</dl>
					</div>
				</div>
				{/if}

            </div>
        </div>
    </div>
</div>

{if $bd}
<div class="row">
    <div class="col-12">
        <div class="card">
       		<div class="card-header">
                <h4 class="card-title">
                    {t domain="platform"}插件配置{/t}
                </h4>
            </div>
        	<div class="card-body">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						{if $bd.ext_config}
						<div class="form-body">
							<!-- {foreach from=$bd.ext_config item=config key=key} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{$config.label}</label>
								<div class="col-lg-6 controls">
									<!-- {if $config.type == "text"} -->
									<input class="form-control" id="cfg_value[]" name="cfg_value[]" type="{$config.type}" value="{$config.value}" size="40" />
									<!-- {elseif $config.type == "textarea"} -->
									<textarea class="form-control" id="cfg_value[]" name="cfg_value[]" cols="80" rows="5">{$config.value}</textarea>
									<!-- {elseif $config.type == "select"} -->
									<select class="select2 form-control" id="cfg_value[]" name="cfg_value[]"  >
										<!-- {html_options options=$config.range selected=$config.value} -->
									</select>
									<!-- {elseif $config.type == "radiobox"} -->
									<!-- {foreach from=$config.range item=val key=k} -->
										<input id="radio_{$k}" type="radio" name="cfg_value[]" value="{$k}" {if $config.value eq $k} checked="true" {/if}/><label for="radio_{$k}">{$val}</label>
									<!-- {/foreach} -->
									<!-- {/if} -->
									<input name="cfg_name[]" type="hidden" value="{$config.name}" />
									<input name="cfg_type[]" type="hidden" value="{$config.type}" />
									<input name="cfg_lang[]" type="hidden" value="{$config.lang}" />
									{if $config.desc}
		    						<div class="help-block">{$config.desc}</div>
		    						{/if}
									<!--the tenpay code -->
								</div>
							</div>
							<!-- {/foreach} -->
						</div>
						{else}
						<div class="text-center">{t domain="platform"}该插件暂无配置{/t}</div>
						{/if}
					</div>
					{if $bd.ext_config}
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="ext_code" value="{$bd.ext_code}" />
						<input type="submit" class="btn btn-outline-primary" value='{t domain="platform"}更新{/t}'/>
					</div>
					{/if}
				</form>
			</div>
		</div>
	</div>
</div>
{/if}

<!-- {/block} -->
