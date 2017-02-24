<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.response.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if}
	</h3>
</div>

<div class="modal hide fade" id="add_material">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.select_material'}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12 material_choose" data-url="{url path='wechat/admin_response/get_material_info'}">
				<form class="form-horizontal" method="post" name="add_material">
					<div class="material_choose_list">
						<fieldset class="material_select m_0">
							<table class="table smpl_tbl dataTable m_b0">
								<thead>
								</thead>
								<tbody class="material_select_tbody">
								</tbody>
							</table>
						</fieldset>
					</div>
					<div class="control-group m_t10 m_b0 hide">
						<div class="t_c">
							<input type="button" class="btn btn-gebo material_verify" value="{lang key='wechat::wechat.ok'}" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid edit-page">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a class="data-pjax" href='{url path="wechat/admin_response/reply_subscribe"}'>{lang key='wechat::wechat.attention_auto_reply'}</a></li>
			<li><a class="data-pjax" href='{url path="wechat/admin_response/reply_msg"}'>{lang key='wechat::wechat.message_auto_reply'}</a></li>
		</ul>
	</div>
	
	<div class="content">
		<div class="material-table span12" data-url="{url path='wechat/admin_response/get_material_list'}">
			<form action="{$form_action}" method="post" name="theForm">
				<div class="w-box">
					<div class="w-box-content cnt_a">
						<div class="page-toolbar clearfix">
							<div class="btn-group pull-left">
								<a title="{lang key='wechat::wechat.character'}" class="btn toolbar-icon text-material"><i class="icon-pencil"></i></a>
								<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.picture'}" class="btn toolbar-icon picture-material"><i class="icon-picture"></i></a>
								<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.voice'}" class="btn toolbar-icon music-material"><i class="fontello-icon-mic"></i></a>
								<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.video'}" class="btn toolbar-icon video-material"><i class="icon-facetime-video"></i></a>
							</div>
							
							<div class="controls text {if $subscribe.media_id}hidden{/if}">
								<textarea class="span12 m_t10" name="content" cols="40" rows="5">{if $subscribe.content}{$subscribe.content}{/if}</textarea>
							</div>
						
							<div class="material_picture {if empty($subscribe.media_id)}hidden{/if}">
								 {if $subscribe['media']}
	                                {if $subscribe['media']['type'] == 'voice'}
	                                    <input type='hidden' name='media_id' value="{$subscribe['media_id']}"><img src="{$subscribe['media']['file']}" class='img-rounded material_show' />
	                                    <div class="material_filename">{$subscribe['media']['file_name']}</div>
	                                {elseif $subscribe['media']['type'] == 'video'}
	                                    <input type='hidden' name='media_id' value="{$subscribe['media_id']}"><img src="{$subscribe['media']['file']}" class='img-rounded material_show' />
	                                    <div class="material_filename">{$subscribe['media']['file_name']}</div>
	                                {else}
	                                    <input type='hidden' name='media_id' value="{$subscribe['media_id']}"><img src="{$subscribe['media']['file']}" class='img-rounded material_show' />
	                                {/if}
	                            {/if}
							</div>
						</div>
						<div class="form-group">
		                    <input type="hidden" name="content_type" value="{if $subscribe['reply_type']}{$subscribe['reply_type']}{else}text{/if}">
		                    <input type="hidden" name="id" value="{$subscribe.id}">
		                    {if $errormsg}
		                    <input type="submit" class="btn btn-gebo" disabled="disabled" value="{lang key='wechat::wechat.ok'} ">
		                    {else}
		                    <input type="submit" class="btn btn-gebo" value="{lang key='wechat::wechat.ok'}">
		                    {/if}
	                  	</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->