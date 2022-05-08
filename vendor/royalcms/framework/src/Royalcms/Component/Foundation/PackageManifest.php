<?php

namespace Royalcms\Component\Foundation;

use Exception;
use Royalcms\Component\Filesystem\Filesystem;

class PackageManifest extends \Illuminate\Foundation\PackageManifest
{

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
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath.'/composer/installed.json')) {
            $installed = json_decode($this->files->get($path), true);
            if (isset($installed['packages'])) {
                $packages = $installed['packages'];
            }
            else {
                $packages = $installed;
            }
        }

        $ignoreAll = in_array('*', $ignore = $this->packagesToIgnore());

        $royalcms_packages = $this->findRoyalcmsPackages($packages);
        $laravel_packages = $this->findLaravelPackages($packages);

        $packages = array_merge($royalcms_packages, $laravel_packages);

        $this->write(collect($packages)->each(function ($configuration) use (&$ignore) {
            $ignore = array_merge($ignore, $configuration['dont-discover'] ?? []);
        })->reject(function ($configuration, $package) use ($ignore, $ignoreAll) {
            return $ignoreAll || in_array($package, $ignore);
        })->filter()->all());
    }

    /**
     * @param $packages
     * @return array
     */
    protected function findRoyalcmsPackages($packages)
    {
        $royalcms_packages = collect($packages)->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['royalcms'] ?? []];
        })->filter()->all();

        return $royalcms_packages;
    }

    /**
     * @param $packages
     * @return array
     */
    protected function findLaravelPackages($packages)
    {
        $laravel_packages = collect($packages)->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['laravel'] ?? []];
        })->filter()->all();

        return $laravel_packages;
    }

    /**
     * Format the given package name.
     *
     * @param  string  $package
     * @return string
     */
    protected function format($package)
    {
        return str_replace($this->vendorPath.'/', '', $package);
    }

    /**
     * Get all of the package names that should be ignored.
     *
     * @return array
     */
    protected function packagesToIgnore()
    {
        if (! file_exists($this->basePath.'/composer.json')) {
            return [];
        }

        return json_decode(file_get_contents(
            $this->basePath.'/composer.json'
        ), true)['extra']['royalcms']['dont-discover'] ?? [];
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
