{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>我的奖品</title>
		
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/prize.css" />
	</head>
	
	<body>
		<div class="ecjia-suggest-store-content">
			<ul class="ecjia-suggest-store">
				<!-- {foreach from=$prize_log_list item=prize} -->
					<li class="store-info">
						<div class="basic-info">
							<div class="store-left">
								<img src="{$prize.icon}">
							</div>
							<div class="store-right">
								<div class="store-title">
									<span class="activity-name">[{$prize.activity_name}]</span>
									<span class="activity-name">
										{if $prize.prize_type eq '2'}
											实物奖励
										{elseif $prize.prize_type eq '3'}
											积分奖励
										{else}
											红包奖励
										{/if}
									</span>
								</div>
								<div class="store-title store-title-middle">
									<span class="prize-content">{$prize.prize_value_label}</span>
									{if $prize.prize_type eq '2'}
										{if $prize.issue_status eq '1'}
											<span class="issue_status">已发放</span>
										{else}
											<a href='{url path="market/mobile_prize/user_info" args="log_id={$prize.id}"}' class="btn btn-prize">{if $prize.has_filled eq '1'}查看地址{else}填写地址{/if}</a>
										{/if}
										
									{else}
										{if $prize.issue_status eq '1'}
											<span class="issue_status">已兑换</span>
										{else}
											<span class="issue_status">未兑换</span>
										{/if}
										
									{/if}
								</div>
								<div class="store-title">
									<span>{$prize.formated_add_time}</span>
								</div>
							</div>
							<div class="clear_both"></div>
						</div>
					</li>
				<!-- {/foreach} -->
			</ul>
		</div>
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
       
        
        <script src="{$system_statics_url}/lib/chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>
      
	</body>
</html>
{/nocache}