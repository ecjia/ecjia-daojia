<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/10
 * Time: 10:03 AM
 */

namespace Royalcms\Component\Pay\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait HasHttpRequest
{

    /**
     * Send a GET request.
     *
     * @param string $endpoint
     * @param array  $query
     * @param array  $headers
     *
     * @return array|string
     */
    protected function get($endpoint, $query = [], $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query'   => $query,
        ]);
    }

    /**
     * Send a POST request.
     *
     * @param string       $endpoint
     * @param string|array $data
     * @param array        $options
     *
     * @return array|string
     */
    protected function post($endpoint, $data, $options = [])
    {
        if (!is_array($data)) {
            $options['body'] = $data;
        } else {
            $options['form_params'] = $data;
        }
        return $this->request('post', $endpoint, $options);
    }

    /**
     * Send request.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $options
     *
     * @return array|string
     */
    protected function request($method, $endpoint, $options = [])
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));
    }

    /**
     * Get base options.
     *
     * @return array
     */
    protected function getBaseOptions()
    {
        $options = [
            'base_uri'         => property_exists($this, 'baseUri') ? $this->baseUri : '',
            'timeout'          => property_exists($this, 'timeout') ? $this->timeout : 5.0,
            'connect_timeout'  => property_exists($this, 'connectTimeout') ? $this->connectTimeout : 5.0,
        ];
        return $options;
    }
    /**
     * Return http client.
     *
     * @param array $options
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    /**
     * Convert response.
     *
     * @param ResponseInterface $response
     *
     * @return array|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();
        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
        }
        return $contents;
    }

}