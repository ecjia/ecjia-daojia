<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<li class="dropdown nav-item mega-dropdown">
<a class="dropdown-toggle nav-link" href="icons-simple-line-icons.html#" data-toggle="dropdown">{$platformAccount->getPlatformName()}</a>
    <ul class="mega-dropdown-menu dropdown-menu row">
		<li class="col-md-12">
        	<h3 class="dropdown-menu-header text-uppercase mb-1">
        		<img src="{$platformAccount->getLogo()}" alt="{$platformAccount->getAccountName()}" width="60" height="60"> 
        		{$platformAccount->getAccountName()}
        	</h3>
        	<div id="mega-menu-carousel-example" class="mega-menu-carousel-example-content">
              	<div class="mega-menu-carousel-content left">
              		<div class="mega-menu-carousel-row left">
              			<p>{t domain="platform"}平台{/t}</p>
              			<img src="{$ecjia_main_static_url}image/{$platformAccount->getPlatform()}.png">
              			<p>{$platformAccount->getPlatformName()}</p>
	              	</div>
	              	<div class="mega-menu-carousel-row right">
                        {if $platformAccount->getPlatform() eq 'wechat'}
	              		<p>{t domain="platform"}公众号类型{/t}</p>
              			<img src="{$ecjia_main_static_url}image/{$platformAccount->getTypeCode()}.png">
              			<p>{$platformAccount->getTypeName()}</p>
                        {/if}
	              	</div>
              	</div>
              	<div class="mega-menu-carousel-content right">
              		<div class="item">
              			<label>{t domain="platform"}UUID：{/t}</label>
              			<label class="item-controls">{$platformAccount->getUUID()}</label>
              		</div>
              		<div class="item">
              			<label>{t domain="platform"}外部访问地址：{/t}</label>
              			<label class="item-controls">{$platformAccount->getApiUrl()}</label>
              		</div>
              		<div class="item">
              			<a class="btn btn-success" target="_blank" href="{$platformAccount->getPlatformSettingUrl()}">{t domain="platform"}编辑配置{/t}</a>
              			<a class="btn btn-info m_l20" href="{$platformAccount->getPlatformListUrl()}">{t domain="platform" 1={$platformAccount->getPlatformName()}}返回%1{/t}</a>
              		</div>
              	</div>
            </div>
      	</li>
	</ul>
</li>
