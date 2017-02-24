<?php namespace Royalcms\Component\Package\Struct;

class Application {
    
    protected $identifier;
    
    protected $directory;
    
    protected $name;
    
    protected $description;
    
    protected $author;
    
    protected $website;
    
    protected $version;
    
    protected $copyright;
    
    
    public function __construct(array $package) {
        $this->identifier   = $package['identifier'];
        $this->directory    = $package['directory'];
        $this->name         = $package['name'];
        $this->description  = $package['description'];
        $this->author       = $package['author'];
        $this->website      = $package['website'];
        $this->version      = $package['version'];
        $this->copyright    = $package['copyright'];
    }
    
    /**
     * 应用标识
     */
    public function getIdentifier() {
        return $this->identifier;
    }
    
    /**
     * 应用目录
     */
    public function getDirectory() {
        return $this->directory;
    }
    
    /**
     * 应用名称
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * 描述对应的语言项
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * 作者
     */
    public function getAuthor() {
        return $this->author;
    }
    
    /**
     * 网址
     */
    public function getWebsite() {
        return $this->website;
    }
    
    /**
     * 版本号
     */
    public function getVersion() {
        return $this->version;
    }
    
    /**
     * 版权信息
     */
    public function getCopyright() {
        return $this->copyright;
    }
    
}
