// JavaScript Document
;
(function (app, $) {
	app.chart = {
		//订单概况
		order_general: function () {
			var dataset = [];
			var ticks = [];
			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
				$("#order_general").append(nodata);
			} else {
				$.each(JSON.parse(data), function (key, value) {
					ticks.push(parseInt(value));
				});

				var orderGeneralChart = echarts.init(document.getElementById('order_general'));

				var option = {
					color: ['#6DCEEE'],
					xAxis: {
						type: 'category',
						data: [js_lang.await_pay_order, js_lang.await_ship_order, js_lang.shipped_order, js_lang.returned_order, js_lang.canceled_order, js_lang.succeed_order]
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
				        top: '5%',
				        containLabel: true
				    },
					series: [{
						data: ticks,
						type: 'bar',
						barWidth: '80px',
					}]
				};

				orderGeneralChart.setOption(option);
				
				window.addEventListener("resize", function() {
					orderGeneralChart.resize();
				});
			}
			app.chart.order_type();
		},

		//配送方式
		ship_status: function () {
			var dataset = [];
			var ticks = [];
			var tpl = [];
			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
				$("#ship_status").append(nodata);
			} else {
				$.each(JSON.parse(data), function (key, value) {
					tpl.push(parseInt(value.order_num));
					dataset.push(value.ship_name);
				});
				
				var shipStatusChart = echarts.init(document.getElementById('ship_status'));

				option = {
					color: ['#6DCEEE'],
					xAxis: {
						type: 'category',
						data: dataset
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
								return '订单数量' + ' ：  ' + params.value;
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
						data: tpl,
						type: 'bar',
						barWidth: '80px',
					}]
				};

				shipStatusChart.setOption(option);
				
				window.addEventListener("resize", function() {
					shipStatusChart.resize();
				});
			}
			app.chart.order_type();
		},

		//支付方式
		pay_status: function () {
			var dataset = [];
			var ticks = [];
			var tpl = [];
			if (data == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
				$("#pay_status").append(nodata);
			} else {
				$.each(JSON.parse(data), function (key, value) {
					tpl.push(parseInt(value.order_num));
					dataset.push(value.pay_name);
				});
				
				var payStatusChart = echarts.init(document.getElementById('pay_status'));

				option = {
					color: ['#6DCEEE'],
					xAxis: {
						type: 'category',
						data: dataset
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
								return '订单数量' + ' ：  ' + params.value;
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
						data: tpl,
						type: 'bar',
						barWidth: '80px',
					}]
				};

				payStatusChart.setOption(option);
				
				window.addEventListener("resize", function() {
					payStatusChart.resize();
				});
			}
			app.chart.order_type();
		},

		//订单类型
		order_type: function () {
			var dataset = [];
			var ticks = [];
			var tpl = [];
			if (order_stats_json == 'null') {
				var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>" + js_lang.no_stats_data + "<\/div>";
				$("#order_type_chart").append(nodata);
			} else {
				dataset = JSON.parse(order_stats_json);
				
				var orderTypeChart = echarts.init(document.getElementById('order_type_chart'));
				
				option = {
					backgroundColor: '#fff',
					color: ['#91BE79', '#F0567D', '#4EB2C9', '#DF9D5E'],
					tooltip: {
						trigger: 'item',
						formatter: "{a} <br/>{b} : {c} ({d}%)"
					},
					legend: {
						selectedMode: false,
						bottom: 25,
						data: ['配送', '团购', '到店', '自提']
					},
					series: [{
						tooltip: {
			                trigger: 'item',
			                formatter: "{b} : {c} ({d}%)"
			            },
						type: 'pie',
						radius: '70%',
						center: ['50%', '40%'],
				        label: {
				            normal: {
				                position: 'inner',
				                formatter: function(param) {
				                    if (!param.percent) return ''
				                    var f = Math.round(param.percent * 10) / 10;
				                    var s = f.toString();
				                    var rs = s.indexOf('.');
				                    if (rs < 0) {
				                        rs = s.length;
				                        s += '.';
				                    }
				                    while (s.length <= rs + 1) {
				                        s += '0';
				                    }
				                    return s + '%';
				                },
				                textStyle: {
				                    color: '#fff',
				                    fontSize: 12
				                }
				            }
				        },
						labelLine: {
							normal: {
								show: false
							}
						},
						data: dataset
					}]
				};

				orderTypeChart.setOption(option);
				
				window.addEventListener("resize", function() {
					orderTypeChart.resize();
				});
			}
		}
	};

})(ecjia.merchant, jQuery);

// end