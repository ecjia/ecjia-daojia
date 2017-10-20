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
			var wrapId = 'order_count';
			var elem = $('#' + wrapId);
			if (templateCounts == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
				elem.find(".ajax_loading").hide();
				elem.append(nodata);
			} else {
				$.each(JSON.parse(templateCounts), function(index, tmp) {
					dataset.push(parseInt(tmp.order_count));
					ticks.push(tmp.period);
				});
				var chart = new AChart({
					theme: AChart.Theme.SmoothBase,
					id: wrapId,
					forceFit: true,
					//自适应宽度
					width: '100%',
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
						name: '订单数量',
						data: dataset
					}]
				});
				elem.find(".ajax_loading").hide();
				chart.render();
			}
		},
		order_amount: function() {
			var dataset = [];
			var ticks = [];
			var wrapId = 'order_amount';
			var elem = $('#' + wrapId);
			if (templateCounts == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
				elem.find(".ajax_loading").hide();
				elem.append(nodata);
			} else {
				$.each(JSON.parse(templateCounts), function(index, tmp) {
					dataset.push(parseInt(tmp.order_amount));
					ticks.push(tmp.period);
				});
				var chart = new AChart({
					theme: AChart.Theme.SmoothBase,
					id: wrapId,
					forceFit: true,
					//自适应宽度
					width: '100%',
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
						name: '销售额',
						data: dataset
					}]
				});
				elem.find(".ajax_loading").hide();
				chart.render();
			}
		},
	};
})(ecjia.merchant, jQuery);

// end