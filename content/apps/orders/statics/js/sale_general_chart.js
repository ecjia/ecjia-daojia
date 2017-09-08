// JavaScript Document
;
(function(app, $) {
	app.chart = {
		init: function() {
			app.chart.order_count();
			app.chart.order_amount();
		},

		order_count: function() {
			var dataset = [];
			var ticks = [];
			var elem = $('#order_count');

			if (templateCounts == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
				$("#order_count").append(nodata);
			} else {
				$.each(JSON.parse(templateCounts), function(index, tmp) {
					dataset.push(parseInt(tmp.order_count));
					ticks.push(tmp.period);
				});
				var chart = new AChart({
					theme: AChart.Theme.SmoothBase,
					id: 'order_count',
					width: 1000,
					height: 550,
					plotCfg: {
						margin: [50, 50, 50] //画板的边距
					},
					xAxis: {
						categories: ticks
					},
					seriesOptions: { //设置多个序列共同的属性
						lineCfg: { //不同类型的图对应不同的共用属性，lineCfg,areaCfg,columnCfg等，type + Cfg 标示
							smooth: true
						}
					},
					legend: null,
					tooltip: {
						valueSuffix: '单',
						shared: true,
						//是否多个数据序列共同显示信息
						crosshairs: false //是否出现基准线
					},
					series: [{
						name: js_lang.order_number,
						data: dataset
					}]
				});
				chart.render();
			}
		},

		order_amount: function() {
			var dataset = [];
			var ticks = [];
			var elem = $('#order_amount');

			if (templateCounts == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
				$("#order_amount").append(nodata);
			} else {
				$.each(JSON.parse(templateCounts), function(index, tmp) {
					dataset.push(parseInt(tmp.order_amount));
					ticks.push(tmp.period);
				});
				var chart = new AChart({
					theme: AChart.Theme.SmoothBase,
					id: 'order_amount',
					width: 1000,
					height: 550,
					plotCfg: {
						margin: [50, 50, 50] //画板的边距
					},
					xAxis: {
						categories: ticks
					},
					seriesOptions: { //设置多个序列共同的属性
						lineCfg: { //不同类型的图对应不同的共用属性，lineCfg,areaCfg,columnCfg等，type + Cfg 标示
							smooth: true
						}
					},
					legend: null,
					tooltip: {
						valueSuffix: '元',
						shared: true,
						//是否多个数据序列共同显示信息
						crosshairs: false //是否出现基准线
					},
					series: [{
						name: js_lang.sales_volume,
						data: dataset
					}]
				});
				chart.render();
			}
		},
	};

})(ecjia.admin, jQuery);

// end