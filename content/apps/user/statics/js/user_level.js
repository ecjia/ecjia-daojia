// JavaScript Document
;
(function (app, $) {
    app.user_level = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container: '.main_content',
            });
            app.user_level.searchForm();
            app.user_level.chart();
        },

        searchForm: function () {
            $('.screen-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var year = $("select[name='year']").val(); //开始时间
                var month = $("select[name='month']").val(); //结束时间
                var url = $("form[name='searchForm']").attr('action'); //请求链接

                if (year == 0 || year == undefined) {
                    ecjia.admin.showmessage({
                        'state': 'error',
                        'message': '请选择年份'
                    });
                    return false;
                }
                url += '&year=' + year;

                if (month != undefined && month != 0) {
                    url += '&month=' + month;
                }
                ecjia.pjax(url);
            });

            $('.search-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $("form[name='searchForm']").attr('action'); //请求链接

                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();

                if (start_date != '' && end_date != '') {
                    if (start_date >= end_date) {
                        var data = {
                            message: '开始时间不能大于或等于结束时间',
                            state: "error",
                        };
                        ecjia.admin.showmessage(data);
                        return false;
                    }
                    var date_diff = DateDiff(end_date, start_date);

                    if (date_diff > 90) {
                        var data = {
                            message: '查询时间间隔不超过90天',
                            state: "error",
                        };
                        ecjia.admin.showmessage(data);
                        return false;
                    }
                }

                if (start_date == '' && end_date != '') {
                    var data = {
                        message: '开始时间不能为空',
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }

                if (start_date != '' && end_date == '') {
                    var data = {
                        message: '结束时间不能为空',
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }

                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;

                if (keywords != '' && keywords != undefined) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        },

        chart: function () {
            var dataset = [];
            var ticks = [];
            if (data.length == 0) {
                var nodata = "<div style='width:100%;height:100%;line-height:400px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
                $('#user_level').html(nodata);
            } else {
                $.each(JSON.parse(data), function (key, value) {
                    if (key < 30) {
                        if (stats == 'order_count') {
                            dataset.push(value.order_count);
                        } else {
                            dataset.push(value.order_money);
                        }
                        ticks.push(value.user_name);
                    }
                });
                var orderStatsChart = echarts.init(document.getElementById('user_level'));
                var option = {
                    color: ['#6DCEEE'],
                    xAxis: {
                        type: 'category',
                        data: ticks
                    },
                    yAxis: {
                        type: 'value'
                    },
                    tooltip: {
                        show: "true",
                        trigger: 'item',
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        padding: [8, 10],
                        extraCssText: 'box-shadow: 0 0 3px rgba(255, 255, 255, 0.4);',
                        formatter: function (params) {
                            if (params.seriesName != "") {
                                return params.name + '：' + params.value;
                            }
                        },
                    },
                    grid: {
                        left: '2%',
                        right: '2%',
                        bottom: '5%',
                        top: '5%',
                        containLabel: true
                    },
                    series: [{
                        data: dataset,
                        type: 'bar',
                        barWidth: '32px',
                    }]
                };

                orderStatsChart.setOption(option);

                window.addEventListener("resize", function () {
                    orderStatsChart.resize();
                });
            }
        },
    };

    function DateDiff(d1, d2) {
        var day = 24 * 60 * 60 * 1000;
        try {
            var dateArr = d1.split("-");
            var checkDate = new Date();
            checkDate.setFullYear(dateArr[0], dateArr[1] - 1, dateArr[2]);
            var checkTime = checkDate.getTime();

            var dateArr2 = d2.split("-");
            var checkDate2 = new Date();
            checkDate2.setFullYear(dateArr2[0], dateArr2[1] - 1, dateArr2[2]);
            var checkTime2 = checkDate2.getTime();

            var cha = (checkTime - checkTime2) / day;
            return cha;
        } catch (e) {
            return false;
        }
    }

})(ecjia.admin, jQuery);

// end