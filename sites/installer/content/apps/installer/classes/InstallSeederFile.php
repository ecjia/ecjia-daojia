<?php


namespace Ecjia\App\Installer;


use Ecjia\Component\Database\Seeder;
use ecjia_error;
use Royalcms\Component\Database\QueryException;

class InstallSeederFile
{

    /**
     * 填充数据表基础数据
     *
     * @return  boolean | ecjia_error    成功返回true，失败返回ecjia_error
     */
    public static function installBaseData()
    {
        try {
            $seeder = new Seeder('InitDatabaseSeeder');

            $seeder->fire();

            return true;
        }
        catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
        catch (\TypeError $e) {
            return new ecjia_error('type_error_exception', $e->getMessage());
        }
        catch (\Error $e) {
            return new ecjia_error('error_exception', $e->getMessage());
        }
        catch (\Exception $e) {
            return new ecjia_error('exception', $e->getMessage());
        }
    }

    /**
     * 填充数据表演示数据
     *
     * @return  boolean | ecjia_error   成功返回true，失败返回ecjia_error
     */
    public static function installDemoData()
    {
        try {
            $seeder = new Seeder('DemoDatabaseSeeder');

            $seeder->fire();

            return true;
        }
        catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
        catch (\TypeError $e) {
            return new ecjia_error('type_error_exception', $e->getMessage());
        }
        catch (\Error $e) {
            return new ecjia_error('error_exception', $e->getMessage());
        }
        catch (\Exception $e) {
            return new ecjia_error('exception', $e->getMessage());
        }
    }

}