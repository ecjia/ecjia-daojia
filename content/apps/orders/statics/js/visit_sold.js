// JavaScript Document
;(function(app, $) {
	app.visit_sold = {
		init : function() {
			app.visit_sold.search();
		},
		
		search : function() {
			$ ("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var cat_id = $("select[name='cat_id']").val();				//分类ID
				var brand_id = $("select[name='brand_id']").val();			//品牌ID
				var show_num = $("input[name='show_num']").val();			//数量
				var url = $("form[name='searchForm']").attr('action');
                if (show_num <= 0) {
                    var data = {
                        message: js_lang.show_num_min,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else {
                    ecjia.pjax(url + '&cat_id=' + cat_id + '&brand_id=' + brand_id + '&show_num=' + show_num);
                }
			});
		}
	};
	
})(ecjia.admin, jQuery);

//end