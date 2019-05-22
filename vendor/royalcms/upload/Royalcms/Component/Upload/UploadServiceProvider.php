<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-15
 * Time: 09:14
 */

namespace Royalcms\Component\Upload;

use Royalcms\Component\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->guessPackagePath('royalcms/upload') . '/config/upload.php', 'upload');

        $this->registerManager();
    }

    /**
     * Register the filesystem manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->royalcms->bindShared('upload', function($royalcms)
        {
            return new UploadManager($royalcms);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['upload'];
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/upload');

        return [
            $dir . "/Uploader/Uploader.php",
            $dir . "/Uploader/NewUploader.php",
            $dir . "/Process/UploadProcess.php",
            $dir . "/Process/NewUploadProcess.php",
            $dir . "/Uploader/CustomUploader.php",
            $dir . "/Uploader/ImageUploader.php",
            $dir . "/Uploader/NewImageUploader.php",
            $dir . "/Uploader/TempImageUploader.php",
            $dir . "/UploaderAbstract.php",
            $dir . "/UploadProcessAbstract.php",
            $dir . "/UploadResult.php",
            $dir . "/UploadManager.php",
            $dir . "/Facades/Upload.php",
            $dir . "/UploadServiceProvider.php",
        ];
    }

}