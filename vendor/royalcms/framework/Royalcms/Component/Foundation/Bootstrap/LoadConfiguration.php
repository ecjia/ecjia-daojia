<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Config\Repository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\Contracts\Config\Repository as RepositoryContract;

use Royalcms\Component\Config\FileLoader;
use Royalcms\Component\Filesystem\Filesystem;

class LoadConfiguration
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        $items = [];

        // First we will see if we have a cache configuration file. If we do, we'll load
        // the configuration items from that file so that it is very quick. Otherwise
        // we will need to spin through every configuration file and load them all.
        if (file_exists($cached = $royalcms->getCachedConfigPath())) {
            $items = require $cached;

            $loadedFromCache = true;
        }

        $config = new Repository(
            $this->getConfigLoader($royalcms), $royalcms['env'], $items
        );

        $royalcms->instance('config', $config);

        // Next we will spin through all of the configuration files in the configuration
        // directory and load each one into the repository. This will make all of the
        // options available to the developer for use in various parts of this app.
        if (! isset($loadedFromCache)) {
            //@todo
            //$this->loadConfigurationFiles($royalcms, $config);
        }

        date_default_timezone_set($config['system.timezone']);

        mb_internal_encoding('UTF-8');
    }

    /**
     * Get the configuration loader instance.
     *
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return \Royalcms\Component\Config\LoaderInterface
     */
    protected function getConfigLoader(Royalcms $royalcms)
    {
        return new FileLoader(new Filesystem, $royalcms['path'].'/content/configs', $royalcms['path.base'].'/content/configs');
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Contracts\Config\Repository  $repository
     * @return void
     */
    protected function loadConfigurationFiles(Royalcms $royalcms, RepositoryContract $repository)
    {
        foreach ($this->getConfigurationFiles($royalcms) as $key => $path) {
            $repository->set($key, require $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return array
     */
    protected function getConfigurationFiles(Royalcms $royalcms)
    {
        $files = [];

        $configPath = realpath($royalcms->configPath());

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $nesting = $this->getConfigurationNesting($file, $configPath);

            $files[$nesting.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    protected function getConfigurationNesting(SplFileInfo $file, $configPath)
    {
        $directory = dirname($file->getRealPath());

        if ($tree = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree).'.';
        }

        return $tree;
    }
}
