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

/**
 * 生成验证码
 * @author royalwang
 * 类用法
 * $checkcode = new captcha();
 * $checkcode->generate_image();
 * //取得验证
 * $checkcode->record_word(); // $_SESSION['code']
 */

RC_Loader::load_app_class('captcha_abstract', 'captcha', false);
class captcha_royalcms_image extends captcha_abstract {
    /**
     * 存在session中的名称
     * @var string	$session_word
     */
    private $session_word 	= 'captcha_word';

    /**
     * 验证码的宽度
     * @var integrate
     */
	public $width			= 130;
	
	/**
	 * 验证码的高
	 * @var integrate
	 */
	public $height			= 50;
	
	/**
	 * 设置字体的地址
	 * @var string
	 */
	public $font;
	
	/**
	 * 设置字体色
	 * @var string
	 */
	public $font_color;
	
	/**
	 * 设置随机生成因子
	 * @var string
	 */
	public $charset 		= 'abcdefghkmnprstuvwyzABCDEFGHKLMNPRSTUVWYZ23456789';
	
	/**
	 * 设置背景色
	 * @var string
	 */
	public $background 		= '#FFFFFF';
	
	/**
	 * 生成验证码字符数
	 * @var integrate
	 */
	public $code_len 		= 4;
	
	/**
	 * 字体大小
	 * @var integrate
	 */
	public $font_size 		= 20;
	
	/**
	 * 验证码
	 * @var string
	 */
	private $code;
	
	/**
	 * 图片内存
	 * @var bin
	 */
	private $img;
	
	/**
	 * 文字X轴开始的地方
	 * @var integrate
	 */
	private $x_start;
		
	function __construct($config = array()) {
		$this->font = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR . 'elephant.ttf';
		parent::__construct($config);
	}
	
	/**
	 * 生成随机验证码。
	 */
	protected function creat_code() {
		$code = '';
		$charset_len = strlen($this->charset)-1;
		for ($i=0; $i<$this->code_len; $i++) {
			$code .= $this->charset[rand(1, $charset_len)];
		}
		$this->code = $code;
	}
	
	/**
	 * 生成验证码
	 */
	protected function record_word() {
		$_SESSION[$this->session_word] = strtolower($this->code);
	}
	
	
	/**
	 * 验证码校验
	 */
	public function verify_word($word) {
		$word = strtolower($word);
		if ($_SESSION[$this->session_word] == $word) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 生成图片
	 */
	public function generate_image() {
		$this->creat_code();
		$this->record_word();
		$this->img = imagecreatetruecolor($this->width, $this->height);
		if (!$this->font_color) {
			$this->font_color = imagecolorallocate($this->img, rand(0,156), rand(0,156), rand(0,156));
		} else {
			$this->font_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1,2)), hexdec(substr($this->font_color, 3,2)), hexdec(substr($this->font_color, 5,2)));
		}
		//设置背景色
		$background = imagecolorallocate($this->img,hexdec(substr($this->background, 1,2)),hexdec(substr($this->background, 3,2)),hexdec(substr($this->background, 5,2)));
		//画一个柜形，设置背景颜色。
		imagefilledrectangle($this->img,0, $this->height, $this->width, 0, $background);
		$this->creat_font();
		$this->creat_line();
		$this->output();
	}
	
	/**
	 * 生成文字
	 */
	private function creat_font() {
		$x = $this->width/$this->code_len;
		for ($i=0; $i<$this->code_len; $i++) {
			imagettftext($this->img, $this->font_size, rand(-30,30), $x*$i+rand(0,5), $this->height/1.4, $this->font_color, $this->font, $this->code[$i]);
			if($i==0)$this->x_start=$x*$i+5;
		}
	}
	
	/**
	 * 画线
	 */
	private function creat_line() {
		imagesetthickness($this->img, 3);
	    $xpos   = ($this->font_size * 2) + rand(-5, 5);
	    $width  = $this->width / 2.66 + rand(3, 10);
	    $height = $this->font_size * 2.14;
	
	    if ( rand(0,100) % 2 == 0 ) {
	      $start = rand(0,66);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(180, 246);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 110);
	
	    imagearc($this->img, $xpos, $ypos, $width, $height, $start, $end, $this->font_color);
	
	    if ( rand(1,75) % 2 == 0 ) {
	      $start = rand(45, 111);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(200, 250);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 100);
	
	    imagearc($this->img, $this->width * .75, $ypos, $width, $height, $start, $end, $this->font_color);
	}
	
	//输出图片
	private function output() {
		header("content-type:image/png\r\n");
		imagepng($this->img);
		imagedestroy($this->img);
	}
}

// end