<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-21
 * Time: 13:34
 */

namespace Ecjia\App\Store\StoreDuplicate;

use RC_Storage;
use RC_File;
use RC_Upload;

class StoreCopyImage
{

    protected $store_id;

    protected $source_store_id;

    /**
     * StoreCopyImage constructor.
     * @param int $store_id 新店铺ID
     * @param int $source_store_id 源店铺ID
     */
    public function __construct($store_id, $source_store_id)
    {
        $this->store_id = $store_id;
        $this->source_store_id = $source_store_id;
    }

    /**
     * 复制商家基本信息中的图片
     * @param $path
     * @return bool
     */
    public function copyMerchantConfigImage($path)
    {
        $disk = RC_Storage::disk();

        $newpath = str_replace("merchant/{$this->source_store_id}/data/", "merchant/{$this->store_id}/data/", $path);

        $newpath = dirname($newpath);
        $filename = basename($path);
        $extname = RC_File::extension($filename);

        $new_filename = RC_Upload::random_filename() . ".{$extname}";

        $newpath = $newpath . '/' . $new_filename;

        return $disk->copy($path, $newpath);
    }



}