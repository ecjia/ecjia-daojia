<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/29
 * Time: 16:05
 */

namespace Ecjia\System\Admins\FileHash;

use Royalcms\Component\DirectoryHasher\DirectoryHasher;
use Royalcms\Component\DirectoryHasher\Result;
use Royalcms\Component\DirectoryHasher\Comparator;
use Royalcms\Component\DirectoryHasher\Comparator\Result as ComparatorResult;
use Royalcms\Component\DirectoryHasher\Source\Directory;
use Royalcms\Component\DirectoryHasher\Hasher\MD5;
use Royalcms\Component\DirectoryHasher\Hasher\Multi;
use Royalcms\Component\DirectoryHasher\Hasher\FileData;
use Royalcms\Component\DirectoryHasher\Result\Factory\Xml;
use RC_File;
use SplFileInfo;

class FileCheck
{
    /**
     * 检查的目录
     * @var string
     */
    protected $dir;

    /**
     * 生成结果存储目录
     * @var string
     */
    protected $storage_dir;

    /**
     * 生成文件名
     * @var string
     */
    protected $filename;

    public function __construct($dir)
    {
        $dir = trim($dir, '/\\');

        $this->dir = base_path($dir);
        $this->storage_dir = storage_path('temp/filehash');

        if (! RC_File::isDirectory($this->storage_dir)) {
            RC_File::makeDirectory($this->storage_dir, 0755, true, true);
        }

        $this->filename = str_replace(['/', '\\'], '_', $dir) . '.xml';

    }

    /**
     * 读取xml文件
     * @return Result
     */
    public function readXmlFileHash()
    {
        $filepath = $this->storage_dir . '/' . $this->filename;
        if (RC_File::exists($filepath)) {
            $xml = new Xml();
            $xml->setFileNameAttrCallback(function($filenameAttr) {
                $filenameAttr->value = base_path() . str_replace('/', DIRECTORY_SEPARATOR, $filenameAttr->value);
            });
            $result = $xml->buildResultFromFile($filepath);
        } else {
            $result = null;
        }

        return $result;
    }

    public function readHashFileStatus()
    {
        $filepath = $this->storage_dir . '/' . $this->filename;

        if (RC_File::exists($filepath)) {
            return new SplFileInfo($filepath);
        }

        return null;
    }

    /**
     * 读取xml字符串
     * @param $string
     * @return Result
     */
    public function readXmlStringHash($string)
    {
        if (empty($string)) {
            return new Result();
        }

        $xml = new Xml();
        $xml->setFileNameAttrCallback(function($filenameAttr) {
            $filenameAttr->value = base_path() . str_replace('/', DIRECTORY_SEPARATOR, $filenameAttr->value);
        });
        $result = $xml->buildResultFromString($string);

        return $result;
    }

    /**
     * 生成
     */
    public function builder()
    {
        $source = new Directory($this->dir);
        $source->addIgnoredFile('.DS_Store');
        $source->addIgnoredFile('.svn');
        $source->addIgnoredFile('.git');

        $hasher = new MD5();
        $result = new Result();
        
        $directoryHasher = new DirectoryHasher($source, $hasher, $result);
        $result = $directoryHasher->run();

        return $result;
    }


    public function writeFile($result)
    {
        $writer = new WriteXml();
        $writer->write($result, $this->storage_dir . '/' . $this->filename);
    }


    public function compareHash(Result $old, Result $new, $force = false)
    {
        $cache_key = 'filehash_'.$this->dir;
        $result = ecjia_cache('system')->get($cache_key);

        if (empty($result) || $force) {
            $comparator = new Comparator();
            $result = $comparator->compare($old, $new);
            ecjia_cache('system')->put($cache_key, $result, 60);
        }

        return $result;
    }

}