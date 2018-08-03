<?php
/*
Name: 修改购物车商品数量
Description: 这是修改购物车商品数量弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}

<div class="ecjia-num-content">
    <form name="numForm" method="post">
        <div class="ecjia-num-view-screen"></div>
        <div class="ecjia-num-view">
            <div class="num-content">
                <div class="title">修改数量</div>
                <div class="num-handle">
                    <div class="num-handle-content">
                        <img src="{$theme_url}images/icon/goods-minus.png" class="minusNum" />
                        <input type="number" name="value" />
                        <img src="{$theme_url}images/icon/goods-plus.png" class="addNum"/>
                    </div>
                </div>
                <div class="num-confirm">
                    <input type="hidden" name="old_value" />
                    <input type="hidden" name="rec_id" />
                    <input type="hidden" name="goods_id" />
                    <div class="btn-confirm btn-cancel">取消</div>
                    <div class="btn-confirm btn-ok">确定</div>
                </div>
            </div>
        </div>
    </form>
</div>
{/nocache}