<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="icons-simple-line-icons.html#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span></a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <h6 class="dropdown-header m-0"><span class="grey darken-2">{t domain="platform"}Notifications{/t}</span></h6>
            <span class="notification-tag badge badge-default badge-danger float-right m-0">{t domain="platform"}5 New{/t}</span>
        </li>
        <li class="scrollable-container media-list w-100">
            <a href="javascript:void(0)">
                <div class="media">
                    <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">{t domain="platform"}You have new order!{/t}</h6>
                        <p class="notification-text font-small-3 text-muted">{t domain="platform"}Lorem ipsum dolor sit amet, consectetuer elit.{/t}</p>
                        <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{t domain="platform"}30 minutes ago{/t}</time>
                        </small>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0)">
                <div class="media">
                    <div class="media-left align-self-center">
                        <i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                    <div class="media-body">
                        <h6 class="media-heading red darken-1">{t domain="platform"}99% Server load{/t}</h6>
                        <p class="notification-text font-small-3 text-muted">{t domain="platform"}Aliquam tincidunt mauris eu risus.{/t}</p>
                        <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{t domain="platform"}Five hour ago{/t}</time>
                        </small>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0)">
                <div class="media">
                    <div class="media-left align-self-center">
                        <i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
                    <div class="media-body">
                        <h6 class="media-heading yellow darken-3">{t domain="platform"}Warning notifixation{/t}</h6>
                        <p class="notification-text font-small-3 text-muted">{t domain="platform"}Vestibulum auctor dapibus neque.{/t}</p>
                        <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{t domain="platform"}Today{/t}</time>
                        </small>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0)">
                <div class="media">
                    <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">{t domain="platform"}Complete the task{/t}</h6>
                        <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{t domain="platform"}Last week{/t}</time>
                        </small>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0)">
                <div class="media">
                    <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                    <div class="media-body">
                        <h6 class="media-heading">{t domain="platform"}Generate monthly report{/t}</h6>
                        <small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{t domain="platform"}Last month{/t}</time>
                        </small>
                    </div>
                </div>
            </a>
        </li>
        <li class="dropdown-menu-footer">
            <a class="dropdown-item text-muted text-center" href="javascript:void(0)">{t domain="platform"}Read all notifications{/t}</a>
        </li>
    </ul>
</li>