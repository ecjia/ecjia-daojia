<?php

namespace Royalcms\Component\Aliyun;

use Royalcms\Component\Aliyun\OSS\OSSClient;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\MimeType;

class AliyunOSS {

  protected $ossClient;
  protected $bucket;

  public function __construct($serverName, $AccessKeyId, $AccessKeySecret)
  {
    $this->ossClient = OSSClient::factory(array(
      OSSOptions::ENDPOINT => $serverName,
      'AccessKeyId' => $AccessKeyId,
      'AccessKeySecret' => $AccessKeySecret
    ));
  }

  public static function boot($serverName, $AccessKeyId, $AccessKeySecret)
  {
    return new AliyunOSS($serverName, $AccessKeyId, $AccessKeySecret);
  }
  
  protected function getFileMimeContentType($filename)
  {
      $paths = pathinfo($filename);
      $mimes = MimeType::getExtensionToMimeTypeMap();
      return array_get($mimes, $paths['extension']);
  }

  public function setBucket($bucket)
  {
    $this->bucket = $bucket;
    return $this;
  }

  public function uploadFile($key, $file)
  {
    $handle = fopen($file, 'r');
    $value = $this->ossClient->putObject(array(
        'Bucket' => $this->bucket,
        'Key' => $key,
        'Content' => $handle,
        'ContentLength' => filesize($file),
        'ContentType' => $this->getFileMimeContentType($key),
    ));
    fclose($handle);
    return $value;
  }

  public function uploadContent($key, $content)
  {
    return $this->ossClient->putObject(array(
        'Bucket' => $this->bucket,
        'Key' => $key,
        'Content' => $content,
        'ContentLength' => strlen($content),
        'ContentType' => $this->getFileMimeContentType($key),
    ));
  }

  public function getUrl($key, $expire_time)
  {
    return $this->ossClient->generatePresignedUrl(array(
      'Bucket' => $this->bucket,
      'Key' => $key,
      'Expires' => $expire_time
    ));
  }
  
  /**
   * 获取阿里云中存储的文件
   *
   * @param string $bucketName 存储容器名称
   * @param string $key 存储key（文件的路径和文件名）
   * @return void
   */
  public function getObject($key)
  {
      return $this->ossClient->getObject(array(
          'Bucket'    => $this->bucket,
          'Key'       => $key
      ));
  }
  
  /**
   * 获取阿里云中存储的文件元数据，不包含文件内容
   *
   * @param string $bucketName 存储容器名称
   * @param string $key 存储key（文件的路径和文件名）
   * @return void
   */
  public function getObjectMetadata($key)
  {
      return $this->ossClient->getObjectMetadata(array(
          'Bucket'    => $this->bucket,
          'Key'       => $key
      ));
  }
  
  /**
   * 删除阿里云中存储的文件
   *
   * @param string $bucketName 存储容器名称
   * @param string $key 存储key（文件的路径和文件名）
   * @return void
   */
  public function deleteObject($key)
  {
      return $this->ossClient->deleteObject(array(
          'Bucket'    => $this->bucket,
          'Key'       => $key
      ));
  }
  
  /**
   * 批量删除阿里云中存储的文件
   * 
   * @param arrary $keys 存储keys（文件的路径和文件名）
   * @param bool $quiet 请求默认是详细(verbose)模式
   * @return void
   */
  public function deleteMultipleObjects($keys, $quiet = false)
  {
      return $this->ossClient->deleteMultipleObjects(array(
          'Bucket'    => $this->bucket,
          'Keys'      => $keys,
          'Quiet'     => $quiet
      ));
  }
  
  /**
   * 列出指定Bucket下的Object
   *
   * @param $prefix 限定返回的Object key必须以prefix作为前缀。
   * @param $marker 用户设定结果从marker之后按字母排序的第一个开始返回。
   * @param $maxKeys 用于限定此次返回object的最大数，如果不设定，默认为100。
   * @param $delimiter 用于对Object名字进行分组的字符。
   *
   * @return Models\ObjectListing
   */
  public function listObjects($prefix, $marker = null, $maxKeys = null, $delimiter = null) {
      return $this->ossClient->listObjects(array(
          'Bucket'    => $this->bucket,
          'Prefix'    => $prefix,
          'Marker'    => $marker,
          'MaxKeys'   => $maxKeys,
          'Delimiter' => $delimiter,
      ));
  }

  public function createBucket($bucketName)
  {
    return $this->ossClient->createBucket(array('Bucket' => $bucketName));
  }

  public function getAllObjectKey($bucketName)
  {
    $objectListing = $this->ossClient->listObjects(array(
      'Bucket' => $bucketName,
    ));

    $objectKeys = array();
    foreach ($objectListing->getObjectSummarys() as $objectSummary) {
      $objectKeys[] = $objectSummary->getKey();
    }
    return $objectKeys;
  }

  /**
   * 获取指定文件夹下的所有文件
   *
   * @param string $bucketName 存储容器名称
   * @param string $folder_name 文件夹名
   * @return 指定文件夹下的所有文件
   */
  public function getAllObjectKeyWithPrefix($bucketName, $folder_name, $nextMarker='')
  {

    $objectKeys = array();

    while (true){
      $objectListing = $this->ossClient->listObjects(array(
        'Bucket' => $bucketName,
        'Prefix' => $folder_name,
        'MaxKeys' => 1000,
        'Marker' => $nextMarker,
      ));

      foreach ($objectListing->getObjectSummarys() as $objectSummary) {
        $objectKeys[] = $objectSummary->getKey();
      }

      $nextMarker = $objectListing->getNextMarker();
      if ($nextMarker === '' || is_null($nextMarker)) {
        break;
      }
    }
    return $objectKeys;
  }

  /**
   * 复制存储在阿里云OSS中的Object
   *
   * @param string $sourceBuckt 复制的源Bucket
   * @param string $sourceKey - 复制的的源Object的Key
   * @param string $destBucket - 复制的目的Bucket
   * @param string $destKey - 复制的目的Object的Key
   * @return Models\CopyObjectResult
   */
  public function copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
  {
      if ($sourceBuckt === null) {
          $sourceBuckt = $this->bucket;
      }
      if ($destBucket === null) {
          $destBucket = $this->bucket;
      }
      return $this->ossClient->copyObject(array(
          'SourceBucket'  => $sourceBuckt,
          'SourceKey'     => $sourceKey,
          'DestBucket'    => $destBucket,
          'DestKey'       => $destKey
      ));
  }

  /**
   * 移动存储在阿里云OSS中的Object
   *
   * @param string $sourceBuckt 复制的源Bucket
   * @param string $sourceKey - 复制的的源Object的Key
   * @param string $destBucket - 复制的目的Bucket
   * @param string $destKey - 复制的目的Object的Key
   * @return Models\CopyObjectResult
   */
  public function moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
  {
      if ($sourceBuckt === null) {
          $sourceBuckt = $this->bucket;
      }
      if ($destBucket === null) {
          $destBucket = $this->bucket;
      }

      $result = $this->ossClient->copyObject(array(
          'SourceBucket'  => $sourceBuckt,
          'SourceKey'     => $sourceKey,
          'DestBucket'    => $destBucket,
          'DestKey'       => $destKey
      ));

      if (is_object($result) && $result->getETag()) {
          $this->deleteObject($sourceBuckt, $sourceKey);
      }
      
      return $result;
  }
  
  /**
   * 获取指定Bucket的访问权限
   *
   * @param string $bucketName 存储容器名称
   * @return void
   *
   * @return Models\AccessControlPolicy
   */
  public function getBucketAcl() {
      return $this->ossClient->getBucketAcl(array(
          'Bucket'    => $this->bucket
      ));
  }
  
  /**
   * 设置指定Bucket的访问权限
   *
   * @param string $bucketName 存储容器名称
   * @param string $acl ACL（Bucket的访问权限，可以为下面几个权限之一： private | public-read | public-read-write）
   * @return void
   *
   * @return Models\AccessControlPolicy
   */
  public function setBucketAcl($acl) {
      return $this->ossClient->setBucketAcl(array(
          'Bucket'    => $this->bucket,
          'ACL'       => $acl
      ));
  }
}
