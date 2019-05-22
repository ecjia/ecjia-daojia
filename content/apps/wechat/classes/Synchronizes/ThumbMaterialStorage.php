<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/19
 * Time: 4:07 PM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use Ecjia\App\Wechat\Models\WechatMediaModel;
use RC_File;

class ThumbMaterialStorage
{
    protected $wechat_id;

    protected $type;

    protected $data;

    protected $wechat;

    protected $save_dir;

    public function __construct($wechat_id, $type, $data, $wechat)
    {
        $this->wechat_id = $wechat_id;
        $this->type = $type;
        $this->data = $data;
        $this->wechat = $wechat;

        $this->save_dir = \RC_Upload::local_upload_path('data/material/wechat_thumb');
        $disk = \RC_Storage::disk('local');
        if (! $disk->is_dir($this->save_dir)) {
            $disk->mkdir($this->save_dir, 0777, true, true);
        }
    }


    public function save()
    {
        $wechat_id = $this->wechat_id;

        $media_id = $this->data['media_id'];

        $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('media_id', $media_id)->where('type', 'thumb')->first();
        if (!empty($model)) {
            //已存在，更新数据
            return $this->updateImage($model, $this->data);

        } else {
            //不存在，添加数据
            return $this->saveImage($this->data);
        }
    }

    /**
     * 更新图片素材
     * @param $model
     * @param $first_item
     * @param $create_time
     * @param $update_time
     */
    protected function updateImage($model, $item)
    {
        //缩略图原数据不更新
        return $model;
    }

    /**
     * 保存图片素材
     * @param $model
     * @param $news_item
     * @param $create_time
     * @param $update_time
     */
    protected function saveImage($item)
    {
        $file_ext = '.jpg';
        $filename = \RC_Upload::random_filename() . $file_ext;
        $file = str_replace(\RC_Upload::local_upload_path(), '', $this->save_dir . '/' . $filename);
        $this->wechat->material->download($item['thumb_media_id'], $this->save_dir, $filename);

        $data = [
            'file_name'             => $item['name'],
            'file'                  => $file,
            'media_id'              => $item['thumb_media_id'],
            'media_url'             => $item['thumb_url'],

            'wechat_id'             => $this->wechat_id,
            'is_material'           => 'material',
            'type'                  => 'thumb',
            'add_time'              => $item['create_time'],
            'edit_time'             => $item['update_time'],
        ];
        $model = WechatMediaModel::create($data);

        return $model;
    }

}