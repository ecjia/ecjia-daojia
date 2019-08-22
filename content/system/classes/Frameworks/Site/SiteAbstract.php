<?php


namespace Ecjia\System\Frameworks\Site;


class SiteAbstract
{
    /**
     * @var string 站点名称
     */
    protected $name;

    /**
     * @var string 站点代号
     */
    protected $code;

    /**
     * 商店类型，单商户 B2C，多商户 B2B2C，到家 cityo2o
     * @var string
     */
    protected $shopType;

    /**
     * 子站点的目录名，原RC_SITE常量
     * @var string
     */
    protected $folder;

    /**
     * 自定义当前站点的主应用
     * @var string
     */
    protected $mainApp;

    /**
     * 当前子站点使用独立二级域名
     * @var boolean
     */
    protected $useSubDomain = false;

    /**
     * Web网站所在目录相对路径，原WEB_PATH常量，示例 / or /sites/xxx/
     * @var string
     */
    protected $webPath;


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     * @return $this
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * @return string
     */
    public function getShopType()
    {
        return $this->shopType;
    }

    /**
     * @param string $shopType
     * @return $this
     */
    public function setShopType($shopType)
    {
        $this->shopType = $shopType;
        return $this;
    }

    /**
     * @return string
     */
    public function getMainApp()
    {
        return $this->mainApp;
    }

    /**
     * @param string $mainApp
     * @return $this
     */
    public function setMainApp($mainApp)
    {
        $this->mainApp = $mainApp;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseSubDomain()
    {
        return $this->useSubDomain;
    }

    /**
     * @param bool $useSubDomain
     * @return $this
     */
    public function setUseSubDomain($useSubDomain)
    {
        $this->useSubDomain = $useSubDomain;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * @param string $webPath
     * @return $this
     */
    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;
        return $this;
    }


}