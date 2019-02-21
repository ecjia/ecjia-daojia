<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_category_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<!-- start add new category form -->
<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data" data-edit-url="{RC_Uri::url('goods/admin_category/edit')}">
	<div class="row-fluid editpage-rightbar">
		<div class="left-bar move-mod">
			<div class="control-group formSep">
				<label class="control-label">{t domain="goods"}分类名称：{/t}</label>
				<div class="controls">
					<input class="w350" type='text' name='cat_name' maxlength="20" value='{$cat_info.cat_name|escape:html}' size='27'/>
					<span class="input-must">*</span>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="goods"}上级分类：{/t}</label>
				<div class="controls">
					<select class="w350" name="parent_id">
						<option value="0">{t domain="goods"}顶级分类{/t}</option>
						<!-- {$cat_select} -->
					</select>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="goods"}数量单位：{/t}</label>
				<div class="controls">
					<input class="w350" type="text" name='measure_unit' value='{$cat_info.measure_unit}' size="12" />
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="goods"}价格区间个数：{/t}</label>
				<div class="controls">
					<input class="w350" type="text" name="grade" value="{$cat_info.grade|default:0}" size="40" />
					<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeGrade">{t domain="goods"}该选项表示该分类下商品最低价与最高价之间的划分的等级个数，填0表示不做分级，最多不能超过10个。{/t}</span>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="goods"}筛选属性：{/t}</label>
				<div class="controls">
					<!-- {if $attr_cat_id eq 0} -->
					<div class="goods_type">
						<select class="w150 choose_goods_type" data-url="{url path='goods/admin_category/choose_goods_type'}" autocomplete="off">
							<option value="0">{t domain="goods"}请选择商品类型{/t}</option>
							<!-- {$goods_type_list} -->
						</select>&nbsp;&nbsp;
						<select class="w150 show_goods_type" name="filter_attr[]" autocomplete="off">
							<option value="0">{t domain="goods"}请选择筛选属性{/t}</option>
						</select>
						<a class="no-underline" data-toggle="clone-obj" data-parent=".goods_type" href="javascript:;"><i class="fontello-icon-plus"></i></a>
					</div>
					<!-- {/if} -->

					<!-- {foreach from=$filter_attr_list item=filter_attr name="filter_attr_tab"}-->
					<div class="goods_type">
						<select class="w150 choose_goods_type" data-url="{url path='goods/admin_category/choose_goods_type'}" autocomplete="off">
							<option value="0">{t domain="goods"}请选择商品类型{/t}</option>
							<!-- {$filter_attr.goods_type_list} -->
						</select>&nbsp;&nbsp;
						<select class="w150 show_goods_type" name="filter_attr[]" autocomplete="off">
							<option value="0">{t domain="goods"}请选择筛选属性{/t}</option>
							<!-- {html_options options=$filter_attr.option selected=$filter_attr.filter_attr} -->
						</select>
						<!-- {if $smarty.foreach.filter_attr_tab.index eq 0} -->
						<a class="no-underline" data-toggle="clone-obj" data-parent=".goods_type" href="javascript:;"><i class="fontello-icon-plus"></i></a>
						<!-- {else} -->
						<a class="no-underline" data-toggle="remove-obj" data-parent=".goods_type" href="javascript:;"><i class="fontello-icon-cancel ecjiafc-red"></i></a>
						<!-- {/if} -->

						<!-- <select onChange="changeCat(this)"><option value="0">{t domain="goods"}请选择商品类型{/t}</option>{$filter_attr.goods_type_list}</select>&nbsp;&nbsp;
						<select name="filter_attr[]"><option value="0">{t domain="goods"}请选择筛选属性{/t}</option>{html_options options=$filter_attr.option selected=$filter_attr.filter_attr}</select> -->
					</div>
					<!-- {/foreach}-->
					<span class="help-block" style="display:block" id="noticeFilterAttr">{t domain="goods"}筛选属性可在前分类页面筛选商品{/t}</span>
				</div>
			</div>

			<div class="foldable-list move-mod-group" id="goods_info_sort_seo">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_seo">
							<strong>{t domain="goods"}SEO优化{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="goods_info_area_seo">
						<div class="accordion-inner">
							<div class="control-group control-group-small" >
								<label class="control-label">{t domain="goods"}关键字：{/t}</label>
								<div class="controls">
									<input class="span12" type="text" name="keywords" value="{$cat_info.keywords|escape}" size="40" />
									<br />
									<p class="help-block w280 m_t5">{t domain="goods"}用英文逗号分隔{/t}</p>
								</div>
							</div>
							<div class="control-group control-group-small" >
								<label class="control-label">{t domain="goods"}分类描述：{/t}</label>
								<div class="controls">
									<textarea class="span12" name='cat_desc' rows="6" cols="48">{$cat_info.cat_desc}</textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- {if $action eq 'edit'} -->
			<div class="foldable-list move-mod-group" id="goods_info_sort_note">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed acc-in move-mod-head" data-toggle="collapse" data-target="#goods_info_term_meta">
							<strong>{t domain="goods"}自定义栏目{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in" id="goods_info_term_meta">
						<div class="accordion-inner">
								<!-- 自定义栏目模板区域 START -->
								<!-- {if $data_term_meta} -->
								<label><b>{t domain="goods"}编辑自定义栏目：{/t}</b></label>
							<table class="table smpl_tbl ">
								<thead>
									<tr>
										<td class="span4">{t domain="goods"}名称{/t}</td>
										<td>{t domain="goods"}值{/t}</td>
									</tr>
								</thead>
								<tbody class="term_meta_edit" data-id="{$cat_info.cat_id}" data-active="{url path='goods/admin_category/update_term_meta'}">
									<!-- {foreach from=$data_term_meta item=term_meta} -->
									<tr>
										<td>
											<input class="span12" type="text" name="term_meta_key" value="{$term_meta.meta_key}" />

											<input type="hidden" name="term_meta_id" value="{$term_meta.meta_id}">
											<a class="data-pjax btn m_t5" data-toggle="edit_term_meta" href="javascript:;">{t domain="goods"}更新{/t}</a>
											<a class="ajaxremove btn btn-danger m_t5" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要删除该自定义栏目吗？{/t}" href='{url path="goods/admin_category/remove_term_meta" args="meta_id={$term_meta.meta_id}"}'>{t domain="goods"}删除{/t}</a>

										</td>
										<td><textarea class="span12 h70" name="term_meta_value">{$term_meta.meta_value}</textarea></td>
									</tr>
									<!-- {/foreach} -->
								</tbody>
							</table>
							<!-- {/if} -->

								<!-- 编辑区域 -->
								<label><b>{t domain="goods"}添加自定义栏目：{/t}</b></label>

								<div class="term_meta_add" data-id="{$cat_info.cat_id}" data-active="{url path='goods/admin_category/insert_term_meta'}">
								<table class="table smpl_tbl ">
									<thead>
										<tr>
											<td class="span4">{t domain="goods"}名称{/t}</td>
											<td>{t domain="goods"}值{/t}</td>
										</tr>
									</thead>
									<tbody class="term_meta_edit" data-id="{$cat_info.cat_id}" data-active="{url path='goods/admin_category/update_term_meta'}">
										<tr>
											<td>
												<!-- {if $term_meta_key_list} -->
												<select class="span12" data-toggle="change_term_meta_key" >
													<!-- {foreach from=$term_meta_key_list item=meta_key} -->
													<option value="{$meta_key.meta_key}">{$meta_key.meta_key}</option>
													<!-- {/foreach} -->
												</select>
												<input class="span12 hide" type="text" name="term_meta_key" value="{$term_meta_key_list.0.meta_key}" />
												<div><a data-toggle="add_new_term_meta" href="javascript:;">{t domain="goods"}添加新栏目{/t}</a></div>
												<!-- {else} -->
												<input class="span12" type="text" name="term_meta_key" value="" />
												<!-- {/if} -->
												<a class="btn m_t5" data-toggle="add_term_meta" href="javascript:;">{t domain="goods"}添加自定义栏目{/t}</a>
											</td>
											<td><textarea class="span12" name="term_meta_value"></textarea></td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- 自定义栏目模板区域 END -->
						</div>
					</div>
				</div>
			</div>
			<!-- {/if} -->

		</div>
		<div class="right-bar move-mod">
			<div class="foldable-list move-mod-group edit-page" id="goods_info_sort_brand">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_brand">
							<strong>{t domain="goods"}促销信息{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in in_visable collapse" id="goods_info_area_brand">
						<div class="accordion-inner">
							<div class="control-group control-group-small">
								<label class="control-label">{t domain="goods"}排序：{/t}</label>
								<div class="controls">
									<input class="w200" type="text" name='sort_order' {if $cat_info.sort_order}value='{$cat_info.sort_order}'{else} value="50"{/if} size="15" />
								</div>
							</div>
							<div class="control-group control-group-small">
								<label class="control-label">{t domain="goods"}是否显示：{/t}</label>
								<div class="controls chk_radio">
									<input type="radio" name="is_show" id="" value="1" {if $cat_info.is_show neq 0}checked="checked"{/if}  /><span>{t domain="goods"}是{/t}</span>
									<input type="radio" name="is_show" id="" value="0" {if $cat_info.is_show eq 0}checked="checked"{/if}  /><span>{t domain="goods"}否{/t}</span>
								</div>
							</div>
							<div class="control-group control-group-small">
								<label class="control-label">{t domain="goods"}首页推荐：{/t}</label>
								<div class="controls chk_radio">
									<input type="checkbox" name="cat_recommend[]" value="1"  {if $cat_recommend[1] eq 1}checked="checked"{/if}  /><span>{t domain="goods"}精品{/t}</span>
									<input type="checkbox" name="cat_recommend[]" value="2"  {if $cat_recommend[2] eq 1}checked="checked"{/if}  /><span>{t domain="goods"}最新{/t}</span>
									<input type="checkbox" name="cat_recommend[]" value="3"  {if $cat_recommend[3] eq 1}checked="checked"{/if}  /><span>{t domain="goods"}热门{/t}</span>
									<span class="help-block">{t domain="goods"}设置为首页推荐{/t}</span>
								</div>
							</div>
							<!-- {if $cat_info.cat_id} -->
							<input type="hidden" name="old_cat_name" value="{$cat_info.cat_name}" />
							<input type="hidden" name="cat_id" value="{$cat_info.cat_id}" />
							<button class="btn btn-gebo" type="submit">{t domain="goods"}更新{/t}</button>
							<!-- {else} -->
							<button class="btn btn-gebo" type="submit">{t domain="goods"}确定{/t}</button>
							<!-- {/if} -->
						</div>
					</div>
				</div>
			</div>

			<div class="foldable-list move-mod-group" id="goods_info_sort_img">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_img">
							<strong>{t domain="goods"}分类图片{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="goods_info_area_img">
						<div class="accordion-inner">
							<label>{t domain="goods"}上传分类图片：{/t}</label>
							<div class="ecjiaf-db">
								<div class="fileupload {if $cat_info.category_img}fileupload-exists{else}fileupload-new{/if} m_t10" data-provides="fileupload">
									<div class="fileupload-preview fileupload-exists thumbnail"><input type="hidden" name="old_img" value="1" />{if $cat_info.category_img}<img src="{$cat_info.category_img}" >{/if}</div>
									<div>
										<span class="btn btn-file">
											<span class="fileupload-new">{t domain="goods"}选择分类图片{/t}</span>
											<span class="fileupload-exists">{t domain="goods"}修改分类图片{/t}</span>
											<input type="file" name="cat_img" />
										</span>
										<a class="btn fileupload-exists" {if $cat_info.category_img eq ''} data-dismiss="fileupload" href="javascript:;"  {else} data-toggle="removefile" data-msg="{t domain="goods"}您确定要删除该分类图片吗？{/t}" data-href='{url path="goods/admin_category/remove_logo" args="cat_id={$cat_info.cat_id}"}' data-removefile="true"{/if}>{t domain="goods"}删除{/t}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="foldable-list move-mod-group" id="goods_info_sort_tvimg">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_tvimg">
							<strong>{t domain="goods"}分类广告{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in in_visable collapse" id="goods_info_area_tvimg">
						<div class="accordion-inner">
						    <div class="control-group">{t domain="goods"}当前广告位：{/t}<br/>
						    <span class="m_t5 ecjiaf-ib">
						    <!-- {if $category_ad.position_id} -->
						    {$category_ad.position_name}
						    <a class="ajaxremove ecjiafc-red m_l10" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要移除此分类广告么？{/t}" href='{url path="goods/admin_category/remove_ad" args="cat_id={$cat_info.cat_id}"}'>{t domain="goods"}移除{/t}</a>
						    {else}{t domain="goods"}未设置{/t}{/if}
						    </span>
						    </div>
							<!-- <label>请选择一个广告位，作为您的分类广告</label> -->
							<div class="control-group">
							    <input type='text' name='ad_search' class='keywords'/>
    							<input type='button' class='btn ad_search' value="{t domain="goods"}搜索{/t}" data-url="{url path='goods/admin_category/search_ad'}"/>
    							<span class="help-block" style="margin-top: 5px;">{t domain="goods"}请先搜索并选择一个广告位作为此分类广告{/t}</span>
							</div>
							<div class="control-group ">
    							<select name='category_ad' class="ad_list">
    								<!-- {if $category_ad.position_id} -->
    									<option value="{$category_ad.position_id}">{$category_ad.position_name}</option>
    								<!-- {else} -->
    									<option value='-1'>{t domain="goods"}请先搜索再选择{/t}</option>
    								<!-- {/if} -->
    							</select>
    						</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
</form>
<!-- {/block} -->