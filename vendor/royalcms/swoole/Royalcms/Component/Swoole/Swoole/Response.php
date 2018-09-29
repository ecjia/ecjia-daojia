<?php


namespace Royalcms\Component\Swoole\Swoole;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class Response implements ResponseInterface
{
    protected $swooleResponse;

    protected $royalcmsResponse;

    public function __construct(\swoole_http_response $swooleResponse, SymfonyResponse $royalcmsResponse)
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
        foreach ($this->royalcmsResponse->headers->allPreserveCase() as $name => $values) {
            foreach ($values as $value) {
                $this->swooleResponse->header($name, $value);
            }
        }
    }

    public function sendCookies()
    {
        foreach ($this->royalcmsResponse->headers->getCookies() as $cookie) {
            $this->swooleResponse->cookie(
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
