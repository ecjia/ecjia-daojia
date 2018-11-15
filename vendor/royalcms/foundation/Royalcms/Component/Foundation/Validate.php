<?php namespace Royalcms\Component\Foundation;
defined('IN_ROYALCMS') or exit('No permission resources.');

/**
 * 表单验证处理类
 */
class Validate extends RoyalcmsObject
{
    /* 验证错误信息 初始没有错误信息 */ 
    public $error = false; 
    /* 验证规则 数组形式 */ 
    private $rule; 
    
    /**
     * 不能为空
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @return string boolean
     */
    public function _nonull($name, $value, $msg)
    {
        if (empty($value) && $value !== 0) {
            return $msg;
        }
        return true;
    }

    /**
     * 验证是否为邮箱
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @return boolean string
     */
    public function _email($name, $value, $msg)
    {
        $preg = '/^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i';
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 最大长度（支持中文），如：maxlen:10
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _maxlen($name, $value, $msg, $arg)
    {
        if (! is_numeric($arg)) {
            rc_die('验证规则的maxlen参数必须为数字');
        }
        if (mb_strlen($value, 'utf-8') <= $arg) {
            return true;
        }
        return $msg;
    }

    /**
     * 最小长度（支持中文），如：minlen:10
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _minlen($name, $value, $msg, $arg)
    {
        if (! is_numeric($arg)) {
            rc_die('验证规则的minlen参数必须为数字');
        }
        if (mb_strlen($value, 'utf-8') >= $arg) {
            return true;
        }
        return $msg;
    }

    /**
     * 验证网址格式
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _http($name, $value, $msg, $arg)
    {
        $preg = '/^(http[s]?:)?(\/{2})?([a-z0-9]+\.)?[a-z0-9]+(\.(com|cn|cc|org|net|com.cn))$/i';
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 验证固定电话
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _tel($name, $value, $msg, $arg)
    {
        $preg = '/(?:\(\d{3,4}\)|\d{3,4}-?)\d{8}/';
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 验证手机
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _phone($name, $value, $msg, $arg)
    {
        $preg = '/^\d{11}$/';
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 身份证验证
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _identity($name, $value, $msg, $arg)
    {
        $preg = '/^(\d{15}|\d{18})$/';
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 用户名验证
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _user($name, $value, $msg, $arg)
    {
        $arg = explode(',', $arg);
        $startLen = $arg[0] - 1;
        $preg = '/^[a-zA-Z]\w{' . $startLen . ',' . $arg[1] . '}$/';
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 数字范围
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _num($name, $value, $msg, $arg)
    {
        $arg = explode(',', $arg);
        if ($value >= $arg[0] && $value <= $arg[1]) {
            return true;
        }
        return $msg;
    }

    /**
     * 自定义正则，如：gexp:/^\d{5,20}$/
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $preg            
     * @return boolean string
     */
    public function _regexp($name, $value, $msg, $preg)
    {
        if (preg_match($preg, $value)) {
            return true;
        }
        return $msg;
    }

    /**
     * 验证两个字段相等，如confirm:password2
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _confirm($name, $value, $msg, $arg)
    {
        if ($value == $_POST[$arg]) {
            return true;
        }
        return $msg;
    }

    /**
     * 验证中文
     *
     * @param string $name            
     * @param string $value            
     * @param string $msg            
     * @param string $arg            
     * @return boolean string
     */
    public function _chinese($name, $value, $msg, $arg)
    {
        if (preg_match('/^[\x{4e00}-\x{9fa5}a-z0-9]+$/ui', $value)) {
            return true;
        }
        return $msg;
    }
}

// end