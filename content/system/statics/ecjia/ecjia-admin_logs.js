;(function(admin, $) {
	admin.admin_logs = {
		init : function(){
			admin.admin_logs.del();
			admin.admin_logs.sift();
			admin.admin_logs.search();
		},
		del : function(){
			$('form[name="deleteForm"]').on('submit', function(e){
				e.preventDefault();
				var thisobj = $(this);

				$("select[name='log_date']").val() == 0 ? 
					smoke.alert(admin_logs_lang.choose_delet_time) 
				: 
					smoke.confirm(admin_logs_lang.delet_ok_1 + $("select[name='log_date']").find("option:selected").text() + admin_logs_lang.delet_ok_2,function(e){
						e && thisobj.ajaxSubmit({
							dataType:"json",
							success:function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}, {ok:admin_logs_lang.ok, cancel:admin_logs_lang.cancel});
			});
		},
		sift : function(){
			$('form[name="siftForm"]').on('submit', function(e){
				e.preventDefault();
				var ip = $("select[name='ip']").val();
				var userid = $("select[name='userid']").val();
				var url = $("form[name='siftForm']").attr('action');

				if(ip == 'undefind')ip='';
				if(userid == 'undefind')userid='';
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

				if(ip == 'undefind')ip='';
				if(userid == 'undefind')userid='';
				ecjia.pjax(url + '&ip=' + ip + '&user_id=' + userid + '&keyword=' + keyword);
			});
		}
	};

})(ecjia.admin, jQuery);
