<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>
.heading .btn { margin-top:-3px;}
</style>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
        <div class="tab-content tab_merchants">
            <div class="tab-pane active" id="tab1">
                <div class="foldable-list move-mod-group">

                <div class="accordion-group">
                    <div class="accordion-heading">
                        <div class="accordion-heading accordion-heading-url">
                            <div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#info2">
                                <strong>{t domain="store"}经营主体信息{/t}</strong>
                            </div>
                            <a class="data-pjax accordion-url m_l10" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=identity")}'>{t domain="store"}编辑{/t}</a>
                        </div>
                    </div>
                    <div class="accordion-body in collapse" id="info2">
                        <table class="table table-oddtd m_b0">
                            <tbody class="first-td-no-leftbd">
                            {if $store.validate_type eq 1}
                            <tr>
                                <td><div align="right"><strong>{t domain="store"}入驻类型：{/t}</strong></div></td>
                                <td>{if $store.validate_type eq 1}{t domain="store"}个人{/t}{else}{t domain="store"}企业{/t}{/if}</td>
                                <td><div align="right"><strong>{t domain="store"}负责人:{/t}</strong></div></td>
                                <td>{$store.responsible_person}</td>
                            </tr>

                            <tr>
                                <td ><div align="right"><strong>{t domain="store"}证件类型：{/t}</strong></div></td>
                                {if $store.identity_type eq 1}
                                <td>{t domain="store"}身份证{/t}</td>
                                {elseif $store.identity_type eq 2}
                                <td>{t domain="store"}护照{/t}</td>
                                {elseif $store.identity_type eq 3}
                                <td>{t domain="store"}港澳身份证{/t}</td>
                                {else}
                                <td></td>
                                {/if}
                                <td><div align="right"><strong>{t domain="store"}证件号码：{/t}</strong></div></td>
                                <td>{$store.identity_number}</td>
                            </tr>
                            {elseif $store.validate_type eq 2}
                            <tr>
                                <td><div align="right"><strong>{t domain="store"}入驻类型：{/t}</strong></div></td>
                                <td>{if $store.validate_type eq 1}{t domain="store"}个人{/t}{else}{t domain="store"}企业{/t}{/if}</td>
                                <td><div align="right"><strong>{t domain="store"}负责人：{/t}</strong></div></td>
                                <td>{$store.responsible_person}</td>
                            </tr>

                            <tr>
                                <td><div align="right"><strong>{t domain="store"}公司名称：{/t}</strong></div></td>
                                <td>{$store.company_name}</td>
                                <td><div align="right"><strong>{t domain="store"}营业执照注册号：{/t}</strong></div></td>
                                <td >{$store.business_licence}</td>
                            </tr>

                            <tr>
                                <td><div align="right"><strong>{t domain="store"}证件类型：{/t}</strong></div></td>
                                {if $store.identity_type eq 1}
                                <td>{t domain="store"}身份证{/t}</td>
                                {elseif $store.identity_type eq 2}
                                <td>{t domain="store"}护照{/t}</td>
                                {elseif $store.identity_type eq 3}
                                <td>{t domain="store"}港澳身份证{/t}</td>
                                {else}
                                <td></td>
                                {/if}
                                <td><div align="right"><strong>{t domain="store"}证件号码：{/t}</strong></div></td>
                                <td>{$store.identity_number}</td>
                            </tr>
                            {/if}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="accordion-group">
                    <div class="accordion-heading">
                        <div class="accordion-heading accordion-heading-url">
                            <div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#identity_pic">
                                <strong>{t domain="store"}证件电子版{/t}</strong>
                            </div>
                            <a class="data-pjax accordion-url" href='{RC_Uri::url("store/admin/edit","store_id={$smarty.get.store_id}&step=pic")}'>{t domain="store"}编辑{/t}</a>
                        </div>
                    </div>

                    <div class="accordion-body in collapse" id="identity_pic">
                        <table class="table table-oddtd m_b0">
                            <tbody class="first-td-no-leftbd">
                            <tr>
                                <td><div align="right"><strong>{t domain="store"}证件正面：{/t}</strong></div></td>
                                <td>
                                    {if $store.identity_pic_front neq ''}
                                    <a href="{RC_Upload::upload_url({$store.identity_pic_front})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_front})}"></a>
                                    {else}
                                    <div class="l_h30">
                                        {t domain="store"} 还未上传{/t}
                                    </div>
                                    {/if}
                                </td>
                                <td><div align="right"><strong>{t domain="store"}证件反面：{/t}</strong></div></td>
                                <td>
                                    {if $store.identity_pic_back neq ''}
                                    <a href="{RC_Upload::upload_url({$store.identity_pic_back})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.identity_pic_back})}"></a>
                                    {else}
                                    <div class="l_h30">
                                        {t domain="store"}还未上传{/t}
                                    </div>
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td><div align="right"><strong>{t domain="store"}手持证件：{/t}</strong></div></td>
                                <td {if $store.validate_type eq 1} colspan="3"{/if}>
                                    {if $store.personhand_identity_pic neq ''}
                                    <a href="{RC_Upload::upload_url({$store.personhand_identity_pic})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.personhand_identity_pic})}"></a>
                                    {else}
                                    <div class="l_h30">
                                         {t domain="store"}还未上传{/t}
                                    </div>
                                    {/if}
                                </td>
                            <!-- {if $store.validate_type eq 1} -->
                            <input type="hidden"  name="identity_type" value="{$store.validate_type}" />
                            <!-- {elseif $store.validate_type eq 2} -->
                                <td><div align="right"><strong>{t domain="store"}营业执照电子版：{/t}</strong></div></td>
                                <td>
                                    {if $store.business_licence_pic neq ''}
                                    <a href="{RC_Upload::upload_url({$store.business_licence_pic})}" title='{t domain="store"}点击查看大图{/t}' target="_blank"><img class="w200 h120 thumbnail"  class="img-polaroid" src="{RC_Upload::upload_url({$store.business_licence_pic})}"></a>
                                    {else}
                                    <div class="l_h30">
                                      	{t domain="store"}还未上传{/t}
                                    </div>
                                    {/if}
                                </td>
                            </tr>
                            <!-- {/if} -->
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <div class="accordion-heading accordion-heading-url">
                            <div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#operate">
                                <strong>{t domain="store"}认证操作{/t}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-body in collapse" id="operate">
                        <form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                        <table class="table table-oddtd m_b0">
                            <tbody class="first-td-no-leftbd">
                            <tr>
                                <td><div align="right"><strong>{t domain="store"}当前认证状态：{/t}</strong></div></td>
                                <td colspan="3">{if $store.identity_status eq 0}{t domain="store"}待认证{/t}
                                {else if $store.identity_status eq 1}{t domain="store"}认证中{/t}
                                {else if $store.identity_status eq 2}{t domain="store"}认证通过{/t}
                                {else if $store.identity_status eq 3}<span class="ecjiafc_red m_l10">{t domain="store"}不通过{/t}</span>{/if}
                                </td>
                            </tr>
                            <tr>
                                <td><div align="right"><strong>{t domain="store"}可执行操作：{/t}</strong></div></td>
                                <td>
                                    <input type="hidden" name="store_id" value="{$store.store_id}" />
                                    {if $store.identity_status neq 1}<button class="btn operatesubmit " type="submit" name="check_ing">{t domain="store"}认证中{/t}</button>&nbsp;&nbsp;{/if}
                                    {if $store.identity_status neq 3}<button class="btn operatesubmit btn-danger" type="submit" name="check_no">{t domain="store"}不通过{/t}</button>&nbsp;&nbsp;{/if}
                                    {if $store.identity_status neq 2}<button class="btn operatesubmit btn-success" type="submit" name="check_yes">{t domain="store"}通过{/t}</button>{/if}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
