// JavaScript Document
;(function(app, $) {
	app.message_template_list = {
		init : function() {
			app.message_template_list.data_table();
		},

		data_table : function() {
			$('#plugin-table').dataTable({
				"sDom": "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"iDisplayLength": 15,
				"aLengthMenu": [15, 25, 50, 100],
				"aaSorting": [[ 2, "asc" ]],
				"oLanguage" : {
					"oPaginate": {
						"sFirst" : 		js_lang.sFirst,
						"sLast" : 		js_lang.sLast,
						"sPrevious" : 	js_lang.sPrevious,
						"sNext" : 		js_lang.sNext,
					},
                    "sInfo": js_lang.sInfo,
                    "sZeroRecords": js_lang.sZeroRecords,
                    "sEmptyTable": js_lang.sEmptyTable,
                    "sInfoEmpty": js_lang.sInfoEmpty,
                    "sInfoFiltered": js_lang.sInfoFiltered
				},
				"aoColumns": [
					{ "sType": "string" },
					{ "bSortable": false },
					{ "bSortable": false }
				],
				"fnInitComplete": function(){
					$("select").not(".noselect").chosen({
						add_class: "down-menu-language",
						allow_single_deselect: true,
						disable_search_threshold: 8
					})
				},
			});
		},

	};
	app.message_template_info = {
		init : function() {
			app.message_template_info.change_editor();
			app.message_template_info.submit_info();
			app.message_template_info.validate_mail();
		},

		change_editor : function() {
			$('[data-toggle="change_editor"]').on('click', function() {
				url = $(this).attr('data-url');
				ecjia.pjax(url);
			});
		},

		submit_info : function() {
			$('[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				var type = $('input[name="mail_type"]:checked').val();
				if(type == 1) {
//					var textinfo = tinyMCE.get('content').getContent();
//					$('#content').css({'display' : 'block', 'height' : '0px', 'padding' : '0px', 'opacity' : 0}).val(textinfo);
				}
			})
		},

		validate_mail : function() {
			var option = {
				rules:{
					template_code : { required : true },
					subject : { required : true },
					content : { required : true }
				},
				messages:{
					template_code : { required : js_lang.template_code_require },
					subject : { required : js_lang.subject_require },
					content : { required : js_lang.content_require }
				},
				submitHandler:function(){
					$("form[name='theForm']").ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$("form[name='theForm']").validate(options);
		},
	};

})(ecjia.admin, jQuery);

// end