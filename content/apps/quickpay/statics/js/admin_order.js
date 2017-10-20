// JavaScript Document
;(function (app, $) {
    app.order_list = {
        init: function () {
			app.order_list.screen();
			app.order_list.searchform();
        },
        
        //筛选功能
		screen : function() {
			$(".screen-btn").on('click', function(e){
				e.preventDefault();
				var activity_type = $("select[name='activity_type']").val();
				var url = $("form[name='searchForm']").attr('action');
				if (activity_type != '') {
	                 url += '&activity_type=' + activity_type;
	            }
				ecjia.pjax(url);
			});
		},
		
		//搜索功能
    	searchform : function() {
			$("form[name='searchForm']").on('submit', function(e){
				e.preventDefault();
				var url = $(this).attr('action');
				var keywords = $("input[name='keywords']").val();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url);
			});
		}
    };
    
    app.order_info = {
	    init: function () {
	        var $form = $("form[name='theForm']");
	        var option = {
	            submitHandler: function () {
	                $form.ajaxSubmit({
	                    dataType: "json",
	                    success: function (data) {
	                        ecjia.admin.showmessage(data);
	                    }
	                });
	            }
	        }
	        var options = $.extend(ecjia.admin.defaultOptions.validate, option);
	        $form.validate(options);
	    }
	};
    
	app.order_search = {
		init : function() {
			$(".date").datepicker({
				format: "yyyy-mm-dd",
			});
			app.order_search.theFormsubmit();
		},
		theFormsubmit : function() {
			$("form[name='theForm']").on('submit',  function(e) {
				e.preventDefault();
				app.order_search.search();
			});
		},
		search : function() {
			var $this	= $("form[name='theForm']");
			var url		= $this.attr('action');
			
			$this.find("input").not("input[type='submit'],input[type='button'],input[type='reset']").each(function(i){
				if ($(this).attr("name") != undefined) {
					url += "&" + $(this).attr("name") + "=" + $(this).val();
				}
			});
			
			$this.find("select").each(function(i){
				url += "&" + $(this).attr("name") + "=" + $(this).val();
			});
			ecjia.pjax(url);
		},
	};
})(ecjia.admin, jQuery);
 
// end