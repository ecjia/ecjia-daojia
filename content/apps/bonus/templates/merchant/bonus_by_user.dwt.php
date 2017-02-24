<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.link_user.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a  class="btn  btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
		</h2>
	</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal tasi-form form1" action="{$form_action}" method="post" name="userRankForm" class="form1" >
                        <div class=" form-group ">
                            <div class="col-lg-12">
                                <strong>{lang key='bonus::bonus.senduserrank'}</strong>
                            </div>
                        </div>
                        <div class="form-group choose_list ">
                            <div class="col-lg-12">
                                <label><span>{lang key='bonus::bonus.user_rank'}</span></label>
                                <select name="rank_id" class="mem-rk chzn-single w130">
                                    <option value="">{lang key='bonus::bonus.select_rank'}</option>
                                    <!-- {html_options options=$ranklist selected=$smarty.get.rank_id} -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <input id="validated_email" type="checkbox" name="validated_email" value="1">
                            <label for="validated_email">{lang key='bonus::bonus.validated_email'}</label>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="hidden" name="act" value="send_by_user"/>
                                <input type="hidden" name="id" value="{$id}" />
                                <button class="btn btn-info" type="submit">{lang key='bonus::bonus.confirm_send_bonus'}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <form class="cmxform form-horizontal tasi-form" action='{$form_user_action}' method="post" name="theForm">
                    <div class="tab-content">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label>{t}按指定用户发放红包{/t}</label>
                                </div>
                            </div>
                            <div class="form-group choose_lists"  id="search_user"  data-url="{url path='bonus/merchant/search_users'}">
                                <div class="col-lg-4">
                                    <input class="form-control" type="text" name="keyword" placeholder="请输入用户名的关键字" />
                                </div>
                                <a class="btn btn-primary" data-toggle="searchuser"><i class='fa fa-search'></i> {lang key='system::system.button_search'}</a>
                                <div class="col-lg-12">
                                    {t}搜索要发放此类型红包的用户展示在左侧区域中，点击左侧列表中选项，用户即可进入右侧发放红包区域。您还可以在右侧编辑将发放红包的用户。{/t}
                                </div>

                            </div>
                            <div class="form-group draggable">
                                <div class="ms-container col-lg-12" id="ms-custom-navigation">
                                    <div class="ms-selectable">
                                        <div class="search-header">
                                            <input class="form-control"  id="ms-search" type="text" placeholder="{t}筛选搜索到的用户信息{/t}" autocomplete="off">
                                        </div>
                                        <ul class="ms-list nav-list-ready">
                                            <li class="ms-elem-selectable disabled"><span>暂无信息</span></li>
                                        </ul>
                                    </div>

                                    <div class="ms-selection">
                                        <div class="custom-header custom-header-align">给下列用户发放红包</div>
                                        <ul class="ms-list nav-list-content">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ecjiaf-tac">
                                <button class="btn btn-info" type="submit">{t}确定发放红包{/t}</button>
                                <input type="hidden" id="bonus_type_id" value="{$id}" />
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->