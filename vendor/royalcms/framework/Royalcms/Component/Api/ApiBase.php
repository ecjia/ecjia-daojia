<?php

namespace Royalcms\Component\Api;

abstract class ApiBase
{
    
    /** @var ApiMain */
    private $mMainModule;
    
    /** @var string */
    private $mModuleName, $mModulePrefix;
    
    
    /**
     * @param ApiMain $mainModule
     * @param string $moduleName Name of this module
     * @param string $modulePrefix Prefix to use for parameter names
     */
    public function __construct( ApiMain $mainModule, $moduleName, $modulePrefix = '' ) {
        $this->mMainModule = $mainModule;
        $this->mModuleName = $moduleName;
        $this->mModulePrefix = $modulePrefix;
    
    }
    
    
    /**
     * Evaluates the parameters, performs the requested query, and sets up
     * the result. Concrete implementations of ApiBase must override this
     * method to provide whatever functionality their module offers.
     * Implementations must not produce any output on their own and are not
     * expected to handle any errors.
     *
     * The execute() method will be invoked directly by ApiMain immediately
     * before the result of the module is output. Aside from the
     * constructor, implementations should assume that no other methods
     * will be called externally on the module before the result is
     * processed.
     *
     * The result data should be stored in the ApiResult object available
     * through getResult().
     */
    abstract public function execute();
    
    
    /**
     * Return links to more detailed help pages about the module.
     * @return string|array
     */
    public function getHelpUrls() {
        return [];
    }
    
    
    /**
     * Returns an array of allowed parameters (parameter name) => (default
     * value) or (parameter name) => (array with PARAM_* constants as keys)
     * Don't call this function directly: use getFinalParams() to allow
     * hooks to modify parameters as needed.
     *
     * Some derived classes may choose to handle an integer $flags parameter
     * in the overriding methods. Callers of this method can pass zero or
     * more OR-ed flags like GET_VALUES_FOR_HELP.
     *
     * @return array
     */
    protected function getAllowedParams( /* $flags = 0 */ ) {
        // int $flags is not declared because it causes "Strict standards"
        // warning. Most derived classes do not implement it.
        return [];
    }
    
    /**
     * Indicates whether this module requires read rights
     * @return bool
     */
    public function isReadMode() {
        return true;
    }
    
    /**
     * Indicates whether this module requires write mode
     *
     * This should return true for modules that may require synchronous database writes.
     * Modules that do not need such writes should also not rely on master database access,
     * since only read queries are needed and each master DB is a single point of failure.
     * Additionally, requests that only need replica DBs can be efficiently routed to any
     * datacenter via the Promise-Non-Write-API-Action header.
     *
     * @return bool
     */
    public function isWriteMode() {
        return false;
    }
    
    
    /**
     * Indicates whether this module is deprecated
     * @return bool
     */
    public function isDeprecated() {
        return false;
    }
    
    /**
     * Indicates whether this module is "internal"
     * Internal API modules are not (yet) intended for 3rd party use and may be unstable.
     * @return bool
     */
    public function isInternal() {
        return false;
    }
    
    
    
    
    /**
     * Get the name of the module being executed by this instance
     * @return string
     */
    public function getModuleName() {
        return $this->mModuleName;
    }
    
    /**
     * Get parameter prefix (usually two letters or an empty string).
     * @return string
     */
    public function getModulePrefix() {
        return $this->mModulePrefix;
    }
    
    /**
     * Get the main module
     * @return ApiMain
     */
    public function getMain() {
        return $this->mMainModule;
    }
    
    
}