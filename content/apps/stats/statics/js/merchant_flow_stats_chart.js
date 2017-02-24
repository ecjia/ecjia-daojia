// JavaScript Document
;(function(app, $) {
	app.chart = {
		init : function() {
			app.chart.general_data();
			app.chart.general_datas();
			app.chart.area();
			app.chart.from();
		},
		general_data : function() {
			$("#general_loading").css('display','block');
			var dataset = [];
			var ticks = [];
			var label = [];
			var elem = $('#general_data');
			$.ajax({
				type: "POST",
				url: $("#general_data").attr("data-url"),
				dataType: "json",
				success: function(chart_datas) {
					$("#general_loading").css('display','none');
					if (chart_datas == null) {
						var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
						$("#general_data").append(nodata);
					} else {
						$.each(chart_datas,function(key,val){
							var tpl = [];
							$.each(val,function(k,v){
								tpl.push(parseInt(v.access_count));
							});
							ticks.push({
								name : key,
								data : tpl,
							});
						});
						var chart = new AChart({
							  theme : AChart.Theme.SmoothBase,
					          id : 'general_data',
//					          forceFit : true, //自适应宽度
					          width: 950,
					          height : 550,
					          plotCfg : {
					            margin : [50,50,50] //画板的边距
					          },
					          xAxis : {
					            categories : ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']
					          },
					          seriesOptions : { //设置多个序列共同的属性
					            lineCfg : { //不同类型的图对应不同的共用属性，lineCfg,areaCfg,columnCfg等，type + Cfg 标示
					              smooth : true
					            }
					          },
					          tooltip : {
					            valueSuffix : '次',
					            shared : true, //是否多个数据序列共同显示信息
					            crosshairs : true //是否出现基准线
					          },
					          series : ticks
					    });
					    chart.render();
					}
				}
			});
		},
		
		general_datas : function() {
			var dataset = [];
			var ticks = [];
			var goods_name = new Array();
			var elem = $('#general_datas');
			$("#general_loading").css('display','block');
			$.ajax({
				type: "POST",
				url: $("#general_datas").attr("data-url"),
				dataType: "json",
				success: function(chart_datas) {
					$("#general_loading").css('display','none');
					if (chart_datas == null) {
						var nodata = "<div style='width:100%;height:100%;line-height:500px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
						$("#general_datas").append(nodata);
					} else {
						$.each(chart_datas,function(key,val){
							var tpl = [];
							$.each(val,function(k,v){
								tpl.push(parseInt(v.access_count));
							});
							ticks.push({
								name : key,
								data : tpl,
							});
						});
						var chart = new AChart({
							  theme : AChart.Theme.SmoothBase,
					          id : 'general_datas',
//					          forceFit : true, //自适应宽度
					          width: 950,
					          height : 550,
					          plotCfg : {
					            margin : [50,50,50] //画板的边距
					          },
					          xAxis : {
					        	  categories : ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
					          },
					          yAxis: {        //y轴添加title
					               formatter: function (value) {
					                   return value + '次'; // 返回值即为格式化的结果
					               }
					          },
					          seriesOptions : { //设置多个序列共同的属性
					            lineCfg : { //不同类型的图对应不同的共用属性，lineCfg,areaCfg,columnCfg等，type + Cfg 标示
					              smooth : true
					            }
					          },
					          tooltip : {
					            valueSuffix : '次',
					            shared : true, //是否多个数据序列共同显示信息
					            crosshairs : true //是否出现基准线
					          },
					          series : ticks
					    });
					    chart.render();
					}
				}
			});
		},
		
		area : function(){
			var dataset = [];
			var ticks = [];
			var goods_name = new Array();
			var elem = $('#area_data');
			$("#area_loading").css('display','block');
			$.ajax({
				type: "POST",
				url: $("#area_data").attr("data-url"),
				dataType: "json",
				success: function(area_datas){
					$("#area_loading").css('display','none');
					if (area_datas == null) {
						$("#area_legend").remove();
						$("#area_data").remove();
						var nodata = "<div style='width:100%;height:100%;line-height:300px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
						$(".area_data").append(nodata);
					} else {
						 $.each(area_datas,function(key,value){
					    	ticks.push([key,value]);
					    });
						var chart = new AChart({
				          theme : AChart.Theme.SmoothBase,
				          id : 'area_data',
//				          forceFit : true, //自适应宽度
				          width:700,
				          height : 450,
				          plotCfg : {
				            margin : [50,50,30,50] //画板的边距
				          },
				          legend : null ,//不显示图例
				          seriesOptions : { //设置多个序列共同的属性
				            pieCfg : {
				              allowPointSelect : true,
				              labels : {
				                distance : 40,
				                label : {
				                  //文本信息可以在此配置
				                },
				                renderer : function(value,item){ //格式化文本
				                  return value + ' ' + (item.point.percent * 100).toFixed(2)  + '%';
				                }
				              }
				            }
				          },
				          tooltip : {
				            pointRenderer : function(point){
				              return (point.percent * 100).toFixed(2)+ '%';
				            }
				          },
				          series : [{
				              type: 'pie',
				              name: '地区分布百分比',
				              data: ticks
				          }]
				        });
				        chart.render();
					}
				}
			});
		},
		
		from : function(){
			var dataset = [];
			var ticks = [];
			var goods_name = new Array();
			var elem = $('#from_data');
			$("#from_loading").css('display','block');
			$.ajax({
				type: "POST",
				url: $("#from_data").attr("data-url"),
				dataType: "json",
				success: function(from_datas){
					$("#from_loading").css('display','none');
					if (from_datas == null) {
						$("#from_data").remove();
						$("#from_legend").remove();
						var nodata = "<div style='width:100%;height:100%;line-height:300px;text-align:center;overflow: hidden;'>没有找到任何记录<\/div>";
						$(".from_data").append(nodata);
					} else {
						$.each(from_datas,function(key,value){
					    	ticks.push([key,value]);
					    });
						var chart = new AChart({
					          theme : AChart.Theme.SmoothBase,
					          id : 'from_data',
//					          forceFit : true, //自适应宽度
					          width:700,
					          height : 450,
					          plotCfg : {
					            margin : [50,50,30,50] //画板的边距
					          },
					          legend : null ,//不显示图例
					          seriesOptions : { //设置多个序列共同的属性
					            pieCfg : {
					              allowPointSelect : true,
					              labels : {
					                distance : 40,
					                label : {
					                  //文本信息可以在此配置
					                },
					                renderer : function(value,item){ //格式化文本
					                  return value + ' ' + (item.point.percent * 100).toFixed(2)  + '%';
					                }
					              }
					            }
					          },
					          tooltip : {
					            pointRenderer : function(point){
					              return (point.percent * 100).toFixed(2)+ '%';
					            }
					          },
					          series : [{
					              type: 'pie',
					              name: '来源网站百分比',
					              data: ticks
					          }]
					        });
						chart.render();
					}
				}
			});
		},
	};
})(ecjia.admin, jQuery);

// end
