<?php namespace Royalcms\Component\Debugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Royalcms\Component\Foundation\Royalcms;

class FilesCollector extends DataCollector implements Renderable
{
    /** 
     * @var \Royalcms\Component\Foundation\Royalcms 
     */
    protected $royalcms;
    
    protected $basePath;

    /**
     * @param \Royalcms\Component\Foundation\Royalcms $royalcms
     */
    public function __construct(Royalcms $royalcms = null)
    {
        $this->royalcms = $royalcms;
        $this->basePath = $royalcms['path.base'];
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        $files = $this->getIncludedFiles();
        $compiled = $this->getCompiledFiles();

        $included = array();
        $alreadyCompiled = array();
        foreach ($files as $file) {
            // Skip the files from Debugbar, they are only loaded for Debugging and confuse the output.
            // Of course some files are stil always loaded (ServiceProvider, Facade etc)
            if (strpos($file, 'vendor/maximebf/debugbar/src') !== false || strpos(
                    $file,
                    'vendor/royalcms/framework/'
                ) !== false
            ) {
                continue;
            } elseif (!in_array($file, $compiled)) {
                $included[] = array(
                    'message' => "'" . $this->stripBasePath($file) . "',",
                    // Use PHP syntax so we can copy-paste to compile config file.
                    'is_string' => true,
                );
            } else {
                $alreadyCompiled[] = array(
                    'message' => "* '" . $this->stripBasePath($file) . "',",
                    // Mark with *, so know they are compiled anyways.
                    'is_string' => true,
                );
            }
        }

        // First the included files, then those that are going to be compiled.
        $messages = array_merge($included, $alreadyCompiled);

        return array(
            'messages' => $messages,
            'count' => count($included),
        );
    }

    /**
     * Get the files included on load.
     *
     * @return array
     */
    protected function getIncludedFiles()
    {
        return get_included_files();
    }

    /**
     * Get the files that are going to be compiled, so they aren't as important.
     *
     * @return array
     */
    protected function getCompiledFiles()
    {
        if ($this->royalcms && class_exists('Royalcms\Component\Foundation\Console\OptimizeCommand')) {
            $reflector = new \ReflectionClass('Royalcms\Component\Foundation\Console\OptimizeCommand');
            $path = dirname($reflector->getFileName()) . '/Optimize/config.php';

            if (file_exists($path)) {
                $royalcms = $this->royalcms;
                $core = require $path;
                return array_merge($core, $royalcms['config']['compile']);
            }
        }
        return array();
    }

    /**
     * Remove the basePath from the paths, so they are relative to the base
     *
     * @param $path
     * @return string
     */
    protected function stripBasePath($path)
    {
        return ltrim(str_replace($this->basePath, '', $path), '/');
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets()
    {
        $name = $this->getName();
        return array(
            "$name" => array(
                "icon" => "files-o",
                "widget" => "PhpDebugBar.Widgets.MessagesWidget",
                "map" => "$name.messages",
                "default" => "{}"
            ),
            "$name:badge" => array(
                "map" => "$name.count",
                "default" => "null"
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'files';
    }
}
