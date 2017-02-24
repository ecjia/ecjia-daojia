<div class="move-mod-group chart-mod1" id="widget_admin_dashboard_salesChart">
	<h3 class="move-mod-head">销售走势图</h3>
	<canvas id="sales-chart"></canvas>
	<style type="text/css">
		.chart-mod1 {
			padding: 20px;
			border-radius: 10px;
			margin-bottom: 20px;
			box-sizing: border-box;
		}
		.chart-mod1 h3 {
			text-align: center;
			color: #fff;
			font-weight: normal;
		}
		.chart-mod1 canvas {
			width: 100%;
			height: 300px;
		}
		#widget_admin_dashboard_salesChart {
			position: relative;
			width: 100%;
			background: #54bcd8;
		}
	</style>
	<script type="text/javascript">
		{literal}
		$(function(){
			var ctx = document.getElementById('sales-chart').getContext("2d"),
    	{/literal}
			data = {
				labels : [{$sale_arr.day}],
				datasets : [{
					fillColor: "#fff",//填充色
					strokeColor: "#fff",//边框色
					data: [{$sale_arr.price}]
				}]
			},
		{literal}
			options = {
				//刻度线
				scaleLineColor : "#fff",

				//左侧刻度线是否显示
				scaleShowLabels : true,
				
				//刻度标签
				scaleLabel : "<%=value%>元",
				
				//底部刻度文字
				scaleFontColor : "#fff",	
				
				//刻度显示网格线
				scaleShowGridLines : false,
				
				//柱状条的宽度
				barStrokeWidth : 2,
				
				//柱状条间距
				barValueSpacing : 2,

				//响应式
				responsive : true,
				
				//是否有动画图表
				animation : true,

				//泡泡里字体
				tooltipEvents: ["touchstart", "touchmove"],//"mousemove", 
				tooltipFontSize : 10,
				//标题文字
				// tooltipTitleFontSize : 12,
				tooltipTitleFontStyle: "normal",
				//填充各地提示文本像素宽度
				// tooltipYPadding : 3,
				// tooltipXPadding : 3,

				//大小的提示插入符
				tooltipCaretSize : 4,

				//像素的工具提示边界半径
				tooltipCornerRadius : 4,

				//从像素点X偏移工具提示边缘
				// tooltipXOffset : 100, 
				// tooltipYOffset : 100, 
				tooltipTemplate : "<%= value %>", //"<%if (label){%><%=label%>: <%}%><%= value %>",

				// multiTooltipTemplate: "<%= value %>",

				//动画速度
				animationSteps : 160,
				
				//动画效果
				animationEasing : "easeOutBounce"//easeOutBounce、easeOutQuart
			}
			var charts = new Chart(ctx).Bar(data,options);
			$('#sales-chart').parents('.move-mod').find('.move-mod-group').on('mouseup', function(e) {
				charts.update();
			});
		})
		{/literal}
	</script>
</div>