<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/24
 * Time: 5:07 PM
 */

namespace Ecjia\App\Wechat\Sends;

use Ecjia\App\Wechat\Models\WechatMassHistoryModel;
use Ecjia\App\Wechat\Models\WechatMediaModel;

class BroadcastSendMessage
{

    protected $wechat_id;

    protected $wechat;


    public function __construct($wechat, $wechat_id)
    {
        $this->wechat_id = $wechat_id;
        $this->wechat = $wechat;
    }

    /**
     * 发送文本消息
     */
    public function sendTextMessage($msg, $tagid = null)
    {
        $content = ['content' => $msg];
        if (! empty($tagid)) {
            $content['tag_id'] = $tagid;
        }

        $result = $this->wechat->broadcast->sendText($msg, $tagid);

        WechatMassHistoryModel::massSendRecord($this->wechat_id, 0, 'text', $content, $result);

        $content['type'] = 'text';
        return $content;
    }

    /**
     * 发送素材消息
     * @param $id
     */
    public function sendMediaMessage($id, $tagid = null)
    {
        $model = WechatMediaModel::where('wechat_id', $this->wechat_id)->find($id);
        if ( ! empty($model)) {
            switch ($model->type) {
                case 'image':
                    return $this->sendImageMessage($model->media_id, $tagid, $model);
                    break;

                case 'voice':
                    return $this->sendVoiceMessage($model->media_id, $tagid, $model);
                    break;

                case 'video':
                    return $this->sendVideoMessage($model->media_id, $tagid, $model);
                    break;

                case 'news':
                    return $this->sendMpnewsMessage($model->media_id, $tagid, $model);
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * 预览文本消息
     */
    public function prviewTextMessage($text, $wxname)
    {
        $result = $this->wechat->broadcast->previewTextByName($text, $wxname);

        return $result;
    }

    /**
     * 预览素材消息
     */
    public function previewMediaMessage($id, $wxname)
    {
        $model = WechatMediaModel::where('wechat_id', $this->wechat_id)->find($id);
        if ( ! empty($model)) {
            switch ($model->type) {
                case 'image':
                    $result = $this->wechat->broadcast->previewImageByName($model->media_id, $wxname);
                    break;

                case 'voice':
                    $result = $this->wechat->broadcast->previewVoiceByName($model->media_id, $wxname);
                    break;

                case 'video':
                    $result = $this->wechat->broadcast->previewVideoByName($model->media_id, $wxname);
                    break;

                case 'news':
                    $result = $this->wechat->broadcast->previewNewsByName($model->media_id, $wxname);
                    break;

                default:
                    break;
            }

            return $result;
        }

    }


    /**
     * 发送图片消息
     */
    public function sendImageMessage($media_id, $tagid = null, $model = null)
    {
        $content = ['media_id' => $media_id];
        if (! empty($tagid)) {
            $content['tag_id'] = $tagid;
        }

        $result = $this->wechat->broadcast->sendImage($media_id, $tagid);

        if (! is_null($model)) {
            $content['img_url'] = \RC_Upload::upload_url($model->file);
        }

        WechatMassHistoryModel::massSendRecord($this->wechat_id, $model->id, 'image', $content, $result);

        $content['type'] = 'image';
        return $content;
    }


    /**
     * 发送语音消息
     */
    public function sendVoiceMessage($media_id, $tagid = null, $model = null)
    {
        $content = ['media_id' => $media_id];
        if (! empty($tagid)) {
            $content['tag_id'] = $tagid;
        }

        $result = $this->wechat->broadcast->sendVoice($media_id, $tagid);

        if (! is_null($model)) {
            $content['voice_url'] = \RC_Upload::upload_url($model->file);
        }

        WechatMassHistoryModel::massSendRecord($this->wechat_id, $model->id, 'voice', $content, $result);

        $content['type'] = 'voice';
        return $content;

    }


    /**
     * 发送视频消息
     */
    public function sendVideoMessage($media_id, $tagid = null, $model = null)
    {
        $content = ['media_id' => $media_id];
        if (! empty($tagid)) {
            $content['tag_id'] = $tagid;
        }

        if (is_array($tagid) && ! is_null($model)) {
            $content['title'] = $model->title;
            $content['description'] = $model->digest;
        }

        $result = $this->wechat->broadcast->sendVideo($media_id, $tagid);

        if (! is_null($model)) {
            $content['video_url'] = \RC_Upload::upload_url($model->file);
        }

        WechatMassHistoryModel::massSendRecord($this->wechat_id, $model->id, 'mpvideo', $content, $result);

        $content['type'] = 'mpvideo';
        return $content;
    }


    /**
     * 发送音乐消息
     */
    public function sendMusicMessage()
    {

    }


    /**
     * 发送图文消息（点击跳转到图文消息页面）
     */
    public function sendMpnewsMessage($media_id, $tagid = null, $model = null)
    {
        $content = ['media_id' => $media_id];
        if (! empty($tagid)) {
            $content['tag_id'] = $tagid;
        }

        $result = $this->wechat->broadcast->sendNews($media_id, $tagid);

        if (! is_null($model)) {

            $subNews = $model->subNews;

            if ( ! $subNews->isEmpty()) {
                $newSubNews = $subNews->map(function ($item) {
                    if (empty($item->file)) {

                        $item->file = \RC_Uri::admin_url('statics/images/nopic.png');

                    } else {

                        $item->file = \RC_Upload::upload_url($item->file);

                    }

                    return [
                        'title' => $item->title,
                        'description' => $item->digest,
                        'url' => $item->media_url,
                        'picurl' => $item->file,
                    ];
                });

                $content['articles'] = $newSubNews->all();
            } else {
                $content['articles'] = [];
            }

            //将主元素插入开头
            array_unshift($content['articles'], [
                'title' => $model->title,
                'description' => $model->digest,
                'url' => $model->media_url,
                'picurl' => \RC_Upload::upload_url($model->file),
            ]);
        }

        WechatMassHistoryModel::massSendRecord($this->wechat_id, $model->id, 'mpnews', $content, $result);

        $content['type'] = 'mpnews';
        return $content;

    }


    /**
     * 发送卡券
     */
    public function sendWxcardMessage()
    {

    }


}