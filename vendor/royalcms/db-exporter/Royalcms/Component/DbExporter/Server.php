<?php namespace Royalcms\Component\DbExporter;

use Royalcms\Component\Support\Facades\Config;
use Royalcms\Component\Support\Facades\SSH;

class Server
{
    protected $ignoredFiles = array('..', '.', '.gitkeep');

    public static $uploadedFiles;

    /**
     * What the class has to upload (migrations or seeds)
     * @var
     */
    protected $what;

    public function upload($what)
    {
        $localPath = "{$what}Path";

        $dir = scandir($localPath);
        $remotePath = Config::get('db-exporter.remote.' . $what);

        foreach($dir as $file) {
            if (in_array($file, $this->ignoredFiles)) {
                continue;
            }

            // Capture the uploaded files for display later
            self::$uploadedFiles[$what][] = $remotePath . $file;

            // Copy the files
            SSH::into($this->getRemoteName())->put(
                $localPath .'/' . $file,
                $remotePath . $file
            );
        }

        return true;
    }

    private function getRemoteName()
    {
        // For now static from he config file.
        return Config::get('db-exporter.remote.name');
    }
}