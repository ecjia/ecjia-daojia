<?php


namespace Royalcms\Component\App;

use Royalcms\Component\App\Bundles\AppBundle;
use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Contracts\Foundation\Royalcms as RoyalcmsContract;

class ApplicationRepository
{

    /**
     * The royalcms implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The path to the manifest file.
     *
     * @var string
     */
    protected $manifestPath;


    /**
     * Create a new service repository instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(RoyalcmsContract $royalcms, Filesystem $files, $manifestPath)
    {
        $this->royalcms = $royalcms;
        $this->files = $files;
        $this->manifestPath = $manifestPath;
    }


    /**
     * Register the application service providers.
     *
     * @param  array  $providers
     * @return array
     */
    public function load(array $providers)
    {
        $manifest = $this->loadManifest();

        // First we will load the service manifest, which contains information on all
        // service providers registered with the application and which services it
        // provides. This is used to know which services are "deferred" loaders.
        if ($this->shouldRecompile($manifest, $providers)) {
            $manifest = $this->compileManifest($providers);
        }

        return $manifest;
    }

    /**
     * Compile the application manifest file.
     *
     * @param  array  $providers
     * @return array
     */
    protected function compileManifest($providers)
    {
        // The service manifest should contain a list of all of the providers for
        // the application so we can compare it on each request to the service
        // and determine if the manifest should be recompiled or is current.
        $manifest = $this->freshManifest($providers);

        foreach ($providers as $provider) {
            $instance = $this->createAppBundle($provider);

            if (! $instance->getIdentifier()) {
                continue;
            }

            $manifest['bundles'][$instance->getAlias()] = $instance;

            if ($instance->getAlias() != $instance->getDirectory()) {
                $manifest['bundles'][$instance->getDirectory()] = $instance;
            }
        }

        return $this->writeManifest($manifest);
    }

    /**
     * Create a new provider instance.
     *
     * @param  string  $path
     * @return \Royalcms\Component\App\BundleAbstract
     */
    public function createAppBundle($path)
    {
        $dir = basename($path);
        $bundle = new AppBundle($dir);

        return $bundle;
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @param  array  $manifest
     * @param  array  $providers
     * @return bool
     */
    public function shouldRecompile($manifest, $providers)
    {
        return is_null($manifest) || $manifest['providers'] != $providers;
    }

    /**
     * Load the service provider manifest JSON file.
     *
     * @return array|null
     */
    public function loadManifest()
    {
        // The service manifest is a file containing a JSON representation of every
        // service provided by the application and whether its provider is using
        // deferred loading or should be eagerly loaded on each request to us.
        if ($this->files->exists($this->manifestPath)) {
            $manifest = json_decode($this->files->get($this->manifestPath), true);

            if ($manifest) {
                return $manifest;
            }
        }

        return null;
    }

    /**
     * Write the service manifest file to disk.
     *
     * @param  array  $manifest
     * @return array
     */
    public function writeManifest($manifest)
    {
        $path = dirname($this->manifestPath);
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }

        $this->files->put(
            $this->manifestPath, json_encode($manifest, JSON_PRETTY_PRINT)
        );

        return $manifest;
    }


    /**
     * Create a fresh service manifest data structure.
     *
     * @param  array  $providers
     * @return array
     */
    protected function freshManifest(array $providers)
    {
        return ['providers' => $providers, 'bundles' => [], 'extends' => []];
    }



}