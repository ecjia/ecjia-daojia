<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.bill_update.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="commission"}温馨提示{/t}：</strong>{t domain="commission"}数据量较大情况会比较慢，请耐心等耐。{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $smarty.get.store_id && $smarty.get.refer neq 'store'} --><a class="btn plus_or_reply" href='{RC_Uri::url("commission/admin/day", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t domain="commission"}返回全部{/t}</a><!-- {/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="tab-content tab_merchants">
            <div class="tab-pane active " style="min-height:300px;">
            <form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                <fieldset>
                    <div class="control-group formSep">
                        <label class="control-label">{t domain="commission"}选择时间：{/t}</label>
                        <div class="controls">
                            <input class="form-control start_date" name="start_date" type="text" placeholder="{t domain="commission"}开始时间{/t}" value="{$smarty.get.start_date}">
                    <span class="">-</span>
                    <input class="form-control end_date" name="end_date" type="text" placeholder="{t domain="commission"}结束时间{/t}" value="{$smarty.get.end_date}">
                            <span class="input-must">*</span>
                        </div>
                    </div>
                    
                    {if 0}<div class="control-group formSep" >
                        <label class="control-label">{t domain="commission"}商家：{/t}</label>
                        <div class="controls">
                            <select name="store_cat">
                                <option value="0">{t domain="commission"}全部{/t}</option>
                                
                            </select>
                        </div>
                    </div>{/if}

                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden"  name="store_id" value="{$store.store_id}" />
                            <input type="hidden"  name="step" value="{$step}" />
                            <button class="btn btn-gebo" type="submit">{t domain="commission"}确定{/t}</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->