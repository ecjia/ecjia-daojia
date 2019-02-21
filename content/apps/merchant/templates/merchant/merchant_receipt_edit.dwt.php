<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.merchant_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<style media="screen">
    .form-group{
        margin-bottom: 0;
    }
</style>
<div class="row">
	<div class="col-lg-12 col-md-8 col-xs-12">
        <section class="panel">
            <div class="panel-body">
                <form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post">
                    <table class="table table-th-block">
                        <tbody>
                            <tr>
                                <td class="active w200">{t domain="merchant"}收款银行：{/t}</td>
                                <td>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <input class="form-control required" type="text" name="bank_name" value="{$data.bank_name}">
                                        </div>
                                        <span class="input-must">
                                            <span class="input-must">*</span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="active">{t domain="merchant"}银行账号：{/t}</td>
                                <td>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <input class="form-control required" type="text" name="bank_account_number" value="{$data.bank_account_number}">
                                        </div>
                                        <span class="input-must">
                                            <span class="input-must">*</span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="active">{t domain="merchant"}账户名称：{/t}</td>
                                <td>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <input class="form-control required" type="text" name="bank_account_name" value="{$data.bank_account_name}">
                                        </div>
                                        <span class="input-must">
                                            <span class="input-must">*</span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="active">{t domain="merchant"}开户银行支行名称：{/t}</td>
                                <td>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <input class="form-control required" type="text" name="bank_branch_name" value="{$data.bank_branch_name}">
                                        </div>
                                        <span class="input-must">
                                            <span class="input-must">*</span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="active">{t domain="merchant"}开户银行支行地址：{/t}</td>
                                <td>
                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <input class="form-control required" type="text" name="bank_address" value="{$data.bank_address}">
                                        </div>
                                        <span class="input-must">
                                            <span class="input-must">*</span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-info" type="submit" name="name" value='{t domain="merchant"}更新{/t}'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
