<?php

namespace Royalcms\Component\Swoole\Foundation;

use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Http\Request as RoyalcmsRequest;
use Royalcms\Component\Contracts\Http\Kernel as HttpKernel;
use Royalcms\Component\Contracts\Console\Kernel as ConsoleKernel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Royalcms
{
    protected $royalcms;

    /**
     * @var HttpKernel $royalcmsKernel
     */
    protected $royalcmsKernel;

    protected static $snapshotKeys = ['config', 'cookie', 'auth', /*'auth.password'*/];

    /**
     * @var array $snapshots
     */
    protected $snapshots = [];

    protected $conf = [];

    protected static $staticBlackList = [
        '/index.php'  => 1,
        '/info.php'   => 1,
        '/.htaccess'  => 1,
        '/web.config' => 1,
    ];

    private $rawGlobals = [];

    public function __construct(array $conf = [])
    {
        $this->conf = $conf;
    }

    public function prepareRoyalcms()
    {
        $this->autoload();
        $this->createRoyalcms();
        $this->createKernel();
        $this->setRoyalcms();
        $this->consoleKernelBootstrap();
        $this->saveSnapshots();
    }

    protected function autoload()
    {
        $autoload = $this->conf['root_path'] . '/content/bootstrap/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
        } else {
            require_once $this->conf['root_path'] . '/vendor/autoload.php';
        }
    }

    protected function createRoyalcms()
    {
        $this->royalcms = require $this->conf['root_path'] . '/content/bootstrap/royalcms.php';
    }

    protected function createKernel()
    {
         $this->royalcmsKernel = $this->royalcms->make(HttpKernel::class);
    }

    protected function setRoyalcms()
    {
        $server = isset($this->conf['_SERVER']) ? $this->conf['_SERVER'] : [];
        $env = isset($this->conf['_ENV']) ? $this->conf['_ENV'] : [];

        $server['DOCUMENT_ROOT'] = $this->conf['root_path'];

        $this->rawGlobals['_SERVER'] = array_merge($_SERVER, $server);
        $this->rawGlobals['_ENV'] = array_merge($_ENV, $env);
    }

    protected function consoleKernelBootstrap()
    {
        $this->royalcms->make(ConsoleKernel::class)->bootstrap();
    }

    protected function saveSnapshots()
    {
        $this->snapshots = [];
        foreach (self::$snapshotKeys as $key) {
            if (isset($this->royalcms[$key])) {
                if (is_object($this->royalcms[$key])) {
                    $this->snapshots[$key] = clone $this->royalcms[$key];
                } else {
                    $this->snapshots[$key] = $this->royalcms[$key];
                }
            }
        }
    }

    protected function applySnapshots()
    {
        foreach ($this->snapshots as $key => $value) {
            if (is_object($value)) {
                $this->royalcms[$key] = clone $value;
            } else {
                $this->royalcms[$key] = $value;
            }
            Facade::clearResolvedInstance($key);
        }
    }

    public function getRawGlobals()
    {
        return $this->rawGlobals;
    }

    public function handleDynamic(RoyalcmsRequest $request)
    {
        $this->applySnapshots();

        ob_start();
        
        $response = $this->royalcmsKernel->handle($request);
        $content = $response->getContent();
        $this->royalcmsKernel->terminate($request, $response);
            
        // prefer content in response, secondly ob
        if (strlen($content) === 0 && ob_get_length() > 0) {
            $response->setContent(ob_get_contents());
        }

        ob_end_clean();

        return $response;
    }

    public function handleStatic(RoyalcmsRequest $request)
    {
        $uri = $request->getRequestUri();
        if (isset(self::$staticBlackList[$uri])) {
            return false;
        }

        $publicPath = $this->conf['static_path'];
        $requestFile = $publicPath . $uri;
        if (is_file($requestFile)) {
            return $this->createStaticResponse($requestFile, $request);
        } elseif (is_dir($requestFile)) {
            $indexFile = $this->lookupIndex($requestFile);
            if ($indexFile === false) {
                return false;
            } else {
                return $this->createStaticResponse($indexFile, $request);
            }
        } else {
            return false;
        }
    }

    protected function lookupIndex($folder)
    {
        $folder = rtrim($folder, '/') . '/';
        foreach (['index.html', 'index.htm'] as $index) {
            $tmpFile = $folder . $index;
            if (is_file($tmpFile)) {
                return $tmpFile;
            }
        }
        return false;
    }

    public function createStaticResponse($requestFile, RoyalcmsRequest $request)
    {
        $response = new BinaryFileResponse($requestFile);
        $response->prepare($request);
        $response->isNotModified($request);
        return $response;
    }

    public function reRegisterServiceProvider($providerCls, array $clearFacades = [], $force = false)
    {
        if (class_exists($providerCls, false) || $force) {
            foreach ($clearFacades as $facade) {
                Facade::clearResolvedInstance($facade);
            }
            $this->royalcms->register($providerCls, [], true);
        }
    }

    public function cleanRequest(RoyalcmsRequest $request)
    {
        // Clean royalcms session
        if ($request->hasSession()) {
            $session = $request->getSession();
            if (method_exists($session, 'clear')) {
                $session->clear();
            } elseif (method_exists($session, 'flush')) {
                $session->flush();
            }
            // TODO: clear session for other versions
        }

        // Re-register auth
        //$this->reRegisterServiceProvider('\Royalcms\Component\Auth\AuthServiceProvider', ['auth', 'auth.driver']);
        //$this->reRegisterServiceProvider('\Royalcms\Component\Auth\Passwords\PasswordResetServiceProvider', ['auth.password']);

        // Re-register passport
        //$this->reRegisterServiceProvider('\Royalcms\Component\Passport\PassportServiceProvider');

        // Re-register some singleton providers
        foreach ($this->conf['register_providers'] as $provider) {
            $this->reRegisterServiceProvider($provider);
        }

        // Clear request
        $this->royalcms->forgetInstance('request');
        Facade::clearResolvedInstance('request');

        //...
    }

    public function fireEvent($name, array $params = [])
    {
        $params[] = $this->royalcms;
        return $this->royalcms->events->fire($name, $params);
    }

    public function bindRequest(RoyalcmsRequest $request)
    {
        $this->royalcms->instance('request', $request);
    }

    public function bindSwoole($swoole)
    {
        $this->royalcms->singleton('swoole', function ($royalcms) use ($swoole) {
            return $swoole;
        });
    }

    public function make($abstract, array $parameters = [])
    {
        return $this->royalcms->make($abstract, $parameters);
    }

    public function resetSession()
    {
        if (!empty($this->royalcms['session'])) {
            $reflection = new \ReflectionObject($this->royalcms['session']);
            $drivers = $reflection->getProperty('drivers');
            $drivers->setAccessible(true);
            $drivers->setValue($this->royalcms['session'], []);
        }
    }

    public function saveSession()
    {
        if (!empty($this->royalcms['session'])) {
            $this->royalcms['session']->save();
        }
    }

    public function __clone()
    {
        $this->royalcms = clone $this->royalcms;

        $this->royalcmsKernel = clone $this->royalcmsKernel;
    }
}
