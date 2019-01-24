<?php

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// $options
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
return array(

    /*
    ==================================================
    布局
    ==================================================
    */
    array(
        'name'     => 'layout',
        'title'    => '布局',
        'icon'     => 'fa fa-cubes',
        'fields'   => array(
            array(
                'type'  => 'notice',
                'class' => 'info',
                'content'   => '首页、分类和标签布局',
            ),
            array(
                'id'           => 'i_layout_goods_list_type',
                'class'        => 'horizontal',
                'type'         => 'radio_image',
                'title'        => '选择商品列表布局',
                'options'      => array(
                    'goods'         => '纯商品展示',
                    'store_goods'   => '店铺+商品展示',
                ),
                'options_images' => array(
                    'goods'         => ecjia_extra::themeUrl('images/goods_list/goods.png'),
                    'store_goods'   => ecjia_extra::themeUrl('images/goods_list/store_goods.png'),
                ),
                'default'      => 'goods'
            ),
        )
    ),


    // ------------------------------
    // license                      -
    // ------------------------------
    array(
        'name'     => 'license',
        'title'    => '关于',
        'icon'     => 'fa fa-info-circle',
        'fields'   => array(

            array(
                'type'    => 'heading',
                'content' => 'ECJIA TEAM'
            ),
            array(
                'type'    => 'content',
                'content' => 'ECJia到家官网，详情请访问： <a href="https://daojia.ecjia.com/" target="_blank">https://daojia.ecjia.com/</a>',
            ),

        )
    ),

);
