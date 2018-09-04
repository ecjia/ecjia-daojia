<?php namespace Royalcms\Component\Model;

use Royalcms\Component\Model\Database\DatabaseFactory;

/**
 * 数据模型基类
 */

class Model
{

    protected $db_config = array(); // 数据库配置
    protected $db = null; // 数据库连接
    protected $db_setting = null; // 调用数据库的配置项
    protected $table_name = null; // 数据表带前缀的表名
    protected $table_short_name = null; // 数据表名
    protected $table_full_name = null; // 数据表带数据库带前缀的表名
    public $db_tablepre = null; // 表前缀
    public $error = null; // 验证不通过的错误信息
    public $trigger = true; // 触发器,开启时执行__after_delete等方法
    public $join_table = array(); // 要关联的表
    public $data = array(); // 增、改操作数据
    public $validate = array(); // 验证规则
    public $auto = array(); // 自动完成
    public $map = array(); // 字段映射
    
    public function __construct()
    {
        if (empty($this->db_config)) {
            $this->db_config = \RC_Config::get('database.connections');
        }
        
        if (! $this->db_setting || ! isset($this->db_config[$this->db_setting])) {
            $this->db_setting = \RC_Config::get('database.default');
        }
        
        $this->db_tablepre = $this->db_config[$this->db_setting]['prefix'];
        
        if (! empty($this->table_name)) {
            $this->table_short_name = $this->table_name;
            $this->table_name = $this->db_tablepre . $this->table_name;
            $this->table_full_name = '`' . $this->db_config[$this->db_setting]['database'] . '`.' . $this->table_name;
        }
        
        $this->db = DatabaseFactory::get_instance($this->db_config)->get_database($this->db_setting, $this->table_name);
    }

    /**
     * 魔术方法 设置模型属性如表名字段名
     *
     * @param string $var
     *            属性名
     * @param mixed $value
     *            值
     */
    public function __set($var, $value)
    {
        // 如果为模型方法时，执行模型方法如 $this->where="id=1"
        $_var = strtolower($var);
        $property = array_keys($this->db->opt);
        if (in_array($_var, $property)) {
            $this->$_var($value);
        } else {
            $this->data[$var] = $value;
        }
    }

    /**
     * 获得$this->data值
     *
     * @param unknown $name            
     * @return Ambigous <NULL, multitype:>
     */
    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * ============================== 自动处理开始 ==========================
     */
    
    /**
     * 执行自动映射、自动验证、自动完成
     *
     * @param array $data
     *            如果为空使用$_POST
     * @return bool
     */
    public function create($data = array())
    {
        // 验证令牌
        if (! $this->token()) {
            return false;
        }
        // 获得数据
        $this->data($data);
        // 自动验证
        if (! $this->validate()) {
            return false;
        }
        // 自动完成
        $this->auto();
        // 字段映射
        $this->map();
        
        return $this;
    }

    /**
     * 验证令牌
     */
    public function token()
    {
        // TODO: 未实现
        $token_on = \RC_Config::get('system.token_on');
        $token_name = \RC_Config::get('system.token_name');
        if ($token_on || isset($_POST[$token_name]) || isset($_GET[$token_name])) {
            // RC_Loader::load_core_class('RC.RCToken', false);
            if (! \RC_Token::check()) {
                $this->error = '表单令牌错误';
                return false;
            }
        }
        return true;
    }

    /**
     * 获得添加、插入数据
     *
     * @param array $data
     *            void
     * @return array null
     */
    public function data($data = array())
    {
        if (is_array($data) && ! empty($data)) {
            $this->data = $data;
        } else 
            if (empty($this->data)) {
                $this->data = $_POST;
            }
        
        foreach ($this->data as $key => $val) {
            if (MAGIC_QUOTES_GPC && is_string($val)) {
                $this->data[$key] = stripslashes($val);
            }
        }
        return $this;
    }

    /**
     * 字段验证
     */
    public function validate($data = array())
    {
        $this->data($data);
        // 当前方法
        $current_method = $this->current_method();
        $_data = & $this->data;
        if (! is_array($this->validate) || empty($this->validate)) {
            return true;
        }
        foreach ($this->validate as $v) {
            // 验证的表单名称
            $name = $v[0];
            // 验证时机
            // 1、插入时验证
            // 2、更新时验证
            // 3、插入与更新都验证
            $action = isset($v[4]) ? $v[4] : 3;
            // 当前时机（插入、更新）不需要验证
            if (! in_array($action, array(
                $current_method,
                3
            ))) {
                continue;
            }
            
            // 1、为默认验证方式
            // 2、有POST这个变量就验证
            $condition = isset($v[3]) ? $v[3] : 1;
            // 错误提示
            $msg = $v[2];
            switch ($condition) {
                // 有POST这个变量就验证
                case 1:
                    if (! isset($_data[$name])) {
                        continue 2;
                    }
                    break;
                
                // 必须验证
                case 2:
                    if (! isset($_data[$name])) {
                        $this->error = $msg;
                        return false;
                    }
                    break;
                
                // 不为空验证
                case 3:
                    if (! isset($_data[$name]) || empty($_data[$name])) {
                        continue 2;
                    }
                    break;
            }
            
            $method = explode(":", $v[1]);
            $func = $method[0];
            $args = isset($method[1]) ? str_replace(" ", '', $method[1]) : '';
            if (method_exists($this, $func)) {
                $res = call_user_func_array(array(
                    $this,
                    $func
                ), array(
                    $name,
                    $_data[$name],
                    $msg,
                    $args
                ));
                if ($res === true) {
                    continue;
                }
                $this->error = $res;
                return false;
            } else 
                if (function_exists($func)) {
                    $res = $func($name, $_data[$name], $msg, $args);
                    if ($res === true) {
                        continue;
                    }
                    $this->error = $res;
                    return false;
                } else {
                    // TODO: validate方法未完成
                    $validate = new \Royalcms\Component\Foundation\Validate();
                    $func = '_' . $func;
                    if (method_exists($validate, $func)) {
                        $res = call_user_func_array(array(
                            $validate,
                            $func
                        ), array(
                            $name,
                            $_data[$name],
                            $msg,
                            $args
                        ));
                        if ($res === true) {
                            continue;
                        }
                        $this->error = $res;
                        return false;
                    }
                }
        }
        
        return true;
    }

    /**
     * 自动完成
     *
     * @param array $data            
     */
    public function auto($data = array())
    {
        $this->data($data);
        $_data = & $this->data;
        $motion = $this->current_method();
        foreach ($this->auto as $v) {
            // 1、插入时处理
            // 2、更新时处理
            // 3、插入与更新都处理
            $type = isset($v[4]) ? $v[4] : 3;
            // 1、是否处理
            // 2、更新或插入
            if ($motion != $type && $type != 3) {
                continue;
            }
            // 验证的表单名称
            $name = $v[0];
            // 函数或方法
            $action = $v[1];
            // 时间：
            // 1、有这个表单项就处理
            // 2、必须处理的表单项
            // 3、如果表单不为空才处理
            $condition = isset($v[3]) ? $v[3] : 1;
            switch ($condition) {
                // 有POST这个变量就处理
                case 1:
                    if (! isset($_data[$name])) {
                        continue 2;
                    }
                    break;
                
                // 必须处理
                case 2:
                    if (! isset($_data[$name])) {
                        $_data[$name] = '';
                    }
                    break;
                
                // 不为空验证
                case 3:
                    if (empty($_data[$name])) {
                        continue 2;
                    }
                    break;
            }
            
            // 处理类型
            // function 函数
            // method 模型方法
            // string 字符串
            $handle = isset($v[2]) ? $v[2] : "string";
            $_data[$name] = isset($_data[$name]) ? $_data[$name] : null;
            switch (strtolower($handle)) {
                case "function":
                    if (function_exists($action)) {
                        $_data[$name] = $action($data[$name]);
                    }
                    break;
                
                case "method":
                    if (method_exists($this, $action)) {
                        $_data[$name] = $this->$action($_data[$name]);
                    }
                    break;
                
                case "string":
                    $_data[$name] = $action;
                    break;
            }
        }
        
        return true;
    }

    /**
     * 字段映射
     */
    protected function map()
    {
        if (empty($this->map)) {
            return;
        }
        
        $this->data();
        
        foreach ($this->map as $k => $v) {
            // 处理POST
            if (isset($this->data[$k])) {
                $this->data[$v] = $this->data[$k];
                unset($this->data[$k]);
            }
        }
    }

    /**
     * 当前操作的方法
     *
     * @return number
     */
    private function current_method()
    {
        // 1、插入
        // 2、更新
        return isset($this->data[$this->db->primary]) ? 2 : 1;
    }

    /**
     * 返回模型错误
     *
     * @param $error 错误信息            
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * ============================== 自动处理结束 ==========================
     */
    
    /**
     * 设置关联模型
     *
     * @param string $table            
     */
    public function join($table = false)
    {
        if (! $table) {
            $this->join_table = false;
        } else 
            if (is_string($table)) {
                $this->join_table = explode(",", $table);
            } else 
                if (is_array($table)) {
                    $this->join_table = $table;
                }
        
        return $this;
    }

    /**
     * 临时更改操作表
     *
     * @param string $table
     *            表名
     * @param bool $full
     *            是否带表前缀
     * @return $this
     */
    public function table($table, $full = false)
    {
        if ($full !== true) {
            $table = $this->db_tablepre . $table;
        }
        
        $this->db->table($table);
        $this->join(false);
        $this->trigger(false);
        return $this;
    }

    /**
     * =========================== 查询语句 =====================
     */
    
    /**
     * 设置字段
     * 示例：$Db->field("username,age")->limit(6)->all();
     */
    public function field($field = array(), $check = true)
    {
        if (empty($field)) {
            return $this;
        }
        $this->db->field($field, $check);
        return $this;
    }

    /**
     * 执行查询操作结果不缓存
     * 示例：$Db->Cache(30)->all();
     */
    public function cache($time = -1)
    {
        $this->db->cache($time);
        return $this;
    }

    /**
     * SQL中的LIKE规则
     *
     * @param array $arg            
     * @return model
     */
    public function like($arg = array())
    {
        if (empty($arg)) {
            return $this;
        }
        
        $this->db->like($arg);
        return $this;
    }

    /**
     * GROUP语句定义
     *
     * @param array $arg            
     */
    public function group($arg = array())
    {
        if (empty($arg)) {
            return $this;
        }
        
        $this->db->group($arg);
        return $this;
    }

    /**
     * HAVING语句定义
     *
     * @param array $arg            
     */
    public function having($arg = array())
    {
        if (empty($arg)) {
            return $this;
        }
        
        $this->db->having($arg);
        return $this;
    }

    /**
     * ORDER 语句定义
     * 示例：$Db->order("id desc")->all();
     */
    public function order($arg = array())
    {
        if (empty($arg)) {
            return $this;
        }
        
        $this->db->order($arg);
        return $this;
    }

    /**
     * IN 语句定义
     * 示例：$db->in(1,2,3)->select();
     */
    public function in($arg = array(), $is_not_in = false)
    {
        if (empty($arg)) {
            return $this;
        }
        
        $this->db->in($arg, $is_not_in);
        return $this;
    }

    /**
     * 删除记录
     * 示例：$db->delete("uid=1");
     */
    public function delete($data = array())
    {
        $trigger = $this->trigger;
        $this->trigger = true;
        
        $trigger and $this->__before_delete($data);
        $result = $this->db->delete($data);
        
        $this->error = $this->db->error;
        $trigger and $this->__after_delete($result);
        return $result;
    }

    /**
     * 慎用 会删除表中所有数据
     * $db->clear();
     */
    public function clear($data = array())
    {
        $this->where("1=1");
        return $this->delete($data);
    }

    /**
     * 执行一个SQL语句 有返回值
     * 示例：$db->query("select title,click,addtime from news where uid=18");
     */
    public function query($data = array())
    {
        return $this->db->query($data);
    }

    /**
     * 执行一个SQL语句 没有有返回值
     * 示例：$db->execute("delete from news where id=16");
     */
    public function execute($sql)
    {
        return $this->db->execute($sql);
    }

    /**
     * LIMIT 语句定义
     * 示例：$db->limit(10)->select("sex=1");
     */
    public function limit($start = null, $end = null)
    {
        if (is_null($start)) {
            return $this;
        } else 
            if (! is_null($end)) {
                $limit = $start . "," . $end;
            } else {
                $limit = $start;
            }
        
        $this->db->limit($limit);
        
        return $this;
    }

    /**
     * 查找满足条件的一条记录
     * 示例：$db->find("id=188")
     */
    public function find($data = array())
    {
        $this->limit(1);
        $result = $this->select($data);
        
        return is_array($result) && isset($result[0]) ? $result[0] : $result;
    }

    /**
     * 查找满足条件的所有记录
     * 示例：$db->select("age>20")
     */
    public function select($args = array())
    {
        $trigger = $this->trigger;
        $this->trigger = true;
        
        $trigger and $this->__before_select($args);
        $result = $this->db->select($args);
        
        $trigger and $this->__after_select($result);
        $this->error = $this->db->error;
        
        return $result;
    }

    /**
     * SQL中的WHERE规则
     * 示例：$db->where("username like '%PHP%')->count();
     */
    public function where($args = array())
    {
        if (! empty($args)) {
            $this->db->where($args);
        }
        return $this;
    }

    /**
     * 查找满足条件的所有记录(一维数组)
     * 示例：$db->get_field("username")
     */
    public function get_field($field, $return_all = false)
    {
        // 设置字段
        $this->field($field);
        $result = $this->select();
        
        if ($result) {
            // 字段数组
            $field = explode(',', preg_replace('@\s@', '', $field));
            // 如果有多个字段时，返回多维数组并且第一字段值做为KEY使用
            if (count($field) > 1) {
                $data = array();
                foreach ($result as $v) {
                    $data[$v[$field[0]]] = $v;
                }
                return $data;
            } else 
                if ($return_all) {
                    // 只有一个字段，且返回多条记录
                    $data = array();
                    foreach ($result as $v) {
                        if (isset($v[$field[0]])) {
                            $data[] = $v[$field[0]];
                        }
                    }
                    return $data;
                } else {
                    // 只有一个字段，且返回一条记录
                    return current($result[0]);
                }
        } else {
            return null;
        }
    }

    /**
     * ======================= 插入或更新语句 ====================
     */
    
    /**
     * 插入数据
     *
     * @param unknown $data            
     * @param string $type            
     */
    public function insert($data = array(), $type = "INSERT")
    {
        $this->data($data);
        $data = $this->data;
        $this->data = array();
        
        $trigger = $this->trigger;
        $this->trigger = true;
        $trigger and $this->__before_insert($data);
        
        $result = $this->db->insert($data, $type);
        $this->error = $this->db->error;
        $trigger and $this->__after_insert($result);
        
        return $result;
    }

    /**
     * 批量插入数据
     *
     * @param unknown $data            
     * @param string $type            
     * @return Ambigous <NULL, multitype:NULL >
     */
    public function batch_insert($data, $type = "INSERT")
    {
        $id = array();
        if (is_array($data) && ! empty($data)) {
            foreach ($data as $d) {
                if (is_array($d)) {
                    $id[] = $this->insert($d, $type);
                }
            }
        }
        
        return empty($id) ? null : $id;
    }

    /**
     * replace INTO方式插入数据
     *
     * @param unknown $data            
     */
    public function replace($data = array())
    {
        return $this->insert($data, "REPLACE");
    }

    /**
     * INSERT IGNORE INTO方式插入数据
     *
     * @param unknown $data            
     */
    public function insert_ignore($data = array())
    {
        return $this->insert($data, "INSERT IGNORE");
    }

    /**
     * 插入数据失败时自动转为更新数据
     *
     * @param array $field_values            
     * @param array $update_values            
     * @return Ambigous <boolean, number>|boolean
     */
    public function auto_replace($field_values, $update_values)
    {
        return $this->db->auto_replace($field_values, $update_values);
    }

    /**
     * 更新数据
     *
     * @param unknown $data            
     */
    public function update($data = array())
    {
        $this->data($data);
        $data = $this->data;
        
        $this->data = array();
        $trigger = $this->trigger;
        $this->trigger = true;
        
        $trigger and $this->__before_update($data);
        if (empty($data)) {
            // TODO: 语言包整理
            $this->error = "没有任何数据用于UPDATE！";
            return false;
        }
        
        $this->error = $this->db->error;
        $result = $this->db->update($data);
        $trigger and $this->__after_update($result);
        
        return $result;
    }

    /**
     * 统计
     *
     * @param array $args            
     */
    public function count($args = array())
    {
        $result = $this->db->count($args);
        return $result;
    }

    /**
     * 求最大值
     *
     * @param unknown $args            
     */
    public function max($args = array())
    {
        $result = $this->db->max($args);
        return $result;
    }

    /**
     * 求最小值
     *
     * @param unknown $args            
     */
    public function min($args = array())
    {
        $result = $this->db->min($args);
        return $result;
    }

    /**
     * 求平均值
     *
     * @param unknown $args            
     */
    public function avg($args = array())
    {
        $result = $this->db->avg($args);
        return $result;
    }

    /**
     * SQL中的SUM计算
     *
     * @param unknown $args            
     */
    public function sum($args = array())
    {
        $result = $this->db->sum($args);
        return $result;
    }

    /**
     * 字段值增加
     * 示例：$Db->dec("price","id=20",188)
     * 将id为20的记录的price字段值增加188
     *
     * @param $field 字段名            
     * @param $where 条件            
     * @param int $step
     *            增加数
     * @return mixed
     */
    public function inc($field, $where, $step = 1)
    {
        $sql = 'UPDATE ' . $this->db->opt['table'] . ' SET ' . $field . '=' . $field . '+' . $step . ' WHERE ' . $where;
        return $this->execute($sql);
    }

    /**
     * 减少字段值
     *
     * @param unknown $field            
     * @param unknown $where            
     * @param number $step            
     */
    public function dec($field, $where, $step = 1)
    {
        $sql = 'UPDATE ' . $this->db->opt['table'] . ' SET ' . $field . '=' . $field . '-' . $step . ' WHERE ' . $where;
        return $this->execute($sql);
    }

    /**
     * 过滤字段
     *
     * @param unknown $data            
     */
    public function field_filter($data = array())
    {
        $this->data($data);
        $data = $this->data;
        $data = $data ? $data : $_GET;
        
        return $this->db->field_filter($data);
    }

    /**
     * 获得受影响的记录数
     */
    public function last_affected_rows()
    {
        return $this->db->last_affected_rows();
    }

    /**
     * 获得最后插入的ID
     */
    public function last_insert_id()
    {
        return $this->db->last_insert_id();
    }

    /**
     * 获得最后一条SQL
     */
    public function last_sql()
    {
        return $this->db->last_sql;
    }

    /**
     * 获得所有SQL
     */
    public function all_sqls()
    {
        return $this->db->all_sqls();
    }

    /**
     * ====================== 数据库操作 ==========================
     */
    
    /**
     * 创建数据库
     *
     * @param string $database            
     * @param string $charset            
     */
    public function create_database($database, $charset = 'utf8')
    {
        return $this->execute("CREATE DATABASE IF NOT EXISTS `$database` CHARSET $charset");
    }

    /**
     * 清空表
     *
     * @param unknown $table            
     */
    public function truncate($table)
    {
        if (is_array($table) && ! empty($table)) {
            foreach ($table as $t) {
                $this->execute("TRUNCATE TABLE `$t`");
            }
            
            return true;
        }
    }

    /**
     * 优化表解决表碎片问题
     *
     * @param array $table
     *            表
     * @return bool
     */
    public function optimize($table)
    {
        if (is_array($table) && ! empty($table)) {
            foreach ($table as $t) {
                $this->execute("OPTIMIZE TABLE `$t`");
            }
            return true;
        }
    }

    /**
     * 修复数据表
     *
     * @param unknown $table            
     * @return boolean
     */
    public function repair($table)
    {
        if (is_array($table) && ! empty($table)) {
            foreach ($table as $t) {
                $this->execute("REPAIR TABLE `$t`");
            }
            return true;
        }
    }

    /**
     * 删除表
     *
     * @param unknown $table            
     */
    public function drop_table($table)
    {
        if (is_string($table)) {
            $table = array(
                $table
            );
        }
        if (is_array($table) && ! empty($table)) {
            foreach ($table as $t) {
                $this->execute("DROP TABLE IF EXISTS `$t`");
            }
        }
        
        return true;
    }

    /**
     * 修改表名
     *
     * @param unknown $old            
     * @param unknown $new            
     */
    public function rename($old, $new)
    {
        $this->execute("ALTER TABLE `$old` RENAME `$new`");
    }

    /**
     * 开启|关闭事务
     *
     * @param bool $stat
     *            true开启事务| false关闭事务
     * @return mixed
     */
    public function begin_trans($stat = true)
    {
        return $this->db->begin_trans($stat);
    }

    /**
     * 执行SQL语句
     *
     * @param
     *            void 传入SQL字符串
     * @return type
     */
    public function execute_sql($str)
    {
        $str = str_replace("\r", "\n", $str);
        $sql_arr = explode(";\n", trim($str));
        foreach ($sql_arr as $s) {
            $this->execute($s);
        }
        
        return true;
    }

    /**
     * ========================= 事务 ==========================
     */
    
    /**
     * 提供一个事务
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     * 回滚事务
     */
    public function rollback()
    {
        return $this->db->rollback();
    }

    /**
     * ========================= 触发器 ===========================
     */
    
    /**
     * 触发器，是否执行__after_delete等魔术方法
     */
    public function trigger($stat = false)
    {
        $this->trigger = $stat;
        return $this;
    }

    /**
     * 模型实例化时自动执行的方法
     */
    public function __init()
    {}

    /**
     * 添加数据前执行的方法
     *
     * @param unknown $data            
     */
    public function __before_insert(& $data)
    {}

    /**
     * 添加数据后执行的方法
     *
     * @param unknown $data            
     */
    public function __after_insert($data)
    {}

    /**
     * 删除数据前执行的方法
     *
     * @param unknown $data            
     */
    public function __before_delete(& $data)
    {}

    /**
     * 删除数据后执行的方法
     *
     * @param unknown $data            
     */
    public function __after_delete($data)
    {}

    /**
     * 更新数据后前执行的方法
     *
     * @param unknown $data            
     */
    public function __before_update(& $data)
    {}

    /**
     * 更新数据后执行的方法
     *
     * @param unknown $data            
     */
    public function __after_update($data)
    {}

    /**
     * 查询数据前前执行的方法
     *
     * @param unknown $data            
     */
    public function __before_select(& $data)
    {}

    /**
     * 查询数据后执行的方法
     *
     * @param unknown $data            
     */
    public function __after_select($data)
    {}

    /**
     * =================================== 数据库通用模型 ===========================
     */
    
    /**
     * 检查不存在的字段
     *
     * @param $array 要检查的字段列表            
     * @return array
     */
    public function check_fields($array)
    {
        $fields = $this->db->fields;
        $nofields = array();
        foreach ($array as $v) {
            if (! array_key_exists($v, $fields)) {
                $nofields[] = $v;
            }
        }
        return $nofields;
    }

    /**
     * 判断表中字段是否在存在
     *
     * @param string $field_name
     *            字段名
     * @return bool
     */
    public function field_exists($field_name)
    {
        $fields = $this->db->opt['fields'];
        if (in_array($field_name, $fields)) {
            return true;
        }
        return false;
    }

    /**
     * 获取数据表主键
     *
     * @return string
     */
    public function table_primary()
    {
        return $this->db->primary;
    }

    /**
     * 获取表字段
     *
     * @return array
     */
    public function table_fields()
    {
        return $this->db->fields;
    }

    /**
     * 检查表是否存在
     *
     * @param $table 表名            
     * @return boolean
     */
    public function table_exists($table)
    {
        return $this->db->table_exists($this->db_tablepre . $table);
    }

    /**
     * 获得数据表大小
     *
     * @param string $table            
     */
    public function table_size($table = null)
    {
        if (empty($table)) {
            $table = array(
                $this->table_name
            );
        }
        if (is_string($table)) {
            $table = array(
                $table
            );
        }
        
        $new_tables = array();
        foreach ($table as $t) {
            if (strpos($t, $this->db_tablepre) === false) {
                $new_tables[] = $this->db_tablepre . $t;
            } else {
                $new_tables[] = $t;
            }
        }
        
        return $this->db->table_size($new_tables);
    }

    /**
     * 获得表信息
     *
     * @param array $table            
     */
    public function table_info($table = null)
    {
        if (empty($table)) {
            $table = array(
                $this->table_name
            );
        }
        if (is_string($table)) {
            $table = array(
                $table
            );
        }
        
        $new_tables = array();
        foreach ($table as $t) {
            if (strpos($t, $this->db_tablepre) === false) {
                $new_tables[] = $this->db_tablepre . $t;
            } else {
                $new_tables[] = $t;
            }
        }
        
        return $this->db->table_info($new_tables);
    }

    /**
     * 获得数据库大小
     */
    public function database_size($tablepre = null)
    {
        return $this->db->database_size($tablepre);
    }

    /**
     * 获得数据库列表
     */
    public function database_tables($tablepre = null)
    {
        return $this->db->tables_list($tablepre);
    }

    /**
     * 返回数据库版本号
     */
    final public function version()
    {
        return $this->db->version();
    }
}

// end