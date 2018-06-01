<?php

namespace Ecjia\App\User\Integrate;


class UserField
{
    /**
     * 整合对象会员表名
     * @var string
     */
    protected $user_table;
    
    /**
     * 会员ID的字段名
     * @var integer
     */
    protected $field_id;
    
    /**
     * 会员名称的字段名
     * @var string
     */
    protected $field_name;
    
    /**
     * 会员密码的字段名
     * @var string
     */
    protected $field_pass;
    
    /**
     * 会员邮箱的字段名
     * @var string
     */
    protected $field_email;
    
    /**
     * 会员性别
     * @var integer
     */
    protected $field_gender;
    
    /**
     * 会员生日
     * @var date
     */
    protected $field_birthday;
    
    /**
     * 注册日期的字段名
     * @var integer
     */
    protected $field_reg_date;
    
    
    
    public function getFieldId()
    {
        return $this->field_id;
    }
    
    
    public function getFieldName()
    {
        return $this->field_name;
    }
    
    
    public function getFieldPass()
    {
        return $this->field_pass;
    }
    
    
    public function getFieldEmail()
    {
        return $this->field_email();
    }
    
    
    public function getFieldBirthDay()
    {
        return $this->field_birthday;
    }
    
    
    public function getFieldRegDate()
    {
        return $this->field_reg_date;
    }
    
    
    
    
}