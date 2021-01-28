<?php


namespace Royalcms\Component\App;


use Exception;
use Illuminate\Foundation\Application;
use RC_Hook;
use Royalcms\Component\App\Bundles\AppBundle;
use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Support\Facades\File as RC_File;

class ApplicationLoader
{

    protected $app_roots = [];

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The path to the manifest file.
     *
     * @var string
     */
    protected $manifestPath;

    public function __construct($app_roots = null)
    {
        if (!empty($app_roots)) {
            $this->app_roots = $app_roots;
        }

        if (royalcms()->runningInSite()) {
            $this->manifestPath = $this->getCachedApplicationsPath(royalcms()->currentSite());
        }
        else {
            $this->manifestPath = $this->getCachedApplicationsPath();
        }

        $this->files = new Filesystem();
    }

    public function addAppRoots()
    {

    }

    public function addAppRootPath($dir)
    {
        $this->app_roots[] = $dir;
    }

    /**
     * @return \Illuminate\Support\Collection|\Royalcms\Component\Support\Collection
     */
    public function loadAppsWithRoot()
    {
        $app_roots = collect($this->app_roots)->map(function ($app_root) {

            if (file_exists($app_root)) {
                $apps_dir = RC_File::directories($app_root);

                $apps = collect($apps_dir)->map(function ($path) {
                    $dir = basename($path);
                    $bundle = new AppBundle();
                    $bundle->packageInit($dir);
                    if (! $bundle->getIdentifier()) {
                        return null;
                    }
                    return $bundle;
                })->filter();

                return $apps;
            }

            return null;
        })->filter();

        return $app_roots;
    }

    /**
     * @return \Illuminate\Support\Collection|\Royalcms\Component\Support\Collection
     */
    public function loadApps()
    {
        $manifest = $this->loadManifest();

        if ($this->shouldRecompile($manifest)) {
            $manifest = $this->scanningAppsToCache();
        }

        $manifest = RC_Hook::apply_filters('app_scan_bundles_filter', $manifest);

        return $manifest;
    }

    public function scanningAppsToCache()
    {
        $app_roots = $this->loadAppsWithRoot();
        $manifest = $app_roots->collapse()->sort(array(__CLASS__, '_sort_uname_callback'));

        $this->writeManifest($manifest);

        return $manifest;
    }

    public function loadAppsWithAlias()
    {
        $apps = $this->loadApps();

        $apps = $apps->mapWithKeys(function ($bundle) {
            $data[$bundle->getAlias()] = $bundle;

            if ($bundle->getAlias() != $bundle->getDirectory()) {
                $data[$bundle->getDirectory()] = $bundle;
            }

            return $data;
        });
        
        return $apps;
    }

    public function loadAppsWithIdentifier()
    {
        $apps = $this->loadApps();

        $apps = $apps->mapWithKeys(function ($bundle) {
            $data[$bundle->getIdentifier()] = $bundle;
            return $data;
        });

        return $apps;
    }


    public function toArray($apps)
    {
        $apps = $apps->map(function ($bundle) {
            return $bundle->toArray();
        })->toArray();

        return $apps;
    }

    /**
     * Callback to sort array by a 'Name' key.
     *
     * @since 3.2.0
     * @access private
     */
    public static function _sort_uname_callback($a, $b)
    {
        return strnatcasecmp( $a->getDirectory(), $b->getDirectory() );
    }

    /**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedApplicationsPath($site = null)
    {
        $royalcms = royalcms();

        if ($royalcms->vendorIsWritableForOptimizations()) {
            $path = $royalcms->bootstrapPath() . "/cache/applications.php";
        }
        else {
            $path = $royalcms->storagePath() . "/framework/applications.php";
        }

        return $path;
    }

    /**
     * Determine if the manifest should be compiled.
     *
     * @param  array  $manifest
     * @param  array  $providers
     * @return bool
     */
    public function shouldRecompile($manifest)
    {
        return is_null($manifest);
    }

    /**
     * Clear the cached Laravel bootstrapping files.
     *
     * @return void
     */
    public function clearCompiled()
    {
        $royalcms = royalcms();

        $applicationsPath = $this->manifestPath;

        if ($this->files->exists($applicationsPath)) {
            return $this->files->delete($applicationsPath);
        }

        return null;
    }

    /**
     * Load the service provider manifest file.
     *
     * @return array|null
     */
    public function loadManifest()
    {
        // The service manifest is a file containing a JSON representation of every
        // service provided by the application and whether its provider is using
        // deferred loading or should be eagerly loaded on each request to us.
        if ($this->files->exists($this->manifestPath)) {
            $manifest = $this->files->getRequire($this->manifestPath);

            if ($manifest) {
                return collect($manifest);
            }
        }
    }

    /**
     * Write the service manifest file to disk.
     *
     * @param  array  $manifest
     * @return array
     *
     * @throws \Exception
     */
    public function writeManifest($manifest)
    {
        if (! is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }

        $this->files->replace(
            $this->manifestPath, '<?php return '.var_export($manifest->all(), true).';'
        );

        return $manifest;
    }


}