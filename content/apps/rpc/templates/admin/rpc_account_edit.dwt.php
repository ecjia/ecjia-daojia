<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} 
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data">
				<div class="tab-content">
					<fieldset>
						<div class="row-fluid edit-page">
							{if $account.id neq ''}
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}外部访问地址：{/t}</label>
								<div class="controls l_h30">
									<input class="w600" type="text" readonly value="{$url}" id="external_address" />&nbsp;&nbsp;
									<a class="btn copy-url-btn" href='javascript:;' data-clipboard-action="copy" data-clipboard-target="#external_address">复制URL</a>
								</div>
							</div>
							{/if}
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="rpc"}名称：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="name" id="name" value="{$account.name}" />
									<span class="input-must">*</span>
                                    <span class="help-block">{t domain="rpc"}给起一个名称，方便查看。{/t}</span>
								</div>
							</div>

                            {if $account.appid neq ''}
							<div class="control-group formSep">
								<label class="control-label">{t domain="rpc"}AppID：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="appid" id="appid" value="{$account.appid}" />
									<span class="input-must">*</span>
								</div>
							</div>

							<div class="control-group formSep">
								<label class="control-label">{t domain="rpc"}AppSecret：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="appsecret" id="appsecret" value="{$account.appsecret}" />
									<span class="input-must">*</span>
								</div>
							</div>

                            <div class="control-group formSep">
                                <label class="control-label">{t domain="rpc"}Password Hash：{/t}</label>
                                <div class="controls">
                                    <input class="w350" type="text" name="password_hash" id="password_hash" value="{password_hash($account.appsecret, PASSWORD_DEFAULT)}" disabled />
                                    <span class="help-block">{t domain="rpc"}这是经过password_hash函数加密过的密文，用于浏览器直接登录验证使用，每次刷新不同。{/t}</span>
                                </div>
                            </div>

                            <div class="control-group formSep">
                                <label class="control-label">{t domain="rpc"}回调地址：{/t}</label>
                                <div class="controls">
                                    <input class="w350" type="text" name="callback_url" id="callback_url" value="{$account.callback_url}" />
                                    <a class="toggle_view btn filter-btn" href='{url path="rpc/admin/test_connect"}' data-val="{$account.appid}">测试通信</a>
                                    <span class="help-block">
                                        {t domain="rpc"}回调地址，用于发送数据到对方网站，双向通信使用，没有则不填。{/t}<br/>
                                        {t domain="rpc"}点击测试通信，自动请求"test/connect"接口，检查获取应答响应。{/t}
                                    </span>
                                </div>
                            </div>
                            {/if}

                            {*
                            <div class="control-group formSep">
                                <label class="control-label">{t domain="rpc"}Token：{/t}</label>
                                <div class="controls">
                                    <input class="generate_token w350" type="text" name="token" id="token" value="{$account.token}" />&nbsp;&nbsp;
                                    <a class="toggle_view btn filter-btn" href='{url path="rpc/admin/generate_token"}'  data-val="allow">{t domain="rpc"}生成Token{/t}</a>&nbsp;&nbsp;
                                    <a class="btn copy-token-btn" href='javascript:;' data-clipboard-action="copy" data-clipboard-target="#token">{t domain="rpc"}复制Token{/t}</a>
                                    <span class="input-must">*</span>
                                    <span class="help-block">{t domain="rpc"}自定义的Token值，或者点击生成Token创建一个，复制到微信公众平台配置中{/t}</span>
                                </div>
                            </div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="platform"}EncodingAESKey：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="aeskey" id="aeskey" value="{$account.aeskey}" />
								</div>
							</div>
                            *}
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="rpc"}状态：{/t}</label>
								<div class="controls chk_radio">
                                    {if $account neq NULL}
									<input type="radio" name="status" value="1" {if $account.status eq 1}checked{/if}><span>{t domain="rpc"}开启{/t}</span>
                                    <input type="radio" name="status" value="0" {if $account.status eq 0}checked{/if}><span>{t domain="rpc"}关闭{/t}</span>
                                    {else}
                                    <input type="radio" name="status" value="1" checked><span>{t domain="rpc"}开启{/t}</span>
                                    <input type="radio" name="status" value="0"><span>{t domain="rpc"}关闭{/t}</span>
                                    {/if}
								</div>
							</div>

                            {if $account.sort neq null}
							<div class="control-group formSep">
								<label class="control-label">{t domain="rpc"}排序：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="sort" id="sort" value="{$account.sort|default:0}" />
								</div>
							</div>
                            {/if}
							
							<div class="control-group">
	        					<div class="controls">
	        						{if $account.id eq ''}
	        						<input type="submit" name="submit" value='{t domain="rpc"}确定{/t}' class="btn btn-gebo" />
	        						{else}
	        						<input type="submit" name="submit" value='{t domain="rpc"}更新{/t}' class="btn btn-gebo" />
	        						{/if}
									<input name="id" type="hidden" value="{$account.id}">
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->