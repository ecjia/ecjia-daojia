<?php

namespace Royalcms\Component\App;

use Exception;
use Royalcms\Component\Filesystem\Filesystem;

class AppPackageManifest
{
    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    public $files;

    /**
     * The base path.
     *
     * @var string
     */
    public $basePath;

    /**
     * The AppManager instance.
     *
     * @var \Royalcms\Component\App\AppManager
     */
    public $appManager;

    /**
     * The manifest path.
     *
     * @var string|null
     */
    public $manifestPath;

    /**
     * The loaded manifest array.
     *
     * @var array
     */
    public $manifest;

    /**
     * Create a new package manifest instance.
     *
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  string  $basePath
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(Filesystem $files, $basePath, $manifestPath)
    {
        $this->files = $files;
        $this->basePath = $basePath;
        $this->manifestPath = $manifestPath;
    }

    /**
     * Get all of the service provider class names for all packages.
     *
     * @return array
     */
    public function providers()
    {
        return collect($this->getManifest())->flatMap(function ($configuration) {
            return (array) ($configuration['providers'] ?? []);
        })->filter()->all();
    }

    /**
     * Get all of the aliases for all packages.
     *
     * @return array
     */
    public function aliases()
    {
        return collect($this->getManifest())->flatMap(function ($configuration) {
            return (array) ($configuration['aliases'] ?? []);
        })->filter()->all();
    }

    /**
     * Get all of the autoload prs4 for all packages.
     *
     * @return  array
     */
    public function autoload_psr4()
    {
        return collect($this->getManifest())->flatMap(function ($configuration) {
            return (array) ($configuration['autoload_psr4'] ?? []);
        })->filter()->all();
    }

    /**
     * Get the current package manifest.
     *
     * @return array
     */
    protected function getManifest()
    {
        if (! is_null($this->manifest)) {
            return $this->manifest;
        }

        if (! file_exists($this->manifestPath)) {
            $this->build();
        }

        $this->files->get($this->manifestPath);

        return $this->manifest = file_exists($this->manifestPath) ?
            $this->files->getRequire($this->manifestPath) : [];
    }

    /**
     * Build the manifest and write it to disk.
     *
     * @return void
     */
    public function build()
    {
        $appManager = royalcms('app');

        $packages = $appManager->getApplicationLoader()->loadApps();

        $bundles = $appManager->getBundles();

        $bundles = array_keys($bundles);

        $packages = collect($packages)->mapWithKeys(function ($bundle) use ($bundles) {
            if (! in_array($bundle->getAlias(), $bundles)) {
                return null;
            }

            $package = $bundle->getPackage();

            $discover = $package['discover'] ?? [];

            if (isset($package['autoload']['psr-4'])) {
                $discover['autoload_psr4'] = $this->normalizePsr4NamespacePath($bundle, $package['autoload']['psr-4']);
            }

            return [$this->format($package['identifier']) => $discover];
        })->filter()->all();

        $this->write($packages);
    }

    /**
     * Normalize a relative or absolute path to a cache file.
     *
     * @param  array  $psr4
     * @return string
     */
    protected function normalizePsr4NamespacePath($bundle, $psr4)
    {
        return collect($psr4)->map(function ($item) use ($bundle) {
            $path = $bundle->getAbsolutePath() . $item;
            $path = str_replace($this->basePath, '', $path);

            return $path;
        })->all();
    }

    /**
     * Format the given package name.
     *
     * @param  string  $package
     * @return string
     */
    protected function format($package)
    {
        return $package;
    }

    /**
     * Write the given manifest array to disk.
     *
     * @param  array  $manifest
     * @return void
     *
     * @throws \Exception
     */
    protected function write(array $manifest)
    {
        if (! is_writable(dirname($this->manifestPath))) {
            throw new Exception('The '.dirname($this->manifestPath).' directory must be present and writable.');
        }

        $this->files->replace(
            $this->manifestPath, '<?php return '.var_export($manifest, true).';'
        );
    }
}
