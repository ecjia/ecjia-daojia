// JavaScript Document
;(function(app, $) {
	app.staff_logs = {
		init : function(){
			app.staff_logs.sift();
			app.staff_logs.search();
		},
		sift : function(){
			$('form[name="siftForm"]').on('submit', function(e){
				e.preventDefault();
				var ip = $("select[name='ip']").val();
				var userid = $("select[name='userid']").val();
				var url = $("form[name='siftForm']").attr('action');

				if (ip == 'undefind')ip='';
				if (userid == 'undefind')userid='';
				ecjia.pjax(url + '&ip=' + ip + '&user_id=' + userid);
			});
		},
		search : function(){
			$('form[name="searchForm"]').on('submit', function(e){
				e.preventDefault();
				var ip = $("select[name='ip']").val();
				var userid = $("select[name='userid']").val();
				var keyword = $("input[name='keyword']").val();
				var url = $("form[name='searchForm']").attr('action');

				if (ip == 'undefind')ip='';
				if (userid == 'undefind')userid='';
				ecjia.pjax(url + '&ip=' + ip + '&user_id=' + userid + '&keyword=' + keyword);
			});
		}
	};

})(ecjia.merchant, jQuery);

//end