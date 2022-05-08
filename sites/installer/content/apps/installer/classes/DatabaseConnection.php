<?php


namespace Ecjia\App\Installer;


use ecjia_error;
use Illuminate\Database\Connection;
use PDO;
use PDOException;
use Royalcms\Component\Database\QueryException;

class DatabaseConnection
{

    /**
     * 创建数据库连接
     *
     * @access  public
     * @param string $host 主机
     * @param string $port 端口号
     * @param string $user 用户名
     * @param string $pass 密码
     * @param null $database
     * @return ecjia_error|Connection      成功返回数据库连接对象，失败返回false
     */
    public static function createDatabaseConnection($host, $port, $user, $pass, $database = null)
    {
        try {

            $dsn = "mysql:host=$host;port=$port";
            if ($database) {
                $dsn .= ";dbname=$database";
            }
            $db = new \PDO($dsn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $connection = new Connection($db);
            $connection->setFetchMode(config('database.fetch'));
            return $connection;
        } catch (PDOException $e) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }
    }

    /**
     * 获得数据库列表
     *
     * @access  public
     * @param   string      $host        主机
     * @param   string      $port        端口号
     * @param   string      $user        用户名
     * @param   string      $pass        密码
     * @return  mixed       成功返回数据库列表组成的数组，失败返回false
     */
    public static function getDataBases($host, $port, $user, $pass)
    {
        $conn = self::createDatabaseConnection($host, $port, $user, $pass);
        if (is_ecjia_error($conn)) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。','installer'));
        }
        $r = $conn->select("SHOW DATABASES");
        return collect($r)->lists('Database');
    }

    /**
     * 创建指定名字的数据库
     *
     * @access  public
     * @param   string      $host        主机
     * @param   string      $port        端口号
     * @param   string      $user        用户名
     * @param   string      $pass        密码
     * @param   string      $database    数据库名
     * @return  boolean | ecjia_error    成功返回true，失败返回false
     */
    public static function createDatabase($host, $port, $user, $pass, $database)
    {
        try {

            $conn = self::createDatabaseConnection($host, $port, $user, $pass);
            if (is_ecjia_error($conn)) {
                return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
            }
            $result = $conn->unprepared("CREATE DATABASE `$database`");
            return true;

        } catch (QueryException $e) {
            return new ecjia_error('cannt_create_database', __('连接数据库失败，无法创建数据库', 'installer'));
        }

    }

    public static function createInstallConnection()
    {
        $db_host = env('DB_HOST');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');
        $db_name = env('DB_DATABASE');
        $db_port = env('DB_PORT', 3306);
        $prefix = env('DB_PREFIX');

        $conn = self::createDatabaseConnection($db_host, $db_port, $db_user, $db_pass, $db_name);
        if (is_ecjia_error($conn)) {
            return $conn;
        }

        $conn->setTablePrefix($prefix);

        return $conn;
    }

    /**
     * 检测mysql数据引擎
     */
    public static function checkMysqlSupport($host, $port, $user, $pass)
    {
        $conn = self::createDatabaseConnection($host, $port, $user, $pass);
        if (is_ecjia_error($conn)) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }
        $r = $conn->select("SHOW variables like 'have_%';");
        return collect($r);
    }

    /**
     * 获取mysql版本
     */
    public static function getMysqlVersion($host, $port, $user, $pass)
    {
        $conn = self::createDatabaseConnection($host, $port, $user, $pass);
        if (is_ecjia_error($conn)) {
            return new ecjia_error('connect_failed', __('连接数据库失败，请检查您输入的数据库帐号是否正确。', 'installer'));
        }
        $r = $conn->select("select version() as version;");
        $version = collect(collect($r)->pluck('version'))->first();
        $ver = strstr($version, '-', true);
        if ( $ver ) {
            return $ver;
        } else {
            return $version;
        }
    }

    /**
     * @param Connection|mixed $connection
     * @return mixed|string
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

}