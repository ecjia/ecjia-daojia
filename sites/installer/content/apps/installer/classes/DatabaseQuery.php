<?php


namespace Ecjia\App\Installer;


use RC_Package;
use sql_query;

class DatabaseQuery
{

    const DB_CHARSET = 'utf8mb4';

    /**
     * 安装数据
     *
     * @access  public
     * @param   array         $sql_files        SQL文件路径组成的数组
     * @return  boolean|\ecjia_error       成功返回true，失败返回false
     */
    public static function installData($sql_files)
    {
        RC_Package::package('app::installer')->loadClass('sql_query', false);

        $prefix = env('DB_PREFIX');

        $conn = DatabaseConnection::createInstallConnection();
        if (is_ecjia_error($conn)) {
            return $conn;
        }
        $sql_query = new sql_query($conn, self::DB_CHARSET, 'ecjia_', $prefix);

        $result = $sql_query->runAll($sql_files);
        if ($result === false) {
            return $sql_query->getError();
        }
        return true;
    }



}