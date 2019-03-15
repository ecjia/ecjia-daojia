<div class="row state-overview">
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type wait-confirm">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_confirm.png" />
            </div>
            <div class="value">
                <h1 class="count"><a href="{RC_Uri::url('orders/merchant/init')}&composite_status=105" target="_blank">{$count.unconfirmed}</a></h1>
                <p>{t domain="orders"}待接单订单（单）{/t}</p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type wait-ship">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_ship.png" />
            </div>
            <div class="value">
                <h1 class="count2"><a href="{RC_Uri::url('orders/merchant/init')}&composite_status=101" target="_blank">{$count.await_ship}</a></h1>
                <p>{t domain="orders"}待发货订单（单）{/t}</p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type wait-shipped">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_shipped.png" />
            </div>
            <div class="value">
                <h1 class="count3"><a href="{RC_Uri::url('orders/merchant/init')}&composite_status=104" target="_blank">{$count.shipped}</a></h1>
                <p>{t domain="orders"}待收货订单（单）{/t}</p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol-order-type return">
            	<img src="{$ecjia_main_static_url}img/merchant_dashboard/return.png" />
            </div>
            <div class="value">
                <h1 class="count4"><a href="{RC_Uri::url('refund/merchant/init')}" target="_blank">{$count.returned}</a></h1>
                <p>{t domain="orders"}退款/售后订单（单）{/t}</p>
            </div>
        </section>
    </div>
</div>
<!-- end:state overview -->