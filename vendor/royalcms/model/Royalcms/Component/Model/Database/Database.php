<?php

namespace Royalcms\Component\Model\Database;

use Royalcms\Component\Support\Facades\Config;

/**
 * Mysql数据库基类
 *
 * @package database
 * @subpackage driver
 */
abstract class Database implements DatabaseInterface
{

    public $fields  = array(); // 字段数组
    public $primary = null;    // 默认表主键
    public $opt     = array(); // SQL 操作
    public $opt_old = array();

    public    $last_query;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                // 最后发送的查询结果集
    public    $last_sql;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        // 最后发送的SQL
    public    $error       = null;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    // 错误信息
    protected $table_name = null;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               // 表名
    protected $db_tablepre = null;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              // 表前缀
    protected $cache_time  = null;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              // 查询操作缓存时间单位秒

    /**
     * 数据库配置信息
     */
    protected $config = array();

    /**
     * 将eq等替换为标准的SQL语法
     *
     * @var array
     */
    protected $condition = array(
        'eq'   => ' = ',
        'neq' => ' <> ',
        'gt'  => ' > ',
        'egt' => ' >= ',
        'lt'  => ' < ',
        'elt' => ' <= ',
        'like' => ' like '
    );

    protected $db;

    /**
     * 构造函数
     */
    public function __construct()
    {
        //...
    }

    /**
     * 打开数据库连接,有可能不真实连接数据库
     *
     * @param $config 数据库连接参数
     * @return void
     */
    public function open($config)
    {
        $this->config = $config;
        $this->connect();
    }

    /**
     * 数据库连接
     * 根据配置文件获得数据库连接对象
     *
     * @param string $table
     * @return Object 连接对象
     */
    final public function connect($table = null)
    {
        // 通过数据驱动如MYSQLI连接数据库
        if ($this->connect_database()) {
            $this->db_tablepre = $this->config['prefix'];

            if (!is_null($table)) {
                $this->table($table);

                $this->table_name = $table;
                $this->primary    = $this->opt['primary'];
                $this->fields     = $this->opt['fields'];
            }

            // 初始始化WHERE等参数
            $this->opt_init();

            return $this->link;
        }

        $this->error("数据库连接出错了请检查数据库配置");
    }

    /**
     * 初始化表字段与主键及发送字符集
     *
     * @param string $tableName
     *            表名
     */
    public function table($table_name)
    {
        if (is_null($table_name)) {
            return;
        }

        $this->opt_init();

        $field = $this->table_fields($table_name); // 获得表结构信息设置字段及主键属性

        $this->opt['table']   = $table_name;
        $this->opt['primary'] = isset($field['primary']) && !empty($field['primary']) ? $field['primary'] : '';
        $this->opt['fields']  = $field['field'];
    }

    /**
     * 查询操作归位
     *
     * @access public
     * @return void
     */
    public function opt_init()
    {
        $this->opt_old    = $this->opt;
        $this->cache_time = null; // SELECT查询缓存时间
        $this->error      = null;
        $opt              = array(
            'table'       => $this->table_name,
            'primary' => $this->primary,
            'field'   => '*',
            'fields'  => $this->fields,
            'where'   => '',
            'like'    => '',
            'group'   => '',
            'having'  => '',
            'order'   => '',
            'limit'   => '',
            'in'      => '',
            'cache'   => '',
            'filter_func' => array() // 对数据进行过滤处理
        );
        $this->opt        = array_merge($this->opt, $opt);
    }

    /**
     * 获得表字段
     *
     * @access public
     * @param string $tableName
     *            表名
     * @return type
     */
    public function table_fields($table_name)
    {
        $table_cache = $this->_get_cache_table($table_name);
        $table_field = array();
        foreach ($table_cache as $v) {
            $table_field['field'][] = $v['field'];
            if ($v['key']) {
                $table_field['primary'] = $v['field'];
            }
        }
        return $table_field;
    }

    /**
     * 获得表结构缓存 如果不存在则生生表结构缓存
     *
     * @access public
     * @param type $table_name
     * @return array 字段数组
     */
    private function _get_cache_table($table_name)
    {
        // 字段缓存
        if (!Config::get('system.debug')) {
            $cache_table_field = \RC_Cache::table_cache_get($table_name);
            if ($cache_table_field)
                return $cache_table_field;
        }
        // 获得表结构
        $tableinfo = $this->_get_table_fields($table_name);
        $fields    = $tableinfo['fields'];
        // 字段缓存
        if (!Config::get('system.debug')) {
            \RC_Cache::table_cache_set($table_name, $fields);
        }
        return $fields;
    }

    /**
     * 获得表结构及主键
     * 查询表结构获得所有字段信息，用于字段缓存
     *
     * @access private
     * @param string $table_name
     * @return array
     */
    private function _get_table_fields($table_name)
    {
        $sql    = "show columns from $table_name";
        $fields = $this->query($sql);

        if ($fields === false) {
            $this->error("表{$table_name}不存在", false);
        }
        $n_fields = array();
        $f        = array();
        foreach ($fields as $res) {
            $f['field']              = $res['Field'];
            $f['type']  = $res['Type'];
            $f['null']  = $res['Null'];
            $f['field'] = $res['Field'];
            $f['key']   = ($res['Key'] == "PRI" && $res['Extra']) || $res['Key'] == "PRI";
            $f['default'] = $res['Default'];
            $f['extra']   = $res['Extra'];
            $n_fields[$res['Field']] = $f;
        }
        $pri = '';
        foreach ($n_fields as $v) {
            if ($v['key']) {
                $pri = $v['field'];
            }
        }
        $info               = array();
        $info['fields'] = $n_fields;
        $info['primarykey'] = $pri;

        return $info;
    }

    /**
     * 将查询SQL压入调试数组 show语句不保存
     *
     * @param
     *            void
     */
    protected function debug($sql)
    {
        $this->last_sql = $sql;
        if (RC_DEBUG && !preg_match("/^\s*show/i", $sql)) {
            \RC_Model::sql_add($sql); // 压入一条成功发送SQL
        }
    }

    /**
     * 错误处理
     *
     * @param unknown $error
     */
    protected function error($error)
    {
        if (is_array($error)) {
            $this->error = $error['error'];
        } else {
            $this->error = $error;
        }

        if (RC_DEBUG) {
            if (is_array($error)) {
                $msg = ('Error: ' . $error['errno'] . ' - ' . $error['error'] . "\t SQL: " . $error['sql']);
            } else {
                $msg = $this->error;
            }
            rc_die($msg);
        } else {
            if (is_array($error)) {
                $msg = '[' . $error['errno'] . ']' . "\t MSG: " . $error['error'] . "\t SQL: " . $error['sql'];
            } else {
                $msg = $this->error;
            }
            \RC_Logger::getLogger(\RC_Logger::LOG_SQL)->error($msg);
        }
    }

    /**
     * 查找记录
     *
     * @param string $where
     * @return array string
     */
    public function select($where)
    {
        // print_r($this->opt);
        if (empty($this->opt['table'])) {
            $this->error("没有可操作的数据表");
            return false;
        }

        // 设置条件
        if (!empty($where))
            $this->where($where);
        // //添加表前缀
        // $chain = array('table', 'group','field','order');
        // foreach ($chain as $v) {
        // $this->opt[$v] = $this->addTableFix($this->opt[$v]);
        // }

        $sql = 'SELECT ' . $this->opt['field'] . ' FROM ' . $this->opt['table'] . $this->opt['where'] . $this->opt['group'] . $this->opt['having'] . $this->opt['order'] . $this->opt['limit'];

        // echo $sql . '<br />';
        $data = $this->query($sql);
        // print_r($data);exit;
        return $data;
    }

    /**
     * 添加表前缀
     *
     * @access public
     * @param string $sql
     * @return string 格式化后的SQL
     */
    // public function addTableFix($sql)
    // {
    // return preg_replace('@(\w+?\.[a-z]+?)@i', C('DB_PREFIX') . '\1', $sql);
    // }

    /**
     * SQL中的REPLACE方法，如果存在与插入记录相同的主键或unique字段进行更新操作
     *
     * @param array $data
     * @param string $type
     * @return array bool
     */
    public function insert($data, $type = 'INSERT')
    {
        $value = $this->format_field($data);
        if (empty($value)) {
            $this->error("没有任何数据用于 INSERT");
            return false;
        } else {
            $sql = $type . " INTO " . $this->opt['table'] . "(" . implode(',', $value['fields']) . ")" . "VALUES (" . implode(',', $value['values']) . ")";
            return $this->execute($sql);
        }
    }

    /**
     * 格式化SQL操作参数 字段加上标识符 值进行转义处理
     *
     * @param array $vars
     *            处理的数据
     * @return array
     */
    public function format_field($vars)
    {
        // 格式化的数据
        $data = array();
        foreach ($vars as $k => $v) {
            // 校验字段与数据
            if (!$this->is_field($k) || is_array($v)) {
                continue;
            }
            $data['fields'][] = "`" . $k . "`";
            $v                = $this->escape_string($v);
            // $data['values'][] = is_numeric($v) ? $v : "\"" . $v . "\""; 避免数字字符串被过滤掉，类似00345
            $data['values'][] = "\"" . $v . "\"";
        }
        return $data;
    }

    /**
     * 更新数据
     *
     * @access public
     * @param mixed $data
     * @return mixed
     */
    public function update($data)
    {
        // 验证条件
        if (empty($this->opt['where'])) {
            if (isset($data[$this->opt['primary']])) {
                $this->opt['where'] = " WHERE " . $this->opt['primary'] . " = " . intval($data[$this->opt['primary']]);
            } else {
                $this->error('UPDATE更新语句必须输入条件');
                return false;
            }
        }
        $data = $this->format_field($data);
        if (empty($data))
            return false;
        $sql = "UPDATE `" . $this->opt['table'] . "` SET ";
        foreach ($data['fields'] as $n => $field) {
            $sql .= $field . "=" . $data['values'][$n] . ',';
        }
        $sql = trim($sql, ',') . $this->opt['where'] . $this->opt['limit'];

        return $this->execute($sql);
    }

    /**
     * 删除方法
     *
     * @param
     *            $data
     * @return bool
     */
    public function delete($data = array())
    {
        $this->where($data);
        if (empty($this->opt['where'])) {
            $this->error("DELETE删除语句必须输入条件");
            return false;
        }
        $sql = "DELETE FROM `" . $this->opt['table'] . "`" . $this->opt['where'] . $this->opt['limit'];
        return $this->execute($sql);
    }

    /**
     * count max min avg 共用方法
     *
     * @param string $type
     *            类型如count|avg
     * @param mixed $data
     *            参数
     * @return mixed
     */
    private function statistics($type, $data)
    {
        $type = strtoupper($type);
        if (empty($data)) {
            $field = " {$type}(" . $this->opt['primary'] . ") AS " . $this->opt['primary'];
        } else
            if (is_string($data)) {
                $s     = explode("|", $data);
                $field = " {$type}(" . $s[0] . ")";
                $field .= isset($s[1]) ? ' AS ' . $s[1] : '';
            }
        $this->opt['field'] = $field;
    }

    /**
     * 统计记录总数
     *
     * @param unknown $data
     * @return Ambigous <NULL, number>
     */
    public function count($data)
    {
        $this->statistics(__FUNCTION__, $data);
        $result = $this->select("");
        return is_array($result) && !empty($result) ? intval(current($result[0])) : NULL;
    }

    /**
     * 查找最大的值
     *
     * @param unknown $data
     * @return Ambigous <NULL, mixed>
     */
    public function max($data)
    {
        $this->statistics(__FUNCTION__, $data);
        $result = $this->select("");
        return is_array($result) && !empty($result) ? current($result[0]) : NULL;
    }

    /**
     * 查找最小的值
     *
     * @param unknown $data
     * @return Ambigous <NULL, mixed>
     */
    public function min($data)
    {
        $this->statistics(__FUNCTION__, $data);
        $result = $this->select("");
        return is_array($result) && !empty($result) ? current($result[0]) : NULL;
    }

    /**
     * 查找平均值
     *
     * @param unknown $data
     * @return Ambigous <NULL, mixed>
     */
    public function avg($data)
    {
        $this->statistics(__FUNCTION__, $data);
        $result = $this->select("");
        return is_array($result) && !empty($result) ? current($result[0]) : NULL;
    }

    /**
     * SQL求合SUM计算
     *
     * @param unknown $data
     * @return Ambigous <NULL, mixed>
     */
    public function sum($data)
    {
        $this->statistics(__FUNCTION__, $data);
        $result = $this->select("");
        return is_array($result) && !empty($result) ? current($result[0]) : NULL;
    }

    /**
     * 判断表名是否存在
     *
     * @param $table 表名
     * @param bool $full
     *            是否加表前缀
     * @return bool
     */
    public function table_exists($table, $full = true)
    {
        // 不为全表名时加表前缀
        if (!$full)
            $table = $this->db_tablepre . $table;
        $table = strtolower($table);
        $info  = $this->query('show tables');
        foreach ($info as $n => $d) {
            if ($table == current($d)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 过滤非法字段
     *
     * @param mixed $opt
     * @return array
     */
    public function field_filter($opt)
    {
        if (empty($opt) || !is_array($opt))
            return null;

        $field = array();
        foreach ($opt as $k => $v) {
            if ($this->is_field($k))
                $field[$k] = $v;
        }
        return $field;
    }

    /**
     * SQL查询条件
     *
     * @param mixed $opt
     *            链式操作中的WHERE参数
     * @return string
     */
    public function where($opt)
    {
        // var_dump($this->opt);
        $where = '';
        if (empty($opt)) {
            return false;
        } else
            if (is_numeric($opt)) {
                $where .= ' `' . $this->opt['primary'] . "`=$opt ";
            } else
                if (is_string($opt)) {
                    $where .= " $opt ";
                } else
                    if (is_numeric(key($opt)) && is_numeric(current($opt))) {
                        $where .= ' ' . $this->opt['primary'] . ' IN(' . implode(',', $opt) . ')';
                    } else
                        if (is_array($opt)) {
                            foreach ($opt as $k => $v) {
                                if (method_exists($this, $k) && $k != 'debug' && $k != 'error') {
                                    $this->$k($v);
                                } else
                                    if (is_array($v)) {
                                        foreach ($v as $n => $m) {
                                            if (isset($this->condition[$n])) {
                                                $where .= " $k" . $this->condition[$n] . (is_numeric($m) ? $m : "'$m'");
                                            } else
                                                if (in_array(strtoupper($m), array(
                                                    "OR",
                                                    "AND"
                                                ))) {
                                                    if (preg_match('@(OR|AND)\s*$@i', $where)) {
                                                        $where = substr($where, 0, -4);
                                                    }
                                                    $where .= strtoupper($m) . ' ';
                                                } else {
                                                    if (is_numeric($m)) {
                                                        $where .= " $k IN(" . implode(',', $v) . ") ";
                                                    } else {
                                                        $where .= " $k IN('" . implode("','", $v) . "') ";
                                                    }
                                                    break;
                                                }
                                            if (!preg_match('@(or|and)\s*$@i', $where)) {
                                                $where .= ' AND ';
                                            }
                                        }
                                        if (!preg_match('@(or|and)\s*$@i', $where)) {
                                            $where .= ' AND ';
                                        }
                                    } else {
                                        if (is_numeric($k) && in_array(strtoupper($v), array(
                                                'OR',
                                                'AND'
                                            ))) {
                                            if (preg_match('@(or|and)\s*$@i', $where)) {
                                                $where = substr($where, 0, -4);
                                            }
                                            $where .= strtoupper($v) . ' ';
                                        } else
                                            if (is_numeric($k) && is_string($v)) {
                                                $where .= $v . ' AND ';
                                            } else
                                                if (is_string($k)) {
                                                    $where .= (is_numeric($v) ? " $k=$v " : " $k='$v' ") . ' AND ';
                                                }
                                    }
                            }
                        }

        $where = trim($where);
        if (!empty($where)) {
            if (empty($this->opt['where'])) {
                $this->opt['where'] = " WHERE $where";
            } else
                if (!preg_match('@^\s*(or|and)@i', $where)) {
                    $this->opt['where'] .= ' AND ' . $where;
                }
        }
        // echo $this->opt['where'];
        $this->opt['where'] = preg_replace('@(or|and)\s*$@i', '', $this->opt['where']);
    }

    /**
     * in 语句
     *
     * @param mixed $data
     *            链式操作中的参数
     */
    public function in($data, $is_not_in = false)
    {
        $in_key = $is_not_in ? "NOT IN" : "IN";

        $in = '';
        if (!is_array($data)) {
            $in .= $this->opt['primary'] . " $in_key(" . $data . ") ";
        } else
            if (is_array($data) && !empty($data)) {
                if (is_string(key($data))) {
                    $_v = current($data);
                    if (!is_array($_v)) {
                        $in .= "" . key($data) . " $in_key({$_v}) ";
                    } else
                        if (isset($_v[0]) && is_string($_v[0])) {
                            $in .= " " . key($data) . " $in_key('" . implode("','", current($data)) . "') ";
                        } else {
                            $in .= " " . key($data) . " $in_key(" . implode(",", current($data)) . ") ";
                        }
                } else {
                    $in .= $this->opt['primary'] . " $in_key(" . implode(",", $data) . ") ";
                }
            }
        if (empty($this->opt['where'])) {
            $this->opt['where'] = " WHERE $in ";
        } else
            if (!preg_match("@^\s*(or|and)@i", $in)) {
                $this->opt['where'] .= " AND " . $in;
            } else {
                $this->opt['where'] .= "  " . $in;
            }
    }

    /**
     * 字段集
     *
     * @param type $data
     */
    public function field($data)
    {
        if (is_string($data)) {
            $data = explode(",", $data);
        }
        $field = trim($this->opt['field']) == '*' ? '' : $this->opt['field'] . ',';
        foreach ($data as $d) {
            $a     = explode("|", $d);
            $field .= trim($a[0]);
            $field .= isset($a[1]) ? ' AS ' . $a[1] . ',' : ',';
        }
        $this->opt['field'] = substr($field, 0, -1);
    }

    /**
     * 验证字段是否全法
     *
     * @param $field 字段名
     * @return bool
     */
    protected function is_field($field)
    {
        return is_string($field) && in_array($field, $this->opt['fields']);
    }

    /**
     * limit 操作
     *
     * @param mixed $data
     * @return type
     */
    public function limit($data)
    {
        $limit = '';
        if (is_array($data)) {
            $limit .= implode(",", $data);
        } else {
            $limit .= $this->opt['limit'] . " $data ";
        }
        $this->opt['limit'] = " LIMIT $limit ";
    }

    /**
     * SQL 排序 ORDER
     *
     * @param type $data
     */
    public function order($data)
    {
        $order = "";
        if (is_string($data)) {
            $order .= preg_replace('@(\w+?\.[a-z]+?)@i', $this->db_tablepre . '\1', $data);;
        } else
            if (is_array($data)) {
                foreach ($data as $f => $t) {
                    $order .= " $f $t,";
                }
                $order = substr($order, 0, -1);
            }
        if (empty($this->opt['order'])) {
            $this->opt['order'] = " ORDER BY $order ";
        } else {
            $this->opt['order'] .= "," . $order;
        }
    }

    /**
     * 分组操作
     *
     * @param type $opt
     */
    public function group($opt)
    {
        $group = "";
        if (is_string($opt)) {
            $group .= $opt;
        } else
            if (is_array($opt)) {
                $group .= implode(",", $opt);
            }
        if (empty($this->opt['group'])) {
            $this->opt['group'] = " GROUP BY $group";
        } else {
            $this->opt['group'] .= ", $group";
        }
    }

    /**
     * ·
     * 分组条件having
     *
     * @param type $opt
     */
    public function having($opt)
    {
        $having = "";
        if (is_string($opt)) {
            $having .= $opt;
        }
        if (empty($this->opt['having'])) {
            $this->opt['having'] = " HAVING $having";
        } else
            if (!preg_match("@^\s*(or|and)@i", $having)) {
                $this->opt['having'] .= " AND " . $having;
            } else {
                $this->opt['having'] .= " " . $having;
            }
    }

    /**
     * 获得所有SQL语句
     *
     * @return type
     */
    public function all_sqls()
    {
        return \RC_Model::sql_all();
    }

    /**
     * 设置查询缓存时间
     *
     * @param
     *            $time
     */
    public function cache($time = -1)
    {
        $this->cache_time = is_numeric($time) ? $time : -1;
    }

    /**
     * 获得表信息
     *
     * @param string $table
     *            数据库名
     * @return array
     */
    public function table_info($table)
    {
        $table             = empty($table) ? array(
            $this->table_name
        ) : $table; // 表名
        $info  = $this->query("SHOW TABLE STATUS FROM " . $this->config['database']);
        $arr   = array();
        $arr['total_size'] = 0; // 总大小
        $arr['total_row']  = 0; // 总条数
        foreach ($info as $k => $t) {
            if ($table) {
                if (!in_array($t['Name'], $table)) {
                    continue;
                }
            }
            $arr['table'][$t['Name']]['tablename']     = $t['Name'];
            $arr['table'][$t['Name']]['engine']    = $t['Engine'];
            $arr['table'][$t['Name']]['rows']      = $t['Rows'];
            $arr['table'][$t['Name']]['collation'] = $t['Collation'];
            $charset                               = $arr['table'][$t['Name']]['collation'] = $t['Collation'];
            $charset                               = explode("_", $charset);
            $arr['table'][$t['Name']]['charset']   = $charset[0];
            $arr['table'][$t['Name']]['datafree']  = $t['Data_free'];
            $arr['table'][$t['Name']]['size']      = $t['Data_free'] + $t['Data_length'];
            $info                                  = $this->_get_table_fields($t['Name']);
            $arr['table'][$t['Name']]['field']     = $info['fields'];
            $arr['table'][$t['Name']]['primarykey'] = $info['primarykey'];
            $arr['table'][$t['Name']]['autoincrement'] = $t['Auto_increment'] ? $t['Auto_increment'] : '';
            $arr['total_size']                         += $arr['table'][$t['Name']]['size'];
            $arr['total_row']++;
        }
        return empty($arr) ? false : $arr;
    }

    /**
     * 获得数据表大小
     */
    public function table_size($table)
    {
        $sql  = "show table status from " . $this->config['database'];
        $row = $this->query($sql);
        $size = 0;
        foreach ($row as $v) {
            if ($table) {
                $size += in_array(strtolower($v['Name']), $table) ? $v['Data_length'] + $v['Index_length'] : 0;
            }
        }
        return \RC_Format::format_size($size);
    }

    /**
     * 获得数据库的所有列表
     *
     * @param string $tablepre
     * @return array
     */
    public function tables_list($tablepre = null)
    {
        $sql        = "show table status from " . $this->config['database'];
        $row = $this->query($sql);
        $new_tables = array();

        if (empty($tablepre)) {
            $tablepre = $this->db_tablepre;
        }

        $skip_tablepre = false;
        if (is_bool($tablepre) && $tablepre === true) {
            $skip_tablepre = true;
        }

        foreach ($row as $v) {
            if ($skip_tablepre) {
                $new_tables[] = $v['Name'];
            } else {
                if (strpos(strtolower($v['Name']), $tablepre) !== false) {
                    $new_tables[] = $v['Name'];
                }
            }
        }

        return $new_tables;
    }

    /**
     * 获得数据库的大小
     */
    public function database_size($tablepre = null)
    {
        $sql  = "show table status from " . $this->config['database'];
        $row = $this->query($sql);
        $size = 0;

        if (empty($tablepre)) {
            $tablepre = $this->db_tablepre;
        }

        $skip_tablepre = false;
        if (is_bool($tablepre) && $tablepre === true) {
            $skip_tablepre = true;
        }

        foreach ($row as $v) {
            if ($skip_tablepre) {
                $size += $v['Data_length'] + $v['Index_length'];
            } else {
                if (strpos(strtolower($v['Name']), $tablepre) !== false) {
                    $size += $v['Data_length'] + $v['Index_length'];
                }
            }
        }
        return \RC_Format::format_size($size);
    }
}


// end