<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.platform_request.init();
// 	var type = "{$type}";
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_list}</h4>
            </div>
            {if !$errormsg}	
            <div class="card-body">
            	<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link data-pjax {if $type eq 1}active{/if}" href='{url path="wechat/platform_request/init" args="type=1"}'>{lang key='wechat::wechat.today'}（{$list.date.today}）</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $type eq 2}active{/if}" href='{url path="wechat/platform_request/init" args="type=2"}'>{lang key='wechat::wechat.yesterday'}（{$list.date.yesterday}）</a>
					</li>
				</ul>
			</div>
			{/if}
            <div class="col-md-12">
				<table class="table">
					<thead>
						<tr>
							<th class="w200">{lang key='wechat::wechat.api_name'}</th>
							<th class="w180">{lang key='wechat::wechat.daily_call_limit'}</th>
							<th class="w180">{lang key='wechat::wechat.daily_call_dosage'}</th>
							<th class="w150">{lang key='wechat::wechat.last_request_time'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.item item=val key=key} -->
						<tr>
							<td>{$val.title}</td>
							<td>{if $val.times}{$val.times}{else}{lang key='wechat::wechat.not_have'}{/if}</td>
							<td>{if $val.info.times}{$val.info.times}{else}0{/if}</td>
							<td>{if $val.info.last_time}{$val.info.last_time}{/if}</td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->