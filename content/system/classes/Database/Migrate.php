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
namespace Ecjia\System\Database;

use RC_Config;

/**
 * ecjia数据库迁移类
 * @author royalwang
 *
 */
class Migrate 
{
    
    /**
     * The migrator instance.
     *
     * @var \Royalcms\Component\Database\Migrations\Migrator
     */
    protected $migrator;
    
    /**
     * The repository instance.
     *
     * @var \Royalcms\Component\Database\Migrations\MigrationRepositoryInterface
     */
    protected $repository;
    
    
    protected $database;


    protected $path;

    /**
     * The notes for the current operation.
     *
     * @var array
     */
    protected $notes = array();
    
    public function __construct()
    {
        $this->migrator = royalcms('migrator');
        $this->repository = royalcms('migration.repository');
        $this->database = RC_Config::get('database.default');

        $this->path = royalcms('path.database').'/migrations';
    }
    
    
    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire($limit = 20)
    {
        $this->prepareDatabase();

        $this->run($this->path, $limit);
        
        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        return $this->getNotes();
    }
    
    /**
     * Prepare the migration database for running.
     *
     * @return void
     */
    protected function prepareDatabase()
    {
        $this->migrator->setConnection($this->database);
        
        if ( ! $this->migrator->repositoryExists())
        {
            $this->repository->createRepository();
        }    
    }
    
    
    public function createMigrationsTable()
    {
        $this->prepareDatabase();
    }



    /**
     * Run the outstanding migrations at a given path.
     *
     * @param  string  $path
     * @param  bool    $pretend
     * @return void
     */
    public function run($path, $limit = 20)
    {
        $this->notes = array();

        $this->migrator->requireFiles($path, $files = $this->migrator->getMigrationFiles($path));

        // Once we grab all of the migration files for the path, we will compare them
        // against the migrations that have already been run for this package then
        // run each of the outstanding migrations against a database connection.
        $ran = $this->repository->getRan();

        $migrations = array_diff($files, $ran);

        $this->runMigrationList($migrations, $limit);
    }

    /**
     * Run an array of migrations.
     *
     * @param  array  $migrations
     * @param  bool   $pretend
     * @return void
     */
    public function runMigrationList($migrations, $limit = 20)
    {
        // First we will just make sure that there are any migrations to run. If there
        // aren't, we will just make a note of it to the developer so they're aware
        // that all of the migrations have been run against this database system.
        if (count($migrations) == 0)
        {
            $this->note('<info>Nothing to migrate.</info>');

            return;
        }

        $batch = $this->repository->getNextBatchNumber();

        $migrations = array_chunk($migrations, $limit);

        $migrations = array_shift($migrations);

        // Once we have the array of migrations, we will spin through them and run the
        // migrations "up" so the changes are made to the databases. We'll then log
        // that the migration was run so we don't repeat it next time we execute.
        foreach ($migrations as $file)
        {
            $this->runUp($file, $batch);
        }
    }


    /**
     * Run "up" a migration instance.
     *
     * @param  string  $file
     * @param  int     $batch
     * @return void
     */
    protected function runUp($file, $batch)
    {
        // First we will resolve a "real" instance of the migration class from this
        // migration file name. Once we have the instances we can run the actual
        // command such as "up" or "down", or we can just simulate the action.
        $migration = $this->migrator->resolve($file);

        $migration->up();

        // Once we have run a migrations class, we will log that it was run in this
        // repository so that we don't try to run it next time we do a migration
        // in the application. A migration repository keeps the migrate order.
        $this->repository->log($file, $batch);

        $this->note("<info>Migrated:</info> $file");
    }

    /**
     * Get all of the will migration files in a given path.
     *
     * @param  string  $path
     * @return array
     */
    public function getWillMigrationFiles()
    {
        $files = $this->migrator->getMigrationFiles($this->path);

        // Once we grab all of the migration files for the path, we will compare them
        // against the migrations that have already been run for this package then
        // run each of the outstanding migrations against a database connection.
        $ran = $this->repository->getRan();

        $migrations = array_diff($files, $ran);

        return $migrations;
    }


    /**
     * Get count of the will migration files in a given path.
     *
     * @param  string  $path
     * @return array
     */
    public function getWillMigrationFilesCount()
    {
        $migrations = $this->getWillMigrationFiles();

        return count($migrations);
    }


    /**
     * Raise a note event for the migrator.
     *
     * @param  string  $message
     * @return void
     */
    protected function note($message)
    {
        $this->notes[] = $message;
    }

    /**
     * Get the notes for the last operation.
     *
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }

}

// end