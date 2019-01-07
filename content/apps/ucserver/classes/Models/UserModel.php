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

namespace Ecjia\App\Ucserver\Models;

use Royalcms\Component\Database\Eloquent\Model;
use Ecjia\App\Ucserver\Helper;
use RC_DB;
use RC_Ip;
use RC_Time;
use RC_Upload;
use RC_Storage;

class UserModel extends Model
{
    protected $table = 'users';
    
    protected $primaryKey = 'user_id';
    
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'user_name',
        'password',
        'avatar_img',
        'question',
        'answer',
        'sex',
        'birthday',
        'address_id',
        'reg_time',
        'last_login',
        'last_time',
        'last_ip',
        'visit_count',
        'user_rank',
        'is_special',
        'ec_salt',
        'parent_id',
        'flag',
        'alias',
        'mobile_phone',
        'is_validated',
    ];
    
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    public function check_username($username) 
    {
        $guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
        $len = Helper::dstrlen($username);
        if($len > 30 || $len < 3 || preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
            return false;
        } else {
            return true;
        }
    }
    
    public function check_usernameexists($username) 
    {
        return $this->getUserByUserName($username);
    }

    public function check_mergeuser($username)
    {
        return 0;
    }

    public function check_emailexists($email, $username = '')
    {
        $model = $this->where('email', $email);
        if ($username) {
            $model->where('username', '<>', $username);
        }

        $email = $model->pluck('email');

        return $email;
    }

    public function check_emailformat($email)
    {
        return strlen($email) > 6 && strlen($email) <= 60 && preg_match('/^([a-z0-9\-_.+]+)@([a-z0-9\-]+[.][a-z0-9\-.]+)$/', $email);
    }

    /**
     * 检查手机号的格式
     *
     * @param $mobile
     * @return mixed
     */
    public function checkMobielFormat($mobile)
    {
        return \Ecjia\App\Sms\Helper::check_mobile($mobile);
    }

    /**
     * 检查手机号是否存在，支持排除用户名
     *
     * @param string $mobile
     * @param string $username 排除用户名
     * @return mixed
     */
    public function checkMobileExists($mobile, $username = '')
    {
        $model = $this->where('mobile_phone', $mobile);
        if ($username) {
            $model->where('username', '<>', $username);
        }

        $mobile = $model->pluck('mobile_phone');

        return $mobile;
    }

    /**
     * 获取用户数据
     */
    public function getUserByUserId($id)
    {
        return optional($this->where('id', $id)->first())->toArray();
    }
    
    /**
     * 获取用户数据
     */
    public function getUserByUserName($username)
    {
        return optional($this->where('user_name', $username)->first())->toArray();
    }
    
    /**
     * 获取用户数据
     */
    public function getUserByMobile($mobile)
    {
        return optional($this->where('mobile_phone', $mobile)->first())->toArray();
    }
    
    /**
     * 获取用户数据
     */
    public function getUserByEmail($email)
    {
        return optional($this->where('email', $email)->first())->toArray();
    }


    /**
     * 检测用户是否可以登录
     *
     * @param $username
     * @param string $ip
     * @return int|mixed
     */
    public function canDoLogin($username, $ip = '')
    {

        $check_times = 5;

        $username = substr(md5($username), 8, 15);
        $expire = 15 * 60;
        if(!$ip) {
            //获取客户端IP
            $ip = RC_Ip::client_ip();
        }

        $ip_check = $user_check = array();

        $row = RC_DB::table('ucenter_failedlogins')->where('ip', $ip)->whereOr('ip', $username)->first();
        if (! empty($row)) {
            if($row['ip'] === $username) {
                $user_check = $row;
            } elseif($row['ip'] === $ip) {
                $ip_check = $row;
            }
        }

        if (empty($ip_check) || (SYS_TIME - $ip_check['lastupdate'] > $expire)) {
            $ip_check = array();
            RC_DB::insert("REPLACE INTO " . RC_DB::getTableFullName('ucenter_failedlogins'). " (`ip`, `count`, `lastupdate`) values('{$ip}', '0', ".SYS_TIME.")");
        }

        if (empty($user_check) || (SYS_TIME - $user_check['lastupdate'] > $expire)) {
            $user_check = array();
            RC_DB::insert("REPLACE INTO " . RC_DB::getTableFullName('ucenter_failedlogins'). " (`ip`, `count`, `lastupdate`) values('{$username}', '0', ".SYS_TIME.")");
        }

        if ($ip_check || $user_check) {
            $time_left = min(($check_times - $ip_check['count']), ($check_times - $user_check['count']));
            return $time_left;
        }

        RC_DB::table('ucenter_failedlogins')->where('lastupdate', '<', SYS_TIME - ($expire + 1))->delete();

        return $check_times;
    }


    public function loginfailed($username, $ip = '')
    {
        $username = substr(md5($username), 8, 15);
        if (!$ip) {
            $ip = RC_Ip::client_ip();
        }
        RC_DB::table('ucenter_failedlogins')->where('ip', $ip)->whereOr('ip', $username)->increment('count', 1, [
            'lastupdate' => SYS_TIME
        ]);
    }
    
    
//     public function check_login($username, $password, &$user) {
//         $user = $this->get_user_by_username($username);
//         if(empty($user['username'])) {
//             return -1;
//         } elseif($user['password'] != md5(md5($password).$user['salt'])) {
//             return -2;
//         }
//         return $user['uid'];
//     }

    /**
     * 添加用户
     *
     * @param $username
     * @param $password
     * @param $email
     * @param string $questionid
     * @param string $answer
     * @param string $regip
     * @return int
     */
    public function addUser($username, $password, $email, $questionid = '', $answer = '', $regip = '')
    {
        $regip      = empty($regip) ? RC_Ip::client_ip() : $regip;
        $salt       = substr(uniqid(rand()), -6);
        $password   = md5(md5($password).$salt);
        
        $data = [
        	'user_name' => $username,
            'password'  => $password,
            'email'     => $email,
            'last_ip'   => $regip,
            'reg_time'  => RC_Time::gmtime(),
            'ec_salt'   => $salt
        ];
        
        $model = $this->create($data);
        if ($model) {
            $uid = $model->user_id;
        } else {
            $uid = 0;
        }
        
        return $uid;
    }

    /**
     * 添加用户，用户名使用手机号
     *
     * @param string $username 手机号
     * @param string $password
     * @param string $email
     * @param string $questionid
     * @param string $answer
     * @param string $regip
     * @return int
     */
    public function addUserByMobile($mobile, $password, $email, $questionid = '', $answer = '', $regip = '')
    {
        $regip      = empty($regip) ? RC_Ip::client_ip() : $regip;
        $salt       = substr(uniqid(rand()), -6);
        $password   = md5(md5($password).$salt);

        $data = [
            'user_name'     => $mobile,
            'mobile_phone'  => $mobile,
            'password'      => $password,
            'email'         => $email,
            'last_ip'       => $regip,
            'reg_time'      => RC_Time::gmtime(),
            'ec_salt'       => $salt
        ];

        $model = $this->create($data);
        if ($model) {
            $uid = $model->user_id;
        } else {
            $uid = 0;
        }

        return $uid;
    }

    /**
     * 编辑用户
     *
     * @param $username
     * @param $oldpw
     * @param $newpw
     * @param $email
     * @param int $ignoreoldpw
     * @param string $questionid
     * @param string $answer
     * @return int
     */
    public function edit_user($username, $oldpw, $newpw, $email, $ignoreoldpw = 0, $questionid = '', $answer = '')
    {
        $data = $this->getUserByUserName($username);

        if ($ignoreoldpw) {
            $isprotected = RC_DB::table('ucenter_protectedmembers')->where('user_id', $data['user_id'])->count();
            if ($isprotected) {
                return -8;
            }
        }
        
        if (!$ignoreoldpw && $data['password'] != md5(md5($oldpw).$data['ec_salt'])) {
            return -1;
        }
        
        $newdata = [];
        if ($email) {
            $newdata['email'] = $email;
        }
        
        if ($newpw) {
            $newdata['password'] = md5(md5($newpw).$data['ec_salt']);
        }
        
        if (!empty($newdata)) {
            return $this->where('user_name', $username)->update($newdata);
        } else {
            return -7;
        }
    }

    /**
     *
     * @param int|array $uidsarr
     * @return int
     */
    public function delete_user($uidsarr) 
    {
        if (! is_array($uidsarr)) {
            $uidsarr = (array)$uidsarr;
        }

        if (!empty($uidsarr)) {
            return 0;
        }

        $puids = RC_DB::table('ucenter_protectedmembers')->whereIn('user_id', $uidsarr)->list('user_id');

        $uids = array_diff($uidsarr, $puids);

        if(! empty($uids)) {

            $result = $this->whereIn('user_id', $uids)->delete();

            $this->delete_useravatar($uidsarr);

            //@todo 发送删除其它节点请求

            return $result;
        }

        return 0;
    }


    public function delete_useravatar($uidsarr)
    {

        if (! is_array($uidsarr)) {
            $uidsarr = (array)$uidsarr;
        }

        if (!empty($uidsarr)) {
            return 0;
        }

        foreach ($uidsarr as $uid) {
            $user = $this->getUserByUserId($uid);

            $path = RC_Upload::upload_path($user['avatar_img']);
            if (RC_Storage::exists($path)) {
                RC_Storage::delete($path);
            }

            $this->where('user_id', $uid)->update(['avatar_img' => '']);
        }

        return 1;
    }



    
}

// end