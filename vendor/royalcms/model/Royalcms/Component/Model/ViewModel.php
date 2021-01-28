<?php

namespace Royalcms\Component\Model;

/**
 * 视图模型处理类
 *
 * @package model
 * @subpackage driver
 */
class ViewModel extends Model
{

    public $view = array();

    protected $table_alias_name = '';

    /**
     * JOIN types
     *
     * @var string
     */
    const TYPE_INNER_JOIN = "INNER JOIN";

    const TYPE_LEFT_JOIN = "LEFT JOIN";

    const TYPE_RIGHT_JOIN = "RIGHT JOIN";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 本次需要关联的表
     *
     * @param unknown $table            
     * @return boolean
     */
    private function _check_join($table)
    {
        // 验证表
        if ($this->join_table === false) {
            return false;
        } else 
            if (is_array($this->join_table) && ! empty($this->join_table) && ! in_array($table, $this->join_table)) {
                return false;
            } else {
                return true;
            }
    }

    /**
     * 验证关联定义
     *
     * @param unknown $set            
     * @return boolean
     */
    private function _check_view_set($set)
    {
        if (empty($set['type']) || ! in_array($set['type'], array(
            self::TYPE_INNER_JOIN,
            self::TYPE_LEFT_JOIN,
            self::TYPE_RIGHT_JOIN
        ))) {
            // TODO: 错误提示
            rc_die("关联定义规则[type]设置错误");
            return false;
        }
        if (empty($set['on'])) {
            // TODO: 错误提示
            rc_die("关联定义规则[on]设置错误");
            return false;
        }
        return true;
    }

    /**
     * 设置表join关联
     */
    private function _join_table()
    {
        // 关联from 语句
        $from = ' ' . $this->table_full_name . ' ';
        if (! empty($this->table_alias_name)) {
            $from .= 'AS ' . $this->table_alias_name . ' ';
        }
        
        // 不存在关联定义或不关联时
        if ($this->join_table === false || empty($this->view)) {
            $this->db->opt['table'] = $from;
            return;
        }
        
        $field = '';
        
        // 处理关联
        foreach ($this->view as $table => $set) {
            // 表是否需要关联
            if (! $this->_check_join($table))
                continue;
                // 验证关联定义
            if (! $this->_check_view_set($set))
                continue;
                // 加表前缀
            $_table = $this->db_tablepre . $table;
            // 加表别名
            $_table .= isset($set['alias']) ? ' AS ' . $set['alias'] : '';
            // 加连接类型
            $from .= $set['type'] . " " . $_table . " ";
            $from .= " ON " . $set['on'] . " ";
            // 加关联表筛选字段
            $field .= isset($set['field']) ? $set['field'] : '';
        }
        
        $this->db->opt['table'] = $from; // 加表前缀 preg_replace('@(\w+?\.[a-z]+?)@i', $this->db_tablepre . '\1', $from);
        
        if (! empty($field)) {
            $field .= ($this->db->opt['field'] != '*') ? ', ' . $this->db->opt['field'] : '';
            $this->field($field);
        }
    }

    /**
     * 初始化
     */
    protected function init()
    {
        $opt = array(
            'trigger' => true,
            'join_table' => array()
        );
        foreach ($opt as $n => $v) {
            $this->$n = $v;
        }
    }

    /**
     * 查询
     *
     * @see model::select()
     */
    final public function select($data = array())
    {
        // 设置表关联
        $this->_join_table($data);
        return parent::select($data);
    }

    /**
     * count
     *
     * @see model::count()
     */
    final public function count($args = '')
    {
        // 设置表关联
        $this->_join_table();
        return parent::count($args);
    }

    /**
     * min
     *
     * @see model::min()
     */
    final public function min($args = '')
    {
        // 设置表关联
        $this->_join_table();
        return parent::min($args);
    }

    /**
     * max
     *
     * @see model::max()
     */
    final public function max($args = '')
    {
        // 设置表关联
        $this->_join_table();
        return parent::max($args);
    }

    /**
     * sum
     *
     * @see model::sum()
     */
    final public function sum($args = '')
    {
        // 设置表关联
        $this->_join_table();
        return parent::sum($args);
    }

    /**
     * avg
     *
     * @see model::avg()
     */
    final public function avg($args = '')
    {
        // 设置表关联
        $this->_join_table();
        return parent::max($args);
    }
}

// end