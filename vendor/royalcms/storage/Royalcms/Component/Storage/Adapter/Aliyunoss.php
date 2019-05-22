<?php

namespace Royalcms\Component\Storage\Adapter;

use Royalcms\Component\Storage\Contracts\StorageInterface;
use Royalcms\Component\Storage\FilesystemBaseTrait;
use Royalcms\Component\Support\Format;
use Royalcms\Component\Error\Error;
use Royalcms\Component\Aliyun\OSS\Exceptions\OSSException;
use Royalcms\Component\Aliyun\AliyunOSS as OSS;
use League\Flysystem\Config;
use League\Flysystem\Adapter\AbstractAdapter;


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
class Aliyunoss extends AbstractAdapter implements StorageInterface
{

    use FilesystemBaseTrait;

    /**
     * The Access error of the current connection, Set automatically.
     *
     * @access public
     * @since 2.5.0
     * @var \RC_Error
     */
    protected $errors;

    protected $options = array();

    /**
     * @var \Royalcms\Component\Aliyun\AliyunOSS
     */
    private $aliyunClient;

    private $bucket;

    private $acl;

    /**
     * constructor
     *
     * @param mixed $arg
     *            ignored argument
     */
    public function __construct($arg)
    {
        $this->options = $arg;
        $this->method = 'aliyunoss';
        $this->errors = new Error();

        $this->bucket = $this->options['bucket'];
        $this->acl = $this->options['acl'] ? $this->options['acl'] : 'public-read';

        $this->connect();
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
        $this->aliyunClient = OSS::boot(
            $serverAddress,
            $this->options['key'],
            $this->options['secret']
        );
        $this->aliyunClient->setBucket($this->options['bucket']);

        return true;
    }

    /**
     * @return mixed
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param $path
     *
     * @return string|false
     */
    public function getUrl($path)
    {
        if ($path) {
            $path = '/' . ltrim($path, '\\/');
        }

        return $this->options['url'] . $path;
    }

    /**
     * @param $path
     *
     * @return array|false
     */
    private function getHeader($path)
    {
//        $path = $this->filterOsskey($path);

        try {
            $object = $this->aliyunClient->getObjectMetadata($path);
            $metadata = $object->getMetadata();
            return $metadata;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config)
    {
        try {
            $this->aliyunClient->uploadContent($path, $contents);
            return true;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Write a new file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function writeStream($path, $resource, Config $config)
    {
        $contents = stream_get_contents($resource);

        try {
            $this->aliyunClient->uploadContent($path, $contents);
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }

        if (is_resource($resource)) {
            fclose($resource);
        }

        return true;
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function update($path, $contents, Config $config)
    {
        try {
            $this->aliyunClient->uploadContent($path, $contents);
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Update a file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function updateStream($path, $resource, Config $config)
    {
        $contents = stream_get_contents($resource);

        try {
            $this->aliyunClient->uploadContent($path, $contents);
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function rename($path, $newPath)
    {
        try {
            $this->aliyunClient->copyObject($this->bucket, $path, $this->bucket, $newPath);

            $this->aliyunClient->deleteObject($path);

            return true;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function copy($path, $newPath)
    {
        //兼容老的delete方法，传入的是绝对路径，需要过滤为相对路径
        $path = $this->filterOsskey($path);
        $newPath = $this->filterOsskey($newPath);

        try {
            $this->aliyunClient->copyObject($this->bucket, $path, $this->bucket, $newPath);
            return true;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {
        //兼容老的delete方法，传入的是绝对路径，需要过滤为相对路径
        $path = $this->filterOsskey($path);

        try {
            $this->aliyunClient->deleteObject($path);
            return true;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {
        return false;
    }

    /**
     * Create a directory.
     *
     * @param string $dirName directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirName, Config $config)
    {
        return true;
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {
        return false;
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        $metadata = $this->getMetadata($path);
        if ($metadata) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {
        try {
            $res = $this->aliyunClient->getObject($path);

            return [
                'contents' => $res->getObjectContent(),
            ];
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {
        try {
            $res = $this->aliyunClient->getObject($path);
            $url = $res->getHeader('oss-request-url');
            $handle = fopen($url, 'r');

            return [
                'stream' => $handle,
            ];
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

//    /**
//     * parse the response body.
//     *
//     * @param $body
//     *
//     * @return array
//     */
//    private function getContents($body)
//    {
//        $xml = new \SimpleXMLElement($body);
//
//        $paths = [];
//        foreach ($xml->Contents as $content) {
//            $filePath = (string) $content->Key;
//
//            $type = (substr($filePath, -1) == '/') ? 'dir' : 'file';
//
//            if ($type == 'dir') {
//                $paths[] = [
//                    'type' => $type,
//                    'path' => $filePath,
//                ];
//            } else {
//                $paths[] = [
//                    'type'      => $type,
//                    'path'      => $filePath,
//                    'timestamp' => strtotime($content->LastModified),
//                    'size'      => (int) $content->Size,
//                ];
//            }
//        }
//        foreach ($xml->CommonPrefixes as $content) {
//            $paths[] = [
//                'type' => 'dir',
//                'path' => (string) $content->Prefix,
//            ];
//        }
//
//        return $paths;
//    }

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array|false
     */
    public function listContents($directory = '', $recursive = false)
    {
        if ($recursive) {
            $delimiter = '';
        } else {
            $delimiter = '/';
        }

        $prefix = $directory.'/';
        $next_marker = '';
        $maxkeys = 100;

        try {
            $object = $this->aliyunClient->listObjects($prefix, $next_marker, $maxkeys, $delimiter);
            $list = $object->getObjectSummarys();
            return $list;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {
        $response = $this->getHeader($path);

        return $response;
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {
        $response = $this->getHeader($path);

        return [
            'size' => $response['Content-Length'],
        ];
    }

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {
        $response = $this->getHeader($path);

        return [
            'mimetype' => $response['Content-Type'],
        ];
    }

    /**
     * Get the timestamp of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {
        $response = $this->getHeader($path);

        return [
            'timestamp' => $response['Last-Modified'],
        ];
    }

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path)
    {
        return [
            'visibility' => $this->acl,
        ];
    }
    
    
    protected function filterOsskey($file)
    {
        $file = str_replace(\RC_Upload::upload_path(), '', $file);
        $file = str_replace(DS, '/', $file);
        return $file;
    }

//    public function getMetadata($file)
//    {
//        $file = $this->filterOsskey($file);
//
//        try {
//            $object = $this->aliyunClient->getObjectMetadata($file);
//            $metadata = $object->getMetadata();
//            return $metadata;
//        } catch (OSSException $e) {
//            $this->errors->add($e->getCode(), $e->getMessage());
//            return false;
//        }
//    }


    /**
     * @return false|\Royalcms\Component\Aliyun\OSS\Models\AccessControlPolicy
     */
    public function getBucketAcl()
    {
        try {
            $objectacl = $this->aliyunClient->getBucketAcl();
            return $objectacl;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * @param $path
     * @return array|bool
     */
    protected function getListObjects($path)
    {
        try {
            $path = $this->filterOsskey($path);
            $object = $this->aliyunClient->listObjects($path);
            $list = $object->getObjectSummarys();
            return $list;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }


    /**
     * ===================================================================
     * StoreInterface
     * ===================================================================
     */


    /**
     * @param string $filename
     * @param string $destination
     *
     * @return bool|\Royalcms\Component\Aliyun\OSS\Models\PutObjectResult
     */
    public function move_uploaded_file($filename, $destination)
    {
    	try {
    		return $this->aliyunClient->uploadFile($this->filterOsskey($destination), $filename);
    	} catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        } 
    }

    /**
     * Reads entire file into a string
     *
     * @param string $file Name of the file to read.
     *
     * @return string bool function returns the read data or false on failure.
     */
    public function get_contents($file)
    {
        $file = $this->filterOsskey($file);
        
        try {
            return $this->aliyunClient->getObject($file)->getObjectContent();
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Reads entire file into an array
     *
     * @param string $file Path to the file.
     *
     * @return array|bool|\Royalcms\Component\Aliyun\OSS\Models\OSSObject bool file contents in an array or false on failure.
     */
    public function get_contents_array($file)
    {
        $file = $this->filterOsskey($file);
        
        try {
            $object = $this->aliyunClient->getObject($file);
            return $object;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Write a string to a file
     *
     * @param string $file Remote path to the file where to write the data.
     * @param string $contents The data to write.
     * @param int $mode (optional) The file permissions as octal number, usually 0644.
     *
     * @return bool|\Royalcms\Component\Aliyun\OSS\Models\PutObjectResult False upon failure.
     */
    public function put_contents($file, $contents, $mode = false)
    {
        $file = $this->filterOsskey($file);

    	try {
    		return $this->aliyunClient->uploadContent($file, $contents);
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
        return getcwd();
    }

    /**
     * Change directory
     *
     * @param string $dir The new current directory.
     * @return bool Returns true on success or false on failure.
     */
    public function chdir($dir)
    {
        return true;
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
     * @param string $file Path to the file.
     *
     * @return string bool of the user or false on error.
     */
    public function owner($file)
    {
        $objectacl = $this->getBucketAcl();
        
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
     * @param string $file Path to the file.
     *
     * @return string Mode of the file (last 3 digits).
     */
    protected function getchmod($file)
    {
        $objectacl = $this->getBucketAcl();

        if ($objectacl) {
            $grants = $objectacl->getGrants();

            if (in_array('public-read', $grants)) {
                return false;
            }
            return 755;
        } else {
            return false;
        }
    }

    /**
     * @param string $file
     *
     * @return bool|string
     */
    public function group($file)
    {
        $objectacl = $this->getBucketAcl();
        
        if ($objectacl) {
            $name = $objectacl->getOwner()->getDisplayName();
            return $name;
        } else {
            return false;
        }
    }

    /**
     * @param string $source
     * @param string $destination
     * @param bool $overwrite
     * @param bool $mode
     *
     * @return bool|\Royalcms\Component\Aliyun\OSS\Models\CopyObjectResult|\Royalcms\Component\Aliyun\OSS\Models\PutObjectResult
     */
    public function copy_file($source, $destination, $overwrite = false, $mode = false)
    {
        if (! $overwrite && $this->exists($destination))
            return false;
        
        $source = $this->filterOsskey($source);
        $destination = $this->filterOsskey($destination);

        try {
            if ($this->exists($source)) {
                $rtval = $this->aliyunClient->copyObject(null, $source, null, $destination);
            } else {
                $rtval = $this->aliyunClient->uploadFile($destination, $source);
            }
            return $rtval;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $source
     * @param string $destination
     * @param bool $overwrite
     * @param bool $mode
     *
     * @return bool|\Royalcms\Component\Aliyun\OSS\Models\CopyObjectResult|\Royalcms\Component\Aliyun\OSS\Models\PutObjectResult
     */
    public function move_file($source, $destination, $overwrite = false, $mode = false)
    {
        if (! $overwrite && $this->exists($destination))
            return false;
        
        $source = $this->filterOsskey($source);
        $destination = $this->filterOsskey($destination);
        
        try {
            if ($this->exists($source)) {
                $rtval = $this->aliyunClient->moveObject(null, $source, null, $destination);
            } else {
                $rtval = $this->aliyunClient->uploadFile($destination, $source);
            }
            return $rtval;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $file
     * @param bool $recursive
     * @param bool $type
     *
     * @return bool|mixed
     */
    public function delete_all($file, $recursive = false, $type = false)
    {
        if (empty($file)) // Some filesystems report this as /, which can cause non-expected recursive deletion of all files in the filesystem.
            return false;
        
        try {
            if ($this->exists($file)) {
                return $this->aliyunClient->deleteObject($this->filterOsskey($file));
            }
            return false;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * 判断文件是否存在
     *
     * @param string $path
     *
     * @return bool
     */
    public function exists($path)
    {
        //兼容老的delete方法，传入的是绝对路径，需要过滤为相对路径
        $path = $this->filterOsskey($path);

        return $this->has($path);
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    public function is_file($file)
    {
        //传入的是绝对路径，需要过滤为相对路径
        $file = $this->filterOsskey($file);

        $metadata = $this->getMetadata($file);
        if ($metadata) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否是目录
     * 默认OSS里为true
     *
     * @param string $path
     *
     * @return bool
     */
    public function is_dir($path)
    {
        return true;
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    public function is_readable($file)
    {
        return true;
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    public function is_writable($file)
    {
        $objectacl = $this->getBucketAcl();

        if ($objectacl) {
            $grants = $objectacl->getGrants();

            if (in_array('private', $grants)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $file
     *
     * @return bool|int
     */
    public function atime($file)
    {
        //传入的是绝对路径，需要过滤为相对路径
        $file = $this->filterOsskey($file);

        $metadata = $this->getMetadata($file);
        
        if ($metadata) {
            $datetime = $metadata['Last-Modified'];
            $timestamp = $datetime->getTimestamp();
            return $timestamp;
        } else {
            return false;
        }
    }

    /**
     * @param string $file
     *
     * @return bool|int
     */
    public function mtime($file)
    {
        //传入的是绝对路径，需要过滤为相对路径
        $file = $this->filterOsskey($file);

        $metadata = $this->getMetadata($file);
        
        if ($metadata) {
            $datetime = $metadata['Last-Modified'];
            $timestamp = $datetime->getTimestamp();
            return $timestamp;
        } else {
            return false;
        }
    }

    /**
     * @param string $file
     *
     * @return bool|int|mixed
     */
    public function size($file)
    {
        //传入的是绝对路径，需要过滤为相对路径
        $file = $this->filterOsskey($file);

        $metadata = $this->getMetadata($file);
        if ($metadata) {
            $filesize = $metadata['Content-Length'];
            return $filesize;
        } else {
            return false;
        }
    }

    /**
     * @param string $file
     * @param int $time
     * @param int $atime
     *
     * @return bool
     */
    public function touch($file, $time = 0, $atime = 0)
    {
        return true;
    }

    /**
     * @param string $path
     * @param bool $chmod
     * @param bool $chown
     * @param bool $chgrp
     *
     * @return bool
     */
    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false)
    {
        return true;
    }

    /**
     * @param string $path
     * @param bool $recursive
     *
     * @return bool
     */
    public function rmdir($path, $recursive = false)
    {
        if (empty($path)) // Some filesystems report this as /, which can cause non-expected recursive deletion of all files in the filesystem.
        {
            return false;
        }
        
        $path = $this->filterOsskey($path);
        
        // At this point it's a folder, and we're in recursive mode
        try {
            $path = Format::trailingslashit($path);
            $list = $this->getListObjects($path);
            $all_keys = array();
            foreach ($list as $object) {
                $all_keys[] = $object->getKey();
                //@todo 批量单个删除文件
                $this->delete_all($object->getKey());
            }
            //@TODO:批量删除多个文件的接口没有测试成功，待继续
            //$result = $this->link->deleteMultipleObjects($all_keys);
            return true;
        } catch (OSSException $e) {
            $this->errors->add($e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $path
     * @param bool $include_hidden
     * @param bool $recursive
     *
     * @return array|bool
     */
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

    /**
     * @param $ret
     * @param $object
     * @param $path
     * @param $entry
     * @param bool $recursive
     *
     * @return bool
     */
    protected function _dirlist(& $ret, $object, $path, $entry, $recursive = false)
    {
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

    /**
     * @param $object
     *
     * @return mixed
     */
    protected function _fileStruct($object)
    {
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

    /**
     * @param $haystack
     * @param $needle
     * @param int $start
     *
     * @return bool|string
     */
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
