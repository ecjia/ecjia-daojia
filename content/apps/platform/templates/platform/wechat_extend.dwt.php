<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.platform.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">{t domain="platform"}操作提示{/t}</h4>
	<p>{t domain="platform"}插件扩展，为系统默认提供的关键词自动回复功能，结合网站商品，会员，订单等功能提供互动查询服务，配合微信自定义菜单使用。{/t}</p>
	<p>{t domain="platform"}如果需要则安装并填写一下配置信息，复制对应的关键词，加入到微信自定义菜单中使用。{/t}</p>
	<p>{t domain="platform"}例如，商品推荐 对应的关键词是 mp_goods（也可以使用相应的扩展词），在自定义菜单中添加一个菜单，菜单类型选择 发送消息。{/t}</p>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
                </h4>
            </div>
	        <div class="col-md-12">
				<div class="tab-content">
					<div class="active">
						<div class="row-fluid">
							<!-- {foreach from=$arr item=module} -->
								<div class="outline">
									<a class="data-pjax"  href='{RC_Uri::url("platform/platform_extend/wechat_extend_view", "code={$module.ext_code}")}' >
										<div class="outline-left"><img class="icon-extend" src="{if $module.icon}{$module.icon}{else}{$img_url}setting_shop.png{/if}" /></div>
										<div class="outline-right">
											<p>{$module.ext_name}</p>
											<span>{$module.ext_code}</span>
										</div>
									</a>
									{if $module.added eq 1}
									<span class="added">{t domain="platform"}已添加{/t}</span>
									{/if}
								</div>
							<!-- {foreachelse} -->
							<div class="no-records">{t domain="platform"}没有找到任何记录{/t}</div>
							<!-- {/foreach} -->
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->