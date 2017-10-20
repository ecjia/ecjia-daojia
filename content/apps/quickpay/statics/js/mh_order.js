// JavaScript Document
;(function (app, $) {
    app.order_list = {
        init: function () {
        	//筛选功能
        	$(".screen-btn").on('click', function(e){
				e.preventDefault();
				var activity_type = $("select[name='activity_type']").val();
				var url = $("form[name='searchForm']").attr('action');
				if (activity_type != '') {
	                   url += '&activity_type=' + activity_type;
	            }
                ecjia.pjax(url);
			});
        	
        
            //搜索功能
            $("form[name='searchForm'] .btn-primary").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            
            
            //列表快速审核触发
           $("a[data-toggle='modal']").on('click', function (e) {
                var $this = $(this);
                var order_id = $this.attr('order-id');
                $("#note_btn").on('click', function (e) {
                    e.preventDefault();
                    var url = $("form[name='actionForm']").attr('action');
                    var action_note = $("textarea[name='action_note']").val();;
                    var option = {
                    	'action_note' : action_note,
                    	'order_id' : order_id
                    };
                    $.post(url, option, function (data) {
                         ecjia.merchant.showmessage(data);
                         location.href = data.url;
                    }, 'json');
                });
			})
        }
    };
    
    app.order_info = {
	    init: function () {
	    	 $(".change_status").on('click', function (e) {
	             e.preventDefault();
	             var url = $(this).attr('data-href');
	             var action_note = $("textarea[name='action_note']").val();
	             var order_id = $("input[name='order_id']").val();
	             var type_info = $("input[name='type_info']").val();
	             var option = {
	             	'action_note' : action_note,
	             	'order_id'    : order_id,
	             	'type_info'	  : type_info
	             };
	             $.post(url, option, function (data) {
	                  ecjia.merchant.showmessage(data);
	             }, 'json');
	         });
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
})(ecjia.merchant, jQuery);
 
// end