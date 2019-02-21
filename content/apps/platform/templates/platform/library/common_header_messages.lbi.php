<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" {if $list}href="javascript:;" data-toggle="dropdown" {else}href="{RC_Uri::url('wechat/platform_message/init')}" {/if}>
    <i class="ficon ft-mail"></i>
    {if $count gt 0}
    <span class="badge badge-pill badge-default badge-info badge-default badge-up">{$count}</span>
    {/if}
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <h6 class="dropdown-header m-0"><span class="grey darken-2">{t domain="platform"}消息列表{/t}</span></h6>
        </li>
        <li class="scrollable-container media-list w-100">
            <!-- {foreach from=$list item=val} -->
            <a href="{RC_Uri::url('wechat/platform_subscribe/subscribe_message')}&uid={$val.uid}">
                <div class="media">
                    <div class="media-left">
                        <span class="avatar avatar-sm avatar-online rounded-circle"><img src="{$val.headimgurl}" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">{$val.nickname}</h6>
                        <p class="notification-text font-small-3 text-muted">{$val.msg}</p>
                        <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{$val.send_time}</time>
                        </small>
                    </div>
                </div>
            </a>
            <!-- {/foreach} -->
        </li>
        <li class="dropdown-menu-footer">
            <a class="dropdown-item text-muted text-center" href="{RC_Uri::url('wechat/platform_message/init')}">{t domain="platform"}全部消息{/t}</a>
        </li>
    </ul>
</li>