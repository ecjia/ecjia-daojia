<?php

namespace Ecjia\App\Wechat;

use Ecjia\App\Wechat\Models\WechatMediaModel;

class WechatMediaReply
{

    private $media_id;

    private $wechat_id;

    public function __construct($wechat_id, $media_id)
    {
        $this->media_id  = $media_id;
        $this->wechat_id = $wechat_id;
    }


    public function replyContent($message)
    {
        $data = WechatMediaModel::where('wechat_id', $this->wechat_id)->find($this->media_id);
        if (!empty($data)) {
            switch ($data->type) {
                case 'image':
                    return $this->Image_reply($data, $message);
                    break;

                case 'voice':
                    return $this->Voice_reply($data, $message);
                    break;

                case 'video':
                    return $this->Video_reply($data, $message);
                    break;

                case 'news':
                    return $this->News_reply($data, $message);
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * 图片素材回复
     * @param WechatMediaModel $data
     */
    protected function Image_reply(WechatMediaModel $data, $message)
    {
        $content = WechatRecord::Image_reply($message, $data->thumb);
        return $content;
    }

    /**
     * 音频素材回复
     * @param WechatMediaModel $data
     */
    protected function Voice_reply(WechatMediaModel $data, $message)
    {
        $content = WechatRecord::Voice_reply($message, $data->media_id);
        return $content;
    }

    /**
     * 视频素材回复
     * @param WechatMediaModel $data
     */
    protected function Video_reply(WechatMediaModel $data, $message)
    {
        $content = WechatRecord::Video_reply($message, $data->media_id, $data->title, $data->digest);
        return $content;
    }

    /**
     * 图文素材回复
     * @param WechatMediaModel $data
     */
    protected function News_reply(WechatMediaModel $data, $message)
    {
        $news[] = WechatRecord::News_reply($message, $data->title, $data->digest, $data->media_url, $data->thumb_url);

        if (!$data->subNews->isEmpty()) {
            $data->subNews->each(function ($item) use (& $news, $message) {
                $news[] = WechatRecord::createNewsReply($message, $item->title, $item->digest, $item->media_url, $item->thumb_url);
                return true;
            });

        }

        $content = WechatRecord::MultiNews_reply($message, $news);
        return $content;
    }


}