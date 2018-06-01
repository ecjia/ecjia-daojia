<?php

namespace Ecjia\App\User\Integrate;


class EcjiaUser extends UserField
{
    
    public function __construct()
    {
        
        $this->user_table       = 'users';
        
        $this->field_id 		= 'user_id';
        
        $this->field_name 		= 'user_name';
        
        $this->field_pass 		= 'password';
        
        $this->field_email 		= 'email';
        
        $this->field_gender 	= 'sex';
        
        $this->field_birthday	= 'birthday';
    
        $this->field_reg_date 	= 'reg_time';
    }
    
}