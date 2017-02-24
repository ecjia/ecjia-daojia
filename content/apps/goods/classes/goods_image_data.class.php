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
 * 图片处理类
 * @author royalwang
 */
RC_Loader::load_app_class('goods_imageutils', 'goods', false);
RC_Loader::load_app_class('goods_image_format', 'goods', false);
class goods_image_data {
	protected $file_path;

	protected $auto_generate_thumb = true;
	
	protected $goods_format;
	protected $gallery_format;
	
	protected $goods_id;
	
	protected $img_desc;
	protected $img_ext;
	
	/**
	 * 构造函数
	 * @param array $file 上传后返回的文件信息
	 */
	public function __construct($file_name, $file_path, $img_ext, $goods_id) {
	    $this->goods_id = $goods_id;
	    $this->img_ext = $img_ext;
	    $this->img_desc = $file_name;
	    $this->file_path = $file_path;

	    $this->goods_format = new goods_image_format($goods_id, $img_ext, goods_image_format::GOODS_IMAGE);
	    $this->gallery_format = new goods_image_format($goods_id, $img_ext, goods_image_format::GOODS_GALLERY);
	    
	    $this->create_dir();
	}
	
	protected function create_dir() {
	    $images_path = RC_Upload::upload_path() . $this->goods_format->filePathPrefix() . DS;
	    goods_imageutils::createImagesDirectory($images_path);
	}
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	protected function generate_goods() {
	    /* 重新格式化图片名称 */
	    $img_path = goods_imageutils::getAbsolutePath($this->goods_format->getGoodsimgPostion());
	    $original_path = goods_imageutils::getAbsolutePath($this->goods_format->getSourcePostion());

	    // 生成缩略图
	    if ($this->auto_generate_thumb) {
	        $thumb_path      = goods_imageutils::getAbsolutePath($this->goods_format->getThumbPostion());
	        goods_imageutils::makeThumb($this->file_path, $thumb_path, $this->img_ext, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
	    }

	    goods_imageutils::addWatermark($this->file_path, $img_path);
	    goods_imageutils::copyImage($this->file_path, $original_path);
	}
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	protected function generate_gallery() {
	    $original_path = goods_imageutils::getAbsolutePath($this->gallery_format->getSourcePostion());
	    $img_path = goods_imageutils::getAbsolutePath($this->gallery_format->getGoodsimgPostion());
	    $thumb_path = goods_imageutils::getAbsolutePath($this->gallery_format->getThumbPostion());
	
	    // 生成缩略图
	    goods_imageutils::makeThumb($this->file_path, $thumb_path, $this->img_ext, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
	    goods_imageutils::addWatermark($this->file_path, $img_path);
	    goods_imageutils::copyImage($this->file_path, $original_path);
	}
	
	/**
	 * 设置是否需要自动生成缩略图，默认为自动生成缩略图
	 * @param boolean $bool
	 */
	public function set_auto_thumb($bool) {
	    if (is_bool($bool)) {
	        $this->auto_generate_thumb = $bool;
	    }
	}
	
	/**
	 * 更新商品图片
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_goods($img_desc = null) {
	    if (empty($img_desc)) {
	        $img_desc = $this->img_desc;
	    }

	    $this->generate_goods();

	    $goods_img = $this->goods_format->getGoodsimgPostion();
	    $goods_original = $this->goods_format->getSourcePostion();
	    $goods_thumb = $this->auto_generate_thumb ? $this->goods_format->getThumbPostion() : '';
	    
	    if (!$goods_original || !$goods_img) {
	        return new ecjia_error('upload_goods_image_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }
	    
	    $db_goods = RC_Model::model('goods/goods_model');
	    
	    /* 如果有上传图片，删除原来的商品图 */
	    $row = $db_goods->field('goods_thumb,goods_img,original_img')->find(array('goods_id' => $this->goods_id));

	    $data = array(
			'goods_img'      => $goods_img,
	        'goods_thumb'    => $goods_thumb,
	        'original_img'   => $goods_original,
		);
		$db_goods->where(array('goods_id' => $this->goods_id))->update($data);
		
		/* 先存储新的图片，再删除原来的图片 */
		if ($row['goods_thumb']) {
		    goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['goods_thumb']));
		}
		if ($row['goods_img']) {
		    goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['goods_img']));
		}
		if ($row['original_img']) {
		    goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['original_img']));
		}
	    
	    /* 复制一份相册图片 */
	    /* 添加判断是否自动生成相册图片 */
	    if (ecjia::config('auto_generate_gallery')) {
	        $data = $this->update_gallery($img_desc);
	        if (empty($data['img_id'])) {
	            return new ecjia_error('copy_gallery_image_fail', RC_Lang::get('goods::goods.copy_gallery_image_fail'));
	        }
	    }
	    
// 	    goods_imageutils::deleteImage($this->file_path);

	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($goods_original)) {
	        $db_goods->where(array('goods_id' => $this->goods_id))->update(array('original_img' => ''));
	        goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($goods_original));
	    }

	}
	
	/**
	 * 更新商品缩略图
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_thumb() {
	    $thumb_path = goods_imageutils::getAbsolutePath($this->goods_format->getThumbPostion());
	    goods_imageutils::copyImage($this->file_path, $thumb_path);

	    $goods_thumb = $this->goods_format->getThumbPostion();
	    if (!$goods_thumb) {
	        return new ecjia_error('upload_thumb_error', RC_Lang::get('goods::goods.upload_thumb_error'));
	    }
	     
	    $db_goods = RC_Model::model('goods/goods_model');
	    
	    /* 如果有上传图片，删除原来的商品图 */
	    $row = $db_goods->field('goods_thumb')->find(array('goods_id' => $this->goods_id));
	     
	    $data = array('goods_thumb' => $goods_thumb);
	    $db_goods->where(array('goods_id' => $this->goods_id))->update($data);
	    
	    /* 先存储新的图片，再删除原来的图片 */
	    if ($row['goods_thumb'] != '') {
	        goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['goods_thumb']));
	    }
	     
// 	    goods_imageutils::deleteImage($this->file_path);
	}

	public function update_gallery($img_desc = null) {
	    if (empty($img_desc)) {
	        $img_desc = $this->img_desc;
	    }
	    
	    $this->generate_gallery();
	    
	    $goods_img = $this->gallery_format->getGoodsimgPostion();
	    $goods_original = $this->gallery_format->getSourcePostion();
	    $goods_thumb = $this->gallery_format->getThumbPostion();
	    
	    if (!$goods_original || !$goods_img) {
	        return new ecjia_error('upload_goods_gallery_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }

	    $db_goods_gallery = RC_Model::model('goods/goods_gallery_model');
	    
	    $data = array(
	        'goods_id' 		=> $this->goods_id,
	        'img_url' 		=> $goods_img,
	        'img_desc' 		=> $img_desc,
	        'thumb_url' 	=> $goods_thumb,
	        'img_original' 	=> $goods_original . '?999',
	    );
	    $data['img_id'] = $db_goods_gallery->insert($data);
	    
// 	    goods_imageutils::deleteImage($this->file_path);
	    
	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($data['img_original'])) {
	        $db_goods_gallery->where(array('goods_id' => $this->goods_id))->update(array('img_original' => ''));
	        goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($data['img_original']));
	    }
	    
	    return $data;
	}

}

// end