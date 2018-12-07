<?php

namespace Royalcms\Component\SmartyView;

use Smarty;
use ReflectionClass;
use Royalcms\Component\View\Factory as Factory;
use Royalcms\Component\View\ViewFinderInterface;
use Royalcms\Component\View\Engines\EngineResolver;
use Royalcms\Component\SmartyView\Cache\Storage;
use Royalcms\Component\SmartyView\Exception\MethodNotFoundException;
use Royalcms\Component\Contracts\Config\Repository as ConfigContract;
use Royalcms\Component\Events\Dispatcher as DispatcherContract;

/**
 * Class SmartyManager
 *
 */
class SmartyFactory extends Factory
{
    /**
     * @var string  version
     */
    const VERSION = '3.1.18';

    /** @var Smarty $smarty */
    protected $smarty;

    /** @var ConfigContract $config */
    protected $config;

    /** @var array valid config keys */
    protected $configKeys = array(
        'auto_literal',
        'error_unassigned',
        'use_include_path',
        'joined_template_dir',
        'joined_config_dir',
        'default_template_handler_func',
        'default_config_handler_func',
        'default_plugin_handler_func',
        'force_compile',
        'compile_check',
        'use_sub_dirs',
        'allow_ambiguous_resources',
        'merge_compiled_includes',
        'inheritance_merge_compiled_includes',
        'force_cache',
        'left_delimiter',
        'right_delimiter',
        'security_class',
        'php_handling',
        'allow_php_templates',
        'direct_access_security',
        'debugging',
        'debugging_ctrl',
        'smarty_debug_id',
        'debug_tpl',
//      'error_reporting', added below with default value
        'get_used_tags',
        'config_overwrite',
        'config_booleanize',
        'config_read_hidden',
        'compile_locking',
        'cache_locking',
        'locking_timeout',
        'default_resource_type',
        'caching_type',
        'properties',
        'default_config_type',
        'source_objects',
        'template_objects',
        'resource_caching',
        'template_resource_caching',
        'cache_modified_check',
        'registered_plugins',
        'plugin_search_order',
        'registered_objects',
        'registered_classes',
        'registered_filters',
        'registered_resources',
        '_resource_handlers',
        'registered_cache_resources',
        '_cacheresource_handlers',
        'autoload_filters',
        'default_modifiers',
        'escape_html',
        'start_time',
        '_file_perms',
        '_dir_perms',
        '_tag_stack',
        '_current_file',
        '_parserdebug',
        '_is_file_cache',
        'cache_id',
        'compile_id',
        'caching',
        'cache_lifetime',
        'template_class',
        'tpl_vars',
        'parent',
        'config_vars'
    );

    /** @var array valid security policy config keys */
    protected $securityPolicyConfigKeys = array(
        'php_handling',
        'secure_dir',
        'trusted_dir',
        'trusted_uri',
        'trusted_constants',
        'static_classes',
        'trusted_static_methods',
        'trusted_static_properties',
        'php_functions',
        'php_modifiers',
        'allowed_tags',
        'disabled_tags',
        'allowed_modifiers',
        'disabled_modifiers',
        'disabled_special_smarty_vars',
        'streams',
        'allow_constants',
        'allow_super_globals',
        'max_template_nesting',
    );

    /**
     * @param EngineResolver      $engines
     * @param ViewFinderInterface $finder
     * @param DispatcherContract  $events
     * @param Smarty              $smarty
     * @param ConfigContract      $config
     */
    public function __construct(EngineResolver $engines, ViewFinderInterface $finder, DispatcherContract $events, Smarty $smarty, ConfigContract $config)
    {
        parent::__construct($engines, $finder, $events);
        $this->smarty = $smarty;
        $this->config = $config;
    }

    /**
     * @return \Smarty
     */
    public function getSmarty()
    {
        return $this->smarty;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return void
     */
    public function resolveSmartyCache()
    {
        $cacheStorage = new Storage($this->getSmarty(), $this->config);
        $cacheStorage->cacheStorageManaged();
    }

    /**
     * smarty configure
     *
     * @throws \SmartyException
     * @return void
     */
    public function setSmartyConfigure()
    {
        $config = $this->config->get('smarty-view::smarty');

        $smarty = $this->smarty;

        $smarty->setTemplateDir(array_get($config, 'template_path'));
        $smarty->setCompileDir(array_get($config, 'compile_path'));
        $smarty->setCacheDir(array_get($config, 'cache_path'));
        $smarty->setConfigDir(array_get($config, 'config_paths'));

        foreach (array_get($config, 'plugins_paths', array()) as $plugins) {
            $smarty->addPluginsDir($plugins);
        }

        $smarty->error_reporting = array_get($config, 'error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

        foreach ($config as $key => $value) {
            if (in_array($key, $this->configKeys)) {
                $this->smarty->{$key} = $value;
            }
        }

        if (array_get($config, 'enable_security')) {
            $smarty->enableSecurity();

            $securityPolicy = $smarty->security_policy;
            $securityConfig = array_get($config, 'security_policy', array());
            foreach ($securityConfig as $key => $value) {
                if (in_array($key, $this->securityPolicyConfigKeys)) {
                    $securityPolicy->{$key} = $value;
                }
            }
        }
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws MethodNotFoundException
     */
    public function __call($name, $arguments)
    {
        $reflectionClass = new ReflectionClass($this->smarty);
        if (!$reflectionClass->hasMethod($name)) {
            throw new MethodNotFoundException("{$name} : Method Not Found");
        }
        return call_user_func_array(array($this->smarty, $name), $arguments);
    }
}
