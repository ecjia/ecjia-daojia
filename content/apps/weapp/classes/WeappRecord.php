<?php

namespace Ecjia\App\Weapp;

use RC_Time;
use Ecjia\App\Wechat\Models\WechatUserModel;
use Ecjia\App\Wechat\Models\WechatCustomMessageModel;
//use Ecjia\App\Wechat\WechatRecord;
use Royalcms\Component\WeChat\Message\Text;
use Royalcms\Component\WeChat\Message\Image;
use Royalcms\Component\WeChat\Message\Voice;
use Royalcms\Component\WeChat\Message\Video;
use Royalcms\Component\WeChat\Message\News;
use Royalcms\Component\WeChat\Message\Music;

class WeappRecord
{
    /**
     * 回复文本消息
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Default_reply($message)
    {
        $content = array(
            'content' => __('抱歉，暂未找到与您关键词所匹配的信息，可以进入客服系统进行相关咨询', 'weapp')
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
            self::replyMsg($message->get('FromUserName'), __('回复图片消息', 'weapp'));

            return new Image($content);
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
            self::replyMsg($message->get('FromUserName'), __('回复图文消息', 'weapp'));

            return new News($content);
        } else {
            return self::Default_reply($message);
        }
    }

    /**
     * 回复多图文消息
     * @param \Royalcms\Component\WeChat\Message\News $news
     */
    public static function MultiNews_reply(/*...*/
        $news)
    {
        $args = func_get_args();

        if (count($args) > 8) {
            $news = array_slice($args, 0, 8);
        }

        return $news;
    }


    /**
     * 输入信息
     */
    public static function inputMsg($fromusername, $msg, $type = 'text', $content = null)
    {
        $uid = WechatUserModel::where('openid', $fromusername)->pluck('uid');
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
        $uid = WechatUserModel::where('openid', $fromusername)->pluck('uid');
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