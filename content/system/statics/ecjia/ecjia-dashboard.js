;(function(admin, $) {
	admin.dashboard = {
		init : function() {
			if( jQuery.isFunction(jQuery.fn.sortable) ){
				$('.move-mods .move-mod').sortable({
					connectWith: '.move-mod',
					distance: 5,
					handle: '.move-mod-head',
					placeholder: 'ui-sortable-placeholder',
					items: "div.move-mod-group:not(.not-move)",
					activate: function(event, ui) {
						$(".move-mod").addClass('sort_ph');
						$('.main_content .row-fluid').removeClass('hide');
					},
					stop: function(event, ui) {
						$(".move-mod").removeClass('sort_ph');
						$('.main_content .move-mods').each(function(index) {
							!$('.main_content .move-mods').eq(index).find('.move-mod-group, .hero-unit').length && $('.main_content .move-mods').eq(index).addClass('hide');
						});
					},
					sort: function() {
						$( this ).removeClass( "ui-state-default" );
					},
					update: function (e, ui) {
						/*保存拖动控件排序*/
						ecjia.admin.save_sortIndex('dashboard');
					}
				});
				$( ".move-mod-head" ).disableSelection();
			}
			$('.close').on('click', function() {
				if($(this).next().hasClass('hero-unit')) {
					$(this).parents('.move-mods').addClass('hide');
					var thisCookie = $.cookie('ecjia_dashboard_hide');
					$.cookie('ecjia_dashboard_hide', 1, { expires: 31});
				}
			})
			admin.dashboard.loader();
//			admin.dashboard.goods_statistics();
		},

		loader : function() {
			/* 仪表盘介绍的加载 */
			var dashboard_hide = $.cookie('ecjia_dashboard_hide');
			dashboard_hide == 1 && $('.hero-unit').parent().remove();

			// ecjia.admin.save_sortIndex();
			// console.log(ecjia.admin.get_sortIndex('dashboard'));

			/*拖动控件排序*/
			ecjia.admin.set_sortIndex('dashboard');
			
			/* 排序后隐藏没有内容的预留区域 */
			$('.main_content .move-mods').each(function(index) {
				!$('.main_content .move-mods').eq(index).find('.move-mod-group, .hero-unit').length && $('.main_content .move-mods').eq(index).addClass('hide');
			});
		},
		goods_statistics : function() {
			var dataset = [];
			var ticks = [];
			var goods_name = new Array();
			goods_name["new_goods"]		= "新品推荐";
			goods_name["best_goods"]	= "精品推荐";
			goods_name["hot_goods"]		= "热销推荐";
			goods_name["promote_goods"]	= "促销商品";
			goods_name["warn_goods"]	= "库存警告商品";
			var goods_color = new Array();
			goods_color["new_goods"]	= "#176799";
			goods_color["best_goods"]	= "#42a4bb";
			goods_color["hot_goods"]	= "#78d6c7";
			goods_color["promote_goods"]= "#0000ff";
			goods_color["warn_goods"]	= "#ff0000";
			$.ajax({
				type: "POST",
				url: $("#placeholder").attr("data-url"),
				dataType: "json",
				success: function(datas){
					var index = 0;
					for(var tmp in datas.goods){
						dataset[index] = { label: goods_name[tmp], data : [[index,parseInt(datas.goods[tmp])]] , color : goods_color[tmp] };;
						ticks.push([index,"<a href="+datas.url[tmp]+">" + goods_name[tmp] + "</a>"]);
						index++;
					}
					var elem = $("#placeholder");
					// Setup the flot chart using our data
					fl_d_plot = $.plot(elem, dataset, {
						series: {
							bars: {
								show : true,
								barWidth : 0.3,
								align : "center",
								lineWidth : 2,
								fill: 1
							}
						},
						xaxis: {
							ticks : ticks ,
							autoscaleMargin: .10 //与两端的间距
						},
						legend: {
							show : false ,
						},
						grid: {
							hoverable : true, // 移动到数据上是否显示数据信息
							borderWidth : 0,
							backgroundColor : { colors: ["#ffffff", "#EDF5FF"] }
						}
					});
					
					// Create a tooltip on our chart
					elem.qtip({
						prerender: true,
						content: 'Loading...', // Use a loading message primarily
						position: {
							viewport: $(window), // Keep it visible within the window if possible
							target: 'mouse', // Position it in relation to the mouse
							adjust: { x: 7 } // ...but adjust it a bit so it doesn't overlap it.
						},
						show: false, // We'll show it programatically, so no show event is needed
						style: {
							classes: 'ui-tooltip-shadow ui-tooltip-tipsy',
							tip: false // Remove the default tip.
						}
					});

					// Bind the plot hover
					elem.on('plothover', function(event, coords, item) {
						// Grab the API reference
						var self = $(this),
							api = $(this).qtip(),
							previousPoint, content,

						// Setup a visually pleasing rounding function
						round = function(x) { return Math.round(x * 1000) / 1000; };

						// If we weren't passed the item object, hide the tooltip and remove cached point data
						if (!item) {
							api.cache.point = false;
							return api.hide(event);
						}

						// Proceed only if the data point has changed
						previousPoint = api.cache.point;
						if (previousPoint !== item.seriesIndex) {
							// Update the cached point data
							api.cache.point = item.seriesIndex;

							var x = item.datapoint[0];
							// Setup new content
							content = item.series.label +': '+ round(item.datapoint[1]);

							// Update the tooltip content
							api.set('content.text', content);

							// Make sure we don't get problems with animations
							api.elements.tooltip.stop(1, 1);

							// Show the tooltip, passing the coordinates
							api.show(coords);
						}
					});
				}
			});
		}
	};
	
})(ecjia.admin, $);