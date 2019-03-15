// JavaScript Document
;(function (app, $) {
    app.admin_express_task = {
            init: function () {
            	
                //缩展地图
                $(".order-map-change").off('click').on('click', function(){
                	 var $this = $(this);
                	 if ($this.hasClass('fa fa-expand')) {
                        $this.removeClass('fa fa-expand').addClass('fa fa-compress');
                        $(".left-bar1").hide();
                     	$(".right-bar").hide();
                     	$('.middle-bar').attr('style','width:100%;margin-left:0%;margin-right:0%;');
                     } else {
                        $this.removeClass('fa fa-compress').addClass('fa fa-expand');
                        $(".left-bar1").show();
                     	$(".right-bar").show();
                     	$('.middle-bar').attr('style','width:49%;margin-left:1%;margin-right:0.5%;');
                     }
                });
                
                $(".user-map-change").off('click').on('click', function(){
                  	 var $this = $(this);
                  	 if ($this.hasClass('fa fa-expand')) {
                           $this.removeClass('fa fa-expand').addClass('fa fa-compress');
                           $(".left-bar1").hide();
                       	$(".right-bar").hide();
                       	$('.middle-bar').attr('style','width:100%;margin-left:0%;margin-right:0%;');
                       } else {
                           $this.removeClass('fa fa-compress').addClass('fa fa-expand');
                           $(".left-bar1").show();
                       	$(".right-bar").show();
                       	$('.middle-bar').attr('style','width:49%;margin-left:1%;margin-right:0.5%;');
                       }
                  });
            	
                //在线配送员缩展
                $('.online-triangle').off('click').on('click', function(e) {
                	var div = ($(".express-user-list").hasClass("in"));
                	if (div) {
            			$(".on-tran").addClass("triangle1");
                		$(".on-tran").removeClass("triangle");
                		$(".on-tran").removeClass("triangle2");
                	} else {
                		$(".on-tran").addClass("triangle2");
                		$(".on-tran").removeClass("triangle");
                		$(".on-tran").removeClass("triangle1");
                	}
    			});
              //离线配送员缩展
                $('.leave-trangle').off('click').on('click', function(e) {
                	var div = ($(".express-user-list-leave").hasClass("in"));
                	
                	if (div) {
                		$(".leaveline").addClass("triangle1");
                		$(".leaveline").removeClass("triangle");
                		$(".leaveline").removeClass("triangle2");
                	} else {
                		$(".leaveline").addClass("triangle2");
                		$(".leaveline").removeClass("triangle");
                		$(".leaveline").removeClass("triangle1");
                	}
    			});
              app.admin_express_task.search_express_user();
              app.admin_express_task.map();
              app.admin_express_task.click_order();
              app.admin_express_task.click_exuser();
              app.admin_express_task.assign();
              app.admin_express_task.express_order_detail();
              app.admin_express_task.hide_sidebar();
            },
    
            search_express_user: function () {
                /* 配送员列表搜索 */
                $("form[name='express_searchForm'] .express-search-btn").off('click').on('click', function (e) {
                    e.preventDefault();
                    var url = $("form[name='express_searchForm']").attr('action');
                    var keyword = $("input[name='keywords']").val();
                    if (keyword != '') {
                    	url += '&keywords=' + keyword;
                    }
                    //ecjia.pjax(url);
                    $.post(url, {'express_id': 1}, function (data) {
                       	$('.original-user-list').css("display","none");
                       	$('.new-user-list').html(data.data);
                    }, 'json');
                });
		    },
		    
		    hide_sidebar: function () {
                $(".sidebar-ckeck").off('click').on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    var key = $(this).attr('key');
                    if (key == 0) {
                    	$("body").removeClass("sidebar_hidden");
                    	$(this).attr("key","1");
                    } else {
                    	$("body").addClass("sidebar_hidden");
                    	$(this).attr("key","0");
                    }
                });
		    },
		    
		    map: function () {
		        var map, 
		        directionsService = new qq.maps.DrivingService({
		            complete : function(response){
		                var start = response.detail.start,
		                    end = response.detail.end;
		                
		                var anchor = new qq.maps.Point(6, 6),
		                    size = new qq.maps.Size(24, 36),
		                    start_icon = new qq.maps.MarkerImage(
		                        'content/apps/express/statics/images/busmarker.png', 
		                        size, 
		                        new qq.maps.Point(0, 0),
		                        anchor
		                    ),
		                    end_icon = new qq.maps.MarkerImage(
		                        'content/apps/express/statics/images/busmarker.png', 
		                        size, 
		                        new qq.maps.Point(24, 0),
		                        anchor
		                        
		                    );
		                start_marker && start_marker.setMap(null); 
		                end_marker && end_marker.setMap(null);
		                clearOverlay(route_lines);
		                
		                start_marker = new qq.maps.Marker({
		                      icon: start_icon,
		                      position: start.latLng,
		                      map: map,
		                      zIndex:1
		                });
		                end_marker = new qq.maps.Marker({
		                      icon: end_icon,
		                      position: end.latLng,
		                      map: map,
		                      zIndex:1
		                });
		               directions_routes = response.detail.routes;
		               var routes_desc=[];
		               //所有可选路线方案
		               for(var i = 0;i < directions_routes.length; i++){
		                    var route = directions_routes[i],
		                        legs = route; 
		                    //调整地图窗口显示所有路线    
		                    map.fitBounds(response.detail.bounds); 
		                    //所有路程信息            
		                    //for(var j = 0 ; j < legs.length; j++){
		                        var steps = legs.steps;
		                        route_steps = steps;
		                        polyline = new qq.maps.Polyline(
		                            {
		                                path: route.path,
		                                strokeColor: '#3893F9',
		                                strokeWeight: 6,
		                                map: map
		                            }
		                        )  
		                        route_lines.push(polyline);
		                         //所有路段信息
		                        for(var k = 0; k < steps.length; k++){
		                            var step = steps[k];
		                            //路段途经地标
		                            directions_placemarks.push(step.placemarks);
		                            //转向
		                            var turning  = step.turning,
		                                img_position;; 
		                            var turning_img = '&nbsp;&nbsp;<span'+
		                                ' style="margin-bottom: -4px;'+
		                                'display:inline-block;background:'+
		                                'url(img/turning.png) no-repeat '+
		                                img_position+';width:19px;height:'+
		                                '19px"></span>&nbsp;' ;
		                            var p_attributes = [
		                                'onclick="renderStep('+k+')"',
		                                'onmouseover=this.style.background="#eee"',
		                                'onmouseout=this.style.background="#fff"',
		                                'style="margin:5px 0px;cursor:pointer"'
		                            ].join(' ');
		                            routes_desc.push('<p '+p_attributes+' ><b>'+(k+1)+
		                            '.</b>'+turning_img+step.instructions);
		                        }
		                    //}
		               }
		               //方案文本描述
		               var routes=document.getElementById('routes');
		               routes.innerHTML = routes_desc.join('<br>');
		            }
		        }),
		        directions_routes,
		        directions_placemarks = [],
		        directions_labels = [],
		        start_marker,
		        end_marker,
		        route_lines = [],
		        step_line,
		        route_steps = [];
		        var start_latLng = document.getElementById("start").value.split(",");
		        var center_latLng = new qq.maps.LatLng(start_latLng[0], start_latLng[1]);
//		    function map_init() {
	        map = new qq.maps.Map(document.getElementById("allmap"), {
	            // 地图的中心地理坐标。
	            center: center_latLng,
	            zoom: 15
	        });
	        
	        calcRoute();
//		    }
		    function calcRoute() {
		        var start_name = document.getElementById("start").value.split(",");
		        var end_name = document.getElementById("end").value.split(",");
		        var policy = document.getElementById("policy").value;
		        route_steps = [];
		            
		        //directionsService.setLocation("北京");
		        directionsService.setPolicy(qq.maps.DrivingPolicy[policy]);
		        directionsService.search(new qq.maps.LatLng(start_name[0], start_name[1]), 
		            new qq.maps.LatLng(end_name[0], end_name[1]));
		    }
		    //清除地图上的marker
		    function clearOverlay(overlays){
		        var overlay;
		        while(overlay = overlays.pop()){
		            overlay.setMap(null);
		        }
		    }
		    function renderStep(index){   
		        var step = route_steps[index];
		        //clear overlays;
		        step_line && step_line.setMap(null);
		        //draw setp line      
		        step_line = new qq.maps.Polyline(
		            {
		                path: step.path,
		                strokeColor: '#ff0000',
		                strokeWeight: 6,
		                map: map
		            }
		        )
		    }
		    //配送员位置start
		    var has_staff = $('.hasstaff').val();
		    
		    if (has_staff == '1') {
		    	 var ex_name 		= $('.nearest_exuser_name').val();
		            var ex_mobile 		= $('.nearest_exuser_mobile').val();
		            var ex_lng 			= $('.nearest_exuser_lng').val();
		            var ex_lat 			= $('.nearest_exuser_lat').val();
		            var ex_user_latLng 	= new qq.maps.LatLng(ex_lat, ex_lng);
		     		//创建一个Marker(自定义图片)
		     	    var ex_user_marker = new qq.maps.Marker({
		     	        position: ex_user_latLng, 
		     	        map: map
		     	    });
		     	    
		     	    //设置Marker自定义图标的属性，size是图标尺寸，该尺寸为显示图标的实际尺寸，origin是切图坐标，该坐标是相对于图片左上角默认为（0,0）的相对像素坐标，anchor是锚点坐标，描述经纬度点对应图标中的位置
		            var ex_user_anchor = new qq.maps.Point(0, 39),
		                size   = new qq.maps.Size(50,50),
		                origin = new qq.maps.Point(0, 0),
		                icon   = new qq.maps.MarkerImage(
		                    "content/apps/express/statics/images/ex_user.png",
		                    size,
		                    origin,
		                    ex_user_anchor
		                );
		            ex_user_marker.setIcon(icon);

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
		                      'background:url("content/apps/express/statics/images/lable_text.png") no-repeat;width:130px;height:60px;margin-top:-98px;margin-left:-38px;position:absolute;z-index:1;' +
		                      'text-align:left;color:white;padding-left:25px;padding-top:8px;';
		                 this.dom.innerHTML = ex_name +'<br>'+ex_mobile;
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
		                 position: ex_user_latLng
		            });
		    }
            //配送员位置end
		 },
		 
		 click_order: function () {
			  $(".order-div").off('click').on('click', function (e) {
                  e.preventDefault();
                  var $this = $(this);
                  var ex_lng = $this.attr('sf_lng');
                  var ex_lat = $this.attr('sf_lat');
                  var starts = $this.attr('express_start');
                  var ends 	 = $this.attr('express_end');
                  var ex_sn  = $this.attr('express_sn');
                  var exp_id  = $this.attr('express_id');
                  var order_express_id  = $('.order_express_id').val();
                  
                  //选中订单边框变色start
                  if (order_express_id == '') {
                	  $this.css("border","1px solid #009ACD");
                	  $('.order_express_id').val(exp_id);
                  } else {
                	  var last_click_div = 'div'+ order_express_id;
                	  $('.' + last_click_div).css("border","1px solid #dcdcdc");
                	  $this.css("border","1px solid #009ACD");
                	  $('.order_express_id').val(exp_id);
                  }
                 //选中订单边框变色end
                  
                  $("#start").val(starts);
                  $("#end").val(ends);
                  
                  //地图备注切换显示
                  $('.map-exp-order').css("display","block");
                  $('.map-exp-user').css("display","none");
                  $('.order').html('[' + ex_sn + ']');
                  
                  //express_id替换；供指派使用
                  $(".selected-express-id").val(exp_id);
                  
                  var url = $this.attr('data-url');
                
                  var data = {
                      sf_lng: ex_lng,
                      sf_lat: ex_lat,
                  }
                   $.post(url, data, function (data) {
                  	 if (data.state == 'success') {
                  		 $('.nearest_exuser_name').val(data.express_info.name);
                  		 $('.nearest_exuser_mobile').val(data.express_info.mobile);
                  		 $('.nearest_exuser_lng').val(data.express_info.longitude);
                  		 $('.nearest_exuser_lat').val(data.express_info.latitude);
                  		 $('.hasstaff').val(data.express_info.has_staff);
                  		app.admin_express_task.map();
                  	 } else {
                  		app.admin_express_task.map(); 
                  	 }
                   }, 'json');
              });
		 },
		 
		 click_exuser: function () {
			  $(".express-user-info").off('click').on('click', function(e) {
				  e.preventDefault();
				  var $this = $(this);
				  var online_status = $this.attr('online_status');
				  if (online_status == 1) {
					  var staff_user_id = $this.attr('staff_user_id');
	                  var express_userid  = $('.ex-u-id').val();
	                 
	                  //选中配送员边框变色start
	                  var current_click_user = 'ex-user-div'+ staff_user_id;
	                  
	                  if (express_userid == '') {
	                	  $this.css("border","1px solid #009ACD");
	               	  	  $('.ex-u-id').val(staff_user_id);
	                  } else {
	               	  	 var last_click_user = 'ex-user-div'+ express_userid;
	               	  	 $('.' + last_click_user).css("border","1px solid #dcdcdc");
	               	     $this.css("border","1px solid #009ACD");
	               	  	 $('.ex-u-id').val(staff_user_id);
	                 }
	                //选中配送员边框变色end
				  }
			  });
			  $(".exuser_div").off('click').on('click', function (e) {
                 e.preventDefault();
                 
                 var $this = $(this);
                 var ex_lng = $this.attr('longitude');
                 var ex_lat = $this.attr('latitude');
                 var ex_name = $this.attr('name');
                 var ex_mobile = $this.attr('mobile');
               
                 
                 //顶部地图变化提示
                 $('.map-exp-order').css("display","none");
                 $('.map-exp-user').css("display","block");
                 $(".user").html('[' + ex_name + ']');
                           		 
              	//腾讯地图加载
              	var map, markersArray = [];
              	var latLng = new qq.maps.LatLng(ex_lat, ex_lng);
              	var map = new qq.maps.Map(document.getElementById("allmap"),{
              	    center: latLng,
              	    zoom: 15
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
                         "content/apps/express/statics/images/ex_user.png",
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
                           'background:url("content/apps/express/statics/images/lable_text.png") no-repeat;width:130px;height:60px;margin-top:-98px;margin-left:-38px;position:absolute;' +
                           'text-align:left;color:white;padding-left:25px;padding-top:8px;';
                      this.dom.innerHTML = ex_name +'<br>'+ex_mobile;
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
             });
			  
			  
		 },
		 
		assign : function(url){
			$('.assign').off('click').on('click', function() {
				var $this = $(this);
				var message = $this.attr('data-msg');
				var url = $this.attr('data-href');
				var exp_id = $('.selected-express-id').val();
				if (message != undefined) {
					smoke.confirm(message, function(e) {
						if (e) {
							$.post(url,{'express_id':exp_id}, function(data){
								 if (data.state == 'success') {
									ecjia.admin.showmessage(data);
								 }
							})
						}
					}, {ok:js_lang.ok, cancel:js_lang.cancel});
				} 
			});
		},
		
		express_order_detail :function(){
            $(".express-order-modal").off('click').on('click', function (e) {
            	e.preventDefault();
                var $this = $(this);
                var express_id = $this.attr('express-id');
                var url = $this.attr('express-order-url');
                $.post(url, {'express_id': express_id}, function (data) {
                	$('.modal').html(data.data);
                }, 'json');
			})
        },
      }
    
    app.task_list_fresh = {
		 init : function() {
			 var InterValObj; 	//timer变量，控制时间
			 var count = 120; 	//间隔函数，1秒执行
			 InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
			 
			//timer处理函数
			function SetRemainTime() {
				if (count == 0) {
					window.clearInterval(InterValObj);		//停止计时器
					$('.auto-refresh').html('<span class="numcolor">120</span>' + js_lang.automatic_refresh_after_seconds);
					ecjia.pjax(location.href);
				} else {
					count--;
					$('.auto-refresh').html('<span class="numcolor">'+ count + '</span>' + js_lang.automatic_refresh_after_seconds);
				}
			};
			$(document).on('pjax:start', function () {
				window.clearInterval(InterValObj);
			});
		 },	
    }
    
    app.serachuser_list = {
   		 init : function() {
   		    $('.online-click').off('click').on('click', function(e) {
               	var div = ($(".express-user-list-on").hasClass("in"));
               	if (div) {
           			$(".on-tri").addClass("triangle1");
               		$(".on-tri").removeClass("triangle");
               		$(".on-tri").removeClass("triangle2");
               	} else {
               		$(".on-tri").addClass("triangle2");
               		$(".on-tri").removeClass("triangle");
               		$(".on-tri").removeClass("triangle1");
               	}
   			});
               $('.offline-click').off('click').on('click', function(e) {
               	var div = ($(".express-user-list-off").hasClass("in"));
               	
               	if (div) {
               		$(".off-tri").addClass("triangle1");
               		$(".off-tri").removeClass("triangle");
               		$(".off-tri").removeClass("triangle2");
               	} else {
               		$(".off-tri").addClass("triangle2");
               		$(".off-tri").removeClass("triangle");
               		$(".off-tri").removeClass("triangle1");
               	}
   			});
               app.serachuser_list.search_user();
               app.serachuser_list.click_reassign_exuser();
               app.serachuser_list.re_assign();
   		 },
       		
   		 search_user: function () {
   		      /* 配送员列表搜索 */
               $(".new-user-list form[name='express_searchForm'] .express-search-btn").off('click').on('click', function (e) {
                   e.preventDefault();
                   var url = $(".new-user-list form[name='express_searchForm']").attr('action');
                   var keyword = $(".new-user-list input[name='keywords']").val();
    
                   if (keyword != '') {
                   	url += '&keywords=' + keyword;
                   }
                   //ecjia.pjax(url);
                   $.post(url, {'express_id': 1}, function (data) {
                   	$('.original-user-list').css("display","none");
                   	$('.new-user-list').html(data.data);
                   }, 'json');
               });
            },
            
         re_assign : function(url){
   			$('.re-assign').off('click').on('click', function() {
   				var $this = $(this);
   				var message = $this.attr('data-msg');
   				var url = $this.attr('data-href');
   				var exp_id = $('.selected-express-id').val();
   				if (message != undefined) {
   					smoke.confirm(message, function(e) {
   						if (e) {
   							$.post(url,{'express_id':exp_id}, function(data){
   								if (data.state == 'success') {
   									ecjia.admin.showmessage(data);
   								}
   							})
   						}
   					}, {ok:js_lang.ok, cancel:js_lang.cancel});
   				} 
   			});
   		 },
            
   		 click_reassign_exuser: function () {
	   		  $(".express-user-info").off('click').on('click', function(e) {
				  e.preventDefault();
				  
				  var $this = $(this);
				  var online_status = $this.attr('online_status');
				  if (online_status == 1) {
					  var staff_user_id = $this.attr('staff_user_id');
		              var express_userid  = $('.ex-u-id').val();
		             
		              //选中配送员边框变色start
		              var current_click_user = 'ex-user-div'+ staff_user_id;
		              
		              if (express_userid == '') {
		            	  $this.css("border","1px solid #009ACD");
		           	  	  $('.ex-u-id').val(staff_user_id);
		              } else {
		           	  	 var last_click_user = 'ex-user-div'+ express_userid;
		           	  	 $('.' + last_click_user).css("border","1px solid #dcdcdc");
		           	   $this.css("border","1px solid #009ACD");
		           	  	 $('.ex-u-id').val(staff_user_id);
		             }
		            //选中配送员边框变色end
				  }
			  });
   			  $(".reassign_exuser_div").off('click').on('click', function (e) {
   	            e.preventDefault();
   	            var $this = $(this);
   	            var ex_lng = $this.attr('longitude');
   	            var ex_lat = $this.attr('latitude');
   	            var ex_name = $this.attr('name');
   	            var ex_mobile = $this.attr('mobile');
   	             
   	         	//腾讯地图加载
   	         	var map, markersArray = [];
   	         	var latLng = new qq.maps.LatLng(ex_lat, ex_lng);
   	         	var map = new qq.maps.Map(document.getElementById("allmap"),{
   	         	    center: latLng,
   	         	    zoom: 15
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
   	                    "content/apps/express/statics/images/ex_user.png",
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
   	                      'background:url("content/apps/express/statics/images/lable_text.png") no-repeat;width:130px;height:60px;margin-top:-98px;margin-left:-38px;position:absolute;' +
   	                      'text-align:left;color:white;padding-left:25px;padding-top:8px;';
   	                 this.dom.innerHTML = ex_name +'<br>'+ex_mobile;
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
   	        });
   		 },
	
    };
    
})(ecjia.admin, jQuery);
 
// end