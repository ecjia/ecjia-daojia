<?php namespace Royalcms\Component\Foundation;
defined('IN_ROYALCMS') or exit('No permission resources.');

/** 
 * IP处理类
*/
class Image extends RoyalcmsObject
{
    
    /**
     * Returns a WP_Image_Editor instance and loads file into it.
     *
     * @since 3.5.0
     * @access public
     *
     * @param string $path Path to file to load
     * @param array $args Additional data. Accepts { 'mime_type'=>string, 'methods'=>{string, string, ...} }
     * @return WP_Image_Editor|WP_Error
     */
    public static function get_image_editor( $path, $args = array() ) {
        $args['path'] = $path;
    
        if ( ! isset( $args['mime_type'] ) ) {
            $file_info = wp_check_filetype( $args['path'] );
    
            // If $file_info['type'] is false, then we let the editor attempt to
            // figure out the file type, rather than forcing a failure based on extension.
            if ( isset( $file_info ) && $file_info['type'] )
                $args['mime_type'] = $file_info['type'];
        }
    
        $implementation = self::_image_editor_choose( $args );
    
        if ( $implementation ) {
            $editor = new $implementation( $path );
            $loaded = $editor->load();
    
            if ( Error::is_error( $loaded ) )
                return $loaded;
    
            return $editor;
        }
    
        return new Error( 'image_no_editor', __('No editor could be selected.') );
    }
    
    
    /**
     * Tests whether there is an editor that supports a given mime type or methods.
     *
     * @since 3.5.0
     * @access public
     *
     * @param string|array $args Array of requirements. Accepts { 'mime_type'=>string, 'methods'=>{string, string, ...} }
     * @return boolean true if an eligible editor is found; false otherwise
     */
    public static function image_editor_supports( $args = array() ) {
        return (bool) self::_image_editor_choose( $args );
    }
    
    
    /**
     * Tests which editors are capable of supporting the request.
     *
     * @since 3.5.0
     * @access private
     *
     * @param array $args Additional data. Accepts { 'mime_type'=>string, 'methods'=>{string, string, ...} }
     * @return string|bool Class name for the first editor that claims to support the request. False if no editor claims to support the request.
     */
    private static function _image_editor_choose( $args = array() ) {
        /**
         * Filter the list of image editing library classes.
         *
         * @since 3.5.0
         *
         * @param array $image_editors List of available image editors. Defaults are
         *                             'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD'.
         */
        $implementations = \RC_Hook::apply_filters( 'rc_image_editors', array( '\Component_ImageEditor_Imagick', '\Component_ImageEditor_GD' ) );
    
        foreach ( $implementations as $implementation ) {
            if ( ! call_user_func( array( $implementation, 'test' ), $args ) )
                continue;
    
            if ( isset( $args['mime_type'] ) &&
                ! call_user_func(
                    array( $implementation, 'supports_mime_type' ),
                    $args['mime_type'] ) ) {
                        continue;
                    }
    
                    if ( isset( $args['methods'] ) &&
                        array_diff( $args['methods'], get_class_methods( $implementation ) ) ) {
                            continue;
                        }
    
                        return $implementation;
        }
    
        return false;
    }
    
    
    /**
     * 生成缩略图
     * @static
     * @access public
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     * @return void
     */
    public static function thumb($image, $thumbname, $type = '', $maxWidth = 200, $maxHeight = 50, $interlace = true) {
        // 获取原图信息
        $info = self::get_image_info($image);
        if ($info !== false) {
            $srcWidth = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type) ? $info['type'] : $type;
            $type = strtolower($type);
            $interlace = $interlace ? 1 : 0;
            unset($info);
            $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight); // 计算缩放比例
            if ($scale >= 1) {
                // 超过原图大小不再缩略
                $width = $srcWidth;
                $height = $srcHeight;
            } else {
                // 缩略图尺寸
                $width = (int) ($srcWidth * $scale);
                $height = (int) ($srcHeight * $scale);
            }
    
            // 载入原图
            $createFun = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
            if (!function_exists($createFun)) {
                //@todo 出错信息返回
//                 $this->error_msg = sprintf($this->lang('nonsupport_type'), $info['type']);
//                 $this->error_no = ERR_NO_GD;
                return false;
            }
            $srcImg = $createFun($image);
    
            //创建缩略图
            if ($type != 'gif' && function_exists('imagecreatetruecolor')) {
                $thumbImg = imagecreatetruecolor($width, $height);
            } else {
                $thumbImg = imagecreate($width, $height);
            }
            
            //png和gif的透明处理
            if ('png' == $type) {
                imagealphablending($thumbImg, false);//取消默认的混色模式（为解决阴影为绿色的问题）
                imagesavealpha($thumbImg, true);//设定保存完整的 alpha 通道信息（为解决阴影为绿色的问题）
            } elseif('gif' == $type) {
                $trnprt_indx = imagecolortransparent($srcImg);
                if ($trnprt_indx >= 0) {
                    //its transparent
                    $trnprt_color = imagecolorsforindex($srcImg , $trnprt_indx);
                    $trnprt_indx = imagecolorallocate($thumbImg, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                    imagefill($thumbImg, 0, 0, $trnprt_indx);
                    imagecolortransparent($thumbImg, $trnprt_indx);
                }
            }
            // 复制图片
            if (function_exists("ImageCopyResampled")) {
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            } else {
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            }
            
            // 对jpeg图形设置隔行扫描
            if ('jpg' == $type || 'jpeg' == $type) {
                imageinterlace($thumbImg, $interlace);
            }
            
            // 生成图片
            $imageFun = 'image' . ($type == 'jpg' ? 'jpeg' : $type);
            $imageFun($thumbImg, $thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return $thumbname;
        }
        return false;
    }
    
    
    /**
     * 为图片添加水印
     * @static public
     * @param string $source 原文件名
     * @param string $water  水印图片
     * @param string $$savename  添加水印后的图片名
     * @param string $alpha  水印的透明度
     * @return void
     */
    public static function water($source, $water, $savename = null, $alpha = 80) {
        //检查文件是否存在
        if (!file_exists($source) || !file_exists($water)) {
            return false;
        }
    
        //图片信息
        $sInfo = self::get_image_info($source);
        $wInfo = self::get_image_info($water);
    
        //如果图片小于水印图片，不生成图片
        if ($sInfo["width"] < $wInfo["width"] || $sInfo['height'] < $wInfo['height']) {
            return false;
        }
    
        //建立图像
        $sCreateFun = "imagecreatefrom" . $sInfo['type'];
        $sImage = $sCreateFun($source);
        $wCreateFun = "imagecreatefrom" . $wInfo['type'];
        $wImage = $wCreateFun($water);
    
        //设定图像的混色模式
        imagealphablending($wImage, true);
    
        //图像位置,默认为右下角右对齐
        $posY = $sInfo["height"] - $wInfo["height"];
        $posX = $sInfo["width"] - $wInfo["width"];
    
        //生成混合图像
        imagecopymerge($sImage, $wImage, $posX, $posY, 0, 0, $wInfo['width'], $wInfo['height'], $alpha);
    
        //输出图像
        $ImageFun = 'Image' . $sInfo['type'];
        //如果没有给出保存文件名，默认为原图像名
        if (!$savename) {
            $savename = $source;
            @unlink($source);
        }
        //保存图像
        $ImageFun($sImage, $savename);
        imagedestroy($sImage);
    }
    
    
    /**
     * 取得图像信息
     * @static
     * @access public
     * @param string $image 图像文件名
     * @return mixed
     */
    public static function get_image_info($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime']
            );
            return $info;
        } else {
            return false;
        }
    }
    
    public static function show_image($img_file, $text='', $x='10', $y='10', $alpha='50') {
        //获取图像文件信息
        //增加图片水印输出，$text为图片的完整路径即可
        $info = self::get_image_info($img_file);
        if ($info !== false) {
            $createFun = str_replace('/', 'createfrom', $info['mime']);
            $im = $createFun($img_file);
            if ($im) {
                $ImageFun = str_replace('/', '', $info['mime']);
                //水印开始
                if (!empty($text)) {
                    $tc = imagecolorallocate($im, 0, 0, 0);
                    //判断$text是否是图片路径
                    if (is_file($text) && file_exists($text)) {
                        // 取得水印信息
                        $textInfo = self::getImageInfo($text);
                        $createFun2 = str_replace('/', 'createfrom', $textInfo['mime']);
                        $waterMark = $createFun2($text);
                        //$waterMark=imagecolorallocatealpha($text,255,255,0,50);
                        $imgW = $info["width"];
                        $imgH = $info["width"] * $textInfo["height"] / $textInfo["width"];
                        //$y	=	($info["height"]-$textInfo["height"])/2;
                        //设置水印的显示位置和透明度支持各种图片格式
                        imagecopymerge($im, $waterMark, $x, $y, 0, 0, $textInfo['width'], $textInfo['height'], $alpha);
                    } else {
                        imagestring($im, 80, $x, $y, $text, $tc);
                    }
                    //ImageDestroy($tc);
                }
                //水印结束
                if ($info['type'] == 'png' || $info['type'] == 'gif') {
                    imagealphablending($im, false); //取消默认的混色模式
                    imagesavealpha($im, true); //设定保存完整的 alpha 通道信息
                }
                Header("Content-type: " . $info['mime']);
                $ImageFun($im);
                @ImageDestroy($im);
                return;
            }
    
            //             //保存图像
            //             $ImageFun($sImage, $savename);
            //             imagedestroy($sImage);
            //             //获取或者创建图像文件失败则生成空白PNG图片
            //             $im = imagecreatetruecolor(80, 30);
            //             $bgc = imagecolorallocate($im, 255, 255, 255);
            //             $tc = imagecolorallocate($im, 0, 0, 0);
            //             imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
            //             imagestring($im, 4, 5, 5, "no pic", $tc);
            //             self::output($im);
            //             return;
        }
    }
    
    /**
     * 输出图片
     */
    public static function output($im, $type='png', $filename='') {
        header("Content-type: image/" . $type);
        $ImageFun = 'image' . $type;
        if (empty($filename)) {
            $ImageFun($im);
        } else {
            $ImageFun($im, $filename);
        }
        imagedestroy($im);
    }
}


// end