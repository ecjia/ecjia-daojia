// JavaScript Document
;(function (app, $) {
	app.mh_comment = {
		list_search: function () {
        	  $(".no-show-rank").on('click', function (e) {
                  $('.hide-rank').hide();
              });
        	  $(".no-show-img").on('click', function (e) {
                  $('.hide-img').hide();
              }); 
            $(".search_comment").on('click', function (e) {
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keyword']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        },
			
		comment_list: function () {
	    	$(".edit-hidden").mouseover(function(){
	    		$(this).children().find(".edit-list").css('visibility', 'visible');
	   		});
	   		$(".edit-hidden").mouseleave(function(){
	   			$(this).children().find(".edit-list").css('visibility', 'hidden');
	   		});
	   		$(".cursor_pointer").click(function(){
	   			$(this).parent().remove();
	   		})
	   		
	        $("form[name='searchForm'] .btn-primary").on('click', function (e) {
	            e.preventDefault();
	            var url = $("form[name='searchForm']").attr('action');
	            var keywords = $("input[name='keywords']").val();
	            if (keywords != '') {
	                url += '&keywords=' + keywords;
	            }
	            ecjia.pjax(url);
	        });
	   		
	   		app.mh_comment.comment_reply();
        },
        
        comment_reply: function () {			
            $(".comment_reply").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                var comment_id = $(this).attr('data-id');
                var data = {
                	reply_content: $("input[name='reply_content']").val(),
                	comment_id: comment_id
                };
                $.get(url, data, function (data) {
                	ecjia.merchant.showmessage(data);
                }, 'json');
            });
		},
        
		comment_info: function () {
            var $form = $("form[name='theForm']");
            var option = {
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                        	ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        
			
		},
	}
})(ecjia.merchant, jQuery);