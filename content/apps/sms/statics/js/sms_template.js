// JavaScript Document
;(function (app, $) {
    app.sms_template_list = {
        init: function () {
            app.sms_template_list.data_table();
        },
 
        data_table: function () {
            $('#plugin-table').dataTable({
                "sDom": "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "iDisplayLength": 15,
                "aLengthMenu": [15, 25, 50, 100],
                "aaSorting": [[2, "asc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": js_lang.sFirst,
                        "sLast": js_lang.sLast,
                        "sPrevious": js_lang.sPrevious,
                        "sNext": js_lang.sNext
                    },
                    "sInfo": js_lang.sInfo,
                    "sZeroRecords": js_lang.sZeroRecords,
                    "sEmptyTable": js_lang.sEmptyTable,
                    "sInfoEmpty": js_lang.sInfoEmpty,
                    "sInfoFiltered": js_lang.sInfoFiltered
                },
                "aoColumns": [
                    {
                        "sType": "string"
                    },
                    {
                        "bSortable": false
                    },
                    {
                        "bSortable": false
                    }
                ],
                "fnInitComplete": function () {
                    $("select").not(".noselect").chosen({
                        add_class: "down-menu-language",
                        allow_single_deselect: true,
                        disable_search_threshold: 8
                    })
                },
            });
        },
 
    };
    
    
    app.sms_template_test = {
        init: function () {
        	 app.sms_template_test.submit_info();
        },
        
        submit_info: function () {
        	 var option = {
                 rules: {
                     mobile: {
                         required: true
                     },
                     sign_name: {
                         required: true
                     }
                 },
                 messages: {
                 	mobile: {
                         required: "请输入手机号"
                     },
                     sign_name: {
                         required: "请输入签名"
                     }
                 },
                 submitHandler: function () {
                     $("form[name='theForm']").ajaxSubmit({
                         dataType: "json",
                         success: function (data) {
                             ecjia.admin.showmessage(data);
                         }
                     });
                 }
             }
             var options = $.extend(ecjia.admin.defaultOptions.validate, option);
             $("form[name='theForm']").validate(options);
        },
    };  
    
    app.sms_template_info = {
        init: function () {
        	app.sms_template_info.ajax_event();
            app.sms_template_info.submit_info();
        },
 
        ajax_event :function(){
        	$("#template_code").change(function () {
    		    var subject_text = $("#template_code option:selected").text();
       		    var subject_val = $("#template_code option:selected").val();
       		    subject = subject_text.replace('['+ subject_val + ']',"");
       		    
        		if (subject_val != 0){
	           		 $('#subject').val(subject);
	   	           	 var url = $("#data-href").val();
	   	             var filters = {
	   	                 'JSON': {
	   	                     'code': subject_val,
	   	                     'channel_code': $("#channel_code").val(),
	   	                 }
	   	             };
	   	             $.post(url, filters, function (data) {
	   	                 app.sms_template_info.ajax_event_data(data);
	   	             }, "JSON");
        		} else {
        			 $('#subject').val('');
        			 $('#content').val('');
        			 $('.help-block').text('')
        		}
        	})
        },
                
        ajax_event_data :function(data){
        	$('#content').val(data.template);
        	$('.help-block').html('');
            if (data.content.length > 0) {
            	var opt = '<span class="help-block">';
                for (var i = 0; i < data.content.length; i++) {
                    opt +=data.content[i] + '<br>';
                };
                opt += '</span>';
                $('.help-block').append(opt);
            } 
            
        },       
 
        submit_info: function () {
            var option = {
                rules: {
                    subject: {
                        required: true
                    },
                    content: {
                        required: true
                    },
                    template_id: {
                        required: true
                    },
                    sign_name: {
                        required: true
                    }
                },
                messages: {
                    subject: {
                        required: js_lang.subject_required
                    },
                    content: {
                        required: js_lang.content_required
                    },
                    template_id: {
                        required: "请输入短信模板ID"
                    },
                    sign_name: {
                        required: "请输入签名"
                    }
                },
                submitHandler: function () {
                    $("form[name='theForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
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