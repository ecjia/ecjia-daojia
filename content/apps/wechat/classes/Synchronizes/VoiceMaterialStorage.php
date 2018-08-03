<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/19
 * Time: 4:07 PM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use Ecjia\App\Wechat\Models\WechatMediaModel;
use Royalcms\Component\Support\Facades\File as RC_File;

class VoiceMaterialStorage
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

        $this->save_dir = \RC_Upload::upload_path('data/material/wechat_voice');

        if (! RC_File::isDirectory($this->save_dir)) {
            RC_File::makeDirectory($this->save_dir, 0777, true, true);
        }
    }


    public function save()
    {
        $items = $this->data->get('item');

        $wechat_id = $this->wechat_id;

        collect($items)->map(function($item) use ($wechat_id) {

            $media_id = $item['media_id'];

            $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('media_id', $media_id)->where('type', 'voice')->first();
            if (!empty($model)) {
                //已存在，更新数据
                $this->updateImage($model, $item);

            } else {
                //不存在，添加数据
                $this->saveImage($item);
            }

        });

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
        //图片文件修改名字后，保存变化
        if ($model->file_name != $item['name']) {
            $data = [
                'file_name'             => $item['name'],
                'edit_time'             => $item['update_time'],
            ];
            $model->update($data);
        }
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
        $file_ext = RC_File::file_ext($item['name']) ? '.' . RC_File::file_ext($item['name']) : '.png';
        $filename = \RC_Upload::random_filename() . $file_ext;
        $file = str_replace(\RC_Upload::upload_path(), '', $this->save_dir . '/' . $filename);
        $this->wechat->material->download($item['media_id'], $this->save_dir, $filename);
  
        $data = [
            'file_name'             => $item['name'],
            'file'                  => $file,
            'media_id'              => $item['media_id'],

            'wechat_id'             => $this->wechat_id,
            'is_material'           => 'material',
            'type'                  => 'voice',
            'add_time'              => $item['update_time'],
            'edit_time'             => $item['update_time'],
        ];
        WechatMediaModel::create($data);
    }



}