<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mass_message.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $warn}
	{if $type eq 0}
	 	<div class="alert alert-error">
	         <strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
	    </div>
	{/if}
{/if}

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="modal hide fade" id="add_material">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.select_material'}</h3>
	</div>

	<div class="modal-body keywords_modal_body">
		<div class="row-fluid">
			<div class="span12 form-horizontal material_choose" data-url="{url path='wechat/admin_mass_message/get_material_info'}">
                <div class="material_choose_list">
                    <div class="material_select m_0">
                        <table class="table smpl_tbl dataTable m_b0">
                            <thead>
                            </thead>
                            <tbody class="material_select_tbody">
                            </tbody>
                        </table>
					</div>
				</div>
                <div class="control-group m_t10 m_b0 hide">
                    <div class="t_c">
                        <input type="button" class="btn btn-gebo material_verify" {if $errormsg}disabled="disabled"{/if} value="{lang key='wechat::wechat.ok'}" />
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
	
<div class="row-fluid ">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab1" data-toggle="tab">{lang key='wechat::wechat.send_message'}</a></li>
				<li><a class="data-pjax" href='{url path="wechat/admin_mass_message/mass_list"}'>{lang key='wechat::wechat.send_record'}</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<div class="alert alert-info">
						<a class="close" data-dismiss="alert">×</a>
						<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.mass_notice_info'}
					</div>
					<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
						<div class="control-group formSep mass_message_group">
							<label class="control-label">{lang key='wechat::wechat.label_mass_type'}</label>
							<div class="controls">
								<select name="mass_type" class="w130 f_l">
									<option value="all">{lang key='wechat::wechat.all_user'}</option>
									<option value="by_group">{lang key='wechat::wechat.by_group'}</option>
				                </select>
				                <div class="by_group hide m_l10 f_l">
									<select name="tag_id" class="w130">
					                    <!-- {foreach from=$list item=val} -->
					                    <option value="{$val['tag_id']}">{$val['name']}</option>
					                    <!-- {/foreach} -->
					                </select>
				                </div>
							</div>
						</div>
						
						<div class="control-group formSep material-table" data-url="{url path='wechat/admin_mass_message/get_material_list'}">
							<label class="control-label">{lang key='wechat::wechat.label_select_material'}</label>
							<div class="controls">
								<div class="material-table span12" data-url="{url path='wechat/admin_mass_message/get_material_list'}">
                                    <div class="w-box">
                                        <div class="w-box-content cnt_a">
                                            <div class="page-toolbar clearfix">
                                                <div class="btn-group pull-left">
                                                	<a title="{lang key='wechat::wechat.text'}" class="btn  toolbar-icon text-material"><i class="icon-pencil"></i></a>
                                                    <a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.image'}" class="btn toolbar-icon picture-material"><i class="icon-picture"></i></a>
                                                    <a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.voice'}" class="btn toolbar-icon music-material"><i class="fontello-icon-mic"></i></a>
                                                    <a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.video'}" class="btn toolbar-icon video-material"><i class="icon-facetime-video"></i></a>
                                                    <a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.text_message'}" class="btn toolbar-icon list-material"><i class=" icon-list-alt"></i></a>
                                                </div>
                                                <span class="input-must">{lang key='system::system.require_field'}</span>
                                                
                                                <div class="text m_b10 {if $data.media_id}hidden{/if}">
                                                    <textarea class="m_t10 span12" name="content" cols="40" rows="5"></textarea>
                                                </div>
                                            
                                                <div class="material_picture {if empty($data.media_id)}hidden{/if}">
                                                     {if $data['media']}
                                                        {if $data['media']['type'] == 'voice'}
                                                            <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
                                                        {elseif $subscribe['media']['type'] == 'video'}
                                                            <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
                                                        {else}
                                                            <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
                                                        {/if}
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
			               		<input type="hidden" name="content_type" value="text">
                          		<input type="submit" class="btn btn-gebo" value="{lang key='wechat::wechat.send_msg'}" {if $errormsg}disabled="disabled"{/if}/>
                            </div>
                          </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->