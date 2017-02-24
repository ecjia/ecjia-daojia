// JavaScript Document
;(function (app, $) {
    app.account_manage = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
 
            $(".select-button").click(function () {
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: surplus_jslang.check_time,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action');
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
 
                ecjia.pjax(url);
            });
 
            //调用图表控件
            $.fn.peity.defaults.line = {
                strokeWidth: 1,
                delimeter: ",",
                height: 32,
                max: null,
                min: 0,
                width: 50
            };
            $.fn.peity.defaults.bar = {
                delimeter: ",",
                height: 32,
                max: null,
                min: 0,
                width: 50
            };
            $(".p_bar_up").peity("bar", {
                colour: "#6cc334"
            });
            $(".p_bar_down").peity("bar", {
                colour: "#e11b28"
            });
            $(".p_line_up").peity("line", {
                colour: "#b4dbeb",
                strokeColour: "#3ca0ca"
            });
            $(".p_line_down").peity("line", {
                colour: "#f7bfc3",
                strokeColour: "#e11b28"
            });
        }
    };
 
    app.user_surplus = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
 
            app.user_surplus.screen();
            app.user_surplus.search();
        },
        
        screen: function () {
            $(".select-button").click(function () {
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
 
                var url = $("form[name='searchForm']").attr('action');
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
 
                ecjia.pjax(url);
            });
        },
        
        search: function () {
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                if (keywords == '') {
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + keywords;
                ecjia.pjax(url);
            });
        }
    };
 
})(ecjia.admin, jQuery);

// end