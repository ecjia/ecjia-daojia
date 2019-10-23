<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.affiliate.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
    <div class="alert alert-warnning">
        <a class="close" data-dismiss="alert">×</a>
        <strong><p>温馨提示：</p></strong>
        <p>1、邀请人将邀请链接分享给新人朋友，链接中，带有分享者独有的推荐码，新人朋友在有效推荐时间段内，成功完成注册，系统将会自动绑定其上下级关系。
            被邀请人之后产生的所有订单消费，邀请人都将获得相应分成奖励。</p>
    </div>
    <form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
        <div class="span12">

            <h3 class="heading">{t domain="affiliate"}分享设置{/t}</h3>
            <div class="control-group formSep formSep1">
                <label class="control-label">{t domain="affiliate"}推荐时效：{/t}</label>
                <div class="controls">
                    <input class="f_l" type="text" name="expire" maxlength="150" size="10" value="{$config.config.expire}"/>
                    <span class="f_l">&nbsp;</span>
                    <select class="w70" name="expire_unit">
                        <!--{html_options options=$unit selected=$config.config.expire_unit}-->
                    </select>
                    <div class="clear"></div>
                    <div class="help-block">{t domain="affiliate"}访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的。{/t}</div>
                </div>
            </div>
            <div class="control-group formSep formSep1">
                <label class="control-label">{t domain="affiliate"}分享内容：{/t}</label>
                <div class="controls">
                    <textarea name='invite_template' class="span7">{$invite_template}</textarea>
                </div>
            </div>

            <div class="control-group formSep formSep1">
                <label class="control-label">{t domain="affiliate"}邀请分享说明：{/t}</label>
                <div class="controls">
                    <textarea name='invite_explain' class="span7">{$invite_explain}</textarea>
                </div>
            </div>

            <div class="control-group formSep1">
                <label class="control-label">{t domain="affiliate"}被邀请分享说明设置：{/t}</label>
                <div class="controls">
                    <textarea name='invitee_rule_explain' class="span7">{$invitee_rule_explain}</textarea>
                </div>
            </div>


            <h3 class="heading">{t domain="affiliate"}推荐订单奖励设置{/t}</h3>
            <div class="control-group formSep">
                <label class="control-label">{t domain="affiliate"}是否开启奖励：{/t}</label>
                <div class="controls chk_radio">
                    <input type="radio" name="on" value="1" {if $config.on eq 1} checked="true" {/if}>
                    <span>{t domain="affiliate"}开启{/t}</span>
                    <input type="radio" name="on" value="0" {if !$config.on || $config.on eq 0} checked="true" {/if}>
                    <span>{t domain="affiliate"}关闭{/t}</span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="control-group formSep1">
                <label class="control-label">{t domain="affiliate"}订单分成总额比：{/t}</label>
                <div class="controls">
                    <input type="text" name="level_money_all" maxlength="150" size="10" value="{$config.config.level_money_all}" />
                    <div class="help-block">{t domain="affiliate"}设置订单金额的此百分比，作为分成用的总金额。{/t}<br>
                        例如，订单金额100，百分比设置10%，那么最终只有100 x 10%=10，作为分成的总金额。<br>
                        而会员获得最终分成=10 x 对应级别现金分成比，级别分成比例可在：“分销管理 - 分成比例”中设置，<a href="{url path='affiliate/admin/init'}" target="_blank">去设置 >></a>。
                    </div>
                </div>
            </div>


            <h3 class="heading">{t domain="affiliate"}邀请注册奖励设置{/t}</h3>
            <div class="control-group formSep">
                <label class="control-label">{t domain="affiliate"}是否开启奖励：{/t}</label>
                <div class="controls chk_radio">
                    <input type="radio" name="signup_on" value="1" {if $config.signup_on eq 1} checked="true" {/if}>
                    <span>{t domain="affiliate"}开启{/t}</span>
                    <input type="radio" name="signup_on" value="0" {if !$config.signup_on || $config.signup_on eq 0} checked="true" {/if}>
                    <span>{t domain="affiliate"}关闭{/t}</span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="control-group formSep formSep1">
                <label class="control-label">{t domain="affiliate"}奖励机制：{/t}</label>
                <div class="controls chk_radio">
                    <input type="radio" name="intive_reward_by" value="orderpay" checked="true">
                    {t domain="affiliate"}首次下单成交后{/t}
                    <input type="radio" name="intive_reward_by" value="signup" {if $config.intvie_reward.intive_reward_by eq 'signup'}checked="true"{/if} >
                    {t domain="affiliate"}注册时{/t}
                    <div class="help-block">
                        首次下单：被邀请人首次下单后，邀请人和被邀请人才可获得奖励;<br>
                        注册：被邀请人注册成功后，邀请人和被邀请人才可获得奖励。
                    </div>
                </div>
            </div>
            <div class="control-group formSep formSep1 intive_reward_type intive_reward_type_balance">
                <label class="control-label">{t domain="affiliate"}邀请人奖励：{/t}</label>
                <div class="controls chk_radio">
                    <input type="text" name="intive_reward_type_balance" value="{$config.intvie_reward.intive_reward_value}"/> 元
                </div>
            </div>
            <div class="control-group formSep formSep1 intivee_reward_type intivee_reward_type_balance">
                <label class="control-label">{t domain="affiliate"}被邀请人奖励：{/t}</label>
                <div class="controls chk_radio">
                    <input type="text" name="intivee_reward_type_balance" value="{$config.intviee_reward.intivee_reward_value}"/> 元
                </div>
            </div>

            <h3 class="heading">{t domain="affiliate"}分成时间{/t}</h3>
            <div class="control-group">
                <label class="control-label">{t domain="affiliate"}订单分成时间：{/t}</label>
                <div class="controls chk_radio">
                    <input type="text" name="affiliate_order_pass_days" value="{$config.affiliate_order_pass_days}"/> 天
                    <div class="help-block">设置会员确认收货后，X天后，生成分成订单。单位：天，默认7天</div>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <input type="submit" value='{t domain="affiliate"}确定{/t}' class="btn btn-gebo" />
                </div>
            </div>
        </div>
    </form>
</div>
<!-- {/block} -->