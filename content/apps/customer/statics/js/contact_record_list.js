// JavaScript Document
;
(function(app, $) {
	var detail_url;
    app.contact_record_list = {
        init: function() {
        	batch_share_url = $("a[name=detail_ture]").attr("data-url");
        	
        	app.contact_record_list.search_keywords();
            app.contact_record_list.search_contact_time();
            app.contact_record_list.check_detail();
        },
        search_keywords: function() {
        	$('.screen-btn').on('click', function(e) {
    			e.preventDefault();
    			var adminner		= $("select[name='adminner']").val(); //员工
    			var way				= $("select[name='way']").val(); //员工
    			var keywords		= $("input[name='keywords']").val(); 		//关键字
    			var url				= $("form[name='theForm']").attr('action'); //请求链接
    			if(adminner			== 'undefined')adminner ='';
    			if(way				== 'undefined')way ='';
    			if(keywords		    == 'undefined')keywords ='';
    			if(url        		== 'undefined')url ='';
    			ecjia.pjax(url + '&adminner=' + adminner + '&way=' + way + '&keywords=' + keywords);
    		});
        },
        search_contact_time : function(){
			$(".date").datetimepicker({
				format: "yyyy-mm-dd hh:ii"
			});
			$('.btn-select').on('click', function(e) {
				e.preventDefault();
				var contact_time1		= $("input[name='contact_time1']").val(); 		//联系时间1
				var contact_time2		= $("input[name='contact_time2']").val(); 		//联系时间2
				var url					= $("form[name='searchForm']").attr('action'); //请求链接
				if(contact_time1		== 'undefined')contact_time1 ='';
				if(contact_time2		== 'undefined')contact_time2 ='';
				if(url        		== 'undefined')url ='';
				if (contact_time1 > contact_time2 && (contact_time1 != '' && contact_time2 !='')) {
					var data = {
							message : "开始时间不得大于结束时间！",
							state : "error",
					};
					ecjia.admin.showmessage(data);
					return false;
				}
				ecjia.pjax(url + '&contact_time1=' + contact_time1 + '&contact_time2=' + contact_time2);
			});
		},
		check_detail : function() {
			$(".feedback-detail").on('click', function(e) {
				var url = $(this).attr('data-url');
				$('#movetype').modal('show');
				 $('#modal-body_new').show();
				 $('.modal-body').hide();
				$.get(url,'',function(data) {
					 $('#modal-body_new').hide();
					 $('.modal-body').show();
					 $('#customer_name').html(data.message.customer_name);
					 $('.state_name').html(data.message.state_name);
					 if((data.message.link_man_name !='') && (data.message.sex_new !='')){
						 $('.link_man_name').html(data.message.link_man_name + '&nbsp;' + '（' + data.message.sex_new + '）');
					 }
					 $('.way_name').html(data.message.way_name);
					 $('.telphone').html(data.message.telphone);
					 $('.contact_time').html(data.message.contact_time);
					 $('.type_name').html(data.message.type_name);
					 $('.next').html(data.message.next);
					 $('.user_name').html(data.message.user_name);
					 $('.source_name').html(data.message.source_name);
					 $('.summary').html(data.message.summary);
					 $('.next_goal').html(data.message.next_goal);
	             } , 'json');
			});
		},
    };
})(ecjia.admin, jQuery);

// end
