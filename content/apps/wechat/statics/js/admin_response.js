// JavaScript Document
;(function(app, $) {
	app.response = {
		init : function() {
			$('#add_material').on('hide.bs.modal', function () {
				$('#add_material').css('height','200px');
				$('.material_choose_list').css('height','auto');
			})
				
			$(".ajaxswitch").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.admin.showmessage(data);
				}, 'json');
			});	
			$('.search-btn').on('click', function(e) {
				e.preventDefault();
				var keywords	= $("input[name='keywords']").val();
				var url			= $("form[name='search_from']").attr('action'); //请求链接
				if(keywords     == 'undefind')keywords='';
				if(url         	== 'undefind')url='';
				
				if (keywords == '') {
					ecjia.pjax(url);
				} else {
					ecjia.pjax(url + '&keywords=' + keywords);
				}
			});
			
			app.response.theForm();
			app.response.add_material();
		},
		//添加必填项js
		theForm : function() {
			var $form = $("form[name='theForm']");
			var option = {
				rules : {
					rule_name : {required : true},
					rule_keywords : {required : true}
				},
				messages : {
					rule_name : {required : js_lang.rule_name_required},
					rule_keywords : {required : js_lang.rule_keywords_required}
				},
				submitHandler:function(){
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
		
		add_material : function() {
			$('.text-material').on('click',function() {
				$('.material_picture').hide();
				$('.text').removeClass('hidden');
				$('input[name="content_type"]').val('text');
				$('.text').show();
			});
			
			$('.picture-material').on('click',function() {
				$('.material_select_tbody').html('');
				$('.material-table').attr('id','image');
				
				var type = 'image';
				url = $('.material-table').attr('data-url');
				var filters = {
					'JSON' : {
						'type' : type
					}
				};
				$.get(url, filters, function(data) {
					app.response.load_material_list(data);
				}, "JSON");
				
			});
			
			$('.music-material').on('click',function() {
				$('.material_select_tbody').html('');
				$('.material-table').attr('id','voice');
				
				var type = 'voice';
				url = $('.material-table').attr('data-url');
				var filters = {
					'JSON' : {
						'type' : type
					}
				};
				$.get(url, filters, function(data) {
					app.response.load_material_list(data);
				}, "JSON");
				
			});
			
			$('.video-material').on('click',function() {
				$('.material_select_tbody').html('');
				var type = 'video';
				
				$('.material-table').attr('id','video');
				url = $('.material-table').attr('data-url');
				var filters = {
					'JSON' : {
						'type' : type
					}
				};
				$.get(url, filters, function(data) {
					app.response.load_material_list(data);
				}, "JSON");
				
			});
			
			$('.list-material').on('click',function() {
				$('.material_select_tbody').html('');
				var type = 'news';

				$('.material-table').attr('id','news');
				$('.material-table').addClass('news');
				url = $('.material-table').attr('data-url');
				var filters = {
					'JSON' : {
						'type' : type
					}
				};
				$.get(url, filters, function(data) {
					app.response.load_material_list(data);
				}, "JSON");
				
			});
			
			$('.material_verify').on('click', function(){
				var type = $('.material-table').attr('id');
				
				$('input[name="content_type"]').val(type);
				$('.text-material').die();
				var id = $("input[name='media_id']").val();
				if (id == undefined || id == '') {
					$('#add_material').modal('hide');
					smoke.alert(js_lang.select_material);
					return false;
				}
				url = $('.material_choose').attr('data-url');
				var filters = {
					'JSON' : {
						'id' : id,
						'type' : type
					}
				};
				$.get(url, filters, function(data) {
					app.response.load_material_verify(data);
				}, "JSON");
			});
			
		},
		
		load_material_list : function(data) {
			if (data.content != null) {
				if (data.content.length > 0) {
					for (var i = 0; i < data.content.length; i++) {
						if (data.content[i].type == 'news') {
							var opt = '<tr class="seleted_material" value="'+data.content[i].id+'"><td colspan="4"><div class="wmk_grid ecj-wookmark wookmark_list articles_picture"><ul class="wookmark-goods-photo move-mod nomove"><li class="thumbnail move-mod-group" style="width: 100%;height: auto; border-radius: 6px;">';
							var children = data.content[i].children.file;
							for (var j = 0; j < children.length; j++) {
								if (j == 0) {
									if (children[j].title == null) {
										opt += '<div class="article"><h4 class="f_l"></h4><br><div class="cover"><img src="'+children[j].file+'"/><span>'+ js_lang.no_title +'</span></div></div>';
									} else {
										opt += '<div class="article"><div class="cover"><img src="'+children[j].file+'"/><span>'+children[j].title+'</span></div></div>';
									}
								} else {
									if (children[j].title == null) {
										opt += '<div class="article_list"><div class="f_l">'+ js_lang.no_title +'</div><img src="'+children[j].file+'" width="78" height="78" class="pull-right" /></div>';
									} else {
										opt += '<div class="article_list"><div class="f_l">'+children[j].title+'</div><img src="'+children[j].file+'" width="78" height="78" class="pull-right" /></div>';
									}
								}
							}
							opt += '<div class="news_mask hidden"></div></li></ul></div></td></tr>';
							$('.material_select_tbody').append(opt);
						} else {
							var opt = '<tr class="seleted_material" value="'+data.content[i].id+'"><td colspan="4"><div class="wmk_grid ecj-wookmark wookmark_list articles_picture"><ul class="wookmark-goods-photo move-mod nomove"><li class="thumbnail move-mod-group" style="width: 100%;height: auto; border-radius: 6px;">';
							
							if (data.content[i].title == null) {
								opt += '<div class="article"><h4 class="f_l"></h4><br><div class="cover"><img src="'+data.content[i].file+'"/><span>'+ js_lang.no_title +'</span></div></div>';
							} else if (data.content[i].title == '') {
								opt += '<div class="article"><div class="cover"><img src="'+data.content[i].file+'"/></div></div>';
							} else {
								opt += '<div class="article"><div class="cover"><img src="'+data.content[i].file+'"/><span>'+data.content[i].title+'</span></div></div>';
							}
							opt += '<div class="news_mask hidden"></div></li></ul></div></td></tr>';
							$('.material_select_tbody').append(opt);
						}
					};
					
					$('.material_select_tbody').append('<input type="hidden" name="media_id">');
					
					$('.seleted_material').on('click',function(){
						$("input[name='media_id']").val($(this).attr('value'));
						$('.news_mask').addClass('hidden');
						$(this).find('li').children('.news_mask').removeClass('hidden');
					});
					
					$('#add_material').css('height','570px');
					$('.material_choose_list').css('height','455px');
					$("input[type='radio']").uniform();
					$('.material_verify').parent().parent().removeClass('hide');
				} else {
					$('#add_material').css('height','200px');
					$('.material_choose_list').css('height','auto');
					$('.material_select_tbody').append('<tr><td class="no-records" colspan="5" style="line-height:100px;border-top:0px solid #eee;">' + js_lang.no_material_select + '</td></tr>');
					$('.material_verify').parent().parent().addClass('hide');
				}
			} else {
				$('#add_material').css('height','200px');
				$('.material_choose_list').css('height','auto');
				$('.material_select_tbody').html('');
				$('.material_select_tbody').append('<tr><td class="no-records" colspan="5" style="line-height:100px;border-top:0px solid #eee;">' + js_lang.no_material_select + '</td></tr>');
				$('.material_verify').parent().parent().addClass('hide');
			}
			
		},
		
		load_material_verify : function(data) {
			var type = $('.material-table').attr('id');
			$('.text').hide();
			$('.material_picture').show();
			$('.material_picture').html('');
			if (data.content != null) {
				if (data.content.ids != null) {
					var opt = '<div class="wmk_grid ecj-wookmark wookmark_list material_pictures w200"><div class="thumbnail move-mod-group material_pictures" style="margin-bottom:0px;">';
					for (var i = 0; i < data.content.file.length; i++) {
						if (i == 0) {
							if (data.content.file[i].title == null) {
								opt += '<div class="article"><h4 class="f_l"></h4><br><div class="cover"><img src="'+data.content.file[i].file+'"/><span>'+ js_lang.no_title +'</span></div></div>';
							} else {
								opt += '<div class="article"><div class="cover"><img src="'+data.content.file[i].file+'"/><span>'+data.content.file[i].title+'</span></div></div>';
							}
						} else {
							if (data.content.file[i].title == null) {
								opt += '<div class="article_list"><div class="f_l">'+ js_lang.no_title +'</div><img src="'+data.content.file[i].file+'" width="78" height="78" class="pull-right" /></div>';
							} else {
								opt += '<div class="article_list"><div class="f_l">'+data.content.file[i].title+'</div><img src="'+data.content.file[i].file+'" width="78" height="78" class="pull-right" /></div>';
							}
						}
						opt += '<input type="hidden" name="media_id" value="'+data.content.id+'">';
					}
					opt += '</div></div>';
				} else {
					if (type == 'voice' || type == 'video') {
						var opt = '<img src="'+  data.content.file +'" style="margin:5px 0 5px 5px; width:20%;height:20%;border-radius: 6px;"><div class="material_filename">'+data.content.file_name+'</div><input type="hidden" name="type" value="'+data.content.type+'"><input type="hidden" name="media_id" value="'+data.content.id+'">';
					} else if (type == 'image') {
						var opt = '<img src="'+  data.content.file +'" style="margin:5px 0 5px 5px; width:20%;height:20%;border-radius: 6px;"><input type="hidden" name="type" value="'+data.content.type+'"><input type="hidden" name="media_id" value="'+data.content.id+'">';
					} else if (type == 'news') {
						var opt = '<div class="wmk_grid ecj-wookmark wookmark_list material_pictures w200"><div class="thumbnail move-mod-group "><div class="article_media"><div class="article_media_title">'+data.content.title+'</div><div>'+data.content.add_time+'</div><div class="cover"><img src="'+data.content.file+'" /></div><div class="articles_content">'+data.content.content+'</div></div></div></div><input type="hidden" name="media_id" value="'+data.content.id+'">';
					}
				}
				$('#add_material').modal('hide');
				$('.material_picture').removeClass('hidden').append(opt);
			}
		}
	}
})(ecjia.admin, jQuery);

// end
