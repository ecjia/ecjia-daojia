<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.merhcant_group_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header"><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<div class="list-div list media_captcha wookmark warehouse" id="listDiv">
		  	<ul>
			<!-- {foreach from=$data item=val} -->
				<li class="thumbnail">
					<div class="bd">
						<div class="group_info">
							{$val.position_name}<span class="label label-info">{$val.count}</span><br>{$val.position_code}
						</div>
						<div class="group_middle">
							{$val.position_desc}
						</div>
						<div class="group_checkin">
							<a class="data-pjax ecjiafc-gray" href='{url path="adsense/mh_group/group_position_list" args="position_id={$val.position_id}"}'><i class="fontello-icon-th-list"></i>广告位列表</a>
							<font style="margin:20px 20px;">|</font>
							<a class="data-pjax ecjiafc-gray" href='{url path="adsense/mh_group/constitute" args="position_id={$val.position_id}"}'><i class="fontello-icon-plus-squared"></i>添加广告位</a>
						</div>
					</div>
				</li>
			<!-- {/foreach} -->
				<li class="thumbnail">
					<div class="bd">
						<div class="add_content">
							<a class="more" href='{RC_Uri::url("adsense/mh_group/add")}' >
								 <img src="{$ecjia_main_static_url}img/plus.png" /><br>
							</a>
							点击添加广告组<br>
						</div>
					</div>
				</li>
			</ul>
		</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->