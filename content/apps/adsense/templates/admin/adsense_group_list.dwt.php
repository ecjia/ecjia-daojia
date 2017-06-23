<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.ad_group_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert">
	<a class="close" data-dismiss="alert">×</a>
	<strong>温馨提示：</strong>建议您添加为"默认"地区的广告组，当并未设置地区时就会显示默认的广告组。
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
 <!-- {foreach from=$city_list item=val} -->
	<li class="{if $city_id eq $val.city_id}active{/if}"><a class="data-pjax" href='{url path="adsense/admin_group/init" args="city_id={$val.city_id}"}'>{$val.city_name}<span class="badge badge-info"></span></a></li>
 <!-- {/foreach} -->
</ul>

<div class="row-fluid">
	<div class="span12">
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
							<a class="data-pjax ecjiafc-gray" href='{url path="adsense/admin_group/group_position_list" args="city_id={$city_id}&position_id={$val.position_id}"}'><i class="fontello-icon-th-list"></i>查看组合</a>
							<font style="margin:20px 20px;">|</font>
							<a class="data-pjax ecjiafc-gray" href='{url path="adsense/admin_group/constitute" args="city_id={$city_id}&position_id={$val.position_id}"}'><i class="fontello-icon-plus-squared"></i>进行组合</a>
						</div>
					</div>
				</li>
			<!-- {/foreach} -->
				<li class="thumbnail">
					<div class="bd">
						<div class="add_content">
							<a class="more" href='{RC_Uri::url("adsense/admin_group/add")}' >
								<i class="fontello-icon-plus"></i>
							</a>
							点击添加广告组<br>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->