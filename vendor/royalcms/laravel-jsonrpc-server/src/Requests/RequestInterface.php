<?php

namespace Royalcms\Laravel\JsonRpcServer\Requests;

/**
 * @see Request
 */
interface RequestInterface extends BasicRequestInterface
{
    /**
     * Get requested method name.
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Get request parameters.
     *
     * @return array<mixed>|object|null
     */
    public function getParams();

    /**
     * Get request parameter using path in some notation (dot, by default).
     *
     * @param string $path
     * @param mixed  $default
     * @param string $delimiter Dot `.` by default
     *
     * @return array<mixed>|bool|float|int|object|string|null Or mixed (passed in $default)
     */
    public function getParameterByPath(string $path, $default = null, string $delimiter = '.');

    /**
     * Is notification request? If true - response is not required.
     *
     * @return bool
     */
    public function isNotification(): bool;

    /**
     * Get raw request in object interpretation.
     *
     * @return mixed
     */
    public function getRawRequest();
}
