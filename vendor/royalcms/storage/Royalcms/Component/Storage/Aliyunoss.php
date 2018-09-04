<?php

namespace Royalcms\Component\Storage;

use Royalcms\Component\Support\Format;
use Royalcms\Component\Error\Error;
use Royalcms\Component\Upload\Upload;
use Royalcms\Component\Aliyun\OSS\Exceptions\OSSException;
use Royalcms\Component\Aliyun\AliyunOSS as OSS;


/**
 * Royalcms Direct Filesystem.
 *
 * @package Royalcms
 * @subpackage Filesystem
 */

/**
 * Royalcms Filesystem Class for direct PHP file and folder manipulation.
 *
 * @since 2.5.0
 * @package Royalcms
 * @subpackage Filesystem
 * @uses \Royalcms\Component\Storage\FilesystemBase Extends class
 */
class Aliyunoss extends FilesystemBase
{

    protected $options = array();
    
    protected $link = false;
    
    /**
     * constructor
     *
     * @param mixed $arg
     *            ignored argument
     */
    public function __construct($arg)
    {
        $this->method = 'aliyunoss';
        $this->options = $arg;
        $this->errors = new Error();
    }
    
    
    protected function filterOsskey($file) {
        $file = str_replace(Upload::upload_path(), '', $file);
        $file = str_replace(DS, '/', $file);
        return $file;
    }
    
    protected function getMetadata($file) {
        $file = $this->filterOsskey($file);
        
        try {
            $object = $this->link->getObjectMetadata($file);
            $metadata = $object->getMetadata();
            return $metadata;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        } 
    }
    
    protected function getBucketAcl($file) {
        $file = $this->filterOsskey($file);
        
        try {
            $objectacl = $this->link->getBucketAcl($file);
            return $objectacl;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }
    
    protected function getListObjects($path) {
        try {
            $path = $this->filterOsskey($path);
            $object = $this->link->listObjects($path);
            $list = $object->getObjectSummarys();
            return $list;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }
    
    
    /**
     * Connect filesystem.
     *
     * @since 2.5.0
     *
     * @return bool True on success or false on failure (always true for WP_Filesystem_Direct).
     */
    public function connect()
    {
        $serverAddress = $this->options['is_internal'] ? $this->options['server_internal'] : $this->options['server'];
        $this->link = OSS::boot(
            $serverAddress,
            $this->options['key'],
            $this->options['secret']
        );
        $this->link->setBucket($this->options['bucket']);
        return true;
    }
    
    public function move_uploaded_file($filename, $destination) {
    	try {
    		return $this->link->uploadFile($this->filterOsskey($destination), $filename);
    	} catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        } 
    }

    /**
     * Reads entire file into a string
     *
     * @param string $file
     *            Name of the file to read.
     * @return string bool function returns the read data or false on failure.
     */
    public function get_contents($file)
    {
        $file = $this->filterOsskey($file);
        
        try {
            return $this->link->getObject($file)->getObjectContent();
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Reads entire file into an array
     *
     * @param string $file
     *            Path to the file.
     * @return array bool file contents in an array or false on failure.
     */
    public function get_contents_array($file)
    {
        $file = $this->filterOsskey($file);
        
        try {
            $object = $this->link->getObject($file);
            return $object;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Write a string to a file
     *
     * @param string $file
     *            Remote path to the file where to write the data.
     * @param string $contents
     *            The data to write.
     * @param int $mode
     *            (optional) The file permissions as octal number, usually 0644.
     * @return bool False upon failure.
     */
    public function put_contents($file, $contents, $mode = false)
    {
    	try {
    		return $this->link->uploadContent($this->filterOsskey($file), $contents);
    	} catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        } 
    }

    /**
     * Gets the current working directory
     *
     * @return string bool current working directory on success, or false on failure.
     */
    public function cwd()
    {
        return @getcwd();
    }

    /**
     * Change directory
     *
     * @param string $dir
     *            The new current directory.
     * @return bool Returns true on success or false on failure.
     */
    public function chdir($dir)
    {
        return @chdir($dir);
    }

    /**
     * Changes file group
     *
     * @param string $file
     *            Path to the file.
     * @param mixed $group
     *            A group name or number.
     * @param bool $recursive
     *            (optional) If set True changes file group recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chgrp($file, $group, $recursive = false)
    {
        return true;
    }

    /**
     * Changes filesystem permissions
     *
     * @param string $file
     *            Path to the file.
     * @param int $mode
     *            (optional) The permissions as octal number, usually 0644 for files, 0755 for dirs.
     * @param bool $recursive
     *            (optional) If set True changes file group recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chmod($file, $mode = false, $recursive = false)
    {
        return true;
    }

    /**
     * Changes file owner
     *
     * @param string $file
     *            Path to the file.
     * @param mixed $owner
     *            A user name or number.
     * @param bool $recursive
     *            (optional) If set True changes file owner recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chown($file, $owner, $recursive = false)
    {
        return true;
    }

    /**
     * Gets file owner
     *
     * @param string $file
     *            Path to the file.
     * @return string bool of the user or false on error.
     */
    public function owner($file)
    {
        $objectacl = $this->getBucketAcl($file);
        
        if ($objectacl) {
            $name = $objectacl->getOwner()->getDisplayName();
            return $name;
        } else {
            return false;
        }
    }

    /**
     * Gets file permissions
     *
     * @param string $file
     *            Path to the file.
     * @return string Mode of the file (last 3 digits).
     */
    protected function getchmod($file)
    {
        $objectacl = $this->getBucketAcl($file);

        if ($objectacl) {
            $grants = $objectacl->getGrants();
            return $grants[0];
        } else {
            return false;
        }
    }

    public function group($file)
    {
        $objectacl = $this->getBucketAcl($file);
        
        if ($objectacl) {
            $name = $objectacl->getOwner()->getDisplayName();
            return $name;
        } else {
            return false;
        }
    }

    public function copy($source, $destination, $overwrite = false, $mode = false)
    {
        if (! $overwrite && $this->exists($destination))
            return false;
        
        $source = $this->filterOsskey($source);
        $destination = $this->filterOsskey($destination);

        try {
            if ($this->exists($source)) {
                $rtval = $this->link->copyObject(null, $source, null, $destination);
            } else {
                $rtval = $this->link->uploadFile($destination, $source);
            }
            return $rtval;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    public function move($source, $destination, $overwrite = false, $mode = false)
    {
        if (! $overwrite && $this->exists($destination))
            return false;
        
        $source = $this->filterOsskey($source);
        $destination = $this->filterOsskey($destination);
        
        try {
            if ($this->exists($source)) {
                $rtval = $this->link->moveObject(null, $source, null, $destination);
            } else {
                $rtval = $this->link->uploadFile($destination, $source);
            }
            return $rtval;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    public function delete($file, $recursive = false, $type = false)
    {
        if (empty($file)) // Some filesystems report this as /, which can cause non-expected recursive deletion of all files in the filesystem.
            return false;
        
        try {
            if ($this->exists($file)) {
                return $this->link->deleteObject($this->filterOsskey($file));
            }
            return false;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    public function exists($file)
    {
        $metadata = $this->getMetadata($file);
        if ($metadata) {
            return true;
        } else {
            return false;
        }
    }

    public function is_file($file)
    {
        $metadata = $this->getMetadata($file);
        if ($metadata) {
            return true;
        } else {
            return false;
        }
    }

    public function is_dir($path)
    {
        //获取在同一个路径下有多少个文件列表
        $list = $this->getListObjects($path);
        if (!empty($list) && count($list) > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function is_readable($file)
    {
        return true;
    }

    public function is_writable($file)
    {
        return true;
    }

    public function atime($file)
    {
        $metadata = $this->getMetadata($file);
        
        if ($metadata) {
            $datetime = $metadata['Last-Modified'];
            $timestamp = $datetime->getTimestamp();
            return $timestamp;
        } else {
            return false;
        }
    }

    public function mtime($file)
    {
        $metadata = $this->getMetadata($file);
        
        if ($metadata) {
            $datetime = $metadata['Last-Modified'];
            $timestamp = $datetime->getTimestamp();
            return $timestamp;
        } else {
            return false;
        }
    }

    public function size($file)
    {
        $metadata = $this->getMetadata($file);
        if ($metadata) {
            $filesize = $metadata['Content-Length'];
            return $filesize;
        } else {
            return false;
        }
    }

    public function touch($file, $time = 0, $atime = 0)
    {
        return true;
    }

    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false)
    {
        // safe mode fails with a trailing slash under certain PHP versions.
        $path = Format::untrailingslashit($path);
        if (empty($path))
            return false;

        return true;
    }

    public function rmdir($path, $recursive = false)
    {
        if (empty($path)) // Some filesystems report this as /, which can cause non-expected recursive deletion of all files in the filesystem.
            return false;
        
        $path = $this->filterOsskey($path);
        
        // At this point it's a folder, and we're in recursive mode
        try {
            $path = Format::trailingslashit($path);
            $list = $this->getListObjects($path);
            $all_keys = array();
            foreach ($list as $object) {
                $all_keys[] = $object->getKey();
                //@todo 批量单个删除文件
                $this->delete($object->getKey());
            }
            //@TODO:批量删除多个文件的接口没有测试成功，待继续
            //$result = $this->link->deleteMultipleObjects($all_keys);
            return true;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    public function dirlist($path, $include_hidden = true, $recursive = false)
    {
        $list = $this->getListObjects($path);
        if ($list) {
            $ret = array();
            foreach ($list as $object) {
                $this->_dirlist($ret, $object, $path, $object->getKey(), $recursive);
            }
            return $ret;
        } else {
            return false;
        }
    }
    
    protected function _dirlist(& $ret, $object, $path, $entry, $recursive = false) {
        if (rtrim($path) . '/' == $entry) {
            return false;
        }
        
        if (strpos($entry, '/') !== false) {
            $path = rtrim($path, '/');
            $entry = str_replace($path . '/', '', $entry);
            $dir = $this->rstrstr($entry, '/');
            $path_f = str_replace($dir . '/', '', $entry);
            
            $struc['name']          = $dir;
            $struc['perms']         = false;
            $struc['permsn']        = false;
            $struc['number']        = false;
            $struc['owner']         = $object->getOwner()->getDisplayName();
            $struc['group']         = $object->getOwner()->getDisplayName();
            $struc['size']          = $object->getSize();
            $struc['lastmodunix']   = $object->getLastModified()->getTimestamp();
            $struc['lastmod']       = date('M j', $struc['lastmodunix']);
            $struc['time']          = date('h:i:s', $struc['lastmodunix']);
            $struc['type']          = 'd';

            if (strpos($path_f, '/') !== false) {
                if ($recursive) {
                    $sub_dir = $this->rstrstr($path_f, '/');
                    $struc_sub = $this->_dirlist($ret[$dir], $object, $path . '/' . $dir, $path_f);
                    if (! isset($struc['files'][$sub_dir])) {
                        $struc['files'][$sub_dir] = $struc_sub;
                    }
                } else {
                    $struc['files'] = array();
                }
            } 
            else {
                $struc_sub = $this->_fileStruct($object);
                if (! isset($ret[$dir])) {
                    $ret[$dir] = $struc;
                }

                if (! isset($ret[$dir]['files'][$path_f])) {
                    $ret[$dir]['files'][$path_f] = $struc_sub;
                }
            }
        } 
        else {
            $struc = $this->_fileStruct($object);
        }
        
        if (! isset($ret[$struc['name']])) {
            $ret[$struc['name']] = $struc;
        }
    }
    
    protected function _fileStruct($object) {
        $struc['name']          = basename($object->getKey());
        $struc['perms']         = false;
        $struc['permsn']        = false;
        $struc['number']        = false;
        $struc['owner']         = $object->getOwner()->getDisplayName();
        $struc['group']         = $object->getOwner()->getDisplayName();
        $struc['size']          = $object->getSize();
        $struc['lastmodunix']   = $object->getLastModified()->getTimestamp();
        $struc['lastmod']       = date('M j', $struc['lastmodunix']);
        $struc['time']          = date('h:i:s', $struc['lastmodunix']);
        $struc['type']          = 'f';
        return $struc;
    }
    
    protected function rstrstr($haystack,$needle, $start = 0)
    {
        return substr($haystack, $start,strpos($haystack, $needle));
    }
    
    /**
     * 获取目录下的指定类型的文件列表
     * @param $path
     * @param array $files
     * @return array
     */
    public function filelist($path, $allowFiles, $start, $size)
    {
        $end = $start + $size;

        $files = $this->getListObjects($path);
        if (!count($files)) {
            return array();
        }
        
        /* 获取指定范围的列表 */
        $list = array();
        $len = count($files);
        for ($i = min($end, $len) - 1; $i < $len && $i >= 0 && $i >= $start; $i--) {
            if (preg_match('/\.(' . $allowFiles . ')$/i', $files[$i]->getKey())) {
                $list[] = array(
                    'url' => \RC_Upload::upload_url().'/'.$files[$i]->getKey(),
                    'mtime' => $files[$i]->getLastModified()->getTimestamp(),
                );
            }
        }
        
        return $list;
    }
    
}
