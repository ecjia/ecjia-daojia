<?php

namespace Royalcms\Component\Log;

use Royalcms\Component\Filesystem\Filesystem;
use Monolog\Logger as MonologLogger;

class FileStore
{
    /**
     * The Royalcms Filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;
    
    /**
     * The file log directory
     *
     * @var string
     */
    protected $directory;
    
    /**
     * Create a new file cache store instance.
     *
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  string  $directory
     * @return void
     */
    public function __construct(Filesystem $files, $directory)
    {
        $this->files = $files;
        $this->directory = $directory;

        if ( ! $this->files->isDirectory($this->directory)) {
            $this->createCacheDirectory($this->directory);
        }
    }
    
    
    /**
     * Create the file cache directory if necessary.
     *
     * @param  string  $path
     * @return void
     */
    protected function createCacheDirectory($path)
    {
        $bool = $this->files->makeDirectory($path, 0755, true, true);
        if ($bool === false)
        {
            //目录没有读写权限
            $path = str_replace(SITE_ROOT, '/', storage_path());
            rc_die(sprintf(__("目录%s没有读写权限，请设置权限为777。"), $path));
        }
    }

    private $loggers = array();
    
    /**
     * 获取一个实例
     * @param string $type
     * @param number $day
     * @return Object
    */
    public function getLogger($type = 'royalcms', $day = 30)
    {
        if (empty($this->loggers[$type])) {
            $this->loggers[$type] = new Writer(new MonologLogger($type));
            $this->loggers[$type]->useDailyFiles($this->directory . $type . '.log', $day);
        }
    
        $log = $this->loggers[$type];
        return $log;
    }
}