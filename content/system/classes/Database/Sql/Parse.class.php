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
namespace Ecjia\System\Database\Sql;

defined('IN_ECJIA') or exit('No permission resources.');

class Parse
{
    /** 
     * 表名
     * @var string      $tableName     
     */
    private $tableName;
    
    /**
     * 数据库字符编码
     *
     * @var      string     $charset
     */
    private $dbCharset;
    
    /**
     * 表中字段列表
     * 
     * @var array $fields
     */
    private $fields = array();
    
    /**
     * 索引列表
     * 
     * @var array $indexes
     */
    private $indexes = array();
    
    
    public function __construct($tableName, $dbCharset, $fields, $indexes) 
    {
        $this->tableName = $tableName;
        $this->dbCharset = $dbCharset;
        $this->fields = $fields;
        $this->indexes = $indexes;
    }
    
    /**
     * 解析出CHANGE操作
     *
     * @param   string      $query_item     SQL查询项
     * @return  array       返回一个以CHANGE操作串和其它操作串组成的数组
     */
    public function parseChangeQuery($query)
    {
        $result = array('', $query);

        $matches = array();
        /* 第1个子模式匹配old_col_name，第2个子模式匹配column_definition，第3个子模式匹配new_col_name */
        $pattern = '/\s*CHANGE\s*`?(\w+)`?\s*`?(\w+)`?([^,(]+\([^,]+?(?:,[^,)]+)*\)[^,]+|[^,;]+)\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                /* 如果表中存在原列名 */
                if (in_array($matches[$i][1], $this->fields))
                {
                    $sql .= $matches[$i][0];
                }
                /* 如果表中存在新列名 */
                elseif (in_array($matches[$i][2], $this->fields))
                {
                    $sql .= 'CHANGE ' . $matches[$i][2] . ' ' . $matches[$i][2] . ' ' . $matches[$i][3] . ',';
                }
                else /* 如果两个列名都不存在 */
                {
                    $sql .= 'ADD ' . $matches[$i][2] . ' ' . $matches[$i][3] . ',';
                    $sql = preg_replace('/(\s+AUTO_INCREMENT)/i', '\1 PRIMARY KEY', $sql);
                }
            }
            $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
            $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//存储CHANGE操作，已过滤末尾的逗号
            $result[0] = $this->insertCharset($result[0]);//加入字符集设置
            $result[1] = preg_replace($pattern, '', $query);//存储其它操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1]: '';
        }
        
        return $result;
    }
    
    /**
     * 解析出DROP COLUMN操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以DROP COLUMN操作和其它操作组成的数组
     */
    public function parseDropColumnQuery($query)
    {
        $result = array('', $query);
        
        $matches = array();
        /* 子模式存储列名 */
        $pattern = '/\s*DROP(?:\s+COLUMN)?(?!\s+(?:INDEX|PRIMARY))\s*`?(\w+)`?\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                if (in_array($matches[$i][1], $this->fields))
                {
                    $sql .= 'DROP ' . $matches[$i][1] . ',';
                }
            }
            if ($sql)
            {
                $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
                $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//过滤末尾的逗号
            }
            $result[1] = preg_replace($pattern, '', $query);//过滤DROP COLUMN操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
    }
    
    /**
     * 解析出ADD [COLUMN]操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以ADD [COLUMN]操作和其它操作组成的数组
     */
    public function parseAddColumnQuery($query)
    {
        $result = array('', $query);
        
        $matches = array();
        /* 第1个子模式存储列定义，第2个子模式存储列名 */
        $pattern = '/\s*ADD(?:\s+COLUMN)?(?!\s+(?:INDEX|UNIQUE|PRIMARY))\s*(`?(\w+)`?(?:[^,(]+\([^,]+?(?:,[^,)]+)*\)[^,]+|[^,;]+))\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $mysql_ver = $this->db->version();
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                if (in_array($matches[$i][2], $this->fields))
                {
                    /* 如果为低版本MYSQL，则把非法关键字过滤掉 */
                    if  ($mysql_ver < '4.0.1' )
                    {
                        $matches[$i][1] = preg_replace('/\s*(?:AFTER|FIRST)\s*.*$/i', '', $matches[$i][1]);
                    }
                    $sql .= 'CHANGE ' . $matches[$i][2] . ' ' . $matches[$i][1] . ',';
                }
                else
                {
                    $sql .= 'ADD ' . $matches[$i][1] . ',';
                }
            }
            $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
            $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//过滤末尾的逗号
            $result[0] = $this->insertCharset($result[0]);//加入字符集设置
            $result[1] = preg_replace($pattern, '', $query);//过滤ADD COLUMN操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
        
        return $result;
    }
    
    /**
     * 解析出DROP INDEX操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以DROP INDEX操作和其它操作组成的数组
     */
    public function parseDropIndexQuery($query)
    {
        $result = array('', $query);
        
        /* 子模式存储键名 */
        $pattern = '/\s*DROP\s+(?:PRIMARY\s+KEY|INDEX\s*`?(\w+)`?)\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                /* 如果子模式为空，删除主键 */
                if (empty($matches[$i][1]))
                {
                    $sql .= 'DROP PRIMARY KEY,';
                }
                /* 否则删除索引 */
                elseif (in_array($matches[$i][1], $this->indexes))
                {
                    $sql .= 'DROP INDEX ' . $matches[$i][1] . ',';
                }
            }
            if ($sql)
            {
                $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
                $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//存储DROP INDEX操作，已过滤末尾的逗号
            }
            $result[1] = preg_replace($pattern, '', $query);//存储其它操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
        
        return $result;
    }
    
    /**
     * 解析出ADD INDEX操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以ADD INDEX操作和其它操作组成的数组
     */
    public function parseAddIndexQuery($query)
    {
        $result = array('', $query);
        
        /* 第1个子模式存储索引定义，第2个子模式存储"PRIMARY KEY"，第3个子模式存储键名，第4个子模式存储列名 */
        $pattern = '/\s*ADD\s+((?:INDEX|UNIQUE|(PRIMARY\s+KEY))\s*(?:`?(\w+)`?)?\s*\(\s*`?(\w+)`?\s*(?:,[^,)]+)*\))\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                $index = !empty($matches[$i][3]) ? $matches[$i][3] : $matches[$i][4];
                if (!empty($matches[$i][2]) && in_array('PRIMARY', $this->indexes))
                {
                    $sql .= 'DROP PRIMARY KEY,';
                }
                elseif (in_array($index, $this->indexes))
                {
                    $sql .= 'DROP INDEX ' . $index . ',';
                }
                $sql .= 'ADD ' . $matches[$i][1] . ',';
            }
            $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
            $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//存储ADD INDEX操作，已过滤末尾的逗号
            $result[1] = preg_replace($pattern, '', $query);//存储其它的操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
        
        return $result;
    }
    
    /**
     * 判断是否还有其它的查询
     *
     * @param   string      $sql     SQL查询串
     * @return  boolean     有返回true，否则返回false
     */
    private function hasOtherQuery($sql)
    {
        return preg_match('/^\s*ALTER\s+TABLE\s*`\w+`\s*\w+/i', $sql);
    }
    
    /**
     * 在查询串中加入字符集设置
     *
     * @param  string      $sql     SQL查询串
     * @return  string     含有字符集设置的SQL查询串
     */
    private function insertCharset($sql)
    {
        $sql = preg_replace('/(TEXT|CHAR\(.*?\)|VARCHAR\(.*?\))\s+/i',
                '\1 CHARACTER SET ' . $this->dbCharset . ' ',
                $sql);
    
        return $sql;
    }
}

//end