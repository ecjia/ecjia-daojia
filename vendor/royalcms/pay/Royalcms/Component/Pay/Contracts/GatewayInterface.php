<?php

namespace Royalcms\Component\Pay\Contracts;

interface GatewayInterface
{
    /**
     * Pay an order.
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return \Royalcms\Component\Support\Collection|\Symfony\Component\HttpFoundation\Response
     */
    public function pay($endpoint, $payload);
}
