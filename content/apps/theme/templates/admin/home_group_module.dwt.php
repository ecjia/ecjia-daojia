<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_home_group.init();
</script>
<style>
.btn-info{
	margin-left:47%;
	margin-top:15px;
}
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn" id="sticky_a" href="{$action_link.href}" style="float:right;margin-top:-3px;"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<div class="row-fluid">
    <div class="span3">

        <div class="setting-group m_b20">
            <span class="setting-group-title"><i class="fontello-icon-cog"></i>{t}可用产品{/t}</span>
            <ul class="nav nav-list m_t10">
                <!-- {foreach from=$platform_groups item=platform} -->
                <li>
                    <a class="setting-group-item
                            {if $platform.platform == $current_platform}
                            llv-active
                            {/if}
                            " href='{url path="theme/admin_home_module/init" args="platform={$platform.platform}"}'>{$platform.label}</a>
                </li>
                <!-- {/foreach} -->
            </ul>
        </div>

    </div>


	<div class="span9">

        <!-- {if count($platform_clients) > 1} -->
        <ul class="nav nav-tabs">
            <!-- {foreach from=$platform_clients item=client} -->
            <!-- {if $client.device_client == $current_client} -->
            <li class="active"><a href="javascript:;">{$client.device_name}</a></li>
            <!-- {else} -->
            <li><a class="data-pjax" href='{url path="theme/admin_home_module/init" args="platform={$current_platform}&client={$client.device_client}"}'>{$client.device_name}</a></li>
            <!-- {/if} -->
            <!-- {/foreach} -->
        </ul>
        <!-- {/if} -->

		<section class="demo clearfix">
			<div id="dragslot">
				<div class="slot-title avaliable-title">可用模块</div>
				<div class="slot-title ">已启用模块</div>
				
				<div class="slot avaliabled">
					<ul class="slot-list">
					<!-- {if $avaliable_group} -->	
					<!-- {foreach from=$avaliable_group item=group} -->
						<li class="slot-item" id="a" code="{$group->getCode()}">
							<div class="slot-handler">
								<p>
									{$group->getName()}
								</p>
								<div class="slot-handler clearfix">
									<div class="avator">
										<img src="{$group->getThumb()}"/>
									</div>
								</div>
							</div>
						</li>
					<!-- {/foreach} -->	 
					<!-- {else} -->	
						<li>
						</li>
					<!-- {/if}  -->	
					</ul>
				</div>
				
				<div class="slot slot2 opened">
					
					<ul class="slot-list">
					<!-- {if $useing_group} -->	
						<!-- {foreach from=$useing_group item=use_group} -->
						<li class="slot-item" code="{$use_group->getCode()}">
							<div class="slot-handler">
								<p>
									{$use_group->getName()}
								</p>
								<div class="slot-handler clearfix">
									<div class="avator">
										<img src="{$use_group->getThumb()}"/>
									</div>
								</div>
							</div>
						</li>
					<!-- {/foreach} -->	
					<!-- {else} -->	
						<li>
						</li>
					<!-- {/if}  -->	
					</ul>
				</div>
			</div>
			<a class="btn btn-info save-sort" data-sorturl='{url path="theme/admin_home_module/save_sort" args="platform={$current_platform}&client={$current_client}"}'>保存</a>
		</section>
	</div>
</div>
<!-- {/block} -->