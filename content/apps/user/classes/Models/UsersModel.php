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
namespace Ecjia\App\User\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class Users
 */
class UsersModel extends Model
{
    protected $table = 'users';
    
    protected $primaryKey = 'user_id';
    
    public $timestamps = false;
    
    protected $fillable = [
        'aite_id',
        'email',
        'user_name',
        'nick_name',
        'password',
        'question',
        'answer',
        'sex',
        'birthday',
        'user_money',
        'frozen_money',
        'pay_points',
        'rank_points',
        'address_id',
        'reg_time',
        'last_login',
        'last_time',
        'last_ip',
        'visit_count',
        'user_rank',
        'is_special',
        'ec_salt',
        'salt',
        'drp_parent_id',
        'parent_id',
        'flag',
        'alias',
        'msn',
        'qq',
        'office_phone',
        'home_phone',
        'mobile_phone',
        'is_validated',
        'credit_line',
        'passwd_question',
        'passwd_answer',
        'user_picture',
        'old_user_picture',
        'report_time'
    ];
    
    protected $guarded = [];
    
    
    /**
     * @return mixed
     */
    public function getAiteId()
    {
        return $this->aite_id;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }
    
    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nick_name;
    }
    
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }
    
    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }
    
    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
    
    /**
     * @return mixed
     */
    public function getUserMoney()
    {
        return $this->user_money;
    }
    
    /**
     * @return mixed
     */
    public function getFrozenMoney()
    {
        return $this->frozen_money;
    }
    
    /**
     * @return mixed
     */
    public function getPayPoints()
    {
        return $this->pay_points;
    }
    
    /**
     * @return mixed
     */
    public function getRankPoints()
    {
        return $this->rank_points;
    }
    
    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }
    
    /**
     * @return mixed
     */
    public function getRegTime()
    {
        return $this->reg_time;
    }
    
    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }
    
    /**
     * @return mixed
     */
    public function getLastTime()
    {
        return $this->last_time;
    }
    
    /**
     * @return mixed
     */
    public function getLastIp()
    {
        return $this->last_ip;
    }
    
    /**
     * @return mixed
     */
    public function getVisitCount()
    {
        return $this->visit_count;
    }
    
    /**
     * @return mixed
     */
    public function getUserRank()
    {
        return $this->user_rank;
    }
    
    /**
     * @return mixed
     */
    public function getIsSpecial()
    {
        return $this->is_special;
    }
    
    /**
     * @return mixed
     */
    public function getEcSalt()
    {
        return $this->ec_salt;
    }
    
    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * @return mixed
     */
    public function getDrpParentId()
    {
        return $this->drp_parent_id;
    }
    
    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }
    
    /**
     * @return mixed
     */
    public function getFlag()
    {
        return $this->flag;
    }
    
    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * @return mixed
     */
    public function getMsn()
    {
        return $this->msn;
    }
    
    /**
     * @return mixed
     */
    public function getQq()
    {
        return $this->qq;
    }
    
    /**
     * @return mixed
     */
    public function getOfficePhone()
    {
        return $this->office_phone;
    }
    
    /**
     * @return mixed
     */
    public function getHomePhone()
    {
        return $this->home_phone;
    }
    
    /**
     * @return mixed
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }
    
    /**
     * @return mixed
     */
    public function getIsValidated()
    {
        return $this->is_validated;
    }
    
    /**
     * @return mixed
     */
    public function getCreditLine()
    {
        return $this->credit_line;
    }
    
    /**
     * @return mixed
     */
    public function getPasswdQuestion()
    {
        return $this->passwd_question;
    }
    
    /**
     * @return mixed
     */
    public function getPasswdAnswer()
    {
        return $this->passwd_answer;
    }
    
    /**
     * @return mixed
     */
    public function getUserPicture()
    {
        return $this->user_picture;
    }
    
    /**
     * @return mixed
     */
    public function getOldUserPicture()
    {
        return $this->old_user_picture;
    }
    
    /**
     * @return mixed
     */
    public function getReportTime()
    {
        return $this->report_time;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setAiteId($value)
    {
        $this->aite_id = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setEmail($value)
    {
        $this->email = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setUserName($value)
    {
        $this->user_name = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setNickName($value)
    {
        $this->nick_name = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        $this->password = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setQuestion($value)
    {
        $this->question = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setAnswer($value)
    {
        $this->answer = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setSex($value)
    {
        $this->sex = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setBirthday($value)
    {
        $this->birthday = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setUserMoney($value)
    {
        $this->user_money = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setFrozenMoney($value)
    {
        $this->frozen_money = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setPayPoints($value)
    {
        $this->pay_points = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setRankPoints($value)
    {
        $this->rank_points = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setAddressId($value)
    {
        $this->address_id = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setRegTime($value)
    {
        $this->reg_time = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setLastLogin($value)
    {
        $this->last_login = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setLastTime($value)
    {
        $this->last_time = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setLastIp($value)
    {
        $this->last_ip = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setVisitCount($value)
    {
        $this->visit_count = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setUserRank($value)
    {
        $this->user_rank = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setIsSpecial($value)
    {
        $this->is_special = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setEcSalt($value)
    {
        $this->ec_salt = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setSalt($value)
    {
        $this->salt = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setDrpParentId($value)
    {
        $this->drp_parent_id = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setParentId($value)
    {
        $this->parent_id = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setFlag($value)
    {
        $this->flag = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setAlias($value)
    {
        $this->alias = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setMsn($value)
    {
        $this->msn = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setQq($value)
    {
        $this->qq = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setOfficePhone($value)
    {
        $this->office_phone = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setHomePhone($value)
    {
        $this->home_phone = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setMobilePhone($value)
    {
        $this->mobile_phone = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setIsValidated($value)
    {
        $this->is_validated = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setCreditLine($value)
    {
        $this->credit_line = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setPasswdQuestion($value)
    {
        $this->passwd_question = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setPasswdAnswer($value)
    {
        $this->passwd_answer = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setUserPicture($value)
    {
        $this->user_picture = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setOldUserPicture($value)
    {
        $this->old_user_picture = $value;
        return $this;
    }
    
    /**
     * @param $value
     * @return $this
     */
    public function setReportTime($value)
    {
        $this->report_time = $value;
        return $this;
    }
    
    
    /**
     * 关联会员红包
     *
     * @access  public
     * @param  user_id
     * @return  array
     */
    public function getUserBonus(){
//         return $this->hasOne('App\Models\UserBonus', 'user_id', 'user_id');
    }
}
