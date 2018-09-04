<div class="row state-overview">
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type wait-confirm">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_confirm.png" />
            </div>
            <div class="value">
                <h1 class="count">{$count.unconfirmed}</h1>
                <p>待接单订单（单）</p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type wait-ship">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_ship.png" />
            </div>
            <div class="value">
                <h1 class="count2">{$count.await_ship}</h1>
                <p>待发货订单（单）</p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type wait-shipped">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_shipped.png" />
            </div>
            <div class="value">
                <h1 class="count3">{$count.shipped}</h1>
                <p>待收货订单（单）</p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type return">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/return.png" />
            </div>
            <div class="value">
                <h1 class="count4">{$count.returned}</h1>
                <p>退款/售后订单（单）</p>
            </div>
        </section>
    </div>
</div>
<!-- end:state overview -->