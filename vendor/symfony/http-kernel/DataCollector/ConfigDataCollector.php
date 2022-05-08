<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

<<<<<<< HEAD
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ConfigDataCollector.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ConfigDataCollector extends DataCollector
=======
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\VarDumper\Caster\ClassStub;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class ConfigDataCollector extends DataCollector implements LateDataCollectorInterface
>>>>>>> v2-test
{
    /**
     * @var KernelInterface
     */
    private $kernel;
<<<<<<< HEAD
    private $name;
    private $version;
    private $cacheVersionInfo = true;

    /**
     * Constructor.
     *
     * @param string $name    The name of the application using the web profiler
     * @param string $version The version of the application using the web profiler
     */
    public function __construct($name = null, $version = null)
    {
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Sets the Kernel associated with this Request.
     *
     * @param KernelInterface $kernel A KernelInterface instance
=======

    /**
     * Sets the Kernel associated with this Request.
>>>>>>> v2-test
     */
    public function setKernel(KernelInterface $kernel = null)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'app_name' => $this->name,
            'app_version' => $this->version,
            'token' => $response->headers->get('X-Debug-Token'),
            'symfony_version' => Kernel::VERSION,
            'symfony_state' => 'unknown',
            'name' => isset($this->kernel) ? $this->kernel->getName() : 'n/a',
            'env' => isset($this->kernel) ? $this->kernel->getEnvironment() : 'n/a',
            'debug' => isset($this->kernel) ? $this->kernel->isDebug() : 'n/a',
            'php_version' => PHP_VERSION,
            'xdebug_enabled' => extension_loaded('xdebug'),
            'eaccel_enabled' => extension_loaded('eaccelerator') && ini_get('eaccelerator.enable'),
            'apc_enabled' => extension_loaded('apc') && ini_get('apc.enabled'),
            'xcache_enabled' => extension_loaded('xcache') && ini_get('xcache.cacher'),
            'wincache_enabled' => extension_loaded('wincache') && ini_get('wincache.ocenabled'),
            'zend_opcache_enabled' => extension_loaded('Zend OPcache') && ini_get('opcache.enable'),
            'bundles' => array(),
            'sapi_name' => PHP_SAPI,
        );

        if (isset($this->kernel)) {
            foreach ($this->kernel->getBundles() as $name => $bundle) {
                $this->data['bundles'][$name] = $bundle->getPath();
            }

            $this->data['symfony_state'] = $this->determineSymfonyState();
        }
    }

    public function getApplicationName()
    {
        return $this->data['app_name'];
    }

    public function getApplicationVersion()
    {
        return $this->data['app_version'];
=======
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $this->data = [
            'token' => $response->headers->get('X-Debug-Token'),
            'symfony_version' => Kernel::VERSION,
            'symfony_state' => 'unknown',
            'env' => isset($this->kernel) ? $this->kernel->getEnvironment() : 'n/a',
            'debug' => isset($this->kernel) ? $this->kernel->isDebug() : 'n/a',
            'php_version' => \PHP_VERSION,
            'php_architecture' => \PHP_INT_SIZE * 8,
            'php_intl_locale' => class_exists(\Locale::class, false) && \Locale::getDefault() ? \Locale::getDefault() : 'n/a',
            'php_timezone' => date_default_timezone_get(),
            'xdebug_enabled' => \extension_loaded('xdebug'),
            'apcu_enabled' => \extension_loaded('apcu') && filter_var(ini_get('apc.enabled'), \FILTER_VALIDATE_BOOLEAN),
            'zend_opcache_enabled' => \extension_loaded('Zend OPcache') && filter_var(ini_get('opcache.enable'), \FILTER_VALIDATE_BOOLEAN),
            'bundles' => [],
            'sapi_name' => \PHP_SAPI,
        ];

        if (isset($this->kernel)) {
            foreach ($this->kernel->getBundles() as $name => $bundle) {
                $this->data['bundles'][$name] = new ClassStub(\get_class($bundle));
            }

            $this->data['symfony_state'] = $this->determineSymfonyState();
            $this->data['symfony_minor_version'] = sprintf('%s.%s', Kernel::MAJOR_VERSION, Kernel::MINOR_VERSION);
            $this->data['symfony_lts'] = 4 === Kernel::MINOR_VERSION;
            $eom = \DateTime::createFromFormat('d/m/Y', '01/'.Kernel::END_OF_MAINTENANCE);
            $eol = \DateTime::createFromFormat('d/m/Y', '01/'.Kernel::END_OF_LIFE);
            $this->data['symfony_eom'] = $eom->format('F Y');
            $this->data['symfony_eol'] = $eol->format('F Y');
        }

        if (preg_match('~^(\d+(?:\.\d+)*)(.+)?$~', $this->data['php_version'], $matches) && isset($matches[2])) {
            $this->data['php_version'] = $matches[1];
            $this->data['php_version_extra'] = $matches[2];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->data = [];
    }

    public function lateCollect()
    {
        $this->data = $this->cloneVar($this->data);
>>>>>>> v2-test
    }

    /**
     * Gets the token.
     *
<<<<<<< HEAD
     * @return string The token
=======
     * @return string|null The token
>>>>>>> v2-test
     */
    public function getToken()
    {
        return $this->data['token'];
    }

    /**
     * Gets the Symfony version.
     *
     * @return string The Symfony version
     */
    public function getSymfonyVersion()
    {
        return $this->data['symfony_version'];
    }

    /**
     * Returns the state of the current Symfony release.
     *
     * @return string One of: unknown, dev, stable, eom, eol
     */
    public function getSymfonyState()
    {
        return $this->data['symfony_state'];
    }

<<<<<<< HEAD
    public function setCacheVersionInfo($cacheVersionInfo)
    {
        $this->cacheVersionInfo = $cacheVersionInfo;
    }

    /**
     * Gets the PHP version.
     *
     * @return string The PHP version
     */
    public function getPhpVersion()
    {
        return $this->data['php_version'];
    }

    /**
     * Gets the application name.
     *
     * @return string The application name
     */
    public function getAppName()
    {
        return $this->data['name'];
    }

    /**
     * Gets the environment.
     *
     * @return string The environment
     */
    public function getEnv()
    {
        return $this->data['env'];
    }

    /**
     * Returns true if the debug is enabled.
     *
     * @return bool true if debug is enabled, false otherwise
     */
    public function isDebug()
    {
        return $this->data['debug'];
    }

    /**
     * Returns true if the XDebug is enabled.
     *
     * @return bool true if XDebug is enabled, false otherwise
     */
    public function hasXDebug()
    {
        return $this->data['xdebug_enabled'];
    }

    /**
     * Returns true if EAccelerator is enabled.
     *
     * @return bool true if EAccelerator is enabled, false otherwise
     */
    public function hasEAccelerator()
    {
        return $this->data['eaccel_enabled'];
    }

    /**
     * Returns true if APC is enabled.
     *
     * @return bool true if APC is enabled, false otherwise
     */
    public function hasApc()
    {
        return $this->data['apc_enabled'];
    }

    /**
     * Returns true if Zend OPcache is enabled.
     *
     * @return bool true if Zend OPcache is enabled, false otherwise
     */
    public function hasZendOpcache()
    {
        return $this->data['zend_opcache_enabled'];
    }

    /**
     * Returns true if XCache is enabled.
     *
     * @return bool true if XCache is enabled, false otherwise
     */
    public function hasXCache()
    {
        return $this->data['xcache_enabled'];
    }

    /**
     * Returns true if WinCache is enabled.
     *
     * @return bool true if WinCache is enabled, false otherwise
     */
    public function hasWinCache()
    {
        return $this->data['wincache_enabled'];
    }

    /**
     * Returns true if any accelerator is enabled.
     *
     * @return bool true if any accelerator is enabled, false otherwise
     */
    public function hasAccelerator()
    {
        return $this->hasApc() || $this->hasZendOpcache() || $this->hasEAccelerator() || $this->hasXCache() || $this->hasWinCache();
=======
    /**
     * Returns the minor Symfony version used (without patch numbers of extra
     * suffix like "RC", "beta", etc.).
     *
     * @return string
     */
    public function getSymfonyMinorVersion()
    {
        return $this->data['symfony_minor_version'];
    }

    /**
     * Returns if the current Symfony version is a Long-Term Support one.
     */
    public function isSymfonyLts(): bool
    {
        return $this->data['symfony_lts'];
    }

    /**
     * Returns the human redable date when this Symfony version ends its
     * maintenance period.
     *
     * @return string
     */
    public function getSymfonyEom()
    {
        return $this->data['symfony_eom'];
    }

    /**
     * Returns the human redable date when this Symfony version reaches its
     * "end of life" and won't receive bugs or security fixes.
     *
     * @return string
     */
    public function getSymfonyEol()
    {
        return $this->data['symfony_eol'];
    }

    /**
     * Gets the PHP version.
     *
     * @return string The PHP version
     */
    public function getPhpVersion()
    {
        return $this->data['php_version'];
    }

    /**
     * Gets the PHP version extra part.
     *
     * @return string|null The extra part
     */
    public function getPhpVersionExtra()
    {
        return $this->data['php_version_extra'] ?? null;
    }

    /**
     * @return int The PHP architecture as number of bits (e.g. 32 or 64)
     */
    public function getPhpArchitecture()
    {
        return $this->data['php_architecture'];
    }

    /**
     * @return string
     */
    public function getPhpIntlLocale()
    {
        return $this->data['php_intl_locale'];
    }

    /**
     * @return string
     */
    public function getPhpTimezone()
    {
        return $this->data['php_timezone'];
    }

    /**
     * Gets the environment.
     *
     * @return string The environment
     */
    public function getEnv()
    {
        return $this->data['env'];
    }

    /**
     * Returns true if the debug is enabled.
     *
     * @return bool true if debug is enabled, false otherwise
     */
    public function isDebug()
    {
        return $this->data['debug'];
    }

    /**
     * Returns true if the XDebug is enabled.
     *
     * @return bool true if XDebug is enabled, false otherwise
     */
    public function hasXDebug()
    {
        return $this->data['xdebug_enabled'];
    }

    /**
     * Returns true if APCu is enabled.
     *
     * @return bool true if APCu is enabled, false otherwise
     */
    public function hasApcu()
    {
        return $this->data['apcu_enabled'];
    }

    /**
     * Returns true if Zend OPcache is enabled.
     *
     * @return bool true if Zend OPcache is enabled, false otherwise
     */
    public function hasZendOpcache()
    {
        return $this->data['zend_opcache_enabled'];
>>>>>>> v2-test
    }

    public function getBundles()
    {
        return $this->data['bundles'];
    }

    /**
     * Gets the PHP SAPI name.
     *
     * @return string The environment
     */
    public function getSapiName()
    {
        return $this->data['sapi_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'config';
    }

    /**
     * Tries to retrieve information about the current Symfony version.
     *
     * @return string One of: dev, stable, eom, eol
     */
<<<<<<< HEAD
    private function determineSymfonyState()
    {
        $now = new \DateTime();
        $eom = \DateTime::createFromFormat('m/Y', Kernel::END_OF_MAINTENANCE)->modify('last day of this month');
        $eol = \DateTime::createFromFormat('m/Y', Kernel::END_OF_LIFE)->modify('last day of this month');
=======
    private function determineSymfonyState(): string
    {
        $now = new \DateTime();
        $eom = \DateTime::createFromFormat('d/m/Y', '01/'.Kernel::END_OF_MAINTENANCE)->modify('last day of this month');
        $eol = \DateTime::createFromFormat('d/m/Y', '01/'.Kernel::END_OF_LIFE)->modify('last day of this month');
>>>>>>> v2-test

        if ($now > $eol) {
            $versionState = 'eol';
        } elseif ($now > $eom) {
            $versionState = 'eom';
        } elseif ('' !== Kernel::EXTRA_VERSION) {
            $versionState = 'dev';
        } else {
            $versionState = 'stable';
        }

        return $versionState;
    }
}
