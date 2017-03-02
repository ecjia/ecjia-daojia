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
class goods_image {
	private    $uploaded_info = array();
	private    $uploaded_file_path;
	
	private    $dir = 'images';
	
	private    $uploaded_file_name;
	
	private    $auto_thumb = true;
	
	/**
	 * 构造函数
	 * @param array $file 上传后返回的文件信息
	 */
	public function __construct($file = array()) {
	    $this->uploaded_info       = $file;
	    $this->uploaded_file_path  = RC_Upload::upload_path() . $file['savepath'] . DS . $file['savename'];
	    $this->uploaded_file_name  = $file['name'];
	}
	
	
	/**
	 * 设置是否需要自动生成缩略图，默认为自动生成缩略图
	 * @param boolean $bool
	 */
	public function set_auto_thumb($bool) {
	    if (is_bool($bool)) {
	        $this->auto_thumb = $bool;
	    }
	}
	
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	public function generate_goods($goods_id) {
	    /* 重新格式化图片名称 */
	    $original_path   = $this->reformat_image_name('goods', $goods_id, 'source');
	    $img_path        = $this->reformat_image_name('goods', $goods_id, 'goods');
	    
	    // 生成缩略图
	    if ($this->auto_thumb) {
	        $thumb_path      = $this->reformat_image_name('goods_thumb', $goods_id, 'thumb');
	        $this->make_thumb($this->uploaded_file_path, $thumb_path, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
	    } else {
	        $thumb_path = '';
	    }
	    
	    $this->add_watermark($this->uploaded_file_path, $img_path);
	    $this->copy_image($this->uploaded_file_path, $original_path);
	
	    $img_original   = $this->get_image_url($original_path);
	    $img_url        = $this->get_image_url($img_path);
	    $thumb_url      = $this->get_image_url($thumb_path);
	    return array($img_url, $thumb_url, $img_original);
	}
	
	/**
	 * 更新商品图片
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_goods($goods_id, $img_desc = '') {
	    if (empty($img_desc)) {
	        $img_desc = $this->uploaded_file_name;
	    }
	    
	    list($goods_img, $goods_thumb, $goods_original) = $this->generate_goods($goods_id);
	    
	    if (!$goods_original || !$goods_img) {
	        return new ecjia_error('upload_goods_image_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }
	    
	    $this->db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	    
	    
	    /* 如果有上传图片，删除原来的商品图 */
	    $row = $this->db_goods->join(null)->field('goods_thumb,goods_img,original_img')->find(array('goods_id' => $goods_id));
	    
	    
	    $data = array(
			'goods_img'      => $goods_img,
	        'goods_thumb'    => $goods_thumb,
	        'original_img'   => $goods_original,
		);
		$this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update($data);
		
		/* 先存储新的图片，再删除原来的图片 */
		if ($row['goods_thumb'] != '') {
		    $this->delete_image(self::get_absolute_path($row['goods_thumb']));
		}
		if ($row['goods_img'] != '') {
		    $this->delete_image(self::get_absolute_path($row['goods_img']));
		}
		if ($row['original_img'] != '') {
		    $this->delete_image(self::get_absolute_path($row['original_img']));
		}
	    
	    /* 复制一份相册图片 */
	    /* 添加判断是否自动生成相册图片 */
	    if (ecjia::config('auto_generate_gallery')) {
	        $data = $this->update_gallery($goods_id, $img_desc);
	        if (empty($data['img_id'])) {
	            return new ecjia_error('copy_gallery_image_fail', RC_Lang::get('goods::goods.copy_gallery_image_fail'));
	        }
	    }
	    
	    $this->delete_image($this->uploaded_file_path);
	    
	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($goods_original)) {
	        $this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update(array('original_img' => ''));
	        $this->delete_image(RC_Upload::upload_path() . str_replace('/', DS, $goods_original));
	    }
	}
	
	/**
	 * 更新商品缩略图
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_thumb($goods_id) {
	    $thumb_path      = $this->reformat_image_name('goods_thumb', $goods_id, 'thumb');
	    $this->copy_image($this->uploaded_file_path, $thumb_path);

	    $goods_thumb     = $this->get_image_url($thumb_path);
	    if (!$goods_thumb) {
	        return new ecjia_error('upload_thumb_error', RC_Lang::get('goods::goods.upload_thumb_error'));
	    }
	     
	    $this->db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	     
	    $data = array('goods_thumb' => $goods_thumb);
	    $this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update($data);
	     
	    $this->delete_image($this->uploaded_file_path);
	}
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	public function generate_gallery($goods_id) {
        /* 重新格式化图片名称 */
        $original_path   = $this->reformat_image_name('gallery', $goods_id, 'source');
        $img_path        = $this->reformat_image_name('gallery', $goods_id, 'goods');
        $thumb_path      = $this->reformat_image_name('gallery_thumb', $goods_id, 'thumb');
        
        // 生成缩略图
        $this->make_thumb($this->uploaded_file_path, $thumb_path, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
        $this->add_watermark($this->uploaded_file_path, $img_path);
        $this->copy_image($this->uploaded_file_path, $original_path);
        
        $img_original   = $this->get_image_url($original_path);
        $img_url        = $this->get_image_url($img_path);
        $thumb_url      = $this->get_image_url($thumb_path);
        return array($img_url, $thumb_url, $img_original);
	}
	
	
	
	public function update_gallery($goods_id, $img_desc = '') {
	    if (empty($img_desc)) {
	        $img_desc = $this->uploaded_file_name;
	    }
	    
	    list($goods_img, $goods_thumb, $img_original) = $this->generate_gallery($goods_id);
	    
	    if (!$img_original || !$goods_img) {
	        return new ecjia_error('upload_goods_image_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }
	    
	    $this->delete_image($this->uploaded_file_path);
	    
	    $db_goods_gallery = RC_Loader::load_app_model('goods_gallery_model', 'goods');
	    
	    $data = array(
	        'goods_id' => $goods_id,
	        'img_url' => $goods_img,
	        'img_desc' => $img_desc,
	        'thumb_url' => $goods_thumb,
	        'img_original' => $img_original . '?999',
	    );
	    $data['img_id'] = $db_goods_gallery->insert($data);
	    
	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($data['img_original'])) {
	        $this->db_goods_gallery->where(array('goods_id' => $goods_id))->update(array('img_original' => ''));
	        $this->delete_image(RC_Upload::upload_path() . str_replace('/', DS, $data['img_original']));
	    }
	    
	    return $data;
	}
	
	
	
	/**
	 * 格式化商品图片名称（按目录存储）
	 *
	 */
	public function reformat_image_name($type, $goods_id, $position = '')
	{
	    $rand_name = RC_Time::gmtime() . sprintf("%03d", mt_rand(1,999));
	    $img_ext = '.' . $this->uploaded_info['ext'];
        
	    $sub_dir = date('Ym', RC_Time::gmtime());
	    
	    $path = RC_Upload::upload_path() . $this->dir . DS . $sub_dir . DS;
	    
	    royalcms('files')->makeDirectory($path . 'source_img');
	    royalcms('files')->makeDirectory($path . 'goods_img');
	    royalcms('files')->makeDirectory($path . 'thumb_img');
	    
        $original_img_path = $path . 'source_img' . DS;
        $goods_img_path = $path . 'goods_img' . DS;
        $goods_thumb_path = $path . 'thumb_img' . DS;

	    switch($type) {
	    	case 'goods':
	    	    $img_name = $goods_id . '_G_' . $rand_name;
	    	    break;
	    	case 'goods_thumb':
	    	    $img_name = $goods_id . '_thumb_G_' . $rand_name;
	    	    break;
	    	case 'gallery':
	    	    $img_name = $goods_id . '_P_' . $rand_name;
	    	    break;
	    	case 'gallery_thumb':
	    	    $img_name = $goods_id . '_thumb_P_' . $rand_name;
	    	    break;
	    }
	
	    if ($position == 'source') {
	        return $original_img_path . $img_name . $img_ext;
	    } elseif ($position == 'thumb') {
	        return $goods_thumb_path . $img_name . $img_ext;
	    } else {
	        return $goods_img_path . $img_name . $img_ext;
	    }
	    return false;
	}
	
	/**
	 * 获取相对上传目录的图片路径
	 * @param string $path
	 * @return string
	 */
	public function get_image_url($path) {
	    if ($path) {
	        return str_replace(DS, '/', str_replace(RC_Upload::upload_path(), '', $path));
	    }
	    return false;
	}
	
	/**
	 * 获取上传图片的绝对路径
	 * @param string $path 数据库中存储的地址
	 * @return string|boolean
	 */
	public static function get_absolute_path($path) {
	    if ($path) {
	        return RC_Upload::upload_path() . $path;
	    }
	    return false;
	}
	
	/**
	 * 获取上传图片的绝对地址
	 * @param string $path 数据库中存储的地址
	 * @return string|boolean
	 */
	public static function get_absolute_url($path) {
	    if ($path) {
	        return RC_Upload::upload_url() . '/' . $path;
	    }
	    return false;
	}

	
    /**
     * 创建图片的缩略图
     *
     * @access public
     * @param string $img 原始图片的路径
     * @param strint $thumbname 生成图片的文件名
     * @param int $thumb_width 缩略图宽度
     * @param int $thumb_height 缩略图高度
     * @return mix 如果成功返回缩略图的路径，失败则返回false
     */
    public function make_thumb($img, $thumbname, $thumb_width = 0, $thumb_height = 0)
    {
    	$image_name = RC_Image::thumb($img, $thumbname, $this->uploaded_info['ext'], $thumb_width, $thumb_height);
    	return $image_name;
    }
    
    /**
     * 为图片增加水印
     *
     * @access      public
     * @param       string      filename            原始图片文件名，包含完整路径
     * @param       string      target_file         需要加水印的图片文件名，包含完整路径。如果为空则覆盖源文件
     * @param       string      $watermark          水印完整路径
     * @param       int         $watermark_place    水印位置代码
     * @return      mix         如果成功则返回文件路径，否则返回false
     */
    public function add_watermark($filename, $target_file='', $watermark='', $watermark_place='', $watermark_alpha = 0.65) {
        return $this->copy_image($filename, $target_file);
    }

	
    /**
     * 复制图片
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public function copy_image($source_path, $dest_path) {
        if (is_file($source_path) && is_writable(dirname($dest_path))) {
            return @copy($source_path, $dest_path);
        }
        
        return false;
    }
    
    /**
     * 删除图片
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public function delete_image($img_path = '') {
        if (!$img_path) {
            $img_path = $this->uploaded_file_path; 
        }
        
        if (!is_file($img_path)) {
            return false;
        }
        
        return @unlink($img_path);
    }

}

// end