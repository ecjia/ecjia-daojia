<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_config('constant', 'captcha', false);

class captcha_merchant_plugin {
	
	static public function merchant_login_captcha() {
		if (ecjia_config::has('captcha_style') && 
			(intval(ecjia::config('captcha')) & CAPTCHA_ADMIN) && 
			RC_ENV::gd_version() > 0) {
			$captcha = RC_Loader::load_app_class('captcha_method', 'captcha');
			if ($captcha->check_activation_captcha()) {
			    $captcha_url =  $captcha->current_captcha_url(captcha_method::CAPTCHA_MERCHANT);
			    
			    $click_for_another = RC_Lang::get('captcha::captcha_manage.click_for_another');
			    $label_captcha = RC_Lang::get('captcha::captcha_manage.label_merchant_captcha');
			    $validate_length = 4;
			    $validate_url = RC_Uri::url('captcha/merchant_captcha/check_validate');
			    echo  <<<EOF
		<div class="hideimg" style="z-index: -1; position: absolute;"><a class='close'>×</a><img src='$captcha_url' title='$click_for_another' ></div>
		<div class="formRow">
			<div class="input-prepend">
				<input class="form-control"  type="text" maxlength="4" name="captcha" placeholder="$label_captcha" value=""  data-placement="top" />
			</div>
		<script>
			var validate_length = {$validate_length},
				validate_url = "{$validate_url}";
			$(window).load(function(){
				var obj_hideimg = $('.hideimg');
				var obj_img = obj_hideimg.find('img');
						
						
				$(document).on('click', '.popover img', function(){
					var newsrc = $(this).attr('src')+Math.random();
					$(this).attr('src',newsrc);
					$('.hideimg img').attr('src',newsrc);
				});
				$(document).on('click', '.close', function(){
					$('.popover').remove();
				});
	
				$('input[name="captcha"]').keyup(function(event){
					if(event.keyCode === 27 || event.keyCode === 13){
						$('.popover').remove();
						$(this).blur();
					}
						
					if(event.keyCode === 13){
						return;
					}
					var obj_this = $(this),
						obj_row = obj_this.parents('.formRow');
					obj_this.val(obj_this.val().toUpperCase());
					if (obj_this.val().length == validate_length) {
						$.post(validate_url, {'captcha': obj_this.val()}, function(data) {
							if (data.state == 'success') {
								$("input[name=captcha]").css('border-color','#468847');
								$('.popover').remove();
							} else {
								$("input[name=captcha]").css('border-color','#b94a48');
							}
						});
					}
				}).popover({
					html: true,
					animation: false,
					trigger: 'manual',
					content: function(){
						var width = obj_img.width()+15;
						var height = obj_img.height()+10;
						return obj_hideimg.clone().css({width : width, height: height, position : 'relative', zIndex : '9999'});
					}
				});
				$('input[name="captcha"]').focus(function(){
					if(!$('.popover').text()){
						$(this).popover('show');
					}
				});
	
			});
		</script>
EOF;
			}
		}
	}
	
	static public function merchant_login_validate($args) {
		if (ecjia_config::has('captcha_style') && 
			!empty($_SESSION['captcha_word']) && 
			(intval(ecjia::config('captcha')) & CAPTCHA_ADMIN)) {
			/* 检查验证码是否正确 */
			RC_Loader::load_app_class('captcha_factory', 'captcha', false);
			$validator = new captcha_factory(ecjia::config('captcha_style'));
			if (isset($args['captcha']) && !$validator->verify_word($args['captcha'])) {
				return RC_Lang::get('captcha::captcha_manage.captcha_error');
			}
		}
	}
	
	static public function set_merchant_captcha_access($route) {
	    $route[] = 'captcha/merchant_captcha/init';
	    $route[] = 'captcha/merchant_captcha/check_validate';
	    return $route;
	}
}

RC_Hook::add_action('merchant_login_captcha', array('captcha_merchant_plugin', 'merchant_login_captcha'));
RC_Hook::add_filter('merchant_login_validate', array('captcha_merchant_plugin', 'merchant_login_validate'));
RC_Hook::add_filter('merchant_access_public_route', array('captcha_merchant_plugin', 'set_merchant_captcha_access'));

// end