<?php defined('IN_ECJIA') or exit('No permission resources.');?>

{if $user_bank_card.bank_type eq 'bank'}
<div class="control-group formSep">
    <label class="control-label">{t domain="withdraw"}银行卡号：{/t}</label>
    <div class="controls l_h30">{$user_bank_card.bank_name} <strong>( {$user_bank_card.bank_card} )</strong></div>
</div>
{else if $user_bank_card.bank_type eq 'wechat'}
<div class="control-group formSep">
    <label class="control-label">{t domain="withdraw"}微信钱包：{/t}</label>
    <div class="controls l_h30">{$user_bank_card.bank_name} <strong>( {$user_bank_card.cardholder} )</strong></div>
</div>
{/if}

<input type="hidden" name="bank_name" value="{$user_bank_card.bank_name}" />
<input type="hidden" name="bank_branch_name" value="{$user_bank_card.bank_branch_name}" />
<input type="hidden" name="bank_card" value="{$user_bank_card.bank_card}" />
<input type="hidden" name="cardholder" value="{$user_bank_card.cardholder}" />
<input type="hidden" name="bank_en_short" value="{$user_bank_card.bank_en_short}" />