<?php

namespace Royalcms\Laravel\JsonRpcClient;

class HttpResponse extends \Datto\JsonRpc\Http\HttpResponse
{
    /** @var string */
    private $version;

    /** @var integer */
    private $code;

    /** @var string */
    private $message;

    /** @var array */
    private $headers;

    public static function fromHttpResponseHeader(array $http_response_header)
    {
        $statusLine = array_shift($http_response_header);
        self::readVersionCodeMessage($statusLine, $version, $code, $message);
        self::readHeaders($http_response_header, $headers);

        return new self($version, $code, $message, $headers);
    }

    public function __construct(string $version, int $code, string $message, array $headers)
    {
        $this->version = $version;
        $this->code = $code;
        $this->message = $message;
        $this->headers = $headers;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    private static function readVersionCodeMessage($input, &$version, &$code, &$message)
    {
        if (preg_match("~HTTP/(?<version>[0-9.]+) (?<code>[0-9]+) ?(?<message>.*)~XDs", $input, $match) === 1) {
            $version = $match['version'];
            $code = (integer)$match['code'];
            $message = $match['message'];
        }
    }

    private static function readHeaders(array $http_response_header, &$headers)
    {
        $headers = array();

        foreach ($http_response_header as $header) {
            $temp = explode(':', $header, 2);
            if (isset($temp[1])) {
                list($name, $value) = $temp;
                $headers[$name] = trim($value);
            }
        }

        return $headers;
    }
}
