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
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_action {
    /**
     * 文本回复
     * @param unknown $request
     */
    public static function Text_action($request) {
    	$content = null;
    	
    	RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'command_reply'), 10, 2);
    	RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'keyword_reply'), 90, 2);
    	RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'empty_reply'), 100, 2);
    	
    	$content = RC_Hook::apply_filters('wechat_text_response', $content, $request);
    	
    	$response = Component_WeChat_Response::create($content);
    	RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
    	$response->send();
    }
    
    /**
     * 消息为空回复
     * @param unknown $content
     * @param unknown $request
     * @return multitype:string unknown NULL
     */
    public static function empty_reply($content, $request) {
        if (!is_null($content)) {
            return $content;
        }
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        RC_Loader::load_app_class('wechat_response', 'wechat', false);
        $wechat_id = wechat_method::wechat_id();
       
        $wr_db    = RC_Loader::load_app_model('wechat_reply_model', 'wechat');
        $media_db = RC_Loader::load_app_model('wechat_media_model', 'wechat');
        $field    = 'reply_type,content,media_id';
        $data     = $wr_db->field($field)->find(array('wechat_id'=>$wechat_id,'type'=>'msg'));
        if ($data['reply_type'] == 'text') {
        	$msg = $data['content'];
        	$content = wechat_response::Text_reply($request, $msg);
        }else if ($data['reply_type'] == 'image') {
        	$msg   = $media_db->where(array('id' => $data['media_id']))->get_field('thumb');
        	$content = wechat_response::Image_reply($request, $msg);
        }else if ($data['reply_type'] == 'voice') {
        	$msg   = $media_db->where(array('id' => $data['media_id']))->get_field('media_id');
        	$content = wechat_response::Voice_reply($request, $msg);
        }else if ($data['reply_type'] == 'video') {
        	$field='title, digest, media_id';
        	$msg = $media_db->field($field)->find(array('id' => $data['media_id']));
        	$content = wechat_response::Video_reply($request, $msg['media_id'], $msg['title'], $msg['digest']);
        }
        return $content;
    }
    
    /**
     * 命令回复
     * @param unknown $content
     * @param unknown $request
     * @return unknown|multitype:string NULL
     */
    public static function command_reply($content, $request) {
        if (!is_null($content)) {
            return $content;
        }
        
        RC_Loader::load_app_class('platform_command', 'platform', false);
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        $wechat_id = wechat_method::wechat_id();
        
        $command = new platform_command($request, $wechat_id);
        $content = $command->runCommand($request->getParameter('Content'));
        
        return $content;
    }
    
    /**
     * 关键字回复
     * @param unknown $content
     * @param unknown $request
     * @return unknown|multitype:string NULL unknown
     */
    public static function keyword_reply($content, $request) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wr_db     = RC_Loader::load_app_model('wechat_reply_model', 'wechat');
        $wr_viewdb = RC_Loader::load_app_model('wechat_reply_viewmodel','wechat');
        $media_db  = RC_Loader::load_app_model('wechat_media_model', 'wechat');
        RC_Loader::load_app_class('platform_account', 'platform', false);
        RC_Loader::load_app_func('global','wechat'); 
               
        $uuid           = trim($_GET['uuid']);
        $account        = platform_account::make($uuid);
        $wechat_id      = $account->getAccountID();
        $rule_keywords  = $request->getParameter('content');
        wechat_method::record_msg($request->getParameter('FromUserName'),$rule_keywords);
        $result         = $wr_viewdb->where(array('wrk.rule_keywords = '."'$rule_keywords'", 'wr.wechat_id' => $wechat_id))->field('wr.content,wr.media_id,wr.reply_type')->select();
        if(!empty($result)) {
            if (!empty($result[0]['media_id'])) {
                $field='id, title, content, digest, file, type, file_name, article_id, link';
                $mediaInfo = $media_db->field($field)->find(array('id' => $result[0]['media_id'],'wechat_id'=>$wechat_id));
                if ($result[0]['reply_type'] == 'image') {
                	$msg   = $media_db->where(array('id' => $result[0]['media_id']))->get_field('thumb');
                    $content = array(
                        'ToUserName' 	=> $request->getParameter('FromUserName'),
                        'FromUserName' 	=> $request->getParameter('ToUserName'),
                        'CreateTime' 	=> SYS_TIME,
                        'MsgType' 		=> $result[0]['reply_type'],
                        'Image' 		=> array(
                            'MediaId'	=>	$msg//通过素材管理接口上传多媒体文件，得到的id。
                        )
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.image_content'), 1);
                } elseif ($result[0]['reply_type'] == 'voice') {
                	$msg   = $media_db->where(array('id' => $result[0]['media_id']))->get_field('media_id');
                    $content = array(
                        'ToUserName' 	=> $request->getParameter('FromUserName'),
                        'FromUserName' 	=> $request->getParameter('ToUserName'),
                        'CreateTime' 	=> SYS_TIME,
                        'MsgType' 		=> $result[0]['reply_type'],
                        'Voice' 		=> array(
                            'MediaId' 	=> $msg,
                        )
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.voice_content'), 1);
                } elseif ($result[0]['reply_type'] == 'video') {
                	$msg   = $media_db->where(array('id' => $result[0]['media_id']))->get_field('media_id');
                    $content = array(
                        'ToUserName' 	=> $request->getParameter('FromUserName'),
                        'FromUserName' 	=> $request->getParameter('ToUserName'),
                        'CreateTime' 	=> SYS_TIME,
                        'MsgType' 		=> $result[0]['reply_type'],
                        'Video' 		=> array(
                            'MediaId' 	  => $msg,
                            'Title' 	  => $mediaInfo['title'],
                            'Description' => $mediaInfo['digest']
                        )
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.video_content'), 1);
                } elseif ($result[0]['reply_type'] == 'news') {
                    // 图文素材
                    $articles = array();
                    if (! empty($mediaInfo['article_id'])) {
                        $artids = explode(',', $mediaInfo['article_id']);
                        foreach ($artids as $key => $val) {
                            $field='id, title, file, content, digest,link';
                            $artinfo = $media_db->field($field)->find(array('id'=>$val, 'wechat_id' => $wechat_id));
                            $articles[$key]['Title']        = $artinfo['title'];
                            $articles[$key]['Description']  = '';
                            $articles[$key]['PicUrl']       = RC_Upload::upload_url($artinfo['file']);
                            $articles[$key]['Url']          = $artinfo['link'];
                        }
                    } else {
                        if (!empty($mediaInfo['digest'])){
                            $desc = $mediaInfo['digest'];
                        } else {
                            $desc = msubstr(strip_tags(html_out($mediaInfo['content'])),100);
                        }
                        $articles[0]['Title']       = $mediaInfo['title'];
                        $articles[0]['Description'] = $desc;
                        $articles[0]['PicUrl']      = RC_Upload::upload_url($mediaInfo['file']);
                        $articles[0]['Url']         = $mediaInfo['link'];
                    }
                    $count = count($articles);
                    $content = array(
                        'ToUserName' 	=> 	$request->getParameter('FromUserName'),
                        'FromUserName' 	=> 	$request->getParameter('ToUserName'),
                        'CreateTime' 	=> 	SYS_TIME,
                        'MsgType' 		=> 	$result[0]['reply_type'],
                        'ArticleCount'	=>	$count,
                        'Articles'		=>	$articles
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.graphic_info'), 1);
                }
        
            } else {
                $content = array(
                    'ToUserName'    => $request->getParameter('FromUserName'),
                    'FromUserName'  => $request->getParameter('ToUserName'),
                    'CreateTime'    => SYS_TIME,
                    'MsgType'       => 'text',
                    'Content'       => $result[0]['content']
                );
                wechat_method::record_msg($request->getParameter('FromUserName'),$result[0]['content'], 1);
            }
        } 
        return $content;
    }
    
    /**
     * 图片回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[image]]></MsgType>
     * <Image>
     * <MediaId><![CDATA[media_id]]></MediaId>
     * </Image>
     * </xml>
     */
    public static function Image_action($request) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'image',
            'Image'         => array(
                'MediaId'=>$request->getParameter('MediaId')//通过素材管理接口上传多媒体文件，得到的id。
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    
    /**
     * 语音回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[voice]]></MsgType>
     * <Voice>
     * <MediaId><![CDATA[media_id]]></MediaId>
     * </Voice>
     * </xml>
     */
    public static function Voice_action($request) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'voice',
            'Voice'         => array(
                'MediaId'=>$request->getParameter('MediaId')//通过素材管理接口上传多媒体文件，得到的id
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->info('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    /**
     * 视频回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[video]]></MsgType>
     * <Video>
     * <MediaId><![CDATA[media_id]]></MediaId>
     * <Title><![CDATA[title]]></Title>
     * <Description><![CDATA[description]]></Description>
     * </Video>
     * </xml>
     */
    public static function Video_action($request) {
        $content = array(
            'ToUserName'     => $request->getParameter('FromUserName'),
            'FromUserName'   => $request->getParameter('ToUserName'),
            'CreateTime'     => SYS_TIME,
            'MsgType'        => 'video',
            'Video'          => array(
                'MediaId'    =>$request->getParameter('MediaId'), //通过素材管理接口上传多媒体文件，得到的id
                'Title'      =>'test',
                'Description'=>'testneirong'
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    
    /**
     * 音乐回复
     * @param unknown $request
     * @return
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[music]]></MsgType>
     * <Music>
     * <Title><![CDATA[TITLE]]></Title>
     * <Description><![CDATA[DESCRIPTION]]></Description>
     * <MusicUrl><![CDATA[MUSIC_Url]]></MusicUrl>
     * <HQMusicUrl><![CDATA[HQ_MUSIC_Url]]></HQMusicUrl>
     * <ThumbMediaId><![CDATA[media_id]]></ThumbMediaId>
     * </Music>
     * </xml>
     */
    public static function Music_action($request) {    
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'music',
            'Music'         => array(
                'Title'         =>'',
                'Description'   =>'',
                'MusicUrl'      =>'',
                'HQMusicUrl'    =>'',//高质量音乐链接，WIFI环境优先使用该链接播放音乐
                'ThumbMediaId'  =>'',//缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    
    /**
     * 自定义菜单点击事件
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[FromUser]]></FromUserName>
     * <CreateTime>123456789</CreateTime>
     * <MsgType><![CDATA[event]]></MsgType>
     * <Event><![CDATA[CLICK]]></Event>
     * <EventKey><![CDATA[EVENTKEY]]></EventKey>
     * </xml>
     */
    public static function Click_action($request) {
        RC_Loader::load_app_class('platform_command', 'platform', false);
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        $wechat_id = wechat_method::wechat_id();
        
        $command = new platform_command($request, $wechat_id);
        $content = $command->runCommand($request->getParameter('EventKey'));
        
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }

    
    /**
     * 图文回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[news]]></MsgType>
     * <ArticleCount>2</ArticleCount>
     * <Articles>
     * <item>
     * <Title><![CDATA[title1]]></Title>
     * <Description><![CDATA[description1]]></Description>
     * <PicUrl><![CDATA[picurl]]></PicUrl>
     * <Url><![CDATA[url]]></Url>
     * </item>
     * <item>
     * <Title><![CDATA[title]]></Title>
     * <Description><![CDATA[description]]></Description>
     * <PicUrl><![CDATA[picurl]]></PicUrl>
     * <Url><![CDATA[url]]></Url>
     * </item>
     * </Articles>
     * </xml>
     */
    public static function Articles_action($request) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'news',
            'ArticleCount'  => '',
            'Articles'      => array(
                'item'      =>array(
                        'Title'         => '',
                        'Description'   => '',
                        'PicUrl'        => '',
                        'Url'           =>''
                    ),
                'item'      =>array(
                        'Title'         => '',
                        'Description'   => '',
                        'PicUrl'        => '',
                        'Url'           =>''
                    )
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('pay')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    /**
     * 关注公众号
     * @param unknown $request
     */
    public static function Subscribe_action($request) {  
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    
    	$uuid   = trim($_GET['uuid']);
    	$wechat = wechat_method::wechat_instance($uuid);
    	
    	$openid = $request->getParameter('FromUserName');
    	$info   = $wechat->getUserInfo($openid);
    	if (empty($info)) {
    		$info = array();
    	}

    	$account   = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	
    	if (isset($info['unionid']) && $info['unionid']) {
    	    //查看有没有在手机或网站上使用微信登录
    	    $connect_user = RC_Api::api('connect', 'connect_user', array('connect_code' => 'sns_wechat', 'open_id' => $info['unionid']));
    	    if ($connect_user) {
    	        $ect_uid = $connect_user->getUserId();
    	    } else {
    	        //查看公众号unionid是否绑定
    	        $ect_uid = $wechatuser_db->where(array('unionid' => $info['unionid']))->get_field('ect_uid');
    	    }
    	} else {
    	    $ect_uid = 0;
    	}

    	$count = $wechatuser_db->where(array('wechat_id' => $wechat_id, 'openid' => $openid))->count();
    	if ($count > 0) {
    	    //曾经关注过,再次关注
    	    $data['group_id']             = isset($info['groupid']) ? $info['groupid'] : $wechat->getUserGroup($openid);
    	    $data['subscribe']            = 1;
    	    $data['nickname']             = $info['nickname'];
    	    $data['sex']                  = $info['sex'];
    	    $data['city']                 = $info['city'];
    	    $data['country']              = $info['country'];
    	    $data['province']             = $info['province'];
    	    $data['language']             = $info['language'];
    	    $data['headimgurl']           = $info['headimgurl'];
    	    $data['subscribe_time']       = $info['subscribe_time'];
    	    $data['remark']               = $info['remark'];
    	    $data['unionid']              = isset($info['unionid']) ? $info['unionid'] : '';
    	    $data['ect_uid']              = $ect_uid ? $ect_uid : 0;
    	    
    	    $wechatuser_db->where(array('wechat_id' => $wechat_id, 'openid' => $openid))->update($data);
    	} else { 
    	    $data['wechat_id']        = $wechat_id;
    	    $data['group_id']         = isset($info['groupid']) ? $info['groupid'] : $wechat->getUserGroup($openid);
    	    $data['subscribe']        = 1;
    	    $data['openid']           = $openid;
    	    $data['nickname']         = $info['nickname'];
    	    $data['sex']              = $info['sex'];
    	    $data['city']             = $info['city'];
    	    $data['country']          = $info['country'];
    	    $data['province']         = $info['province'];
    	    $data['language']         = $info['language'];
    	    $data['headimgurl']       = $info['headimgurl'];
    	    $data['subscribe_time']   = $info['subscribe_time'];
    	    $data['remark']           = $info['remark'];
    	    $data['unionid']          = isset($info['unionid']) ? $info['unionid'] : '';
    	    $data['ect_uid']          = $ect_uid ? $ect_uid : 0;
    	    
    	    $wechatuser_db->insert($data);
    	}

    	//给关注用户进行问候
    	$wr_db = RC_Loader::load_app_model('wechat_reply_model', 'wechat');
    	$field = 'reply_type,content,media_id';
    	$replymsg = $wr_db->field($field)->find(array('wechat_id'=>$wechat_id,'type'=>'subscribe'));
    	$media_db = RC_Loader::load_app_model('wechat_media_model', 'wechat');
    	if ($replymsg['reply_type'] == 'text') {
    		if(!empty($replymsg['content'])){
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => $replymsg['content']
    			);
    			wechat_method::record_msg($openid, $replymsg['content'], 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	} else if ($replymsg['reply_type'] == 'image') {
    		if(!empty($replymsg['media_id'])){
    			$thumb   = $media_db->where(array('id' => $replymsg['media_id']))->get_field('thumb');
    			$content = array(
    					'ToUserName'    => $request->getParameter('FromUserName'),
    					'FromUserName'  => $request->getParameter('ToUserName'),
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'image',
    					'Image'         => array(
    							'MediaId' => $thumb //通过素材管理接口上传多媒体文件，得到的id。
    					)
    			);
    			wechat_method::record_msg($openid, RC_Lang::get('wechat::wechat.image_content'), 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	}else if ($replymsg['reply_type'] == 'voice') {
    		if(!empty($replymsg['media_id'])){
    			$media_id = $media_db->where(array('id' => $replymsg['media_id']))->get_field('media_id');
    			$content = array(
    					'ToUserName'    => $request->getParameter('FromUserName'),
    					'FromUserName'  => $request->getParameter('ToUserName'),
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'voice',
    					'Voice'         => array(
    							'MediaId' 	=> $media_id, //通过素材管理接口上传多媒体文件，得到的id。
    					)
    			);
    			wechat_method::record_msg($openid, RC_Lang::get('wechat::wechat.voice_content'), 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	}else if ($replymsg['reply_type'] == 'video') {
    		if(!empty($replymsg['media_id'])){
    			$field='title, digest, media_id';
    			$mediaInfo = $media_db->field($field)->find(array('id' => $replymsg['media_id']));
    			$content = array(
    					'ToUserName'    => $request->getParameter('FromUserName'),
    					'FromUserName'  => $request->getParameter('ToUserName'),
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'video',
    					'Video'         => array(
    							'MediaId' 	     => $media_id, //通过素材管理接口上传多媒体文件，得到的id。
    							'Title' 	     => $mediaInfo['title'],
    							'Description'    => $mediaInfo['digest']
    					)
    			);
    			wechat_method::record_msg($openid, RC_Lang::get('wechat::wechat.video_content'), 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	}

    	$response = Component_WeChat_Response::create($content);
    	RC_Logger::getLogger('pay')->debug('RESPONSE: ' . json_encode($response->getContent()));
    	$response->send();
    }
    
    
    /**
     * 已关注事件
     * @param unknown $request
     */
    public static function Scan_action($request) {
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	
    	$uuid   = trim($_GET['uuid']);
    	$wechat = wechat_method::wechat_instance($uuid);
    	$openid = $request->getParameter('FromUserName');
    	
    	$info = $wechat->getUserInfo($openid);
    	
    	if (empty($info)) {
    		$info = array();
    	}
    
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	
    	$data['wechat_id']      = $wechat_id;
    	$data['group_id']       = isset($info['groupid']) ? $info['groupid'] : $wechat->getUserGroup($openid);
    	$data['subscribe']      = 1;
    	$data['openid']         = $openid;
    	$data['nickname']       = $info['nickname'];
    	$data['sex']            = $info['sex'];
    	$data['city']           = $info['city'];
    	$data['country']        = $info['country'];
    	$data['province']       = $info['province'];
    	$data['language']       = $info['language'];
    	$data['headimgurl']     = $info['headimgurl'];
    	$data['subscribe_time'] = $info['subscribe_time'];
    	$data['remark']         = $info['remark'];
    	$data['unionid']        = isset($info['unionid']) ? $info['unionid'] : '';
    	
    	$wechatuser_db->insert($data);
    }
    
	/**
	 * 取消关注时
	 * @param unknown $request
	 */
	public static function Unsubscribe_action($request) {
		$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		
		$uuid      = trim($_GET['uuid']);
		$account   = platform_account::make($uuid);
		$wechat_id = $account->getAccountID();
		$openid    = $request->getParameter('FromUserName');
		$rs        = $wechatuser_db->where(array('openid' => $openid,'wechat_id' => $wechat_id))->count();
		if ($rs > 0) {
			$wechatuser_db->where(array('openid' => $openid,'wechat_id' => $wechat_id))->update(array('subscribe' => 0));
		}
	}
	
	
	/**
	 * 客服消息接入会话的事件
	 * @param unknown $request
	 */
	public static function Kf_Create_Session_action($request) {
		$customer_log = RC_Loader::load_app_model('wechat_customer_log_model', 'wechat');
		
		$data['kf_account']    = $request->getParameter('KfAccount');
		$data['openid']        = $request->getParameter('ToUserName');
		$data['type']          = $request->getParameter('Event');
		$data['create_time']   = $request->getParameter('CreateTime');
		
		$customer_log->insert($data);
	}
	

	/**
	 * 客服消息关闭会话的事件
	 * @param unknown $request
	 */
	public static function Kf_Close_Session_action($request) {
		$customer_log = RC_Loader::load_app_model('wechat_customer_log_model', 'wechat');
		
		$data['kf_account']    = $request->getParameter('KfAccount');
		$data['openid']        = $request->getParameter('ToUserName');
		$data['type']          = $request->getParameter('Event');
		$data['create_time']   = $request->getParameter('CreateTime');
		
		$customer_log->insert($data);
	}
	

	/**
	 * 客服消息转接会话的事件
	 * @param unknown $request
	 */
	public static function Kf_Switch_Session_action($request) {
		$customer_log = RC_Loader::load_app_model('wechat_customer_log_model', 'wechat');
		
		$data['kf_account']    = $request->getParameter('FromKfAccount');
		$data['openid']        = $request->getParameter('ToUserName');
		$data['type']          = $request->getParameter('Event');
		$data['create_time']   = $request->getParameter('CreateTime');
		
		$customer_log->insert($data);
	}
	
	
	/**
	 * 群发发送成功之后推送的事件
	 * @param unknown $request
	 */
	public static function MassSendJobFinish_action($request) {
		$mass_history = RC_Loader::load_app_model('wechat_mass_history_model', 'wechat');
		$msgid = $request->getParameter('msgid');
		$data = array(
			$data['status']		= $request->getParameter('status'),
			$data['totalcount']	= $request->getParameter('totalcount'),
			$data['filtercount']= $request->getParameter('filtercount'),
			$data['sentcount']	= $request->getParameter('sentcount'),
			$data['errorcount']	= $request->getParameter('errorcount'),
		);
		$mass_history->where(array('msg_id' => $msgid))->update($data);
	}
}

// end