<!-- /* -->
<!--  Name: 城市选择 -->
<!--  Description: 这是城市选择模块 -->
<!--  */ -->
{nocache}
<div class="choose-city-div">
	<div class="city-content">
		<div class="header">
			<div class="title">请选择您所在的城市</div>
			<span class="close_div">X</span>
		</div>
		<div class="content">
			<div class="content-position">
				<div class="guess-position">猜你在</div>
				<div class="position">
					{if $info.location_id}
						<!-- {foreach from=$info.region_list item=val} -->
						{if $info.location_id eq $val.id}
							<li class="position-li {if $info.city_id eq $val.id}active{/if} location-position" data-id="{$val.id}">{$val.name}</li>
						{/if}
						<!-- {/foreach} -->
					{/if}
				</div>
			</div>
			<div class="content-bottom">
				<div class="title">热门城市</div>
				<div class="position-list">
					<!-- {foreach from=$info.region_list item=val} -->
					<li class="position-li {if $info.city_id eq $val.id}active{/if}" data-id="{$val.id}">{$val.name}</li>
					<!-- {/foreach} -->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="choose-city-overlay"></div>
{/nocache}
