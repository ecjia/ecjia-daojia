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
namespace Ecjia\App\User\Integrate;

use Ecjia\App\User\Integrate\Tables\EcjiaUserTable;
use RC_DB;

/**
 * 会员融合插件抽象类
 *
 * Class IntegrateAbstract
 * @package Ecjia\App\User\Integrate
 */
abstract class UserIntegrateDatabaseAbstract extends UserIntegrateAbstract
{

    protected $user_table;


    public function __construct()
    {
        $this->user_table = new EcjiaUserTable();

    }

    /**
     * 添加一个新用户
     *
     * @param $username
     * @param null $password
     * @param $email
     * @param int $gender
     * @param int $bday
     * @param int $reg_date
     * @param string $md5password
     * @return bool
     */
    public function addUser($username, $password, $email, $gender = -1, $bday = 0, $reg_date = 0, $md5password = null)
    {
        /* 将用户添加到整合方 */
        if ($this->checkUser($username) > 0) {
            $this->error = self::ERR_USERNAME_EXISTS;
            return false;
        }

        /* 检查email是否重复 */
        if ($this->checkEmail($email)) {
            $this->error = self::ERR_EMAIL_EXISTS;
            return false;
        }

        $post_username = $username;

        if ($md5password) {
            $post_password = $this->compilePassword(null, $md5password);
        } else {
            $post_password = $this->compilePassword($password);
        }

        $fields = array($this->user_table->getFieldName(), $this->user_table->getFieldEmail(), $this->user_table->getFieldPass());
        $values = array($post_username, $email, $post_password);

        if ($gender > -1) {
            $fields[] = $this->user_table->getFieldGender();
            $values[] = $gender;
        }

        if ($bday) {
            $fields[] = $this->user_table->getFieldBirthDay();
            $values[] = $bday;
        }

        if ($reg_date) {
            $fields[] = $this->user_table->getFieldRegDate();
            $values[] = $reg_date;
        }

        $data = array_combine($fields, $values);
        RC_DB::table($this->user_table->getUserTable())->insert($data);

        if ($this->need_sync) {
            $this->sync($username, $password);
        }

        return true;
    }

    /**
     * 编辑用户信息($password, $email, $gender, $bday)
     *
     * @param $username
     * @param null $password
     * @param $email
     * @param int $gender
     * @param int $bday
     * @param null $md5password
     * @return bool
     */
    public function editUser($username, $password, $email, $gender = -1, $bday = 0, $md5password = null)
    {
        $post_username = $username;

        $values = array();
        if (!empty($password) && empty($md5password)) {
            $md5password = md5($password);
        }

        if (!empty($md5password) && ! is_null($this->user_table->getFieldPass())) {
            $values[$this->user_table->getFieldPass()] = $this->compilePassword(null, $md5password);
        }

        if ((!empty($email)) && ! is_null($this->user_table->getFieldEmail())) {
            /* 检查email是否重复 */
            if ($this->checkEmail($email, $username) > 0) {
                $this->error = self::ERR_EMAIL_EXISTS;
                return false;
            }

            // 检查是否为新E-mail
            $count = $this->checkEmail($email);
            if (empty($count)) {
                // 新的E-mail，设置为未验证
                RC_DB::table($this->user_table)->where($this->user_table->getFieldName(), $username)->update(array('is_validated' => 0));
            }
            $values[$this->user_table->getFieldEmail()] = $email;
        }

        if (isset($gender) && ! is_null($this->user_table->getFieldGender())) {
            $values[$this->user_table->getFieldGender()] = $gender;
        }

        if ((!empty($bday)) && ! is_null($this->user_table->getFieldBirthDay())) {
            $values[$this->user_table->getFieldBirthDay()] = $bday;
        }

        if ($values) {
            RC_DB::table($this->user_table->getUserTable())->where($this->user_table->getFieldName(), $post_username)->update($values);

            if ($this->need_sync) {
                if (empty($md5password)) {
                    $this->sync($username);
                } else {
                    $this->sync($username, '', $md5password);
                }
            }
        }

        return true;
    }

    /**
     * 删除用户
     *
     * @param $username
     * @return
     */
    public function removeUser($username)
    {
        /* 如果需要同步或是ecjia插件执行这部分代码 */
        if ($this->need_sync || $this->getCode() == 'ecjia') {

            $this->syncRemoveUser($username);

        }

        if ($this->getCode() == 'ecjia')
        {
            /* 如果是ecshop插件直接退出 */
            return null;
        }

        //删除用户
        RC_DB::table($this->user_table->getUserTable())->where($this->user_table->getFieldName(), $username)->delete();

        return false;
    }

    /**
     * 检查指定用户是否存在及密码是否正确
     *
     * @param   string  $username   用户名
     * @return
     */
    public function checkUser($username, $password = null)
    {

        /* 如果没有定义密码则只检查用户名 */
        if ($password === null) {
            $user = RC_DB::table($this->user_table->getUserTable())
                ->where($this->user_table->getFieldName(), $username)
                ->pluck($this->user_table->getFieldId());

            return $user;
        } else {
            $password = $this->compilePassword($password);
            $user = RC_DB::table($this->user_table->getUserTable())
                ->where($this->user_table->getFieldName(), $username)
                ->where($this->user_table->getFieldPass(), $password)
                ->pluck($this->user_table->getFieldId());

            return $user;
        }

    }

    /**
     *  检查指定邮箱是否存在
     *
     * @param   string  $email   用户邮箱
     *
     * @return  boolean
     */
    public function checkEmail($email, $exclude_username = null)
    {
        if ($exclude_username) {
            /* 检查email是否重复，并排除指定的用户名 */
            $field_id = RC_DB::table($this->user_table->getUserTable())
                ->where($this->user_table->getFieldEmail(), $email)
                ->where($this->user_table->getFieldName(), $exclude_username)
                ->pluck($this->user_table->getFieldId());
        } else {
            /* 检查email是否重复 */
            $field_id = RC_DB::table($this->user_table->getUserTable())
                ->where($this->user_table->getFieldEmail(), $email)
                ->pluck($this->user_table->getFieldId());
        }

        if ($field_id > 0) {
            $this->error = self::ERR_EMAIL_EXISTS;
            return true;
        }
        return false;
    }

    /**
     *  获取指定用户的信息
     *
     * @param $username
     * @return array
     */
    public function getProfileByName($username)
    {
        $row = RC_DB::table($this->user_table->getUserTable())->selectRaw(
            $this->user_table->getFieldId() . ' AS `user_id`, ' .
            $this->user_table->getFieldName() . ' AS `user_name`, ' .
            $this->user_table->getFieldEmail() . ' AS `email`, ' .
            $this->user_table->getFieldGender() . ' AS `sex`, ' .
            $this->user_table->getFieldBirthDay() . ' AS `birthday`, ' .
            $this->user_table->getFieldRegDate() . ' AS `reg_time`, ' .
            $this->user_table->getFieldPass() . ' AS `password`'
        )->where($this->user_table->getFieldName(), $username)
            ->first();

        return $row;
    }

    /**
     *  获取指定用户的信息
     *
     * @param $id
     * @return array
     */
    public function getProfileById($id)
    {
        $row = RC_DB::table($this->user_table->getUserTable())->selectRaw(
            $this->user_table->getFieldId() . ' AS `user_id`, ' .
            $this->user_table->getFieldName() . ' AS `user_name`, ' .
            $this->user_table->getFieldEmail() . ' AS `email`, ' .
            $this->user_table->getFieldGender() . ' AS `sex`, ' .
            $this->user_table->getFieldBirthDay() . ' AS `birthday`, ' .
            $this->user_table->getFieldRegDate() . ' AS `reg_time`, ' .
            $this->user_table->getFieldPass() . ' AS `password`'
        )->where($this->user_table->getFieldId(), $id)
            ->first();

        return $row;
    }

    /**
     * 获取用户积分
     *
     * @param $username
     * @return bool
     */
    public function getPoints($username)
    {
        $credits = $this->getPointsName();
        $fileds = array_keys($credits);
        if ($fileds) {
            $row = RC_DB::table($this->user_table->getUserTable())
                ->select($this->user_table->getFieldId())
                ->selectRaw(implode(', ',$fileds))
                ->where($this->user_table->getFieldName(), $username)
                ->first();
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 设置用户积分
     *
     * @param $username
     * @param $credits
     * @return bool
     */
    public function setPoints($username, $credits)
    {
        $user_set = array_keys($credits);
        $points_set = array_keys($this->getPointsName());

        $set = array_intersect($user_set, $points_set);

        if ($set) {
            $tmp = array();
            foreach ($set as $credit) {
                $tmp[$credit] = $credit + $credits[$credit];
            }

            RC_DB::table($this->user_table->getUserTable())
                ->where($this->user_table->getFieldName(), $username)
                ->update($tmp);
        }

        return true;
    }

    /**
     * 检查有无重名用户，有则返回重名用户
     *
     * @param $user_list
     * @return null|array
     */
    public function testConflict($user_list)
    {
        if (empty($user_list)) {
            return array();
        }

        $user_list = RC_DB::table($this->user_table->getUserTable())
            ->select($this->user_table->getFieldName())
            ->whereIn($this->user_table->getFieldName(), $user_list)
            ->get();

        return $user_list;
    }
    
}