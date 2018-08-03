<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/19
 * Time: 4:07 PM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use \Ecjia\App\Wechat\Models\WechatMediaModel;
use Royalcms\Component\Support\Facades\File as RC_File;

class NewsMaterialStorage
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

        $this->save_dir = \RC_Upload::upload_path('data/material/wechat_thumb');

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
            $create_time = array_get($item, 'content.create_time');
            $update_time = array_get($item, 'content.update_time');
            $news_item = array_get($item, 'content.news_item');

            $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('media_id', $media_id)->where('type', 'news')->where('parent_id', 0)->first();
            if (!empty($model)) {

                //已存在，更新数据
                if (count($news_item) > 1) {
                    $this->updateMultiNews($model, $news_item, $create_time, $update_time);
                } else {
                    $this->updateMainNews($model, $news_item[0], $create_time, $update_time);
                }

            } else {
                //不存在，添加数据
                if (count($news_item) > 1) {
                    $this->saveMultiNews($media_id, $news_item, $create_time, $update_time);
                } else {
                    $this->saveMainNews($media_id, $news_item[0], $create_time, $update_time);
                }
            }

        });

    }

    /**
     * 更新主图文素材
     * @param $model
     * @param $first_item
     * @param $create_time
     * @param $update_time
     */
    protected function updateMainNews($model, $first_item, $create_time, $update_time)
    {
        $data = [
            'title'                 => $first_item['title'],
            'author'                => $first_item['author'],
            'digest'                => $first_item['digest'],
            'content'               => $first_item['content'],
            'link'                  => $first_item['content_source_url'],
            'thumb'                 => $first_item['thumb_media_id'],
            'is_show'               => $first_item['show_cover_pic'],
            'media_url'             => $first_item['url'],
            'thumb_url'             => $first_item['thumb_url'],
            'need_open_comment'     => $first_item['need_open_comment'],
            'only_fans_can_comment' => $first_item['only_fans_can_comment'],

            'add_time'              => $create_time,
            'edit_time'             => $update_time,
        ];

        $this->processThumbDownload($data, $first_item, $create_time, $update_time, $model->thumb);

        $model->update($data);
    }

    /**
     * 更新多图文素材
     * @param $model
     * @param $news_item
     * @param $create_time
     * @param $update_time
     */
    protected function updateMultiNews($model, $news_item, $create_time, $update_time)
    {
        $this->updateMainNews($model, $news_item[0], $create_time, $update_time);

        unset($news_item[0]);

        //子图文素材对比，如果不一样，删除原有子图文，添加新的子图文
        $a = collect($news_item)->lists('title');
        $b = $model->subNews->lists('title');
        $result = array_diff($a, $b);

        //如果一样，只更新内容
        if (! empty($result)) {
            if (! $model->subNews->isEmpty()) {
                $model->subNews->each(function ($item) {
                    $item->delete();
                    return true;
                });
            }

            foreach ($news_item as $key => $news) {
                $data = [
                    'title'                 => $news['title'],
                    'author'                => $news['author'],
                    'digest'                => $news['digest'],
                    'content'               => $news['content'],
                    'link'                  => $news['content_source_url'],
                    'thumb'                 => $news['thumb_media_id'],
                    'is_show'               => $news['show_cover_pic'],
                    'media_url'             => $news['url'],
                    'thumb_url'             => $news['thumb_url'],
                    'need_open_comment'     => $news['need_open_comment'],
                    'only_fans_can_comment' => $news['only_fans_can_comment'],

                    'sort'                  => $key,
                    'wechat_id'             => $this->wechat_id,
                    'parent_id'             => $model->id,
                    'is_material'           => 'material',
                    'type'                  => 'news',
                    'add_time'              => $create_time,
                    'edit_time'             => $update_time,
                ];

                $this->processThumbDownload($data, $news, $create_time, $update_time);

                WechatMediaModel::create($data);
            }

        } else {

            foreach ($news_item as $key => $news) {
                //内容存在，且大于更新时间
                $model = WechatMediaModel::where('wechat_id', $this->wechat_id)->where('title', $news['title'])->where('type', 'news')->where('parent_id', $model->id)->first();
                if (!empty($model) && $model->edit_time > $update_time) {
                    $data = [
                        'title'                 => $news['title'],
                        'author'                => $news['author'],
                        'digest'                => $news['digest'],
                        'content'               => $news['content'],
                        'link'                  => $news['content_source_url'],
                        'thumb'                 => $news['thumb_media_id'],
                        'is_show'               => $news['show_cover_pic'],
                        'media_url'             => $news['url'],
                        'thumb_url'             => $news['thumb_url'],
                        'need_open_comment'     => $news['need_open_comment'],
                        'only_fans_can_comment' => $news['only_fans_can_comment'],

                        'sort'                  => $key,
                        'edit_time'             => $update_time,
                    ];

                    $this->processThumbDownload($data, $news, $create_time, $update_time, $model->thumb);

                    $model->update($data);
                }

            }

        }

    }

    /**
     * 保存主图文
     * @param $first_item
     */
    protected function saveMainNews($media_id, $first_item, $create_time, $update_time)
    {

        $data = [
            'title'                 => $first_item['title'],
            'author'                => $first_item['author'],
            'digest'                => $first_item['digest'],
            'content'               => $first_item['content'],
            'link'                  => $first_item['content_source_url'],
            'thumb'                 => $first_item['thumb_media_id'],
            'is_show'               => $first_item['show_cover_pic'],
            'media_url'             => $first_item['url'],
            'thumb_url'             => $first_item['thumb_url'],
            'need_open_comment'     => $first_item['need_open_comment'],
            'only_fans_can_comment' => $first_item['only_fans_can_comment'],

            'media_id'              => $media_id,
            'wechat_id'             => $this->wechat_id,
            'parent_id'             => 0,
            'is_material'           => 'material',
            'type'                  => 'news',
            'add_time'              => $create_time,
            'edit_time'             => $update_time,
        ];

        $this->processThumbDownload($data, $first_item, $create_time, $update_time);

        $parent_model = WechatMediaModel::create($data);

        return $parent_model;
    }


    /**
     * 保存多图文
     * @param $news_item
     * @param $create_time
     * @param $update_time
     */
    protected function saveMultiNews($media_id, $news_item, $create_time, $update_time)
    {
        $parent_model = $this->saveMainNews($media_id, $news_item[0], $create_time, $update_time);

        unset($news_item[0]);

        foreach ($news_item as $key => $news) {

            $data = [
                'title'                 => $news['title'],
                'author'                => $news['author'],
                'digest'                => $news['digest'],
                'content'               => $news['content'],
                'link'                  => $news['content_source_url'],
                'thumb'                 => $news['thumb_media_id'],
                'is_show'               => $news['show_cover_pic'],
                'media_url'             => $news['url'],
                'thumb_url'             => $news['thumb_url'],
                'need_open_comment'     => $news['need_open_comment'],
                'only_fans_can_comment' => $news['only_fans_can_comment'],

                'sort'                  => $key,
                'wechat_id'             => $this->wechat_id,
                'parent_id'             => $parent_model->id,
                'is_material'           => 'material',
                'type'                  => 'news',
                'add_time'              => $create_time,
                'edit_time'             => $update_time,
            ];

            $this->processThumbDownload($data, $news, $create_time, $update_time);

            WechatMediaModel::create($data);
        }
    }


    /**
     * 处理图文素材的缩略图下载
     * @param $model
     * @param $item
     * @param $create_time
     * @param $update_time
     * @param $data
     */
    protected function processThumbDownload(& $data, $item, $create_time, $update_time, $thumb = null)
    {
        try {
            //$thumb = null时，是新缩略图
            //如果缩略图的素材ID有变动，就更新
            if (is_null($thumb) || $thumb != $item['thumb_media_id']) {
                $item['create_time'] = $create_time;
                $item['update_time'] = $update_time;

                $thumb_model = with(new ThumbMaterialStorage($this->wechat_id, 'thumb', $item, $this->wechat))->save();

                $data['file'] = $thumb_model->file;
                $data['file_name'] = $thumb_model->file_name;
            }

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            //如果缩略图下载出错，就跳过

        } catch (\Royalcms\Component\Database\QueryException $e) {
            //查询错误，忽略
        }

    }

}