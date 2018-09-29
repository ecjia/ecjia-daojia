<?php

namespace Royalcms\Component\Readme\Services;

use cebe\markdown\GithubMarkdown;
use Royalcms\Component\Filesystem\Filesystem;
use RC_Config;
use RC_File;

class ReadmeService
{
    /**
     * @var Filesystem
     */
    private $files;

    /**
     * Markdown
     * @var
     */
    private $parser;

    /**
     * @array Packages
     */
    private $packages;

    /**
     * ReadmeService constructor.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->parser = new GithubMarkdown();
        $this->packages = $this->getAllPackages();
    }

    public function getPackageList()
    {
        return $this->packages;
    }

    public function getDocs($packageName, $path = null)
    {
        if (! is_null($path)) {
            $fileName = $this->getDocsFile($this->parseUrlParamToPackageName($packageName), $path);
        } else {
            $fileName = $this->getReadmeFile($this->parseUrlParamToPackageName($packageName));
        }

        if(!is_file($fileName)) {
            return 'No Readme File.';
        }
        $markdown = $this->files->get($fileName);
        $html = $this->parser->parse($markdown);
        return $html;
    }

    public function parsePackageNameToUrlParam($name)
    {
        return str_replace('/', '_', $name);
    }

    public function parseUrlParamToPackageName($name)
    {
        return str_replace('_', '/', $name);
    }

    protected function getAllPackages()
    {
        $vendorPath = vendor_path();

        $require = RC_File::directories($vendorPath, 1);

        $packages = [];

        foreach($require as $value) {
            $key = str_replace($vendorPath . '/', '', $value);
            $vendor = strstr($key, '/', true);
            $packages[$vendor][$key] = $this->parsePackageNameToUrlParam($key);
        }

        return $packages;
    }

    protected function getAllComposerPackages()
    {
        $composer = json_decode($this->files->get(base_path().'/composer.json'));

        $require = get_object_vars($composer->require);
        $requireDev = get_object_vars($composer->{'require-dev'});

        $packages = [];

        foreach($require as $key=>$value) {
            if($key!='php') {
                $packages['require'][$key] = $this->parsePackageNameToUrlParam($key);
            }
        }

        foreach($requireDev as $key=>$value) {
            $packages['require-dev'][$key] = $this->parsePackageNameToUrlParam($key);
        }

        return $packages;
    }

    protected function getReadmeFile($packageName)
    {
        $name = $this->getReadmeFileName(vendor_path($packageName));
        return $name;
    }

    protected function getReadmeFileName($path)
    {
        $dir = dir($path);
        while($file = $dir->read()) {
            if(!is_dir($filePath = "$path/$file")) {
                if(stristr($file, RC_Config::get('readme::readme.filename'))) {
                    return $filePath;
                }
            }
        }
    }


    protected function getDocsFile($packageName, $file)
    {
        $path = vendor_path($packageName);
        $name = $this->getDocsFileName("$path/$file");
        return $name;
    }

    protected function getDocsFileName($filePath)
    {
        if (file_exists($filePath)) {
            return $filePath;
        }
    }


    public function processDocsInternatLinks($docs)
    {
        $pattern = array(
            '/href=["|\']docs\//i',  // 替换相对链接
        );
        $replace = array(
            '/href="?path=docs/'.'\1',
        );
        $docs = preg_replace($pattern, $replace, $docs);

        return $docs;
    }

}