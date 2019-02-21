<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

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
    <div class="col-lg-12">
        <div class="bar">
            <div class="step-bar">
                <div class="step_{$step}"></div>
            </div>
            <ul class="step">
                <li>
                    <span>1</span>
                    <p>{t domain="merchant"}提交申请{/t}</p>
                </li>
                <li>
                    <span>2</span>
                    <p>{t domain="merchant"}等待审核{/t}</p>
                </li>
                <li>
                    <span>3</span>
                    <p>{t domain="merchant"}审核状态{/t}</p>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <section class="panel">
        <div class="panel-body">
            <div class="status">
                <div class="error">
                    <div class="line"></div>
                </div>
                <div class="error-title">
                    <h3>{t domain="merchant"}审核未通过{/t}</h3>
                </div>
                <a class="btn btn-info" data-toggle="modal" href="#logs">{t domain="merchant"}查看审核日志{/t}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-info data-pjax" href="{url path='merchant/mh_franchisee/request_edit' args="step=1"}">{t domain="merchant"}再次申请修改{/t}</a>
            </div>
        </div>
    </section>

    <div class="modal fade" id="logs">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">{t domain="merchant"}审核日志{/t}</h4>
                </div>
                <div class="modal-body">
                    <ul class="error-logs">
                        <!-- {foreach from=$logs item=rs} -->
                        <li>{$rs}</li>
                        <!-- {/foreach} -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">{t domain="merchant"}关闭{/t}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
