(function (ecjia, $) {

    /**
     * 店铺购物车
     * @param store_id
     * @param goods_id
     * @param spec
     * @param div
     * @constructor
     */
    var cart = function EcjiaStoreCart(store_id, goods_id, spec,div) {

        /**
         * 店铺ID
         */
        this.store_id = store_id;

        /**
         * 商品ID
         * @type {{$goods_info}}
         */
        this.goods_id = goods_id === null ? 0 : goods_id;


        /**
         * 商品规格
         */
        this.spec = spec;

        /**
         * 删除指定div
         */
        this.div = div;

        /**
         * 默认方法
         * @param url
         * @param num
         * @param act_id
         * @param checked
         */
        this.update = function (url,num,act_id,checked) {
            var info = {
            	'val': num,
            	'rec_id': rec_id,
            	'store_id': this.store_id,
            	'goods_id': this.goods_id,
            	'checked': ecjia._default(checked,''),
            	'response': response,
            	'spec': this.spec,
            	'act_id': ecjia._default(act_id,0)
            };
            $.post(url,info,this.updateCartCallback.bind(this));
        };
        /**
         * 添加购物车，增加数量
         * rec_id 不赋值为add 赋值为reduce
         * @param url
         * @param num
         * @param act_id
         */
        this.add = function (url,num,act_id) {
            this.num = num;
            this.type = 'add';
            var info ={
                'val': num,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                'act_id': ecjia._default(act_id,0),
                'spec': ecjia._default(this.spec,'')
            };

            //更新购物车中商品
            $.post(url, info, this.updateCartCallback.bind(this));
        };

        /**
         * 减少购物车，减少数量
         * @param url
         * @param rec_id
         * @param num
         * @param act_id
         */
        this.reduce = function (url,rec_id,num,act_id) {
            this.num = num;
            this.type = 'reduce';
            var info = {
                'val': num,
                'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                'spec': this.spec,
                'act_id': ecjia._default(act_id,0)
            };

            //更新购物车中商品
            $.post(url, info, this.updateCartCallback.bind(this));
        };

        /**
         * 更新购物车中某件商品的数量
         * @param url
         * @param rec_id
         * @param num
         * touch.category.change_num
         */
        this.changeNum = function (url,rec_id,num) {
            this.num = num;
            this.type = 'change_num';
            var info = {
                'val': num,
                'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                'spec': this.spec
            };

            //更新购物车中商品
            $.post(url, info, this.updateCartCallback.bind(this));
        };

        /**
         * 清空购物车中的全部商品
         * @param url
         * @param rec_id
         * ecjia.touch.category.deleteall
         */
        this.deleteAllProducts = function (url,rec_id) {
            this.type ='del_all_pro';
            var info = {
                'val': 0,
                'goos_id': this.goods_id,
                'store_id': this.store_id,
                'rec_id': rec_id
            };
            $.post(url,info,this.deleteAllProductsCallBack.bind(this))
        };

        /**
         * 改变购物车中商品的状态,单个或者全部
         * @param url
         * @param rec_id string or array
         * @param is_checked
         * ecjia.touch.category.toggle_checkbox
         * ecjia.touch.category.check_goods
         */
        this.toggleCheckbox = function (url,rec_id,is_checked) {
            this.type = 'toggle_status';
            var info = {
                'val': 0,
                'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': 0,
                'checked': is_checked === undefined ? '' : is_checked
            };
            $.post(url,info,this.updateCartCallback.bind(this));
        };

        /**
         * 删除购物车中某个商家
         * @param url
         * @param rec_id
         * @param response
         * ecjia.touch.goods.category.check_cart
         */
        this.removeCartItem = function (url,rec_id,response) {
            // response true
            var info = {
                'val': 0,
                'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': 0,
                'spec': this.spec,
                'response': response

            };
            //更新购物车中商品
            $.post(url, info, this.updateCartCallback.bind(this));
        };
        /**
         * 请求回调
         * @param data
         */
        this.updateCartCallback = function (data) {
            // dom 操作
            ecjia.touch.cartdom.updateCartInitDom();
            // error return
            if (data.state === 'error') {
                this.loginAlert(data);
                return false;
            }
            // 传入的商品数量为0
            if (this.num === 0) {
                // 移除购物车中的商品
                ecjia.touch.cartdom.removeProduct(this.goods_id);
            }
            // 移除购物车中某个商铺
            if (div !== undefined && div !== '') {
                ecjia.touch.cartdom.removeElement(div);
                return  false;
            }
            // empty  true, clear cart list
            if (data.empty === true) {
                ecjia.touch.cartdom.clearCartList(data.store_id);
                return false;
            }
            // 返回 response 字段为true
            if (data.response === true) {
                $('.la-ball-atom').remove();
                if (data.count != null) {
                    var price_ele = $('.price_' +this.store_id);
                    var _check_cart_ele = $('.check_cart_' + this.store_id);

                    if (data.count.discount !== 0) {
                        var discount_html = '<label class="discount">' + sprintf(js_lang.reduced, data.count.discount) + '<label>';
                        price_ele.html(data.count.goods_price + discount_html);
                    } else {
                        price_ele.html(data.count.goods_price);
                    }

                    if (data.data_rec) {
                        _check_cart_ele.attr('data-rec', data.data_rec);
                        _check_cart_ele.removeClass('disabled');
                    } else {
                        _check_cart_ele.attr('data-rec', '');
                        _check_cart_ele.addClass('disabled');
                    }
                }
                return true;
            }
            // 根据传入的商品规格来更新商品规格部分的数据
            if (spec !== '' || spec !== false) {
                ecjia.touch.cartdom.updateProductSpecNumDom(this.spec,this.type,this.goods_id,this.num);
            }
            // 更新购物车数据和相关dom
            ecjia.touch.cartdom.updateCartDataAndDom(data,this.goods_id,this.spec,this.num);

            ecjia.touch.category.check_all();
        };

        /**
         * 清空购物车商品回调
         * @param data
         */
        this.deleteAllProductsCallBack = function(data){
            if (data.state === 'success') {
                this.hideCart(true);
                if ($.find('.box').length !== 0) {
                    $('.box').each(function () {
                        if ($(this).parent().find('.goods-add-cart').length !== 0) {
                            $(this).removeClass('show').addClass('hide');
                            $(this).children('label').html('1');
                        } else {
                            $(this).children('span.reduce').addClass('hide').removeClass('show');
                            $(this).children('label').html('');
                        }
                        $(this).children('span').attr('rec_id', '');
                    });
                }
                if ($.find('.goods-add-cart').length !== 0) {
                    $('.box').addClass('hide');
                    $('.goods-add-cart').removeClass('hide').attr('rec_id', '');
                }
                if ($.find('.goods-price-plus').length !== 0) {
                    $('.goods-price-plus').attr('rec_id', '').attr('data-num', '');
                }
                if ($.find('i.attr-number').length !== 0) {
                    $('i.attr-number').remove();
                }
                if ($.find('.choose_attr').length !== 0) {
                    $('.choose_attr').attr('data-spec', '');
                }
                $('.ecjia-choose-attr-box.box').removeClass('show').addClass('hide'); //隐藏加减按钮
                $('.add-tocart.add_spec').addClass('show').removeClass('hide'); //显示加入购物车按钮
            } else {
                ecjia.touch.showmessage(data);
            }
            return false;
        };
        /**
         * 消息提示
         * @param data
         */
        this.loginAlert = function (data) {
            var myApp = new Framework7();

            $('.la-ball-atom').remove();
            if (data.referer_url || data.message === 'Invalid session') {
                $(".ecjia-store-goods .a1n .a1x").css({
                    overflow: "hidden"
                }); //禁用滚动条
                //禁用滚动条
                $('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
                    event.preventDefault();
                }, false);

                myApp.modal({
                    title: js_lang.tips,
                    text: js_lang.logged_yet,
                    buttons: [
                        {
                            text: js_lang.cancel,
                            onClick: function () {
                                $('.modal').remove();
                                $('.modal-overlay').remove();
                                $(".ecjia-store-goods .a1n .a1x").css({
                                    overflow: "auto"
                                }); //启用滚动条
                                $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
                                return false;
                            }
                        },
                        {
                            text: js_lang.go_login,
                            onClick: function () {
                                $('.modal').remove();
                                $('.modal-overlay').remove();
                                $(".ecjia-store-goods .a1n .a1x").css({
                                    overflow: "auto"
                                }); //启用滚动条
                                $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
                                location.href = data.referer_url;
                                return false;
                            }
                        }
                    ]
                });
            }
            else {
                alert(data.message);
            }
        };

        /**
         * 显示购物车
         * 传入布尔值
         * @param boolean
         */
        this.showCart = function (boolean) {
            var store_add_acrt_ele = $('.store-add-cart');
            var minicart_content_ele = $('.minicart-content');

            if (boolean) {
                // 底部灰色部分可用
                store_add_acrt_ele.children('.a4x').addClass('light').removeClass('disabled');
                store_add_acrt_ele.children('.a51').removeClass('disabled');
            } else {
                // 显示
                $('.a57').css('display', 'block');
                //禁用滚动条
                ecjia.touch.cartdom.isScroll('body','y',false);
                minicart_content_ele.on('touchmove', function (e) {
                    e.stopPropagation();
                });
                $('.a53').css('display', 'block');
                store_add_acrt_ele.children('.a4x').removeClass('show').removeAttr('show');
                store_add_acrt_ele.children('.minicart-content').css('transform', 'translateY(-100%)');
                store_add_acrt_ele.children('.a4z').css('transform', 'translateX(-60px)');
                minicart_content_ele.children('.a4x').addClass('show').addClass('light').removeClass('disabled');
            }
        };

        /**
         * 清空并隐藏购物车
         * 若传入参数为true 同时清空购物车
         * @param boolean
         */
       this.hideCart = function (boolean) {
            var store_add_acrt_ele = $('.store-add-cart');
            var minicart_content_ele = $('.minicart-content');
            //启用滚动条
            $('body').css('overflow-y', 'auto').off("touchmove");

            store_add_acrt_ele.find('.a4z').css('transform', 'translateX(0px)');
            $('.a53').css('display', 'none');
            store_add_acrt_ele.find('.minicart-content').css('transform', 'translateY(0px)');
            minicart_content_ele.children('.a4x').removeClass('show').attr('show', false);
            store_add_acrt_ele.children('.a4x').addClass('show').attr('show', false);

            //购物车完全清空
            if (boolean === true) {
                this.clearCart();
            }
            //启用用滚动条
            $(".ecjia-store-goods .a1n .a1x").css({
                overflow: "auto"
            });
        };

        /**
         * 清空购物车
         */
        this.clearCart = function(){
            var a51_ele = $('.a51');
            var text = a51_ele.attr('data-text') === undefined ? js_lang.go_settlement : a51_ele.attr('data-text');
            var store_add_acrt_ele = $('.store-add-cart');
            var minicart_content_ele = $('.minicart-content');
            $('.a57').css('display', 'none');
            store_add_acrt_ele.removeClass('active');
            $('.a4y').remove();
            store_add_acrt_ele.children('.a4x').addClass('disabled').addClass('outcartcontent').removeClass('light').removeClass('incartcontent');
            minicart_content_ele.children('.a4x').removeClass('light').addClass('disabled');
            store_add_acrt_ele.children('.a4z').children('div').addClass('a50').html(js_lang.cart_empty);
            store_add_acrt_ele.children('.a51').addClass('disabled').html(text);
            $('.minicart-goods-list').html('');
        }

    };
    ecjia.touch.cart = cart;

    /**
     * 购物车DOM相关操作
     */
    ecjia.touch.cartdom = {

        /**
         * 从商品列表中隐藏数量以及 reduce 按钮
         * @param goods_id
         */
        removeProduct: function (goods_id) {

            var element = $('#goods_' + goods_id);

            element.children('.reduce').removeClass('show').addClass('hide');
            element.children('label').removeClass('show').addClass('hide');
            element.children('span.detail-add').removeClass('show').addClass('hide');
            element.children('span.goods-detail').addClass('hide');
            element.siblings('span').removeClass('hide').attr('rec_id', '');

            $('#setion_' + goods_id).remove();
        },

        /**
         * 更新完购物车后，立即操作的一些dom
         */
        updateCartInitDom: function(){
            $('.la-ball-atom').remove();
            $('.box').children('span').addClass('limit_click'); //禁止其他加减按钮点击
            $('[data-toggle="toggle_checkbox"]').removeClass('limit_click'); //店铺首页 允许其他单选框点击
            $("[data-toggle='add-to-cart']").removeClass('limit_click');
            $("[data-toggle='remove-to-cart']").removeClass('limit_click');

            $('.goods-add-cart').removeClass('disabled');
            $('.ecjia-num-view').find('.btn-ok').removeClass('disabled');
        },

        /**
         * 删除购物车列表中的某个商家
         * @param element
         */
        removeElement: function (element) {
            if (element.hasClass('other_place')) {
                if (element.parent().find('.other_place').length === 1) {
                    $('.a4u.a4u-gray').remove();
                }
            } else if (element.hasClass('current_place')) {
                if (element.parent().find('.current_place').length === 1) {
                    $('.a4u.a4u-green').after('<div class="a57"><span>' + js_lang.shop_cart_empty + '</span></div>');
                }
            }
            element.remove();
            if ($('.a57').length === 1 && $('.a4u-gray').length === 0) {
                var index_url = $('input[name="index_url"]').val();
                $('.ecjia-flow-cart-list').html('').html('<div class="flow-no-pro"><div class="ecjia-nolist">' + js_lang.add_goods_yet + '<a class="btn btn-small" type="button" href="' + index_url + '">' + js_lang.go_go + '</a></div>');
            }
        },

        /**
         * 清空购物车商家列表
         */
        clearCartList: function(store_id){
            var li = $('.check_cart_' + store_id).parents('.cart-single');
            li.remove();
            if ($('li.cart-single').length === 0) {
                // 清空购物车列表
                $('.ecjia-flow-cart').remove();
                $('.flow-no-pro').removeClass('hide');
            }
        },

        /**
         * 根据传入的商品规格和商品数量来决定显示隐藏商品的数量部分
         * @param spec
         * @param type
         * @param goods_id
         * @param num
         */
        updateProductSpecNumDom: function(spec,type,goods_id,num){
            var good_spec_ele = $('.goods_spec_' + goods_id);
            var n = parseInt(good_spec_ele.children('i').html());
            var ecjia_attr_modal = $('.ecjia-attr-modal');

            if (type && type === 'add') {
                if (spec.length !== undefined) {
                    good_spec_ele.find('.choose_attr').attr('data-spec', spec);
                }
                n = n + 1;
                if (isNaN(n)) n = 1;
                if (good_spec_ele.find('.attr-number').length === 0) {
                    good_spec_ele.append('<i class="attr-number">' + n + '</i>');
                } else {
                    good_spec_ele.find('.attr-number').html(n);
                }
            } else if (type && type === 'reduce') {
                n = n - 1;
                if (n === 0) {
                    good_spec_ele.find('.attr-number').remove();
                    good_spec_ele.children('.choose_attr').attr('data-spec', '');
                } else {
                    good_spec_ele.find('.attr-number').html(n);
                }
            }

            if (num === 0) {
                ecjia_attr_modal.find('.add-tocart').addClass('show').removeClass('hide');
                ecjia_attr_modal.find('#goods_' + this.goods_id).removeClass('show').addClass('hide').children().attr('rec_id', '');
            } else {
                ecjia_attr_modal.find('.add-tocart').removeClass('show').addClass('hide');
                ecjia_attr_modal.find('#goods_' + this.goods_id).addClass('show').removeClass('hide');
                ecjia_attr_modal.find('#goods_' + this.goods_id).children().addClass('show').removeClass('hide');
            }
            ecjia_attr_modal.find('#goods_' + this.goods_id).children('label').html(num);
        },

        /**
         * 更新购物车数据和相关dom
         * @param data
         * @param goods_id
         * @param spec
         * @param num
         */
        updateCartDataAndDom: function (data,goods_id,spec,num) {
            var check_button_ele = $('.a51');// 去结算按钮
            var text = check_button_ele .attr('data-text') === undefined ? js_lang.go_settlement : check_button_ele.attr('data-text');

            if (data.count == null) {
                ecjia.touch.category.hide_cart(true);
            } else {
                ecjia.touch.category.show_cart(true);
                // 更新商家商品的选中数量等信息
                var goods_number = data.count.goods_number;
                var goods_ele = $('#goods_' + goods_id);
                if (spec == '' || spec == undefined) {
                    for (var i = 0; i < data.list.length; i++) {
                        if (data.say_list) {
                            if (data.list[i].id == goods_id) {
                                goods_ele.children('.reduce').removeClass('hide').attr('rec_id', data.list[i].rec_id);
                                goods_ele.children('label').removeClass('hide').html(data.list[i].goods_number);
                                goods_ele.children('.add').removeClass('hide').attr('rec_id', data.list[i].rec_id);
                                if ($.find('.may_like_' + goods_id)) {
                                    $('.may_like_' + goods_id).attr('rec_id', data.list[i].rec_id);
                                }
                            }
                        }
                        if (data.list[i].is_checked != 1) {
                            data.count.goods_number -= data.list[i].goods_number;
                        }
                    }
                } else {
                    goods_ele.children('span').attr('rec_id', data.current.rec_id).removeClass('hide');
                    goods_ele.children('label').removeClass('hide').html(data.current.goods_number);
                }

                if (data.say_list) {
                    // 重绘购物车，并且绑定事件
                    $('.minicart-goods-list').html(data.say_list);
                    ecjia.touch.category.change_num();
                }

                // 购物车右上方的数量显示更新
                $('p.a6c').html(sprintf(js_lang.have_select, data.count.goods_number));
                if (goods_number > 99) {
                    $('.a4x').html('<i class="a4y">99+</i>');
                } else {
                    $('.a4x').html('<i class="a4y">' + goods_number + '</i>');
                }

                if (data.count.goods_number === 0) {
                    check_button_ele.addClass('disabled').html(text);
                } else {
                    check_button_ele.removeClass('disabled');
                    //隐藏加入购物车按钮 显示加减按钮
                    var goods_add_cart_ele = $('.goods-add-cart');
                    var ecjia_goods_plus_box_ele = $('.ecjia-goods-plus-box');
                    if (goods_add_cart_ele.attr('goods_id') === goods_id) {
                        if (spec === '') {
                            if (num > 0) {
                                goods_add_cart_ele.addClass('hide').removeClass('show');
                                ecjia_goods_plus_box_ele.removeClass('hide').addClass('show');
                            } else {
                                goods_add_cart_ele.removeClass('hide').addClass('show');
                                ecjia_goods_plus_box_ele.addClass('hide').removeClass('show');
                            }
                        } else {
                            if (num === 0) num = 1;
                            goods_add_cart_ele.not('.choose_attr').addClass('hide');
                            ecjia_goods_plus_box_ele.removeClass('hide').children('label').html(num);
                            ecjia_goods_plus_box_ele.children().removeClass('hide');
                        }
                    }
                }
                // 结算部分信息更新
                var discount_html = '';
                if (parseFloat(data.count.discount) !== 0) {
                    discount_html = '<label>' + sprintf(js_lang.reduced, data.count.discount) + '<label>';
                }
                $('.a4z').html('<div>' + data.count.goods_price + discount_html + '</div>');
                var check_cart_ele =  $('.check_cart');
                if (data.data_rec) {
                    check_cart_ele.attr('data-rec', data.data_rec);
                    check_cart_ele.removeClass('disabled');
                } else {
                    check_cart_ele.attr('data-rec', '');
                    check_cart_ele.addClass('disabled');
                }
                var count = data.count;
                if (count.meet_min_amount === 1 || !count.label_short_amount) {
                    if (count.real_goods_count > 0) {
                        check_cart_ele.removeClass('disabled').html(text);
                    } else {
                        check_cart_ele.html(text);
                    }
                } else {
                    check_cart_ele.addClass('disabled').html(sprintf(js_lang.deviation_pick_up, count.label_short_amount));
                }
                // 对更新的dom绑定事件
                ecjia.touch.category.add_tocart();
                ecjia.touch.category.remove_tocart();
                ecjia.touch.category.toggle_checkbox();
                //隐藏修改购物车商品数量弹窗
                $('.ecjia-num-content').removeClass('show');
            }
        },

        /**
         * remove modal
         */
        removeModal: function(){
            $('.modal').remove();
            $('.modal-overlay').remove();
            $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
        },

        /**
         * 禁止/启动滚动
         * @param ele
         * @param direction
         * @param is_scroll
         */
        isScroll: function (ele,direction,is_scroll) {
            var overflow_direction = "overflow-";
            if(direction && direction ==='x'){
                overflow_direction += 'x';
            }else{
                overflow_direction += 'y'
            }
            $(ele).css(overflow_direction, (is_scroll || is_scroll ===true) ? 'auto': 'hidden').off('touchmove');
            if(!is_scroll){
                $(ele).on('touchmove', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            }
        }
    };

    /**
     * css 的一些tarnsform 方法
     * @type {{translateY: ecjia.touch.css.translateY, translateX: ecjia.touch.css.translateX}}
     */
    ecjia.touch.css = {
        translateX: function (ele,x) {
            $(ele).css('transform','translateX('+x+'px)');
        },
        translateY: function (ele,x) {
            $(ele).css('transform','translateY('+x+'px)');
        }
    };
    ecjia.touch.cartBindEvent = {
        init: function(){
           this.addToCart();
           this.removeCart();
           this.changeNum();
           this.toggleCart();
           this.toggleCategory();
        },
        /**
         * + 按钮点击绑定事件
         * 把事件绑定到 ul 父元素上，避免需要重复绑定
         */
        addToCart: function () {
            $('.store_goods_all').on('click',"[data-toggle='add-to-cart']",this.addToCartBindFunc.bind(this));
            $('.minicart-goods-list').on('click',"[data-toggle='add-to-cart']",this.addToCartBindFunc.bind(this));
        },
        /**
         * - 按钮点击绑定事件
         * 把事件绑定到 ul 父元素上，避免需要重复绑定
         */
        removeCart: function () {
            $('.store_goods_all').on('click',"[data-toggle='remove-to-cart']",this.removeToCartBindFunc.bind(this));
            $('.minicart-goods-list').on('click',"[data-toggle='remove-to-cart']",this.removeToCartBindFunc.bind(this))
        },

        /**
         * 订单页面
         * + 按钮点击绑定事件
         * 把事件绑定到 ul 父元素上，避免需要重复绑定
         */
        addGoods: function(){

        },
        /**
         * 订单页面
         * - 按钮点击绑定事件
         * 把事件绑定到 ul 父元素上，避免需要重复绑定
         */
        removeGoods: function(){

        },
        /**
         * 改变商品数量相关事件
         * 同样绑定到购物车列表上
         */
        changeNum: function(){
            $('.minicart-goods-list').on('click',"[data-toggle='change-number']",function () {});
            // 弹出框上元素的事件绑定一次即可
        },
        /**
         * 购物车动画效果
         */
        toggleCart: function(){
            // 同样绑定一次即可
        },
        /**
         * 左侧分类绑定事件
         */
        toggleCategory: function(){

        },
        //-----以下为绑定的函数方法----
        /**
         * 添加到购物车按钮绑定事件
         * @param ev
         */
        addToCartBindFunc: function (ev) {

        },
        /**
         *
         * @param ev
         */
        removeToCartBindFunc: function (ev) {

        }

    }

})(ecjia, jQuery);

