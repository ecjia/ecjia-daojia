<?php

namespace Royalcms\Component\Swoole;

use Royalcms\Component\Swoole\Swoole;
use Royalcms\Component\Swoole\DynamicResponse;
use Royalcms\Component\Swoole\Request;
use Royalcms\Component\Swoole\Server;
use Royalcms\Component\Swoole\StaticResponse;
use Royalcms\Component\Swoole\Traits\CustomProcessTrait;
use Royalcms\Component\Swoole\Traits\InotifyTrait;
use Royalcms\Component\Swoole\Traits\RoyalcmsTrait;
use Royalcms\Component\Swoole\Traits\LogTrait;
use Royalcms\Component\Swoole\Traits\ProcessTitleTrait;
use Royalcms\Component\Swoole\Traits\TimerTrait;
use Royalcms\Component\HttpKernel\Request as RoyalcmsRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Swoole\Http\Response as SwooleResponse;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Server as HttpServer;


/**
 * Swoole Request => Royalcms Request
 * Royalcms Request => Royalcms handle => Royalcms Response
 * Royalcms Response => Swoole Response
 */
class RoyalcmsSwoole extends Server
{
    /**
     * Fix conflicts of traits
     */
    use InotifyTrait, RoyalcmsTrait, LogTrait, ProcessTitleTrait, TimerTrait, CustomProcessTrait {
        LogTrait::log insteadof InotifyTrait, TimerTrait;
        LogTrait::logException insteadof InotifyTrait, TimerTrait;
        ProcessTitleTrait::setProcessTitle insteadof InotifyTrait, TimerTrait, CustomProcessTrait;
        RoyalcmsTrait::initRoyalcms insteadof TimerTrait, CustomProcessTrait;
    }

    protected $royalcmsConf;

    /**
     * @var \Royalcms\Component\Swoole\Royalcms $royalcms
     */
    protected $royalcms;

    public function __construct(array $svrConf, array $royalcmsConf)
    {
        parent::__construct($svrConf);
        $this->royalcmsConf = $royalcmsConf;

        $timerCfg = isset($this->conf['timer']) ? $this->conf['timer'] : [];
        $timerCfg['process_prefix'] = $svrConf['process_prefix'];
        $this->swoole->timerProcess = $this->addTimerProcess($this->swoole, $timerCfg, $this->royalcmsConf);
        
        $inotifyCfg = isset($this->conf['inotify_reload']) ? $this->conf['inotify_reload'] : [];
        $inotifyCfg['root_path'] = $this->royalcmsConf['root_path'];
        $inotifyCfg['process_prefix'] = $svrConf['process_prefix'];
        $this->swoole->inotifyProcess = $this->addInotifyProcess($this->swoole, $inotifyCfg);
        
        $processes = isset($this->conf['processes']) ? $this->conf['processes'] : [];
        $this->swoole->customProcesses = $this->addCustomProcesses($this->swoole, $svrConf['process_prefix'], $processes, $this->royalcmsConf);
    }

    protected function bindWebSocketEvent()
    {
        if ($this->enableWebSocket) {
            $eventHandler = function ($method, array $params) {
                try {
                    call_user_func_array([$this->getWebSocketHandler(), $method], $params);
                } catch (\Exception $e) {
                    $this->logException($e);
                }
            };

            $this->swoole->on('Open', function (\swoole_websocket_server $server, \swoole_http_request $request) use ($eventHandler) {
                // Start Royalcms's lifetime, then support session ...middleware.
                $this->royalcms->resetSession();
                $royalcmsRequest = $this->convertRequest($request);
                $this->royalcms->bindRequest($royalcmsRequest);
                $this->royalcms->handleDynamic($royalcmsRequest);
                $eventHandler('onOpen', func_get_args());
                $this->royalcms->saveSession();
            });

            $this->swoole->on('Message', function () use ($eventHandler) {
                $eventHandler('onMessage', func_get_args());
            });

            $this->swoole->on('Close', function (\swoole_websocket_server $server, $fd, $reactorId) use ($eventHandler) {
                $clientInfo = $server->getClientInfo($fd);
                if (isset($clientInfo['websocket_status']) && $clientInfo['websocket_status'] === \WEBSOCKET_STATUS_FRAME) {
                    $eventHandler('onClose', func_get_args());
                }
                // else ignore the close event for http server
            });
        }
    }

    public function onWorkerStart(HttpServer $server, $workerId)
    {
        parent::onWorkerStart($server, $workerId);

        // To implement gracefully reload
        // Delay to create Royalcms
        // Delay to include Royalcms's autoload.php
        $this->royalcms = $this->initRoyalcms($this->royalcmsConf, $this->swoole);
    }

    protected function convertRequest(SwooleRequest $request)
    {
        $rawGlobals = $this->royalcms->getRawGlobals();
        $server = isset($rawGlobals['_SERVER']) ? $rawGlobals['_SERVER'] : [];
        $env = isset($rawGlobals['_ENV']) ? $rawGlobals['_ENV'] : [];
        return with(new Request($request))->toRoyalcmsRequest($server, $env);
    }

    public function onRequest(SwooleRequest $request, SwooleResponse $response)
    {
        try {
            $royalcmsRequest = $this->convertRequest($request);
            $this->royalcms->bindRequest($royalcmsRequest);
            $this->royalcms->fireEvent('swoole.received_request', [$royalcmsRequest]);
            $success = $this->handleStaticResource($royalcmsRequest, $response);
            if ($success === false) {
                $this->handleDynamicResource($royalcmsRequest, $response);
            }
        } catch (\Exception $e) {
            $this->handleException($e, $response);
        } catch (\Throwable $e) {
            $this->handleException($e, $response);
        }
    }

    /**
     * @param \Exception|\Throwable $e
     * @param \swoole_http_response $response
     */
    protected function handleException($e, SwooleResponse $response)
    {
        $error = sprintf('onRequest: Uncaught exception "%s"([%d]%s) at %s:%s, %s%s', get_class($e), $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), PHP_EOL, $e->getTraceAsString());
        $this->log($error, 'ERROR');
        try {
            $response->status(500);
            $response->end('Oops! An unexpected error occurred: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Catch: zm_deactivate_swoole: Fatal error: Uncaught exception 'ErrorException' with message 'swoole_http_response::status(): http client#2 is not exist.
        }
    }

    protected function handleStaticResource(RoyalcmsRequest $royalcmsRequest, SwooleResponse $swooleResponse)
    {
        // For Swoole < 1.9.17
        if (!empty($this->conf['handle_static'])) {
            $royalcmsResponse = $this->royalcms->handleStatic($royalcmsRequest);
            if ($royalcmsResponse !== false) {
                $royalcmsResponse->headers->set('Server', $this->conf['server'], true);
                $this->royalcms->fireEvent('swoole.generated_response', [$royalcmsRequest, $royalcmsResponse]);
                with(new StaticResponse($swooleResponse, $royalcmsResponse))->send($this->conf['enable_gzip']);
                return true;
            }
        }
        return false;
    }

    protected function handleDynamicResource(RoyalcmsRequest $royalcmsRequest, SwooleResponse $swooleResponse)
    {
        $royalcmsResponse = $this->royalcms->handleDynamic($royalcmsRequest);
        $royalcmsResponse->headers->set('Server', $this->conf['server'], true);
        $this->royalcms->fireEvent('swoole.generated_response', [$royalcmsRequest, $royalcmsResponse]);
        $this->royalcms->cleanRequest($royalcmsRequest);
        if ($royalcmsResponse instanceof BinaryFileResponse) {
            with(new StaticResponse($swooleResponse, $royalcmsResponse))->send($this->conf['enable_gzip']);
        } else {
            with(new DynamicResponse($swooleResponse, $royalcmsResponse))->send($this->conf['enable_gzip']);
        }
        return true;
    }
}
