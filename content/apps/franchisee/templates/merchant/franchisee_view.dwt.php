<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="meta"} -->
<title>
查询审核进度 - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
查询审核进度 - {ecjia::config('shop_name')}
<!-- {/block} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.franchisee.init();
</script>
<script type="text/javascript">
    var map, markersArray = [];
    var step='{$step}';
    var lat = '{$data.latitude}';
    var lng = '{$data.longitude}';
    var latLng = new qq.maps.LatLng(lat, lng);
    var map = new qq.maps.Map(document.getElementById("allmap"),{
        center: latLng,
        zoom: 16
    });
    setTimeout(function(){
        var marker = new qq.maps.Marker({
            position: latLng, 
            map: map
          });
        markersArray.push(marker);
    }, 500);
    if (step == 1) {
        //添加监听事件 获取鼠标单击事件
        qq.maps.event.addListener(map, 'click', function(event) {
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
                markersArray.length = 0;
            }
            $('input[name="longitude"]').val(event.latLng.lng)
            $('input[name="latitude"]').val(event.latLng.lat)
               var marker = new qq.maps.Marker({
                position: event.latLng, 
                map: map
              });
            markersArray.push(marker);    
        });
    }
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
				{if $step eq 1}
				<form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post">
					<div class="form-group">
					  	<label class="control-label col-lg-2">手机号码：</label>
					  	<div class="controls col-lg-6">
					      	<input class="form-control" name="mobile" id="mobile" placeholder="请输入手机号码" type="text"/>
					  	</div>
					 	<a class="btn btn-primary" data-url="{url path='franchisee/merchant/get_code_value'}" id="get_code">获取短信验证码</a>
					</div>
					<div class="form-group">
					  	<label class="control-label col-lg-2">{t}短信验证码：{/t}</label>
					  	<div class="col-lg-6">
					      	<input class="form-control" name="code" placeholder="请输入手机短信验证码" type="text"/>
					  	</div>
					</div>
					<div class="form-group ">
						<div class="col-lg-6 col-md-offset-2">
							<input class="btn btn-primary" type="submit" value="下一步">
					  	</div>
					</div>
				</form>
       			{/if} 
            </div>
        </section>
    </div>
</div>
{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}
<!-- {/block} -->