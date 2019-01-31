<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.activity.prize_init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-reply"></i>{$action_link.text}</a>{/if}
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="post" action="{$form_action}" name="listForm">
			<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
				<ul class="wookmark-ul">
					<!-- {foreach from=$data.item item=prize} -->
					<li class="thumbnail">
						<div class="prize_level_div">
							<div class="prize_level prize_level_{$prize.prize_level}">
								<div class="model-title ware_name">
									<span>
										{if $prize.prize_level eq '0'} [{t domain="market"}特等奖{/f}] {elseif $prize.prize_level eq '1'} [{t domain="market"}一等奖{/f}] {elseif $prize.prize_level eq '2'} [{t domain="market"}二等奖{/f}] {elseif
										$prize.prize_level eq '3'} [{t domain="market"}三等奖{/f}] {elseif $prize.prize_level eq '4'} [{t domain="market"}四等奖{/f}] {elseif $prize.prize_level eq '5'} [{t domain="market"}五等奖{/f}]
										{/if} {$prize.prize_name}
									</span>
									<br>
									<span>{t domain="market"}奖品内容：{/f}{$prize.prize_value_label}</span>
								</div>
								<p class="model-inner">
									<span class="f_l">{$prize.prize_number}&nbsp;/&nbsp;{$prize.prize_prob}%</span>
									<span class="f_r">
										{if $prize.prize_type eq '0'} {t domain="market"}未中奖{/f} {elseif $prize.prize_type eq '1'} {t domain="market"}礼券红包{/f} {elseif $prize.prize_type eq '2'} {t domain="market"}实物奖品{/f} {elseif $prize.prize_type
										eq '3'} {t domain="market"}送积分{/f} {elseif $prize.prize_type eq '4'} {t domain="market"}推荐商品{/f} {elseif $prize.prize_type eq '5'} {t domain="market"}推荐店铺{/t} {elseif $prize.prize_type
										eq '6'} {t domain="market"}现金红包{/f} {/if}
									</span>
								</p>
							</div>
						</div>

						<div class="input">
							<a class="data-pjax f_l p_l20" title='{t domain="market"}编辑{/t}' href='{RC_Uri::url("market/admin/activity_prize_edit", "code={$code}&p_id={$prize.prize_id}")}'>
								<i class="fontello-icon-edit"></i>
							</a>
							{if $prize.is_used eq 0}
							<a class="f_l ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="market"}您确定要删除该活动奖品池吗？{/t}' title='{t domain="market"}删除{/t}' href='{RC_Uri::url("market/admin/activity_prize_remove", "code={$code}&p_id={$prize.prize_id}")}'>
								<i class="fontello-icon-trash"></i>
							</a>
							{else}
							<span class="prize-used">{t domain="market"}使用中{/t}</span>
							{/if}
						</div>
					</li>
					<!-- {/foreach} -->
					{if $smarty.get.page eq $data.total_pages || !$smarty.get.page}
					<li class="thumbnail add-ware-house">
						<a class="more data-pjax" href='{RC_Uri::url("market/admin/activity_prize_add", "code={$code}")}'>
							<i class="fontello-icon-plus"></i>
						</a>
					</li>
					{/if}
				</ul>
				<!-- {$data.page} -->
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->