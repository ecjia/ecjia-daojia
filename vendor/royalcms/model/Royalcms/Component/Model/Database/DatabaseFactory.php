<?php namespace Royalcms\Component\Model\Database;

/**
 * database_factory.class.php 数据库工厂类
 */
final class DatabaseFactory
{

    /**
     * 当前数据库工厂类静态实例
     */
    private static $db_factory;

    /**
     * 数据库配置列表
     */
    protected $db_config = array();

    /**
     * 数据库操作实例化列表
     */
    protected $db_list = array();

    /**
     * 构造函数
     */
    public function __construct()
    {}

    /**
     * 析构函数
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * 返回当前终级类对象的实例
     *
     * @param $db_config 数据库配置            
     * @return object
     */
    public static function get_instance($db_config = array())
    {
        if (empty($db_config)) {
            $db_config = \RC_Config::get('database.connections');
        }
        
        if (is_null(self::$db_factory)) {
            self::$db_factory = new self();
        }
        
        if ($db_config != self::$db_factory->db_config) {
            self::$db_factory->db_config = array_merge($db_config, self::$db_factory->db_config);
        }
        
        if (! self::$db_factory) {
            // 连接异常
            if (RC_DEBUG) {
                rc_die("数据库连接出错了请检查配置文件中的参数");
            } else {
                \RC_Logger::getLogger(\RC_Logger::LOG_SQL)->error("数据库连接出错了请检查配置文件中的参数");
            }
            return null;
        } else {
            return self::$db_factory;
        }
    }

    /**
     * 获取数据库操作实例
     *
     * @param $db_name 数据库配置名称            
     */
    public function get_database($db_name, $table_name = null)
    {
        if (empty($table_name)) {
            $table_name = "empty";
            $db_list_name = $db_name;
        } else {
            $db_list_name = $db_name . '_' . $table_name;
        }
        if (! isset($this->db_list[$db_list_name]) || ! is_object($this->db_list[$db_list_name])) {
            $this->db_list[$db_list_name] = $this->connect($db_name, $table_name);
        }
        return $this->db_list[$db_list_name];
    }

    /**
     * 链接数据库
     *
     * @param $db_name 数据库配置名称            
     * @return object
     */
    public function connect($db_name, $table_name)
    {
        $object = $this->get_driver($this->db_config[$db_name]['driver']);
        $object->open($this->db_config[$db_name]);
        if ($table_name == 'empty') {
            $object->connect();
        } else {
            $object->connect($table_name);
        }
        
        return $object;
    }

    /**
     * 获取数据库驱动类型
     *
     * @param unknown $type            
     * @return $object
     */
    private function get_driver($driver)
    {
        if ($driver == 'mysql') {
            $driver = 'mysqli';
        }
        $class_name = '\Royalcms\Component\Model\Database\\' . ucfirst($driver);
        if (class_exists($class_name)) {
            $object = new $class_name();
        } else {
            $object = null;
        }
        
        if (! $object) {
            if (RC_DEBUG) {
                rc_die("数据库连接出错了请检查配置文件中的参数", false);
            } else {
                \RC_Logger::getLogger(\RC_Logger::LOG_SQL)->error("数据库连接出错了请检查配置文件中的参数");
            }
        } else {
            return $object;
        }
    }

    /**
     * 关闭数据库连接
     *
     * @return void
     */
    protected function close()
    {
        foreach ($this->db_list as $db) {
            $db->close();
        }
    }
}


//end