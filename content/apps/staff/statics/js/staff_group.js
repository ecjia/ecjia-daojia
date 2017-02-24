// JavaScript Document
;(function (app, $) {
    app.staff_group_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .btn-info").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
 
    app.staff_group_edit = {
            init: function () {
        		var $form = $("form[name='groupForm']");
    			var option = {
    		            rules: {
    		            	group_name: "required",
    		            	groupdescribe: "required",
    		            },
    		            messages: {
    		            	group_name: "请输入员工组名称",
    		            	groupdescribe: "请输入员工组描述",
    		            },

    					submitHandler : function() {
    						$form.ajaxSubmit({
    							dataType : "json",
    							success : function(data) {
    								ecjia.merchant.showmessage(data);
    							}
    						});
    					}
    				}
    			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
    			$form.validate(options);
            }
        }
})(ecjia.merchant, jQuery);
 
// end