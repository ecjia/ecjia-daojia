// JavaScript Document
;(function (app, $) {
    app.searchengine = {
        init: function () {
            app.searchengine.data();
            app.searchengine.search();
        },
        
        search: function () {
            $("select[name='month']").change(function (e) {
                e.preventDefault();
                var month = $("select option:selected").val();
                var url = $(".choost_list").attr('data-url');
                if (!month) {
                    ecjia.pjax(url);
                } else {
                    ecjia.pjax(url + '&month=' + month);
                }
            });
        },
 
        data: function () {
            $("#general_loading").css('display', 'block');
            var dataset = [];
            var ticks = [];
            var elem = $('#general_datas');
            $.ajax({
                type: "POST",
                url: $("#general_datas").attr("data-url"),
                dataType: "json",
                success: function (counts) {
                    $("#general_loading").css('display', 'none');
                    if (counts.length == 0) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_records + "<\/div>";
                        $("#general_datas").append(nodata);
                    } else {
                        if (type == 4) {
                            $.each(counts, function (key, val) {
                                var tpl = [];
                                $.each(val, function (k, v) {
                                    tpl.push(parseInt(v));
                                });
                                ticks.push({
                                    name: key,
                                    data: tpl,
                                });
                            });
 
                            var chart = new AChart({
                                theme: AChart.Theme.SmoothBase,
                                id: 'general_datas',
                                width: 950,
                                height: 550,
                                plotCfg: {
                                    margin: [50, 50, 50] //画板的边距
                                },
                                xAxis: {
                                    categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13',
                                            '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25',
                                            '26', '27', '28', '29', '30', '31'],
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
                        } else if (type == 3) {
                            $.each(counts, function (key, val) {
                                var tpl = [];
                                $.each(val, function (k, v) {
                                    tpl.push(parseInt(v));
                                });
                                ticks.push({
                                    name: key,
                                    data: tpl,
                                });
                            });
 
                            var day_list = [];
                            $.each(js_lang.day_list, function (key, val) {
                                day_list.push(val);
                            });
 
                            var chart = new AChart({
                                theme: AChart.Theme.SmoothBase,
                                id: 'general_datas',
                                width: 950,
                                height: 550,
                                plotCfg: {
                                    margin: [50, 50, 50] //画板的边距
                                },
                                xAxis: {
                                    categories: day_list,
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
                        } else if (type == 2) {
                            $.each(counts, function (key, value) {
                                ticks.push(parseInt(value));
                                dataset.push(key);
                            });
                            var chart = new AChart({
                                theme: AChart.Theme.SmoothBase,
                                id: 'general_datas',
                                width: 1000,
                                height: 500,
                                plotCfg: {
                                    margin: [50, 50, 50] //画板的边距
                                },
                                xAxis: {
                                    categories: dataset
                                },
                                yAxis: {
                                    min: 0
                                },
                                seriesOptions: { //设置多个序列共同的属性
                                    /*columnCfg : { //公共的样式在此配置
                          
                                    }*/
                                },
                                tooltip: {
                                    pointRenderer: function (point) {
                                        return point.yValue;
                                    }
                                },
                                legend: null,
                                series: [{
                                    name: js_lang.times,
                                    type: 'column',
                                    data: ticks,
                            	}]
                            });
                            chart.render();
                        } else if (type == 1) {
                            $.each(counts, function (key, value) {
                                ticks.push(parseInt(value));
                                dataset.push(key);
                            });
                            var chart = new AChart({
                                theme: AChart.Theme.SmoothBase,
                                id: 'general_datas',
                                width: 1000,
                                height: 500,
                                plotCfg: {
                                    margin: [50, 50, 50] //画板的边距
                                },
                                xAxis: {
                                    categories: dataset
                                },
                                yAxis: {
                                    min: 0
                                },
                                seriesOptions: { //设置多个序列共同的属性
                                    /*columnCfg : { //公共的样式在此配置
                          
                                    }*/
                                },
                                tooltip: {
                                    pointRenderer: function (point) {
                                        return point.yValue;
                                    }
                                },
                                legend: null,
                                series: [{
                                    name: js_lang.times,
                                    type: 'column',
                                    data: ticks,
                            	}]
                            });
                            chart.render();
                        }
                    }
                }
            });
        },
    };
    
})(ecjia.admin, jQuery);
 
// end