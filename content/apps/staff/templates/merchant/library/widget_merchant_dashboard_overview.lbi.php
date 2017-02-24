<!-- start:state overview -->
<div class="row state-overview">
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-money"></i>
            </div>
            <div class="value">
                <h1 class="count">{$order_money}</h1>
                <p><a target="__blank" href='{url path="orders/mh_order_stats/init" args="start_date={$month_start_time}&end_date={$month_end_time}"}'>本月订单总额</a></p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-list-alt"></i>
            </div>
            <div class="value">
                <h1 class="count2">{$order_number}</h1>
                <p><a target="__blank" href='{url path="orders/mh_order_stats/init" args="start_date={$month_start_time}&end_date={$month_end_time}"}'>本月订单数量</a></p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-gavel"></i>
            </div>
            <div class="value">
                <h1 class="count3">{$order_unconfirmed}</h1>
                <p><a target="__blank" href='{url path="orders/merchant/init" args="start_time={$today_start_time}&end_time={$today_end_time}&composite_status={$unconfirmed}"}'>今日待确认订单</a></p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol purple">
                <i class="fa fa-truck"></i>
            </div>
            <div class="value">
                <h1 class="count4">{$order_await_ship}</h1>
                <p><a target="__blank" href='{url path="orders/merchant/init" args="start_time={$today_start_time}&end_time={$today_end_time}&composite_status={$wait_ship}"}'>今日待发货订单</a></p>
            </div>
        </section>
    </div>
</div>
<!-- end:state overview -->