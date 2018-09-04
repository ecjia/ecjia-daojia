<?php

namespace Royalcms\Component\Image;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Http\Response as HttpResponse;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/image');
        
        // try to create imagecache route only if imagecache is present
        if (class_exists('Royalcms\Component\\Image\\ImageCache')) {
        
            $royalcms = $this->royalcms;
        
            // load imagecache config
            $royalcms['config']->package('royalcms/imagecache', __DIR__.'/../../../../imagecache/config', 'imagecache');
            $config = $royalcms['config'];
        
            // create dynamic manipulation route
            if (is_string($config->get('imagecache::route'))) {
        
                // add original to route templates
                $config->set('imagecache::templates.original', null);
        
                // setup image manipulator route
                $royalcms['router']->get($config->get('imagecache::route').'/{template}/{filename}', array('as' => 'imagecache', function ($template, $filename) use ($royalcms, $config) {
        
                    // disable session cookies for image route
                    $royalcms['config']->set('session.driver', 'array');
        
                    // find file
                    foreach ($config->get('imagecache::paths') as $path) {
                        // don't allow '..' in filenames
                        $image_path = $path.'/'.str_replace('..', '', $filename);
                        if (file_exists($image_path) && is_file($image_path)) {
                            break;
                        } else {
                            $image_path = false;
                        }
                    }
        
                    // abort if file not found
                    if ($image_path === false) {
                        $royalcms->abort(404);
                    }
        
                    // define template callback
                    $callback = $config->get("imagecache::templates.{$template}");
        
                    if (is_callable($callback) || class_exists($callback)) {
        
                        // image manipulation based on callback
                        $content = $royalcms['image']->cache(function ($image) use ($image_path, $callback) {
        
                            switch (true) {
                            	case is_callable($callback):
                            	    return $callback($image->make($image_path));
                            	    break;
        
                            	case class_exists($callback):
                            	    return $image->make($image_path)->filter(new $callback);
                            	    break;
                            }
        
                        }, $config->get('imagecache::lifetime'));
        
                    } else {
        
                        // get original image file contents
                        $content = file_get_contents($image_path);
                    }
        
                    // define mime type
                    $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $content);
        
                    // return http response
                    return new HttpResponse($content, 200, array(
                        'Content-Type' => $mime,
                        'Cache-Control' => 'max-age='.($config->get('imagecache::lifetime')*60).', public',
                        'Etag' => md5($content)
                    ));
        
                }))->where(array('template' => join('|', array_keys($config->get('imagecache::templates'))), 'filename' => '[ \w\\.\\/\\-]+'));
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $royalcms = $this->royalcms;
        
        $royalcms['image'] = $royalcms->share(function ($royalcms) {
            return new ImageManager($royalcms['config']->get('image::config'));
        });
        
        $royalcms->alias('image', 'Royalcms\Component\Image\ImageManager');
        
        // Load the alias
        $this->loadAlias();
    }
    
    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('RC_Image', 'Royalcms\Component\Image\Facades\Image');
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('image');
    }
}
