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
 * ECJia 整合插件类的基类
 */
abstract class integrate_abstract
{

    /*------------------------------------------------------ */
    //-- PUBLIC ATTRIBUTEs
    /*------------------------------------------------------ */

    /* 整合对象使用的数据库主机 */
    public $db_host                 = '';

    /* 整合对象使用的数据库名 */
    public $db_name                 = '';

    /* 整合对象使用的数据库用户名 */
    public $db_user                 = '';

    /* 整合对象使用的数据库密码 */
    public $db_pass                 = '';

    /* 整合对象数据表前缀 */
    public $prefix                  = '';

    /* 数据库所使用编码 */
    public $charset                 = '';

    /* 整合对象使用的cookie的domain */
    public $cookie_domain           = '';

    /* 整合对象使用的cookie的path */
    public $cookie_path             = '/';

    /* 整合对象会员表名 */
    public $user_table              = '';

    /* 会员ID的字段名 */
    public $field_id                = '';

    /* 会员名称的字段名 */
    public $field_name              = '';

    /* 会员密码的字段名 */
    public $field_pass              = '';

    /* 会员邮箱的字段名 */
    public $field_email             = '';

    /* 会员性别 */
    public $field_gender            = '';

    /* 会员生日 */
    public $field_bday              = '';

    /* 注册日期的字段名 */
    public $field_reg_date          = '';

    /* 是否需要同步数据到商城 */
    public $need_sync               = true;

    public $error                   = 0;

    /*------------------------------------------------------ */
    //-- PRIVATE ATTRIBUTEs
    /*------------------------------------------------------ */

    protected $db;

    /*------------------------------------------------------ */
    //-- PUBLIC METHODs
    /*------------------------------------------------------ */
    
    /**
     * 会员数据整合插件类的构造函数
     *
     * @access      public
     * @param       string  $db_host    数据库主机
     * @param       string  $db_name    数据库名
     * @param       string  $db_user    数据库用户名
     * @param       string  $db_pass    数据库密码
     * @return      void
     */
    public function __construct($cfg)
    {
        RC_Loader::load_app_config('constant', 'user', false);
        
        $this->charset 			= isset($cfg['db_charset'])    ? $cfg['db_charset']       : 'UTF8';
        $this->prefix 			= isset($cfg['prefix'])        ? $cfg['prefix']           : '';
        $this->db_name 			= isset($cfg['db_name'])       ? $cfg['db_name']          : '';
        $this->cookie_domain 	= isset($cfg['cookie_domain']) ? $cfg['cookie_domain']    : '';
        $this->cookie_path 		= isset($cfg['cookie_path'])   ? $cfg['cookie_path']      : '/';
        $this->need_sync 		= true;
        $this->user_table       = 'users';

        $quiet = empty($cfg['quiet']) ? 0 : 1;

        /* 初始化数据库 */
        $this->db = RC_Model::model('user/'.$this->user_table . '_model');
        
    }

    /**
     *  用户登录函数
     *
     * @access  public
     * @param   string  $username
     * @param   string  $password
     *
     * @return void
     */
    public function login($username, $password, $remember = null)
    {
        if ($this->check_user($username, $password) > 0) {
            if ($this->need_sync) {
                $this->sync($username,$password);
            }
            $this->set_session($username);
            $this->set_cookie($username, $remember);

            return true;
        } else {
            return false;
        }
    }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function logout()
    {
        $this->set_cookie(); //清除cookie
        $this->set_session(); //清除session
    }

    /**
     *  添加一个新用户
     *
     * @access  public
     * @param
     *
     * @return int
     */
    public function add_user($username, $password, $email, $gender = -1, $bday = 0, $reg_date = 0, $md5password = '')
    {
    	/* 将用户添加到整合方 */
        if ($this->check_user($username) > 0) {
            $this->error = new ecjia_error('ERR_USERNAME_EXISTS', RC_Lang::get('user::users.username_exists'));
            return false;
        }
        
        /* 检查email是否重复 */
        $query = $this->db->field($this->field_id)->find(array($this->field_email => $email));
        if ($query[$this->field_id] > 0) {
            $this->error = new ecjia_error('ERR_EMAIL_EXISTS', RC_Lang::get('user::users.email_exists'));
            return false;
        }

        $post_username = $username;

        if ($md5password) {
            $post_password = $this->compile_password(array('md5password' => $md5password));
        } else {
            $post_password = $this->compile_password(array('password' => $password));
        }

        $fields = array($this->field_name, $this->field_email, $this->field_pass);
        $values = array($post_username, $email, $post_password);

        if ($gender > -1) {
            $fields[] = $this->field_gender;
            $values[] = $gender;
        }
        
        if ($bday) {
            $fields[] = $this->field_bday;
            $values[] = $bday;
        }
        
        if ($reg_date) {
            $fields[] = $this->field_reg_date;
            $values[] = $reg_date;
        }

        $data = array_combine($fields, $values);
        $this->db->insert($data);

        if ($this->need_sync) {
            $this->sync($username, $password);
        }

        return true;
    }

    /**
     *  编辑用户信息($password, $email, $gender, $bday)
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function edit_user($cfg)
    {
        if (empty($cfg['username'])) {
            return false;
        } else {
            $cfg['post_username'] = $cfg['username'];
        }

        $values = array();
        if (!empty($cfg['password']) && empty($cfg['md5password'])) {
            $cfg['md5password'] = md5($cfg['password']);
        }
        if ((!empty($cfg['md5password'])) && $this->field_pass != 'NULL') {
            $values[$this->field_pass] = $this->compile_password(array('md5password' => $cfg['md5password']));
        }

        if ((!empty($cfg['email'])) && $this->field_email != 'NULL') {
            /* 检查email是否重复 */
        	$query = $this->db->field($this->field_id)->find(array($this->field_email => $cfg['email'], $this->field_name => array('neq' => $cfg['post_username'])));
            if ($query[$this->field_id] > 0) {
                $this->error = ERR_EMAIL_EXISTS;
                return false;
            }
            // 检查是否为新E-mail
            $count = $this->db->where(array($this->field_email => $cfg['email']))->count();
            if ($count == 0) {
                // 新的E-mail
            	$this->db->where(array('user_name' => $cfg['post_username']))->update(array('is_validated' => 0));
            }
            $values[$this->field_email] = $cfg['email'];
        }

        if (isset($cfg['gender']) && $this->field_gender != 'NULL') {
            $values[$this->field_gender] = $cfg['gender'];
        }

        if ((!empty($cfg['bday'])) && $this->field_bday != 'NULL') {
            $values[$this->field_bday] = $cfg['bday'];
        }

        if ($values) {
        	$this->db->where(array($this->field_name => $cfg['post_username']))->update($values);

            if ($this->need_sync) {
                if (empty($cfg['md5password'])) {
                    $this->sync($cfg['username']);
                } else {
                    $this->sync($cfg['username'], '', $cfg['md5password']);
                }
            }
        }

        return true;
    }

    /**
     * 删除用户
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function remove_user($id)
    {
        $post_id = $id;
        
        $db_order_info      = RC_Model::model('orders/order_info_model');
        $db_order_goods     = RC_Model::model('orders/order_goods_model');
        $db_collect_goods   = RC_Model::model('goods/collect_goods_model');
        $db_user_address    = RC_Model::model('user/user_address_model');
        $db_user_bonus      = RC_Model::model('bonus/user_bonus_model');
        $db_user_account    = RC_Model::model('user/user_account_model');
        
        $db_account_log     = RC_Model::model('user/account_log_model');
        

        /* 如果需要同步或是ecjia插件执行这部分代码 */
        if ($this->need_sync || (isset($this->is_ecjia) && $this->is_ecjia)) {
            if (is_array($post_id)) {
            	$col = $this->db->in(array('user_id' => $post_id))->get_field('user_id', true);
            } else {
                $col = $this->db->field('user_id')->where(array('user_name' => $post_id))->find();
            }

            if ($col) {
            	
                //将删除用户的下级的parent_id 改为0
            	$this->db->in(array('parent_id' => $col))->update(array('parent_id' => 0));
            	//删除用户
            	$this->db->in(array('user_id' => $col))->delete();
                /* 删除用户订单 */
            	$col_order_id = $db_order_info->in(array('user_id' => $col))->get_field('order_id', true);
                if ($col_order_id) {
                	$db_order_info->in(array('order_id' => $col_order_id))->delete();
                	$db_order_goods->in(array('order_id' => $col_order_id))->delete();
                }

                //删除会员收藏商品
                $db_collect_goods->in(array('user_id' => $col))->delete();
                //删除用户留言
//                 $db_feedback->in(array('user_id' => $col))->delete();
                //删除用户地址
                $db_user_address->in(array('user_id' => $col))->delete();
                //删除用户红包
                $db_user_bonus->in(array('user_id' => $col))->delete();
                //删除用户帐号金额
                $db_user_account->in(array('user_id' => $col))->delete();
                //删除用户标记
//                 $db_tag->in(array('user_id' => $col))->delete();
                //删除用户日志
                $db_account_log->in(array('user_id' => $col))->delete();
                
                RC_Api::api('connect', 'connect_user_remove', array('user_id' => $col));
            }
        }
        
        /* 如果是ecjia插件直接退出 */
        if (isset($this->ecjia) && $this->ecjia) {
            return;
        }

        if (is_array($post_id)) {
            $this->db->in(array($this->field_id => $post_id))->delete();
        } else {
        	$this->db->where(array($this->field_name => $post_id))->delete();
        }
    }

    /**
     *  获取指定用户的信息
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_profile_by_name($username)
    {
        $row = $this->db->field("$this->field_id AS `user_id`, $this->field_name AS `user_name`, $this->field_email AS `email`, $this->field_gender AS `sex`, $this->field_bday AS `birthday`, $this->field_reg_date AS `reg_time`, $this->field_pass AS `password`")->find(array($this->field_name => $username));
        return $row;
    }

    /**
     *  获取指定用户的信息
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_profile_by_id($id)
    {
    	$row = $this->db->field("$this->field_id AS `user_id`, $this->field_name AS `user_name`, $this->field_email AS `email`, $this->field_gender AS `sex`, $this->field_bday AS `birthday`, $this->field_reg_date AS `reg_time`, $this->field_pass AS `password`, `passwd_question`")->find(array($this->field_id => $id));
        return $row;
    }

    /**
     *  根据登录状态设置cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_cookie()
    {
        $id = $this->check_cookie();
        if ($id) {
            if ($this->need_sync) {
                $this->sync($id);
            }
            $this->set_session($id);
            return true;
        } else {
            return false;
        }
    }

    /**
     *  检查指定用户是否存在及密码是否正确
     *
     * @access  public
     * @param   string  $username   用户名
     *
     * @return  int
     */
    public function check_user($username, $password = null)
    {
        $post_username = $username;

        /* 如果没有定义密码则只检查用户名 */
        if ($password === null) {
        	return $this->db->field($this->field_id)->find(array($this->field_name => $post_username));
        } else {
        	return $this->db->field($this->field_id)->find(array($this->field_name => $post_username, $this->field_pass => $this->compile_password(array('password' => $password))));
        }
    }

    /**
     *  检查指定邮箱是否存在
     *
     * @access  public
     * @param   string  $email   用户邮箱
     *
     * @return  boolean
     */
    public function check_email($email)
    {
        if (!empty($email)) {
            /* 检查email是否重复 */
            $result = $this->db->field($this->field_id)->find(array($this->field_email => $email));
	        if($result[$this->field_id] > 0) {
                $this->error = ERR_EMAIL_EXISTS;
                return true;
            }
            return false;
        }
    }


    /**
     *  检查cookie是正确，返回用户名
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function check_cookie()
    {
        return '';
    }

    /**
     *  设置cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function set_cookie($username = '', $remember = null )
    {
    	if (empty($username)) {
            /* 摧毁cookie */
            $time = time() - 3600;
            setcookie("ECJIA[user_id]",  '', $time, $this->cookie_path);            
            setcookie("ECJIA[password]", '', $time, $this->cookie_path);

        } elseif ($remember) {
            /* 设置cookie */
            $time = time() + 3600 * 24 * 15;
            setcookie("ECJIA[username]", $username, $time, $this->cookie_path, $this->cookie_domain);
            
            $row = $this->db->field('user_id, password')->find(array('user_name' => $username));
            if ($row) {
                setcookie("ECJIA[user_id]", $row['user_id'], $time, $this->cookie_path, $this->cookie_domain);
                setcookie("ECJIA[password]", $row['password'], $time, $this->cookie_path, $this->cookie_domain);
            }
        }
    }

    /**
     *  设置指定用户SESSION
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function set_session ($username='')
    {
        if (empty($username)) {
            RC_Session::destroy();
        } else {
        	$row = $this->db->field('user_id, password, email')->find(array('user_name' => $username));
            if ($row) {
                $_SESSION['user_id']   = $row['user_id'];
                $_SESSION['user_name'] = $username;
                $_SESSION['email']     = $row['email'];
            }
        }
    }


    /**
     * 在给定的表名前加上数据库名以及前缀
     *
     * @access  private
     * @param   string      $str    表名
     *
     * @return void
     */
    public function table($str)
    {
        return '`' .$this->db_name. '`.`'.$this->prefix.$str.'`';
    }

    /**
     *  编译密码函数
     *
     * @access  public
     * @param   array   $cfg 包含参数为 $password, $md5password, $salt, $type
     *
     * @return void
     */
    public function compile_password ($cfg)
    {
        if (isset($cfg['password'])) {
            $cfg['md5password'] = md5($cfg['password']);
        }
       
        if (empty($cfg['type'])) {
            $cfg['type'] = PWD_MD5;
        }

        $password = '';
        switch ($cfg['type']) {
            case PWD_MD5 :
                if (!empty($cfg['ec_salt'])) {
                    $password = md5($cfg['md5password'] . $cfg['ec_salt']);
                } else {
                    $password = $cfg['md5password'];
                }
                break;
            case PWD_PRE_SALT :
                if (empty($cfg['salt'])) {
                    $cfg['salt'] = '';
                }
                
                $password = md5($cfg['salt'] . $cfg['md5password']);
                break;
                
           case PWD_SUF_SALT :
                if (empty($cfg['salt'])) {
                    $cfg['salt'] = '';
                }

                $password = md5($cfg['md5password'] . $cfg['salt']);
                break;
           default:
               break;
       }
       
       return $password;
    }

    /**
     *  会员同步
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function sync ($username, $password='', $md5password='')
    {
    	
        if ((!empty($password)) && empty($md5password)) {
            $md5password = md5($password);
        }

        $main_profile = $this->get_profile_by_name($username);

        if (empty($main_profile)) {
            return false;
        }

        $profile = $this->db->field('user_name, email, password, sex, birthday')->find(array('user_name' => $username));
        if (empty($profile)) {
            /* 向用户表插入一条新记录 */
            if (empty($md5password)) {
            	$data = array(
            		'user_name'  => $username,
            		'email'      => $main_profile['email'],
            		'sex'        => $main_profile['sex'],
            		'birthday'   => $main_profile['birthday'] ,
            		'reg_time'   => $main_profile['reg_time'],
            	);
            	$this->db->insert($data);
            } else {
            	$data = array(
            		'user_name'  => $username,
            		'email'      => $main_profile['email'],
            		'sex'        => $main_profile['sex'],
            		'birthday'   => $main_profile['birthday'] ,
            		'reg_time'   => $main_profile['reg_time'],
            		'password'   => $md5password
            	);
            	$this->db->insert($data);

            }
            return true;
        } else {
            $values = array();
            if ($main_profile['email'] != $profile['email']) {
                $values['email'] = $main_profile['email'];
            }
            
            if ($main_profile['sex'] != $profile['sex']) {
                $values['sex'] = $main_profile['sex'];
            }
            
            if ($main_profile['birthday'] != $profile['birthday']) {
                $values['birthday'] = $main_profile['birthday'];
            }
            
            if ((!empty($md5password)) && ($md5password != $profile['password'])) {
                $values['password'] = $md5password;
            }

            if (empty($values)) {
                return  true;
            } else {
                $this->db->where(array('user_name' => $username))->update($values);
                return true;
            }
        }
    }

    /**
     *  获取论坛有效积分及单位
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_points_name ()
    {
        return array();
    }

    /**
     *  获取用户积分
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_points($username)
    {
        $credits = $this->get_points_name();
        $fileds = array_keys($credits);
        if ($fileds) {
        	$row = $this->db->field($this->field_id, implode(', ',$fileds))->find(array($this->field_name => $username));
            return $row;
        } else {
            return false;
        }
    }

    /**
     *设置用户积分
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function set_points ($username, $credits)
    {
        $user_set = array_keys($credits);
        $points_set = array_keys($this->get_points_name());

        $set = array_intersect($user_set, $points_set);

        if ($set) {
            $tmp = array();
            foreach ($set as $credit) {
               $tmp[$credit] = $credit + $credits[$credit];
            }
            $this->db->where(array($this->field_name => $username))->update($tmp);
        }

        return true;
    }

    public function get_user_info($username)
    {
        return $this->get_profile_by_name($username);
    }


    /**
     * 检查有无重名用户，有则返回重名用户
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function test_conflict ($user_list)
    {
        if (empty($user_list)) {
            return array();
        }
        
        $user_list = $this->db->field($this->field_name)->in(array($this->field_name => $user_list))->select();
        return $user_list;
    }
}

// end