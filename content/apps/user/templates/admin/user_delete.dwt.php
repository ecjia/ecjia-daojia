<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>


<div class="row-fluid ecjia-delete-user">
	<div class="span12">
		<div class="form-horizontal">
			{if $count eq 0}
			<div class="alert alert-warning">
				<a class="close" data-dismiss="alert">×</a>
				<strong>
					<p>温馨提示</p>
				</strong>
				<p>当前账户没有关联数据，您可以直接删除此会员账户。</p>
			</div>
			{else}
				<!-- {foreach from=$handles item=val} -->
				<div class="control-group formSep">
					<label class="control-label">{$val->getName()}</label>
					<div class="controls p_t4">
						{$val->handlePrintData()}
						{if $val->handleCanRemove()}
						<span class="controls-info-right f_r">
							<a class="btn btn-gebo" data-toggle="ajaxremove" data-msg="您确定要这么做吗？" href="{RC_Uri::url('user/admin/remove_item')}&id={$id}&handle={$val->getCode()}">删除数据</a>
						</span>
						{/if}
					</div>
				</div>
				<!-- {/foreach} -->
			{/if}

			<div class="control-group">
				{if $delete_all}
				<a class="btn delete_confirm" data-msg="您确定要彻底删除该会员所有信息吗？" href="{RC_Uri::url('user/admin/remove_all')}&id={$id}">一键删除所有</a>
				{/if}

				<a class="btn btn-gebo delete_confirm m_l10" data-msg="您确定要彻底删除该会员吗？" href="{RC_Uri::url('user/admin/remove')}&id={$id}">删除会员</a>

				<div class="help-block">
					<p>注：一键删除：点击后，会将以上所有有关当前账号的数据全部删除，一旦删除后将不可恢复。</p>
					<p>删除会员：点击后，将当前会员账号彻底删除。</p>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- {/block} -->