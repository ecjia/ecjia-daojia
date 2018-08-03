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
				<form class="form" method="post" name="editForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='platform::platform.lable_platform_name'}</label>
								<div class="col-lg-8 controls">{$name}</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='platform::platform.lable_plug_name'}</label>
								<div class="col-lg-8 controls">{$bd.ext_name}</div>
							</div>
							
							<!-- {foreach from=$bd.ext_config item=config key=key} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{$config.label}</label>
								<div class="col-lg-8 controls">
									<!-- {if $config.type == "text"} -->
									<input class="w350" name="cfg_value[]" type="{$config.type}" value="{$config.value}" size="40" />
									<span class="help-block">{$config.desc}</span>
									<!-- {elseif $config.type == "textarea"} -->
									<textarea class="w350 select2 form-control" name="cfg_value[]" cols="80" rows="5">{$config.value}</textarea>
									<span class="help-block">{$config.desc}</span>
									<!-- {elseif $config.type == "select"} -->
									<select class="w350"   name="cfg_value[]"  >
										<!-- {html_options options=$config.range selected=$config.value} -->
									</select>
									<!-- {elseif $config.type == "radiobox"} -->
									<!-- {foreach from=$config.range item=val key=k} -->
										<input type="radio" name="cfg_value[]" value="{$k}" {if $config.value eq $k} checked="true" {/if}/>{$val}
									<!-- {/foreach} -->
									<!-- {/if} -->
									<input name="cfg_name[]" type="hidden" value="{$config.name}" />
									<input name="cfg_type[]" type="hidden" value="{$config.type}" />
									<input name="cfg_lang[]" type="hidden" value="{$config.lang}" />
								</div>
							</div>
							<!-- {/foreach} -->
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<button class="btn btn-outline-primary" type="submit">{lang key='platform::platform.update'}</button>
						<input type="hidden" name="account_id" value="{$bd.account_id}" />
						<input type="hidden" name="ext_code" value="{$bd.ext_code}" />
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->