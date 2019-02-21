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
<div class="row">
	<div class="col-lg-12 col-md-8 col-xs-12">
        <section class="panel">
            <div class="panel-body">
                <table class="table table-th-block">
                    <tbody>
                        <tr>
                            <td class="active w200">{t domain="merchant"}收款银行：{/t}</td>
                            <td>
								<!-- {if $data.bank_name} -->
								{$data.bank_name}
								<!-- {else} -->
								<i>< {t domain="merchant"}还未填写{/t} ></i>
								<!-- {/if} -->
							</td>
                        </tr>
                        <tr>
                            <td class="active">{t domain="merchant"}银行账号：{/t}</td>
                            <td>
								<!-- {if $data.bank_account_number} -->
								{$data.bank_account_number}
								<!-- {else} -->
								<i>< {t domain="merchant"}还未填写{/t} ></i>
								<!-- {/if} -->
							</td>
                        </tr>
                        <tr>
                            <td class="active">{t domain="merchant"}账户名称：{/t}</td>
                            <td>
								<!-- {if $data.bank_account_name} -->
								{$data.bank_account_name}
								<!-- {else} -->
								<i>< {t domain="merchant"}还未填写{/t} ></i>
								<!-- {/if} -->
							</td>
                        </tr>
                        <tr>
                            <td class="active">{t domain="merchant"}开户银行支行名称：{/t}</td>
                            <td>
								<!-- {if $data.bank_branch_name} -->
								{$data.bank_branch_name}
								<!-- {else} -->
								<i>< {t domain="merchant"}还未填写{/t} ></i>
								<!-- {/if} -->
							</td>
                        </tr>
                        <tr>
                            <td class="active">{t domain="merchant"}开户银行支行地址：{/t}</td>
                            <td>
								<!-- {if $data.bank_address} -->
								{$data.bank_address}
								<!-- {else} -->
								<i>< {t domain="merchant"}还未填写{/t} ></i>
								<!-- {/if} -->
							</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <a class="btn btn-info" href="{url path='merchant/mh_franchisee/receipt_edit'}">{t domain="merchant"}编辑{/t}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->