<?php

namespace Royalcms\Component\Sentry;

use Exception;
use Raven_Client;
use Royalcms\Component\Routing\Route;
use Royalcms\Component\Log\Events\MessageLogged;
use Royalcms\Component\Auth\Events\Authenticated;
use Royalcms\Component\Routing\Events\RouteMatched;
use Royalcms\Component\Contracts\Events\Dispatcher;
use Royalcms\Component\Database\Events\QueryExecuted;

class SentryEventHandler
{
    /**
     * Maps event handler function to event names.
     *
     * @var array
     */
    protected static $eventHandlerMap = array(
        'router.matched' => 'routerMatched', // Until Laravel 5.1
        'Royalcms\Component\Routing\Events\RouteMatched' => 'routeMatched',  // Since Laravel 5.2

        'royalcms.query' => 'query',         // Until Laravel 5.1
        'Royalcms\Component\Database\Events\QueryExecuted' => 'queryExecuted', // Since Laravel 5.2

        'royalcms.log' => 'log',           // Until Laravel 5.3
        'Royalcms\Component\Log\Events\MessageLogged' => 'messageLogged', // Since Laravel 5.4
    );

    /**
     * Maps authentication event handler function to event names.
     *
     * @var array
     */
    protected static $authEventHandlerMap = array(
        'Royalcms\Component\Auth\Events\Authenticated' => 'authenticated', // Since Laravel 5.3
    );

    /**
     * Sentry client.
     *
     * @var Raven_Client
     */
    protected $client;

    /**
     * Indicates if we should we add query bindings to the breadcrumbs.
     *
     * @var bool
     */
    private $sqlBindings;

    /**
     * SentryLaravelEventHandler constructor.
     *
     * @param \Raven_Client $client
     * @param array         $config
     */
    public function __construct(Raven_Client $client, array $config)
    {
        $this->client = $client;
        $this->sqlBindings = isset($config['breadcrumbs.sql_bindings']) ? $config['breadcrumbs.sql_bindings'] === true : true;
    }

    /**
     * Attach all event handlers.
     *
     * @param \Royalcms\Component\Contracts\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        foreach (static::$eventHandlerMap as $eventName => $handler) {
            $events->listen($eventName, array($this, $handler));
        }
    }

    /**
     * Attach all authentication event handlers.
     *
     * @param \Royalcms\Component\Contracts\Events\Dispatcher $events
     */
    public function subscribeAuthEvents(Dispatcher $events)
    {
        foreach (static::$authEventHandlerMap as $eventName => $handler) {
            $events->listen($eventName, array($this, $handler));
        }
    }

    /**
     * Pass through the event and capture any errors.
     *
     * @param string $method
     * @param array  $arguments
     */
    public function __call($method, $arguments)
    {
        try {
            call_user_func_array(array($this, $method . 'handler'), $arguments);
        } catch (Exception $exception) {
            // Ignore
        }
    }

    /**
     * Record the event with default values.
     *
     * @param array $payload
     */
    protected function record($payload)
    {
        $this->client->breadcrumbs->record(array_merge(array(
            'data' => null,
            'level' => 'info',
        ), $payload));
    }

    /**
     * Until Royalcms 5.1
     *
     * @param Route $route
     */
    protected function routerMatchedHandler(Route $route)
    {
        if ($route->getName()) {
            // someaction (route name/alias)
            $routeName = $route->getName();
        } elseif ($route->getActionName()) {
            // SomeController@someAction (controller action)
            $routeName = $route->getActionName();
        }
        if (empty($routeName) || $routeName === 'Closure') {
            // /someaction // Fallback to the url
            $routeName = $route->uri();
        }

        $this->client->transaction->push($routeName);
    }

    /**
     * Since Royalcms 5.2
     *
     * @param \Royalcms\Component\Routing\Events\RouteMatched $match
     */
    protected function routeMatchedHandler(RouteMatched $match)
    {
        $this->routerMatchedHandler($match->route);
    }

    /**
     * Until Royalcms 5.1
     *
     * @param $query
     * @param $bindings
     * @param $time
     * @param $connectionName
     */
    protected function queryHandler($query, $bindings, $time, $connectionName)
    {
        $data = array('connectionName' => $connectionName);

        if ($this->sqlBindings) {
            $data['bindings'] = $bindings;
        }

        $this->record(array(
            'message' => $query,
            'category' => 'sql.query',
            'data' => $data,
        ));
    }

    /**
     * Since Royalcms 5.2
     *
     * @param \Royalcms\Component\Database\Events\QueryExecuted $query
     */
    protected function queryExecutedHandler(QueryExecuted $query)
    {
        $data = array('connectionName' => $query->connectionName);

        if ($this->sqlBindings) {
            $data['bindings'] = $query->bindings;
        }

        $this->client->breadcrumbs->record(array(
            'message' => $query->sql,
            'category' => 'sql.query',
            'data' => $data,
        ));
    }

    /**
     * Until Royalcms 5.3
     *
     * @param $level
     * @param $message
     * @param $context
     */
    protected function logHandler($level, $message, $context)
    {
        $this->client->breadcrumbs->record(array(
            'message' => $message,
            'category' => 'log.' . $level,
            'data' => empty($context) ? null : array('params' => $context),
            'level' => $level,
        ));
    }

    /**
     * Since Royalcms 5.4
     *
     * @param \Royalcms\Component\Log\Events\MessageLogged $logEntry
     */
    protected function messageLoggedHandler(MessageLogged $logEntry)
    {
        $this->client->breadcrumbs->record(array(
            'message' => $logEntry->message,
            'category' => 'log.' . $logEntry->level,
            'data' => empty($logEntry->context) ? null : array('params' => $logEntry->context),
            'level' => $logEntry->level,
        ));
    }

    /**
     * Since Royalcms 5.3
     *
     * @param \Royalcms\Component\Auth\Events\Authenticated $event
     */
    protected function authenticatedHandler(Authenticated $event)
    {
        $this->client->user_context(array(
            'id' => $event->user->getAuthIdentifier(),
        ));
    }
}
