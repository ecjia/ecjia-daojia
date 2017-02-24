// JavaScript Document
;(function (app, $) {
    app.general_stats = {
        init: function () {
            app.general_stats.searchForm();
            app.general_stats.selectForm();
        },
        searchForm: function () {
            $(".year_date").datepicker({
                format: "yyyy",
                container : '.main_content',
            });
            
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                $("#general_loading").css('display', 'block');
 
                var url = $("form[name='searchForm']").attr('action');
                var start_year = $("input[name=start_year]").val();
                var end_year = $("input[name=end_year]").val();
 
                if (start_year != '') {
                    url += '&start_year=' + start_year;
                }
 
                if (end_year != '') {
                    url += '&end_year=' + end_year;
                }
                ecjia.pjax(url);
            });
        },
        
        selectForm: function () {
            $(".month_date").datepicker({
                format: "yyyy-mm",
                container : '.main_content',
            });
            
            $('.screen-btn1').on('click', function (e) {
                e.preventDefault();
                $("#general_loading").css('display', 'block');
 
                var url = $("form[name='selectForm']").attr('action');
                var start_month = $("input[name=start_month]").val();
                var end_month = $("input[name=end_month]").val();
                var type = $("input[name=type]").val();
 
                if (start_month != '') {
                    url += '&start_month=' + start_month;
                }
 
                if (end_month != '') {
                    url += '&end_month=' + end_month;
                }
                ecjia.pjax(url + '&type=' + type);
            });
        }
    };
    
})(ecjia.admin, jQuery);
 
// end