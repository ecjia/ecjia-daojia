<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="header-top">
    <!-- start:navbar -->
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            <!-- start:navbar-header -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{if $shop_title_link}{$shop_title_link}{else}{RC_Uri::url('franchisee/merchant/init')}{/if}"><i class="fa fa-cubes"></i> <strong>{ecjia::config('shop_name')} - {if $shop_title}{$shop_title}{else}商家入驻{/if}</strong></a>
            </div>
            <!-- end:navbar-header -->
            <ul class="nav navbar-nav navbar-left top-menu">
                <!-- start dropdown 3 -->
                <!-- end dropdown 3 -->
            </ul>
            <ul class="nav navbar-nav navbar-right top-menu">
            	<a class="ecjiafc-white l_h30" href='{RC_Uri::home_url()}'><i class="fa fa-reply"></i> 网站首页</a>
            </ul>
        </div>
    </nav>
    <!-- end:navbar -->
</div>
<!-- start:header -->
<div id="header" {if $background_url}style="background: url({$background_url}) no-repeat center center fixed;"{/if}>
    <div class="overlay">
        <nav class="navbar" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="btn-block btn-drop navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <strong>MENU</strong>
                    </button>
                </div>
            
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav m_t40">
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- end:header -->