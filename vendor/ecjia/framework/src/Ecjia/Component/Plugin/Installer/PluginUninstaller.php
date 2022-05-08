<?php


namespace Ecjia\Component\Plugin\Installer;


use Ecjia\Component\Plugin\Contracts\PluginStorageInterface;

class PluginUninstaller
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var PluginStorageInterface
     */
    protected $storage;


    public function __construct($code, $storage = null)
    {
        $this->code = $code;
        $this->storage = $storage;
    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        $code = $this->code;

        if (!empty($this->storage)) {
            $plugin_file = "$code/$code.php";
            $this->storage->removePlugin($plugin_file);
        }

        $this->uninstallByCode($code);

        return true;
    }

    public function uninstallByCode($code)
    {
        //...
    }

}