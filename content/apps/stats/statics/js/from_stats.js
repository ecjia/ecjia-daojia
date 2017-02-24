// JavaScript Document
;(function (app, $) {
    app.from_stats = {
        init: function () {
            app.from_stats.searchForm();
        },
        searchForm: function () {
            $(".start_date,.end_date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                $("#from_loading").css('display', 'block');
                var start_date = $("input[name=start_date]").val(); 	//开始时间
                var end_date = $("input[name=end_date]").val(); 		//结束时间
                var url = $("form[name='searchForm']").attr('action'); 	//请求链接
                var from_type = $("select option:selected").val();
                var start_time = (new Date(start_date.replace(/-/g, '/')).getTime()) / 1000;
                var end_time = (new Date(end_date.replace(/-/g, '/')).getTime()) / 1000;
                
                if (!from_type) {
                    var data = {
                        message: js_lang.from_type_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                if (start_date == '') {
                    var data = {
                        message: js_lang.start_date_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (end_date == '') {
                    var data = {
                        message: js_lang.end_date_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (start_date > end_date) {
                    var data = {
                        message: js_lang.start_lt_end_date,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (end_time - start_time > 86400 * 90) {
                    var data = {
                        message: js_lang.range_error,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
 
                if (start_date == 'undefind') start_date = '';
                if (end_date == 'undefind') end_date = '';
                if (url == 'undefind') url = '';
                ecjia.pjax(url + '&start_date=' + start_date + '&end_date=' + end_date + '&from_type=' + from_type);
            });
        },
 
        general_data: function () {
            var monthlist = [];
            $.each(js_lang.month_list, function (key, val) {
                monthlist.push(val);
            });
            $("#general_loading").css('display', 'block');
            var dataset = [];
            var ticks = [];
            var label = [];
            var elem = $('#general_data');
            $.ajax({
                type: "POST",
                url: $("#general_data").attr("data-url"),
                dataType: "json",
                success: function (chart_datas) {
                    $("#general_loading").css('display', 'none');
                    if (chart_datas.length == 0) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_records + "<\/div>";
                        $("#general_data").append(nodata);
                    } else {
                        $.each(chart_datas, function (key, val) {
                            var tpl = [];
                            $.each(val, function (k, v) {
                                tpl.push(parseInt(v.access_count));
                            });
                            ticks.push({
                                name: key,
                                data: tpl,
                            });
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'general_data',
                            width: 950,
                            height: 550,
                            plotCfg: {
                                margin: [50, 50, 50] //画板的边距
                            },
                            xAxis: {
                                categories: monthlist
                            },
                            seriesOptions: { //设置多个序列共同的属性
                                lineCfg: { //不同类型的图对应不同的共用属性，lineCfg,areaCfg,columnCfg等，type + Cfg 标示
                                    smooth: true
                                }
                            },
                            tooltip: {
                                valueSuffix: js_lang.times,
                                shared: true, //是否多个数据序列共同显示信息
                                crosshairs: true //是否出现基准线
                            },
                            series: ticks
                        });
                        chart.render();
                    }
                }
            });
        },
    };
    
})(ecjia.admin, jQuery);

// end