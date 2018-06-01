<?php

namespace Royalcms\Component\Remote\Console;

use Royalcms\Component\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class TailCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'remote:tail';
    
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'tail 
        {connection? : The remote connection name} 
        {--path= : The fully qualified path to the log file.} 
        {--lines=20 : The number of lines to tail.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tail a log file on a remote server';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->getPath($this->argument('connection'));

        if ($path) {
            $this->tailLogFile($path, $this->argument('connection'));
        } else {
            $this->error('Could not determine path to log file.');
        }
    }

    /**
     * Tail the given log file for the connection.
     *
     * @param string $path
     * @param string $connection
     *
     * @return void
     */
    protected function tailLogFile($path, $connection)
    {
        if (is_null($connection)) {
            $this->tailLocalLogs($path);
        } else {
            $this->tailRemoteLogs($path, $connection);
        }
    }

    /**
     * Tail a local log file for the application.
     *
     * @param string $path
     *
     * @return string
     */
    protected function tailLocalLogs($path)
    {
        $path = $this->findNewestLocalLogfile($path);

        $output = $this->output;

        $lines = $this->option('lines');

        ( new Process('tail -f -n '.$lines.' '.escapeshellarg($path)) )->setTimeout(null)->run(function ($type, $line) use ($output) {
            $output->write($line);
        });

        return $path;
    }

    /**
     * Tail a remote log file at the given path and connection.
     *
     * @param string $path
     * @param string $connection
     *
     * @return void
     */
    protected function tailRemoteLogs($path, $connection)
    {
        $out = $this->output;

        $lines = $this->option('lines');

        $this->getRemote($connection)->run('cd '.escapeshellarg($path).' && tail -f $(ls -t | head -n 1) -n '.$lines, function ($line) use ($out) {
            $out->write($line);
        });
    }

    /**
     * Get the path to the latest local Laravel log file.
     *
     * @param $path
     *
     * @return mixed
     */
    protected function findNewestLocalLogfile($path)
    {
        $files = glob($path.'/*.log');

        $files = array_combine($files, array_map('filemtime', $files));

        arsort($files);

        $newestLogFile = key($files);

        return $newestLogFile;
    }

    /**
     * Get a connection to the remote server.
     *
     * @param string $connection
     *
     * @return \Royalcms\Component\Remote\Connection
     */
    protected function getRemote($connection)
    {
        return $this->royalcms['remote']->connection($connection);
    }

    /**
     * Get the path to the Laravel log file.
     *
     * @param string $connection
     *
     * @return string
     */
    protected function getPath($connection)
    {
        if ($this->option('path')) {
            return $this->option('path');
        }

        if (is_null($connection) && $this->option('path')) {
            return storage_path($this->option('path'));
        } elseif (is_null($connection) && !$this->option('path')) {
            return storage_path('logs');
        }

        return $this->getRoot($connection).str_replace(base_path(), '', storage_path('logs'));
    }

    /**
     * Get the path to the Laravel install root.
     *
     * @param string $connection
     *
     * @return string
     */
    protected function getRoot($connection)
    {
        return $this->royalcms['config']['remote::remote.connections.'.$connection.'.root'];
    }
}
