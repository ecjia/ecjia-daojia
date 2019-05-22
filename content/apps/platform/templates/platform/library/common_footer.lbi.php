<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<footer class="footer footer-static footer-transparent ecjia-platform-footer">
	<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
		<span class="d-block d-md-inline-blockd-none d-lg-block">Copyright &copy; 2018 {ecjia::config('shop_name')} {if ecjia::config('icp_number', 2)}<a href="http://beian.miit.gov.cn" target="_blank">{ecjia::config('icp_number')}</a>{/if}</span>
	</p>
</footer>

{if ecjia::config('stats_code')}
{stripslashes(ecjia::config('stats_code'))}
{/if}