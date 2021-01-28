<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/30
 * Time: 15:37
 */

namespace Royalcms\Component\Upload;


class UploadResult
{

    protected $name;

    protected $type;

    protected $size;

    protected $extension;

    protected $save_name;

    protected $save_path;

    protected $tmp_name;

    protected $file_name;

    protected $hash_md5;

    protected $hash_sha1;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return UploadResult
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return UploadResult
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param mixed $name
     * @return UploadResult
     */
    public function setName($name)
    {
        $this->name = strip_tags($name);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     * @return UploadResult
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaveName()
    {
        return $this->save_name;
    }

    /**
     * @param mixed $save_name
     * @return UploadResult
     */
    public function setSaveName($save_name)
    {
        $this->save_name = $save_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaveNameWithOutExtension()
    {
        return str_replace('.'.$this->extension, '', $this->save_name);
    }

    /**
     * @return mixed
     */
    public function getSavePath()
    {
        return $this->save_path;
    }

    /**
     * @param mixed $save_path
     * @return UploadResult
     */
    public function setSavePath($save_path)
    {
        $this->save_path = $save_path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->tmp_name;
    }

    /**
     * @param mixed $tmp_name
     * @return UploadResult
     */
    public function setTmpName($tmp_name)
    {
        $this->tmp_name = $tmp_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        if (is_null($this->file_name)) {
            $this->file_name = $this->save_path . $this->save_name;
        }

        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     * @return UploadResult
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHashMd5()
    {
        return $this->hash_md5;
    }

    /**
     * @param mixed $hash_md5
     * @return UploadResult
     */
    public function setHashMd5($hash_md5)
    {
        $this->hash_md5 = $hash_md5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHashSha1()
    {
        return $this->hash_sha1;
    }

    /**
     * @param mixed $hash_sha1
     * @return UploadResult
     */
    public function setHashSha1($hash_sha1)
    {
        $this->hash_sha1 = $hash_sha1;
        return $this;
    }

    /**
     * 返回对老数据兼容的数组
     * @return array
     */
    public function toCompatibleArray()
    {
        $result = [
            'name'     => $this->getName(),
            'ext'      => $this->getExtension(),
            'type'     => $this->getType(),
            'size'     => $this->getSize(),
            'savename' => $this->getSaveName(),
            'savepath' => $this->getSavePath(),
            'tmpname'  => $this->getTmpName(),
            'filename' => $this->getFileName(),
            'md5'      => $this->getHashMd5(),
            'sha1'     => $this->getHashSha1()
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

    /**
     * 返回新的标准命名数组
     * @return array
     */
    public function toArray()
    {
        $result = [
            'name'      => $this->getName(),
            'extension' => $this->getExtension(),
            'type'      => $this->getType(),
            'size'      => $this->getSize(),
            'save_name' => $this->getSaveName(),
            'save_path' => $this->getSavePath(),
            'tmp_name'  => $this->getTmpName(),
            'file_name' => $this->getFileName(),
            'hash_md5'  => $this->getHashMd5(),
            'hash_sha1' => $this->getHashSha1()
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}