;(function (app, $) {
    app.store_log = {
        init : function(){
            app.store_log.sift();
            app.store_log.search();
            app.store_log.del();
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
        },

        del : function(){
			$('form[name="deleteForm"]').on('submit', function(e){
				e.preventDefault();
				var thisobj = $(this);

				$("select[name='log_date']").val() == 0 ?
					smoke.alert(store.choose_delet_time)
				:
					smoke.confirm(store.delet_ok_1 + $("select[name='log_date']").find("option:selected").text() + store.delet_ok_2,function(e){
						e && thisobj.ajaxSubmit({
							dataType:"json",
							success:function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}, {ok:store.ok, cancel:store.cancel});
			});
		},

        range : function(){
            $('.range-slider').jRange({
                from: 0, to: 1440, step:30,
                scale: ['00:00','03:00','06:00', '09:00','12:00' ,'15:00','18:00','21:00','24:00'],
                format: '%s',
                width: 500,
                showLabels: true,
                isRange : true
            });
        }
    }
})(ecjia.admin, jQuery);
