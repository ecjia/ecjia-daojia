<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.material.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

{if $warn && $wechat_type eq 0}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.notice_public_not_certified'}
</div>
{/if}

<!-- {if ecjia_screen::get_current_screen()->get_help_sidebar()} -->
<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<!-- {ecjia_screen::get_current_screen()->get_help_sidebar()} -->
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>

            {if $get_material_link}
			<div class="card-body">
				<div><button type="button" class="get_material btn btn-outline-primary" data-url='{$get_material_link.href}'>{$get_material_link.text}</button><span style="margin-left: 20px;">通过点击该按钮可以获取微信公众平台素材到本地。</span></div><br/>
			</div>
            {/if}

			<div class="card-body">
				<ul class="nav nav-pills float-left">
					<!-- {if $smarty.get.material eq 1} -->
     				<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'news'}active{/if}" href='{url path="wechat/platform_material/init" args="type=news{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.text_message'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.news}{$lists.filter.count.news}{else}0{/if}</span></a>
					</li>
					<!-- {/if} -->
					
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'image'}active{/if}" href='{url path="wechat/platform_material/init" args="type=image{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.image'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.image}{$lists.filter.count.image}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'voice'}active{/if}" href='{url path="wechat/platform_material/init" args="type=voice{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.voice'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.voice}{$lists.filter.count.voice}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'video'}active{/if}" href='{url path="wechat/platform_material/init" args="type=video{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.video'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.video}{$lists.filter.count.video}{else}0{/if}</span></a>
					</li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $smarty.get.type eq 'thumb'}active{/if}" href='{url path="wechat/platform_material/init" args="type=thumb{if $smarty.get.material}&material=1{/if}"}'>
                            {lang key='wechat::wechat.thumb'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.thumb}{$lists.filter.count.thumb}{else}0{/if}</span></a>
                    </li>
				</ul>
				<!-- {if $action_link} -->
				<a class="btn btn-outline-primary plus_or_reply float-right" id="sticky_a" href='{$action_link.href}{if $smarty.get.type neq "news"}{if $smarty.get.material}&material=1{/if}{/if}'><i class="ft-plus"></i>{$action_link.text}</a>
				<!-- {/if} -->
			</div>
			<div class="card-body">
				<!-- {if $smarty.get.type eq news} -->
                <!-- #BeginLibraryItem "/library/wechat_material_news.lbi" --><!-- #EndLibraryItem -->
				<!-- {/if} -->
				
				<!-- {if $smarty.get.type eq image} -->
                <!-- #BeginLibraryItem "/library/wechat_material_image.lbi" --><!-- #EndLibraryItem -->
				<!-- {/if} -->
				
				<!-- {if $smarty.get.type eq voice} -->
                <!-- #BeginLibraryItem "/library/wechat_material_voice.lbi" --><!-- #EndLibraryItem -->
				<!-- {/if} -->

                <!-- {if $smarty.get.type eq thumb} -->
                <!-- #BeginLibraryItem "/library/wechat_material_thumb.lbi" --><!-- #EndLibraryItem -->
                <!-- {/if} -->
				
				<!-- {if $smarty.get.type eq video} -->
                <!-- #BeginLibraryItem "/library/wechat_material_video.lbi" --><!-- #EndLibraryItem -->
				<!-- {/if} -->
			</div>
        </div>
    </div>
</div>
<!-- {/block} -->
