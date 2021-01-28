<?php


namespace Ecjia\App\Installer;

use Ecjia\Component\Database\Migrate;
use PDO;
use PDOException;
use ecjia_error;
use Royalcms\Component\Database\MySqlConnection as Connection;
use Royalcms\Component\Database\QueryException;

class InstallDatabase
{
    /**
     * 主机
     * @var string
     */
    protected $host;

    /**
     * 端口号
     * @var string
     */
    protected $port;

    /**
     * 用户名
     * @var string
     */
    protected $user;

    /**
     * 密码
     * @var string
     */
    protected $pass;

    /**
     * InstallDatabase constructor.
     * @param $host
     * @param $port
     * @param $user
     * @param $pass
     */
    public function __construct($host, $port, $user, $pass)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * 获得数据库列表
     *
     * @return  mixed       成功返回数据库列表组成的数组，失败返回false
     */
    public function getDataBases()
    {
        $conn = $this->createDatabaseConnection();
        if (is_ecjia_error($conn)) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }

        $r = $conn->select("SHOW DATABASES");
        return collect($r)->pluck('Database');
    }


    /**
     * 创建指定名字的数据库
     *
     * @param   string      $database    数据库名
     * @return  boolean | \ecjia_error    成功返回true，失败返回false
     */
    public function createDatabase($database)
    {
        try {
            $conn = $this->createDatabaseConnection();
            if (is_ecjia_error($conn)) {
                return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
            }

            return $conn->unprepared("CREATE DATABASE `$database`");
        }
        catch (QueryException $e) {
            return new ecjia_error('cannt_create_database', __('连接数据库失败，无法创建数据库', 'installer'));
        }
    }

    /**
     * 创建数据库连接
     * @param null $database
     * @return  Connection | \ecjia_error      成功返回数据库连接对象，失败返回false
     */
    public function createDatabaseConnection($database = null)
    {
        try {

            $dsn = "mysql:host={$this->host};port={$this->port}";
            if ($database) {
                $dsn .= ";dbname=$database";
            }
            $db = new PDO($dsn, $this->user, $this->pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $connection = new Connection($db);
            $connection->setFetchMode(config('database.fetch'));
            return $connection;
        }
        catch (PDOException $e) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }
    }

    /**
     * 获取mysql版本
     */
    public function getMysqlVersion()
    {
        $conn = $this->createDatabaseConnection();
        if (is_ecjia_error($conn)) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }

        $r = $conn->select("select version() as version;");
        $version = collect($r)->pluck('version')->first();
        $ver = strstr($version, '-', true);
        if ( $ver ) {
            return $ver;
        } else {
            return $version;
        }
    }

    /**
     * @param Connection $connection
     * @return false|mixed|string
     */
    public static function getMysqlVersionByConnection(Connection $connection)
    {
        $r = $connection->select("select version() as version;");
        $version = collect(collect($r)->pluck('version'))->first();
        $ver = strstr($version, '-', true);
        if ( $ver ) {
            return $ver;
        } else {
            return $version;
        }
    }

    /**
     * 检测mysql数据引擎
     */
    public function checkMysqlSupport()
    {
        $conn = $this->createDatabaseConnection();
        if (is_ecjia_error($conn)) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }

        $r = $conn->select("SHOW variables like 'have_%';");
        return collect($r);
    }

    /**
     * 创建安装连接
     * @return ecjia_error|Connection
     */
    public static function createInstallConnection()
    {
        $db_host = env('DB_HOST');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');
        $db_name = env('DB_DATABASE');
        $db_port = env('DB_PORT', 3306);
        $prefix = env('DB_PREFIX');

        $instance = new static($db_host, $db_port, $db_user, $db_pass);
        $conn = $instance->createDatabaseConnection($db_name);
        if (is_ecjia_error($conn)) {
            return $conn;
        }

        $conn->setTablePrefix($prefix);

        return $conn;
    }

}