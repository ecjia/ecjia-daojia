// JavaScript Document
;(function (app, $) {
    app.refund_list = {
        init: function () {
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });
            
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var url				= $("form[name='searchForm']").attr('action');
				var start_date		= $("input[name='start_date']").val();
				var end_date		= $("input[name='end_date']").val(); 
				var status = $("select[name='status']").val();
				var keywords = $("input[name='keywords']").val();
				
				if (start_date != '' && end_date !='') {
					if (start_date >= end_date && (start_date != '' && end_date !='')) {
						var data = {
							message : "查询的开始时间不能大于结束时间！",
							state : "error",
						};
						ecjia.merchant.showmessage(data);
						return false;
					} else {
						url += '&start_date=' + start_date + '&end_date=' +end_date
					}
				}
				
				if (status != '') {
	                url += '&status=' + status;
	            }
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
				
				ecjia.pjax(url);
			});
        }
    };
    
    app.refund_info = {
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
            $("#order-money-info").click(function(){
            	$(".order-money-info").toggle();
            });
            
            $("#order-info").click(function(){
            	$(".order-info").toggle();
            });
            
            $("#address-info").click(function(){
            	$(".address-info").toggle();
            });
            
         	$("#mer_reply_content").change(function () {
    		    var reply_text = $("#mer_reply_content option:selected").text();
    		    var reply_val  = $("#mer_reply_content option:selected").val();
        		if (reply_text != '' && reply_val !=''){
	           		 $('#action_note').val(reply_text);
        		} else {
        			 $('#action_note').val('');
        		}
        	})
        	
            $('.change_status').on('click', function(e) {
            	e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-href');
				var type = $this.attr('data-type');
				var action_note = $("#action_note").val();
				var refund_id = $("#refund_id").val();
				var option = {'type' : type, 'action_note' : action_note,'refund_id' : refund_id};
				$.post(url, option, function(data){
					ecjia.merchant.showmessage(data);
				})
			});
        },
    };
    
    app.return_info = {
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
        		
        		$("#order-money-info").click(function(){
        			$(".order-money-info").toggle();
        		});
        		
                $("#order-info").click(function(){
                	$(".order-info").toggle();
                });
                
                $("#address-info").click(function(){
                	$(".address-info").toggle();
                });
                
                $("#mer_reply_content").change(function () {
        		    var reply_text = $("#mer_reply_content option:selected").text();
        		    var reply_val  = $("#mer_reply_content option:selected").val();
            		if (reply_text != '' && reply_val !=''){
    	           		 $('#action_note').val(reply_text);
            		} else {
            			 $('#action_note').val('');
            		}
            	})
                
                //商家审核不通过
                $('.change_status_disagree').on('click', function(e) {
    	    		e.preventDefault();
    				var $this = $(this);
    				var url = $this.attr('data-href');
    				var action_note = $("#action_note").val();
    				var refund_id = $("#refund_id").val();
    				var option = {'type' : 'disagree', 'action_note' : action_note,'refund_id' : refund_id};
    				$.post(url, option, function(data){
    					ecjia.merchant.showmessage(data);
    				})
    			});
                
                //商家审核通过并设置退还方式范围
                $("#note_btn").on('click', function (e) {
                	e.preventDefault();
                    var url = $("form[name='actionForm']").attr('action');
                    var action_note = $("#action_note").val();
    				var refund_id = $("#refund_id").val();
    				var arr = new Array();
  			　　　　  $("input[name=return_shipping_range]:checked").each(function (key, value) {
  			　　　　　　	arr[key] = $(value).val();
  			　　　　  });
                    var option = {'type' : 'agree','action_note' : action_note,'refund_id' : refund_id,'return_shipping_range':arr};
                    $.post(url, option, function (data) {
                         if (data.state == 'success') {
							$('#actionmodal').modal('hide');
							$(".modal-backdrop").remove();
							$("body").removeClass('modal-open');
							ecjia.merchant.showmessage(data);
						 } else {
							var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
							$info.appendTo('.error-msg').delay(5000).hide(0);
						 }
                    }, 'json');
                });
                
                $("#mer_confirm").change(function () {
        		    var confirm_text = $("#mer_confirm option:selected").text();
        		    var confirm_val  = $("#mer_confirm option:selected").val();
            		if (confirm_text != '' && confirm_val !=''){
    	           		 $('#action_note').val(confirm_text);
            		} else {
            			 $('#action_note').val('');
            		}
            	})
                
                //商家确认收货
                $('.confirm_change_status').on('click', function(e) {
                	e.preventDefault();
    				var $this = $(this);
    				var url = $this.attr('data-href');
    				var type = $this.attr('data-type');
    				var action_note = $("#action_note").val();
    				var refund_id = $("#refund_id").val();
    				var option = {'type' : type, 'action_note' : action_note,'refund_id' : refund_id};
    				$.post(url, option, function(data){
    					ecjia.merchant.showmessage(data);
    				})
    			});
            },
        };
    
})(ecjia.merchant, jQuery);
 
// end