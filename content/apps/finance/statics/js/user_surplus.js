// JavaScript Document
;
(function (app, $) {
    app.account_manage = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container: '.main_content',
            });

            $('[data-toggle="tooltip"]').tooltip();

            $(".select-button").off('click').click(function () {
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

            app.account_manage.left_chart();
            app.account_manage.right_chart();
        },

        left_chart: function () {
            var dataset = [];
            var ticks = [];
            if ($.find("#left_stats").length == 0) { return false; }
            if (data == 'null') {
                var nodata = "<div style='width:100%;height:100%;line-height:300px;text-align:center;overflow: hidden;'>没有统计数据<\/div>";
                $("#left_stats").append(nodata);
            } else {
                $.each(JSON.parse(data), function (key, value) {
                    ticks.push(parseInt(value));
                });
                var orderGeneralChart = echarts.init(document.getElementById('left_stats'));

                var option = {
                    title: {
                        left: 'center',
                        text: '（余额分布图）',
                    },
                    color: ['#ABDEE3'],
                    xAxis: {
                        type: 'category',
                        data: ['消费', '充值', '退款', '提现', '冻结']
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
                                return params.name + ' ：  ' + params.value;
                            }
                        },
                    },
                    grid: {
                        left: '2%',
                        right: '2%',
                        bottom: '5%',
                        top: '15%',
                        containLabel: true
                    },
                    series: [{
                        data: ticks,
                        type: 'bar',
                        barWidth: '50px',
                    }]
                };

                orderGeneralChart.setOption(option);

                window.addEventListener("resize", function () {
                    orderGeneralChart.resize();
                });
            }
        },

        right_chart: function () {
            var dataset = [];
            var ticks = [];
            if ($.find("#right_stats").length == 0) { return false; }
            if (right_data == 'null') {
                var nodata = "<div style='width:100%;height:100%;line-height:300px;text-align:center;overflow: hidden;'>没有统计数据<\/div>";
                $("#right_stats").append(nodata);
            } else {
                $.each(JSON.parse(right_data), function (key, value) {
                    ticks.push(parseInt(value));
                });
                var right_chart = echarts.init(document.getElementById('right_stats'));

                var option = {
                    title: {
                        left: 'center',
                        text: '（积分分布图）',
                    },
                    color: ['#ABDEE3'],
                    xAxis: {
                        type: 'category',
                        data: ['下单发放', '积分抵现']
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
                                return params.name + ' ：  ' + params.value;
                            }
                        },
                    },
                    grid: {
                        left: '2%',
                        right: '2%',
                        bottom: '5%',
                        top: '15%',
                        containLabel: true
                    },
                    series: [{
                        data: ticks,
                        type: 'bar',
                        barWidth: '50px',
                    }]
                };

                right_chart.setOption(option);

                window.addEventListener("resize", function () {
                    right_chart.resize();
                });
            }
        }
    };

    app.user_surplus = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container: '.main_content',
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