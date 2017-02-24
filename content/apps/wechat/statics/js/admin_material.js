// JavaScript Document
;(function(app, $) {
	app.material = {
		init : function() {
			$( ".wookmark_list img" ).disableSelection();
			$('.move-mod').sortable({
				distance: 0,
				revert: false, //缓冲效果   
				handle: '.move-mod-head',
				placeholder: 'ui-sortable-placeholder thumbnail',
				activate: function(event, ui) {
					$('.wookmark-goods-photo').append(ui.helper);
				},
				stop: function(event, ui) {
				},
				sort: function(event, ui) {
				}
			});
			var action = $(".fileupload").attr('data-action');
			var type = $(".fileupload").attr('data-type');
			if (type == 'image') {
				var label = js_lang.upload_images_area;
			} else if (type == 'voice') {
				var label = js_lang.upload_mp3_area;
			}
			$(".fileupload").dropper({
				action 			: action,
				label 			: label,
				maxQueue		: 2,
				maxSize 		: 5242880, // 5 mb
				height 			: 150,
				postKey			: "img_url",
				successaa_upload: function(data) {
					ecjia.admin.showmessage(data);
				}
			});
			app.material.sort_ok();
			app.material.edit_title();
			app.material.loaded_img();
			
			$(".ajaxswitch").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.admin.showmessage(data);
				}, 'json');
			});	
		},
		sort_ok : function() {
			$('[data-toggle="sort-ok"]').on('click', function(e) {
				e.preventDefault();
				var $this 	= $(this),
					url 	= $this.attr('data-saveurl'),
					id 		= $this.attr('data-imgid'),
					val 	= $this.parent().find('.edit-inline').val(),
					info 	= {id : id, val : val};

				$.get(url, info, function(data) {
					$this.parent().find('.edit_title').html(val);
					$this.parent('p').find('.ajaxremove , .move-mod-head , [data-toggle="edit"]').css('display', 'inline-block');
					$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
					ecjia.admin.showmessage(data);
				});
			});
		},
		edit_title : function() {
			$('[data-toggle="edit"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					value = $(this).parent().find('.edit_title').text();
				$this.parent('p').find('.edit_title').html('<input class="edit-inline" type="text" value="' + value + '" />').find('.edit-inline').focus().select();
				
				$this.css('display', 'none').parent('p').find('.ajaxremove , .move-mod-head').css('display', 'none');
				$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'inline-block');

				$('[data-toggle="sort-cancel"]').off('click').on('click', function() {
					$this.parent().find('.edit_title').html(value);
					$this.css('display', 'inline-block').parent('p').find('.ajaxremove , .move-mod-head').css('display', 'inline-block');
					$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
					
				});
			});
		},
		loaded_img : function() {
			$('div.wookmark_list').imagesLoaded(function() {
				$('div.wookmark_list .thumbnail a.bd').attr('rel', 'gallery').colorbox({
					maxWidth		: '80%',
					maxHeight		: '80%',
					opacity			: '0.8', 
					loop			: true,
					slideshow		: false,
					fixed			: true,
					speed			: 300,
				});
			});
		}
	};
	
	app.material_add = {
		init : function() {
			app.material_add.add_material();
			app.material_add.the_Form();
		},
		//添加必填项js
		the_Form : function() {
			$(".start_time,.end_time").datepicker({
				format: "yyyy-mm-dd",
				container : '.main_content',
			});
			var $form = $("form[name='theForm']");
			var option = {
				rules : {
					title	: {required : true},
					video_title : {required : true},
				},
				messages : {
					title	: {required : js_lang.title_placeholder},
					video_title : {required : js_lang.title_placeholder_title},
				},
				submitHandler:function(){
					$form.bind('form-pre-serialize', function(event, form, options, veto) {
						(typeof(tinyMCE) != "undefined") && tinyMCE.triggerSave();
					}).ajaxSubmit({
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
		
		add_material : function() {
			$('.picture-material').on('click',function() {
				$('.material_select_tbody').html('');
				$('.material-table').attr('id','image');
				
				var type = 'news';
				url = $('.material-table').attr('data-url');
				var filters = {
					'JSON' : {
						'type' : type
					}
				};
				
				$.get(url, filters, function(data) {
					app.material_add.load_material_list(data);
				}, "JSON");
			});
			
			
			$('.material_verify').on('click', function(){
				var type = $('.material-table').attr('id');
				$('input[name="content_type"]').val(type);
				var id = '';
				$("input[name=media_id]").each(function() {
		        	if ($(this).val()) {  
		        		id += $(this).val()+'.';
		        	}
		        });
				if (id == undefined || id == '') {
					$('#add_material').modal('hide');
					smoke.alert(js_lang.select_material);
					return false;
				}
				url = $('.material_choose').attr('data-url');
				
				var filters = {
					'JSON' : {
						'id' : id
					}
				};
				$.get(url, filters, function(data) {
					app.material_add.load_material_verify(data);
				}, "JSON");
			});
		},
		
		load_material_list : function(data) {
			if (data.content != null) {
				if (data.content.length > 0) {
					for (var i = 0; i < data.content.length; i++) {
						var opt = '<tr class="seleted_material multi_material" value="'+data.content[i].id+'"><td>'+
						'<td><img src="'+  data.content[i].file +'" style="width:80px;height:80px;border-radius: 6px;"></td>'+
				    	'<td class="w180">'+data.content[i].title+'</td>'+
				    	'<td>'+data.content[i].size+'</td>'+
				    	'<td>'+data.content[i].add_time+'</td></tr>';
						$('.material_select_tbody').append(opt);
					};
					
					$('.seleted_material').on('click',function(){
						var value = $(this).attr('value');
						if (!$(this).hasClass('selected_background')) {
							$(this).addClass('selected_background');
							$('.material_select_tbody').append('<input type="hidden" name="media_id" value="'+value+'" class="material_'+value+'">');
						} else {
							$(this).removeClass('selected_background');
							var class_name = 'material_'+value;
							$('.'+class_name).remove();
						}
					});
					$('#add_material').css('height','420px');
					$('.material_choose_list').css('height','300px');
					$("input[type='radio']").uniform();
					$('.material_verify').parent().parent().removeClass('hide');
				} else {
					$('#add_material').css('height','200px');
					$('.material_choose_list').css('height','auto');
					$('.material_select_tbody').append('<tr><td class="no-records" colspan="5" style="line-height:100px;border-top:0px solid #eee;">'+js_lang.no_material_select+'</td></tr>');
					$('.material_verify').parent().parent().addClass('hide');
				}
			} else {
				$('#add_material').css('height','200px');
				$('.material_choose_list').css('height','auto');
				$('.material_select_tbody').html('');
				$('.material_select_tbody').append('<tr><td class="no-records" colspan="5" style="line-height:100px;border-top:0px solid #eee;">'+js_lang.no_material_select+'</td></tr>');
				$('.material_verify').parent().parent().addClass('hide');
			}
		},
		
		load_material_verify : function(data) {
			$('.content').html('');
			if (data.content != null) {
				$('#add_material').modal('hide');
				$('.image_message').removeClass('hidden');
				var opt = '<div class="wmk_grid ecj-wookmark wookmark_list material_pictures"><ul class="wookmark-goods-photo move-mod nomove"><li class="thumbnail move-mod-group">';
				for (var i = 0; i < data.content.length; i++) {
					if (i == 0) {
						opt += '<div class="article"><div class="cover"><img src="'+data.content[i].file+'"/><span>'+data.content[i].title+'</span></div></div>';
					} else {
						if (data.content[i].title == '') {
							opt += '<div class="article_list"><div class="f_l">'+js_lang.no_title+'</div><img src="'+data.content[i].file+'" width="78" height="78" class="pull-right" /></div>';
						} else {
							opt += '<div class="article_list"><div class="f_l">'+data.content[i].title+'</div><img src="'+data.content[i].file+'" width="78" height="78" class="pull-right" /></div>';
						}
					}
					opt += '<input type="hidden" name="media_id[]" value="'+data.content[i].id+'">';
				}
				opt += '</li></ul></div>';
				$('.content').append(opt);
			} else {
				return false;
			}
		}
	};
	
	app.material_edit = {
		init : function() {
			app.material_edit.clone();
			app.material_edit.edit_area();
			app.material_edit.remove_area();
			app.material_edit.form_submit();
			app.material_edit.title_show();
			app.material_edit.image_show();
			app.material_edit.issue_submit();
			var index = $('.mobile_news_view').find('.select_mobile_area').length;
			if (index >= 8 ) {
				$('.create_news').hide();
			} else {
				$('.create_news').show();
			}
		},
		
		clone : function () {
			$('a[data-toggle="clone-object"]').on('click',function(e){
				$('div.hide').find('input').prop('disabled', true);
				$('div.hide').find('textarea').prop('disabled', true);
				$('div.hide').find('checkbox').prop('disabled', true);
				
				$('.create_news').hide();
				var index = $('.select_mobile_area').length;
				$('.material_info').children().children('h4').html(js_lang.graphic + index);
				
				$('input[name="title"]').val('');
				$('input[name="sort"]').val('');
				$('input[name="author"]').val('');
				$('textarea[name="digest"]').val('');
				$('.fileupload').removeClass('fileupload-exists').addClass('fileupload-new');
				$('.fileupload-preview').children('img').hide();
				$('input[name="is_show"]').attr("checked", false).parent().removeClass('uni-checked');

				$('input[name="id"]').val('');
				$('input[name="link"]').val('http://');
				$('input[name="index"]').val(index-1);
				
				$('.sort_form').hide();
				var $this		= $(this),
					$parentobj	= $($this.attr('data-parent')),
					$parentobj_clonearea = $($this.attr('data-clone-area'))
					before		= $this.attr('data-before') || 'before',
					$childobj	= $($this.attr('data-child')),
					$childobj_clonearea	= $($this.attr('data-child-clone-area')),
					option		= {parentobj : $parentobj, parentobj_clonearea : $parentobj_clonearea, before : before, childobj : $childobj, childobj_clonearea : $childobj_clonearea};
					!$parentobj ? console.log(js_lang.clone_no_parent) : app.material_edit.clone_obj(option);
				
				$(document).unbind('keyup').on("keyup", "input[name^='title']" ,function(){
					$this = $(this);
					if ($this.val() == '') {
						$('.material_info_select').find('.title_show').html(js_lang.title);
					} else {
						$('.material_info_select').find('.title_show').html($this.val());
					}
				});
				
				$(document).unbind('change').on("change", 'input[name^="image_url"]' ,function(){
					$this = $(this);
					var index = $this.parents('.select_mobile_area').index() + 1;
					if ($this.val() == '') {
						$('.material_info_select').find('.show_image').html(js_lang.thumbnail);
					} else {
						setTimeout(function(){
							var src = $this.parents('.controls').find("img").attr('src');
							var html = '<img src="'+src+'"/>';
							$('.material_info_select').find('.show_image').html(html);
						}, 500);
					}
				});
				
//				$("#content").children().find('iframe').contents().find('body.view').html('<p><br></p>');
				var editor = UE.getEditor('content');
				editor.setContent('');
				$('textarea[name="content"]').html('');
			});
		},
		clone_obj(options) {
			if(!options.parentobj)return console.log(js_lang.batch_less_parameter);
			var tmpObj = options.parentobj.clone();
			tmpObj.removeClass('hide');
			tmpObj.removeClass('mobile_news_auxiliary_clone');
			
			(options.before == 'before') ? options.parentobj_clonearea.before(tmpObj) : options.parentobj_clonearea.after(tmpObj);
			if(options.childobj && options.childobj_clonearea) {
				var size = options.childobj_clonearea.children('div').size() + 2;
				if (size >= 9) {
					var error = {'message':js_lang.images_most8, 'state':'error'};
					ecjia.admin.showmessage(error);
					return false;
				}
				$('.material_add_info').children().children('h4').html(js_lang.graphic + size);
				num = size - 1;
			}
			
			//清空默认数据
			options.parentobj.find('input').not(":hidden").val('');
			//编辑区域展示效果js
			app.material_edit.edit_area_show(num);
		},
		edit_area_show : function(num) {
			var tmp = $('.mobile_news_edit').children().eq(num);
			tmp.find('input.material_is_show').attr('type', 'checkbox').uniform();
			tmp.removeClass('hide');
		},
		edit_area : function() {
			$('.icon-pencil').on('click', function (e) {
				e.preventDefault();
				$('.material_info_select').not('.hide').remove();
				$('.create_news').show();
				var index = $(this).parents('.select_mobile_area').index() + 1;
				
				$('.material_info').children().children('h4').html(js_lang.graphic + index);
				var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(index-1);
				
				$(document).unbind('keyup').on("keyup", "input[name^='title']" ,function(){
					if ($(this).val() == '') {
						edit_area.find('.title_show').html(js_lang.title);
					} else {
						edit_area.find('.title_show').html($(this).val());
					}
				});
				
				$(document).unbind('change').on("change", 'input[name^="image_url"]' ,function(){
					$this = $(this);
					if ($(this).val() == '') {
						edit_area.find('.show_image').html(js_lang.thumbnail);
					} else {
						setTimeout(function(){
							var src = $this.parents('.controls').find("img").attr('src');
							var html = '<img src="'+src+'"/>';
							edit_area.find('.show_image').html(html);
						}, 500);
					}
				});
				
				var url = $(this).parent().attr('data-href');
				var id = $(this).parent().attr('data-id')
				
				if (url == undefined || id == undefined) {
					return false;
				}
				$.get(url, id, function(data) {
					$('input[name="title"]').val(data.content.title);
					$('input[name="author"]').val(data.content.author);
					$('input[name="sort"]').val(data.content.sort);
					$('textarea[name="digest"]').val(data.content.digest);
					$('input[name="id"]').val(data.content.id);
					$('input[name="link"]').val(data.content.link);
					$('input[name="index"]').val(index-1);
					
					var img = $('.fileupload-preview').children('img');
					if (data.content.file) {
						$('.fileupload').addClass('fileupload-exists').removeClass('fileupload-new');
						if (img) {
							$('.fileupload-preview').html('<img src="'+data.content.file+'" alt=js_lang.img_priview>')
						} else {
							$('.fileupload-preview').children('img').show().attr('src', data.content.file);
						}
						$('.fileupload').children('a').removeAttr('data-dismiss').attr({'href':data.content.href, 'data-toggle':'ajaxremove', 'data-msg':js_lang.remove_material_cover});
					} else {
						$('.fileupload').removeClass('fileupload-exists').addClass('fileupload-new');
						$('.fileupload-preview').html('');
					}
					if (data.content.is_show == 1) {
						$('input[name="is_show"]').attr("checked", true).parent().addClass('uni-checked');
					} else {
						$('input[name="is_show"]').attr("checked", false).parent().removeClass('uni-checked');
					}
					if (data.content.parent_id != 0) {
						$('.sort_form').hide();
					} else {
						$('.sort_form').show();
					}
					$('.material_info').attr('type', 'checkbox').uniform();
					
//					$("#content").children().find('iframe').contents().find('body.view').html(data.content.content);
					var editor = UE.getEditor('content');
					content = editor.setContent(data.content.content);
					
					$('textarea[name="content"]').html(data.content.content);
				}, "JSON");
				
				app.material_edit.edit_area_show(index);
			});
		},
		remove_area : function () {
			$('[data-toggle="remove_material"]').on('click', function() {
				var $this = $(this);
				var msg = $this.attr('data-msg'),
					id = $this.attr('data-id'),
					url = $this.attr('data-href');
				
				smoke.confirm(msg,function(e){
					if (e){
						$.get(id, url, function(data){
							ecjia.pjax(window.location.href, function(){
								ecjia.admin.showmessage(data);
							});
						}, 'json');
					}
				}, {ok:js_lang.ok, cancel:js_lang.cancel});
			});
			
			$('[data-toggle="remove-obj"]').die().live('click', function() {
				var index = $(this).parents('.select_mobile_area').index();
				$('.mobile_news_view').children().eq(index).remove();
				$('.material_info').children().children('h4').html(js_lang.graphic + index);
				app.material_edit.edit_area_show(index);
				$('.create_news').show();
				
				$('.material_info_select').find('.title_show').html(js_lang.title);
				$('.material_info_select').find('.show_image').html('');
				
				var a = $('.create_news').prev('.select_mobile_area').children('.edit_mask').children('a');
				var id = a.attr('data-id');
				var url = a.attr('data-href');

				$.get(url, id, function(data) {
					$('input[name="title"]').val(data.content.title);
					$('input[name="author"]').val(data.content.author);
					if (data.content.file) {
						$('.fileupload').addClass('fileupload-exists').removeClass('fileupload-new');
						$('.fileupload-preview').children('img').show().attr('src', data.content.file);
					}
					if (data.content.is_show == 1) {
						$('input[name="is_show"]').attr("checked", true).parent().addClass('uni-checked');
					} else {
						$('input[name="is_show"]').attr("checked", false).parent().removeClass('uni-checked');
					}
					$('textarea[name="digest"]').val(data.content.digest);
					
					$("#content").children().find('iframe').contents().find('body.view').html(data.content.content);
					$('textarea[name="content"]').html(data.content.content);
					
					$('input[name="id"]').val(data.content.id);
					$('input[name="link"]').val(data.content.link);
					if (data.content.parent_id != 0) {
						$('.sort_form').hide();
					} else {
						$('.sort_form').show();
					}
					$('.material_info').attr('type', 'checkbox').uniform();
				}, "JSON");
			});
		},
		issue_submit : function () {
			$('.issue').on('click', function(e) {
				var url = $(this).attr('data-url');
				$.get(url, function(data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
			});
		},
		form_submit : function () {
			$('div.hide').find('input').prop('disabled', true);
			$('div.hide').find('textarea').prop('disabled', true);
			$('div.hide').find('checkbox').prop('disabled', true);
			
			var $form = $("form[name='theForm']");	
			var option = {
				rules:{
					title : {required : true},
				},
				messages:{
					title : {required : js_lang.title_placeholder_graphic},
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
		title_show : function () {
			var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(0);
			
			$(document).unbind('keyup').on("keyup", "input[name^='title']" ,function(){
				$this = $(this);
				if ($this.val() == '') {
					edit_area.find('.title_show').html(js_lang.title);
				} else {
					edit_area.find('.title_show').html($this.val());
				}
			});
		},
		image_show : function () {
			var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(0);
			
			$(document).unbind('change').on("change", 'input[name^="image_url"]' ,function(){
				$this = $(this);
				var index = $this.parents('.select_mobile_area').index() + 1;
				if ($this.val() == '') {
					edit_area.eq(0).find('.show_image').html(js_lang.thumbnail);
				} else {
					setTimeout(function(){
						var src = $this.parents('.controls').find("img").attr('src');
						var html = '<img src="'+src+'"/>';
						edit_area.eq(0).find('.show_image').html(html);
					}, 500);
				}
			});
		},
	};
})(ecjia.admin, jQuery);

// end