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
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
						{if $ext_code}
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="platform"}已选插件：{/t}</label>
								<div class="col-lg-7 controls">
									<!-- {foreach from=$extend_list item=list} -->
									{if $ext_code eq $list.ext_code}
									{$list.ext_name}
									{/if}
									<!-- {/foreach} -->
								</div>
							</div>
							<input type="hidden" name="ext_code" value="{$ext_code}">
							{else}
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="platform"}请选择插件：{/t}</label>
								<div class="col-lg-7 controls">
									<div class="row">
										<div class="col-md-11">
											<select name="ext_code" class="select2 form-control" data-url="{RC_Uri::Url('platform/platform_command/get_sub_code')}">
												<option value="">{t domain="platform"}请选择...{/t}</option>
												<!-- {foreach from=$extend_list item=list} -->
												<option value="{$list.ext_code}" {if $ext_code eq $list.ext_code}selected{/if}>{$list.ext_name}</option>
												<!-- {/foreach} -->
											</select>
										</div>
									</div>
								</div>
							</div>
							{/if}

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="platform"}关键词：{/t}</label>
								<div class="col-lg-7 controls">
									<!-- {foreach from=$data item=val key=key name=n} -->
									<div class="clone-input row m_b10">
										<div class="{if $sub_code}col-md-7{else}col-md-11{/if}"><input type="text" readonly class="form-control" value="{$val.cmd_word}" /></div>
										{if $sub_code}
										<div class="col-md-4 p_l0 p_r0">
											<select class="select2 form-control" disabled>
												<option>{if $val.sub_code}{$val.sub_code}{else}{t domain="platform"}空子命令（默认）{/t}{/if}</option>
											</select>
										</div>
										{/if}
										<label class="col-md-1">
											<a class="no-underline l_h35" data-toggle="ajaxremove" data-msg='{t domain="platform"}您确定要删除该关键词吗？{/t}' href='{RC_Uri::url("platform/platform_command/remove", "cmd_id={$val.cmd_id}")}'><i class="fa fa-minus"></i></a>
										</label>
									</div>
									<!-- {/foreach} -->
									<div class="clone-input row m_b10">
										<div class="{if $sub_code}col-md-7{else}col-md-11{/if} cmd_word"><input type="text" name="cmd_word[]" class="form-control"/></div>
										{if $sub_code}
										<div class="col-md-4 p_l0 p_r0">
											<select name="sub_code[]" class="select2 form-control">
												<option value="">{t domain="platform"}空子命令（默认）{/t}</option>
												<!-- {foreach from=$sub_code item=val} -->
												<option value="{$val}">{$val}</option>
												<!-- {/foreach} -->
											</select>
										</div>
										{/if}
										<label class="col-md-1">
											<a class="no-underline l_h35" data-toggle="clone-cmd" data-parent=".clone-input" href="javascript:;"><i class="fa fa-plus"></i></a>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<input type="submit" value='{t domain="platform"}确定{/t}' class="btn btn-outline-primary" />
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->