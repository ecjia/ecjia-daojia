<div class="row">
    <div class="col-lg-12 ">
        <div class="panel">
            <div class="panel-body">
                <div class="task-progress-content">
                    {foreach $list as $order_list}
                    <div class="item-column" style="align-items: center">
                        <a href="{$order_list.url}">
                            <img src="{$order_list.img}" width="60" height="60">
                        </a>
                        <div class="title" style="font-weight: 700; color:#333; margin-bottom: 0">{$order_list.title}</div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>