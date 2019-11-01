<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/6/5 005
 * Time: 11:35
 */

namespace Ecjia\App\Affiliate;

use Ecjia\App\Affiliate\Models\AffiliateStoreModel;
use Ecjia\App\Affiliate\Models\AffiliateStoreRecordModel;
use RC_QrCode;
use RC_Uri;
use ecjia;

//代理商招募下级，推荐店铺
class AffiliateStore
{

    //获得代理商id
    public function getAgentIdByUserId($user_id) {
        return AffiliateStoreModel::where('user_id', $user_id)->value('id');
    }


    public function getAgentInfoByUserId($user_id) {
        return AffiliateStoreModel::where('user_id', $user_id)->first();
    }

    public function getAgentInfo($id) {
        return AffiliateStoreModel::where('id', $id)->first();
    }

    public function getParentAgentInfoByUserId($user_id) {
        $info = AffiliateStoreModel::where('user_id', $user_id)->first();
        if($info) {
            return AffiliateStoreModel::where('id', $info['agent_parent_id'])->first();
        } else {
            return [];
        }
    }

    //生成邀请代理商邀请码url
    public function generateInviteUrl($invite_code) {
        if (ecjia::config('mobile_touch_url') != '') {
            $invite_url = ecjia::config('mobile_touch_url') . 'index.php?m=affiliate&c=index&a=invite_agent&invite_code=' . $invite_code;
        } else {
            $invite_url = RC_Uri::site_url() . '/index.php?m=affiliate&c=index&a=invite_agent&invite_code=' . $invite_code;
        }

        return $invite_url;
    }

    //生成邀请代理商邀请码二维码
    public function generateInviteQrcode($code = '', $size = 430) {
        $img = RC_QrCode::format('png')->size($size)->margin(1)
            ->errorCorrection('L')
            ->generate($this->generateInviteUrl($code));

        return $img;
    }

    //生成邀请店铺入驻邀请码url
    public function generateInviteStoreUrl($invite_code) {
        if (ecjia::config('mobile_touch_url') != '') {
            $invite_url = ecjia::config('mobile_touch_url') . 'index.php?m=franchisee&c=index&a=first&invite_code=' . $invite_code;
        } else {
            $invite_url = RC_Uri::site_url() . '/index.php?m=franchisee&c=merchant&a=init&invite_code=' . $invite_code;
        }

        return $invite_url;
    }

    //生成邀请店铺入驻的邀请码二维码
    public function generateInviteStoreQrcode($code = '', $size = 430) {
        $img = RC_QrCode::format('png')->size($size)->margin(1)
            ->errorCorrection('L')
            ->generate($this->generateInviteStoreUrl($code));

        return $img;
    }


    //店铺入驻成功更新邀请记录
    public function updateAgentInviteWithNewStore($store_preaudit_id, $store_id) {
        if($store_preaudit_id && $store_id) {
            return AffiliateStoreRecordModel::where('store_preaudit_id', $store_preaudit_id)->update([
                'store_id' => $store_id,
                'store_preaudit_id' => null
            ]);
        }
    }

    //获得推荐人id-根据store_id
    public function getAffiliateStoreId($store_id) {
        return AffiliateStoreRecordModel::where('store_id', $store_id)->value('affiliate_store_id');
    }
}