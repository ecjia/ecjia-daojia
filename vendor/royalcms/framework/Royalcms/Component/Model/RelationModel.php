<?php namespace Royalcms\Component\Model;

/**
 * 关联模型
 *
 * @package model
 * @subpackage driver
 */

class Relation extends Model
{

    /**
     * 关联模型定义
     */
    public $join = array();

    /**
     * Relation types
     *
     * @var string
     */
    
    /**
     * 关联常量定义
     *
     * @var string
     */
    const TYPE_HAS_ONE = "HAS_ONE";

    /**
     * 一对多 主表 VS 从表 用户表（主表） VS 用户信息表
     *
     * @var string
     */
    const TYPE_HAS_MANY = "HAS_MANY";

    /**
     * 一对多 从表 VS 主表 用户信息表（主表） VS 用户表
     *
     * @var string
     */
    const TYPE_BELONGS_TO = "BELONGS_TO";

    /**
     * 多对多
     *
     * @var string
     */
    const TYPE_MANY_TO_MANY = "MANY_TO_MANY";

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
        if (! empty($this->join_table) && ! in_array($table, $this->join_table)) {
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
    private function _check_join_set($set)
    {
        if (empty($set['type']) || ! in_array($set['type'], array(
            self::TYPE_HAS_ONE,
            self::TYPE_HAS_MANY,
            self::TYPE_BELONGS_TO,
            self::TYPE_MANY_TO_MANY
        ))) {
            // TODO: 错误提示
            rc_die("关联定义规则[type]设置错误");
            return false;
        }
        if (empty($set['foreign_key'])) {
            // TODO: 错误提示
            rc_die("关联定义规则[foreign_key]设置错误");
            return false;
        }
        if (empty($set['parent_key'])) {
            // TODO: 错误提示
            rc_die("关联定义规则[parent_key]设置错误");
            return false;
        }
        return true;
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
     * 关联查询
     *
     * @see model::select()
     */
    final public function select($data = array())
    {
        $trigger = $this->trigger;
        $this->trigger = true;
        // 主表主键
        $primary = $this->db->primary;
        $result = call_user_func(array(
            $this->db,
            __FUNCTION__
        ), $data);
        // 插入失败或者没有定义关联join属性
        if (! $result || $this->join_table === false || empty($this->join) || ! is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_select($result);
            $this->init();
            return $result;
        }
        
        // 关联操作
        foreach ($this->join as $table => $set) {
            // 本次需要关联的表
            if (! $this->_check_join($table))
                continue;
                // 验证关联定义
            if (! $this->_check_join_set($set))
                continue;
                // 必须定义foreign_key 与 parent_key
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            // 关联表对象
            // TODO: 可以优化成使用时才实例化数据库模型
            $db = is_object($set['model']) ? $set['model'] : null;
            
            // 附表字段
            $field = "";
            if (isset($set['field'])) {
                $field = $set['field'];
            }
            switch ($set['type']) {
                // 一对一
                case self::TYPE_HAS_ONE:
                    if (! $db)
                        break;
                    foreach ($result as $n => $d) {
                        $s = $db->field($field)
                            ->where($fk . '=' . $d[$primary])
                            ->find();
                        if (is_array($s)) {
                            $result[$n] = array_merge($d, $s);
                        }
                    }
                    break;
                
                // 一对多
                case self::TYPE_HAS_MANY:
                    if (! $db)
                        break;
                    foreach ($result as $n => $d) {
                        $s = $db->field($field)
                            ->where($fk . '=' . $d[$primary])
                            ->select();
                        if (is_array($s)) {
                            $result[$n][$table] = $s;
                        }
                    }
                    break;
                
                // 多对一
                case self::TYPE_BELONGS_TO:
                    if (! $db)
                        break;
                    foreach ($result as $n => $d) {
                        $s = $db->field($field)
                            ->where($pk . '=' . $d[$fk])
                            ->find();
                        if (is_array($s)) {
                            $result[$n] = array_merge($d, $s);
                        }
                    }
                    break;
                
                // 多对多
                case self::TYPE_MANY_TO_MANY:
                    if (! $db)
                        break;
                    if (! isset($set['relation_table']))
                        break;
                    foreach ($result as $n => $d) {
                        $s = $db->table($set['relation_table'])
                            ->field($fk)
                            ->where($pk . '=' . $d[$primary])
                            ->select();
                        if (is_array($s)) {
                            $_id = array();
                            foreach ($s as $_s) {
                                $_id[] = $_s[$fk];
                            }
                            $result[$n][$table] = $db->table($table)
                                ->in($_id)
                                ->select();
                        }
                    }
                    break;
            }
        }
        $this->error = $this->db->error;
        $trigger and $this->__after_select($result);
        $data = empty($result) ? null : $result;
        $this->init();
        return $data;
    }

    /**
     * 关联插入
     *
     * @see model::insert()
     */
    final public function insert($data = array(), $type = "INSERT")
    {
        $this->data($data);
        $data = $this->data;
        $trigger = $this->trigger;
        $primary = $this->db->primary;
        $trigger and $this->__before_insert($data);
        if (empty($data)) {
            $this->error = "没有任何数据用于INSERT！";
            $this->init();
            $this->data = array();
            $this->trigger = true;
            return false;
        }
        $id = call_user_func(array(
            $this->db,
            __FUNCTION__
        ), $data, $type);
        // 插入失败或者没有定义关联join属性
        if (! $id || $this->join_table === false || empty($this->join) || ! is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_insert($id);
            $this->init();
            $this->data = array();
            $this->trigger = true;
            return $id;
        }
        $result_id = array();
        $result_id[$this->table_short_name] = $id;
        // 处理表关联
        foreach ($this->join as $table => $set) {
            // 有无操作数据
            if (empty($data[$table]) || ! is_array($data[$table]))
                continue;
                // 检测是否需要关联
            if (! $this->_check_join($table))
                continue;
                // 验证关联定义
            if (! $this->_check_join_set($set))
                continue;
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            // 关联表对象
            $db = is_object($set['model']) ? $set['model'] : null;
            
            switch ($set['type']) {
                // 一对一
                case self::TYPE_HAS_ONE:
                    if (! $db)
                        break;
                    $data[$table][$fk] = $id;
                    $result_id[$table] = $db->insert($data[$table], $type);
                    break;
                
                // 一对多
                case self::TYPE_HAS_MANY:
                    if (! $db)
                        break;
                    $result_id[$table] = array();
                    foreach ($data[$table] as $d) {
                        if (is_array($d)) {
                            $d[$fk] = $id;
                            $result_id[$table][] = $db->insert($d, $type);
                        }
                    }
                    break;
                
                // 多对一
                case self::TYPE_BELONGS_TO:
                    if (! $db)
                        break;
                    $_id = $db->insert($data[$table]);
                    $db->table($this->table_short_name)
                        ->where("$primary=" . $id)
                        ->update(array(
                        $fk => $_id
                    ));
                    $result_id[$table] = $_id;
                    break;
                
                // 多对多
                case self::TYPE_MANY_TO_MANY:
                    if (! $db)
                        break;
                    if (! isset($set['relation_table']))
                        break;
                        // 关联表
                    $_id = $db->insert($data[$table]);
                    $result_id[$table] = $_id;
                    
                    // 中间表
                    $r_fields = array(
                        $pk => $id,
                        $fk => $_id
                    );
                    if (isset($data[$set['relation_table']]) && is_array($data[$set['relation_table']])) {
                        $r_fields = array_merge($r_fields, $data[$set['relation_table']]);
                    }
                    $_r_id = $db->table($set['relation_table'])->insert($r_fields, $type);
                    $result_id[$set['relation_table']] = $_r_id;
            }
        }
        $this->error = $this->db->error;
        $result = empty($result_id) ? null : $result_id;
        $trigger and $this->__after_insert($result);
        $this->init();
        $this->data = array();
        $this->trigger = true;
        return $result;
    }

    /**
     * 关联更新
     *
     * @see model::update()
     */
    final public function update($data = array())
    {
        $this->data($data);
        $data = $this->data;
        $trigger = $this->trigger;
        $trigger and $this->__before_update($data);
        if (empty($data)) {
            $this->error = "没有任何数据用于UPDATE！";
            $trigger and $this->__after_update(null);
            $this->init();
            $this->data = array();
            $this->trigger = true;
            return false;
        }
        $stat = call_user_func(array(
            $this->db,
            __FUNCTION__
        ), $data);
        // 插入失败或者没有定义关联join属性
        if (! $stat || $this->join_table === false || empty($this->join) || ! is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_update($stat);
            $this->init();
            $this->data = array();
            $this->trigger = true;
            return $stat;
        }
        $primary = $this->db->primary;
        $where = preg_replace('@\s*WHERE@i', '', $this->db->opt_old['where']);
        $_p = $this->field($primary)
            ->where($where)
            ->find();
        $id = $_p[$primary];
        $result_id = array();
        $result_id[$this->table_short_name] = $stat;
        // 处理表关联
        foreach ($this->join as $table => $set) {
            // 有无操作数据
            if (empty($data[$table]) || ! is_array($data[$table]))
                continue;
                // 检测是否需要关联
            if (! $this->_check_join($table))
                continue;
                // 验证关联定义
            if (! $this->_check_join_set($set))
                continue;
            
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            // 关联表对象
            $db = is_object($set['model']) ? $set['model'] : null;
            
            switch ($set['type']) {
                // 一对一
                case self::TYPE_HAS_ONE:
                    if (! $db)
                        break;
                    $data[$table][$fk] = $id;
                    $db->where("$fk=$id")->update($data[$table]);
                    break;
                
                // 一对多
                case self::TYPE_HAS_MANY:
                    if (! $db)
                        break;
                    $db->where($fk . '=' . $id)->delete();
                    foreach ($data[$table] as $d) {
                        if (is_array($d)) {
                            $d[$fk] = $id;
                            $db->replace($d);
                        }
                    }
                    break;
                
                // 多对一
                case self::TYPE_BELONGS_TO:
                    if (! $db)
                        break;
                        // 副表数据
                    $temp = $db->table($this->table_short_name)->find($id);
                    $data[$table][$pk] = $temp[$fk];
                    $result_id[$table] = $db->update($data[$table]);
                    break;
                
                // 多对多
                case self::TYPE_MANY_TO_MANY:
                    if (! $db)
                        break;
                    if (! isset($set['relation_table']))
                        break;
                    $result_id[$table] = $db->update($data[$table]);
                    break;
            }
        }
        $this->error = $this->db->error;
        $result = empty($result_id) ? null : $result_id;
        $trigger and $this->__after_update($result);
        $this->init();
        $this->data = array();
        $this->trigger = true;
        return $result;
    }

    /**
     * 关联删除
     *
     * @see model::delete()
     */
    final public function delete($data = array())
    {
        $trigger = $this->trigger;
        $this->trigger = true;
        $trigger and $this->__before_delete($data);
        // 查找将删除的主表数据，用于副表删除时使用
        $id = $this->where($data)->select();
        if (! $id) {
            $this->init();
            return true;
        }
        $this->db->opt = $this->db->opt_old;
        $stat = call_user_func(array(
            $this->db,
            __FUNCTION__
        ));
        // 插入失败或者没有定义关联join属性
        if (! $stat || $this->join_table === false || empty($this->join) || ! is_array($this->join)) {
            $this->error = $this->db->error;
            $trigger and $this->__after_delete($stat);
            $this->init();
            return $stat;
        }
        $result_id = array();
        $result_id[$this->table_short_name] = $stat;
        // 处理表关联
        foreach ($this->join as $table => $set) {
            // 检测是否需要关联
            if (! $this->_check_join($table))
                continue;
                // 验证关联定义
            if (! $this->_check_join_set($set))
                continue;
            $fk = $set['foreign_key'];
            $pk = $set['parent_key'];
            // 关联表对象
            $db = is_object($set['model']) ? $set['model'] : null;
            
            switch ($set['type']) {
                // 一对一 与 一对多
                case self::TYPE_HAS_ONE:
                case self::TYPE_HAS_MANY:
                    if (! $db)
                        break;
                    foreach ($id as $p) {
                        $result_id[$table] = $db->where($fk . '=' . $p[$pk])->delete();
                    }
                    break;
                
                // 多对一
                CASE self::TYPE_BELONGS_TO:
                    break;
                
                // 多对多
                case self::TYPE_MANY_TO_MANY:
                    if (! $db)
                        break;
                    foreach ($id as $p) {
                        $result_id[$table] = $db->table($set['relation_table'])
                            ->where($pk . '=' . $p[$pk])
                            ->delete();
                    }
                    break;
            }
        }
        $this->error = $this->db->error;
        $result = empty($result_id) ? null : $result_id;
        $trigger and $this->__after_delete($result);
        $this->init();
        return $result;
    }
}

// end