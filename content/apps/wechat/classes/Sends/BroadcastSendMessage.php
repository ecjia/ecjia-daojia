<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
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