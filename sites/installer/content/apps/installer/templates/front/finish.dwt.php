<?php defined('IN_ECJIA') or exit('No permission resources.');?>
{extends file="./ecjia_installer.dwt.php"}

{block name="main_content"}
<div class="container">
    <div class="row">
        <div class="col-mb-12 col-tb-8 col-tb-offset-2">
            <div class="column-14 start-06 ecjia-install-complete">
                <h3 class="typecho-install-title">{$finish_message}</h3>
                <div class="typecho-install-body">
                	{if $locked_message}
                	<h5>{$locked_message}</h5>
                	{/if}
                	
                 	{if !$locked_message}
             		<div class="message success">
                        {t domain="installer"}您的用户名是：{/t}<strong class="mono">{$admin_name}</strong><br>
                        {t domain="installer"}您的密码是：{/t}<strong class="mono">{$admin_password}</strong>
	                </div>
	                {/if}

                    <div class="p message notice">
                        {t domain="installer"  escape=no}<a target="_blank" href="https://www.ecjia.com/wiki/">前往ECJIA WIKI，查看帮助文档，使您快速上手。</a>{/t}
                    </div>

                    {if !empty($go_urls)}
                    <div class="session">
                    <p>{t domain="installer"}您可以将下面链接保存到您的收藏夹哦{/t}</p>
                    <ul>
                        <!-- {foreach from=$go_urls item=url key=key} -->
                    	<li><a target="_blank" href="{$url.link}">{$url.text}</a></li>
                        <!-- {/foreach} -->
                    </ul>
                    </div>
                    {/if}

                    <p>{t domain="installer"}各种体验，希望您能尽情享用ECJIA带来的乐趣！{/t}</p>
                </div>
			</div>
		</div>
	</div>
</div>	
{/block}