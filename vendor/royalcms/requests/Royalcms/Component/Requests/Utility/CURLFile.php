<?php 

namespace Royalcms\Component\Requests\Utility;

/**
 * @file
 *
 * CURLFile
 * 兼容PHP5.4的上传文件类，来自于PHP5.5+
 */

class CURLFile {
    
    public $name;
    public $mime;
    public $postname;
    
    public function __construct ( $filename, $mimetype = 'application/octet-stream', $postname = 'name' ) {
        $this->name = $filename;
        $this->mime = $mimetype;
        $this->postname = $postname;   
    }
    
    /**
     * 获取被上传文件的 文件名
     * @return string
     */
    public function getFilename () {
        return $this->name;
    }
    
    /**
     * 获取被上传文件的 MIME 类型
     * @return string
     */
    public function getMimeType () {
        return $this->mime;
    }
    
    /**
     * 获取 POST 请求时使用的 文件名
     * @return string
     */
    public function getPostFilename () {
        return $this->postname;
    }
    
    /**
     * 设置被上传文件的 MIME 类型
     * @param string $mime
     */
    public function setMimeType ( $mime ) {
        $this->mime = $mime;
    }
    
    /**
     * 设置 POST 请求时使用的文件名
     * @param string $postname
     */
    public function setPostFilename ( $postname ) {
        $this->postname = $postname;
    }
    
    /**
     * 反序列化句柄
     */
    public function __wakeup () {
        
    }
    
    public function __toString() {
        if (class_exists('\CURLFile')) 
        {
            return new \CURLFile(realpath($this->name), $this->mime, $this->postname);
        } 
        else 
        {
            return sprintf("@%s;type=%s;filename=%s", realpath($this->name), $this->mime, $this->postname);
        }
    }

}
