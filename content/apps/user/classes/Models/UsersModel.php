<?php

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
