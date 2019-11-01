<?php

namespace Ecjia\App\Wechat;

use RC_Time;
use RC_Lang;
use Ecjia\App\Wechat\Models\WechatUserModel;
use Ecjia\App\Wechat\Models\WechatCustomMessageModel;
use Royalcms\Component\WeChat\Message\Text;
use Royalcms\Component\WeChat\Message\Image;
use Royalcms\Component\WeChat\Message\Voice;
use Royalcms\Component\WeChat\Message\Video;
use Royalcms\Component\WeChat\Message\News;
use Royalcms\Component\WeChat\Message\Music;

class WechatRecord
{
    /**
     * 回复文本消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Default_reply($message)
    {
        $content = array(
            'content' => __('抱歉，暂未找到与您关键词所匹配的信息，可以进入客服系统进行相关咨询', 'wechat')
        );
        self::replyMsg($message->get('FromUserName'), $content['content']);

        return new Text($content);
    }

    /**
     * 回复文本消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Text_reply($message, $text)
    {
        if (!empty($text)) {
            $content = array(
                'content' => $text
            );
            self::replyMsg($message->get('FromUserName'), $text);

            return new Text($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 回复图片消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Image_reply($message, $file)
    {
        if (!empty($file)) {
            $content = [
                'media_id' => $file //通过素材管理接口上传多媒体文件，得到的id。
            ];
            self::replyMsg($message->get('FromUserName'), __('回复图片消息', 'wechat'));

            return new Image($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 回复语音消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Voice_reply($message, $file)
    {
        if (!empty($file)) {
            $content = [
                'media_id' => $file //通过素材管理接口上传多媒体文件，得到的id。
            ];
            self::replyMsg($message->get('FromUserName'), __('回复语音消息', 'wechat'));

            return new Voice($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 回复视频消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Video_reply($message, $file, $title, $digest)
    {
        if (!empty($file)) {
            $content = [
                'media_id'    => $file,
                'title'       => $title,
                'description' => $digest
            ];
            self::replyMsg($message->get('FromUserName'), __('回复视频消息', 'wechat'));

            return new Video($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 回复图文消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function News_reply($message, $title, $description, $url, $image)
    {
        if (!empty($title)) {
            $content = [
                'title'       => $title,
                'description' => $description,
                'url'         => $url,
                'image'       => $image,
            ];
            self::replyMsg($message->get('FromUserName'), __('回复图文消息', 'wechat'));

            return new News($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 回复图文消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function createNewsReply($message, $title, $description, $url, $image)
    {
        $content = [
            'title'       => $title,
            'description' => $description,
            'url'         => $url,
            'image'       => $image,
        ];

        return new News($content);
    }

    /**
     * 回复多图文消息
     * @param array | \Royalcms\Component\WeChat\Message\News $news
     */
    public static function MultiNews_reply($message, /*...*/
                                           $news)
    {
        $args = func_get_args();
        $nums = func_num_args();

        if ($nums == 2) {
            if (is_array($args[1])) {
                $news = $args[1];
            }
        }

        unset($args[0]);

        if (count($args) > 8) {
            $news = array_slice($args, 0, 8);
        }

        self::replyMsg($message->get('FromUserName'), __('回复多图文消息', 'wechat'));

        return $news;
    }

    /**
     * 回复音乐消息
     * @param string $message
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $hq_url 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param string $thumb_media_id 缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
     * @return \Royalcms\Component\WeChat\Message\Music|\Royalcms\Component\WeChat\Message\Text
     */
    public static function Music_reply($message, $title, $description, $url, $hq_url, $thumb_media_id)
    {
        if (!empty($title) && !empty($description)) {
            $content = [
                'title'          => $title,
                'description'    => $description,
                'url'            => $url,
                'hq_url'         => $hq_url,
                'thumb_media_id' => $thumb_media_id,
            ];
            self::replyMsg($message->get('FromUserName'), __('回复音乐消息', 'wechat'));

            return new Music($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 输入信息
     */
    public static function inputMsg($fromusername, $msg, $type = 'text', $content = null)
    {
        $uid = WechatUserModel::where('openid', $fromusername)->value('uid');
        if (!empty($uid)) {
            $data = array(
                'uid'           => $uid,
                'msg'           => $msg,
                'send_time'     => RC_Time::gmtime(),
                'iswechat'      => 0,
                'type'          => $type,
                'media_content' => $content ? serialize($content) : '',
            );
            WechatCustomMessageModel::insert($data);
        }
    }

    /**
     * 公众号回复信息
     */
    public static function replyMsg($fromusername, $msg, $type = 'text', $content = null)
    {
        $uid = WechatUserModel::where('openid', $fromusername)->value('uid');
        if (!empty($uid)) {
            $data = array(
                'uid'           => $uid,
                'msg'           => $msg,
                'send_time'     => RC_Time::gmtime(),
                'iswechat'      => 1,
                'type'          => $type,
                'media_content' => $content ? serialize($content) : '',
            );
            WechatCustomMessageModel::insert($data);
        }
    }


}