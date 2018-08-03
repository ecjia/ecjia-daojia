<?php

namespace Ecjia\App\Wechat\Maintains;

use Ecjia\App\Maintain\AbstractCommand;
use RC_DB;

class WechatUserAvatarChangeHTTPS extends AbstractCommand
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'wechat_user_avatar_change_https';
    
    /**
     * 名称
     * @var string
     */
    protected $name = '微信粉丝用户头像更换HTTPS';
    
    /**
     * 描述
     * @var string
     */
    protected $description = '一键将微信粉丝用户头像使用HTTP地址更换为HTTPS地址';
    
    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';


    /**
     * 一键将微信粉丝用户头像使用HTTP地址更换为HTTPS地址
     *
     * @return bool
     */
    public function run() {
        

        RC_DB::table('wechat_user')->where('headimgurl', 'like', 'http://%')->update([ 'headimgurl' => RC_DB::raw('REPLACE(headimgurl, "http://", "https://")') ] );
        
        return true;
    }
    
}

// end