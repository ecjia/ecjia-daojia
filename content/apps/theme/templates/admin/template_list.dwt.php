<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var StyleSelected = '{$curr_tpl_style}';
	ecjia.admin.admin_template.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		{t domain="theme"}当前主题{/t}
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" name="theForm" method="post">
			<fieldset>
				<div class="row-fluid showview">
					<div class="left control-group">
                        <div class="thumbnail">
                            <img id="screenshot" src="{if $curr_template.screenshot}{$curr_template.screenshot}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}"/>
                        </div>
					</div>
					<div class="right wookmark control-group">
						{if $curr_template.name}
						<div class="control-group formSep">
						    <h4 id="templateName">{$curr_template.name} <small id="templateVersion" class="text-muted">(Version{$curr_template.version})</small></h4>
						</div>
						<div class="control-group">
                            <p>{t domain="theme"}模板来源：{/t}<a href="{$curr_template.uri}" target="_blank">{$curr_template.uri}</a></p>
                        </div>
						<div class="control-group">
                            <p><span class="template_author" id="templateAuthor">{t domain="theme"}模板作者：{/t}<a href="{$curr_template.author_uri}" target="_blank">{$curr_template.author}</a></span></p>
                        </div>
                        {if $curr_template_styles|@count gt 1 }
						<div class="control-group">
                            <p class="tmpstyle">{t domain="theme"}风格选择：{/t}
                            <!-- {foreach from=$curr_template_styles item=style} -->
                            <i{if $curr_template.stylename eq $style.stylename} class="active"{/if} style="background: {if $style.color}{$style.color}{else}#cccccc{/if};" value='{$style.stylename}' data-toggle="setupTemplateFG" data-tplcode="{$style.code}" data-style="{$style.stylename}"></i>
                            <!-- {/foreach} -->
                            </p>
                        </div>
                        {/if}
						<div class="control-group">
                            <p>{t domain="theme"}主题描述：{/t}<span id="templateDesc">{$curr_template.desc}</span></p>
                        </div>
						{else}
						<div class="control-group formSep">
						    <h4 class="color-999"><i class="fontello-icon-attention"></i>{t domain="theme"}未选择任何主题{/t}</h4>
						</div>
						{/if}
					</div>
				</div>
				<h3 class="heading">{t domain="theme"}可用主题{/t}<span class="f_s14 stop_color">{t domain="theme" escape=no 1=$available_templates_count}（共有 <strong class="ok_color">%1</strong> 套可用主题）{/t}</span></h3>
				<div class="control-group">
					<div class="wookmark">
						<ul>
							<!-- {foreach from=$available_templates item=template} -->
							<li class="thumbnail{if $curr_template.name eq $template.name} active{/if}">
								<a href="javascript:;" class="thumbnail_img" id="{$template.code}" data-toggle="setupTemplate" data-tplcode="{$template.code}">{if $template.screenshot}<img src="{$template.screenshot}" border="0" />{/if}</a>
								<p class="ecjiaf-toe">
                                    <a href="javascript:;" id="{$template.code}" data-toggle="setupTemplate" data-tplcode="{$template.code}" target="_blank">{$template.name}</a>
                                </p>
								<p class="ecjiaf-toe tmpstyle">
                                    <a href="{$template.uri}"><i class="fontello-icon-user" title='{t domain="theme"}作者信息{/t}'></i>&nbsp;&nbsp;{$template.author}</a>
								</p>
								<p class="ecjiaf-toe">
                                    {$template.desc}
                                </p>
								<p class="ecjiaf-toe tmpstyle">
									{foreach name=foo1 from=$template_style[$template.code] item=style}
									{if $smarty.foreach.foo1.total gt 1}
									<i style="background: {if $style.color}{$style.color}{else}#cccccc{/if};" value='{$style.stylename}' data-toggle="setupTemplateFG" data-tplcode="{$template.code}" data-style="{$style.stylename}"></i>
                                    {else}
                                    &nbsp;
                                    {/if}
									{/foreach}
								</p>
							</li>
							<!-- {foreachelse} -->
							<label class="t_l">{t domain="theme"}暂无可用主题{/t}</label>
							<!-- {/foreach} -->
						</ul>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->
