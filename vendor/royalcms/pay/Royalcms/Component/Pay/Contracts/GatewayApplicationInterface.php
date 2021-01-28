<?php

namespace Royalcms\Component\Pay\Contracts;

interface GatewayApplicationInterface
{
    /**
     * To pay.
     *
     * @param string $gateway
     * @param PayloadInterface  $params
     *
     * @return \Royalcms\Component\Support\Collection|\Symfony\Component\HttpFoundation\Response
     */
    public function pay($gateway, PayloadInterface $params);

    /**
     * Query an order.
     *
     * @param string|array $order
     * @param bool         $refund
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function find($order, $refund);

    /**
     * Refund an order.
     *
     * @param array $order
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function refund($order);

    /**
     * Cancel an order.
     *
     * @param string|array $order
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     *
     * @param string|array $order
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function close($order);

    /**
     * Verify a request.
     *
     * @param string|null $content
     * @param bool        $refund
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function verify($content, $refund);

    /**
     * Echo success to server.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function success();
}
