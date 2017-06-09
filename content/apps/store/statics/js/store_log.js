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
		
		formatTimeLabelFunc:function(value, type) {
        	var hours = String(value).substr(0,2);
        	var mins = String(value).substr(3,2);

        	if (hours > 24) {
        		hours = hours - 24;
        		hours = (hours < 10 ? "0"+hours : hours);
        		value = hours+':'+mins;
        		var text = String('次日%s').replace('%s', value);
        		return text;
        	}
        	else {
        		return value;
        	}
        },

        range : function(){
            $('.range-slider').jRange({
                from: 0, to: 2880, step:30,
                scale: ['00:00','04:00','08:00','12:00','16:00','20:00','次日00:00','04:00','08:00','12:00','16:00','20:00','24:00'],
                format: app.store_log.formatTimeLabelFunc,
                width: 600,
                showLabels: true,
                isRange : true
            });
        }
    }
})(ecjia.admin, jQuery);
