<?php

namespace Ecjia\App\Affiliate;

use RC_DB;

class UserInviteCode
{
    
    const OBJECT_TYPE = 'ecjia.affiliate';
    
    const OBJECT_GROUP = 'user_invite_code';
    
    const META_KEY = 'invite_code';
    
    /**
     * 添加邀请码code
     * @param integer $user_id
     * @param string $code
     */
    protected static function add($user_id, $code)
    {
        $data = [
        	'object_type'  => self::OBJECT_TYPE,
        	'object_group' => self::OBJECT_GROUP,
        	'object_id'    => $user_id,
        	'meta_key'     => self::META_KEY,
        	'meta_value'   => $code,
        ];
        
        RC_DB::table('term_meta')->insert($data);
    }
    
    /**
     * 生成邀请码并写入数据库
     * @param integer $user_id
     * @return string
     */
    protected static function makeCode($user_id)
    {
        while (true) {
            $charset     = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
            $code = rc_random(6, $charset);
    
            if (! self::checkDuplication($code)) {
                self::add($user_id, $code);
                break;
            }
        }
        return $code;
    }
    
    /**
     * 获取邀请码code
     * @param integer $user_id
     * @return string
     */
    public static function getCode($user_id)
    {
        $user_invite_code = RC_DB::table('term_meta')
                ->where('object_type',  self::OBJECT_TYPE)
                ->where('object_group', self::OBJECT_GROUP)
                ->where('object_id',    $user_id)
                ->where('meta_key',     self::META_KEY)
                ->value('meta_value');
        
        if (empty($user_invite_code)) {
            $user_invite_code = self::makeCode($user_id);
        }
        
        return $user_invite_code;
    }
    
    /**
     * 获取邀请码对应的用户ID
     * @param string $code
     * @return integer | null
     */
    public static function getUserId($code)
    {
        $user_id = RC_DB::table('term_meta')
                    ->where('object_type',  self::OBJECT_TYPE)
                    ->where('object_group', self::OBJECT_GROUP)
                    ->where('meta_key',     self::META_KEY)
                    ->where('meta_value',   $code)
                    ->value('object_id');
        return $user_id;
    }
    
    /**
     * 检查code是否重复
     */
    public static function checkDuplication($code)
    {
        /* 判断邀请码是否已存在*/
        $invite_result = RC_DB::table('term_meta')
                            ->where('object_type',  self::OBJECT_TYPE)
                            ->where('object_group', self::OBJECT_GROUP)
                            ->where('meta_key',     self::META_KEY)
                            ->where('meta_value', $code)
                            ->first();
        if (empty($invite_result)) {
            return false;
        }
        return true;
    }
    
    
}

// end