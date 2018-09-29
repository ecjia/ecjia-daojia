<?php

namespace Ecjia\App\Weapp;

use Ecjia\App\Wechat\Models\WechatMediaModel;

class WeappMediaReply
{
    
    private $media_id;
    
    private $weapp_id;
    
    public function __construct($weapp_id, $media_id)
    {
        $this->media_id = $media_id;
        $this->weapp_id = $weapp_id;
    }
    
    
    public function replyContent($message)
    {
        $data = WechatMediaModel::where('wechat_id', $this->weapp_id)->find($this->media_id);
        if ( ! empty($data)) {
            switch ($data->type) {
                case 'image':
                    return $this->Image_reply($data, $message);
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
        $content = WeappRecord::Image_reply($message, $data->thumb);
        return $content;
    }
    
    /**
     * 图文素材回复
     * @param WechatMediaModel $data
     */
    protected function News_reply(WechatMediaModel $data, $message)
    {
        return null;
    }
    
    
}