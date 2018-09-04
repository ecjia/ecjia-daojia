<?php namespace Royalcms\Component\WeChat;

use RC_Hook;
use Royalcms\Component\Error\Error;
use Exception;

/**
 * @file
 *
 * WechatAPI
 * @see http://mp.weixin.qq.com/wiki/home/index.html
 */


/**
 * @todo 客服 群发 永久素材
 *
 */
class WeChatAPI {
    
    /**
     * 发送客服消息
     *
     * @param {
          touser  : OPENID,
          msgtype : text | image | voice | video | music | news | wxcard
          ...
       }
     *
     * @return boolean | array
     */
    public function sendCustomMessage($data) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'message/custom/send');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 添加客服帐号
     *
     * @param $kf_account test1@test
     * @param $nickname  客服1
     *
     * @return boolean | Object Error
     */
    public function addKfaccount($kf_account, $nickname) {
        static $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
        	'kf_account' => $kf_account,
            'nickname'   => $nickname,
        );
        $body = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfaccount/add');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 邀请绑定客服帐号
     *
     * @param $kf_account test1@test 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param $inviteworker  接收绑定邀请的客服微信号
     *
     * @return boolean | Object Error
     */
    public function inviteKfaccount($kf_account, $nickname) {
        static $url = 'https://api.weixin.qq.com/customservice/kfaccount/inviteworker?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
            'kf_account' => $kf_account,
            'invite_wx'   => $nickname,
        );
        $body = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfaccount/add');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 设置客服信息
     *
     * @param $kf_account test1@test
     * @param $nickname  客服1
     * @param $password  普通密码需要md5后传入
     *
     * @return boolean | Object Error
     */
    public function updateKfaccount($kf_account, $nickname) {
        static $url = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
            'kf_account' => $kf_account,
            'nickname'   => $nickname,
        );
        $body = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfaccount/update');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 删除客服帐号
     *
     * @param $kf_account test1@test
     * 
     * @return boolean | Object Error
     */
    public function deleteKfaccount($kf_account) {
        static $url = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=%s&kf_account=%s';
        $token = $this->getAccessToken();
        $body = Utility::http(sprintf($url, $token, $kf_account));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfaccount/del');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 设置客服帐号的头像
     *
     * @param $kf_account test1@test
     *
     * @return boolean | Object Error
     */
    public function uploadHeadimgKfaccount($kf_account, $media) {
        static $url = 'https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=%s&kf_account=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token, $kf_account), array('media' => curl_file_create(realpath($media))));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfaccount/uploadheadimg');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 获取所有客服账号
     *
     * @return boolean | array(
          kf_list : [
             {
                kf_account
                kf_nick
                kf_id
                kf_headimgurl
             },
             ...
          ]
       ) | Object Error
     */
    public function getKflist() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'customservice/getkflist');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 获取在线客服接待信息
     *
     * @return boolean | array(
          kf_online_list : [
             {
                kf_account
                status
                kf_id
                auto_accept
                accepted_case
             },
             ...
          ]
     ) | Object Error
     */
    public function getOnlineKflist() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'customservice/getkflist');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 创建客服会话
     *
     * @param $kf_account 完整客服账号，格式为：账号前缀@公众号微信号 test1@test
     * @param $openid  客户openid
     * @param $text  附加信息，文本会展示在客服人员的多客服客户端
     *
     * @return boolean | Object Error
     */
    public function createKfsession($kf_account, $openid, $text) {
        static $url = 'https://api.weixin.qq.com/customservice/kfsession/create?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
            'kf_account'=> $kf_account,
            'openid'    => $openid,
            'text'      => $text,
        );
        $body = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfsession/create');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 创建客服会话
     *
     * @param $kf_account 完整客服账号，格式为：账号前缀@公众号微信号 test1@test
     * @param $openid  客户openid
     * @param $text  附加信息，文本会展示在客服人员的多客服客户端
     *
     * @return boolean | Object Error
     */
    public function closeKfsession($kf_account, $openid, $text) {
        static $url = 'https://api.weixin.qq.com/customservice/kfsession/close?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
            'kf_account'=> $kf_account,
            'openid'    => $openid,
            'text'      => $text,
        );
        $body = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfsession/close');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 获取客户的会话状态
     *
     * @param $openid  客户openid
     *
     * @return {
     *      createtime : 123456789,
     *      kf_account : test1@test
     * } | Object Error
     */
    public function getKfsession($openid) {
        static $url = 'https://api.weixin.qq.com/customservice/kfsession/getsession?access_token=%s&openid=%s';
        $token = $this->getAccessToken();
        $body = Utility::http(sprintf($url, $token, $openid));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfsession/getsession');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return array(
            	'createtime' => $result['createtime'],
                'kf_account' => $result['kf_account']
            );
        }
    }
    
    
    /**
     * 获取客服的会话状态
     *
     * @param $kf_account 完整客服账号，格式为：账号前缀@公众号微信号 test1@test
     *
     * @return {
     *      "sessionlist" : [
               {
                  "createtime" : 123456789,
                  "openid" : "OPENID"
               },
               {
                  "createtime" : 123456789,
                  "openid" : "OPENID"
               }
            ]
     * } | Object Error
     */
    public function getKfsessionList($kf_account) {
        static $url = 'https://api.weixin.qq.com/customservice/kfsession/getsessionlist?access_token=%s&kf_account=%s';
        $token = $this->getAccessToken();
        $body = Utility::http(sprintf($url, $token, $kf_account));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfsession/getsessionlist');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    
    /**
     * 获取未接入会话列表
     *
     * @return {
            "count" : 150,
            "waitcaselist" : [
               {
                  "createtime" : 123456789,
                  "kf_account" : "test1@test",
                  "openid" : "OPENID"
               },
               {
                  "createtime" : 123456789,
                  "kf_account" : "",
                  "openid" : "OPENID"
               }
            ]
        } | Object Error
     */
    public function getKfsessionWaitcase() {
        static $url = 'https://api.weixin.qq.com/customservice/kfsession/getwaitcase?access_token=%s';
        $token = $this->getAccessToken();
        $body = Utility::http(sprintf($url, $token));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/kfsession/getwaitcase');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    
    /**
     * 获取未接入会话列表
     * 
     * @param $starttime    查询开始时间，UNIX时间戳
     * @param $endtime      查询结束时间，UNIX时间戳，每次查询不能跨日查询
     * @param $pageindex    每页大小，每页最多拉取50条
     * @param $pagesize     查询第几页，从1开始
     *
     * @return array | Object Error
     */
    public function getMsgrecord($starttime, $endtime, $pageindex, $pagesize) {
        static $url = 'https://api.weixin.qq.com/customservice/msgrecord/getrecord?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
        	'starttime' => $starttime,
            'endtime'   => $endtime,
            'pageindex' => $pageindex,
            'pagesize'  => $pagesize,
        );
        $body = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        RC_Hook::do_action('wechat_api_request_record', 'customservice/msgrecord/getrecord');
        $result = json_decode($body, true);
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
   
    /**
     * 发送模板消息
     *
     * @param {
          touser      : OPENID,
          template_id : TEMPLATE,
          url         :
          topcolor    : '#FFFFFF'
          data        : [
              first : {
                 value :
                 color :
              }
              ...
              remark : {
                 value :
                 color :
              }
          ]
       }
     *
     * @return boolean | array | Object Error
     */
    public function sendTemplateMessage($data) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'message/template/send');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 上传临时素材
     *
     * image 1M, voice 2M, video 10M, thumb 64K     
     * @return boolean | array(type => , media_id => , created_at => ) | Object Error
     */
    public function uploadFile($type, $file) {
        static $url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s';
        $token = $this->getAccessToken(); 
        $body  = Utility::http(sprintf($url, $token, $type), array('media' => curl_file_create(realpath($file))));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'media/upload');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 下载临时素材
     *
     * @return boolean | binary
     */
    public function downloadFile($media_id) {
        static $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=%s&media_id=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token, $media_id));
        RC_Hook::do_action('wechat_api_request_record', 'media/get');
        if (substr($body,0,1) == '{') {
            return false;
        } else {
            return $body;
        }
    }
    
    /**
     * 上传图文消息内的图片获取URL
     *
     * image 1M, voice 2M, video 10M, thumb 64K
     * @return array(media_id => ) | Object Error
     */
    public function uploadimgFile($file) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), array('media' => curl_file_create(realpath($file))));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'media/uploadimg');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 上传图文消息内的图片获取URL
     * @param array {
     *      articles : [{
     *          title : TITLE,
     *          thumb_media_id : THUMB_MEDIA_ID,
     *          author : AUTHOR,
     *          digest : DIGEST,
     *          show_cover_pic : SHOW_COVER_PIC(0 / 1),
     *          content : CONTENT,
     *          content_source_url : CONTENT_SOURCE_URL
     *      }
     *      ......
     *    ]
     * }
     * @return array(type => , media_id => , created_at => ) | Object Error
     */
    public function uploadNews($data) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'media/uploadnews');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 获取群发消息中需要的视频media_id
     * 
     * @param $media_id 此处media_id需通过基础支持中的上传下载多媒体文件来得到
     * @param $title
     * @param description
     * 
     * @return array(type => 'video', media_id => , created_at => ) | Object Error
     */
    public function uploadVideo($media_id, $title, $description) {
        static $url = 'https://file.api.weixin.qq.com/cgi-bin/media/uploadvideo?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
        	'media_id'     => $media_id,
            'title'        => $title,
            'description'  => $description
        );
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'media/uploadvideo');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 上传永久素材文件
     *
     * image 1M, voice 2M, video 10M, thumb 64K
     * @return array(media_id => , url => ) | Object Error
     */
    public function addMaterialFile($type, $file, $introduction=array()) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s&type=%s';
    	$token = $this->getAccessToken();
    	if ($type == 'video') {
    		$body = Utility::http(sprintf($url, $token, $type), array('media' => curl_file_create(realpath($file)), 'description' => Utility::json_encode($introduction)));
    	} else {
    		$body = Utility::http(sprintf($url, $token, $type), array('media' => curl_file_create(realpath($file))));
    	}
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/add_material');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return $result;
    	}
    }
    
    /**
     * 上传永久素材图文
     *
     * @param array {
     *      articles : [{
     *          title : TITLE,
     *          thumb_media_id : THUMB_MEDIA_ID,
     *          author : AUTHOR,
     *          digest : DIGEST,
     *          show_cover_pic : SHOW_COVER_PIC(0 / 1),
     *          content : CONTENT,
     *          content_source_url : CONTENT_SOURCE_URL
     *      }
     *      ......
     *    ]
     * }
     * @return array(media_id => , url =>) | Object Error
     */
    public function addMaterialNews($data) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/add_news');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 获取永久素材
     *
     * image 1M, voice 2M, video 10M, thumb 64K
     * @return array | Object Error
     */
    public function getMaterial($media_id) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array('media_id' => $media_id)));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/get_material');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 获取永久素材列表
     * 
     * @param $type [image, voice, video, thumb]
     * @param $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
     * @param $count  返回素材的数量，取值在1到20之间
     * 
     * @return array | Object Error
     */
    public function batchGetMaterial($type, $offset, $count) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
        	'type'      => $type,
            'offset'    => $offset,
            'count'     => $count,
        );
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/batchget_material');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 删除永久素材
     *
     * image 1M, voice 2M, video 10M, thumb 64K
     * @return boolean | Object Error
     */
    public function deleteMaterial($media_id) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array('media_id' => $media_id)));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/del_material');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 修改永久图文素材
     *
     * @param media_id
     * @param index
     * @param array {
     *      articles : {
     *          title : TITLE,
     *          thumb_media_id : THUMB_MEDIA_ID,
     *          author : AUTHOR,
     *          digest : DIGEST,
     *          show_cover_pic : SHOW_COVER_PIC(0 / 1),
     *          content : CONTENT,
     *          content_source_url : CONTENT_SOURCE_URL
     *      }
     * }
     * @return boolean | Object Error
     */
    public function updateMaterialNews($media_id, $index, $articles) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=%s';
        $token = $this->getAccessToken();
        $data = array(
        	'media_id'  => $media_id,
            'index'     => $index,
            'articles'  => $articles['articles'],
        );
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/update_news');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 获取永久素材总数
     *
     * @return array(
     *      voice_count : COUNT,
     *      video_count : COUNT,
     *      image_count : COUNT,
     *      news_count : COUNT,
     * ) | Object Error
     */
    public function getMaterialCount() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'material/get_materialcount');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }

    /**
     * 获取单个用户信息
     *
     * @return boolean | array(
            subscribe      =>,
            openid         =>,
            nickname       =>,
            sex            =>,
            language       =>,
            city           =>,
            province       =>,
            country        =>,
            headimgurl     =>,
            subscribe_time =>,
            unionid        =>,
            remark         =>,
            groupid        => 0,
        ) | Object Error
     */
    public function getUserInfo($openid) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token, $openid));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'user/info');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }

    /**
     * 获取多个用户信息 最多100个
     *
     * @deprecated 4.0.0 已废弃
     * @param {
          user_list : [
            { openid =>, lang => zh_CN }
            { openid =>, lang => zh_CN }
          ]
        }
     *
     * @return boolean | array(
          user_info_list : [
             {USERINFO}
             {USERINFO}
          ]
        ) | Object Error
     */
    public function getUserInfoBatch($openids) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=%s';
        $token = $this->getAccessToken();
        foreach ($openids as $openid) {
            $data['user_list'][] = array(
                'openid' => $openid,
                'lang'   => 'zh_CN',
            );
        }
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'user/info/batchget');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 设置用户备注
     *
     * @return boolean | Object Error
     */
    public function setUserRemark($openid, $remark) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'openid' => $openid, 'remark' => $remark,
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'user/info/updateremark');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 获取用户列表
     * 
     * @deprecated 4.0.0 已废弃
     * @return boolean | array(
            total
            count
            next_openid
            data : {
                openid : [OPENID, OPENID, ...]
            }
       ) | Object Error
     */
    public function getUserList($next_openid = '') {
        static $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=%s&next_openid=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token, $next_openid));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'user/get');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }

    /**
     * 创建用户分组
     *
     * @param {
          group ：{
             name => ,
          }
        }
     *
     * @return boolean | array(
          group : {
             id   =>,
             name =>,
          }
       ) | Object Error
     */
    public function addGroup($name) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/create?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'group' => array('name' => $name)
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/create');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 创建用户标签组
     *
     * @param {
     tag ：{
     name => ,
     }
     }
     *
     * @return boolean | array(
     tag : {
     id   =>,
     name =>,
     }
     ) | Object Error
     */
    public function addTag($name) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
    			'tag' => array('name' => $name)
    	)));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/create');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return $result;
    	}
    }

    /**
     * 查询所有分组
     *
     * @return boolean | array(
          groups : [
             {
                id
                name
                count
             },
             ...
          ]
       ) | Object Error
     */
    public function getGroups() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/get?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/get');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 获取所有标签
     *
     * @deprecated 4.0.0 已废弃
     * @return boolean | array(
     tags : [
     {
     id
     name
     count
     },
     ...
     ]
     ) | Object Error
     */
    public function getTags() {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/get');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return $result;
    	}
    }

    /**
     * 修改分组
     *
     * @param {
          group ：{
             id   => ,
             name => ,
          }
        }
     *
     * @return boolean | Object Error
     */
    public function setGroup($groupid, $name) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/update?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'group' => array('id' => $groupid, 'name' => $name)
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/update');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 修改标签
     *
     * @param {
     tag ：{
     id   => ,
     name => ,
     }
     }
     *
     * @return boolean | Object Error
     */
    public function setTag($tagid, $name) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
    			'tag' => array('id' => $tagid, 'name' => $name)
    	)));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/update');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return true;
    	}
    }
    
    /**
     * 删除分组
     *
     * @param {
          group ：{
             id   => ,
          }
        }
     *
     * @return boolean | Object Error
     */
    public function deleteGroup($groupid) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'group' => array('id' => $groupid)
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/delete');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 删除标签
     *
     * @param {
     tag ：{
     id   => ,
     }
     }
     *
     * @return boolean | Object Error
     */
    public function deleteTag($tagid) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
    			'tag' => array('id' => $tagid)
    	)));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/delete');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return true;
    	}
    }
    
    /**
     * 查询用户所在分组
     *
     * @return boolean | array(
          groupid =>,
       ) | Object Error
     */
    public function getUserGroup($openid) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/getid?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'openid' => $openid,
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/getid');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    
    /**
     * 获取用户身上的标签列表
     *
     * @return boolean | array(
          tagid_list =>,
       ) | Object Error
     */
    public function getUserTags($openid) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
    			'openid' => $openid,
    	)));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/getidlist');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return $result;
    	}
    }
    
    /**
     * 修改用户所在分组
     *
     * @return boolean | Object Error
     */
    public function setUserGroup($openid, $groupid) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'openid'     => $openid,
                    'to_groupid' => $groupid,
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/members/update');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }
    
    /**
     * 批量为用户添加标签
     *
     * @param {
     tagid : ,
     openid_list ：[
     OPENID, OPENID, ...
     ]
     }
     *
     * @return boolean | Object Error
     */
    public function setBatchTag($openids, $tagid) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
    			'openid_list' => $openids,
    			'tagid'  	  => $tagid,
    	)));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/members/batchtagging');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return true;
    	}
    }
    
    
    /**
     * 批量为用户取消标签
     *
     * @param {
     tagid : ,
     openid_list ：[
     OPENID, OPENID, ...
     ]
     }
     *
     * @return boolean | Object Error
     */
    public function setBatchunTag($openids, $tagid) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
    			'openid_list' => $openids,
    			'tagid'  	  => $tagid,
    	)));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'tags/members/batchuntagging');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return true;
    	}
    }
    
    
    /**
     * 批量移动用户分组
     *
     * @param {
          to_groupid : ,
          openid_list ：[
             OPENID, OPENID, ...
          ]
        }
     *
     * @return boolean | Object Error
     */
    public function setUsersGroup($openids, $groupid) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode(array(
                    'openid_list' => $openids,
                    'to_groupid'  => $groupid,
                 )));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'groups/members/update');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }

    /**
     * 创建自定义菜单
     * 
     * @deprecated 4.0.0 已废弃
     * @param {
          button : [
              {
                type : click
                name :
                key  :
              },
              {
                name :
                sub_button : [
                    type: view
                    name:
                    url :
                ]
              }
          ]
        }
     *
     * @return boolean | Object Error
     */
    public function setMenu($menu) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($menu));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'menu/create');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }

    /**
     * 查询自定义菜单
     *
     * @deprecated 4.0.0 已废弃
     * @retrun boolean | array(
            menu : {
                button : ...
            }
       ) | Object Error
     */
    public function getMenu() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'menu/get');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }

    /**
     * 删除自定义菜单
     * 
     * @deprecated 4.0.0 已废弃
     * @return boolean | Object Error
     */
    public function deleteMenu() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'menu/delete');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }

    /**
     * 用户同意授权，获取code
     *
     * @param array(
          redirect_uri =>,
          scope        =>,
          state        =>,
       )
     *
     * @return string URL
     */
    public function getWebCodeUrl($param){
        static $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect';
        $args = array(
            'appid'         => $this->getConfig('appid'),
            'redirect_uri'  => $param['redirect_uri'],
            'response_type' => 'code',
            'scope'         => $param['scope'],
            'state'         => $param['state'],
        );
        return vsprintf($url, $args);
    }
    
    /**
     * 第三方使用网站应用授权登录，用户同意，获取code
     *
     * @param array(
     redirect_uri =>,
     scope        =>,
     state        =>,
     )
     *
     * @return string URL
     */
    public function getQRConnectCodeUrl($param) {
        static $url = 'https://open.weixin.qq.com/connect/qrconnect?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect';
        $args = array(
            'appid'         => $this->getConfig('appid'),
            'redirect_uri'  => $param['redirect_uri'],
            'response_type' => 'code',
            'scope'         => $param['scope'],
            'state'         => $param['state'],
        );
        return vsprintf($url, $args);
    }

    /**
     * 通过code换取网页授权WebAccessToken
     *
     * @return boolean | array | Object Error
     */
    public function getWebToken($code) {
        static $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?%s';
        $args = array(
            'appid'      => $this->getConfig('appid'),
            'secret'     => $this->getConfig('appsecret'),
            'code'       => $code,
            'grant_type' => 'authorization_code',
        );
        $body = Utility::http(sprintf($url, http_build_query($args)));
        $result = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'sns/oauth2/access_token');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }

    /**
     * 刷新WebAccessToken
     *
     * @return boolean | array | Object Error
     */
    public function refreshWebToken($token) {
        static $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?%s';
        $args = array(
            'appid'         => $this->getConfig('appid'),
            'grant_type'    => 'refresh_token',
            'refresh_token' => $token,
        );
        $body = Utility::http(sprintf($url, http_build_query($args)));
        $result = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'sns/oauth2/refresh_token');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 验证WebAccessToken
     *
     * @return boolean | Object Error
     */
    public function authWebToken($openid, $token) {
        static $url = 'https://api.weixin.qq.com/sns/auth?access_token=%s&openid=%s';
        $body = Utility::http(sprintf($url, $token, $openid));
        $result = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'sns/auth');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    }

    /**
     * 获取用户信息(需scope为 snsapi_userinfo)
     *
     * @return boolean | array(
            openid     =>,
            nickname   =>,
            sex        =>,
            province   =>,
            city       =>,
            country    =>,
            headimgurl =>,
            privilege  => []
        ) | Object Error
     */
    public function getWebUserInfo($openid, $token) {
        static $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN';
        $body = Utility::http(sprintf($url, $token, $openid));
        $result = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'sns/userinfo');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 二维码申请
     *
     * 临时二维码
     * @param {
            expire_seconds: 604800
            action_name   : QR_SCENE
            action_info : {
                scene : {
                    scene_id : 小于100000
                }
            }
        }
     * 永久二维码
     * @param {
            action_name : QR_LIMIT_SCENE | QR_LIMIT_STR_SCENE
            action_info : {
                scene : {
                    scene_id :小于100000
                    <scene_str:长度小于64>
                }
            }
        }
     *
     * @return boolean | array(
            ticket         =>,
            expire_seconds =>,
            url            =>,
        ) | Object Error
     * https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=TICKET
     */
    public function getQrcodeTicket($data) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s';
        $token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'qrcode/create');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return $result;
        }
    }
    
    /**
     * 获取JS API Ticket
     *
     * @return {
            "errcode":0,
            "errmsg":"ok",
            "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKdvsdshFKA",
            "expires_in":7200
        }
     */
    public function getJsTicket() {
        static $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=%s";
        $ticket = Utility::getJsTicket($this);
        if (empty($ticket) || time() > $ticket['expired']) {
            $token = $this->getAccessToken();
            $body  = Utility::http(sprintf($url, $token));
            $json  = json_decode($body, true);
            if (!$json || !empty($json['errcode'])) {
                throw new Exception('Error - WeChat Can not get JsTicket.');
            } else {
                $ticket['ticket']   = $json['ticket'];
                $ticket['expired'] = time() + $json['expires_in'] - 120;
                Utility::setJsTicket($ticket, $this);
            }
        }
        
        return $ticket['ticket'];
    }
    
    /**
     * 获取access_token
     */
    public function getAccessToken() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
        $token = Utility::getAccessToken($this);
        if (empty($token) || time() > $token['expired']) {
            $body= Utility::http(sprintf($url, $this->getConfig('appid'), $this->getConfig('appsecret')));
            $result = json_decode($body, true);
            RC_Hook::do_action('wechat_api_request_record', 'token');
            if (!$result || !empty($result['errcode'])) {
                throw new Exception('Error - WeChat Can not get AccessToken.');            
            } else {
                $token['token']   = $result['access_token'];
                $token['expired'] = time() + $result['expires_in'] - 120;
                Utility::setAccessToken($token, $this);
            }
        }

        return $token['token'];
    }
    
    /**
     * 获取wx.config需要的数据
     *
     * @param string uri 当前网址(#前的所有字符)
     */
    public function wxConfig($uri = '') {
        $timestamp  = time();
        $nonceStr   = md5(microtime(true));
        $ticket     = $this->getJsTicket();
        $string     = "jsapi_ticket={$ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url=" . $uri;
        $signature  = sha1($string);
        return array(
            'appId'     => $this->getConfig('appid'),
            'timestamp' => $timestamp,
            'nonceStr'  => $nonceStr,
            'signature' => $signature,
        );
    }

    /**
     * 验证配置
     * @return boolean | Object Error
     */
    public function validateConfig() {
        static $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
        $body = Utility::http(sprintf($url, $this->getConfig('appid'), $this->getConfig('appsecret')));
        $result = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'token');
        if (!$result || !empty($result['errcode'])) {
            return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
        } else {
            return true;
        }
    } 

    /**
     * 群发消息
     *
     * @return boolean | array
     */
    public function sendallMass($data) {
    	static $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=%s';
    	$token = $this->getAccessToken();
    	$body  = Utility::http(sprintf($url, $token), Utility::json_encode($data));
    	$result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'message/custom/send');
    	if (!$result || !empty($result['errcode'])) {
    		return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
    	} else {
    		return $result;
    	}
     }

     
    /**
      * 删除群发
      *
      * @return boolean | array
      */
     public function mass_delete($msg_id) {
        static $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=%s';
    	$token = $this->getAccessToken();
        $body  = Utility::http(sprintf($url, $token), Utility::json_encode($msg_id));
        $result  = json_decode($body, true);
        RC_Hook::do_action('wechat_api_request_record', 'message/mass/delete');
	    if (!$result || !empty($result['errcode'])) {
	       return new Error('wechat_error_' . $result['errcode'], $result['errmsg']);
	    } else {
	       return $result;
	    }
	 }
}
