// JavaScript Document
;(function (app, $) {
    app.payrecord_list = {
        init: function () {
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });
            
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var url				= $("form[name='searchForm']").attr('action');
				var start_date		= $("input[name='start_date']").val();
				var end_date		= $("input[name='end_date']").val(); 
				var refund_type = $("select[name='refund_type']").val();
				var keywords = $("input[name='keywords']").val();
				
				if (start_date != '' && end_date !='') {
					if (start_date >= end_date && (start_date != '' && end_date !='')) {
						var data = {
							message : "查询的开始时间不能大于结束时间！",
							state : "error",
						};
						ecjia.admin.showmessage(data);
						return false;
					} else {
						url += '&start_date=' + start_date + '&end_date=' +end_date
					}
				}
				
				if (refund_type != '') {
	                url += '&refund_type=' + refund_type;
	            }
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
				ecjia.pjax(url);
			});
        }
    };
    
    app.payrecord_info = {
            init: function () {
        		$('div.refund_content').imagesLoaded(function() {
    				$('div.refund_content a.up-img').attr('rel', 'gallery').colorbox({
    					maxWidth: '80%',
    					maxHeight: '80%',
    					opacity: '0.8',
    					loop: true,
    					slideshow: false,
    					fixed: true,
    					speed: 300,
    				});
    			});
        		
            	$(".back-logo").click(function() {
            		$(".back-logo").removeClass('active');
            		$(this).addClass('active');
            		$("input[name='back_type']").val($(this).attr('data-type'));
            	});
            	
			    var $form = $("form[name='theForm']");
			    var option = {
			        rules: {
			        	back_content: {
			                required: true
			            }
			        },
			        messages: {
			        	back_content: {
			            	required: "请输入退款操作备注"
			            }
			        },
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
    
})(ecjia.admin, jQuery);
 
// end