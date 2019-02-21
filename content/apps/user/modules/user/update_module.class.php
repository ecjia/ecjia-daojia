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

/**
 * 用户 头像上传
 * @author royalwang
 */
class user_update_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $user_id = $_SESSION['user_id'];
        if ($user_id <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        //判断用户有没申请注销
        $api_version = $this->request->header('api-version');
        if (version_compare($api_version, '1.25', '>=')) {
            $account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
            if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
                return new ecjia_error('account_status_error', __('当前账号已申请注销，不可执行此操作！', 'user'));
            }
        }

        $user_name = $this->requestData('user_name');
        $db        = RC_Model::model('user/users_model');
        if (isset($_FILES['avatar_img'])) {
            $save_path = 'data/avatar_img';
            $upload    = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));

            $image_info = $upload->upload($_FILES['avatar_img']);
            /* 判断是否上传成功 */
            if (!empty($image_info)) {
                $avatar_img     = $upload->get_position($image_info);
                $old_avatar_img = $db->where(array('user_id' => $_SESSION['user_id']))->get_field('avatar_img');
                if (!empty($old_avatar_img)) {
                    $upload->remove($old_avatar_img);
                }
                $db->where(array('user_id' => $_SESSION['user_id']))->update(array('avatar_img' => $avatar_img));
            } else {
                return new ecjia_error('avatar_img_error', __('头像上传失败！', 'user'));
            }

// 			$uid = $user_id;
// 			$userinfo = $db->field('user_name')->find(array('user_id' => $uid));

// 			$uid = abs(intval($uid));//保证uid为绝对的正整数

// 			$uid = sprintf("%09d", $uid);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0

// 			$dir1 = substr($uid, 0, 3);//把uid分段
// 			$dir2 = substr($uid, 3, 2);
// 			$dir3 = substr($uid, 5, 2);

// 			if (empty($userinfo)) {
// 				return new ecjia_error('user_error', __('用户信息错误！'));
// 			}

// 			$filename = md5($userinfo['user_name']);

// 			$path = RC_Upload::upload_path() . 'data' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $dir1 . DIRECTORY_SEPARATOR . $dir2 . DIRECTORY_SEPARATOR . $dir3;
// 			$filename_path = $path. DIRECTORY_SEPARATOR . substr($uid, -2)."_".$filename.'.jpg';

// 			//创建目录
// 			$result = RC_Filesystem::mkdir($path, 0777, true, true);

// 			//删除原有图片
// 			RC_Filesystem::delete($filename_path);

// 			@unlink($filename_path);//删除原有图片
// 			$img = base64_decode($img);
// 			file_put_contents($filename_path, $img);//返回的是字节数printr(a);
        }

        if (!empty($user_name)) {
            $user_exists = $db->where(array('user_id' => array('neq' => $_SESSION['user_id']), 'user_name' => $user_name))->find();
            if ($user_exists) {
                return new ecjia_error('user_name_exists', __('用户名已存在！', 'user'));
            } else {
                $data = array('object_type' => 'ecjia.user', 'object_group' => 'update_user_name', 'object_id' => $_SESSION['user_id'], 'meta_key' => 'update_time');

                /* 判断会员名更改时间*/
                $last_time  = RC_Model::model('term_meta_model')->find($data);
                $time       = RC_Time::gmtime();
                $limit_time = $last_time['meta_value'] + 2592000;
                if (empty($last_time) || $limit_time < $time) {
                    $db->where(array('user_id' => $_SESSION['user_id']))->update(array('user_name' => $user_name));
                    $_SESSION['user_name']   = $user_name;
                    $_SESSION['update_time'] = RC_Time::gmtime();
                    if (empty($last_time)) {
                        $data['meta_value'] = $time;
                        RC_Model::model('term_meta_model')->insert($data);
                    } else {
                        RC_Model::model('term_meta_model')->where($data)->update(array('meta_value' => $time));
                    }
                } else {
                    return new ecjia_error('not_repeat_update_username', __('30天内只允许修改一次会员名称！', 'user'));
                }

            }
        }

        RC_Loader::load_app_func('admin_user', 'user');
        $user_info = EM_user_info($_SESSION['user_id']);
        return $user_info;

    }
}

// end