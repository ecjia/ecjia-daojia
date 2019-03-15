<div id="footer" class="footer" style="background: #f5f5f5">
    <div class="helpnav clearfix" style="background: #f5f5f5">
        <div class="wrap">
            <div class="footer-center">
                {if $help_list}
                <!-- {foreach from=$help_list key=key item=help} -->
                {if $key lt 5}
                <div class="helpnav-list">
                    <div class="helpnav-title">
                        <i></i>
                        {$help.name}
                    </div>
                    <ul>
                        <!-- {foreach from=$help.article key=k item=h} -->
                        <li><a href="{RC_Uri::url('article/help/init')}&aid={$h.id}" title="{$h.title}" target="_blank">{$h.title}</a></li>
                        <!-- {/foreach} -->
                    </ul>
                </div>
                {/if}
                <!-- {/foreach} -->
                {/if}
            </div>
        </div>
    </div>
    <div class="bottom-nav">
        <div>
            {$shop_info_html}
        </div>
        <div class="copyright">
            {if ecjia::config('company_name')}{ecjia::config('company_name')}{t domain="default"}版权所有{/t}{/if}
            {if ecjia::config('icp_number')}<a href="http://www.miibeian.gov.cn" target="_blank">{ecjia::config('icp_number')}</a>{/if}&nbsp;&nbsp;{$commoninfo.powered}
        </div>
        <div class="police">
        </div>
    </div>
</div>
{if ecjia::config('stats_code')}
{stripslashes(ecjia::config('stats_code'))}
{/if}
<script type="text/javascript">
    $(document).ready(function(){
        $('.current').parent().parent('ul').show();
        $('.current').parent().parent('ul').prev().addClass('current-header');
    });

    $('p.menu_head').click(function(){
        if($(this).addClass('current-header').next('ul.menu_body').css('display')=='none'){
            $(this).addClass('current-header').next('ul.menu_body').show();
        }else{
            $(this).addClass('current-header').next('ul.menu_body').hide(400);
        }

        $(this).siblings().removeClass('current-header');
    });
</script>