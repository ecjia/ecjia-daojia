// JavaScript Document
;
(function(app, $) {
    app.contact_plan = {
        init: function() {
        	app.contact_plan.search();
        },
        search: function() {
        	$(".date").datetimepicker({
				format: "yyyy-mm-dd hh:ii"
			});
        	$('.screen-btn').on('click', function(e) {
    			e.preventDefault();
    			var begin_date		= $("input[name='begin_date']").val(); 		//联系时间1
				var end_date		= $("input[name='end_date']").val(); 		//联系时间2
    			var keywords		= $("input[name='keywords']").val(); 		//关键字
    			var url				= $("form[name='theForm']").attr('action'); //请求链接
    			if(begin_date		== 'undefined')begin_date ='';
				if(end_date			== 'undefined')end_date ='';
    			if(keywords		    == 'undefined')keywords ='';
    			if(url        		== 'undefined')url ='';
    			if (begin_date > end_date && (begin_date != '' && end_date !='')) {
					var data = {
							message : "开始时间不得大于结束时间！",
							state : "error",
					};
					ecjia.admin.showmessage(data);
					return false;
				}
    			ecjia.pjax(url + '&begin_date=' + begin_date + '&end_date=' + end_date + '&keywords=' + keywords);
    		});
        },
    };
})(ecjia.admin, jQuery);

// end
