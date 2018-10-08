<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/8
 * Time: 10:14 AM
 */

return [
    'ecjia_touch_user' => 'ecjia_touch_user',
    'ecjia_touch_page' => 'ecjia_touch_page',

    /*
     * ========================================
     * API模型加载
     * ========================================
     */
    'api_shop_config_model' => 'shop.api_shop_config_model',
    'api_shop_help_detail_model' => 'shop.api_shop_help_detail_model',
    'api_shop_help_model' => 'shop.api_shop_help_model',
    'api_shop_info_detail_model' => 'shop.api_shop_info_detail_model',
    'api_shop_info_model' => 'shop.api_shop_info_model',
    'api_shop_payment_model' => 'shop.api_shop_payment_model',
    'api_shop_region_model' => 'shop.api_shop_region_model',
    'api_shop_token_model' => 'shop.api_shop_token_model',

    'api_address_add_model' => 'address.api_address_add_model',
    'api_address_delete_model' => 'address.api_address_delete_model',
    'api_address_info_model' => 'address.api_address_info_model',
    'api_address_list_model' => 'address.api_address_list_model',
    'api_address_setDefault_model' => 'address.api_address_setDefault_model',
    'api_address_update_model' => 'address.api_address_update_model',

    'api_bonus_bind_model' => 'bonus.api_bonus_bind_model',
    'api_bonus_coupon_model' => 'bonus.api_bonus_coupon_model',
    'api_bonus_validate_model' => 'bonus.api_bonus_validate_model',
    'api_receive_coupon_model' => 'bonus.api_receive_coupon_model',
    'api_send_coupon_model' => 'bonus.api_send_coupon_model',

    'api_cart_create_model' => 'cart.api_cart_create_model',
    'api_cart_delete_model' => 'cart.api_cart_delete_model',
    'api_cart_list_model' => 'cart.api_cart_list_model',
    'api_cart_update_model' => 'cart.api_cart_update_model',
    'api_flow_checkOrder_model' => 'cart.api_flow_checkOrder_model',
    'api_flow_done_model' => 'cart.api_flow_done_model',

    'api_home_adsense_model' => 'home.api_home_adsense_model',
    'api_home_category_model' => 'home.api_home_category_model',
    'api_home_data_model' => 'home.api_home_data_model',
    'api_home_discover_model' => 'home.api_home_discover_model',
    'api_home_news_model' => 'home.api_home_news_model',

    'api_merchant_goods_category_model' => 'merchant.api_merchant_goods_category_model',
    'api_merchant_goods_list_model' => 'merchant.api_merchant_goods_list_model',
    'api_merchant_goods_suggestlist_model' => 'merchant.api_merchant_goods_suggestlist_model',
    'api_merchant_home_data_model' => 'merchant.api_merchant_home_data_model',

    'api_order_affirmReceived_model' => 'order.api_order_affirmReceived_model',
    'api_order_cancel_model' => 'order.api_order_cancel_model',
    'api_order_detail_model' => 'order.api_order_detail_model',
    'api_order_express_model' => 'order.api_order_express_model',
    'api_order_list_model' => 'order.api_order_list_model',
    'api_order_pay_model' => 'order.api_order_pay_model',
    'api_order_reminder_model' => 'order.api_order_reminder_model',
    'api_order_update_model' => 'order.api_order_update_model',

    'api_seller_category_model' => 'seller.api_seller_category_model',
    'api_seller_collect_create_model' => 'seller.api_seller_collect_create_model',
    'api_seller_collect_delete_model' => 'seller.api_seller_collect_delete_model',
    'api_seller_collect_list_model' => 'seller.api_seller_collect_list_model',
    'api_seller_list_model' => 'seller.api_seller_list_model',
    'api_seller_search_model' => 'seller.api_seller_search_model',

    'api_connect_bind_model' => 'user.api_connect_bind_model',
    'api_connect_signin_model' => 'user.api_connect_signin_model',
    'api_connect_signup_model' => 'user.api_connect_signup_model',

    'api_user_account_cancel_model' => 'user.api_user_account_cancel_model',
    'api_user_account_deposit_model' => 'user.api_user_account_deposit_model',
    'api_user_account_log_model' => 'user.api_user_account_log_model',
    'api_user_account_pay_model' => 'user.api_user_account_pay_model',
    'api_user_account_raply_model' => 'user.api_user_account_raply_model',
    'api_user_account_record_model' => 'user.api_user_account_record_model',
    'api_user_account_update_model' => 'user.api_user_account_update_model',

    'api_user_collect_create_model' => 'user.api_user_collect_create_model',
    'api_user_collect_delete_model' => 'user.api_user_collect_delete_model',
    'api_user_collect_list_model' => 'user.api_user_collect_list_model',

    'api_user_forget_password_model' => 'user.api_user_forget_password_model',
    'api_user_info_model' => 'user.api_user_info_model',
    'api_user_password_model' => 'user.api_user_password_model',
    'api_user_reset_password_model' => 'user.api_user_reset_password_model',
    'api_user_send_pwdmail_model' => 'user.api_user_send_pwdmail_model',
    'api_user_signin_model' => 'user.api_user_signin_model',
    'api_user_signout_model' => 'user.api_user_signout_model',
    'api_user_signup_model' => 'user.api_user_signup_model',
    'api_user_signupFields_model' => 'user.api_user_signupFields_model',
    'api_user_snsbind_model' => 'user.api_user_snsbind_model',
    'api_user_update_model' => 'user.api_user_update_model',

    'api_validate_account_model' => 'user.api_validate_account_model',
    'api_validate_bind_model' => 'user.api_validate_bind_model',
    'api_validate_bonus_model' => 'user.api_validate_bonus_model',
    'api_validate_forget_password_model' => 'user.api_validate_forget_password_model',
    'api_validate_integral_model' => 'user.api_validate_integral_model',
    'api_validate_signin_model' => 'user.api_validate_signin_model',

    'api_goods_category_model' => 'goods.api_goods_category_model',
    'api_goods_comments_model' => 'goods.api_goods_comments_model',
    'api_goods_seller_list_model' => 'goods.api_goods_seller_list_model',
    'api_goods_suggestlist_model' => 'goods.api_goods_suggestlist_model',
    'api_goods_detail_model' => 'goods.api_goods_detail_model',
    'api_goods_desc_model' => 'goods.api_goods_desc_model',
    'api_goods_filter_model' => 'goods.api_goods_filter_model',
];