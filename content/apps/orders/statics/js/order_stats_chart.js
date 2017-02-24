// JavaScript Document
;(function (app, $) {
    app.chart = {
        init: function () {
            app.chart.order_general();
            app.chart.order_status();
            app.chart.ship_status();
            app.chart.ship_stats();
            app.chart.pay_status();
            app.chart.pay_stats();
        },
        order_general: function () {
            var dataset = [];
            var ticks = [];
            var elem = $('#order_general');
            $.ajax({
                type: "POST",
                url: $("#order_general").attr("data-url"),
                dataType: "json",
                success: function (order_infos) {
                    if (order_infos === null) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
                        $("#order_general").append(nodata);
                    } else {
                        $.each(order_infos, function (key, value) {
                            ticks.push(parseInt(value));
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'order_general',
                            //                            forceFit : true, //自适应宽度
                            width: 1000,
                            height: 500,
                            plotCfg: {
                                margin: [50, 50, 50] //画板的边距
                            },
                            xAxis: {
                            	categories: [
                    	             js_lang.unconfirmed_order,
                    	             js_lang.confirmed_order,
                    	             js_lang.succeed_order,
                    	             js_lang.invalid_order,
				         		],
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
                                name: js_lang.number,
                                type: 'column',
                                data: ticks,
                        	}]
                        });
                        chart.render();
                    }
                }
            });
        },
 
        order_status: function () {
            var dataset = new Array();
            var elem = $('#order_status');
            var tpl = [];
            var datas = [];
            $.ajax({
                type: "POST",
                url: $("#order_status").attr("data-url"),
                dataType: "json",
                success: function (templateCounts) {
                    if (templateCounts === null) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
                        $("#order_status").append(nodata);
                    } else {
                        $.each(templateCounts, function (key, val) {
                            var ticks = [];
                            var categories = [];
                            $.each(val, function (k, v) {
                                ticks.push(parseInt(v));
                                categories.push(k);
                            });
                            datas.push({
                                name: key,
                                data: ticks,
                            });
                            tpl = categories;
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'order_status',
                            //                            forceFit : true, //自适应宽度
                            width: 1000,
                            height: 500,
                            xAxis: {
                                categories: tpl
                            },
                            plotCfg: {
                                margin: [50, 50, 80] //画板的边距
                            },
                            yAxis: {
                                min: 0
                            },
                            tooltip: {
                                shared: true
                            },
                            seriesOptions: {
                                columnCfg: {}
                            },
                            series: datas
                        });
                        chart.render();
                    }
                }
            });
        },
 
        ship_status: function () {
            var dataset = [];
            var ticks = [];
            var tpl = [];
            var elem = $('#ship_status');
            $.ajax({
                type: "POST",
                url: $("#ship_status").attr("data-url"),
                dataType: "json",
                success: function (ship_infos) {
                    if (ship_infos === null) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
                        $("#ship_status").append(nodata);
                    } else {
                        $.each(ship_infos, function (key, value) {
                            tpl.push(parseInt(value.order_num));
                            dataset.push(value.ship_name);
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'ship_status',
                            //                            forceFit : true, //自适应宽度
                            width: 1000,
                            height: 500,
                            plotCfg: {
                                margin: [50, 50, 50] //画板的边距
                            },
                            xAxis: {
                                categories: dataset,
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
                                name: js_lang.number,
                                type: 'column',
                                data: tpl,
                        	}]
                        });
                        chart.render();
                    }
                }
            });
        },
 
        ship_stats: function () {
            var dataset = [];
            var datas = [];
            var elem = $('#ship_stats');
            $.ajax({
                type: "POST",
                url: $("#ship_stats").attr("data-url"),
                dataType: "json",
                success: function (ship_infos) {
                    if (ship_infos === null) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
                        $("#ship_stats").append(nodata);
                    } else {
                        var tpl = [];
                        $.each(ship_infos, function (key, val) {
                            var ticks = [];
                            var categories = [];
                            $.each(val, function (k, v) {
                                ticks.push(parseInt(v));
                                categories.push(k);
                            });
                            datas.push({
                                name: key,
                                data: ticks,
                            });
                            tpl = categories;
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'ship_stats',
                            //                            forceFit : true, //自适应宽度
                            width: 1000,
                            height: 500,
                            xAxis: {
                                categories: tpl
                            },
                            plotCfg: {
                                margin: [50, 50, 80] //画板的边距
                            },
                            yAxis: {
                                min: 0
                            },
                            tooltip: {
                                shared: true
                            },
                            seriesOptions: {
                                columnCfg: {}
                            },
                            series: datas
                        });
                        chart.render();
                    }
                }
            });
        },
 
        pay_status: function () {
            var dataset = [];
            var ticks = [];
            var tpl = [];
            var elem = $('#pay_status');
            $.ajax({
                type: "POST",
                url: $("#pay_status").attr("data-url"),
                dataType: "json",
                success: function (pay_infos) {
                    if (pay_infos === null) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
                        $("#pay_status").append(nodata);
                    } else {
                        $.each(pay_infos, function (key, value) {
                            tpl.push(parseInt(value.order_num));
                            dataset.push(value.pay_name);
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'pay_status',
                            //                            forceFit : true, //自适应宽度
                            width: 1000,
                            height: 500,
                            plotCfg: {
                                margin: [50, 50, 50] //画板的边距
                            },
                            xAxis: {
                                categories: dataset,
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
                                name: js_lang.number,
                                type: 'column',
                                data: tpl,
                        	}]
                        });
                        chart.render();
                    }
                }
            });
        },
 
        pay_stats: function () {
            var dataset = [];
            var ticks = [];
            var datas = [];
            var elem = $('#pay_stats');
            $.ajax({
                type: "POST",
                url: $("#pay_stats").attr("data-url"),
                dataType: "json",
                success: function (pay_stat) {
                    if (pay_stat === null) {
                        var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
                        $("#pay_stats").append(nodata);
                    } else {
                        $.each(pay_stat, function (key, val) {
                            var ticks = [];
                            var categories = [];
                            $.each(val, function (k, v) {
                                ticks.push(parseInt(v));
                                categories.push(k);
                            });
                            datas.push({
                                name: key,
                                data: ticks,
                            });
                            tpl = categories;
                        });
                        var chart = new AChart({
                            theme: AChart.Theme.SmoothBase,
                            id: 'pay_stats',
                            //                            forceFit : true, //自适应宽度
                            width: 1000,
                            height: 500,
                            xAxis: {
                                categories: tpl
                            },
                            plotCfg: {
                                margin: [50, 50, 80] //画板的边距
                            },
                            yAxis: {
                                min: 0
                            },
                            tooltip: {
                                shared: true
                            },
                            seriesOptions: {
                                columnCfg: {}
                            },
                            series: datas
                        });
                        chart.render();
                    }
                }
            });
        },
    };
    
})(ecjia.admin, jQuery);
 
// end