<?php

namespace Royalcms\Component\App;

class AppPath
{
    
    /**
     * Gets the basename of a plugin.
     *
     * This method extracts the name of a application from its filename.
     *
     * @since 1.5.0
     *
     * @access private
     *
     * @param string $file The filename of application.
     * @return string The name of a application.
     * @uses RC_PLUGIN_PATH
     */
    private function basename($file)
    {
        
    }
    
    
    /**
     * Gets the filesystem directory path (with trailing slash) for the application __FILE__ passed in
     *
     * @since 3.0.0
     *
     * @param string $file The filename of the application (__FILE__)
     * @return string the filesystem path of the directory that contains the application
     */
    public function dirPath($file)
    {
        
    }
    
    
    /**
     * Gets the URL directory path (with trailing slash) for the application __FILE__ passed in
     *
     * @since 3.0.0
     *
     * @param string $file The filename of the plugin (__FILE__)
     * @return string the URL path of the directory that contains the application
     */
    public function dirUrl($file)
    {
        
    }
    
    
    
}