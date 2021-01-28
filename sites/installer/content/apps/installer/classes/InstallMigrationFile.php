<?php


namespace Ecjia\App\Installer;


use Ecjia\Component\Database\Migrate;
use ecjia_error;
use Royalcms\Component\Database\QueryException;

class InstallMigrationFile
{

    protected $migrate;

    /**
     * InstallMigrationFile constructor.
     */
    public function __construct()
    {
        $this->migrate = new Migrate();
    }


    /**
     * 安装数据库结构
     *
     * @param int $limit
     * @return  boolean | array | ecjia_error   成功返回true，失败返回ecjia_error
     */
    public function installStructure($limit = 20)
    {
        try {
            return $this->migrate->fire($limit);
        }
        catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 获取将要安装的脚本数量
     */
    public function getWillMigrationFilesCount()
    {
        try {
            return $this->migrate->getWillMigrationFilesCount();
        }
        catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 获取全部安装的脚本数量
     */
    public function getMigrationFilesCount()
    {
        try {
            return $this->migrate->getMigrationFilesCount();
        }
        catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

}