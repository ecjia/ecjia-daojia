<?php


namespace Royalcms\Component\Swoole\Swoole;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Swoole\Http\Response as SwooleResponse;

abstract class Response implements ResponseInterface
{
    protected $swooleResponse;

    protected $royalcmsResponse;

    public function __construct(SwooleResponse $swooleResponse, SymfonyResponse $royalcmsResponse)
    {
        $this->swooleResponse = $swooleResponse;
        $this->royalcmsResponse = $royalcmsResponse;
    }

    public function sendStatusCode()
    {
        $this->swooleResponse->status($this->royalcmsResponse->getStatusCode());
    }

    public function sendHeaders()
    {
        $headers = method_exists($this->royalcmsResponse->headers, 'allPreserveCaseWithoutCookies') ?
            $this->royalcmsResponse->headers->allPreserveCaseWithoutCookies() : $this->royalcmsResponse->headers->allPreserveCase();
        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                $this->swooleResponse->header($name, $value);
            }
        }
    }

    public function sendCookies()
    {
        $hasIsRaw = null;
        /**@var \Symfony\Component\HttpFoundation\Cookie[] $cookies */
        $cookies = $this->royalcmsResponse->headers->getCookies();
        foreach ($cookies as $cookie) {
            if ($hasIsRaw === null) {
                $hasIsRaw = method_exists($cookie, 'isRaw');
            }
            $setCookie = $hasIsRaw && $cookie->isRaw() ? 'rawcookie' : 'cookie';
            $this->swooleResponse->$setCookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpiresTime(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->isSecure(),
                $cookie->isHttpOnly()
            );
        }
    }

    public function send($gzip = false)
    {
        $this->sendStatusCode();
        $this->sendHeaders();
        $this->sendCookies();
        if ($gzip) {
            $this->gzip();
        }
        $this->sendContent();
    }
}
