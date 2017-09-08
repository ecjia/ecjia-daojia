// JavaScript Document
;(function(app, $) {
	app.weapp = {
		init : function() {
			ecjia.admin.weapp.search();
			ecjia.admin.weapp.edit();
			ecjia.admin.weapp.batch_set_label();
			ecjia.admin.weapp.edit_tag();
			ecjia.admin.weapp.edit_remark();
		},
		
		//小程序列表 搜索/筛选
		search : function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val();
				var url = $(this).attr('action'); 
				if (keywords) {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
			//小程序用户列表搜索/筛选
			$("form[name='filterForm']").on('submit', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val();
				var weapp_id = $("select[name='weapp_id']").val();
				var url = $(this).attr('action'); 
				if (keywords) {
					url += '&keywords=' + keywords;
				}
				if (weapp_id) {
					url += '&weapp_id=' + weapp_id;
				}
				ecjia.pjax(url);
			});
			
			//切换小程序账号
			$(".ajaxswitch").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.admin.showmessage(data);
				}, 'json');
			});	
		},
		
		//小程序 添加/编辑
		edit : function() {
			var $form = $('form[name="theForm"]');
			var option = {
				rules:{
					name : {required : true},
					appid : {required : true},
					appsecret : {required : true},
				},
				messages:{
					name : {
						required : "请输入小程序名称",
					},
					appid : {
						required : "请输入appid",
					},
					appsecret : {
						required : "请输入appsecret",
					}
				},
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.admin.showmessage(data); 
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		},
		
		//批量给用户打标签
		batch_set_label : function() {
			$(".set-label-btn").on('click', function(e) {
				var openid = $(this).attr('data-openid');
				var uid = $(this).attr('data-uid');
				searchURL = $(this).attr('data-url');
				var filters = {
					'uid'	: uid,
				};
				if (openid != '' &&　openid != undefined) {
					$('input[name="openid"]').val(openid);
					$('input[name="uid"]').val(uid);
				} else {
					var checkboxes = [];
					$(".checkbox:checked").each(function() {
						checkboxes.push($(this).val());
					});
					if (checkboxes == '') {
						smoke.alert(js_lang.pls_select_user);
						return false;
					} else {
						$('input[name="openid"]').val(checkboxes);
					}
				}
				$('.popover_tag_list').html('');
				$.post(searchURL, filters, function(data) {
					app.weapp.load_opt(data);
				}, "JSON");
				$('#set_label').modal('show');
			});
			
			$(".set_label").on('click', function(e) {
				var $form = $("form[name='label_form']"); 
				$form.ajaxSubmit({
					dataType : "json",
					success : function(data) {
						ecjia.admin.showmessage(data);
						$('#set_label').modal('hide');
					}
				});
			});
		},
		
		load_opt : function(data){
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					if (data.content[i].checked == 1) {
						var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" checked="checked" name="tag_id[]" value="'+data.content[i].tag_id+'"><span class="lbl_content">'+data.content[i].name+'</span></label>');
					} else {
						var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" name="tag_id[]" value="'+data.content[i].tag_id+'"><span class="lbl_content">'+data.content[i].name+'</span></label>');
					}
					$('.popover_tag_list').append($opt);
					$('input[type="checkbox"]').uniform();
				}
			}
			$('.frm_checkbox').click(function() {
				var c = $("input[name='tag_id[]']:checked").length-1, limit = 3;

				$(this).attr('checked') == 'checked' ? c++ : c--;
				if (c > limit){ 
					$(this).attr('checked', false);
					$.uniform.update($(this));
					$(".label_block").show();
					c--;
				} else {
					$(".label_block").hide();
				}
			});
		},
		
		edit_tag : function() {
			$('.subscribe-icon-edit').die().live('click',function() {
				$('input[name="new_tag"]').val('');
				var old_tag_name = $(this).attr('data-name');
				$('.old_tag').html(old_tag_name);
				$('.old_tag_name').show();
				var id = $(this).attr('value');
				$('#edit_tag input[name="id"]').val(id);
				
				var $form = $("form[name='edit_tag']");
				var option = {
					rules:{
						new_tag : {required:true, maxlength:6},
					},
					messages:{
						new_tag : {
							required:js_lang.tag_name_required, maxlength:js_lang.tag_name_maxlength
						}
					},
					submitHandler : function() {
						var new_tag_name = $('input[name="new_tag"]').val();
						if (new_tag_name == old_tag_name) {
							$('#edit_tag').modal('hide');
							return false;
						}
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
								$('#edit_tag').modal('hide');
							}
						});
					}
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			});	
			
			$('.subscribe-icon-plus').die().live('click',function() {
				$('input[name="new_tag"]').val('');
				var $form = $("form[name='add_tag']");
				var option = {
					rules:{
						new_tag : {required:true, maxlength:6},
					},
					messages:{
						new_tag : {required:js_lang.tag_name_required, maxlength:js_lang.tag_name_maxlength}
					},
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
								$('#add_tag').modal('hide');
							}
						});
					}
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			});	
		},
		
		//编辑备注
		edit_remark : function() {
			$('.edit_remark_icon').on('click', function(e) {
				e.preventDefault();
				var remark = $('input[name="remark"]').val();
				$('.remark_info').hide();
				$('.edit_remark_icon').hide();
				$('.remark').show();
			});
			
			$('.remark_ok').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					remark = $('input[name="remark"]').val(),
					url = $('.edit_remark_url').attr('data-url'),
					openid = $('.edit_remark_url').attr('data-openid'),
					page = $('.edit_remark_url').attr('data-page'),
					uid = $('.edit_remark_url').attr('data-uid'),
					old_remark = $('.edit_remark_url').attr('data-remark'),
					info = {remark : remark, openid : openid, page : page, uid : uid};
				if (remark == old_remark) {
					$('.remark_info').show();
					$('.edit_remark_icon').show();
					$('.remark').hide();
				} else {
					$.post(url, info, function(data) {
						ecjia.admin.showmessage(data);
					}, 'json');
				}
			});
			
			$('.remark_cancel').on('click', function(e) {
				e.preventDefault();
				var remark = $('input[name="remark"]').val();
				$('.remark_info').show();
				$('.edit_remark_icon').show();
				$('.remark').hide();
			});
		},
	};
})(ecjia.admin, jQuery);

//end