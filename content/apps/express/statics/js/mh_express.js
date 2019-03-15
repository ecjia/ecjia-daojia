// JavaScript Document
;(function (app, $) {
    app.express_list = {
        init: function () {   
            $("form[name='searchForm'] .search_express").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keyword = $("input[name='keyword']").val();
                if (keyword != '') {
                	url += '&keyword=' + keyword;
                }
                ecjia.pjax(url);
            });
            
            /* 列表查看配送员当前位置 */
            $("a[data-toggle='modal']").off('click').on('click', function (e) {
                var $this = $(this);
                var lng = $this.attr('exlng');
                var lat = $this.attr('exlat');
                var name  =$this.attr('exname');
                var mobile =$this.attr('exmobile');
                var home_url =$this.attr('home_url');
                var ex_user_img    =  home_url + "/content/apps/express/statics/images/ex_user.png";
                var lable_text_img =  home_url + "/content/apps/express/statics/images/lable_text.png";
             	//腾讯地图加载
             	var map, markersArray = [];
             	var latLng = new qq.maps.LatLng(lat, lng);
             	var map = new qq.maps.Map(document.getElementById("allmap"),{
             	    center: latLng,
             	    zoom: 18
             	});
             	
         		//创建一个Marker(自定义图片)
         	    var marker = new qq.maps.Marker({
         	        position: latLng, 
         	        map: map
         	    });
         	    
         	    //设置Marker自定义图标的属性，size是图标尺寸，该尺寸为显示图标的实际尺寸，origin是切图坐标，该坐标是相对于图片左上角默认为（0,0）的相对像素坐标，anchor是锚点坐标，描述经纬度点对应图标中的位置
                var anchor = new qq.maps.Point(0, 39),
                    size   = new qq.maps.Size(50,50),
                    origin = new qq.maps.Point(0, 0),
                    icon   = new qq.maps.MarkerImage(
                    	ex_user_img,
                        size,
                        origin,
                        anchor
                    );
                marker.setIcon(icon);

                //创建描述框
             	var Label = function(opts) {
                    qq.maps.Overlay.call(this, opts);
               	}
               	//继承Overlay基类
                Label.prototype = new qq.maps.Overlay();
                //定义construct,实现这个接口来初始化自定义的Dom元素
                Label.prototype.construct = function() {
                     this.dom = document.createElement('div');
                     this.dom.style.cssText =
                          'background:url("'+ lable_text_img +'") no-repeat;width:130px;height:60px;margin-top:-98px;margin-left:-38px;position:absolute;' +
                          'text-align:left;color:white;padding-left:25px;padding-top:6px;';
                     this.dom.innerHTML = name +'<br>'+mobile;
                     //将dom添加到覆盖物层，overlayLayer的顺序为容器 1，此容器中包含Polyline、Polygon、GroundOverlay等
                     this.getPanes().overlayLayer.appendChild(this.dom);

                }
                //绘制和更新自定义的dom元素
                Label.prototype.draw = function() {
                    //获取地理经纬度坐标
                    var position = this.get('position');
                    if (position) {
                        //根据经纬度坐标计算相对于地图外部容器左上角的相对像素坐标
                        //var pixel = this.getProjection().fromLatLngToContainerPixel(position);
                        //根据经纬度坐标计算相对于地图内部容器原点的相对像素坐标
                        var pixel = this.getProjection().fromLatLngToDivPixel(position);
                        this.dom.style.left = pixel.getX() + 'px';
                        this.dom.style.top = pixel.getY() + 'px';
                    }
                }

                Label.prototype.destroy = function() {
                    //移除dom
                    this.dom.parentNode.removeChild(this.dom);
                }
	            var label = new Label({
	                 map: map,
	                 position: latLng
	            });
 			})
        },
    }
    
    /* 配送员查看账目详情 */
    app.account_list = {
		init : function() {
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });
            app.account_list.screen();
		},
		
        screen: function () {
            $(".select-button").off('click').on('click', function () {
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
                var user_id = $("input[name='user_id']").val();
 
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: js_lang.time_range_screening,
                        state: "error",
                    };
                    ecjia.merchant.showmessage(data);
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action');
 
                if (user_id != '') url += '&user_id=' + user_id;
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                ecjia.pjax(url);
            });
        }
	}

    /* 配送员资金对账列表 */
    app.match_list = {
        init: function () {
            $("form[name='searchForm'] .search_match").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keyword = $("input[name='keyword']").val();
                if (keyword != '') {
                	url += '&keyword=' + keyword;
                }
                ecjia.pjax(url);
            })
            
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });
            app.match_list.screen();
        },
        
        screen: function () {
            $(".select-button").off('click').on('click', function () {
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
                var user_id = $("input[name='user_id']").val();
 
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: "请选择正确的时间范围进行筛选",
                        state: "error",
                    };
                    ecjia.merchant.showmessage(data);
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action');
 
                if (user_id != '') url += '&user_id=' + user_id;
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                ecjia.pjax(url);
            });
        }
    };
    
})(ecjia.merchant, jQuery);
 
// end