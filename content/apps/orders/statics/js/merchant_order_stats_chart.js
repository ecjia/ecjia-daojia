// JavaScript Document
;
(function(app, $) {
	app.chart = {
		init: function() {
			app.chart.order_general();
			app.chart.order_status();
			app.chart.ship_status();
			app.chart.ship_stats();
		},
		order_general: function() {
			var dataset = [];
			var ticks = [];
			var wrapId = 'order_general';
			var elem = $('#' + wrapId);

			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
				elem.find(".ajax_loading").hide();
				elem.append(nodata);
			} else {
				$.each(JSON.parse(data), function(key, value) {
					ticks.push(parseInt(value));
				});
				var chart = new AChart({
					theme: AChart.Theme.SmoothBase,
					id: wrapId,
					forceFit: true,
					//自适应宽度
					width: '100%',
					height: 500,
					plotCfg: {
						margin: [50, 50, 50] //画板的边距
					},
					xAxis: {
						categories: ['未确认订单', '已确认订单', '已完成订单', '已取消订单', ],
					},
					yAxis: {
						min: 0
					},
					seriesOptions: { //设置多个序列共同的属性
						/*columnCfg : { //公共的样式在此配置
			 
			            }*/
					},
					tooltip: {
						pointRenderer: function(point) {
							return point.yValue;
						}
					},
					legend: null,
					series: [{
						name: '数量',
						type: 'column',
						data: ticks,
					}]
				});
				elem.find(".ajax_loading").hide();
				chart.render();
			}
		},

		order_status: function() {
			var dataset = new Array();
			var wrapId = 'order_status';
			var elem = $('#' + wrapId);
			var tpl = [];
			var datas = [];
			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
				elem.find(".ajax_loading").hide();
				elem.append(nodata);
			} else {
				$.each(JSON.parse(data), function(key, val) {
					var ticks = [];
					var categories = [];
					$.each(val, function(k, v) {
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
					id: wrapId,
					forceFit: true,
					//自适应宽度
					width: '100%',
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
				elem.find(".ajax_loading").hide();
				chart.render();
			}
		},

		ship_status: function() {
			var dataset = [];
			var ticks = [];
			var tpl = [];
			var wrapId = 'ship_status';
			var elem = $('#' + wrapId);
			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
				elem.find(".ajax_loading").hide();
				elem.append(nodata);
			} else {
				$.each(JSON.parse(data), function(key, value) {
					tpl.push(parseInt(value));
					dataset.push(key);
				});
				var chart = new AChart({
					theme: AChart.Theme.SmoothBase,
					id: wrapId,
					forceFit: true,
					//自适应宽度
					width: '100%',
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
						pointRenderer: function(point) {
							return point.yValue;
						}
					},
					legend: null,
					series: [{
						name: '数量',
						type: 'column',
						data: tpl,
					}]
				});
				elem.find(".ajax_loading").hide();
				chart.render();
			}
		},

		ship_stats: function() {
			var dataset = [];
			var wrapId = 'ship_stats';
			var elem = $('#' + wrapId);
			var tpl = [];
			var datas = [];

			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
				elem.find(".ajax_loading").hide();
				elem.append(nodata);
			} else {
				$.each(JSON.parse(data), function(key, val) {
					var ticks = [];
					var categories = [];
					$.each(val, function(k, v) {
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
					id: wrapId,
					forceFit: true,
					//自适应宽度
					width: '100%',
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
				elem.find(".ajax_loading").hide();
				chart.render();
			}
		},
	};
})(ecjia.merchant, jQuery);

// end