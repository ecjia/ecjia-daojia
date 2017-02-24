// JavaScript Document
;(function(admin, $) {
	admin.admin_nav = {
		init : function() {
			$('input[name="navlist_del"]').val('0');
			/* 控制全选点击效果 */
			$(document).on('click', ".checkall", function(){
				var checkbox = $(this).closest( ".accordion-inner" ).find("input[type='checkbox']");
				var checkednum = $(this).closest( ".accordion-inner" ).find("input[type='checkbox']:checked").size();

				if(checkednum == checkbox.size()){
					checkbox.prop("checked",false);
					$.uniform.update(checkbox);
				}else{
					checkbox.prop("checked",true);
					$.uniform.update(checkbox);
				}
			});
			/* 已有元素的排序 */
			admin.admin_nav.load_cookie();
			/* 导航排序调用 */
			admin.admin_nav.nav_sortable();
			/* 提交按钮方法 */
			admin.admin_nav.navlist_submit();
			/* 移除单个菜单 */
			admin.admin_nav.del_nav();
			/* 将菜单加入菜单列表 */
			admin.admin_nav.addtolist();
			/* 选择菜单列表的链接 */
			admin.admin_nav.choose_list();
			/* 手风琴事件 */
			admin.admin_nav.move_accordion();
			/* 导航菜单上传图片*/
			admin.admin_nav.btn_submit();
		},
//		addlist : function() {
//			/* 控制全选点击效果 */
//			$(".checkall").click(function(){
//				var checkbox = $(this).closest( ".accordion-inner" ).find("input[type='checkbox']");
//				var checked = true;
//				checkbox.each(function(){
//					if(!$(this).prop("checked"))checked = false;
//				});
//				if(checked){
//					checkbox.prop("checked",false);
//				}else{
//					checkbox.prop("checked",true);
//				}
//			});
//			/* 创建菜单的点击事件 */
//			admin.admin_nav.add_navlist();
//		},
//
//		/* 创建菜单的点击事件 */
//		add_navlist : function() {
//			/*  */
//			$("#nav_name").change(function(){
//				$(".add_navlist_form .data-pjax").attr("href","index.php?m=admincp&c=navigator&a=update_nav_list&showstate=2&nav_name="+$("#nav_name").val());
//			});
//		},
		/* 已有元素的排序 */
		load_cookie : function() {
			var thisCookie = $.cookie("nav_list");
			if(thisCookie != null) {
				$.each(thisCookie.split(";"),function(i,id) {
					thisSortable = $(".moveaccordion div[class*='span']").not(".not_sortable").get(i);
					if(id != "null"){
						$.each(id.split(","),function(i,id) {
							$("#"+id).appendTo(thisSortable);
						});
					}
				})
			}
		},
		/* 导航排序调用 */
		nav_sortable : function() {
			$(".moveaccordion div[class*='span']").not(".not_sortable").sortable({
				connectWith: ".moveaccordion div[class*='span']",
				helper: "original",
				handle: ".w-box-header",
				cancel: ".sort-disabled",
				forceHelperSize: true,
				forcePlaceholderSize: true,
				tolerance: "pointer",
				activate: function(event, ui) {
					$(".ui-sortable").addClass("sort_ph");
				},
				stop: function(event, ui) {
					$(".ui-sortable").removeClass("sort_ph");
				},
				update: function (e, ui) {
					var values = $(".moveaccordion div[class*='span']").eq(0).find(".w-box");
					jQuery.each(values, function(index,value) {
						$(this).find("input[name='vieworder']").val(index);
					});
				}
			});
		},
		/* 上传单个icon背景图片*/
		btn_submit : function (){
			$(document).off('click', '.btn-submit');
			$(document).on('click', '.btn-submit', function(e){
				e.preventDefault();
				var icon = $(this).parent().parent('form[name="icon-submit"]').find('input[name="icon"]');

				$(this).parent().parent('form[name="icon-submit"]').ajaxSubmit({
					success:function(data){
						dataType:"json",
						icon.val(data.iconimg);
						ecjia.admin.showmessage(data);
					}
				});
			})
		},
		/* 提交按钮方法 */
		navlist_submit : function() {
			$(".navlist_submit").on('click', function(){
				 var nav_type = $("input[name='nav_type']").val(),
				 form_url = $(this).attr('data-url'),
				 navlist_name = $("input[name='navlist_name']").val(),
				 navlist_icon = $("input[name='navlist_icon']").val(),
				 navlist_del = $("input[name='navlist_del']").val(),
				 values = $(".moveaccordion div[class*='span']").eq(0).find(".w-box"),
				 str = "[",
				 len = values.length -1;
				 jQuery.each(values, function(index,value) {
				 	var opennew = $(this).find("input[name='opennew']").prop("checked")?1:0;
				 	var ifshow = $(this).find("input[name='ifshow']").prop("checked")?1:0;
					 str += "{id:'"+$(this).find('input[name="id"]').val()+"',name:'"+$(this).find('input[name="name"]').val()+"',icon:'"+$(this).find('input[name="icon"]').val()+"',url:'"+$(this).find('input[name="url"]').val()+"',ifshow:"+ifshow+',vieworder:'+(index+1)+',opennew:'+opennew+'}';
					 if(index != len)str += ",";
				 });
				 str += "]";
				 var exstr = eval(str);

				 var navlist = {
				 	nav_type		: nav_type,
				 	navlist_name	: navlist_name,
				 	navlist_del		: navlist_del,
				 	nav_list		: exstr
				 };

				$.post(form_url, navlist, function(data){
					ecjia.admin.showmessage(data);
				},"json");
			});
		},
		/* 移除单个菜单 */
		del_nav : function() {
			$( document ).off("click", ".del_nav");
			$(document).on("click", ".del_nav", function(){
				var t = $(this);
				smoke.confirm("确定要移除这个菜单项吗？",function(e){
					if (e){
						if(t.closest( ".w-box" ).find("input[name='id']").val() == "new"){
							t.closest( ".w-box" ).remove();
						}else{
							var del_id = t.closest( ".w-box" ).find("input[name='id']").val();
							var old_id = $('input[name="navlist_del"]').val()?$('input[name="navlist_del"]').val():'';
							var count_id = old_id + ',' + del_id;
							$('input[name="navlist_del"]').val(count_id);
							t.closest( ".w-box" ).remove();
						}
					}
				}, {ok:"确定", cancel:"取消"});
			});
		},
		/* 将菜单加入菜单列表 */
		addtolist : function() {
			$( document ).off("click", '.addtolist');
			$(document).on('click', '.addtolist', function(){
				var len = parseInt($(".moveaccordion .w-box:last").attr("value"))+1;
				if($(this).closest( ".accordion-inner" ).find("input[name='nav_url']").val()){
					/* 获取属性值 */
					var nav_url 	= $(this).closest( ".accordion-inner" ).find(".nav_url").val(),
						nav_name 	= $(this).closest( ".accordion-inner" ).find(".nav_name").val(),
						url 		= $('.hide_url').val();
					$(".moveaccordion").children("div[class*='span']")
					.append('<div class="w-box" id="new'+len+'" value="'+len+'"><div class="w-box-header">'+$.trim(nav_name)+'<span class="fontello-icon-down-open portlet-toggle"></span></div><div class="w-box-content hide"><form method="post" action="'+url+'" name="icon-submit"><input type="hidden" name="id" value="new" /><input type="hidden" name="vieworder" value="'+(len++)+'" /><p>URL:<input type="text" name="url" class="span12" value="'+nav_url+'" /></p><p>导航标签<input type="text" name="name" class="span12" value="'+$.trim(nav_name)+'" /></p><div>标签图标：<div class="fileupload fileupload-new" data-provides="fileupload" style="display:inline"><div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div><span class="btn btn-file"><span  class="fileupload-new">浏览</span><span  class="fileupload-exists">修改</span> <input type="file" name="iconimg" size="35"/></span><a class="btn fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">删除</a></div></div><p><input type="checkbox" name="ifshow" checked />是否显示<input type="checkbox" name="opennew" checked />是否新窗口</p><p><a class="btn btn-mini btn-danger del_nav">移除</a><input class="btn btn-mini btn-success btn-submit" type="submit" style="float:right" value="确定"></p></form></div></div>');
					$("input[type='checkbox'],input[type='radio']").not(".nouniform").uniform();
						
				}else{
					var nav_checkbox = $(this).closest( ".accordion-inner" ).find(".nav_url");
					for (var i = 0; i < nav_checkbox.length; i++) {
						if(nav_checkbox.eq(i).prop("checked")){
							var nav_url 	= nav_checkbox.eq(i).val(),
								nav_name 	= nav_checkbox.eq(i).closest("label").find(".nav_name").text(),
								icon 	 	= nav_checkbox.eq(i).closest("label").find(".nav_url").attr('data-icon'),
								url 		= $('.hide_url').val();
							$(".moveaccordion").children("div[class*='span']")
								.append('<div class="w-box" id="new'+len+'" value="'+len+'"><div class="w-box-header">'+$.trim(nav_name)+'<span class="fontello-icon-down-open portlet-toggle"></span></div><div class="w-box-content hide"><form method="post" action="'+url+'" name="icon-submit"><input type="hidden" name="id" value="new" /><input type="hidden" name="vieworder" value="'+(len++)+'" /><p>URL:<input type="text" name="url" class="span12" value="'+nav_url+'" /></p><p>导航标签<input type="text" name="name" class="span12" value="'+$.trim(nav_name)+'" /></p><div>标签图标：<div class="fileupload fileupload-new" data-provides="fileupload" style="display:inline"><div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div><span class="btn btn-file"><input type="hidden" value="'+ icon +'" name="icon" /><span  class="fileupload-new">浏览</span><span  class="fileupload-exists">修改</span> <input type="file" name="iconimg" size="35"/></span><a class="btn fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">删除</a></div></div><p><input type="checkbox" name="ifshow" checked />是否显示<input type="checkbox" name="opennew" checked />是否新窗口</p><p><a class="btn btn-mini btn-danger del_nav">移除</a><input class="btn btn-mini btn-success btn-submit" type="submit" style="float:right" value="确定"></p></form></div></div>');
							$("input[type='checkbox'],input[type='radio']").not(".nouniform").uniform();
						}
					};
				}
			});
		},
		/* 选择菜单列表的链接 */
		choose_list : function() {
			$( document ).off("click", ".choose_list .btn");
			$(document).on("click", ".choose_list .btn", function(){
				ecjia.pjax("index.php?m=admincp&c=navigator&a=init&type="+$(".choose_list select").val());
			});
		},
		/* 手风琴事件 */
		move_accordion : function() {
			$( document ).off("click", ".moveaccordion .portlet-toggle");
			$( document ).on("click", ".moveaccordion .portlet-toggle", function() {
				var icon = $( this );
				icon.toggleClass( "fontello-icon-down-open fontello-icon-up-open" );
				if(icon.hasClass("fontello-icon-up-open")){
					icon.parent().css({borderBottomRightRadius:"0px",borderBottomLeftRadius:"0px"});
				}else{
					icon.parent().css({borderRadius:"4px"});
				}
				icon.closest( ".w-box" ).find( ".w-box-content" ).stop().toggle();
			});
		}
	};
})(ecjia.admin, $);

//end